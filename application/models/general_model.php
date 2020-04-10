<?php
	class general_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function get_one_row($table,$id_name,$id){
			$this->db->select('*');
			$this->db->from($table);
			if($id!=''){
			$this->db->where($id_name,$id);
			}
			$query = $this->db->get('');
			$result = $query->result();
			if(count($result)!=0){
				return $result[0]; 
			}
			else{
				return false;
			}		
		}
		public function list($table){
			$this->db->select('*');
			$this->db->from($table);
			$query = $this->db->get('');
			$result = $query->result();
			return $result; 
		}
		public function get_province(){
			$this->db->select('provDesc,provCode');
			$this->db->from('refprovince');
			return $this->db->get()->result_object(); 
		}
		public function get_municipality($provCode){
			$this->db->select('citymunDesc,citymunCode,provCode');
			$this->db->from('refcitymun');
			$this->db->where('provCode', $provCode); 
			return $this->db->get()->result_object(); 
		}
		public function get_brgy($citymunCode){
			$this->db->select('brgyDesc,brgyCode,citymunCode');
			$this->db->from('refbrgy');
			$this->db->where('citymunCode', $citymunCode); 
			return $this->db->get()->result_object(); 
		}
		public function get_hmo(){
			$this->db->select('*');
			$this->db->from('hmo');
			return $this->db->get()->result_object(); 
		}
	}
?>

