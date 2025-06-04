<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbTemplateSurat extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_template'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_template'    => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'icon_template'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'ref_link'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id_template', true);
        $this->forge->createTable('tb_template_surat');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_template_surat');
    }
}
