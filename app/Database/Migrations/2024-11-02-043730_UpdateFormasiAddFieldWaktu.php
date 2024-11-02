<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateFormasiAddFieldWaktu extends Migration
{
    public function up()
    {
        $fields = [
            'waktu' => [
                'type' => 'INT',
            ],
        ];
        $this->forge->addColumn('ref_formasi', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('ref_formasi', ['waktu']);
    }
}
