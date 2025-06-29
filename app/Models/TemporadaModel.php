<?php

namespace App\Models;

use CodeIgniter\Model;

class TemporadaModel extends Model
{
    protected $table = 'temporadas';
    protected $primaryKey = 'temporada_id';

    protected $allowedFields = [
        'serie_id',
        'numero_temporada',
        'titulo',
        'episodios',
        'año',
        'sinopsis',
        'poster'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
