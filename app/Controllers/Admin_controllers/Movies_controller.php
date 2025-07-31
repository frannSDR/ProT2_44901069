<?php

namespace App\Controllers\Admin_controllers;

use App\Controllers\BaseController;
use App\Models\PeliculaGeneroModel;
use App\Models\PeliculaModel;
use App\Models\GeneroModel;
use App\Models\PeliculaStreamModel;

class Movies_controller extends BaseController
{
    protected $movieModel;
    protected $generoModel;
    protected $peliculaGeneroModel;
    protected $peliculaStreamModel;

    public function __construct()
    {
        $this->movieModel = new PeliculaModel();
        $this->generoModel = new GeneroModel();
        $this->peliculaGeneroModel = new PeliculaGeneroModel();
        $this->peliculaStreamModel = new PeliculaStreamModel();
    }

    public function list_movies()
    {

        //** traemos la info de las peliculas */

        $moviesPage = $this->request->getVar('movies_page') ?? 1;
        $moviesPerPage = 15;
        $movieFilter = $this->request->getVar('movie_filter') ?? 'title';
        $movieDirection = $this->request->getVar('movie_direction') ?? 'asc';
        $movieDirection = strtoupper($movieDirection) === 'DESC' ? 'DESC' : 'ASC';

        $moviesOrderBy = match ($movieFilter) {
            'title' => 'titulo',
            'release' => 'año',
            'rating' => 'valoracion',
            default => 'titulo'
        };

        $movies = $this->movieModel
            ->select('movie_id, titulo, año, poster, valoracion, activa')
            ->orderBy($moviesOrderBy, $movieDirection)
            ->paginate($moviesPerPage, 'movies', $moviesPage);

        $moviesTotal = $this->movieModel->countAll();
        $moviesTotalPages = ceil($moviesTotal / $moviesPerPage);

        //** traemos la info del genero de cada pelicula */

        $movieIds = array_column($movies, 'movie_id');
        $generoPorPelicula = [];
        if (!empty($movieIds)) {
            $generos = $this->peliculaGeneroModel
                ->select('pelicula_generos.movie_id, generos.nombre, generos.slug')
                ->join('generos', 'generos.genero_id = pelicula_generos.genero_id')
                ->whereIn('pelicula_generos.movie_id', $movieIds)
                ->findAll();

            foreach ($generos as $genero) {
                $generoPorPelicula[$genero['movie_id']][] = [
                    'nombre' => $genero['nombre'],
                    'slug' => $genero['slug']
                ];
            }
        }

        foreach ($movies as &$movie) {
            $movie['generos'] = $generoPorPelicula[$movie['movie_id']] ?? [];
        }

        $data = [
            'titulo' => 'Peliculas',
            'movies' => $movies,
            'currentMoviesPage' => $moviesPage,
            'totalMoviesPage' => $moviesTotalPages,
            'currentMovieFilter' => $movieFilter,
            'currentDirection' => strtolower($movieDirection),
            'generoActual' => 'todas',
            'pager' => $this->movieModel->pager
        ];

        return view('Views/front/navbar', $data)
            . view('Views/front/peliculas', $data)
            . view('Views/front/footer');
    }

    public function filtro_genero_pelicula($slug = 'todas')
    {
        $moviesPage = $this->request->getVar('movies_page') ?? 1;
        $moviesPerPage = 15;
        $movieFilter = $this->request->getVar('movies_filter') ?? 'title';
        $movieDirection = $this->request->getVar('movies_direction') ?? 'asc';
        $movieDirection = strtoupper($movieDirection) === 'DESC' ? 'DESC' : 'ASC';

        $moviesOrderBy = match ($movieFilter) {
            'title' => 'titulo',
            'release' => 'año',
            'rating' => 'valoracion',
            default => 'titulo'
        };

        // si el slug es 'todas', no filtramos por genero
        if ($slug === 'todas') {
            $movies = $this->movieModel
                ->select('movie_id, titulo, año, poster, valoracion, activa')
                ->orderBy($moviesOrderBy, $movieDirection)
                ->paginate($moviesPerPage, 'movies', $moviesPage);

            $moviesTotal = $this->movieModel->countAll();
        } else {
            // filtrar por genero usando join y el slug
            $movies = $this->movieModel
                ->select('peliculas.movie_id, peliculas.titulo, peliculas.año, peliculas.poster, peliculas.valoracion, peliculas.activa')
                ->join('pelicula_generos', 'peliculas.movie_id = pelicula_generos.movie_id')
                ->join('generos', 'generos.genero_id = pelicula_generos.genero_id')
                ->where('generos.slug', $slug)
                ->orderBy($moviesOrderBy, $movieDirection)
                ->paginate($moviesPerPage, 'movies', $moviesPage);

            // solo contamos las peliculas del genero filtrado
            // Solo contar las películas del género filtrado
            $moviesTotal = $this->movieModel
                ->join('pelicula_generos', 'peliculas.movie_id = pelicula_generos.movie_id')
                ->join('generos', 'generos.genero_id = pelicula_generos.genero_id')
                ->where('generos.slug', $slug)
                ->countAllResults();
        }

        $moviesTotalPages = ceil($moviesTotal / $moviesPerPage);

        // traemos la info del genero de cada pelicula
        $movieIds = array_column($movies, 'movie_id');
        $generoPormovie = [];
        if (!empty($movieIds)) {
            $generos = $this->peliculaGeneroModel
                ->select('pelicula_generos.movie_id, generos.nombre, generos.slug')
                ->join('generos', 'generos.genero_id = pelicula_generos.genero_id')
                ->whereIn('pelicula_generos.movie_id', $movieIds)
                ->findAll();

            foreach ($generos as $genero) {
                $generoPormovie[$genero['movie_id']][] = [
                    'nombre' => $genero['nombre'],
                    'slug' => $genero['slug']
                ];
            }
        }

        foreach ($movies as &$movie) {
            $movie['generos'] = $generoPormovie[$movie['movie_id']] ?? [];
        }

        $data = [
            'titulo' => 'movies',
            'movies' => $movies,
            'currentMoviesPage' => $moviesPage,
            'totalMoviesPage' => $moviesTotalPages,
            'currentMovieFilter' => $movieFilter,
            'currentDirection' => strtolower($movieDirection),
            'generoActual' => $slug,
            'pager' => $this->movieModel->pager
        ];

        return view('Views/front/navbar', $data)
            . view('Views/front/peliculas', $data)
            . view('Views/front/footer');
    }

    public function movie_detail($id = null)
    {
        $movie = $this->movieModel->find($id);

        $generos = $this->peliculaGeneroModel
            ->select('generos.nombre, generos.slug')
            ->join('generos', 'generos.genero_id = pelicula_generos.genero_id')
            ->where('pelicula_generos.movie_id', $id)
            ->findAll();

        $streams = $this->peliculaStreamModel
            ->where('movie_id', $id)
            ->where('activo', 1)
            ->findAll();

        $data = [
            'titulo' => $movie['titulo'],
            'movie' => $movie,
            'generos' => $generos,
            'streams' => $streams
        ];

        return view('Views/front/navbar', $data)
            . view('Views/front/seccion_pelicula', $data)
            . view('Views/front/footer');
    }
}
