<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoSerieItemModel extends Model // Cambiar aquí
{
    protected $table = 'favoritos_series_items';
    protected $primaryKey = 'item_id';

    protected $allowedFields = [
        'user_id',
        'serie_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'added_at';
    protected $updatedField = null;
}
