<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_create_kegiatan_options extends CI_Migration {

   public function up() {

      // Master Komponen
      $this->dbforge->add_field(array(
         'id' => array(
            'type' => 'INT',
            'constraint' => 5,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
         ),
         'kegiatan_id' => array(
            'type' => 'INT',
         ),
         'code_komponen' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
         ),
         'key' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
         ),
         'value' => array(
            'type' => 'text',
            'null' => TRUE,
         ),
      ));

      $this->dbforge->add_key('id', TRUE);
      $this->dbforge->create_table('kegiatan_options');

   }

   public function down() {
      $this->dbforge->drop_table('kegiatan_options');
   }
}
