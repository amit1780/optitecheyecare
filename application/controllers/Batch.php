<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends CI_Controller {
	
		
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('batch_model');
		$this->load->language('language_lang');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index() {
		
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Batches', '/batch');
		$data['page_heading'] = $this->lang->line('batch_list_heading');	    
	
		$data['success'] = $this->session->success;
		
		$data['form_action'] = 'batch';
		
		//getBatchList
		
		/* Pagination */	
		$total_rows = $this->batch_model->getTotalBatch($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/batch/index';	
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
		
		$data['batches'] = array();
		$batches = $this->batch_model->getBatchList($per_page, $start,$this->input->get());		
		foreach($batches as $batch){			
			$delStatus = $this->batch_model->getDelStatus($batch['batch_id']);
			
			$data['batches'][] = array(
				'iqc' 			=> $batch['iqc'],
				'product_id' 	=> $batch['product_id'],
				'product_name' 	=> $batch['product_name'],
				'model' 		=> $batch['model'],
				'batch_no' 		=> $batch['batch_no'],
				'exp_date' 		=> $batch['exp_date'],
				'mfg_date' 		=> $batch['mfg_date'],
				'batch_id' 		=> $batch['batch_id'],
				'del_status'	=> $delStatus
			);
		}

		$this->load->view('common/header');
		$this->load->view('batch/batch_list', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function getBatchDetail(){
		
		$data['batch_id']=$this->input->post('batch_id');
		$batchData=$this->batch_model->getBatchByData($data);
		echo json_encode($batchData);
	}

	public function addBatch(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Batch', '/addBatch');
		$data['page_heading'] = $this->lang->line('batch_add_heading');
		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('iqc', 'IQC', 'required');
		$this->form_validation->set_rules('batch_no', 'Batch No', 'required');
		$this->form_validation->set_rules('batch_no', 'Batch no', 'is_unique[batch.batch_no]');
		
		if ($this->form_validation->run() == false) {
			
			if(form_error('batch_no')){
				$result['error']="Batch No. ".$this->input->post('batch_no')." already exists";
				echo json_encode($result);
			}			
		
			/* $this->load->view('common/header');
			$this->load->view('batch/batch_form', $data);
			$this->load->view('common/footer'); */
			
		} else {
			
			$data=$this->getPostFields();
			
			if($this->input->post('stock_popup')){
			    $data['product_id'] = $data['model_no'];
			}
			
			$mfdt="01/".$this->input->post('mfg_date');
			$mfgDate = DateTime::createFromFormat('d/m/Y', $mfdt);
			$exdt="01/".$this->input->post('exp_date');			
			$expDate = DateTime::createFromFormat('d/m/Y', $exdt);			
			$expDate =$expDate->format('Y-m-d');			
			$last_date = date("t", strtotime($expDate));
			
			$exdt1 = $last_date."/".$this->input->post('exp_date');			
			$expDate = DateTime::createFromFormat('d/m/Y', $exdt1);			
			
			if(strtotime($mfdt) > strtotime($exdt)){
				$data['error']="Exp. Date must be greator than Mfg. Date";
				$this->load->view('common/header');
				$this->load->view('batch/batch_form', $data);
				$this->load->view('common/footer');
								
				return false;				
			}
			
			$data['mfg_date']=$mfgDate->format('Y-m-d');
			$data['exp_date']=$expDate->format('Y-m-d');
			$diff=date_diff($data['mfg_date'],$data['exp_date']);
			if ($this->input->post()) {
				
				$batchData=$this->batch_model->getBatchByData($this->input->post(),$data);
				if(empty($batchData)){
					$result  = $this->batch_model->addBatch($this->input->post(),$data);
					if($this->input->post('stock_popup')){	
					     $result['error']='';
						echo json_encode($result);					
					} else {					
						$_SESSION['success']      = "Success: You have Added Batch";
						redirect('/batch');					
					}	
				}else{
				    $result['error']="Batch No. ".$this->input->post('batch_no')." already exists";
					echo json_encode($result);
				    /* $data['error']="Batch No. ".$this->input->post('batch_no')." already exists";
					$this->load->view('common/header');
					$this->load->view('batch/batch_form', $data);
					$this->load->view('common/footer'); */
				}
			}		
		}
	}
	
	public function editBatch($batch_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Batches', '/batch');
		
		$data['page_heading'] = "Edit Batch";
		
				
		$data['batchinfo'] = $this->batch_model->getBatchById($batch_id);
		
		$data['batch_challan'] = $this->batch_model->checkBatchIdInChallan($batch_id);
		
		$data['batch_id'] = $batch_id;
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('iqc', 'IQC', 'required');
		
		if ($this->form_validation->run() == false) {						
			$this->load->view('common/header');
			$this->load->view('batch/batch_form', $data);
			$this->load->view('common/footer');			
		} else {
			
			$data['batch_id'] = $batch_id;
			
			
			$mfdt="01/".$this->input->post('mfg_date');
			$mfgDate = DateTime::createFromFormat('d/m/Y', $mfdt);
			$exdt="01/".$this->input->post('exp_date');			
			$expDate = DateTime::createFromFormat('d/m/Y', $exdt);			
			$expDate =$expDate->format('Y-m-d');			
			$last_date = date("t", strtotime($expDate));
			
			$exdt1 = $last_date."/".$this->input->post('exp_date');			
			$expDate = DateTime::createFromFormat('d/m/Y', $exdt1);					

			if(strtotime($mfdt) > strtotime($exdt)){
				$data['error']="Exp. Date must be greator than Mfg. Date";
				$this->load->view('common/header');
				$this->load->view('batch/batch_form', $data);
				$this->load->view('common/footer');
								
				return false;				
			}
			
			$data['mfg_date']=$mfgDate->format('Y-m-d');
			$data['exp_date']=$expDate->format('Y-m-d');
			$diff=date_diff($data['mfg_date'],$data['exp_date']);
			if ($this->input->post()) {			
				$result  = $this->batch_model->editBatch($this->input->post(),$data);
				
				$_SESSION['success']  = "Success: You have Update Batch";
				redirect('/batch');				
			}			
		}		
	}
	
	public function deleteBatch($batch_id){
		$result  = $this->batch_model->deleteBatch($batch_id);		
		$_SESSION['success']      = "Success: You have delete Batch";
		redirect('/batch');	
	}
	
	protected function getPostFields(){
		$data=Array();
		foreach ($this->input->post() as $name => $value){
			$data[$name]=$value;
		}
		return $data;
	}
	
}