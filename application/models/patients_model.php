<?php
	class patients_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function add_patients($data){
			$this->db->insert("patients", $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}

		public function add($data){
			$this->db->insert("patients", $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}

		public function add_testResults($data){
			$this->db->insert("swab_test", $data); 
			$insert_id = $this->db->insert_id();
		   	return  $insert_id;		
		}

		public function edit_patients($data,$id){
			$this->db->where('id', $id); 
			$this->db->update("patients", $data); 
			//echo $this->db->last_query();
		}

		public function edit_testResults($data,$id){
			$this->db->where('test_id', $id); 
			$this->db->update("swab_test", $data); 
			//echo $this->db->last_query();
		}

		public function patients_list(){
			$this->db->select('id,concat(patient_id," : ",name) as patient_id');
			$this->db->from('patients');
			$this->db->where('classification','0');
			$this->db->or_where('classification','3');
			$this->db->or_where('classification','4');
			$this->db->order_by('qdate','ASC');
			return $this->db->get()->result_object(); 
		}

		public function merge_list(){
			$this->db->select('id, (CASE WHEN date1 = "0000-00-00" AND date2 = "0000-00-00" THEN date3
										 WHEN date1 > date2 THEN date1
										 WHEN date2 > date1 THEN  date2 END) as qdate');
			$this->db->from('patients2');
			$this->db->where('classification','1');
			$query = $this->db->get('');
	        $result =  $query->result(); 
	        foreach($result as $val){
	        	$this->db->set('qdate', $val->qdate);
				$this->db->where('id', $val->id); 
				$this->db->update("patients2"); 
	        }
			//return $this->db->get()->result_object(); 
		}

		public function get_testResults($id){
			$this->db->select('*');
			$this->db->from('swab_test');
			$this->db->where('p_id',$id);
			$this->db->order_by('test_id','ASC');
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
	
		function allpatients_count($classification){
			$this->db->select('count(patient_id) as count');
			$this->db->where('classification',$classification);
			if($classification!=0){
				$this->db->where('status != ','CLEARED');
			}
			$query = $this->db->get("patients");
	        $result =  $query->result(); 
	        return $result[0]->count;  
		}
		
		function allpatients($limit,$start,$col,$dir,$classification){  
			$this->db->where('classification',$classification);
			if($classification!=0){
				$this->db->where('status != ','CLEARED');
			}
			$this->db->limit($limit,$start);
			$this->db->order_by($col,$dir);
			$query = $this->db->get("patients"); 
	        if($query->num_rows()>0)
	        {
	            return $query->result(); 
	        }
	        else
	        {
	            return null;
	        }
	    }

		function patients_search($limit,$start,$search,$col,$dir,$classification){
			if($classification!=0){
		        $query = $this
		                ->db
		                ->where('classification',$classification)
		                ->where('status != ','CLEARED')
		                ->group_start()
		                ->like('name',$search)
		                ->or_like('brgy',$search)
		                ->group_end()
		                ->limit($limit,$start)
		                ->order_by($col,$dir)
		                ->get("patients");
            }else{
		        $query = $this
		                ->db
		                ->where('classification',$classification)
		                ->group_start()
		                ->like('name',$search)
		                ->or_like('brgy',$search)
		                ->group_end()
		                ->limit($limit,$start)
		                ->order_by($col,$dir)
		                ->get("patients");
            }
	        if($query->num_rows()>0)
	        {
	            return $query->result();  
	        }
	        else
	        {
	            return null;
	        }
	    }

		function patients_search_count($search,$classification)
	    {
			if($classification!=0){
		        $query = $this
		                ->db
		                ->select('count(patient_id) as count')
		                ->where('classification',$classification)
		                ->where('status != ','CLEARED')
		                ->group_start()
		                ->like('name',$search)
		                ->or_like('brgy',$search)
		                ->group_end()
		                ->get("patients");
            }else{
		        $query = $this
		                ->db
		                ->select('count(patient_id) as count')
		                ->where('classification',$classification)
		                ->group_start()
		                ->like('name',$search)
		                ->or_like('brgy',$search)
		                ->group_end()
		                ->get("patients");
            }
	        $result =  $query->result(); 
	        return $result[0]->count;  
	    } 

		public function lastNumber($classification){
			if($classification == 0){
				$col_name = 'confirmed';
			}
			if($classification == 1){
				$col_name = 'pui';
			}
			if($classification == 2){
				$col_name = 'pum';
			}
			if($classification == 3){
				$col_name = 'ic';
			}
			if($classification == 4){
				$col_name = 'oc';
			}
			$this->db->select($col_name.' as lastNum');
			$this->db->from('last_id');
			$query = $this->db->get('');
			//echo $this->db->last_query();
			$result = $query->result();
			if(count($result)!=0){
				return $result[0]->lastNum;
			}else{
				return 0;
			}
		}

		public function update_lastNumber($lastNum,$classification){
			if($classification == 0){
				$col_name = 'confirmed';
			}
			if($classification == 1){
				$col_name = 'pui';
			}
			if($classification == 2){
				$col_name = 'pum';
			}
			if($classification == 3){
				$col_name = 'ic';
			}
			if($classification == 4){
				$col_name = 'oc';
			}
			$data = [
        	$col_name => $lastNum,
			];
			$this->db->where('id', '1'); 
			$this->db->update("last_id", $data); 
			//echo $this->db->last_query();
		}
	}
?>

