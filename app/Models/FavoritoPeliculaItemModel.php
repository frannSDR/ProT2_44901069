<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoPeliculaItemModel extends Model
{
    protected $table = 'favoritos_movies_items';
    protected $primaryKey = 'item_id';

    protected $allowedFields = [
        'user_id',
        'movie_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'added_at';
    protected $updatedField = null;
}
