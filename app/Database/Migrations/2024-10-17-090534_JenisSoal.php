<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisSoal extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
                'default' => null,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'default' => null,
                'null' => true,
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ref_jenis_soal');
    }

    public function down()
    {
        $this->forge->dropTable('ref_jenis_soal');
    }
}
