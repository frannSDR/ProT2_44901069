<?php

namespace App\Models;

use CodeIgniter\Model;

class SerieStreamModel extends Model
{
    protected $table = 'stream_series';
    protected $primaryKey = 'stream_id';
    protected $allowedFields = [
        'serie_id',
        'nro_temporada',
        'nro_episodio',
        'idioma',
        'server',
        'calidad',
        'stream_url',
        'activo'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getStreamsBySeason($serieId, $nroTemporada, $activo = 1)
    {
        return $this->where('serie_id', $serieId)
            ->where('nro_temporada', $nroTemporada)
            ->where('activo', $activo)
            ->orderBy('nro_episodio', 'ASC')
            ->findAll();
    }

    public function getStreamsByEpisode($serieId, $nroTemporada, $nroEpisodio, $activo = 1)
    {
        return $this->where('serie_id', $serieId)
            ->where('nro_temporada', $nroTemporada)
            ->where('nro_episodio', $nroEpisodio)
            ->where('activo', $activo)
            ->findAll();
    }
}
