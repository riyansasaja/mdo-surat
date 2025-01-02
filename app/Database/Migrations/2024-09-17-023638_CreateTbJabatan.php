<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbJabatan extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_jabatan' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => '2',
            ],
            'attachment_log DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id_jabatan', true);
        $this->forge->createTable('tb_jabatan');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_jabatan');
    }
}
