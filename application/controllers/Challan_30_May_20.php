<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Challan extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('challan_model');
		$this->load->model('order_model');
		$this->load->model('quotation_model');
		$this->load->model('customer_model');
		$this->load->model('product_model');
		$this->load->model('bank_model');
		$this->load->language('language_lang');	
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
		$this->load->library('dbvars');
	}
	
	public function index(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order List', '/orderList');
				
		
		$data['page_heading'] = "Create Challan";				
		$data['order_id'] = $this->input->get('order_id');	
		$data['users'] = $this->quotation_model->getUsers();
		$data['packers'] = $this->challan_model->getPackers();
		
		
		$data['orderInfo'] 		= $this->challan_model->getOrderByOId($data['order_id']);
		$data['bankInfo'] 		= $this->order_model->getBankById($data['orderInfo']->bank_id);		
		$data['customerInfo'] 	= $this->order_model->getCustomerById($data['orderInfo']->customer_id);		
		$customerAddressInfo 	= $this->order_model->getCustomerAddressById($data['orderInfo']->customer_id);
		
		if(($data['customerInfo']->store_id ==1) && ($data['customerInfo']->customer_id == $this->config->item('allahabad_customer_id'))) {
			$data['store_id'] = 2;			
		} elseif(($data['customerInfo']->store_id ==2) && ($data['customerInfo']->customer_id == $this->config->item('delhi_customer_id'))) {
			$data['store_id'] = 1;	
		}
		
		$data['addresses'] = array();
		$data['addresses'][] = array(
			'address_id' 		=> 0,
			'address_1' 		=> $data['customerInfo']->address_1,
			'address_2' 		=> $data['customerInfo']->address_2,
			'city' 				=> $data['customerInfo']->city,
			'district' 			=> $data['customerInfo']->district,
			'state_name' 		=> $data['customerInfo']->state_name,
			'pin' 				=> $data['customerInfo']->pin,
			'country_name' 		=> $data['customerInfo']->country_name				
		);

		foreach($customerAddressInfo as $customerAddress){			
			$data['addresses'][] = array(
				'address_id' 		=> $customerAddress['address_id'],
				'address_1' 		=> $customerAddress['address_1'],
				'address_2' 		=> $customerAddress['address_2'],
				'city' 				=> $customerAddress['city'],
				'district' 			=> $customerAddress['district'],
				'state_name' 		=> $customerAddress['state_name'],				
				'pin' 				=> $customerAddress['pin'],
				'country_name' 		=> $customerAddress['country_name']				
			);
		}		
		
		$data['error'] = $this->session->error;		
		$data['orderProducts'] = $this->challan_model->getOrderProductById($data['order_id']);
		$data['stores'] = $this->challan_model->getStore();		
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['orderInfo']->order_id, $data['orderInfo']->quotation_id);		
		$data['lastChallanId'] = $this->challan_model->getLastChallanId();	
		$data['freightCharges'] = $this->challan_model->getChallanFreightCharge($data['order_id']);
		
		$data['freightChargesList'] = $this->challan_model->getChallanFreightChargeList($data['order_id']);	
		$data['banks'] = $this->challan_model->getBanks();	
		
		$data['form_action']= 'challan?order_id='.$data['order_id'];
		
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		
		$this->form_validation->set_rules('challan_type', 'Challan Type', 'required');
		$this->form_validation->set_rules('product_id[]', 'Product Id', 'required',
			array('required' => 'Please select any product to create challan.'));
		$this->form_validation->set_rules('productid[]', 'ProductId', 'required',
			array('required' => 'Please select any product to create challan.'));
		
		$this->form_validation->set_rules('bank_id', 'Confirm Bank', 'required',
			array('required' => 'Please confirm Bank.'));
			
		if($this->input->post('method_of_shipment')){
			$this->form_validation->set_rules('date_of_shipment', 'Date of shipment', 'required',
			array('required' => 'Please select date of shipment.'));			
		}
		
		if($this->input->post('invoice_no')){
			$this->form_validation->set_rules('invoice_date', 'Invoice date', 'required',
			array('required' => 'Please select Invoice date.'));			
		}

		if ($this->form_validation->run() == false) {			
			
			$this->load->view('common/header');
			$this->load->view('challan/challan_form', $data);
			$this->load->view('common/footer');
			unset($_SESSION['error']);
		} else {
			if(($data['customerInfo']->store_id > 0) && ($data['customerInfo']->store_id == $this->input->post('store_id') && ($data['customerInfo']->customer_id == $this->config->item('allahabad_customer_id') || $data['customerInfo']->customer_id == $this->config->item('delhi_customer_id')))){
				
				$data['errorMsg'] = 'Transfer for same store not allowed.';
				$this->load->view('common/header');
				$this->load->view('challan/challan_form', $data);
				$this->load->view('common/footer');
				return false;						
			}
			
			
			$batchArr = $this->input->post('batch_id');			
			if(count($batchArr) > count(array_unique($batchArr))){
				$_SESSION['error']      = "You are select duplicate batch.";
				redirect('/challan?order_id='.$data['order_id']);
				exit;
			}
			
			$proData = $this->input->post('productid');		
			$qty 	= $this->input->post('qty');		
			foreach($proData as $index => $product_id ){				
				$ordProInfo =$this->challan_model->checkPendingQty($data['order_id'],$product_id);
				$pendingQty = ($ordProInfo->qty - $ordProInfo->challan_qty);
				if($qty[$index] > $pendingQty){
					$_SESSION['error']      = "Challan Qty greater then order Qty.";
					redirect('/challan?order_id='.$data['order_id']);
					exit;
				}
			}
			
			$this->challan_model->saveChallan($this->input->post(),$data['customerInfo']);
			$_SESSION['success']      = "Success: You have Added Challan";
			redirect('/challanList');
		}
		
		/* $this->load->view('common/header');
		$this->load->view('challan/challan_form', $data);
		$this->load->view('common/footer');
		unset($_SESSION['error']); */
	}
	
	/* public function saveChallan(){
		$product_id = $this->input->post('product_id');
		$productid = $this->input->post('productid');
		$order_id = $this->input->post('order_id');
		if(empty($product_id)){
			$_SESSION['error']      = "Please select any product to create challan.";
			redirect('/challan?order_id='.$order_id);
			exit;
		}
		if(empty($productid)){
			$_SESSION['error']      = "Please select any product to create challan.";
			redirect('/challan?order_id='.$order_id);
			exit;
		}
		
		$this->challan_model->saveChallan($this->input->post());
		$_SESSION['success']      = "Success: You have Added Challan";
		redirect('/challanList');		
	} */
	
	public function edit($challan_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Challan List', '/challanList');
		
		$data['page_heading'] = 'Challan Edit';
		
		$data['form_action']= site_url().'/challan/edit/'.$challan_id;
		
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);
		$data['users'] = $this->quotation_model->getUsers();
		$data['packers'] = $this->challan_model->getPackers();
		$data['stores'] = $this->challan_model->getStore();
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);
				
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		$data['bankInfo'] = $this->bank_model->getBankById($data['challanInfo']->bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);		
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		$data['banks'] = $this->challan_model->getBanks();
		$customerAddressInfo 	= $this->order_model->getCustomerAddressById($data['orderInfo']->customer_id);
		
		$data['addresses'] = array();
		$data['addresses'][] = array(
			'address_id' 		=> 0,
			'address_1' 		=> $data['customerInfo']->address_1,
			'address_2' 		=> $data['customerInfo']->address_2,
			'city' 				=> $data['customerInfo']->city,
			'district' 			=> $data['customerInfo']->district,
			'state_name' 		=> $data['customerInfo']->state_name,
			'pin' 				=> $data['customerInfo']->pin,
			'country_name' 		=> $data['customerInfo']->country_name				
		);

		foreach($customerAddressInfo as $customerAddress){			
			$data['addresses'][] = array(
				'address_id' 		=> $customerAddress['address_id'],
				'address_1' 		=> $customerAddress['address_1'],
				'address_2' 		=> $customerAddress['address_2'],
				'city' 				=> $customerAddress['city'],
				'district' 			=> $customerAddress['district'],
				'state_name' 		=> $customerAddress['state_name'],				
				'pin' 				=> $customerAddress['pin'],
				'country_name' 		=> $customerAddress['country_name']				
			);
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		
		$this->form_validation->set_rules('new_discount[]', 'New Discount', 'required',
			array('required' => 'Please Enter new discount'));
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('challan/challan_edit_form', $data);
			$this->load->view('common/footer');
			unset($_SESSION['error']);
		} else {			
			$this->challan_model->editChallan($this->input->post(),$challan_id);
			$_SESSION['success']      = "Success: You have Update Challan Discount.";
			redirect('/challanView/'.$challan_id);
		}
	}
	
	public function challanList(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Challan List', '/challanList');		
		$data['success'] = $this->session->success;
		
		$data['stores'] = $this->quotation_model->getStore();
		$data['users'] = $this->quotation_model->getUsers();		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['countries'] = $this->customer_model->getCountry();		
		$data['states'] = $this->customer_model->getState($this->input->get('country_id'));
		
		$data['form_action_delete']= site_url().'/deleteChallan/';
		
		if($this->input->get('per_page')){
			$pageUrl = '&per_page='.$this->input->get('per_page');
		} else {
			$pageUrl = '';
		}
		
		if($this->input->get('order') == 'ASC'){
			$order = '&order=DESC';
		} else {
			$order = '&order=ASC';
		}
		
		$filtered_array = array_filter(array_unique($this->input->get())); 
		unset($filtered_array['sort']);
		unset($filtered_array['order']);		
		$url = http_build_query($filtered_array);
		if($url){
			$url = '&'.$url;
		}				
		
		$data['challan_type_sort'] = site_url().'/challanList?sort=challan_type'. $order . $pageUrl .$url;
		$data['docket_no_sort'] = site_url().'/challanList?sort=docket_no'. $order . $pageUrl .$url;
		$data['customer_name_sort'] = site_url().'/challanList?sort=customer_name'. $order . $pageUrl .$url;
		$data['country_sort'] = site_url().'/challanList?sort=country_name'. $order . $pageUrl .$url;
		$data['state_sort'] = site_url().'/challanList?sort=state_name'. $order . $pageUrl .$url;
		
		
		$data['form_action']= 'challanList';		
		/* Pagination */
		$total_rows = $this->challan_model->getTotalChallan($this->input->get());
		$per_page =25;
		$config['base_url'] = site_url().'/challanList';
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
		
		$data['challanInfo'] = $this->challan_model->getChallan($per_page, $start,$this->input->get());
		
		$i=0;		
		foreach($data['challanInfo'] as $chaInfo){
			$totwithgst = 0;
			if($chaInfo['currency_id'] == 1){
				$productgst = $this->challan_model->getOrderProductGroupGst($chaInfo['challan_id']);				
				if($productgst){					
										
					foreach($productgst as $progst){						
						$totwithgst = $totwithgst + $progst['gst_total_amount'];
					}					
				}
			}
			$freight_charge = $chaInfo['freight_charge'];
			$net_amount = $chaInfo['net_amount'];				
			$data['challanInfo'][$i]['net_total'] = ($net_amount + $freight_charge + $totwithgst);						
			$i++;
		}
		
		#$data['challanInfoProduct'] = $this->challan_model->getChallanProduct();
				
		$this->load->view('common/header');
		$this->load->view('challan/challan_list', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);
	}
	
	public function challanView($challan_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Challan List', '/challanList');
		
		$data['page_heading'] = 'Challan View';
				
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);		
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);		
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
			
		$this->load->view('common/header');
		$this->load->view('challan/challan_view', $data);
		$this->load->view('common/footer');
		
	}
	
	public function challanPrint($challan_id){
						
		/* $data['challanInfo'] = $this->challan_model->getChallanById($challan_id);		
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		$data['bankInfo'] = $this->bank_model->getBankById($data['ordersInfo']->bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);				
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);		
		$this->load->view('challan/challan_print', $data); */
		
		
		$this->load->library('m_pdf');
		//load mPDF library
		#$challan_id = $this->input->post('challan_id');
				
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);		
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);				
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);		
		
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		
		$html= $this->load->view('challan/challan_download', $data,true);
		
		//this the the PDF filename that user will get to download
		#$filename = str_pad($challan_id, 6, "C00000", STR_PAD_LEFT);
		$filename = getChallanNo($challan_id);
		$pdfFilePath = "uploads/challan/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['challanInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:40%;float:left;font-size:15px;text-align:left;">DISPATCH CHALLAN From</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'. getQuotationNo($data['ordersInfo']->quotation_id) .' / '.getOrderNo($data['challanInfo']->order_id).' / '. getChallanNo($challan_id).'</b></div>
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
		$pdf->Output($pdfFilePath, "F");
		$url = base_url().$pdfFilePath;		
		redirect($url);	
	}
	
	public function dispatchNotePrint($challan_id){		
		/* $data['challanInfo'] = $this->challan_model->getChallanById($challan_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);	
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		$data['bankInfo'] = $this->bank_model->getBankById($data['ordersInfo']->bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);				
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);		
		$this->load->view('challan/challan_dispatch_note_print', $data); */
		
		$this->load->library('m_pdf');
		//load mPDF library
		#$challan_id = $this->input->post('challan_id');
				
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);	
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);				
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		
		$html = $this->load->view('challan/challan_dispatch_note_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = "Dispatch Note - ".getChallanNo($challan_id);
		$pdfFilePath = "uploads/challan/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['challanInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:40%;float:left;font-size:15px;text-align:left;">DISPATCH NOTE</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'. getQuotationNo($data['ordersInfo']->quotation_id) .' / '.getOrderNo($data['challanInfo']->order_id).' / '. getChallanNo($challan_id).'</b></div>
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
		$pdf->Output($pdfFilePath, "F");
		$url = base_url().$pdfFilePath;		
		redirect($url);	
	}
	
	public function dispatchNoteSavePdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$challan_id = $this->input->post('challan_id');
				
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);	
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);				
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		
		$html = $this->load->view('challan/challan_dispatch_note_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = "Dispatch Note - ".getChallanNo($challan_id);
		$pdfFilePath = "uploads/challan/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['challanInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:40%;float:left;font-size:15px;text-align:left;">DISPATCH NOTE</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'. getQuotationNo($data['ordersInfo']->quotation_id) .' / '.getOrderNo($data['challanInfo']->order_id).' / '. getChallanNo($challan_id).'</b></div>
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
		$pdf->Output($pdfFilePath, "F");
		
    	$json = array();
		$json[] = array(
			'challan_file' 			=> $pdfFilePath,
			'challan_file_name' 	=> $filename,
			'person' 				=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
			'email_to' 				=> $data['customerInfo']->email
		);
		
		echo json_encode($json);
	}
	
	public function dispatchNote($challan_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Challan View', '/challanView/'.$challan_id);		
		
		$data['page_heading'] = 'Dispatch Note';
		$data['success'] = $this->session->success;		
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);				
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		
		$data['form_action']= 'dispatchNote/'.$challan_id;
		
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		
		if($this->input->post('invoice_no')){
			$this->form_validation->set_rules('invoice_date', 'Invoice date', 'required',
			array('required' => 'Please select Invoice date.'));			
		}
		
		if($this->input->post('method_of_shipment')){
			$this->form_validation->set_rules('date_of_shipment', 'Date of shipment', 'required',
			array('required' => 'Please select Date of shipment.'));			
		}	
		
		if ($this->form_validation->run() == false) {
			
			$this->load->view('common/header');
			$this->load->view('challan/challan_dispatch_note', $data);
			$this->load->view('common/footer');
			unset($_SESSION['success']);
			unset($_SESSION['error']);
		} else {
			
			$challan_id = $this->input->post('challan_id');
			$this->challan_model->addDispatchNote($this->input->post());	
			
			$_SESSION['success']      = "Success: You have Update Dispatch Note";
			redirect('/dispatchNote/'.$challan_id);	
			
		}		
	}
	
	/* public function dispatchNoteSave(){
				
		$challan_id = $this->input->post('challan_id');
		$this->challan_model->addDispatchNote($this->input->post());	
		
		$_SESSION['success']      = "Success: You have Update Dispatch Note";
		redirect('/dispatchNote/'.$challan_id);	
	} */
	
	public function getBatchList(){
		$batchinfo = $this->challan_model->getProductBatchByProId($this->input->post());
		echo json_encode($batchinfo);
	}
	
	public function getProductBatch(){
		$json = array();	
		$batchinfo = $this->challan_model->getProductBatchByProId($this->input->post());
		
		if(!empty($batchinfo)){
			$orderInfo = $this->challan_model->getOrderByOId($this->input->post('order_id'));		
			$orderProducts = $this->challan_model->getOrderProByOIdPId($this->input->post('order_id'),$this->input->post('product_id'));		
			
			$qtyInOrder = $orderProducts->qty - $orderProducts->challan_qty;
			$saleQty = 0;
			$netTotal  = 0;
			
			//$total = 0;
			foreach($batchinfo as $batch){			
				//$avalQtyInBatch = $batch['stock_qty'] - $saleQty;
				$avalQtyInBatch = ($batch['stock_qty'] - $batch['out_qty']) + $batch['return_qty'];
				if($avalQtyInBatch <= 0){
					continue;
				}
				
				if($qtyInOrder > 0){
					if($avalQtyInBatch >= $qtyInOrder){
						
									
						$netTotal = $qtyInOrder * ($orderProducts->rate - $orderProducts->discount);					
						
						$json['list'][] = array(
							'product_id' 		=> $this->input->post('product_id'),
							'model_name' 		=> $orderProducts->model_name,
							'description' 		=> $orderProducts->description,
							'hsn' 				=> $orderProducts->hsn,
							'gst_rate' 			=> $orderProducts->product_gst,
							'pack_unit' 		=> $orderProducts->unit,
							'qty' 				=> $qtyInOrder,
							'rate' 				=> number_format((float)$orderProducts->rate, 4, '.', ''),
							'discount' 			=> number_format((float)$orderProducts->discount, 4, '.', ''),
							'batch_no' 			=> $batch['batch_no'],
							'batch_id' 			=> $batch['batch_id'],
							'net_total' 		=> number_format((float)$netTotal, 2, '.', ''),
							'mfg_date' 			=> date('m-Y',strtotime($batch['mfg_date'])),
							'exp_date' 			=> date('m-Y',strtotime($batch['exp_date']))
						);
						$qtyInOrder = 0;	
						//$total = $total + $netTotal;
						break;
					} elseif($avalQtyInBatch < $qtyInOrder){
						
						$netTotal =  $avalQtyInBatch * ($orderProducts->rate - $orderProducts->discount);
						
						$json['list'][] = array(
							'product_id' 		=> $this->input->post('product_id'),
							'model_name' 		=> $orderProducts->model_name,
							'description' 		=> $orderProducts->description,
							'hsn' 				=> $orderProducts->hsn,
							'gst_rate' 			=> $orderProducts->product_gst,
							'pack_unit' 		=> $orderProducts->unit,
							'qty' 				=> $avalQtyInBatch,
							'rate' 				=> number_format((float)$orderProducts->rate, 4, '.', ''),
							'discount' 			=> number_format((float)$orderProducts->discount, 4, '.', ''),
							'batch_no' 			=> $batch['batch_no'],
							'batch_id' 			=> $batch['batch_id'],
							'net_total' 		=> number_format((float)$netTotal, 2, '.', ''),
							'mfg_date' 			=> date('m-Y',strtotime($batch['mfg_date'])),
							'exp_date' 			=> date('m-Y',strtotime($batch['exp_date']))
						);
						$qtyInOrder = $qtyInOrder - $avalQtyInBatch;					
						//$total = $total + $netTotal;
					}				
				}			
			}		
			//$json['total'] = $total;	
			$json['freight_charges'] = number_format((float)$orderInfo->freight_charge, 2, '.', '');
			//$json['grand_total'] =  $total + $orderInfo->freight_charge;
		} else if(empty($batchinfo)) {
			$json['batch_error'] = 'No stock available for this product.';
		}		
		echo json_encode($json);
	}
	
	public function getProductBatchManul(){
	
		$qtySum = array_sum($this->input->post('qty'));
		$qty = $this->input->post('qty');
		
		$order_pro_qty = $this->input->post('order_pro_qty');
		$batches = $this->input->post('batch_id');
		$store_id = $this->input->post('store_id');
				
		if(($qtySum <= $order_pro_qty) && isset($batches)){			
			$batches = $this->input->post('batch_id');
			$json = array();
			$saleQty = 0;
			$netTotal  = 0;
			$i=0;
			foreach($batches as $batch_id){	
				if($qty[$batch_id] != ''){
					$batchinfo = $this->challan_model->getProductBatchByProIdBthId($this->input->post('product_id'),$batch_id,$store_id);	
					
					$orderInfo = $this->challan_model->getOrderByOId($this->input->post('order_id'));		
					$orderProducts = $this->challan_model->getOrderProByOIdPId($this->input->post('order_id'),$this->input->post('product_id'));
					
					$qtyInOrder = $orderProducts->qty;				
					
					//$total = 0;
					foreach($batchinfo as $batch){					
						$avalQtyInBatch = $qty[$batch_id]; 
						$stock_qty = ($batch['stock_qty'] - $batch['out_qty']) + $batch['return_qty'];
						if($stock_qty <= 0){
							continue;
						}
						if($avalQtyInBatch > $stock_qty){
							$json['error'] = "Qty entered for batch ".$batch['batch_no']." in more than available store.";
							break;
						}
											
						$netTotal = $avalQtyInBatch * ($orderProducts->rate - $orderProducts->discount);					
								
						$json['list'][] = array(
							'product_id' 		=> $this->input->post('product_id'),
							'model_name' 		=> $orderProducts->model_name,
							'description' 		=> $orderProducts->description,
							'hsn' 				=> $orderProducts->hsn,
							'gst_rate' 			=> $orderProducts->product_gst,
							'pack_unit' 		=> $orderProducts->unit,
							'qty' 				=> $avalQtyInBatch,
							'rate' 				=> number_format((float)$orderProducts->rate, 4, '.', ''),
							'discount' 			=> number_format((float)$orderProducts->discount, 4, '.', ''),
							'batch_no' 			=> $batch['batch_no'],
							'batch_id' 			=> $batch['batch_id'],
							'net_total' 		=> number_format((float)$netTotal, 2, '.', ''),
							'mfg_date' 			=> date('m-Y',strtotime($batch['mfg_date'])),
							'exp_date' 			=> date('m-Y',strtotime($batch['exp_date']))
						);
						
					}
					$i++;
				}
			}
			//$json['total'] = $total;	
			$json['freight_charges'] = number_format((float)$orderInfo->freight_charge, 2, '.', '');
			//$json['grand_total'] =  $total + $orderInfo->freight_charge;	
			
		} elseif(empty($batches)){
			$json['error'] = "Please Select Batch.";
		} elseif(empty($qty)){
			$json['error'] = "Please Enter Qty.";
		} elseif($qtySum > $order_pro_qty){
			$json['error'] = "Qty is greater than Ordered Qty.";
		} /* elseif($qtySum < $order_pro_qty){
			$json['error'] = "Qty is Less than Ordered Qty."; 
		} 	 */	
		
		echo json_encode($json);
	}
	
	public function createSli() {
		$data['challan_id'] = $this->input->get('challan_id');
		$data['sli_id'] = $this->input->get('sli_id');
		$data['sli'] = $this->challan_model->getSli();
		$data['challanInfo'] = $this->challan_model->getChallanById($data['challan_id']);
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);		
		$data['sliDocLabel'] = $this->challan_model->getSliDocLabel($data['sli_id']);
		$data['sliDetailInfo'] = $this->challan_model->getSliDetailsByID($data['sli_id'],$data['challan_id']);			
		$data['sliDocInfo'] = $this->challan_model->getSliDocByID($data['sli_id'],$data['sliDetailInfo']->sli_detail_id);
		
		$data['countries'] = $this->customer_model->getCountry();
		
		$data['challan_total'] = $this->challan_model->getChallanFrcTot($data['challan_id']);
		$freight_charges = $data['challan_total']->freight_charges;
		$cost = $data['challan_total']->net_total;
		
		$data['frec'] = 0;
		$data['frec_cost'] = 0;
		if($freight_charges > 0 && $cost == 0){
			$data['frec'] = 1;
		} elseif($freight_charges > 0 && $cost > 0){
			$data['frec_cost'] = 1;
		}
		
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			
			if(empty($this->input->post('country_id')) && ($data['sli_id'] == 2)){				
				$data['error']      = "Please Select Destination Country.";								
				$this->load->view('common/header');
				$this->load->view('challan/challan_sli', $data);				
				$this->load->view('common/footer');
				return false;
			}
			
			/* echo "<pre>";
			print_r($this->input->post());exit; */
			$this->challan_model->addSliDetails($this->input->post());			
			$_SESSION['success']      = "Success: You have Added SLI Details";
			redirect('/createSli?challan_id='.$data['challan_id'].'&sli_id='.$data['sli_id']);
		} else {
			$this->load->view('common/header');
			$this->load->view('challan/challan_sli', $data);				
			$this->load->view('common/footer');	
		}
	}
	
	public function printSli() {
		$this->load->library('m_pdf');
		
		
		$challan_id = $this->input->get('challan_id');
		$sli_id = $this->input->get('sli_id');
		
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);
		$data['customer_info'] = $this->customer_model->getDefaultAddress($data['challanInfo']->customer_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);
		$data['sliDocLabel'] = $this->challan_model->getSliDocLabel($sli_id);
		$data['sliDetailInfo'] = $this->challan_model->getSliDetailsById($sli_id,$challan_id);
		$data['sliDocInfo'] = $this->challan_model->getSliDocByID($sli_id,$data['sliDetailInfo']->sli_detail_id);
		
		$data['challan_total'] = $this->challan_model->getChallanFrcTot($challan_id);
	
		$netTotal = 0;
		foreach($data['challanInfoProduct'] as $challanProduct){
			$netTotal = $netTotal + $challanProduct['net_total'];			
		}				
		if($data['ordersInfo']->currency == 'INR'){
			$productgst = $this->challan_model->getOrderProductGroupGst($challan_id);
			$totwithgst = 0;
			foreach($productgst as $progst){																	
				$totwithgst = $totwithgst + $progst['gst_total_amount'];
			}					
			$netTotal = $netTotal + $totwithgst; 
		}				
		$netTotal = $netTotal + $data['ordersInfo']->freight_charge;
		$data['freight_charge'] = $data['ordersInfo']->freight_charge;
		$data['grand_total'] = $netTotal;
		
		$pdf = $this->m_pdf->load();
		
		$data['tick_img'] = '<img src="'.base_url().'/assets/img/tick.jpg" style="width:10px;">';
		
		if($sli_id == '1'){
			$this->load->view('challan/challan_dhl', $data);
		} else if($sli_id == '2'){
			
			#$this->load->view('challan/challan_fedex', $data);
			
			$html= $this->load->view('challan/challan_fedex', $data,true);
			
			
			$filename = "Fedex-".getChallanNo($challan_id);
			$pdfFilePath = "uploads/challan/".$filename.".pdf"; 

			//actually, you can pass mPDF parameter on this load() function
			 $pdf = $this->m_pdf->load();
			
			$pdf->AddPage('', // L - landscape, P - portrait 
			'', '', '', '',
			2, // margin_left
			2, // margin right
			2, // margin top
			2, // margin bottom
			0, // margin header
			0); // margin footer		
			
			$pdf->WriteHTML($html,2); 
			//offer it to user via browser download! (The PDF won't be saved on your server HDD)
			
			 $pdf->Output($pdfFilePath, "F");
			$url = base_url().$pdfFilePath;		
			redirect($url);	 	 
				
		} else if($sli_id == '3'){			
			$this->load->view('challan/challan_speed_post', $data);	
		}
	}
	
	public function downloadPdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$challan_id = $this->input->get('challan_id');
				
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);		
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);				
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);		
		
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		
		$html= $this->load->view('challan/challan_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = getChallanNo($challan_id);
		$pdfFilePath = $filename.".pdf";

		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
				
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['challanInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:40%;float:left;font-size:15px;text-align:left;">DISPATCH CHALLAN From</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'. getQuotationNo($data['ordersInfo']->quotation_id) .' / '.getOrderNo($data['challanInfo']->order_id).' / '. getChallanNo($challan_id).'</b></div>
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
		$pdf->Output($pdfFilePath, "D");
	}
	
	public function challanSavePdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$challan_id = $this->input->post('challan_id');
				
		$data['challanInfo'] = $this->challan_model->getChallanById($challan_id);		
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);				
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		
		if(empty($data['challanInfo']->bank_id)){
			$bank_id = $data['ordersInfo']->bank_id;
		} else {
			$bank_id = $data['challanInfo']->bank_id;
		}
		
		$data['bankInfo'] = $this->bank_model->getBankById($bank_id);
		$data['challanInfoProduct'] = $this->challan_model->getChallanProductById($data['challanInfo']->challan_id);		
		
		$data['productgst'] = $this->challan_model->getOrderProductGroupGst($challan_id);
		
		$html= $this->load->view('challan/challan_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = getChallanNo($challan_id);
		$pdfFilePath = "uploads/challan/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['challanInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:40%;float:left;font-size:15px;text-align:left;">DISPATCH CHALLAN From</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'. getQuotationNo($data['ordersInfo']->quotation_id) .' / '.getOrderNo($data['challanInfo']->order_id).' / '. getChallanNo($challan_id).'</b></div>
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
		$pdf->Output($pdfFilePath, "F");
		
    	$json = array();
		$json[] = array(
			'challan_file' 			=> $pdfFilePath,
			'challan_file_name' 	=> $filename,
			'person' 				=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
			'email_to' 				=> $data['customerInfo']->email
		);
		
		echo json_encode($json);
	}
	
	public function challanSendMail() {
		
		$config = Array(
		  //'protocol' => 'smtp', 
		  'smtp_host' => 'localhost', 
		  'smtp_port' => '25', 
		  '_smtp_auth' => 'FALSE', 
		  'smtp_crypto' => 'false/none', 
		  'mailtype' => 'html', 
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);
		
		$this->load->library('email',$config);
		
		$to = $this->input->post('email_to');
		$subject = $this->input->post('email_subject');
		$message = $this->input->post('email_massage');
		$challan_file = $this->input->post('challan_file');
		$email_cc = $this->input->post('email_cc');
		
		$this->email->from('info@optitecheyecare.in', 'Optitech eye care');
		$this->email->reply_to('info@optitecheyecare.com', 'Optitech eye care');
		$this->email->to($to);
		
		$this->email->cc($email_cc);
		$this->email->bcc('info@optitecheyecare.com');		

		$this->email->subject($subject);
		$this->email->message(nl2br($message));		
	   
		$attachfile = getcwd().'/'.$challan_file;
		$this->email->attach($attachfile);		
		
		$this->email->send();
		
		echo json_encode($json);
		
	}
	
	public function deleteChallan() {
		if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){ 
			if(empty($this->input->post('deleted_reason'))){
				$result['error']="Please Enter delete reason.";
				echo json_encode($result);
			}else {
				$this->challan_model->deleteChallanById($this->input->post());
				$result['success'] = "Successfully delete Challan";
				echo json_encode($result);
			}
		} else {
			$result['error']="You don't have  permission to delete challan.";
			echo json_encode($result);
		}			
	}
	
	public function viewDeleteReason() {
		
		$result = $this->challan_model->getDeleteReason($this->input->post());
		
		$json['username'] = $result->firstname .' '.$result->lastname;
		$json['deleted_reason'] = $result->deleted_reason;
		$json['deleted_date'] = dateFormat('d-m-Y',$result->deleted_date);
		echo json_encode($json);						
	}
	
}