<?php

defined('BASEPATH') OR exit('You can no permission to  access this page !');

class Employee extends CI_Controller{	 

	public function index(){
		$this->load->library('myencryption');
		$this->load->view('header_view');
		$this->load->view('employee_view');
		$this->load->view('footer_view');	
	}
	public function create_employee_validation(){

		$this->load->library('form_validation');
		$this->load->library('myencryption');
		$this->form_validation->set_rules('fullname','Full Name', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('nickname', 'Nick Name','trim|required|min_length[5]');
		$this->form_validation->set_rules('email' , 'Email','trim|required|valid_email');	
		$this->form_validation->set_rules('nationality', 'Nationality' ,'trim|max_length[50]|alpha');
		$this->form_validation->set_rules('gender','Gender','trim|required');
		$this->form_validation->set_rules('dateofbirth','Date of Birth','trim|required');
		$this->form_validation->set_rules('startworkingdate','Start Working Date','trim|required');		
		$this->form_validation->set_rules('telephone1','Telephone 1','trim|numeric|required');				
		$this->form_validation->set_rules('ssnnumber','SSN Number','trim');
		$this->form_validation->set_rules('placeofbirth','Place of Birth','trim');
		$this->form_validation->set_rules('currentaddress','Current Address','trim');
		$this->form_validation->set_error_delimiters("<div class=' alert alert-danger' id='showmessage' style='margin-bottom:5px'><span>","&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div> ");

		

		if ($this->form_validation->run() == false ) {
			$this->load->view('header_view');
			$this->load->view('employee_view');
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
     		  $check = 0;

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
			$nickname = $this->input->post('nickname');
			$email = $this->input->post('email');
			$nationality = $this->input->post('nationality');
			$gender = $this->input->post('gender');
			$dateofbirth = $this->input->post('dateofbirth');
			$startworkingdate = $this->input->post('startworkingdate');			
			$telephone1 = $this->input->post('telephone1');				
			$ssnnumber = $this->input->post('ssnnumber');
			$placeofbirth = $this->input->post('placeofbirth');
			$currentaddress = $this->input->post('currentaddress');
			//notyet get image path 

			$arr = array(
					'name' => $fullname ,
					'nickname' => $nickname , 
					'gender' => $gender , 
					'place_of_birth' => $placeofbirth , 
					'start_service_date' => $startworkingdate , 
					'nationality' => $nationality , 				
					'email' => $email ,
					'date_of_birth' => $dateofbirth , 
					'current_address' => $currentaddress , 
					'telephone1' => $telephone1 ,										
					'ssn_number' => $ssnnumber,
					'picture' =>$filename
				);

			if (empty($_FILES['userfile']['name']) && $this->input->post('secret') == "EDIT") {
				unset($arr['picture']);
			}
			
			$cleandata = $this->security->xss_clean($arr);
			if ($this->input->post('secret') == "INSERT") {		


				$vv = $this->db->get_where('employee', array ('email' => $email));
				if ($vv->num_rows() > 0) {
					$this->session->set_flashdata('error',"<div class=' alert alert-warning' id='showmessage' style='margin-bottom:5px'><span> Email can't be dupplidate &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>" ); 
					$check = 1;
				}else{

				$result = $this->db->insert('employee',$cleandata);
				$this->session->set_flashdata('inserted_id',$this->db->insert_id());	
			}

			}else if($this->input->post('secret') == "EDIT"){
				$uid = $this->input->post('uid');
				$id= $this->myencryption->decode($uid);
				if($this->db->update('employee',$cleandata, array('id' => $id))){
					$this->session->set_flashdata('inserted_id',$id);	
				}
			}			

			if ($check != 1) {
				$error['success'] = "<div class=' alert alert-success' id='showmessage' style='margin-bottom:5px'><span>User has been successfully registered &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>";
			}			
			$this->load->view('header_view');
			$this->load->view('employee_view',$error);
			$this->load->view('footer_view');
		}

	}

	function server_side(){		
		$this->load->library('myencryption');
		$session_data = $this->session->all_userdata();
		if ( isset($session_data['user']) && $session_data['user'] == TRUE ) {
			
		}else{
            redirect('','refresh');
        }

		$table = 'employee';
		// Table's primary key
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes

		$columns = array(			
			array( 'db' => 'name', 'dt' => 'name' ),
			array( 'db' => 'nickname',  'dt' => 'nickname' ),
			array( 'db' => 'gender',  'dt' => 'gender' ),
			array( 'db' => 'telephone1',  'dt' => 'telephone1' ),
			array( 'db' => 'email',  'dt' => 'email' ),	
			array( 'db' => 'start_service_date',  'dt' => 'start_service_date' ),
			array(
			        'db' => 'id',
			        'dt' => 'id',
			        'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix		
			            $vv = base_url()."employee/index/".$this->myencryption->encode($d);;	         
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
	function manage_employee(){

		$this->load->view('header_view');
		$this->load->view('manage_employee_view');		
		$this->load->view('footer_view');		
	}
	function deleteUser(){
		$this->load->library('myencryption');

		$var = $this->input->post('post_data');				
		$this->db->delete('employee',array('id'=>$var));
	}
	

}
