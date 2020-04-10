<?php
	class public_info_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function count($classification,$where){
			$this->db->select('count(*) as case_count');
			$this->db->from('patients');
			$this->db->where('classification',$classification);
			if($classification!=0){
				$this->db->where('status!=','CLEARED');
			}
			if($where!=''){
				$this->db->where('status',$where);
			}
			$query = $this->db->get('');
			$result = $query->result();
			return $result[0]->case_count; 
		}
		public function add_patients($data,$table){
			$this->db->insert($table, $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}

		public function add($data,$table){
			$this->db->insert($table, $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}

		public function edit_patients($data,$id,$table){
			$this->db->where('id', $id); 
			$this->db->update($table, $data); 
			//echo $this->db->last_query();
		}

		public function get_patients_list(){
			$this->db->select('*');
			$this->db->from('patients');
			$this->db->order_by('patient_id','DEC');
			return $this->db->get()->result_object(); 
		}

		public function tree_data(){
			$this->db->select('id, patient_id as head, possible_link,classification,status, concat(brgy,"<br>",status) as contents, current_location');
			$this->db->from('patients');
			$this->db->where('classification','0');
			$this->db->or_where('classification','3');
			$this->db->or_where('classification','4');
			$this->db->order_by('patient_id','ASC');
			return $this->db->get()->result_object(); 
		}

		public function patient_data($rowno,$rowperpage,$classification){
			$this->db->select('a.patient_id,a.gender, a.age,a.age_type, a.brgy, a.travel_history,a.possible_link, a.status,  a.current_condition, a.symptoms, a.current_location,b.patient_id as pt_link');
			$this->db->from('patients a');
			$this->db->join('patients b','b.id=a.possible_link','left');
			$this->db->where('a.classification',$classification);
			if($classification!=0){
				$this->db->where('a.status!=','CLEARED');
			}
			$this->db->order_by('a.id','ASC');
			$this->db->limit($rowperpage, $rowno);  
			return $this->db->get()->result_object(); 
		}
		public function getrecordCount($classification) {
		    $this->db->select('count(*) as allcount');
		    $this->db->from('patients');
			$this->db->where('classification',$classification);
			if($classification!=0){
				$this->db->where('status!=','CLEARED');
			}
		    $query = $this->db->get();
			$result = $query->result();
			return $result[0]->allcount; 
	  	}

  		public function pie_data($classification){
			$this->db->select('count(*) as confirmed_count,brgy');
			$this->db->from('patients');
			$this->db->where('classification',$classification);
			$this->db->where('brgy!=','');
			if($classification!='0'){
				$this->db->where('status!=','CLEARED');
			}
			$this->db->group_by('brgy');
			$this->db->order_by('brgy','ASC');
			return $this->db->get()->result_object(); 
		}


  		public function bar_data($classification,$where){
			$this->db->select('count(*) as num');
			$this->db->from('patients');
			if($where == ''){
				$this->db->where('status!=','CLEARED');
			}else{
				$this->db->where('status',$where);
			}
			$this->db->where('classification',$classification);
		    $query = $this->db->get();
			$result = $query->result();
			return $result[0]->num; 
		}

  		public function test_data($where){
			$this->db->select('count(*)');
			$this->db->from('swab_test');
			if($where != '' && $where != 'WAITING'){
				$this->db->where('result',$where);
			}
			if($where == 'WAITING'){
				$this->db->where('result','');
			}
			$this->db->group_by('p_id');
			$this->db->order_by('test_id','ASC');
		    $query = $this->db->get();
			$result = $query->result();
			if(count($result)!=0){
			return $result[0]->num; 
			}else{
				return 0;
			}
		}

		public function area_data(){
			$this->db->select('count(*) as num,result_date');
			$this->db->from('patients');
			$this->db->where('classification','0');
			$this->db->group_by('result_date');
			$this->db->order_by('result_date','ASC');
			return $this->db->get()->result_object(); 
		}

		public function recoveries_data(){
			$this->db->select('count(*) as num, date_recovered as date');
			$this->db->from('patients');
			$this->db->where('status','RECOVERED');
			$this->db->where('classification','0');
			$this->db->group_by('date_recovered');
			$this->db->order_by('date_recovered','ASC');
			return $this->db->get()->result_object(); 
		}

		public function death_data(){
			$this->db->select('count(*) as num, date_died as date');
			$this->db->from('patients');
			$this->db->where('status','DECEASED');
			$this->db->where('classification','0');
			$this->db->group_by('date_died');
			$this->db->order_by('date_died','ASC');
			return $this->db->get()->result_object(); 
		}

		public function get_client_info($id){
			$this->db->select('a.*,b.diagnose_date as diabetes, c.diagnose_date as hypertension, h.hmo');
			$this->db->from('patients a');
			$this->db->join('(select * from client_hd where diagnosis = "DIABETES") b', 'b.client_id = a.patient_id', 'LEFT');
			$this->db->join('(select * from client_hd where diagnosis = "HYPERTENSION") c', 'c.client_id = a.patient_id', 'LEFT');
			$this->db->join('hmo h', 'h.hmo_id = a.hmo_id', 'LEFT');
			$this->db->where('patient_id',$id);
			$query = $this->db->get('');
			$result = $query->result();
			return $result[0];
		}

	
		public function get_details($id,$table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where('vs_id',$id);
			$query = $this->db->get('');
			$result = $query->result();
			if(count($result)!=0){
				return $result[0]; 
			}
			else{
				return false;
			}
		}
		public function get_list($id,$table,$column){
			if($table == 'client_diagnosis'){
				$this->db->select('group_concat(cd_id,":",'.$column.') as selected_'.$column);
			}else{
				$this->db->select('group_concat('.$column.') as selected_'.$column);
			}
			$this->db->from($table);
			$this->db->where('vs_id',$id);
			$query = $this->db->get('');
			$result = $query->result();
			if(count($result)!=0){
				return $result[0]; 
			}
			else{
				return false;
			}
		}
	
		function allpatients_count($table){   
			$this->db->select('count(patient_id) as count');
			$query = $this->db->get($table);
	        $result =  $query->result(); 
	        return $result[0]->count;  
		}
		
		function allpatients($limit,$start,$col,$dir,$table){  
			$this->db->limit($limit,$start);
			$this->db->order_by($col,$dir);
			$query = $this->db->get($table); 
	        if($query->num_rows()>0)
	        {
	            return $query->result(); 
	        }
	        else
	        {
	            return null;
	        }
	    }

		function patients_search($limit,$start,$search,$col,$dir,$table){
	        $query = $this
	                ->db
	                ->like('name',$search)
	                ->or_like('brgy',$search)
	                ->limit($limit,$start)
	                ->order_by($col,$dir)
	                ->get($table);
	        if($query->num_rows()>0)
	        {
	            return $query->result();  
	        }
	        else
	        {
	            return null;
	        }
	    }

		function patients_search_count($search,$table)
	    {
	        $query = $this
	                ->db
	                ->select('count(patient_id) as count')
	                ->like('name',$search)
	                ->or_like('brgy',$search)
	                ->get($table);
	        $result =  $query->result(); 
	        return $result[0]->count;  
	    } 

		public function lastNumber($dov){
			$this->db->select('number_today');
			$this->db->from('vital_signs');
			$this->db->where('dov',$dov);
			$this->db->order_by('number_today','DESC');
			$this->db->limit('1');
			$query = $this->db->get('');
			//echo $this->db->last_query();
			$result = $query->result();
			if(count($result)!=0){
				return $result[0]->number_today; 
			}
			else{
				return false;
			}
		}
	}
?>

