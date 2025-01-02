<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsers extends Migration
{
    public function up()
    {
        //
        $fields = [
            'fullname'      => ['type' => 'VARCHAR', 'constraint' => 100, 'after' => 'username'],
            'nip'       => ['type' => 'VARCHAR', 'constraint' => 63, 'after' => 'fullname'],
            'jabatan'          => ['type' => 'VARCHAR', 'constraint' => 18, 'after' => 'nip'],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('users', 'fullname');
        $this->forge->dropColumn('users', 'nip');
        $this->forge->dropColumn('users', 'jabatan');
    }
}
