<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class patients extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		//$this->output->enable_profiler(TRUE);
		$this->load->model('patients_model', '', TRUE);

	}

	public function index()
	{
		$this->list();
	}

	public function list()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'patients/confirmed';

		$this->load->view('template/admin', $this->data);
	}

	public function get_pui()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'patients/pui';

		$this->load->view('template/admin', $this->data);
	}

	public function get_pum()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'patients/pum';

		$this->load->view('template/admin', $this->data);
	}

	public function get_confined()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'patients/confined';

		$this->load->view('template/admin', $this->data);
	}

	public function get_other()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'patients/others';

		$this->load->view('template/admin', $this->data);
	}

	public function get_patients(){
		$classification = $this->input->get('classification');

		$this->load->model('patients_model');
		$columns = array( 
                            0 =>'patient_id', 
                            1 =>'name',
                            2=> 'brgy',
                            3=> 'status',
                            4=> 'current_location',
                            5=> 'age',
                            6=> 'qdate',
                            7=> 'transmission',
                            8=> 'action',
                        );

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->patients_model->allpatients_count($classification);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $patients = $this->patients_model->allpatients($limit,$start,$order,$dir,$classification);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $patients =  $this->patients_model->patients_search($limit,$start,$search,$order,$dir,$classification);

            $totalFiltered = $this->patients_model->patients_search_count($search,$classification);
        }

        $data = array();
        if(!empty($patients))
        {
            foreach ($patients as $val)
            {

				if($val->symptoms_started!='0000-00-00'){
					$symptoms_started=date_create($val->symptoms_started);
					$symptoms_started=date_format($symptoms_started,"F d, Y");
				}else{
					$symptoms_started='';
				}

				if($val->result_date!='0000-00-00'){
					$result_date=date_create($val->result_date);
					$result_date=date_format($result_date,"F d, Y");
				}else{
					$result_date='';
				}

				if($val->date_recovered!='0000-00-00'){
					$date_recovered=date_create($val->date_recovered);
					$date_recovered=date_format($date_recovered,"F d, Y");
				}else{
					$date_recovered='';
				}

				if($val->date_died!='0000-00-00'){
					$date_died=date_create($val->date_died);
					$date_died=date_format($date_died,"F d, Y");
				}else{
					$date_died='';
				}

				if($val->qdate!='0000-00-00'){
					$qdate=date_create($val->qdate);
					$qdate=date_format($qdate,"F d, Y");
					$qend = date('M d, Y', strtotime($val->qdate. ' + 14 days'));
				}else{
					$qdate='';
					$qend='';
				}

                $nestedData['patient_id'] = $val->patient_id;
                $nestedData['name'] = $val->name;
                $nestedData['brgy'] = $val->brgy;
                $nestedData['status'] = $val->status;
                $nestedData['current_location'] = $val->current_location;
                $nestedData['age'] = $val->age.' '.$val->age_type;
                $nestedData['qdate'] = $qend;
                $nestedData['transmission'] = $val->transmission;
                $nestedData['action'] = '<a class="edit_modal" href="#" title="Edit Details"
			                              id="'.$val->id.'" 
			                              name="'.$val->name.'" 
			                              age="'.$val->age.'" 
			                              age_type="'.$val->age_type.'" 
			                              gender="'.$val->gender.'" 
			                              brgy="'.$val->brgy.'" 
			                              travel_history="'.$val->travel_history.'" 
			                              status="'.$val->status.'" 
			                              current_location="'.$val->current_location.'" 
			                              symptoms="'.$val->symptoms.'" 
			                              symptoms_started="'.$symptoms_started.'" 
			                              qdate="'.$qdate.'" 
			                              result_date="'.$result_date.'" 
			                              date_recovered="'.$date_recovered.'" 
			                              date_died="'.$date_died.'" 
			                              current_condition="'.$val->current_condition.'" 
			                              transmission="'.$val->transmission.'" 
			                              possible_link="'.$val->possible_link.'" 
			                              >
			                              <i class="fa fa-edit"></i>
			                               </a> |
										<a class="test_results" href="#" title="Add / View Test Results"
			                              id="'.$val->id.'" 
			                              >
			                              <i class="fa fa-medkit"></i>
			                               </a>
			                               ';
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
	}

	public function add_patients()
	{
		$classification = $this->input->post('classification');
		if($classification==0){
			$prefix = 'LB-C';
		}
		if($classification==1){
			$prefix = 'PUI-';
		}
		if($classification==2){
			$prefix = 'PUM-';
		}
		if($classification==3){
			$prefix = 'IC-';
		}

		if($classification==4){
			$prefix = 'OC-';
		}

		if(!empty($this->input->post('symptoms_started'))){
			$symptoms_started=date_create($this->input->post('symptoms_started'));
			$symptoms_started=date_format($symptoms_started,"Y-m-d");
		}else{
			$symptoms_started='';
		}

		if(!empty($this->input->post('result_date'))){
			$result_date=date_create($this->input->post('result_date'));
			$result_date=date_format($result_date,"Y-m-d");
		}else{
			$result_date='';
		}

		if(!empty($this->input->post('date_recovered'))){
			$date_recovered=date_create($this->input->post('date_recovered'));
			$date_recovered=date_format($date_recovered,"Y-m-d");
		}else{
			$date_recovered='';
		}

		if(!empty($this->input->post('date_died'))){
			$date_died=date_create($this->input->post('date_died'));
			$date_died=date_format($date_died,"Y-m-d");
		}else{
			$date_died='';
		}

		if(!empty($this->input->post('qdate'))){
			$qdate=date_create($this->input->post('qdate'));
			$qdate=date_format($qdate,"Y-m-d");
		}else{
			$qdate='';
		}
		//get count base on classification
		$lastNum = $this->patients_model->lastNumber($classification);
		$lastNum = sprintf('%02d', $lastNum+1);
		$symptoms = $this->input->post('symptoms');
		//update last number
		$this->patients_model->update_lastNumber($lastNum,$classification);
		$data = new stdClass();
		$data->patient_id = $prefix.$lastNum;
		$data->classification = $this->input->post('classification');
		$data->name = $this->input->post('name');
		$data->age = $this->input->post('age');
		$data->age_type = $this->input->post('age_type');
		$data->gender = $this->input->post('gender');
		$data->brgy = $this->input->post('brgy');
		$data->travel_history = $this->input->post('travel_history');
		$data->status = $this->input->post('status');
		$data->current_location = $this->input->post('current_location');
		$data->symptoms_started = $symptoms_started;
		$data->qdate = $qdate;
		$data->result_date = $result_date;
		$data->date_recovered = $date_recovered;
		$data->date_died = $date_died;
		$data->current_condition = $this->input->post('current_condition');
		$data->transmission = $this->input->post('transmission');
		$data->possible_link = $this->input->post('possible_link');
		$data->date_added = date('Y-m-d');
		if(!empty($symptoms)){
			foreach($symptoms as $key=>$val){
				if($key=='0'){
				$data->symptoms = $val;
				}
				else{
				$data->symptoms .= ','.$val;
				}
			}
		}else{
				$data->symptoms = '';
		}

		$id = $this->patients_model->add_patients($data);
		$data->name = $data->name;
		$data->patient_id = $id;
		$data->action = 'added';
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function edit_patients()
	{
		$this->load->model('patients_model', '', TRUE);

		if(!empty($this->input->post('symptoms_started'))){
			$symptoms_started=date_create($this->input->post('symptoms_started'));
			$symptoms_started=date_format($symptoms_started,"Y-m-d");
		}else{
			$symptoms_started='';
		}

		if(!empty($this->input->post('result_date'))){
			$result_date=date_create($this->input->post('result_date'));
			$result_date=date_format($result_date,"Y-m-d");
		}else{
			$result_date='';
		}

		if(!empty($this->input->post('date_recovered'))){
			$date_recovered=date_create($this->input->post('date_recovered'));
			$date_recovered=date_format($date_recovered,"Y-m-d");
		}else{
			$date_recovered='';
		}

		if(!empty($this->input->post('date_died'))){
			$date_died=date_create($this->input->post('date_died'));
			$date_died=date_format($date_died,"Y-m-d");
		}else{
			$date_died='';
		}

		if(!empty($this->input->post('qdate'))){
			$qdate=date_create($this->input->post('qdate'));
			$qdate=date_format($qdate,"Y-m-d");
		}else{
			$qdate='';
		}

		$from_pum = $this->input->post('from_pum');
		$symptoms = $this->input->post('symptoms');
		$table = $this->input->post('table');
		$classification = $this->input->post('classification');
		$id = $this->input->post('id');
		$this->load->model('patients_model', '', TRUE);
		$data = new stdClass();
		$todo = "0";
		if($from_pum!='' && $classification==1){
			$lastNum = $this->patients_model->lastNumber('pui');
			$lastNum = sprintf('%02d', $lastNum+1);
			//update last number
			$this->patients_model->update_lastNumber($lastNum,$classification);
			$data->patient_id = 'PUI-'.$lastNum;
			$data->classification = $this->input->post('classification');
			$todo = '1';
		}

		$data->name = $this->input->post('name');
		$data->age = $this->input->post('age');
		$data->age_type = $this->input->post('age_type');
		$data->gender = $this->input->post('gender');
		$data->brgy = $this->input->post('brgy');
		$data->travel_history = $this->input->post('travel_history');
		$data->status = $this->input->post('status');
		$data->current_location = $this->input->post('current_location');
		$data->symptoms_started = $symptoms_started;
		$data->qdate = $qdate;
		$data->result_date = $result_date;
		$data->date_recovered = $date_recovered;
		$data->date_died = $date_died;
		$data->current_condition = $this->input->post('current_condition');
		$data->transmission = $this->input->post('transmission');
		$data->possible_link = $this->input->post('possible_link');
		if(!empty($symptoms)){
			foreach($symptoms as $key=>$val){
				if($key=='0'){
				$data->symptoms = $val;
				}
				else{
				$data->symptoms .= ','.$val;
				}
			}
		}else{
				$data->symptoms = '';
		}
		$this->patients_model->edit_patients($data,$id);
		$data->id=	$id;
		$data->todo=$todo;
		$data->action = 'edited';
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_testResults()
	{
		$this->load->model('patients_model', '', TRUE);
		$id = $this->input->post('id');
		$data = $this->patients_model->get_testResults($id);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function add_testResults()
	{
		$this->load->model('patients_model', '', TRUE);

		if(!empty($this->input->post('test_date'))){
			$test_date=date_create($this->input->post('test_date'));
			$test_date=date_format($test_date,"Y-m-d");
		}else{
			$test_date='';
		}
		
		if(!empty($this->input->post('result_date'))){
			$result_date=date_create($this->input->post('result_date'));
			$result_date=date_format($result_date,"Y-m-d");
		}else{
			$result_date='';
		}
		$test_id = $this->input->post('test_id');
		$data = new stdClass();
		$data->p_id = $this->input->post('p_id');
		$data->test_date = $test_date;
		$data->result_date = $result_date;
		$data->result = $this->input->post('result');
		if($test_id == ''){
			$data->test_id = $this->patients_model->add_testResults($data);
		}else{
			$this->patients_model->edit_testResults($data,$test_id);
		}

		$jsondata = $this->patients_model->get_testResults($data->p_id);		
		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}

	public function add_test()
	{
		$this->load->model('patients_model', '', TRUE);

		if(!empty($this->input->post('test_date'))){
			$test_date=date_create($this->input->post('test_date'));
			$test_date=date_format($test_date,"Y-m-d");
		}else{
			$test_date='';
		}
		
		if(!empty($this->input->post('result_date'))){
			$result_date=date_create($this->input->post('result_date'));
			$result_date=date_format($result_date,"Y-m-d");
		}else{
			$result_date='';
		}
		$test_id = $this->input->post('test_id');
		$data = new stdClass();
		$data->p_id = $this->input->post('p_id');
		$data->test_date = $test_date;
		$data->result_date = $result_date;
		$data->result = $this->input->post('result');
		if($test_id == ''){
			$data->test_id = $this->patients_model->add_testResults($data);
		}else{
			$this->patients_model->edit_testResults($data,$test_id);
		}
		$jsondata = new stdClass();
		if($data->result == 1){
			$classification = 'confirmed';
			//get count base on classification
			$lastNum = $this->patients_model->lastNumber($classification);
			$lastNum = sprintf('%02d', $lastNum+1);
			$symptoms = $this->input->post('symptoms');
			//update last number
			$this->patients_model->update_lastNumber($lastNum,$classification);
			$data2= new stdClass();
			$data2->patient_id = 'LB-C'.$lastNum;
			$data2->classification = 0;
			$data2->result_date = $result_date;
			$this->patients_model->edit_patients($data2,$data->p_id);
			$jsondata->todo = '1';	
		}else{
			$jsondata->todo = '0';	
		}
		$jsondata->data = $this->patients_model->get_testResults($data->p_id);

		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}

	public function patient_list()
	{
		$this->load->model('patients_model', '', TRUE);
		$classification = $this->input->post('classification');
		$data = new stdClass();
		$data->patient_list = $this->patients_model->patients_list();
		header('Content-Type: application/json');
		echo json_encode( $data );
	}
	/*
	public function merge()
	{
		$this->load->model('patients_model', '', TRUE);
		$classification = $this->input->post('classification');
		$data = new stdClass();
		$patient_list = $this->patients_model->merge_list();
		echo '<pre>' . var_export($patient_list, true) . '</pre>';
		//header('Content-Type: application/json');
		//echo json_encode( $data );
	}*/

}
