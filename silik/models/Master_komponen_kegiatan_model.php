<?php
class Master_komponen_kegiatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    public function get_all_records() {
        $this->db->from('master_komponen_kegiatan');
        $this->db->order_by('order', 'asc');
        return $this->db->get()->result();
    }

    public function get_record_by_id($id) {
        return $this->db->get_where('master_komponen_kegiatan', array('id' => $id))->row();
    }

    public function get_record_by_code($code) {
        return $this->db->get_where('master_komponen_kegiatan', array('code' => $code))->row();
    }

    public function get_record_by_short_code($code) {
        return $this->db->get_where('master_komponen_kegiatan', array('short_code' => $code))->row();
    }

    public function get_record_by_table($table) {
        return $this->db->get_where('master_komponen_kegiatan', array('table_name' => $table))->row();
    }

    public function insert_record($data) {
        $this->db->insert('master_komponen_kegiatan', $data);
    }

    public function update_record($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('master_komponen_kegiatan', $data);
    }

    public function delete_record($id) {
        $this->db->where('id', $id);
        $this->db->delete('master_komponen_kegiatan');
    }

    public function save($data, $id){
        if(empty($id)){
            $count = $this->db->get_where('master_komponen_kegiatan', array('table_name' => $data['table_name']))->count();
            
            if($count == 0){
                $this->db->insert('master_komponen_kegiatan', $data);
                $res = $this->create_sample_table($data['table_name']);
                return $res;
            }else{
                return FALSE;
            }
            
        }else{ 
            
            $this->db->where('id', $id);
            $this->db->update('master_komponen_kegiatan', $data);

            return TRUE;
        }  
    }

    public function create_sample_table($table_name) { 

        // Check if the table already exists
        if ($this->db->table_exists($table_name)) {
            return FALSE;  // Table already exists, no need to create it again
        }

        // Define the fields
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'kode' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
            ),
            'kegiatan_id' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'ktp' => array(
                'type' => 'VARCHAR',
                'constraint' => '16',
            ),
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
            ),
            'tempat_lahir' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
            ),
            'tgl_lahir' => array(
                'type' => 'DATE', 
            ),
            'jenis_kelamin' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'nip' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'npwp' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'golongan' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'pangkat' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'pendidikan_terakhir' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'unit_kerja' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'jabatan' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ), 
            'alamat_unit_kerja' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'provinsi_unit_kerja' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'kab_unit_kerja' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'telp_unit_kerja' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'alamat_tinggal' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'telp' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ), 
            'pegawai_balai' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'nama_bank' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'nama_pemilik_rekening' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'no_rekening' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'surat_tugas' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'konfirmasi_paket' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'tanda_tangan' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'kategori' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'daftar_hadir' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'dibuat_oleh' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'dibuat_tgl' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ), 
            'diubah_oleh' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'diubah_tgl' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ), 
        );

        // Define the primary key
        $this->dbforge->add_key('id', TRUE);

        // Create the table
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table($table_name, TRUE);

        return TRUE;  // Table created successfully
    }
}
?>
