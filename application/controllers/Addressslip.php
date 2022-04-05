<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addressslip extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('addressslip_model');
		$this->load->model('challan_model');
		$this->load->model('order_model');
		$this->load->model('quotation_model');
		$this->load->model('customer_model');
		$this->load->model('product_model');
		$this->load->model('bank_model');
		$this->load->language('language_lang');	
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');		
		$this->breadcrumbs->push('Challan List', 'challanList');	
		
		
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		$data['error'] = $_SESSION['error'];
		
		$data['page_heading'] = "Address Slip";				
		$data['challan_id'] = $this->input->get('challan_id');
		$data['getaddressslip'] = $this->addressslip_model->getAddressSlipById($this->input->get('challan_id'));
		$data['getAddressSliPackages'] = $this->addressslip_model->getAddressSliPackagepById($data['getaddressslip']->addressslip_id);
		$data['getOrderDetails'] = $this->addressslip_model->getOrderDetails($this->input->get('challan_id'));
		
		
		$data['challanInfoProduct'] = $this->addressslip_model->getChallanProductById($this->input->get('challan_id'));	
				
		$data['total_qty'] = array_sum(array_column($data['challanInfoProduct'],'qty'));
		//$data['no_of_pack'] = count(array_column($data['getAddressSliPackages'],'package_no'));
		$data['no_of_pack'] = $data['getaddressslip']->no_of_package;
		
		$data['getaddresssliplists'] = $this->addressslip_model->getAddressSliPackagepByGroup($data['getaddressslip']->addressslip_id);		
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
	
		$this->form_validation->set_rules('no_of_packs', 'Packages', 'required');
		$this->form_validation->set_rules('weight_unit', 'Weight unit', 'required');
		$this->form_validation->set_rules('address_type', 'Address type', 'required');
		$this->form_validation->set_rules('pack[]', 'Package no', 'required');
		$this->form_validation->set_rules('qty[]', 'Qty', 'required');
		//$this->form_validation->set_rules('weight[]', 'Weight', 'required');
		$this->form_validation->set_rules('product[]', 'Product', 'required');
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('address_slip/addressslip_form', $data);
			$this->load->view('common/footer');			
		} else {
						
			$challan_id = $this->input->post('challan_id');
			
			$data['challanInfoProduct'] = $this->addressslip_model->getChallanProductById($challan_id);		
			$total_qty = array_sum(array_column($data['challanInfoProduct'],'qty'));			
			$data =$this->input->post();
			$qty = array_sum($data['qty']);
			if($qty > $total_qty){
				
				$_SESSION['error']="Qty of product must be same as qty in challan.";				
				redirect('/addressslip?challan_id='.$challan_id);
				return false;
			}
			
			$data['challanInfoProduct'] = $this->addressslip_model->addAddressSlip($this->input->post());
			$_SESSION['success']      = "Success: You have Added Challan";			
			redirect('/addressslip?challan_id='.$challan_id);	
		}
		unset($_SESSION['error']);
		
	}
	
		
	
	public function addSlipPrint(){
		
		$data['page_heading'] = "Address Slip";				
		$data['challan_id'] = $this->input->get('challan_id');
		$data['package_no'] = $this->input->get('package_no');
		$data['addressslip_id'] = $this->input->get('addressslip_id');
		$data['getaddressslip'] = $this->addressslip_model->getAddressSlipById($this->input->get('challan_id'));		
		$data['getOrderDetails'] = $this->addressslip_model->getOrderDetails($this->input->get('challan_id'));
		$data['customerInfo'] = $this->order_model->getCustomerById($data['getOrderDetails']->customer_id);
		$data['challanInfo'] = $this->challan_model->getChallanById($this->input->get('challan_id'));	
		$data['getAddressSliPackages'] = $this->addressslip_model->getAddressSliPackagepBySingleId($data['package_no'],$data['addressslip_id']);
		
		
		$data['total'] = $data['getaddressslip']->no_of_package;
		
		
		$data['challanInfoProduct'] = $this->addressslip_model->getChallanProductById($this->input->get('challan_id'));		
							
		$this->load->view('address_slip/addressslip_print', $data);		
	} 
	
	public function addSlipDetailPrint(){
		
		$data['page_heading'] = "Address Slip";				
		$data['challan_id'] = $this->input->get('challan_id');
		$data['package_no'] = $this->input->get('package_no');
		$data['addressslip_id'] = $this->input->get('addressslip_id');
		$data['getaddressslip'] = $this->addressslip_model->getAddressSlipById($this->input->get('challan_id'));		
		$data['getOrderDetails'] = $this->addressslip_model->getOrderDetails($this->input->get('challan_id'));
		$data['customerInfo'] = $this->order_model->getCustomerById($data['getOrderDetails']->customer_id);
		$data['challanInfo'] = $this->challan_model->getChallanById($this->input->get('challan_id'));	
		$addSlipProDetails = $this->addressslip_model->getAddressSliPackagepBySingleId($data['package_no'],$data['addressslip_id']);
		
		$data['getAddressSliPackages'] = array();
		
		foreach($addSlipProDetails  as $addSlipProDetail){			
			$result = $this->addressslip_model->getBatchDetailsBaseChallanProduct($data['challan_id'],$addSlipProDetail['product_id']);
			$mgfDate  = new DateTime($result->mfg_date);
			$expDate = new DateTime($result->exp_date);
			$data['getAddressSliPackages'][] = array(
				'model' 			=> 	$addSlipProDetail['model'],		
				'description' 		=> 	$addSlipProDetail['description'],		
				'qty' 				=> 	$addSlipProDetail['qty'],
				'batch' 			=> 	$result->batch_no,
				'mfg_date' 			=> 	$mgfDate->format('m-Y'),
				'exp_date' 			=> 	$expDate->format('m-Y')
				
			);
		}
			
		
		$data['total'] = $data['getaddressslip']->no_of_package;
		
		
		$data['challanInfoProduct'] = $this->addressslip_model->getChallanProductById($this->input->get('challan_id'));		
							
		$this->load->view('address_slip/addressslip_product_details_print', $data);		
	}
	
}