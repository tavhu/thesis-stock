<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class supplier extends CI_Controller {

	function index(){		
		$this->load->library('myencryption');
		$this->load->view('header_view');
		$this->load->view('supplier_view');
		$this->load->view('footer_view');
	}
	function manage(){

		$this->load->view('header_view');
		$this->load->view('manage_supplier_view');
		$this->load->view('footer_view');
	}

	function insert_validate(){


		$this->load->library('form_validation');
		$this->load->library('myencryption');
		$this->form_validation->set_rules('companyname','Company Name', 'trim|required');
		$this->form_validation->set_rules('fullname', 'Full Name','trim|required');	
		$this->form_validation->set_rules('telephone1','Telephone 1','trim|numeric|required');
		$this->form_validation->set_rules('note','Note','trim');
		$this->form_validation->set_rules('address','Current Address','trim');	
		$this->form_validation->set_error_delimiters("<div class=' alert alert-danger' id='showmessage' style='margin-bottom:5px'><span>","&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>");

	if ($this->form_validation->run() == false ) {
			$this->load->view('header_view');
			$this->load->view('supplier_view');
			$this->load->view('footer_view');
		}else{

			$companyname = $this->input->post('companyname');
			$fullname = $this->input->post('fullname');
			$telephone1 = $this->input->post('telephone1');
			$telephone2 = $this->input->post('telephone2');
			$address = $this->input->post('address');
			$address = $this->input->post('address');			

		}

			$arr = array(
					'company_name' => $companyname ,
					'name' => $fullname , 
					'tel1' => $telephone1 , 
					'tel2' => $telephone2 , 
					'note' => $address , 
					'address' => $address 				
				);
			$cleandata = $this->security->xss_clean($arr);		

			if ($this->input->post('secret') == "INSERT") {
				$result = $this->db->insert('tbl_supplier',$cleandata);
				$this->session->set_flashdata('inserted_id',$this->db->insert_id());	
			}else if($this->input->post('secret') == "EDIT"){
				$uid = $this->input->post('uid');
				$id= $this->myencryption->decode($uid);
				if($this->db->update('tbl_supplier',$cleandata, array('id' => $id))){
					$this->session->set_flashdata('inserted_id',$id);	
				}
			}			

			$error['success'] = "<div class=' alert alert-success' id='showmessage' style='margin-bottom:5px'><span>User has been successfully registered &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>";
			$this->load->view('header_view');
			$this->load->view('supplier_view',$error);
			$this->load->view('footer_view');


	}

	function server_side(){		
		$this->load->library('myencryption');
		$session_data = $this->session->all_userdata();
		if ( isset($session_data['user']) && $session_data['user'] == TRUE ) {
			
		}else{
            redirect('','refresh');
        }
        $table = 'tbl_supplier';
		// Table's primary key
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes

		$columns = array(			
			array( 'db' => 'company_name', 'dt' => 'companyname' ),
			array( 'db' => 'name',  'dt' => 'name' ),
			array( 'db' => 'tel1',  'dt' => 'telephone1' ),
			array( 'db' => 'tel2',  'dt' => 'telephone2' ),
			array( 'db' => 'address',  'dt' => 'address' ),	
			array( 'db' => 'note',  'dt' => 'note' ),
			array(
			        'db' => 'id',
			        'dt' => 'id',
			        'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix		
			            $vv = base_url()."supplier/index/".$this->myencryption->encode($d);;	         
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
		$this->db->delete('tbl_supplier',array('id'=>$var));
	}
	
}