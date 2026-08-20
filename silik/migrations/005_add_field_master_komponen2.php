<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_add_field_master_komponen2 extends CI_Migration {

   public function up() { 
       
      // Tambah Filed Kegiatan
      $fields = array(
         "short_code" => array(
            "type" => "VARCHAR", 
            "constraint" => 50
         )
      );
      $this->dbforge->add_column("master_komponen_kegiatan", $fields);
   }

   public function down() {
      $this->dbforge->drop_column('master_komponen_kegiatan', 'short_code');
   }
}
