<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbRegistSm extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'inmail_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'sifat_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jenis_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nomor_agenda' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tgl_agenda' => [
                'type'       => 'date'
            ],
            'no_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tgl_surat' => [
                'type'       => 'date',
            ],
            'asal_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'perihal' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'isi_surat' => [
                'type'       => 'text',
            ],
            'status_inmail' => [
                'type'       => 'INT',
                'constrain'  => 2
            ],
            'inmail_log DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('inmail_id', true);
        $this->forge->createTable('inmail');
    }

    public function down()
    {
        //
        $this->forge->dropTable('inmail');
    }
}
