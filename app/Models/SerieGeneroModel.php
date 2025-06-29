<?php

namespace App\Models;

use CodeIgniter\Model;

class SerieGeneroModel extends Model
{
    protected $table = 'serie_generos';
    protected $primaryKey = ['serie_id', 'genero_id'];

    protected $allowedFields = [
        'serie_id',
        'genero_id'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'serie_id' => 'required|integer',
        'genero_id' => 'required|integer'
    ];
}
