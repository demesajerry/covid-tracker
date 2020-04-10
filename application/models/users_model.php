<?php
	class users_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function add_users($data){		
			$this->db->insert('users', $data); 
			$insert_id = $this->db->insert_id();
		   return  $insert_id;		
		}

		public function get_users_list(){
			$this->db->select('a.*');
			$this->db->from('users a');
			return $this->db->get()->result_object(); 
		}
		public function station_list(){
			$this->db->select('*');
			$this->db->from('health_station');
			return $this->db->get()->result_object(); 
		}
		public function get_station($station_id){
			$this->db->select('*');
			$this->db->from('health_station');
			$this->db->where('station_id',$station_id);
			return $this->db->get()->result_object(); 
		}
		public function edit_users($data,$userid){
			$this->db->where('userid', $userid); 
			$this->db->update('users', $data); 
			//echo $this->db->last_query();exit();
		}

		public function update_points_leftover($data){
			$this->db->set('points', 'points+'.$data->points, FALSE);
			$this->db->set('leftover', $data->leftover);
			$this->db->where('customers_id', $data->sold_to);
			$this->db->update('customers'); 
		}

	}
?>

