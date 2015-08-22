<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	function index(){
		$this->load->view('header_view');
		$this->load->view('home_view');
		$this->load->view('footer_view');

	}

	function supplier(){

		$this->load->view('header_view');
		$this->load->view('supplier_view');
		$this->load->view('footer_view');
	}
	
}

