<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbEviden extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'evidence_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'inmail_id' => [
                'type'       => 'INT',
            ],
            'user_id' => [
                'type'       => 'INT',
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'attachment_log DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('evidence_id', true);
        $this->forge->createTable('tb_evidence');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_evidence');
    }
}
