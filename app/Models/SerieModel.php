<?php

namespace App\Models;

use CodeIgniter\Model;

class SerieModel extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'serie_id';

    protected $allowedFields = [
        'titulo',
        'titulo_original',
        'sinopsis',
        'año_inicio',
        'año_fin',
        'temporadas',
        'episodios_total',
        'clasificacion',
        'poster',
        'trailer',
        'valoracion',
        'estado',
        'activa'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
