<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_add_field_kegiatan extends CI_Migration {

   public function up() { 
       
      // Tambah Filed Kegiatan
      $fields = array(
         "provinsi_tempat_kegiatan" => array(
            "type" => "VARCHAR", 
            "constraint" => 50
         )
      );
      $this->dbforge->add_column("kegiatan", $fields);
   }

   public function down() {
      $this->dbforge->drop_column('kegiatan', 'provinsi_tempat_kegiatan');
   }
}
