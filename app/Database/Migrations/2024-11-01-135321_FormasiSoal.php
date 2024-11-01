<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormasiSoal extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true
            ],
            'ref_formasi' => [
                'type' => 'INT',
            ],
            'ref_jenis_soal' => [
                'type' => 'INT',
            ],
            'jumlah' => [
                'type' => 'INT',
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
        $this->forge->createTable('ref_formasi_soal');
    }

    public function down()
    {
        $this->forge->dropTable('ref_formasi_soal');
    }
}
