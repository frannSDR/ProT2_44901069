<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneroModel extends Model
{
    protected $table = 'generos';
    protected $primaryKey = 'genero_id';

    protected $allowedFields = [
        'nombre',
        'descripcion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
