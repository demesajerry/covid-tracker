<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reports extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->sales_reports();
	}
	public function stocks()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/stocks';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$product_id = $this->input->get('product_id');

		//$this->data['product_list'] = $this->product_model->product_list();
		//$this->data['brand_list'] = $this->product_model->brand_list();
		//$this->data['unit_list'] = $this->product_model->unit_list();
		//$this->data['stocks_list'] = $this->reports_model->stocks($product_id);
		$this->data['station_list'] = $this->users_model->station_list();
		$this->data['cat_list'] = $this->product_model->cat_list();
		//$this->data['product_id']=$product_id;
		$this->load->view('template/admin', $this->data);
	}

	public function search_stocks()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/stocks';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$product_id = $this->input->get('product_id');

		$search = new stdClass();
		$search->exp_from = $this->input->post('date_from');
		$search->exp_to = $this->input->post('date_to');
		$search->stock_from = $this->input->post('sdate_from');
		$search->stock_to = $this->input->post('sdate_to');
		$search->product_name = $this->input->post('product_name');
		$search->remaining_stock = $this->input->post('remaining_stock');
		$search->station_id = $this->input->post('station_id');
		$search->cat_id = $this->input->post('cat_id');

		//$this->data['product_list'] = $this->product_model->product_list();
		//$this->data['brand_list'] = $this->product_model->brand_list();
		//$this->data['unit_list'] = $this->product_model->unit_list();
		$this->data['station_list'] = $this->users_model->station_list();
		$this->data['stocks_list'] = $this->reports_model->search_stocks($search);
		$this->data['cat_list'] = $this->product_model->cat_list();
		$this->load->view('template/admin', $this->data);
	}

	public function total_stocks()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/total_stocks';
		$this->load->model('product_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$this->load->model('admin_model', '', TRUE);

		$this->data['cat_list'] = $this->product_model->cat_list();
		$this->data['station_list'] = $this->users_model->station_list();
		$this->data['source_list'] = $this->admin_model->source_list();
		$this->load->view('template/admin', $this->data);
	}
	public function get_total_stock(){
		$this->load->model('reports_model', '', TRUE);
		if($this->input->post('date')){
			$date = explode(' - ',$this->input->post('date'));
			$from = $date[0];
			$to = $date[1];
		}else{
			$from = '';
			$to = '';
		}
		$source_id = $this->input->post('source_id');
		$remaining_stock = $this->input->post('remaining_stock');
		$cat_id = $this->input->post('cat_id');
		$station = $this->input->post('station_id');
		$data = new stdClass();
		$data->list = $this->reports_model->total_stocks($remaining_stock,$from,$to,$cat_id,$station,$source_id);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function per_brgy()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/per_brgy';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$disposed_from = $this->input->post('disposed_from');
		$disposed_to = new DateTime($this->input->post('disposed_to'));
		$disposed_to->modify('+1 day');
		$station = $this->input->post('station_id');
		//$this->data['brand_list'] = $this->product_model->brand_list();
		//$this->data['product_drop_list'] = $this->product_model->product_drop_list();
		//$this->data['unit_list'] = $this->product_model->unit_list();
		$this->data['stocks_list'] = $this->reports_model->per_brgy($disposed_from,$disposed_to->format('Y-m-d'),$station);
		$this->data['brgy']= $this->input->post('brgy');
		$this->data['from'] = $disposed_from;
		$this->data['to'] = $this->input->post('disposed_to');
		$this->data['station_list'] = $this->users_model->station_list();
		if($station!=""){
		$station_name = $this->users_model->get_station($station);
		$this->data['station_name'] = $station_name['0']->brgy;
		}
		$this->load->view('template/admin', $this->data);
	}
	public function per_station()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/per_station';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$disposed_from = $this->input->post('disposed_from');
		$disposed_to = new DateTime($this->input->post('disposed_to'));
		$disposed_to->modify('+1 day');
		//$this->data['brand_list'] = $this->product_model->brand_list();
		//$this->data['product_drop_list'] = $this->product_model->product_drop_list();
		//$this->data['unit_list'] = $this->product_model->unit_list();
		$this->data['stocks_list'] = $this->reports_model->per_station($disposed_from,$disposed_to->format('Y-m-d'));
		$this->data['brgy']= $this->input->post('brgy');
		$this->data['from'] = $disposed_from;
		$this->data['to'] = $this->input->post('disposed_to');
		$this->load->view('template/admin', $this->data);
	}
	public function sales_reports()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->load->model('disposal_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('expenses_model', '', TRUE);
		$this->data['content'] = 'reports/reports';
		$this->data['product_list'] = $this->product_model->product_list();
		$this->data['customers_list'] = $this->clients_model->get_clients_list();
		$this->data['product_id'] = $this->input->post('product_id');
		$this->data['remarks'] = $this->input->post('remarks');
		$this->data['customers_id'] = $this->input->post('customers_id');
		$search_data = new stdClass();
		$search = $this->input->post('submit');
		if($search == 'Search'){
		$this->data['date_from'] = $this->input->post('date_from');
		$this->data['date_to'] = $this->input->post('date_to');
		$search_data->date_from = $this->input->post('date_from');
		$search_data->date_to = $this->input->post('date_to');
		$search_data->product_id = $this->input->post('product_id');
		$search_data->remarks = $this->input->post('remarks');
		$search_data->sold_to = $this->input->post('customers_id');
		//display sales
		$this->data['search_history'] = $this->reports_model->search_history_active($search_data);
		//get highest spender
		$this->data['sum_history'] = $this->reports_model->sum_history_active($search_data);
		//get highest points used
		$this->data['sum_points'] = $this->reports_model->sum_points_active($search_data);
		//get highest product sales
		$this->data['sum_product'] = $this->reports_model->sum_product_active($search_data);
		//get expense list
		$this->data['expenses_list'] = $this->reports_model->search_expenses_active($search_data);
		}
		else
		{
		$search_data->date_from = date("Y-m-01 00:00:00");
		$search_data->date_to = date("Y-m-t 23:59:59");
		$this->data['date_from'] = $search_data->date_from;
		$this->data['date_to'] = $search_data->date_to;
		$this->data['search_history'] = $this->reports_model->search_history($search_data);
		//get highest spender
		$this->data['sum_history'] = $this->reports_model->sum_history($search_data);
		//get highest points used
		$this->data['sum_points'] = $this->reports_model->sum_points($search_data);
		//get highest product sales
		$this->data['sum_product'] = $this->reports_model->sum_product($search_data);
		//get expense list
		$this->data['expenses_list'] = $this->reports_model->search_expenses($search_data);
		}


		$this->load->view('template/admin', $this->data);
	
	}
	public function wastes()
	{
		$this->load->model('disposal_model', '', TRUE);
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$this->data['product_list'] = $this->disposal_model->product_list();
		$this->data['clients_list'] = $this->clients_model->get_clients_list();
		$this->data['users_list'] = $this->disposal_model->users_list();
		$this->data['station_list'] = $this->users_model->station_list();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/wastes';

		$search = $this->input->post('submit');
		if($search == 'Search'){
		$search_data = new stdClass();
		$search_data->date_from = $this->input->post('date_from');
		$search_data->date_to = $this->input->post('date_to');
		$search_data->product_id = $this->input->post('product_id');
		$search_data->remarks = $this->input->post('remarks');
		$search_data->added_by = $this->input->post('disposed_by');
		$search_data->station = $this->input->post('station_id');
		$this->data['history'] = $this->reports_model->wastes_list($search_data);
		$this->data['search_data'] = $search_data;
		}
		$this->load->view('template/admin', $this->data);
	}
	public function transfer_history()
	{
		$this->load->model('disposal_model', '', TRUE);
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$this->data['product_list'] = $this->disposal_model->product_list();
		$this->data['clients_list'] = $this->clients_model->get_clients_list();
		$this->data['station_list'] = $this->users_model->station_list();
		$this->data['users_list'] = $this->disposal_model->users_list();
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/station_transfer';
		$this->data['station_list'] = $this->users_model->station_list();

		$search = $this->input->post('submit');
		if($search == 'Search'){
		$search_data = new stdClass();
		$search_data->date_from = $this->input->post('date_from');
		$search_data->date_to = $this->input->post('date_to');
		$search_data->product_id = $this->input->post('product_id');
		$search_data->remarks = $this->input->post('remarks');
		$search_data->sold_to = $this->input->post('clients_id');
		$search_data->disposed_by = $this->input->post('disposed_by');
		$search_data->gender = $this->input->post('gender');
		$search_data->station = $this->input->post('station_id');
		$search_data->sold_to = $this->input->post('to_station_id');
		$this->data['history'] = $this->reports_model->transfer_history_search($search_data);
		$this->data['search_data'] = $search_data;
		}
		$this->load->view('template/admin', $this->data);
	}

	public function monthly_disposal()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/monthly_disposal';
		$this->load->model('disposal_model', '', TRUE);
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('product_model', '', TRUE);
		$this->load->model('users_model', '', TRUE);
		$search = new stdClass();
		$search->from =  date("Y-m-01", strtotime($this->input->post('disposed_from')) );
		$search->to =  date("Y-m-t", strtotime($this->input->post('disposed_to')) );
		$search->station = $this->input->post('station_id');
		$search->product_id = $this->input->post('product_id');
		$this->data['product_list'] = $this->disposal_model->product_list();
		$this->data['total_list'] = $this->reports_model->monthly_disposal($search);
		//$this->data['brgy']= $this->input->post('brgy');
		$this->data['from'] = date("F Y", strtotime($this->input->post('disposed_from')));
		$this->data['to'] = date("F Y", strtotime($this->input->post('disposed_to')));
		$this->data['station_list'] = $this->users_model->station_list();
		$this->data['station_count'] = count($search->station);
		$this->data['med_count'] = count($search->product_id);
		//$station_name = $this->reports_model->get_station($search->station);
		//$this->data['station_name'] = $station_name;
		$this->load->view('template/admin', $this->data);
	}
	
	public function morbidity()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/morbidity';
		$this->data['month'] = $this->input->post('date');
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$this->data['diagnosis'] = $this->general_model->list('diagnosis');
		$this->data['icd_group'] = $this->general_model->list('icd_group');
		$this->data['health_station'] = $this->clients_model->health_station();
		$this->load->view('template/admin', $this->data);
	}

	public function get_morbidity(){
		$this->load->model('reports_model', '', TRUE);
		$search = new stdClass();
		$search->date_from =  (!empty($this->input->post('date')))?date("Y-m-01", strtotime($this->input->post('date')) ):'';
		$time = strtotime($search->date_from);
		$search->date_to =  (!empty($this->input->post('date')))?date("Y-m-d",strtotime("+1 month", $time)):'';
		$search->poc =  (!empty($this->input->post('poc')))?$this->input->post('poc'):'';
		$search->icd_group =  (!empty($this->input->post('icd_group')))?$this->input->post('icd_group'):'';
		$search->selected_diagnosis =  (!empty($this->input->post('selected_diagnosis')))?$this->input->post('selected_diagnosis'):'';
		$data = new stdClass();
		$data->morbidity_list = $this->reports_model->morbidity($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}
	
	public function immunization()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/immunization';
		$this->data['month'] = $this->input->post('date');
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$this->data['vaccine'] = $this->general_model->list('vaccine');
		$this->data['health_station'] = $this->clients_model->health_station();
		$this->load->view('template/admin', $this->data);
	}

	public function get_immunization(){
		$this->load->model('reports_model', '', TRUE);
		$search = new stdClass();
		$search->date_from =  (!empty($this->input->post('date')))?date("Y-m-01", strtotime($this->input->post('date')) ):'';
		$time = strtotime($search->date_from);
		$search->date_to =  (!empty($this->input->post('date')))?date("Y-m-d",strtotime("+1 month", $time)):'';
		$search->poi =  (!empty($this->input->post('poi')))?$this->input->post('poi'):'';
		$search->selected_antigen =  (!empty($this->input->post('selected_antigen')))?$this->input->post('selected_antigen'):'';
		$data = new stdClass();
		$data->immunization_list = $this->reports_model->immunization($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function client_count()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/client_count';
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$this->data['health_station'] = $this->clients_model->health_station();
		$this->load->view('template/admin', $this->data);
	}

	public function get_client_count(){
		$this->load->model('reports_model', '', TRUE);
		$search = new stdClass();
		$date = explode(" - ",$this->input->post('date'));

		$search->group_by = $this->input->post('group_by');
		$search->date_from =  $date[0];
		$search->date_to =  $date[1];
		$search->poc =  (!empty($this->input->post('poc')))?$this->input->post('poc'):'';
		$data = new stdClass();
		$data->date['date'] = $this->input->post('date');
		$data->date['from'] =  date("M d, Y", strtotime($date[0]));
		$data->date['to'] = date("M d, Y", strtotime($date[1]));
		$data->date['date1'] =  $date[0];
		$data->date['date2'] = $date[1];
		$data->view = $this->input->post('group_by');
		$data->client_count = $this->reports_model->client_count($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function print_morbidity()
	{
		$this->data['content'] = 'reports/print/morbidity';
		$this->data['month'] = $this->input->get('date');
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$search = new stdClass();
		$search->date_from =  (!empty($this->input->post('date')))?date("Y-m-01", strtotime($this->input->post('date')) ):'';
		$time = strtotime($search->date_from);
		$search->date_to =  (!empty($this->input->post('date')))?date("Y-m-d",strtotime("+1 month", $time)):'';
		$search->poc =  (!empty($this->input->post('poc')))?$this->input->post('poc'):'';
		$search->icd_group =  (!empty($this->input->post('icd_group')))?$this->input->post('icd_group'):'';
		$search->selected_diagnosis =  (!empty($this->input->post('selected_diagnosis')))?$this->input->post('selected_diagnosis'):'';
		$this->data['poc'] = $search->poc;
		$this->data['month'] = date("F Y", strtotime($this->input->post('date')));
		$this->data['station'] = $this->general_model->get_one_row('health_station','station_id',$search->poc);
		$this->data['morbidity_list'] = $this->reports_model->morbidity($search);
		$this->load->view('template/print_head', $this->data);
	}


	public function print_ncdCase()
	{
		$this->load->model('reports_model', '', TRUE);
		$date = $this->input->post('date');
		$poc = $this->input->post('poc');
		$sel_diag = $this->input->post('selected_diagnosis');
		$station_id = $this->input->post('station_id');
		

		$this->data['content'] = 'reports/print/ncd_case';
		$this->data['month'] = $this->input->get('date');
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$search = new stdClass();
		$search->from =  (!empty($date))?date("Y-m-01", strtotime($date) ):'';
		$time = strtotime($search->from);
		$search->to =  (!empty($date))?date("Y-m-d",strtotime("+1 month", $time)):'';
		$search->station_id =  (!empty($station_id))?$station_id:'';
		$search->selected_diagnosis =  (!empty($sel_diag))?$sel_diag:'';
		$this->data['poc'] = $search->station_id;
		$this->data['month'] = date("F Y", strtotime($date));
		$this->data['station'] = $this->general_model->get_one_row('health_station','station_id',$search->station_id);
		$this->data['ncd_list'] = $this->reports_model->get_ncdCase($search);
		$this->load->view('template/print_head', $this->data);
	}

	public function print_immunization()
	{
		$this->data['content'] = 'reports/print/immunization';
		$this->data['month'] = $this->input->get('date');
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$search = new stdClass();
		$search->date_from =  (!empty($this->input->post('date')))?date("Y-m-01", strtotime($this->input->post('date')) ):'';
		$time = strtotime($search->date_from);
		$search->date_to =  (!empty($this->input->post('date')))?date("Y-m-d",strtotime("+1 month", $time)):'';
		$search->poi =  (!empty($this->input->post('poi')))?$this->input->post('poi'):'';
		$search->selected_antigen =  (!empty($this->input->post('selected_antigen')))?$this->input->post('selected_antigen'):'';
		$this->data['poc'] = $search->poi;
		$this->data['month'] = date("F Y", strtotime($this->input->post('date')));
		$this->data['station'] = $this->general_model->get_one_row('health_station','station_id',$search->poi);
		$this->data['immunization_list'] = $this->reports_model->immunization($search);
		$this->load->view('template/print_head', $this->data);
	}

	public function print_client_count()
	{
		$this->data['content'] = 'reports/print/client_count';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$search = new stdClass();
		$date = explode(" - ",$this->input->post('date'));

		$search->group_by = $this->input->post('group_by');
		$search->date_from =  $date[0];
		$search->date_to =  $date[1];
		$search->poc =  (!empty($this->input->post('poc')))?$this->input->post('poc'):'';
		$this->data['from'] = $date[0];
		$this->data['to'] = $date[1];
		$this->data['poc'] = $search->poc;
		$this->data['station'] = $this->general_model->get_one_row('health_station','station_id',$search->poc);
		$this->data['client_count'] = $this->reports_model->client_count($search);
		$this->data['client_count'] = $this->reports_model->client_count($search);
		$this->load->view('template/print_head', $this->data);
	}

	public function ncdCase()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/ncd_case';
		$this->data['month'] = $this->input->post('date');
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$this->data['diagnosis'] = $this->general_model->list('diagnosis');
		$this->data['health_station'] = $this->clients_model->health_station();
		$this->load->view('template/admin', $this->data);
	}

	public function get_ncdCase(){
		$this->load->model('reports_model', '', TRUE);
		$date = $this->input->post('date');
		$poc = $this->input->post('poc');
		$sel_diag = $this->input->post('selected_diagnosis');
		$station_id = $this->input->post('station_id');
		
		$search = new stdClass();
		$search->from =  (!empty($date))?date("Y-m-01", strtotime($date) ):'';
		$time = strtotime($search->from);
		$search->to =  (!empty($date))?date("Y-m-d",strtotime("+1 month", $time)):'';
		$search->station_id =  (!empty($station_id))?$station_id:'';
		$search->selected_diagnosis =  (!empty($sel_diag))?$sel_diag:'';

		$data = new stdClass();
		$data->ncd_list = $this->reports_model->get_ncdCase($search);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function consultation_summary()
	{
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'reports/consultation_summary';
		$this->data['month'] = $this->input->post('date');
		$this->load->model('clients_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$this->data['health_station'] = $this->clients_model->health_station();
		$this->data['mop_list'] = $this->general_model->list('mop');
		$this->load->view('template/admin', $this->data);
	}

	public function get_cs(){
		$this->load->model('reports_model', '', TRUE);
		$date = explode(" - ",$this->input->post('date'));
		$payment_type = $this->input->post('payment_type');
		$mop_id = $this->input->post('mop_id');
		
		$search = new stdClass();
		$search->from = $date[0];
		$search->to = $date[1];
		$search->payment_type = $payment_type;
		$search->mop_id = $mop_id;

		$data = new stdClass();
		$data->cs_list = $this->reports_model->get_cs($search);
		$data->date['from'] = $date[0];
		$data->date['to'] = $date[1];
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function print_consultation_summary()
	{		
		$this->data['content'] = 'reports/print/consultation_summary';
		$this->load->model('reports_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);

		$date = explode(" - ",$this->input->post('date'));
		$payment_type = $this->input->post('payment_type');
		$mop_id = $this->input->post('mop_id');

		$search = new stdClass();
		$search->from = $date[0];
		$search->to = $date[1];
		$search->payment_type = $payment_type;
		$search->mop_id = $mop_id;

		$search->poc =  (!empty($this->input->post('poc')))?$this->input->post('poc'):'';
		$this->data['from'] = $date[0];
		$this->data['to'] = $date[1];
		$this->data['station'] = $this->general_model->get_one_row('health_station','station_id',$search->poc);
		$this->data['cs_list'] = $this->reports_model->get_cs($search);
		$this->data['payment_type'] = $payment_type;
		$this->load->view('template/print_head', $this->data);
	}


}
