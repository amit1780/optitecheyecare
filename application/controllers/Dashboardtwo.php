<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardtwo extends CI_Controller {
	
	public function __construct() {
		
		#var $curObj;
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		
	}
	
	public function index()
	{	
		$this->load->view('common/header');
		$this->load->view('dashboard/dashboardtwo', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	
	
}
