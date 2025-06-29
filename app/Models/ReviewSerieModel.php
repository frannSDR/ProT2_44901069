<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewSerieModel extends Model
{
    protected $table = 'series_reviews';
    protected $primaryKey = 'review_id';

    protected $allowedFields = [
        'serie_id',
        'user_id',
        'review_title',
        'rating',
        'review_text',
        'is_approved'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
