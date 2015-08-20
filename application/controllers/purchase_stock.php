<?php

defined('BASEPATH') OR exit('You can no permission to  access this page !');

class purchase_stock extends CI_Controller{	 

	function index(){
		$this->load->library('myencryption');
		$this->load->view('header_view');
		$this->load->view('purchase_stock_view');
		$this->load->view('footer_view');
	}


	function validation(){
		$this->load->library('form_validation');
		$this->load->library('myencryption');

		$this->form_validation->set_rules('date_time','Date','required');
		$this->form_validation->set_rules('employee_name','Employee Name','required');
		$this->form_validation->set_rules('productcode','Product Code','required');
		$this->form_validation->set_rules('productname','Product Name','required');
		$this->form_validation->set_rules('descriptions','Descriptions','required');
		$this->form_validation->set_rules('cost','Cost','required');
		$this->form_validation->set_rules('quantity','quantity','required');
		$this->form_validation->set_rules('categories','categories','required');


		$this->form_validation->set_error_delimiters("<div class=' showmessage alert alert-danger' id='showmessage' style='margin-bottom:5px'><span>","&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' onclick='hide()' id='closeicon'></i></div> ");
 		$date_time = $this->input->post('date_time');
		$employee_name = $this->input->post('employee_name');
		$productcode = $this->input->post('productcode');
		$productname = $this->input->post('productname');
		$descriptions = $this->input->post('descriptions');
		$cost = $this->input->post('cost');
		$quantity = $this->input->post('quantity');
		$categories = $this->input->post('categories');


		$arr = array('date_time'=>$date_time,'employee_name'=>$employee_name,'product_id'=>$productcode,'name'=>$productname,'quantity'=>$quantity,'unit_price' => $cost, 'catagories_id' => $categories, 'description' => $descriptions );
		$clean_data= $this->security->xss_clean($arr);

		if ($this->form_validation->run() == false) {

			$this->load->view('header_view');
			$this->load->view('purchase_stock_view');
			$this->load->view('footer_view');
		}else{
			$this->db->where("product_id",$productcode);
			$this->db->update('tbl_product',$clean_data);
			$error['success'] = "<div class=' alert alert-success' id='showmessage' style='margin-bottom:5px'><span>Product has been successfully updated &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>";
			$this->load->view('header_view');
			$this->load->view('manage_product_view',$error);
			$this->load->view('footer_view');
		
		}
	}

	function saveProducts(){
		$arr = $this->input->post('post_data');		
		$arrs = null;
		$count =0;
		 foreach ($arr as $value) {
		 	
		 	$result = $this->db->get_where('tbl_product',array('product_id' =>  $value['Model']));
		 	$row = $result->row();
		 

		 	$arrs = array(		 		
		 			'name' => $value['Productname'],
			 		'description'=> $value['Descriptions'],
			 		'supplier_id'=> $value['Supplier_id'],
			 		'product_id' => $value['Model'],
			 		'quantity'  =>  $row->quantity + $value['Quantity'],
			 		'catagories_id' => $value['Categories'],
			 		'unit_price' => $value['Cost']
		 		);
		 	$cleanArr = $this->security->xss_clean($arrs);	
		 	if ($this->check_id_if_exist($value['Model']) == true){
		 		$this->db->where('product_id',  $value['Model']);
		 		$this->db->update('tbl_product',$cleanArr);
			}else{
			 	 $bigArr[$count] = $arrs;
			}

		 	 $count++;
		 }
		
		 	$this->db->insert_batch('tbl_product',$bigArr);
		 	echo "Submit Successfull";
		 		

	}

	private function check_id_if_exist($id){
	
		$result = $this->db->get_where('tbl_product', array('product_id' => $id));

		
		if ($result->num_rows() > 0)
		     return TRUE;
		else    
		    return FALSE;
			

	}

	function server_side(){		
		$this->load->helper('text');	
		$this->load->library('myencryption');
		$session_data = $this->session->all_userdata();
		if ( isset($session_data['user']) && $session_data['user'] == TRUE ) {
			
		}else{
            redirect('','refresh');
        }

		$table = 'tbl_product';
		// Table's primary key
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes

		$columns = array(			
			array( 'db' => 'name', 'dt' => 'name' ),
			array( 'db' => 'product_id',  'dt' => 'product_id' ),
			array( 'db' => 'catagories_id',  'dt' => 'categories' ),
			array( 'db' => 'unit_price',  'dt' => 'unit_price' ),
			array( 'db' => 'quantity',  'dt' => 'unit_in_stock' ),	
			array( 'db' => 'description',  'dt' => 'unit_in_order',

					'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix		
			           return word_limiter($d,5);
			        }),
			array(
			        'db' => 'id',
			        'dt' => 'id',
			        'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix		
			            $vv = base_url()."purchase_stock/index/".$this->myencryption->encode($d);;	         
			            return "<a href='$vv'>Edit</a> | <a href='#' onclick='showModal($d)'>Delete</a>";
			        }
			 ),		
		);

		// SQL server connection information
		$sql_details = array(
			'user' => 'root',
			'pass' => '',
			'db'   => 'thesis_stock',
			'host' => 'localhost'
		);

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP
		 * server-side, there is no need to edit below this line.
		 */
		$this->load->helper('ssp_helper');
		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);
	}

	function get_product_code(){
		$value =  $this->input->post('productname');
		$result = $this->db->get_where('tbl_product',array('product_id'=>$value));

		foreach ($result->result() as $row) {
			echo $row->name;
		}
	}
	function get_product_price(){
		$value =  $this->input->post('productname');
		$result = $this->db->get_where('tbl_product',array('product_id'=>$value));

		foreach ($result->result() as $row) {
			echo $row->unit_price;
		}
	}
	function check_duplicate_productcode(){

		$value = $this->input->post('productcode');
		$test="0";

		if ( ! empty($value) ) {
			$result = $this->db->get_where('tbl_product',array('product_id' => $value));

			foreach ($result->result() as $row) {
				$test ="1";
			}

		}
		
		echo $test;

	}
}