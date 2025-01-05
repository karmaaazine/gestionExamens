<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('comptes');

        // Insert rows into the compte table
        $rolesTable = $this->db->table('roles');
        $usersTable = $this->db->table('users');
        $compteTable = $this->db->table('comptes');

        // Fetch the ids of predefined roles
        $adminRole = $rolesTable->where('role_name', 'admin')->get()->getRow();
        $studentRole = $rolesTable->where('role_name', 'etudiant')->get()->getRow();

        $adminUser = $usersTable->where('email', 'admin@edu.com')->get()->getRow();
        $studentUser = $usersTable->where('email', 'student@edu.com')->get()->getRow();

        // Ensure data exists before inserting
        if ($adminRole && $studentRole && $adminUser && $studentUser) {
            $data = [
                [
                    'user_id'    => $adminUser->id,
                    'role_id'    => $adminRole->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id'    => $studentUser->id,
                    'role_id'    => $studentRole->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ];
            $compteTable->insertBatch($data);
        }
    }

    public function down()
    {
        $this->forge->dropTable('compte');
    }
}
