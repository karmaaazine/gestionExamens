<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'IL',
            ],
            [
                'id' => '2',
                'name' => 'IDIA',
            ]
        ];

        // Insert data into the database
        $this->db->table('classes')->insertBatch($data);
    }
}
