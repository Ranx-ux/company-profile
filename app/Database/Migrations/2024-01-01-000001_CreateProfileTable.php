<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfileTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 255],
            'logo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'visi'        => ['type' => 'TEXT', 'null' => true],
            'misi'        => ['type' => 'TEXT', 'null' => true],
            'alamat'      => ['type' => 'TEXT', 'null' => true],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'telepon'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'website'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('profile');
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}
