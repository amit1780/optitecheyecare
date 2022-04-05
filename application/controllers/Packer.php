<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packer extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('packer_model');
		$this->load->library('breadcrumbs');		
	}
	
	public function index()
	{	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Packer', '/packer');
		
		$data['page_heading'] = 'Add Packer';		
		$data['form_action']= 'packer';
		
        
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required');		
		//$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[packer.packer_email]');
		
		
			
		if ($this->form_validation->run() == false) {			
			
			$this->load->view('common/header');
			$this->load->view('user/packer_form', $data);
			$this->load->view('common/footer');
			
		} else {
						
			$this->packer_model->addPacker($this->input->post());			
			$_SESSION['success']      = "Success: You have Added New Customer";
			redirect('/packerList');
		}			
	}
	
	public function packerList()
	{	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Packers', '/packerList');
	
		$data['page_heading'] = 'Packer List';
		
		$data['success'] = $_SESSION['success'];
		
		$data['packers'] = $this->packer_model->getPackerList();
			
		$this->load->view('common/header');
		$this->load->view('user/packer_list', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function editPacker($packer_id) {
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Packers', '/packerList');
	
		$data['page_heading'] = 'Edit Packer';		
		$data['form_action']= 'editPacker/'.$packer_id;		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['packerInfo'] = $this->packer_model->getPackerById($packer_id);
		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required');		
			
		if ($this->form_validation->run() == false) {			
			
			$this->load->view('common/header');
			$this->load->view('user/packer_form', $data);
			$this->load->view('common/footer');
			
		} else {						
			$this->packer_model->editPacker($this->input->post(),$packer_id);			
			$_SESSION['success']      = "Success: You have Update Customer";
			redirect('/packerList');
		}			
	}	
}
