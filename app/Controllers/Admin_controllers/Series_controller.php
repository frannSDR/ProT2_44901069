<?php

namespace App\Controllers\Admin_controllers;

use App\Controllers\BaseController;
use App\Models\SerieGeneroModel;
use App\Models\SerieModel;
use App\Models\GeneroModel;
use App\Models\TemporadaModel;
use App\Models\EpisodioModel;
use App\Models\SerieStreamModel;

class Series_controller extends BaseController
{
    protected $serieModel;
    protected $generoModel;
    protected $serieGeneroModel;
    protected $temporadaModel;
    protected $episodioModel;
    protected $serieStreamModel;

    public function __construct()
    {
        $this->serieModel = new SerieModel();
        $this->generoModel = new GeneroModel();
        $this->serieGeneroModel = new SerieGeneroModel();
        $this->temporadaModel = new TemporadaModel();
        $this->episodioModel = new EpisodioModel();
        $this->serieStreamModel = new SerieStreamModel();
    }

    public function list_series()
    {

        //** traemos la info de las series */

        $seriesPage = $this->request->getVar('series_page') ?? 1;
        $seriesPerPage = 15;
        $serieFilter = $this->request->getVar('series_filter') ?? 'title';
        $serieDirection = $this->request->getVar('series_direction') ?? 'asc';
        $serieDirection = strtoupper($serieDirection) === 'DESC' ? 'DESC' : 'ASC';

        $seriesOrderBy = match ($serieFilter) {
            'title' => 'titulo',
            'release' => 'año_inicio',
            'rating' => 'valoracion',
            default => 'titulo'
        };

        $series = $this->serieModel
            ->select('serie_id, titulo, año_inicio, año_fin, poster, temporadas, valoracion, estado, activa')
            ->orderBy($seriesOrderBy, $serieDirection)
            ->paginate($seriesPerPage, 'series', $seriesPage);

        $seriesTotal = $this->serieModel->countAll();
        $seriesTotalPages = ceil($seriesTotal / $seriesPerPage);

        //** traemos la info del genero de cada serie */

        $serieIds = array_column($series, 'serie_id');
        $generoPorSerie = [];
        if (!empty($serieIds)) {
            $generos = $this->serieGeneroModel
                ->select('serie_generos.serie_id, generos.nombre, generos.slug')
                ->join('generos', 'generos.genero_id = serie_generos.genero_id')
                ->whereIn('serie_generos.serie_id', $serieIds)
                ->findAll();

            foreach ($generos as $genero) {
                $generoPorSerie[$genero['serie_id']][] = [
                    'nombre' => $genero['nombre'],
                    'slug' => $genero['slug']
                ];
            }
        }

        foreach ($series as &$serie) {
            $serie['generos'] = $generoPorSerie[$serie['serie_id']] ?? [];
        }

        $data = [
            'titulo' => 'Series',
            'series' => $series,
            'currentSeriesPage' => $seriesPage,
            'totalSeriesPage' => $seriesTotalPages,
            'currentSerieFilter' => $serieFilter,
            'currentDirection' => strtolower($serieDirection),
            'generoActual' => 'todas',
            'pager' => $this->serieModel->pager
        ];

        return view('Views/front/navbar', $data)
            . view('Views/front/series', $data)
            . view('Views/front/footer');
    }

    public function serie_detail($id = null)
    {
        $serie = $this->serieModel->find($id);

        $generos = $this->serieGeneroModel
            ->select('generos.nombre, generos.slug')
            ->join('generos', 'generos.genero_id = serie_generos.genero_id')
            ->where('serie_generos.serie_id', $id)
            ->findAll();

        // Obtener temporadas con episodios
        $temporadas = $this->temporadaModel
            ->where('serie_id', $id)
            ->orderBy('numero_temporada', 'ASC')
            ->findAll();

        foreach ($temporadas as &$temporada) {
            $temporada['episodios'] = $this->episodioModel
                ->where('temporada_id', $temporada['temporada_id'])
                ->orderBy('numero_episodio', 'ASC')
                ->findAll();

            // Para cada episodio, obtener sus streams
            foreach ($temporada['episodios'] as &$episodio) {
                $episodio['streams'] = $this->serieStreamModel
                    ->where('episodio_id', $episodio['episodio_id'])
                    ->where('activo', 1)
                    ->findAll();
            }
        }

        $data = [
            'titulo' => $serie['titulo'],
            'serie' => $serie,
            'generos' => $generos,
            'temporadas' => $temporadas,
            'streams' => []
        ];

        return view('Views/front/navbar', $data)
            . view('Views/front/seccion_serie', $data)
            . view('Views/front/footer');
    }
}
