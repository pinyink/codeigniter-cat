<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Soal extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true
            ],
            'ref_jenis_soal' => [
                'type' => 'INT',
            ],
            'soal' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('ref_soal');
    }

    public function down()
    {
        $this->forge->dropTable('ref_soal');
    }
}
