<?php

namespace App\Models;

use CodeIgniter\Model;

class SerieStreamModel extends Model
{
    protected $table = 'stream_series';
    protected $primaryKey = 'stream_id';
    protected $allowedFields = [
        'episodio_id',
        'idioma',
        'server',
        'calidad',
        'url',
        'activo'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
