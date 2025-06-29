<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoModel extends Model
{
    protected $table = 'favoritos';
    protected $primaryKey = 'favorito_id';

    protected $allowedFields = [
        'user_id',
        'tipo',
        'contenido_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_agregado';
    protected $updatedField = null;
}
