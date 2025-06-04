<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbSuratKeluar extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'          => ['type' => 'int'],
            'kode_surat'      => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'isi_surat'      => ['type' => 'text', 'constraint' => 30, 'null' => true],
            'penandatangan'      => ['type' => 'varchar', 'null' => true],
            'file_ttd'      => ['type' => 'varchar', 'null' => true],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_surat_keluar');
    }

    public function down()
    {
        //jika dihapus

        $this->forge->dropTable('tb_surat_keluar');
    }
}
