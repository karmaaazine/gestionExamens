<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UniversityYearSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'year' => '2024/2025',
                

            ]
        ];

        // Insert data into the database
        $this->db->table('university_year')->insertBatch($data);
    }
}
