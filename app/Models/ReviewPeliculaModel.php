<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewPeliculaModel extends Model
{
    protected $table = 'movies_reviews';
    protected $primaryKey = 'review_id';

    protected $allowedFields = [
        'movie_id',
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
