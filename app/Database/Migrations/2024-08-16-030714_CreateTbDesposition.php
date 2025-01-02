<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbDesposition extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'disposition_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'inmail_id' => [
                'type'       => 'INT',
            ],
            'disposition_form' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'disposition_to' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'petunjuk' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'catatan' => [
                'type'       => 'TEXT',
                'constraint' => '100',
            ],
            'disposition_status' => [
                'type'       => 'INT',
                'constrain'  => 2
            ],
            'disposition_log' => [
                'type'       => 'INT'
            ]
        ]);
        $this->forge->addKey('disposition_id', true);
        $this->forge->createTable('tb_disposition');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_disposition');
    }
}
