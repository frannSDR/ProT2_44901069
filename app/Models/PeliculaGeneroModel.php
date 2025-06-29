<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaGeneroModel extends Model
{
    protected $table = 'pelicula_generos';
    protected $primaryKey = ['pelicula_id', 'genero_id'];

    protected $allowedFields = [
        'pelicula_id',
        'genero_id'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'pelicula_id' => 'required|integer',
        'genero_id' => 'required|integer'
    ];
}
