<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewHelpfulModel extends Model
{
    protected $table = 'review_helpful';
    protected $primaryKey = 'helpful_id';

    protected $allowedFields = [
        'review_id',
        'user_id',
        'is_helpful'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
