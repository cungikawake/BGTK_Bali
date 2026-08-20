<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Telegram {
		protected $CI;
		protected $accessToken = "";
		
		public function __construct() {
			$this->CI =& get_instance();
			$this->CI->load->database();
			
			$this->CI->db->select("*");
			$this->CI->db->from("pengaturan");
			$this->CI->db->where("sistem", "telegram_bot_token");
			$this->CI->db->order_by("pos", "ASC");

			$query = $this->CI->db->get();

			if($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$this->accessToken = $row["value"];
				}
			}
		}
		
		public function sendChat ($chatID, $chat) {
			$chat = urlencode($chat);
			$apiURL = "https://api.telegram.org/bot".$this->accessToken;
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$chat."&parse_mode=HTML");
		}
	}
?>