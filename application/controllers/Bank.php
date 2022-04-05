<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('bank_model');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
		
	}
	
	public function index(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Banks', '/bank');
		$data['page_heading'] = "Bank List";
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['success'] = $this->session->success;
		$data['banks'] = $this->bank_model->getBanks();		
		

		$this->load->view('common/header');
		$this->load->view('bank/bank_list', $data);
		$this->load->view('common/footer');	
		$this->session->unset_userdata('success');
	}

	public function addBank(){	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Bank', '/addBank');
		$data['page_heading'] = "Add Bank";
		$this->load->helper('form');
		$this->load->library('form_validation');		
        
        $data['form_action']='saveBank';
        
		$this->load->view('common/header');
		$this->load->view('bank/bank_form', $data);
		$this->load->view('common/footer');	
	}

	public function editBank($bank_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Banks', '/bank');
		
		$data['page_heading'] = "Edit Bank";
		

		$data['bank'] = $this->bank_model->getBankById($bank_id);
		//print_r($data['bank']);
		$data['form_action']= 'editBank/'.$bank_id;		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'required');		
		$this->form_validation->set_rules('account_no', 'Account No', 'required');		
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');		
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('bank/bank_form', $data);
			$this->load->view('common/footer');			
		} else {			
			$this->bank_model->editBank($this->input->post());			
			$sessionData['success']="Success: You have Updated Bank Successfully!!";	
			$this->session->set_userdata($sessionData);
			redirect('/bank');			
		}		
	}

	public function bankView($bank_id){
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Banks', '/bank');
		
		
	    
		$data['bank'] = $this->bank_model->getBankById($bank_id);
		$data['page_heading'] = $data['bank']->beneficiary_name." ".$data['bank']->bank_name;
		
		$this->load->view('common/header');
		$this->load->view('bank/bank_view', $data);
		$this->load->view('common/footer');

	}

	public function saveBank(){		
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->bank_model->addBank($this->input->post());

		$sessionData['success']="Success: You have Added Bank Successfully!!";	
		$this->session->set_userdata($sessionData);
		redirect('/bank');
	}

	public function save_download()	{ 
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library


		
		 $this->data['banks'] = $this->bank_model->getBanks();		
		 //now pass the data //

		
		$html=$this->load->view('bank/pdf_output',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="mypdf.pdf";

		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
		 	
	}
	
}
