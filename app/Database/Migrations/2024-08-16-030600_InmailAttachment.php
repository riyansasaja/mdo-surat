<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InmailAttachment extends Migration
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
            // 'attachment_name' => [
            //     'type'       => 'VARCHAR',
            //     'constraint' => '200',
            // ],
            'attachment_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'attachment_log' => [
                'type'       => 'INT',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('attachment_id', true);
        $this->forge->createTable('tb_inmail_attachment');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_inmail_attachment');
    }
}
