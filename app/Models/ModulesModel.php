<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table      = 'modules'; // Table name
    protected $primaryKey = 'id'; // Primary key

    protected $returnType = 'array'; // Return type

    protected $allowedFields = ['name']; // Fields that can be inserted/updated

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules (optional)
    protected $validationRules = [
        'name' => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'The module name is required.',
        ],
    ];
}