<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
			$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('returns_model');
		$this->load->model('challan_model');
		$this->load->model('order_model');
		$this->load->model('quotation_model');
		$this->load->model('customer_model');
		$this->load->model('product_model');
		$this->load->language('language_lang');	
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index(){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Returns List', '/returns');
		
		$data['success'] = $this->session->success;		
		
		$data['form_action']= 'returns';
		$data['stores'] = $this->quotation_model->getStore();
		
		/* Pagination */
		$total_rows = $this->returns_model->getTotalChallanProduct($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/returns';
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;		
		$this->pagination->initialize($config);
		$page = 1;			
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
		
		$data['challanProInfo'] = $this->returns_model->getChallanProduct($per_page, $start,$this->input->get());
		
		$this->load->view('common/header');
		$this->load->view('returns/returns_list', $data);
		$this->load->view('common/footer');	
		unset($_SESSION['success']);
	}	
	
	public function addReturns(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Returns List', '/returns');
		$this->breadcrumbs->push('Add Returns', 'addReturns');
		
		$data['action'] = site_url().'/addReturns?challan_no='.$this->input->get('challan_no').'&invoice_no='.$this->input->get('invoice_no');
	
		if($this->input->get('challan_no') || $this->input->get('invoice_no') || $this->input->get('model') || $this->input->get('customer_id')){
			if($this->input->get('challan_no')){
				$data['challan_no'] = $this->input->get('challan_no');
			} else {
				$data['challan_no'] = '';
			}
			
			if($this->input->get('invoice_no')){
				$data['invoice_no'] = $this->input->get('invoice_no');
			} else {
				$data['invoice_no'] = '';
			}
			
			if($this->input->get('id')){
				$data['challan_pro_id'] = $this->input->get('id');
			} else {
				$data['challan_pro_id'] = '';
			}
			
			if($this->input->get('model')){
				$data['product_id'] = $this->input->get('model');
			} else {
				$data['product_id'] = '';
			}
			
			if($this->input->get('customer_id')){
				$data['customer_id'] = $this->input->get('customer_id');
			} else {
				$data['customer_id'] = '';
			}
			
			$data['challanInfo'] = $this->returns_model->getChallanById($data['challan_no'],$data['invoice_no']);
			$data['orderInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);			
			$data['challanProInfo'] = $this->returns_model->getChallanInfo($data['challan_no'],$data['invoice_no'],$data['challan_pro_id'],$data['product_id'],$data['customer_id']);	
			
			$data['returnNotes'] = $this->returns_model->getReturnNote($data['challan_no']);
		}
		
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			
			if($this->input->post('invoice_reason') == ''){
				
				if($this->input->post('invoiceno') == ''){
				
					//$data['error'] = "Invoice details are not saved in dispatch Note/Challan";
					$data['error'] = "Please Enter Reason For no Invoice.";
					$this->load->view('common/header');
					$this->load->view('returns/returns_form', $data);
					$this->load->view('common/footer');									
					return false;
				
				}
				
			}
			
			foreach($this->input->post('sold_qty') as $index => $sold_qty){
				$qty_returns = $this->input->post('qty_returns');
				if($qty_returns[$index] > $sold_qty){
					$data['error'] = "Please Enter Sold Qty Or Less then";
					$this->load->view('common/header');
					$this->load->view('returns/returns_form', $data);
					$this->load->view('common/footer');									
					return false;
				}							
			}		
						
			$this->returns_model->addReturns($this->input->post());			
			$_SESSION['success'] = "Success: You have Returns Qty";
			redirect('/returns');
		}
		
		$this->load->view('common/header');
		$this->load->view('returns/returns_form', $data);
		$this->load->view('common/footer');					
	}
	
	public function returnsPrint(){
					
		if($this->input->get('challan_no') || $this->input->get('invoice_no') || $this->input->get('model') || $this->input->get('customer_id')){
			if($this->input->get('challan_no')){
				$data['challan_no'] = $this->input->get('challan_no');
			} else {
				$data['challan_no'] = '';
			}
			
			if($this->input->get('invoice_no')){
				$data['invoice_no'] = $this->input->get('invoice_no');
			} else {
				$data['invoice_no'] = '';
			}
			
			if($this->input->get('id')){
				$data['challan_pro_id'] = $this->input->get('id');
			} else {
				$data['challan_pro_id'] = '';
			}
			
			if($this->input->get('model')){
				$data['product_id'] = $this->input->get('model');
			} else {
				$data['product_id'] = '';
			}
			
			if($this->input->get('customer_id')){
				$data['customer_id'] = $this->input->get('customer_id');
			} else {
				$data['customer_id'] = '';
			}
			
			$data['challanInfo'] = $this->returns_model->getChallanById($data['challan_no'],$data['invoice_no']);
			
			$data['orderInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);	
			$data['customerInfo'] 	= $this->order_model->getCustomerById($data['orderInfo']->customer_id);
			$data['challanProInfo'] = $this->returns_model->getChallanInfo($data['challan_no'],$data['invoice_no'],$data['challan_pro_id'],$data['product_id'],$data['customer_id']);	

			$data['returnNotes'] = $this->returns_model->getReturnNote($data['challan_no']);
			
			$this->load->library('m_pdf');
				
			$html= $this->load->view('returns/returns_print', $data,true);
			
			//this the the PDF filename that user will get to download
			#$filename = str_pad($challan_id, 6, "C00000", STR_PAD_LEFT);
			$filename = getChallanNo($data['challan_no']);
			$pdfFilePath = "uploads/challan/".$filename.".pdf";


			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			//generate the PDF!
			//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
			//$pdf->WriteHTML($stylesheet,1);
			
			$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:0px solid black;">	
		<div style="width:100%;padding-top:30px;padding-bottom:25px;">
			<div style="width:100%;text-align:center;"><img src="'.base_url().$data['challanInfo']->store_logo.'"></div>	
		</div>	
		<div style="width:100%;float:left;font-size:15px;text-align:center;">Goods Return (Store - '. $data['challanInfo']->store_name .' )</div>			
	</div>';

			$footer = '<div style="margin-right: 25px;margin-left: 25px;font-size:12px;width:100%;text-align:right;"><span>Page - {PAGENO}</span></div>';
			
			$pdf->SetHTMLHeader($header);
			$pdf->SetHTMLFooter($footer);
			$pdf->AddPage('', // L - landscape, P - portrait 
			'', '', '', '',
			0, // margin_left
			0, // margin right
		   55, // margin top
		   25, // margin bottom
			0, // margin header
			0); // margin footer	
			
			
			$pdf->WriteHTML($html,2);
			//offer it to user via browser download! (The PDF won't be saved on your server HDD)
			$pdf->Output($pdfFilePath, "I");
			$url = base_url().$pdfFilePath;		
			redirect($url);
			
		}		
	}
		
}