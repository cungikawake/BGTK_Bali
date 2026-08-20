<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_add_field_master_komponen extends CI_Migration {

   public function up() { 
       
      // Tambah Filed Kegiatan
      $fields = array(
         "order" => array(
            "type" => "INT", 
            'default'=> 0
         )
      );
      $this->dbforge->add_column("master_komponen_kegiatan", $fields);
   }

   public function down() {
      $this->dbforge->drop_column('master_komponen_kegiatan', 'order');
   }
}
