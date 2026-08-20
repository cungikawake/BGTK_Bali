<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guest_model extends CI_Model{
	var $passwordSalt;
	
    function __construct() {
		$this->passwordSalt = "SiPandu2022";
    }
	
	public function getByFacebookId ($facebookId) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("oauth_provider", "facebook");
		$this->db->where("oauth_uid", $facebookId);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByGoogleId ($googleId) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("oauth_provider", "google");
		$this->db->where("oauth_uid", $googleId);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getById ($id) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("id", $id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByEmail ($email) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("email", $email);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByActivation ($code) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("aktivasi", $code);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function getByResetCode ($code) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("reset_password", $code);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function login ($email, $password) {
		$out = array();
		
		$this->db->select("*");
		$this->db->from("guest");
		$this->db->where("email", $email);
		$this->db->where("password", md5($this->passwordSalt.$password));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row["notif"] = json_decode($row["notif"], true);
				$out = $row;
			}
		}
		
		return $out;
	}
	
	public function save ($data, $id = 0) {
		if (empty($id)) {
			$data['dibuat_tgl']  = date("Y-m-d H:i:s");
            $data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			$this->db->insert('guest', $data);
			$id = $this->db->insert_id();
		}
		else {
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			$this->db->where('id', $id);
			$this->db->update('guest', $data);
		}
		
		return $id;
	}
	
	public function savePassword ($password, $id = 0) {
		if (!empty($id)) {
			$data["password"] = md5($this->passwordSalt.$password);
			$data["reset_password"] = "";
			$data['diubah_tgl'] = date("Y-m-d H:i:s");
			
			$this->db->where('id', $id);
			$this->db->update('guest', $data);
		}
		
		return $id;
	}
	
	public function register ($data) {
		$data["oauth_provider"] = "sipandu";
		$data["oauth_uid"] = time().rand();
		$data["password"] = md5($this->passwordSalt.$data["password"]);
		$data["aktivasi"] = md5($this->passwordSalt.time().rand());
		$data['dibuat_tgl']  = date("Y-m-d H:i:s");
		$data['diubah_tgl'] = date("Y-m-d H:i:s");
		
		$this->db->insert('guest', $data);
		$id = $this->db->insert_id();
		
		return $id;
	}
	
	/*public function resetPassword ($userId) {
		$data = array();
		$data["reset_password"] = md5($this->passwordSalt.time().rand());
		$data['last_update'] = date("Y-m-d H:i:s");
		
		$this->db->where('id', $userId);
		$this->db->update('user', $data);
		
		return $data["reset_password"];
	}
	
	public function changePassword ($userId, $password) {
		$data["password"] = md5($this->passwordSalt.$password);
		$data['last_update'] = date("Y-m-d H:i:s");
		
		$this->db->where('id', $userId);
		$this->db->update('user', $data);
		
		return $userId;
	}*/
    
    /*
     * Insert / Update facebook profile data into the database
     * @param array the data for inserting into the table
     */
    public function checkUser($userData = array()){
        if(!empty($userData)){
            //check whether user data already exists in database with same oauth info
            $this->db->select($this->primaryKey);
            $this->db->from($this->tableName);
            $this->db->where(array('oauth_provider'=>$userData['oauth_provider'],'oauth_uid'=>$userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                
                //update user data
                $userData['last_update'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->tableName,$userData,array('id'=>$prevResult['id']));
                
                //get user ID
                $userID = $prevResult['id'];
            }else{
                //insert user data
                $userData['created_date']  = date("Y-m-d H:i:s");
                $userData['last_update'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->tableName,$userData);
                
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        
        //return user ID
        return $userID?$userID:FALSE;
    }
}