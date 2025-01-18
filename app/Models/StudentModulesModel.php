<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModulesModel extends Model
{
    protected $table      = 'student_modules'; // Table name
    protected $primaryKey = 'id'; // Composite primary key

    protected $returnType = 'array'; // Return type

    protected $allowedFields = ['student_id', 'module_id', 'prof_id']; // Fields that can be inserted/updated

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules (optional)
    protected $validationRules = [
        'student_id' => 'required|numeric',
        'module_id' => 'required|numeric',
        'prof_id' => 'required|numeric',
    ];

    protected $validationMessages = [
        'student_id' => [
            'required' => 'The student ID is required.',
        ],
        'module_id' => [
            'required' => 'The module ID is required.',
        ],
        'prof_id' => [
            'required' => 'The professor ID is required.',
        ],
    ];
}