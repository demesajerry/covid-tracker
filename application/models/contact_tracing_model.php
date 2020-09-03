<?php
	class contact_tracing_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function preparation_list(){
			$this->db->select('*');
			$this->db->from('preparation');
			return $this->db->get()->result_object(); 
		}
		public function list($table){
			$this->db->select('*');
			$this->db->from($table);
			//$this->db->order_by($table,'ASC');
			return $this->db->get()->result_object(); 
		}

		public function checker($where,$table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($table,$where);
			$query = $this->db->get('');
			//echo $this->db->last_query();
			$num = $query->num_rows();
			return $num;
		}

		public function category_list(){
			$this->db->select('*');
			$this->db->from('category');
			return $this->db->get()->result_object(); 
		}

		public function diagnosis_list(){
			$this->db->select('a.*,a.icd_group as icdGroup_id, b.icd_group');
			$this->db->from('diagnosis a');
			$this->db->join('icd_group b','b.id = a.icd_group','LEFT');
			return $this->db->get()->result_object(); 
		}

		public function escalate_list(){
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where("FIND_IN_SET('Consultant',access) >", 0);
			$this->db->or_where("FIND_IN_SET('Admin',access) >", 0);
			return $this->db->get()->result_object(); 
		}

		public function source_list(){
			$this->db->select('*');
			$this->db->from('source');
			return $this->db->get()->result_object(); 
		}

		public function type_list(){
			$this->db->select('*');
			$this->db->from('type');
			return $this->db->get()->result_object(); 
		}

		public function add_preparation($data){
			$this->db->insert('preparation', $data); 
		}

		public function edit_preparation($data,$id){
			$this->db->where('prep_id', $id); 
			$this->db->update('preparation', $data); 
			//echo $this->db->last_query();
		}

		public function add_category($data){
			$this->db->insert('category', $data); 
		}

		public function add_diagnosis($data){
			$this->db->insert('diagnosis', $data); 
			return $this->db->insert_id();
		}

		public function add($data,$table){
			$this->db->insert($table, $data);
			$insert_id = $this->db->insert_id();
   			return  $insert_id;
		}
		public function edit($data,$id,$table,$id_name){
			$this->db->where($id_name, $id); 
			$this->db->update($table, $data); 
			//echo $this->db->last_query();
		}

		public function add_source($data){
			$this->db->insert('source', $data); 
		}

		public function edit_category($data,$id){
			$this->db->where('cat_id', $id); 
			$this->db->update('category', $data); 
			//echo $this->db->last_query();
		}

		public function edit_diagnosis($data,$id){
			$this->db->where('diagnosis_id', $id); 
			$this->db->update('diagnosis', $data); 
			//echo $this->db->last_query();
		}

		public function edit_source($data,$id){
			$this->db->where('source_id', $id); 
			$this->db->update('source', $data); 
			//echo $this->db->last_query();
		}

		public function add_type($data){
			$this->db->insert('type', $data); 
		}

		public function edit_type($data,$id){
			$this->db->where('type_id', $id); 
			$this->db->update('type', $data); 
			//echo $this->db->last_query();
		}

		public function update_points_leftover($data){
			$this->db->set('points', 'points+'.$data->points, FALSE);
			$this->db->set('leftover', $data->leftover);
			$this->db->where('clients_id', $data->sold_to);
			$this->db->update('clients'); 
		}

		public function delete($id,$table_id,$table){
			$this->db->where($table_id,$id);
			$this->db->delete($table); 
		}

	}
?>

