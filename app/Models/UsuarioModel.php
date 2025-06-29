<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_img',
        'email',
        'nickname',
        'password_hash',
        'is_active',
        'last_login',
        'is_admin'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
