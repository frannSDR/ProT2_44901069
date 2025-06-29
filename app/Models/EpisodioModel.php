<?php

namespace App\Models;

use CodeIgniter\Model;

class EpisodioModel extends Model
{
    protected $table = 'episodios';
    protected $primaryKey = 'episodio_id';

    protected $allowedFields = [
        'temporada_id',
        'numero_episodio',
        'titulo',
        'sinopsis',
        'duracion',
        'fecha_emision',
        'magnet_link',
        'torrent_hash',
        'archivo_torrent',
        'calidad',
        'tamaño_mb'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
