<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Formasi extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'BIGINT',
                'auto_increment' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '128'
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
        $this->forge->createTable('ref_formasi');
    }

    public function down()
    {
        $this->forge->dropTable('ref_formasi');
    }
}
