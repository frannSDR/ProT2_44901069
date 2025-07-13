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
        'director',
        'reparto',
        'año',
        'duracion',
        'clasificacion',
        'poster',
        'banner',
        'trailer',
        'valoracion',
        'magnet_link',
        'calidad',
        'activa'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
