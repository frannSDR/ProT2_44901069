<?php

namespace App\Models;

use CodeIgniter\Model;

class EpisodioModel extends Model
{
    protected $table = 'episodios';
    protected $primaryKey = 'episodio_id';

    protected $allowedFields = [
        'nro_temporada',
        'nro_episodio',
        'titulo',
        'sinopsis',
        'duracion',
        'fecha_emision',
        'calidad',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
