<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Bitly {
		protected $CI;
		protected $accessToken = "8ad380126bd66539c3772a5cdb95a666d34b2603";
		
		public function __construct() {
			$this->CI =& get_instance();
			$this->CI->load->database();
			
			$this->CI->db->select("*");
			$this->CI->db->from("pengaturan");
			$this->CI->db->where("sistem", "bitly_access_token");
			$this->CI->db->order_by("pos", "ASC");

			$query = $this->CI->db->get();

			if($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$this->accessToken = $row["value"];
				}
			}
		}
		
		public function shorten ($longUrl) {
			$url = 'https://api-ssl.bitly.com/v4/shorten';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['long_url' => $longUrl]));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"Authorization: Bearer ".$this->accessToken,
				"Content-Type: application/json"
			]);

			$result = json_decode(curl_exec($ch));
			
			$out = array();
			
			if (isset($result->id)) {
				$out["id"] = $result->id;
				$out["link"] = $result->link;
				$out["custom_bitlinks"] = "";
				$out["long_url"] = $result->long_url;
				$out["group"] = $result->references->group;	
			}
			else {
				$out["msg"] = $result->message;
				$out["desc"] = $result->description;
			}
			
			return $out;
		}
		
		public function customLink ($bitlyId, $link) {			
			$url = 'https://api-ssl.bitly.com/v4/custom_bitlinks';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['custom_bitlink' => "bit.ly/".$link, "bitlink_id" => $bitlyId]));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"Authorization: Bearer ".$this->accessToken,
				"Content-Type: application/json"
			]);
			
			$result = json_decode(curl_exec($ch));
			
			if (isset($result->bitlink->id)) {
				$out = array();
				$out["id"] = $result->bitlink->id;
				$out["link"] = $result->bitlink->link;
				$out["custom_bitlinks"] = $result->custom_bitlink;
				$out["long_url"] = $result->bitlink->long_url;
				$out["group"] = $result->bitlink->references->group;
			}
			else {
				$out["msg"] = $result->message;
				$out["desc"] = $result->description;
			}
			
			
			return $out;
		}
	}
?>