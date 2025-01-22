<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentClassModel extends Model
{
    protected $table      = 'student_class'; // Table name
    protected $primaryKey = 'id'; // Composite primary key

    protected $returnType = 'array'; // Return type

    protected $allowedFields = ['class_id', 'student_id', 'year_id']; // Fields that can be inserted/updated

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules (optional)
    protected $validationRules = [
        'class_id' => 'required|numeric',
        'student_id' => 'required|numeric',
        'year_id' => 'required|numeric',
    ];

    protected $validationMessages = [
        'class_id' => [
            'required' => 'The class ID is required.',
        ],
        'student_id' => [
            'required' => 'The student ID is required.',
        ],
        'year_id' => [
            'required' => 'The year ID is required.',
        ],
    ];
}