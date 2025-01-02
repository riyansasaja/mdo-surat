<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInmailAttach extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'attachment_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'inmail_id' => [
                'type'       => 'INT',
            ],
            'attachment_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'attachment_log DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('attachment_id', true);
        $this->forge->createTable('inmail_attachment');
    }

    public function down()
    {
        //
        $this->forge->dropTable('inmail_attachment');
    }
}
