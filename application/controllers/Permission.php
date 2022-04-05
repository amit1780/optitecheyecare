<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		$this->load->library('breadcrumbs');		
	}
	
	public function index()
	{	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Permission', 'Permission');
		$data['page_heading'] = "Permission";
		
		$data['error'] = "You don't have  permission to access this page.";
	
		$this->load->view('common/header');
		$this->load->view('user/permission', $data);
		$this->load->view('common/footer');		
	}
	
}