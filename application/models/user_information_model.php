<?php
	class User_information_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function backend_authentication_details($username, $password){
			$this->db->select('a.*');
			$this->db->from('users a');
			$this->db->where('username', $username);
			$this->db->where('password', sha1($password));
			$this->db->limit(1);

			$query = $this->db->get();
			
			//$this->db->query("UPDATE `backend_user_info` set last_login_date = UNIX_TIMESTAMP(NOW()) where username ='" .$username. "' and password='".sha1($password)."'");
			
			if($query->num_rows() == 1)
			{
				$result = $query->result();
				return $result[0];
			}
			else
			{
				return false;
			}
		}
		
		
		
	}
?>

