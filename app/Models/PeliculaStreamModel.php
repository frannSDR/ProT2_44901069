<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaStreamModel extends Model
{
    protected $table = 'stream_peliculas';
    protected $primaryKey = 'stream_id';
    protected $allowedFields = [
        'movie_id',
        'idioma',
        'server',
        'calidad',
        'stream_url',
        'activo',
        'created_at'
    ];
}
