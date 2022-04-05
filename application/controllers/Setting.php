<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		$this->load->helper(array('url'));
		$this->load->model('setting_model');		
		$this->load->library('breadcrumbs');		
		$this->load->library('dbvars');		
	}
	
	public function index()
	{	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Setting', 'setting');
		$data['page_heading'] = "Setting";
		
		$data['form_action'] = "addSetting";		
		
		$data['Config_data'] = $this->setting_model->getConfigData();
		
		$this->load->view('common/header');
		$this->load->view('user/setting', $data);
		$this->load->view('common/footer');		
	}
	
	public function addSetting(){
		
		$this->setting_model->addSet($this->input->post());		
		$_SESSION['success']      = "Success: You have Added New Customer";
		redirect('/setting');
	}
	
}