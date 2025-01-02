<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersPhone extends Migration
{
    public function up()
    {
        //
        $fields = [
            'no_hp'      => ['type' => 'VARCHAR', 'constraint' => 100, 'after' => 'jabatan'],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('users', 'no_hp');
    }
}
