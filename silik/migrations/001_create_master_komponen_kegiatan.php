<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_create_master_komponen_kegiatan extends CI_Migration {

   public function up() {
 
      $this->dbforge->add_field(array(
         'id' => array(
            'type' => 'INT',
            'constraint' => 5,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
         ),
         'name' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
         ),
         'code' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
         ),
         'table_name' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
         ),
         'status' => array(
            'type' => 'INT',
            'constraint' => '1',
            'default'=>1
         ),
      ));

      $this->dbforge->add_key('id', TRUE);
      $this->dbforge->create_table('master_komponen_kegiatan');

   }

   public function down() {
      $this->dbforge->drop_table('master_komponen_kegiatan');
   }
}
