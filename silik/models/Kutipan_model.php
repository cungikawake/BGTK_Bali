<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kutipan_model extends CI_Model{
	
    function __construct() {
    }
	
	public function getRandom () {
		$out = array();
		
		$this->db->order_by('id', 'RANDOM');
    	$this->db->limit(1);
		$query = $this->db->get('kutipan');
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$out = $row;
			}
		}
		
		return $out;
	}	
}