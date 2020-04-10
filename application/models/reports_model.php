<?php
	class reports_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function stocks($data){
			$this->db->select('a.*, b.supplier_price,b.product_id,b.investment,b.exp_date,b.stock_date,b.stock_quantity,b.quantity_sold,c.category,d.preparation,e.type');
			$this->db->from('product a');
			$this->db->join('stocks b', 'b.product_id = a.product_id');
			$this->db->join('category c', 'c.cat_id = a.cat_id','LEFT');
			$this->db->join('preparation d', 'd.prep_id = a.prep_id','LEFT');
			$this->db->join('type e', 'e.type_id = a.type_id','LEFT');
			//$this->db->group_by('a.brand_name, a.product_name');
			//$this->db->where("b.product_id", $product_id); 
			return $this->db->get()->result_object(); 
		}

		public function search_stocks($data){
			$this->db->select('a.*, b.supplier_price,b.product_id,b.investment,b.exp_date,b.stock_date,b.stock_quantity,b.quantity_sold,c.category,d.preparation,e.type,f.brgy as station,g.source');
			$this->db->from('product a');
			$this->db->join('stocks b', 'b.product_id = a.product_id');
			$this->db->join('category c', 'c.cat_id = a.cat_id','LEFT');
			$this->db->join('preparation d', 'd.prep_id = a.prep_id','LEFT');
			$this->db->join('type e', 'e.type_id = a.type_id','LEFT');
			$this->db->join('health_station f', 'f.station_id = b.stock_station','LEFT');
			$this->db->join('source g', 'g.source_id = b.source','LEFT');
			//$this->db->group_by('a.brand_name, a.product_name');
			if($data->exp_from!=''){
			$this->db->where("b.exp_date >=", $data->exp_from); 
			}
			if($data->exp_to!=''){
			$this->db->where("b.exp_date <=", $data->exp_to); 
			}
			if($data->stock_from!=''){
			$this->db->where("b.stock_date >=", $data->stock_from); 
			}
			if($data->stock_to!=''){
			$this->db->where("b.stock_date <=", $data->stock_to); 
			}
			if($data->cat_id!=''){
			$this->db->where("a.cat_id =", $data->cat_id); 
			}
			if($data->product_name!=''){
			$this->db->LIKE("a.product_name", $data->product_name); 
			}
			if($data->station_id!=''){
			$this->db->LIKE("b.stock_station", $data->station_id); 
			}
			if($data->remaining_stock!=''){
			$this->db->where("b.remaining_stock <=", $data->remaining_stock); 
			}
			return $this->db->get()->result_object(); 
		}

		public function total_stocks($remaining_stock,$from,$to,$cat_id,$station,$source_id){
			$sql='';
			$sql2='';
			//add where query to array
			$where = array();
			if($from){
			    $where[] = "d.date_sold >= '".$from."'";
			}
			if($to){
			    $where[] = "d.date_sold <= '".$to."'";
			}
			if($source_id){
			    $where[] = "s.source = '".$source_id."'";
			}
			if($station){
			    $where[] = "s.stock_station = '".$station."'";
			}
			// add AND to sql in between where if more than 1 where else add where array to sql directly
			if ( sizeof($where) > 0 ) {
		    	$sql .= implode(' AND ', $where);   
			}else{
			 	$sql = $where;
			}
			//add where query to array 
			$where2 = array();
			if($source_id){
			    $where2[] = "source = '".$source_id."'";
			}
			if($station){
			    $where2[] = "stock_station = '".$station."'";
			}
			// add AND to sql in between where if more than 1 where else add where array to sql directly
			if ( sizeof($where2) > 0 ) {
		    	$sql2 .= implode(' AND ', $where2);   
			}else{
			 	$sql2 = $where2;
			}

			$this->db->select('p.*, ca.category, t.type,prep.preparation,rstock,
							SUM(CASE WHEN c.gender = "FEMALE" THEN d.quantity ELSE 0 END) AS female_quantity,
							SUM(CASE WHEN c.gender = "MALE" THEN d.quantity ELSE 0 END) AS male_quantity,
							SUM(Coalesce(d.quantity, 0)) AS total_disposed
							');
			$this->db->from('product p');
			$this->db->join('category ca', 'ca.cat_id = p.cat_id','LEFT');
			$this->db->join('type t', 't.type_id = p.type_id','LEFT');
			$this->db->join('preparation prep', 'prep.prep_id = p.prep_id','LEFT');

			$rstockQuery = ''; 
			$stockQuery = 'select source,product_id, stock_id from stocks'; 

			//if where has value set where parameters
			if(sizeof($where2) > 0){
			$this->db->join('(select source,product_id, sum(remaining_stock) as rstock from stocks WHERE '.$sql2.' group by product_id) s', 's.product_id = p.product_id','LEFT');
			$this->db->join('(select source,product_id, stock_id from stocks WHERE '.$sql2.') ss', 'ss.product_id = p.product_id','INNER');
			//if where array do not have value
			}else{
			$this->db->join('(select source,product_id, sum(remaining_stock) as rstock from stocks  group by product_id) s', 's.product_id = p.product_id','LEFT');
			}

			//if where has value set where parameters
			if(sizeof($where) > 0){
				$this->db->join('(select s.source, d.stock_id as sid, d.product_id, d.quantity, d.sold_to,d.date_sold from disposal d LEFT JOIN stocks s ON d.stock_id = s.stock_id WHERE '.$sql.') d', 'd.product_id = p.product_id','LEFT');
			//if where array do not have value
			}else{
				$this->db->join('(select s.source, d.stock_id as sid, d.product_id, d.quantity, d.sold_to from disposal d LEFT JOIN stocks s ON d.stock_id = s.stock_id) d', 'd.product_id = p.product_id','LEFT');
			}
			$this->db->join('clients c', 'c.clients_id = d.sold_to','LEFT');
			if($cat_id!=''){
				$this->db->where('p.cat_id',$cat_id);
			}
			if($remaining_stock!=''){
				$this->db->where('rstock <=',$remaining_stock);
			}
			$this->db->group_by('p.product_id');
			//$query = $this->db->get();
			//echo $this->db->last_query();
			//exit();
			return $this->db->get()->result_object(); 
		}



		public function per_brgy($from,$to,$station){
			$this->db->select('a.*,e.preparation,sum(d.quantity) as total_disposed,
				SUM(CASE WHEN c.brgy = "Anos" THEN d.quantity ELSE 0 END) AS anos,
				SUM(CASE WHEN c.brgy = "Bagong Silang" THEN d.quantity ELSE 0 END) AS bs,
				SUM(CASE WHEN c.brgy = "Bambang" THEN d.quantity ELSE 0 END) AS bambang,
				SUM(CASE WHEN c.brgy = "Batong Malake" THEN d.quantity ELSE 0 END) AS bm,
				SUM(CASE WHEN c.brgy = "Baybayin" THEN d.quantity ELSE 0 END) AS baybayin,
				SUM(CASE WHEN c.brgy = "Bayog" THEN d.quantity ELSE 0 END) AS bayog,
				SUM(CASE WHEN c.brgy = "Lalakay" THEN d.quantity ELSE 0 END) AS lalakay,
				SUM(CASE WHEN c.brgy = "Maahas" THEN d.quantity ELSE 0 END) AS maahas,
				SUM(CASE WHEN c.brgy = "Mayondon" THEN d.quantity ELSE 0 END) AS mayondon,
				SUM(CASE WHEN c.brgy = "Malinta" THEN d.quantity ELSE 0 END) AS malinta,
				SUM(CASE WHEN c.brgy = "Tuntungin-Putho" THEN d.quantity ELSE 0 END) AS tp,
				SUM(CASE WHEN c.brgy = "San Antonio" THEN d.quantity ELSE 0 END) AS sa,
				SUM(CASE WHEN c.brgy = "Tadlac" THEN d.quantity ELSE 0 END) AS tadlac,
				SUM(CASE WHEN c.brgy = "Timugan" THEN d.quantity ELSE 0 END) AS timugan
				');
			$this->db->from('product a');
			//$this->db->join('stocks b', 'b.product_id = a.product_id');
			if($station !=""){
			$this->db->join('(select * from disposal where date_sold >= "'.$from.'" AND date_sold <= "'.$to.'" AND station = "'.$station.'" )d', 'd.product_id = a.product_id','LEFT OUTER');
			}
			else{
			$this->db->join('(select * from disposal where date_sold >= "'.$from.'" AND date_sold <= "'.$to.'")d', 'd.product_id = a.product_id','LEFT OUTER');
			}
			$this->db->join('clients c', 'c.clients_id = d.sold_to','LEFT OUTER');
			$this->db->join('preparation e', 'e.prep_id = a.prep_id','LEFT');
			$this->db->group_by('a.prep_id, a.product_name');
			//$query = $this->db->get('product_entity');
			//echo $this->db->last_query();
			//exit();
			//$this->db->where("b.product_id", $product_id); 
			return $this->db->get()->result_object(); 
		}

		public function per_station($from,$to){
			$this->db->select('a.*,e.preparation,sum(d.quantity) as total_disposed,
				SUM(CASE WHEN c.brgy = "Anos" THEN d.quantity ELSE 0 END) AS anos,
				SUM(CASE WHEN c.brgy = "Bagong Silang" THEN d.quantity ELSE 0 END) AS bs,
				SUM(CASE WHEN c.brgy = "Bambang" THEN d.quantity ELSE 0 END) AS bambang,
				SUM(CASE WHEN c.brgy = "Batong Malake" THEN d.quantity ELSE 0 END) AS bm,
				SUM(CASE WHEN c.brgy = "Baybayin" THEN d.quantity ELSE 0 END) AS baybayin,
				SUM(CASE WHEN c.brgy = "Bayog" THEN d.quantity ELSE 0 END) AS bayog,
				SUM(CASE WHEN c.brgy = "Lalakay" THEN d.quantity ELSE 0 END) AS lalakay,
				SUM(CASE WHEN c.brgy = "Maahas" THEN d.quantity ELSE 0 END) AS maahas,
				SUM(CASE WHEN c.brgy = "Mayondon" THEN d.quantity ELSE 0 END) AS mayondon,
				SUM(CASE WHEN c.brgy = "Malinta" THEN d.quantity ELSE 0 END) AS malinta,
				SUM(CASE WHEN c.brgy = "Tuntungin-Putho" THEN d.quantity ELSE 0 END) AS tp,
				SUM(CASE WHEN c.brgy = "San Antonio" THEN d.quantity ELSE 0 END) AS sa,
				SUM(CASE WHEN c.brgy = "Tadlac" THEN d.quantity ELSE 0 END) AS tadlac,
				SUM(CASE WHEN c.brgy = "Timugan" THEN d.quantity ELSE 0 END) AS timugan
				');
			$this->db->from('product a');
			//$this->db->join('stocks b', 'b.product_id = a.product_id');
			$this->db->join('(select * from disposal_station where date_sold >= "'.$from.'" AND date_sold <= "'.$to.'"  )d', 'd.product_id = a.product_id','LEFT OUTER');
			$this->db->join('health_station c', 'c.station_id = d.sold_to','LEFT OUTER');
			$this->db->join('preparation e', 'e.prep_id = a.prep_id','LEFT');
			$this->db->group_by('a.prep_id, a.product_name');
			//$query = $this->db->get('product_entity');
			//echo $this->db->last_query();
			//exit();
			//$this->db->where("b.product_id", $product_id); 
			return $this->db->get()->result_object(); 
		}

		public function search_history_active($data){
			$this->db->select('a.disposal_id, a.stock_id, a.quantity, a.price_sold, a.date_sold,a.transaction_id,a.sold_to,a.used_points,a.remarks, b.product_id as p_id, b.product_name, b.brand_name, b.unit, c.product_id, c.supplier_price, d.clients_id,d.fname,d.lname');
			$this->db->from('disposal a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id');
			$this->db->join('clients d', 'd.clients_id = a.sold_to','LEFT');
			$this->db->order_by("disposal_id", "desc");
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.date_sold >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.date_sold <=', $date_to);
			}
			if($data->product_id != ""){
			$this->db->where('b.product_id', $data->product_id);
			}
			if($data->remarks != ""){
			$this->db->like('a.remarks', $data->remarks);
			}
			if($data->sold_to != ""){
			$this->db->where('a.sold_to', $data->sold_to);
			}
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}

		public function search_history($data){
			$this->db->select('a.disposal_id, a.stock_id, a.quantity, a.price_sold, a.date_sold,a.transaction_id,a.sold_to,a.used_points,a.remarks, b.product_id as p_id, b.product_name, b.brand_name, b.unit, c.product_id, c.supplier_price, d.clients_id,d.fname,d.lname');
			$this->db->from('disposal a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id');
			$this->db->join('clients d', 'd.clients_id = a.sold_to','LEFT');
			$this->db->order_by("disposal_id", "desc");
			$this->db->WHERE('a.date_sold >=',$data->date_from);
			$this->db->where('a.date_sold <=', $data->date_to);
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}

		public function sum_points_active($data){
			$query = "SELECT SUM(disposal.used_points) as most_used_points, disposal.sold_to, disposal.date_sold, b.fname,b.lname,b.clients_id  FROM (select * from disposal GROUP BY transaction_id) disposal JOIN `clients` `b` ON `b`.`clients_id` = `disposal`.`sold_to`  WHERE `date_sold` >= '.$data->date_from.' AND `date_sold` <= '$data->date_to' group by disposal.sold_to ";
			$query = $this->db->query($query);
			$result = $query->result();
			return	$result;
		}
		public function sum_points($data){
			$query = "SELECT SUM(disposal.used_points) as most_used_points, disposal.sold_to, disposal.date_sold, b.fname,b.lname,b.clients_id  FROM (select * from disposal GROUP BY transaction_id) disposal JOIN `clients` `b` ON `b`.`clients_id` = `disposal`.`sold_to`  WHERE `date_sold` >= '.$data->date_from.' AND `date_sold` <= '$data->date_to' group by disposal.sold_to ";
			$query = $this->db->query($query);
			$result = $query->result();
			return	$result;
		}
		public function sum_history_active($data){
			$this->db->select('a.disposal_id, a.stock_id,a.transaction_id, a.quantity, SUM(a.price_sold) AS total_per_user , a.date_sold,a.sold_to,SUM(a.used_points) AS most_used_points,d.clients_id,d.fname,d.lname');
			$this->db->from('disposal a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id');
			$this->db->join('clients d', 'd.clients_id = a.sold_to','LEFT');
			$this->db->order_by("disposal_id", "desc");
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.date_sold >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.date_sold <=', $date_to);
			}
			if($data->remarks != ""){
			$this->db->like('a.remarks', $data->remarks);
			}
			if($data->sold_to != ""){
			$this->db->where('a.sold_to', $data->sold_to);
			}
			$this->db->group_by('a.sold_to');
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
		public function sum_history($data){
			$this->db->select('a.disposal_id, a.stock_id,a.transaction_id, a.quantity, SUM(a.price_sold) AS total_per_user , a.date_sold,a.sold_to,SUM(a.used_points) AS most_used_points,d.clients_id,d.fname,d.lname');
			$this->db->from('disposal a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id');
			$this->db->join('clients d', 'd.clients_id = a.sold_to','LEFT');
			$this->db->order_by("disposal_id", "desc");
			$this->db->WHERE('a.date_sold >=',$data->date_from);
			$this->db->where('a.date_sold <=', $data->date_to);
			$this->db->group_by('a.sold_to');
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
		public function sum_product_active($data){
			$this->db->select('a.disposal_id, a.stock_id, SUM(a.quantity) as total_quantity, SUM(a.price_sold) AS total_price, a.date_sold,a.sold_to,d.clients_id,d.fname,d.lname,b.product_id as p_id, b.product_name, b.brand_name, b.unit');
			$this->db->from('disposal a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id');
			$this->db->join('clients d', 'd.clients_id = a.sold_to','LEFT');
			$this->db->order_by("disposal_id", "desc");
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.date_sold >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.date_sold <=', $date_to);
			}
			if($data->product_id != ""){
			$this->db->where('b.product_id', $data->product_id);
			}
			if($data->remarks != ""){
			$this->db->like('a.remarks', $data->remarks);
			}
			if($data->sold_to != ""){
			$this->db->where('a.sold_to', $data->sold_to);
			}
			$this->db->group_by('b.product_id');
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
		public function sum_product($data){
			$this->db->select('a.disposal_id, a.stock_id, SUM(a.quantity) as total_quantity, SUM(a.price_sold) AS total_price, a.date_sold,a.sold_to,d.clients_id,d.fname,d.lname,b.product_id as p_id, b.product_name, b.brand_name, b.unit');
			$this->db->from('disposal a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id');
			$this->db->join('clients d', 'd.clients_id = a.sold_to','LEFT');
			$this->db->order_by("disposal_id", "desc");
			$this->db->WHERE('a.date_sold >=',$data->date_from);
			$this->db->where('a.date_sold <=', $data->date_to);
			$this->db->group_by('b.product_id');
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
		public function search_expenses_active($data){
			$this->db->select('type,details,amount,date');
			$this->db->from('expenses');
			$this->db->order_by("date", "desc");
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('date >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('date <=', $date_to);
			}
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
		public function search_expenses($data){
			$this->db->select('type,details,amount,date');
			$this->db->from('expenses');
			$this->db->order_by("date", "desc");
			$this->db->WHERE('date >=',$data->date_from);
			$this->db->where('date <=', $data->date_to);
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
		public function wastes_list($data){
			$this->db->select('a.waste_id,a.product_id, a.stock_id, a.quantity, a.date_wasted,a.added_by,a.reason, b.product_id as p_id, b.product_name,e.fname as dfname, e.lname as dlname,f.preparation,g.category,h.type,i.brgy as station');
			$this->db->from('wastes a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id','LEFT');
			$this->db->join('users e', 'e.userid = a.added_by','LEFT');
			$this->db->join('preparation f', 'f.prep_id = b.prep_id','LEFT');
			$this->db->join('category g', 'g.cat_id = b.cat_id','LEFT');
			$this->db->join('type h', 'h.type_id = b.type_id','LEFT');
			$this->db->join('health_station i', 'i.station_id = a.station','LEFT');
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.date_wasted >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.date_wasted <=', $date_to);
			}
			if($data->product_id != ""){
			$this->db->where('b.product_id', $data->product_id);
			}
			if($data->remarks != ""){
			$this->db->like('a.reason', $data->remarks);
			}
			if($data->added_by != ""){
			$this->db->where('a.added_by', $data->added_by);
			}
			if($data->station != ""){
			$this->db->where('a.station', $data->station);
			}
			$this->db->order_by("waste_id", "desc");
			//$this->db->group_by("d.gender,a.product_id");
			$query = $this->db->get();

			return $query->result();
		}
		public function transfer_history_search($data){
			$this->db->select('a.disposal_id,a.product_id, a.stock_id, a.quantity, a.date_sold,a.transaction_id,a.sold_to,a.remarks, b.product_id as p_id, b.product_name, c.product_id, c.supplier_price,d.brgy as transfered_station,e.fname as dfname, e.lname as dlname,f.preparation,g.category,h.type,i.brgy as station');
			$this->db->from('disposal_station a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id','LEFT');
			$this->db->join('health_station d', 'd.station_id = a.sold_to','LEFT');
			$this->db->join('users e', 'e.userid = a.disposed_by','LEFT');
			$this->db->join('preparation f', 'f.prep_id = b.prep_id','LEFT');
			$this->db->join('category g', 'g.cat_id = b.cat_id','LEFT');
			$this->db->join('type h', 'h.type_id = b.type_id','LEFT');
			$this->db->join('health_station i', 'i.station_id = a.station','LEFT');
			if($data->date_from != ""){
				$date_from = date('Y-m-d H:i:s', strtotime($data->date_from." 00:00:00")); 
				$this->db->WHERE('a.date_sold >=',$date_from);
			}
			if($data->date_to != ""){
				$date_to = date('Y-m-d H:i:s', strtotime($data->date_to." 23:59:59"));
				$this->db->where('a.date_sold <=', $date_to);
			}
			if($data->product_id != ""){
			$this->db->where('b.product_id', $data->product_id);
			}
			if($data->remarks != ""){
			$this->db->like('a.remarks', $data->remarks);
			}
			if($data->sold_to != ""){
			$this->db->where('a.sold_to', $data->sold_to);
			}
			if($data->disposed_by != ""){
			$this->db->where('a.disposed_by', $data->disposed_by);
			}
			if($data->station != ""){
			$this->db->where('a.station', $data->station);
			}
			$this->db->order_by("disposal_id", "desc");
			//$this->db->group_by("d.gender,a.product_id");
			$query = $this->db->get();
			//echo $this->db->last_query();
			//exit()
			return $query->result();
		}
		public function transfer_history(){
			$this->db->select('a.disposal_id,a.product_id, a.stock_id, a.quantity, a.date_sold,a.transaction_id,a.sold_to,a.remarks, b.product_id as p_id, b.product_name, c.product_id, c.supplier_price, d.clients_id,d.fname,d.lname,d.gender,d.brgy,e.fname as dfname, e.lname as dlname,f.preparation,g.category,h.type');
			$this->db->from('disposal_station a');
			$this->db->join('stocks c', 'c.stock_id = a.stock_id');
			$this->db->join('product b', 'b.product_id = c.product_id','LEFT');
			$this->db->join('health_station d', 'd.station_id = a.sold_to','LEFT');
			$this->db->join('users e', 'e.userid = a.disposed_by','LEFT');
			$this->db->join('preparation f', 'f.prep_id = b.prep_id','LEFT');
			$this->db->join('category g', 'g.cat_id = b.cat_id','LEFT');
			$this->db->join('type h', 'h.type_id = b.type_id','LEFT');
			//$this->db->WHERE('a.date_sold >=',$today);
			$this->db->order_by("disposal_id", "desc");
			$query = $this->db->get(); 
			return $query->result();
		}
		public function monthly_disposal($search){
			$start    = (new DateTime($search->from))->modify('first day of this month');
		    $end      = (new DateTime($search->to))->modify('first day of next month');
		    $interval = DateInterval::createFromDateString('1 month');
		    $period   = new DatePeriod($start, $interval, $end);

			//$this->db->select('a.product_id,a.product_name,MONTHNAME(d.date_sold) as month,year(d.date_sold) as year,concat(MONTHNAME(d.date_sold)," ",year(d.date_sold)) as month_year,SUM(d.quantity) as total_quantity,e.preparation');
				/* if needed multiple product in one search switch to this select*/
				
				$sql = 'a.product_id,a.product_name,f.brgy,e.preparation';
                foreach ($period as $dt) {
                	$sql .=', SUM(CASE WHEN d.date_sold BETWEEN "'.$dt->format("Y-m-01").'" AND "'.$dt->format("Y-m-t").'" THEN d.quantity ELSE 0 END) AS '.$dt->format("My");
				}
				$station_sql ='(select * from disposal where date_sold >= "'.$search->from.'" AND date_sold <= "'.$search->to.'" AND (';
				if(count($search->station)!=0){
				foreach($search->station as $key=>$station){
					if($key == '0'){
					$station_sql .= 'station = "'.$station.'"';
					}
					else{
					$station_sql .= 'OR station = "'.$station.'"';
					}
				}
			}
				$station_sql .='))d';

			$this->db->select($sql);
						
			$this->db->from('product a');
			//$this->db->join('stocks b', 'b.product_id = a.product_id');
			if($search->station !=""){
			$this->db->join($station_sql, 'd.product_id = a.product_id','INNER');
			}
			else{
			$this->db->join('(select * from disposal where date_sold >= "'.$search->from.'" AND date_sold <= "'.$search->to.'")d', 'd.product_id = a.product_id','INNER');
			}
			$this->db->join('preparation e', 'e.prep_id = a.prep_id','LEFT');
			$this->db->join('health_station f', 'f.station_id = d.station','LEFT');
			if(count($search->product_id) != '0'){
				foreach($search->product_id as $key=>$product_id){
					if($key == '0'){
					$this->db->WHERE('a.product_id', $product_id);
					}
					else{
					$this->db->OR_WHERE('a.product_id', $product_id);
					}
				}
			}
			$this->db->group_by('a.product_id, d.station');
			//$this->db->get('');echo $this->db->last_query();exit();
			//$this->db->where("b.product_id", $product_id); 
			return $this->db->get()->result_object(); 
		}

		public function morbidity($data){
			$this->db->select('a.*,b.client_id,
							sum(IF(b.yr_old = 0 AND c.gender = "MALE", 1,0)) AS m0,
							sum(IF(b.yr_old = 0 AND c.gender = "FEMALE", 1,0)) AS f0,
							sum(IF((b.yr_old >= 1 AND b.yr_old <= 4) AND c.gender = "MALE", 1,0)) AS m1,
							sum(IF((b.yr_old >= 1 AND b.yr_old <= 4) AND c.gender = "FEMALE", 1,0)) AS f1,
							sum(IF((b.yr_old >= 5 AND b.yr_old <= 9) AND c.gender = "MALE", 1,0)) AS m5,
							sum(IF((b.yr_old >= 5 AND b.yr_old <= 9) AND c.gender = "FEMALE", 1,0)) AS f5,
							sum(IF((b.yr_old >= 10 AND b.yr_old <= 14) AND c.gender = "MALE", 1,0)) AS m10,
							sum(IF((b.yr_old >= 10 AND b.yr_old <= 14) AND c.gender = "FEMALE", 1,0)) AS f10,
							sum(IF((b.yr_old >= 15 AND b.yr_old <= 19) AND c.gender = "MALE", 1,0)) AS m15,
							sum(IF((b.yr_old >= 15 AND b.yr_old <= 19) AND c.gender = "FEMALE", 1,0)) AS f15,
							sum(IF((b.yr_old >= 20 AND b.yr_old <= 24) AND c.gender = "MALE", 1,0)) AS m20,
							sum(IF((b.yr_old >= 20 AND b.yr_old <= 24) AND c.gender = "FEMALE", 1,0)) AS f20,
							sum(IF((b.yr_old >= 25 AND b.yr_old <= 29) AND c.gender = "MALE", 1,0)) AS m25,
							sum(IF((b.yr_old >= 25 AND b.yr_old <= 29) AND c.gender = "FEMALE", 1,0)) AS f25,
							sum(IF((b.yr_old >= 30 AND b.yr_old <= 34) AND c.gender = "MALE", 1,0)) AS m30,
							sum(IF((b.yr_old >= 30 AND b.yr_old <= 34) AND c.gender = "FEMALE", 1,0)) AS f30,
							sum(IF((b.yr_old >= 35 AND b.yr_old <= 39) AND c.gender = "MALE", 1,0)) AS m35,
							sum(IF((b.yr_old >= 35 AND b.yr_old <= 39) AND c.gender = "FEMALE", 1,0)) AS f35,
							sum(IF((b.yr_old >= 40 AND b.yr_old <= 44) AND c.gender = "MALE", 1,0)) AS m40,
							sum(IF((b.yr_old >= 40 AND b.yr_old <= 44) AND c.gender = "FEMALE", 1,0)) AS f40,
							sum(IF((b.yr_old >= 45 AND b.yr_old <= 49) AND c.gender = "MALE", 1,0)) AS m45,
							sum(IF((b.yr_old >= 45 AND b.yr_old <= 49) AND c.gender = "FEMALE", 1,0)) AS f45,
							sum(IF((b.yr_old >= 50 AND b.yr_old <= 54) AND c.gender = "MALE", 1,0)) AS m50,
							sum(IF((b.yr_old >= 50 AND b.yr_old <= 54) AND c.gender = "FEMALE", 1,0)) AS f50,
							sum(IF((b.yr_old >= 55 AND b.yr_old <= 59) AND c.gender = "MALE", 1,0)) AS m55,
							sum(IF((b.yr_old >= 55 AND b.yr_old <= 59) AND c.gender = "FEMALE", 1,0)) AS f55,
							sum(IF((b.yr_old >= 60 AND b.yr_old <= 64) AND c.gender = "MALE", 1,0)) AS m60,
							sum(IF((b.yr_old >= 60 AND b.yr_old <= 64) AND c.gender = "FEMALE", 1,0)) AS f60,
							sum(IF((b.yr_old >= 65 AND b.yr_old <= 69) AND c.gender = "MALE", 1,0)) AS m65,
							sum(IF((b.yr_old >= 65 AND b.yr_old <= 69) AND c.gender = "FEMALE", 1,0)) AS f65,
							sum(IF(b.yr_old >= 70 AND c.gender = "MALE", 1,0)) AS m70,
							sum(IF(b.yr_old >= 70 AND c.gender = "FEMALE", 1,0)) AS f70,
							sum(IF(c.gender = "MALE", 1,0)) AS mtotal,
							sum(IF(c.gender = "FEMALE", 1,0)) AS ftotal,
							count(a.diagnosis_id) as total
							');
			$this->db->from('diagnosis a');
			$this->db->join('client_diagnosis d','d.diagnosis_id = a.diagnosis_id');
			if($data->poc!='ALL' AND $data->poc!=""){
			$this->db->join('(select vs_id, yr_old, client_id from vital_signs where (dov >= "'.$data->date_from.'" AND dov < "'.$data->date_to.'") AND poc = "'.$data->poc.'") b', 'b.vs_id = d.vs_id');
			}else{
			$this->db->join('(select vs_id, yr_old, client_id from vital_signs where dov >= "'.$data->date_from.'" AND dov < "'.$data->date_to.'") b', 'b.vs_id = d.vs_id');
			}
			$this->db->join('clients c', 'c.clients_id = b.client_id');
			if($data->icd_group){
				foreach($data->icd_group as $val){
					$this->db->or_where('a.icd_group',$val);
				}
			}
			if($data->selected_diagnosis){
				foreach($data->selected_diagnosis as $val){
					$this->db->or_where('a.diagnosis_id',$val);
				}
			}
			$this->db->group_by('a.diagnosis_id');
			$this->db->order_by('total','DESC');
			//$this->db->where("b.product_id", $product_id);
			//$query = $this->db->get();
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function immunization($data){
			$this->db->select('a.*,b.client_id,
							sum(IF(b.yr_old = 0 AND c.gender = "MALE", 1,0)) AS m0,
							sum(IF(b.yr_old = 0 AND c.gender = "FEMALE", 1,0)) AS f0,
							sum(IF(b.yr_old >= 1  AND c.gender = "MALE", 1,0)) AS m1,
							sum(IF(b.yr_old >= 1  AND c.gender = "FEMALE", 1,0)) AS f1,
							sum(IF(c.gender = "MALE", 1,0)) AS mtotal,
							sum(IF(c.gender = "FEMALE", 1,0)) AS ftotal,
							count(a.vac_id) as total
							');
			$this->db->from('vaccine a');
			if($data->poi!='ALL' AND $data->poi!=""){
			$this->db->join('(select * from client_immunization where (date >= "'.$data->date_from.'" AND date < "'.$data->date_to.'") AND poi = "'.$data->poi.'") b', 'b.vac_id = a.vac_id');
			}else{
			$this->db->join('(select * from client_immunization where date >= "'.$data->date_from.'" AND date < "'.$data->date_to.'") b', 'b.vac_id = a.vac_id');
			}
			$this->db->join('clients c', 'c.clients_id = b.client_id');
			if($data->selected_antigen){
				foreach($data->selected_antigen as $val){
					$this->db->or_where('a.vac_id',$val);
				}
			}
			$this->db->group_by('a.vac_id');
			$this->db->order_by('total','DESC');
			//$this->db->where("b.product_id", $product_id);
			//$query = $this->db->get();
			//echo $this->db->last_query();

			return $this->db->get()->result_object(); 
		}

		public function client_count($data){
			$this->db->select('a.dov,DATE_FORMAT(a.dov, "%b&nbsp;%d, %Y") as dov_text,LEFT (a.dov, 7) as yearmonth,
							sum(IF(c.gender = "MALE", 1,0)) AS count_male,
							sum(IF(c.gender = "FEMALE", 1,0)) AS count_female,
							count(a.vs_id) as total
							');
			$this->db->from('vital_signs a');
			$this->db->join('clients c', 'c.clients_id = a.client_id','LEFT');
			$this->db->where('a.dov>=',$data->date_from);
			$this->db->where('a.dov<=',$data->date_to);
			if($data->poc!="" && $data->poc!="ALL"){
				$this->db->where('a.poc',$data->poc);
			}
			if($data->group_by == 'day'){
				$this->db->group_by('a.dov');
			}else{
				$this->db->group_by('yearmonth');
			}
			//$this->db->where("b.product_id", $product_id);
			//$query = $this->db->get();
			//echo $this->db->last_query();
			//exit();
			return $this->db->get()->result_object(); 
		}
		public function get_ncdCase($search){
			$this->db->select('concat(b.lname," ",b.fname," ",", ",b.mname) as fullname, b.philhealth_no, b.birthday, b.gender, b.brgy, c.brgy as station_d, ch.brgy as station_h, a.diagnose_date as diabetes, ah.diagnose_date as hypertension ');
			$this->db->from('clients b');
			$this->db->join('(select * from client_hd where diagnosis = "DIABETES") a','b.clients_id = a.client_id','LEFT');
			$this->db->join('(select * from client_hd where diagnosis = "HYPERTENSION") ah','b.clients_id = ah.client_id','LEFT');
			$this->db->join('health_station c','c.station_id = a.station_id','LEFT');
			$this->db->join('health_station ch','ch.station_id = ah.station_id','LEFT');
			if($search->selected_diagnosis=='1'){
				$this->db->where('a.diagnose_date != ""');
				if($search->from!=''){
					$this->db->group_start();
						$this->db->where('a.diagnose_date >= "'.$search->from.'"');
						$this->db->where('a.diagnose_date <= "'.$search->to.'"');
					$this->db->group_end();
				}
				if($search->station_id!=''){
					$this->db->where('a.station_id',$search->station_id);
				}
			}
			if($search->selected_diagnosis=='2'){
				$this->db->where('ah.diagnose_date != ""');
				if($search->from!=''){
					$this->db->group_start();
						$this->db->where('ah.diagnose_date >= "'.$search->from.'"');
						$this->db->where('ah.diagnose_date <= "'.$search->to.'"');
					$this->db->group_end();
				}
				if($search->station_id!=''){
					$this->db->where('ah.station_id',$search->station_id);
				}
			}
			if($search->selected_diagnosis=='1&2'){
				$this->db->group_start();
					$this->db->where('a.diagnose_date != ""');
					$this->db->where('ah.diagnose_date != ""');
				$this->db->group_end();
				if($search->from!=''){
					$this->db->group_start();
						$this->db->group_start();
							$this->db->where('a.diagnose_date >= "'.$search->from.'"');
							$this->db->where('a.diagnose_date <= "'.$search->to.'"');
						$this->db->group_end();
						$this->db->group_start("OR",false);
							$this->db->where('ah.diagnose_date >= "'.$search->from.'"');
							$this->db->where('ah.diagnose_date <= "'.$search->to.'"');
						$this->db->group_end();
					$this->db->group_end();
				}
				if($search->station_id!=''){
					$this->db->where('a.station_id',$search->station_id);
					$this->db->where('ah.station_id',$search->station_id);
				}
			}
			if($search->selected_diagnosis=='' OR $search->selected_diagnosis=='ALL'){
				$this->db->group_start();
					$this->db->where('a.diagnose_date != ""');
					$this->db->where('ah.diagnose_date != ""');
				$this->db->group_end();

				$this->db->group_start("OR",false);
					$this->db->where('a.diagnose_date != ""');
				$this->db->group_end();

				$this->db->group_start("OR",false);
					$this->db->where('ah.diagnose_date != ""');
				$this->db->group_end();

				if($search->from!=''){
					$this->db->group_start();
						$this->db->where('a.diagnose_date >= "'.$search->from.'"');
						$this->db->where('a.diagnose_date <= "'.$search->to.'"');
					$this->db->group_end();
					$this->db->group_start("OR",false);
						$this->db->where('ah.diagnose_date >= "'.$search->from.'"');
						$this->db->where('ah.diagnose_date <= "'.$search->to.'"');
					$this->db->group_end();
				}
				if($search->station_id!=''){
					$this->db->group_start();
						$this->db->where('a.station_id',$search->station_id);
						$this->db->or_where('ah.station_id',$search->station_id);
					$this->db->group_end();
				}
			}
			//$query = $this->db->get();
			//echo $this->db->last_query();
			//exit();
			return $this->db->get()->result_object(); 
		}
		public function get_cs($data){
			$this->db->select('a.vs_id, a.dov, a.consultation_fee, a.actual_payment, a.hmo_fee, a.hmo_payment, concat(b.lname," ",b.fname," ",", ",b.mname) as fullname, b.gender');
			$this->db->from('vital_signs a');
			$this->db->join('clients b', 'b.clients_id = a.client_id','LEFT');
			$this->db->where('a.status','1');

			if($data->from!=''){
				$this->db->where('a.dov>=',$data->from);
				$this->db->where('a.dov<=',$data->to);
			}
			if($data->mop_id!='' && $data->mop_id!='ALL'){
				if($data->mop_id==1){
				$this->db->where('a.consultation_fee is not null');
					if($data->payment_type=='FREE'){
						$this->db->group_start();
							$this->db->where('a.actual_payment','0');
						$this->db->group_end();
					}
					if($data->payment_type=='PAYED'){
						$this->db->group_start();
							$this->db->where('a.actual_payment = a.consultation_fee');
							$this->db->where('a.consultation_fee is not null');
						$this->db->group_end();
					}

					if($data->payment_type=='DISCOUNTED'){
						$this->db->group_start();
							$this->db->where('a.actual_payment < a.consultation_fee');
							$this->db->where('a.actual_payment is not null');
							$this->db->where('a.actual_payment != 0');
							$this->db->where('a.consultation_fee != 0');
							$this->db->where('a.consultation_fee is not null');
						$this->db->group_end();
					}
				}
				if($data->mop_id==2){
				$this->db->where('a.hmo_fee is not NULL');
					if($data->payment_type=='FREE'){
						$this->db->group_start();
							$this->db->where('a.hmo_payment','0');
						$this->db->group_end();
					}
					if($data->payment_type=='PAYED'){
						$this->db->group_start();
							$this->db->where('a.hmo_payment = a.hmo_fee');
							$this->db->where('a.hmo_fee is not null');
						$this->db->group_end();
					}

					if($data->payment_type=='DISCOUNTED'){
						$this->db->group_start();
								$this->db->where('a.hmo_payment < a.hmo_fee');
								$this->db->where('a.hmo_payment is not null');
								$this->db->where('a.hmo_payment != 0');
								$this->db->where('a.hmo_fee != 0');
								$this->db->where('a.hmo_fee is not null');
						$this->db->group_end();
					}
				}
			}else{
				if($data->payment_type!='' && $data->payment_type!='ALL'){
					if($data->payment_type=='FREE'){
						$this->db->group_start();
							$this->db->group_start();
								$this->db->where('a.actual_payment','0');
							$this->db->group_end();
							$this->db->group_start('or',false);
								$this->db->where('a.hmo_payment','0');
							$this->db->group_end();
						$this->db->group_end();
					}
					if($data->payment_type=='PAYED'){
						$this->db->group_start();
							$this->db->group_start();
								$this->db->where('a.actual_payment = a.consultation_fee');
								$this->db->where('a.consultation_fee is not null');
							$this->db->group_end();
							$this->db->group_start('or',false);
								$this->db->where('a.hmo_payment = a.hmo_fee');
								$this->db->where('a.hmo_fee is not null');
							$this->db->group_end();
						$this->db->group_end();
					}

					if($data->payment_type=='DISCOUNTED'){
						$this->db->group_start();
							$this->db->group_start();
								$this->db->where('a.actual_payment < a.consultation_fee');
								$this->db->where('a.actual_payment is not null');
								$this->db->where('a.actual_payment != 0');
								$this->db->where('a.consultation_fee != 0');
								$this->db->where('a.consultation_fee is not null');
							$this->db->group_end();
							$this->db->group_start('or',false);
								$this->db->where('a.hmo_payment < a.hmo_fee');
								$this->db->where('a.hmo_payment is not null');
								$this->db->where('a.hmo_payment != 0');
								$this->db->where('a.hmo_fee != 0');
								$this->db->where('a.hmo_fee is not null');
							$this->db->group_end();
						$this->db->group_end();
					}

				}
			}
			$this->db->order_by('a.dov','DESC');
			//$this->db->where("b.product_id", $product_id);
			//$query = $this->db->get();echo $this->db->last_query();exit();
			return $this->db->get()->result_object(); 
		}
	}
?>

