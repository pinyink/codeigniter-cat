<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jawaban extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true
            ],
            'ref_soal' => [
                'type' => 'INT',
            ],
            'jawaban' => [
                'type' => 'TEXT',
            ],
            'nilai' => [
                'type' => 'INT'
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
        $this->forge->createTable('ref_soal_jawaban');
    }

    public function down()
    {
        $this->forge->dropTable('ref_soal_jawaban');
    }
}
