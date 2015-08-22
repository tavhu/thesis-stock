<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class sale extends CI_Controller {

	function index(){
		
		$this->load->view('header_view');
		$this->load->view('sale_view');
		$this->load->view('footer_view');
	}

	function insert_sale(){

				$arr = $this->input->post('post_data');		
				$arrs = null;				
				$count =0;

				$val = $this->db->get('sale_invoice');
				$invoice_id = 0;
				foreach ($val->result() as $dd) {
					$invoice_id = $dd->invoice_id;					
				}
				$invoice_id = $invoice_id + 1;
				 foreach ($arr as $value) {		 

				 	$arrs = array(		
				 			'invoice_id' => $invoice_id, 		
				 			'productcode' => $value['productcode'],
					 		'productname'=> $value['productname'],
					 		'unit_price'=> $value['unit_price'],
					 		'qty' => $value['qty'],
					 		'total'  =>  $value['total'],
					 		'employee_name' => $value['employee_name'],
					 		'date_time' => $value['date_time'],
					 		'paid' => $value['paid'],
					 		'discount' => $value['discount'],
					 		'subtotal' => $value['subtotal']
				 		);
				 	$cleanArr = $this->security->xss_clean($arrs);					 
					$bigArr[$count] = $cleanArr;					
				 	 $count++;

				 	$result = $this->db->get_where('tbl_product',array('product_id' =>  $value['productcode']));
				 	$row = $result->row();
				 	$s = $row->quantity - $value['qty'];
				 	$this->db->where('product_id',$value['productcode']);
				 	$av = array('quantity' => $s);
				 	$this->db->update('tbl_product',$av);

				 }
				
				 	$this->db->insert_batch('sale_invoice',$bigArr);
				 	echo $invoice_id;
				 		

	}
	function manage_product(){

		$this->load->view('header_view');
		$this->load->view('manage_product_view');
		$this->load->view('footer_view');
	}
	function categories(){
		$this->load->library('myencryption');
		$this->load->view('header_view');
		$this->load->view('add_categories_view');
		$this->load->view('footer_view');
		
	}
	function categories_validate(){
	$this->load->library('form_validation');
		$this->load->library('myencryption');
		$this->form_validation->set_rules('fullname','Full Name', 'trim|required|min_length[5]');		
		$this->form_validation->set_rules('description','Current Address','trim');
		$this->form_validation->set_error_delimiters("<div class=' alert alert-danger' id='showmessage' style='margin-bottom:5px'><span>","&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div> ");

		

		if ($this->form_validation->run() == false ) {
			$this->load->view('header_view');
			$this->load->view('add_categories_view');
			$this->load->view('footer_view');
		}else{
			//upload image 

			  $config['upload_path']   = './assets/images/';
              $config['allowed_types'] = 'gif|jpg|png';
              $config['max_size']      = 10000;
              $config['max_width']     = 3024;
              $config['max_height']    = 3024;

              $error = null ;
              $this->load->library('upload',$config);
              $this->upload->initialize($config);     		
     		  $filename = null;
     		  $arr = null;


     			if (empty($_FILES['userfile']['name']) && $this->input->post('secret') == "EDIT") {
     				
				}else{
						if( ! $this->upload->do_upload('userfile')){
			                      	
			              }else{
			                   $filename =  $this->upload->data('file_name');
			              } 
				}

			if (empty($_FILES['userfile']['name']) && $this->input->post('secret') == "INSERT") {

				if ($this->upload->do_upload('userfile'))
	                {
	                     $filename =  $this->upload->data('file_name'); 	
	                }
			}
				
               

			$fullname = $this->input->post('fullname');
			$description = $this->input->post('description');		
			//notyet get image path 

			$arr = array(
					'name' => $fullname ,
					'description' => $description , 				
					'img_url' =>$filename
				);

			if (empty($_FILES['userfile']['name']) && $this->input->post('secret') == "EDIT") {
				unset($arr['picture']);
			}
			$error = null ; 
			$cleandata = $this->security->xss_clean($arr);			

			if ($this->input->post('secret') == "INSERT") {
				$error['success'] = "<div class=' alert alert-success' id='showmessage' style='margin-bottom:5px'><span>Category has been successfully created &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>";
				$result = $this->db->insert('tbl_categories',$cleandata);
				$this->session->set_flashdata('inserted_id',$this->db->insert_id());	
			}else if($this->input->post('secret') == "EDIT"){
				$error['success'] = "<div class=' alert alert-success' id='showmessage' style='margin-bottom:5px'><span>Category has been successfully updated &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>";
				$uid = $this->input->post('uid');
				$id= $this->myencryption->decode($uid);
				if($this->db->update('tbl_categories',$cleandata, array('id' => $id))){
					$this->session->set_flashdata('inserted_id',$id);	
				}
			}			
			
			$this->load->view('header_view');
			$this->load->view('add_categories_view',$error);
			$this->load->view('footer_view');
		}


	}
	function manage_categories(){
		$this->load->library('myencryption');
		$this->load->view('header_view');
		$this->load->view('manage_categories_view');
		$this->load->view('footer_view');
	}


	function server_side(){		
		$this->load->library('myencryption');
		$session_data = $this->session->all_userdata();
		if ( isset($session_data['user']) && $session_data['user'] == TRUE ) {
			
		}else{
            redirect('','refresh');
        }

		$table = 'tbl_categories';
		// Table's primary key
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes

		$columns = array(			
			array( 'db' => 'name', 'dt' => 'name' ),
			array( 'db' => 'description',  'dt' => 'description' ),										
			array(
			        'db' => 'id',
			        'dt' => 'id',
			        'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix		
			            $vv = base_url()."sale/categories/".$this->myencryption->encode($d);;	         
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

	function deleteUser(){
		$this->load->library('myencryption');

		$var = $this->input->post('post_data');				
		$this->db->delete('tbl_product',array('id'=>$var));
	}
	
}