<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaModel extends Model
{
    protected $table = 'peliculas';
    protected $primaryKey = 'movie_id';

    protected $allowedFields = [
        'titulo',
        'titulo_original',
        'sinopsis',
        'año',
        'duracion',
        'clasificacion',
        'poster',
        'trailer',
        'valoracion',
        'fecha_estreno',
        'magnet_link',
        'torrent_hash',
        'archivo_torrent',
        'calidad',
        'tamaño_mb',
        'activa'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
