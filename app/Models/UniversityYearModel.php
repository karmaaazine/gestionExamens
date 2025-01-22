<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'university_year'; // Table name
    protected $primaryKey = 'id'; // Primary key

    protected $returnType = 'array'; // Return type 

    protected $allowedFields = ['year']; 

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules 
    protected $validationRules = [
        'year' => 'required|max_length[255]|is_unique[university_year.year]',
    ];

    protected $validationMessages = [
        'year' => [
            'required' => 'The year field is required.',
            'is_unique' => 'This year already exists.',
        ],
    ];
}
