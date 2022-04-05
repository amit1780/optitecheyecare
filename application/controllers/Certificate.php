<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends CI_Controller {
	
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
		$this->load->model('certificate_model');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
		
	}
	
	public function index(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Certificate', '/certificate');
		$data['page_heading'] = "Certificate List";
		
		$data['success'] = $this->session->success;
		$data['certificates'] = $this->certificate_model->getCertificates();		
		

		$this->load->view('common/header');
		$this->load->view('certificate/certificate_list', $data);
		$this->load->view('common/footer');	
		$this->session->unset_userdata('success');
	}

	public function addCertificate(){	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Certificate', '/addCertificate');
		$data=$this->getPostFields();
		$data['page_heading'] = "Add Certificate";
		$this->load->helper('form');
		$this->load->library('form_validation');			
		$data['form_action']= 'addCertificate';	
		

		$this->form_validation->set_rules('certificate_name', 'Certificate name', 'required|is_unique[certificates.certificate_name]');

		if ($this->form_validation->run() == false) {			
						
			$this->load->view('common/header');
			$this->load->view('certificate/certificate_form', $data);
			$this->load->view('common/footer');			
		}else{

			if ($this->input->post()) {
				
				if(!empty($_FILES['certificate_file']['name'])){
					$certificate_file = '';
					$config['upload_path'] = 'uploads/certificates/';
					$config['allowed_types'] = '*';
					$config['file_name'] = $_FILES['certificate_file']['name'];
					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('certificate_file')){
						$uploadData = $this->upload->data();						
						$certificate_file = $config['upload_path'].$uploadData['file_name'];
					}else{
						$certificate_file = '';
					}					
				}else{
					$certificate_file = '';
				}

				$this->certificate_model->addCertificate($this->input->post(),$certificate_file);
				$sessionData['success']="Success: You have Added Certificate Successfully!!";	
				$this->session->set_userdata($sessionData);
				redirect('/certificate');
			}
		}
			
	}

	public function editCertificate($certificate_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Certificate', '/certificate');
		
		$data['page_heading'] = "Edit Certificate";
		$this->load->helper('form');
		$this->load->library('form_validation');			
		$data['form_action']= 'editCertificate/'.$certificate_id;	
		if(!empty($this->input->post('certificate_id'))){
			$certificate_id=$this->input->post('certificate_id');
		}
		$certificateInfo = $this->certificate_model->getCertificateById($certificate_id);
		if(empty($certificateInfo)){
			redirect('/addCertificate');
		}else{
			
			$data['certificate_name']=$certificateInfo->certificate_name;
			$data['certificate_id']=$certificateInfo->certificate_id;
			$data['certificate_expiry_date']=date("d-m-Y", strtotime($certificateInfo->expire_date_time));
			if(!empty($certificateInfo->path)){
				$data['certificate_file']=base_url().$certificateInfo->path;
			}
		}

		$this->form_validation->set_rules('certificate_name', 'Certificate name', 'required');

		if ($this->form_validation->run() == false) {			
						
			$this->load->view('common/header');
			$this->load->view('certificate/certificate_form', $data);
			$this->load->view('common/footer');			
		}else{
			
			if ($this->input->post()) {
				
				if(!empty($_FILES['certificate_file']['name'])){
					$certificate_file = '';
					$config['upload_path'] = 'uploads/certificates/';
					$config['allowed_types'] = '*';
					$config['file_name'] = $_FILES['certificate_file']['name'];
					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('certificate_file')){
						$uploadData = $this->upload->data();						
						$certificate_file = $config['upload_path'].$uploadData['file_name'];
					}else{
						$certificate_file = '';
					}					
				}else{
					$certificate_file = '';
				}

				$this->certificate_model->updateCertificate($this->input->post(),$certificate_file);
				$sessionData['success']="Success: You have Updated Certificate Successfully!!";	
				$this->session->set_userdata($sessionData);
				redirect('/certificate');
			}
		}	
	}
	
	protected function getPostFields(){
		$data=Array();
		foreach ($this->input->post() as $name => $value){
			$data[$name]=$value;
		}
		return $data;
	}
}
	
	