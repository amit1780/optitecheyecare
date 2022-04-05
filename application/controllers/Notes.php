<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('notes_model');
		$this->load->model('customer_model');
		$this->load->library('breadcrumbs');
	}
	
	public function index()
	{	
		
	}	
	
	public function notes($customer_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$data['page_heading'] = "Notes";
	    
		$data['form_action']= 'notes/'.$customer_id;
		
		$data['notes'] = $this->notes_model->getNotes($customer_id);
		$data['customer'] = $this->customer_model->getCustomerById($customer_id);

		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('notes', 'Notes', 'required');
		
		if ($this->form_validation->run() == false) {
			
			$data['success'] = $this->session->success;
		
			$this->load->view('common/header');
			$this->load->view('customer/notes_form', $data);
			$this->load->view('common/footer');
			unset($_SESSION['success']);			
		} else {			
			
			$this->notes_model->addNotes($this->input->post(),$customer_id);			
			$_SESSION['success']      = "Success: You have Added New Notes";
			redirect('/notes/'.$customer_id);
		}		
		
					
	}	
}