<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {

	function index(){

		$this->load->view('header_view');
		$this->load->view('create_user_view');
		$this->load->view('footer_view');		
	}

	function insert_database(){	
		
		if (! $this->session->userdata('user')) {
			redirect('','refresh');
		}

		$this->load->helper('inflector');

		$id = $this->session->userdata('user_id');		
		$position_name = humanize(trim($this->input->post('position_name')));	
		if ($position_name === "") {			
			return 0;			
		}
		$result = $this->db->get_where('tbl_position',array('name'=>$position_name));

		if ($result->num_rows() >= 1 ) {
			echo "<div class=' alert alert-danger hideclass' id='showmessage' style='margin-bottom:5px;text-align:left;'><span > This position already existed &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg' id='closeicon' onclick='hide()'></i></div> ";
		}else{
			$value = array('name'=>$position_name);
			$this->db->insert('tbl_position',$value);
			echo "<div class=' alert alert-success hideclass' id='showmessage' style='margin-bottom:5px;text-align:left;'><span>Successfully updated &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg' id='closeicon' onclick='hide()'></i></div> ";
		}

	}	
	function read_position(){
		if (! $this->session->userdata('user')) {
			redirect('','refresh');
		}
		
		$result = $this->db->get('tbl_position');
		 
		echo 	"<select class='form-control' name='type_user' data-validation='required'>";
		echo 	"<option value=''>Please choose user position</option>";
			foreach ($result->result() as $value) {
				echo "<option value='$value->name'>$value->name</option>";
			}
         echo 	"</select>"; 


	}

	function create_user_validation(){
		$this->load->library('form_validation');
		$this->load->library('myencryption');
		$this->form_validation->set_rules('username','Username','required|min_length[5]|alpha', 
											array('alpha' => 'username character only no space included ' )
										  );
 		$this->form_validation->set_rules('fullname','Full Name','trim|required|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|required');
		$this->form_validation->set_rules('password_confirm','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('type_user','Type User','trim|required');
		$this->form_validation->set_error_delimiters("<div class=' showmessage alert alert-danger' id='showmessage' style='margin-bottom:5px'><span>","&nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' onclick='hide()' id='closeicon'></i></div> ");
		$username = $this->input->post('username');
		$fullname = $this->input->post('fullname');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm_password');
		$type_user = $this->input->post('type_user');

		$arr = array('email_address'=>$email,'username'=>$this->myencryption->encode($username),'real_name'=>$fullname,'password'=>$this->myencryption->encode($password),'type_user'=>$type_user);
		$clean_data= $this->security->xss_clean($arr);

		if ($this->form_validation->run() == false) {

			$this->load->view('header_view');
			$this->load->view('create_user_view');
			$this->load->view('footer_view');
		}else{

			$this->db->insert('user',$clean_data);
			$error['success'] = "<div class=' alert alert-success' id='showmessage' style='margin-bottom:5px'><span>User account has been successfully registered &nbsp&nbsp&nbsp&nbsp&nbsp </span><i class='fa  fa-times fa-lg closeicon' id='closeicon'></i></div>";
			$this->load->view('header_view');
			$this->load->view('create_user_view',$error);
			$this->load->view('footer_view');
		}
	}

}