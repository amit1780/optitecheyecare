<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Records extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
			$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('records_model');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index() {
	    
		$this->breadcrumbs->push('Dashboard', '/dashboard');		
	   	$this->breadcrumbs->push('Records List', '/records');
		
		$data['page_heading'] = "Records List";
	    
		$data['success'] = $this->session->success;
		
		$data['form_action']= 'records';
		$data['records'] = array();
				
		/* Pagination */	
		$total_rows = $this->records_model->getTotalRecords($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/records/index';	
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;				
		$this->pagination->initialize($config);
		$page = 1;		
		/*if(!empty($this->uri->segment(3,0))){
			$page = $this->uri->segment(3,0);
		}*/		
		if(!empty($this->input->get('per_page'))){
			$page = $this->input->get('per_page');
		}
		$start = ($page-1)*$per_page;		
		$pagination = $this->pagination->create_links();
		
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$data['pagination'] = '<p style="margin-top: 10px;">We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';
			
		}
		/* Pagination */
		
		$data['records'] = $this->records_model->getRecords($per_page, $start,$this->input->get());
	
		$this->load->view('common/header');
		$this->load->view('records/record_list', $data);
		$this->load->view('common/footer');		
		unset($_SESSION['success']);
	}
	
	public function addRecord() {	
	   
	    $this->breadcrumbs->push('Dashboard', '/dashboard');	   	
		$this->breadcrumbs->push('Add Record', '/addRecord');
		
		$data['page_heading'] = "Add Record";
	    
		$data['form_action']= 'addRecord';
		
		$data['banks'] = $this->records_model->getBanks();				
		$data['currencies'] = $this->records_model->getCurrencies();

		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		$this->form_validation->set_rules('financial_year', 'Financial Year', 'required');
		$this->form_validation->set_rules('bill_no', 'Bill No', 'required');
		$this->form_validation->set_rules('bill_date', 'Bill date', 'required');
		$this->form_validation->set_rules('bill_currency', 'Bill Currency', 'required');
		$this->form_validation->set_rules('bill_amount', 'Bill Amount', 'required');
		$this->form_validation->set_rules('challan_id', 'Challan Id', 'required');
		$this->form_validation->set_rules('challan_date', 'Challan date', 'required');
		$this->form_validation->set_rules('payment_bank', 'Payment Bank', 'required');
		$this->form_validation->set_rules('payment_ref_no', 'Payment Ref. no', 'required|is_unique[records.payment_ref_no]');
		$this->form_validation->set_rules('awb', 'AWB', 'required');
		$this->form_validation->set_rules('awb_date', 'AWB Date', 'required');
		$this->form_validation->set_rules('method_of_shipment', 'Method of Shipment', 'required');
		$this->form_validation->set_rules('boe_sdf', 'BOE / SDF / SB', 'required');		
		$this->form_validation->set_rules('bank_sub_date', 'Bank Sub Date', 'required');
				
		
		if ($this->form_validation->run() == false) {
			$data['RefNo'] = $this->records_model->getRecordByBankRefNo($this->input->post('payment_ref_no'));
				
			$this->load->view('common/header');
			$this->load->view('records/record_form', $data);
			$this->load->view('common/footer');			
		} else {			
			$this->records_model->addRecord($this->input->post());			
			$_SESSION['success']      = "Success: You have Added New Records";
			redirect('/records');
		}		
	}
	
	public function editRecord($record_id) {
		$this->breadcrumbs->push('Dashboard', '/dashboard');		
	   	$this->breadcrumbs->push('Records List', '/records');
		$data['page_heading'] = "Edit Record";
	    
		$data['form_action']= 'editRecord/'.$record_id;
		
		$data['recordInfo'] = $this->records_model->getRecordById($record_id);
		
		$data['banks'] = $this->records_model->getBanks();				
		$data['currencies'] = $this->records_model->getCurrencies();

		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		/* $this->form_validation->set_rules('financial_year', 'Financial Year', 'required');
		$this->form_validation->set_rules('bill_no', 'Bill No', 'required');
		$this->form_validation->set_rules('bill_date', 'Bill date', 'required');
		$this->form_validation->set_rules('bill_currency', 'Bill Currency', 'required');
		$this->form_validation->set_rules('bill_amount', 'Bill Amount', 'required');
		$this->form_validation->set_rules('challan_id', 'Challan Id', 'required');
		$this->form_validation->set_rules('challan_date', 'Challan date', 'required');
		$this->form_validation->set_rules('payment_bank', 'Payment Bank', 'required');
		$this->form_validation->set_rules('payment_ref_no', 'Payment Ref. no', 'required|is_unique[records.payment_ref_no]');
		$this->form_validation->set_rules('awb', 'AWB', 'required');
		$this->form_validation->set_rules('boe_sdf', 'BOE / SDF', 'required');
		$this->form_validation->set_rules('sb', 'SB', 'required');
		$this->form_validation->set_rules('bank_sub_date', 'Bank Sub Date', 'required'); */
		
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('records/record_form', $data);
			$this->load->view('common/footer');			
		} else {			
			$this->records_model->editRecord($this->input->post());			
			$_SESSION['success']      = "Success: You have Update Records";
			redirect('/records');
		}		
	}
	
	public function viewRecord($record_id) {
		$this->breadcrumbs->push('Dashboard', '/dashboard');		
	   	$this->breadcrumbs->push('Records List', '/records');
		$data['page_heading'] = "View Record";
	    
		$data['form_action']= 'editRecord/'.$record_id;
		
		$data['recordInfo'] = $this->records_model->getRecordById($record_id);
			
		$this->load->view('common/header');
		$this->load->view('records/record_view', $data);
		$this->load->view('common/footer');			
			
	}
	
	public function printRecord($record_id) {
		
		$data['page_heading'] = "View Record";
	    
		$data['form_action']= 'editRecord/'.$record_id;
		
		$data['recordInfo'] = $this->records_model->getRecordById($record_id);
		
		if(($data['recordInfo']->payment_bank == 5) || ($data['recordInfo']->payment_bank == 6) || ($data['recordInfo']->payment_bank == 7)){
			$this->load->view('records/record_print_standard', $data);
		} else if($data['recordInfo']->payment_bank == 1){
			$this->load->view('records/record_print_axis', $data);
		} 	
	}
	
}