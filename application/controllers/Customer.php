<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('customer_model');
		$this->load->model('quotation_model');
		$this->load->model('order_model');
		$this->load->model('challan_model');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index() {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$data['page_heading'] = "Customer List";
	    
		$data['success'] = $this->session->success;
		
		$data['form_action']= 'customer';
		$data['customers'] = array();
		$data['countries'] = $this->customer_model->getCountry();
		
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
		
		$data['company_name_sort'] = site_url().'/customer/index?sort=company_name'. $order . $pageUrl .$url;
		$data['contact_person_sort'] = site_url().'/customer/index?sort=contact_person'. $order . $pageUrl .$url;
		$data['email_sort'] = site_url().'/customer/index?sort=email'. $order . $pageUrl .$url;			
		
		
		/* Pagination */	
		$total_rows = $this->customer_model->getTotalCustomers($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/customer/index';	
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
		
		$data['customers'] = array();	
		$data['customers'] = $this->customer_model->getCustomers($per_page, $start,$this->input->get());
		
		/* foreach($customers as $customer){			
			$outstand_balance = $this->customer_model->getOutStandingBalanceById($customer['customer_id']);
			$customer_amount = ($customer['customer_amount']=='') ? 0 : $customer['customer_amount'];
			$challanTotal = $this->customer_model->getChallanTotalByCustomerId($customer['customer_id']);
			
			$color='';
			
			if(($outstand_balance > '0') && ($customer_amount == '0')){
				$color='red';
			}
			
			if(($outstand_balance > '0') && ($customer_amount > '0')){
				$color='#f8d7da'; //pink
			}
			
			if(($outstand_balance == '0') && ($challanTotal['net_total'] > '0') && ($customer_amount > '0')){
				$color='#28a745';  //green
			} 
			
			$data['customers'][] = array(
				'customer_id' 			=> $customer['customer_id'],
				'company_name' 			=> $customer['company_name'],
				'person_title' 			=> $customer['person_title'],
				'contact_person' 		=> $customer['contact_person'],
				'email' 				=> $customer['email'],
				'mobile' 				=> $customer['mobile'],
				'country_name' 			=> $customer['country_name'],
				'outstand_balance' 		=> $outstand_balance,
				'customer_amount' 		=> $customer['customer_amount'],
				'color'					=> $color
			);
		} */
		
		
					
		$this->load->view('common/header');
		$this->load->view('customer/customer_list', $data);
		$this->load->view('common/footer');		
		unset($_SESSION['success']);
	}
	
	public function addCustomer() {	
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Customer', '/addCustomer');
		$data['page_heading'] = "Add Customer";
	    
		$data['form_action']= 'addCustomer';
        
        $data['titles'] = $this->customer_model->getTitle();
		$data['countries'] = $this->customer_model->getCountry();
		$data['carriers'] = $this->challan_model->getSli();
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_message('contactVerify', 'Either Mobile or Email is required');

		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|callback_contactVerify[email]|is_unique[customer.mobile]');
		$this->form_validation->set_rules('email', 'Email', 'trim|callback_contactVerify[mobile]');

		
		$this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[customer.email]');
		
		
		if ($this->form_validation->run() == false) {
			
			if(form_error('email')){
				$customerInfoByEmail =$this->customer_model->getCustomerByEmail($this->input->post('email'));
				$data['ref_id'] = $customerInfoByEmail->ref_id;
				$data['unique_mess'] = 'This email id is already registered for a customer. If you want to assign this email id to new customer, press OK other wise press SKIP';
			} else if(form_error('mobile')) {
				$customerInfoByMobile =$this->customer_model->getCustomerByMobile($this->input->post('mobile'));
				$data['ref_id'] = $customerInfoByMobile->ref_id;
				$data['unique_mess'] = 'This Mobile is already registered for a customer. If you want to assign this email id to new customer, press OK other wise press SKIP';
			} else {
				$data['unique_mess'] = '';
			}
			
			$this->load->view('common/header');
			$this->load->view('customer/customer_form', $data);
			$this->load->view('common/footer');			
		} else {			
			$this->customer_model->addCustomer($this->input->post());			
			$_SESSION['success']      = "Success: You have Added New Customer";
			redirect('/customer');
		}		
	}
	
	 public function addUniqueCustomer() {	    
		$this->customer_model->addCustomer($this->input->post());			
		$mess      = "Success: You have Added New Customer";
		echo json_encode($html);			
	} 
	

	public function contactVerify($contact, $otherField) {
		
		return ($contact != '' || $this->input->post($otherField) != '');
	}	
	
	public function editCustomer($customer_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		$this->breadcrumbs->push('Edit Customer', '/editCustomer');
		$data['page_heading'] = "Edit Customer";
		
		$data['titles'] = $this->customer_model->getTitle();
		$data['countries'] = $this->customer_model->getCountry();
		$data['customer'] = $this->customer_model->getCustomerById($customer_id);
		$data['carriers'] = $this->challan_model->getSli();
		
		$data['form_action']= 'editCustomer/'.$customer_id;		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');		
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('customer/customer_form', $data);
			$this->load->view('common/footer');			
		} else {			
			$this->customer_model->editCustomer($this->input->post());			
			$_SESSION['success']      = "Success: You have Added Customer";
			redirect('/customer');			
		}		
	}
	
	public function priceList($customer_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$data['page_heading'] = "Customer price list";
		
		$data['customer'] = $this->customer_model->getCustomerById($customer_id);		
		$data['priceLists'] = $this->customer_model->getCustomerPriceList($customer_id);		
			
		$this->load->view('common/header');
		$this->load->view('customer/customer_pricelist', $data);
		$this->load->view('common/footer');			
			
	}
	
	public function ajaxGetSatetByCountryId() {
		$country_id = $this->input->post('country_id');		
		$states = $this->customer_model->getState($country_id);		
		echo json_encode($states);
	}
	
	public function addNewState() {
		
		$states = $this->customer_model->addState($this->input->post());		
		echo json_encode($states);
	}	
	
	public function addCarrier() {
		
		$carrier = $this->customer_model->addCarrier($this->input->post());		
		echo json_encode($carrier);
	}	
	
	public function customerView($customer_id){
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
	    
		$data['customer'] = $this->customer_model->getCustomerById($customer_id);
		$countryName = $this->customer_model->getCountryByID($data['customer']->country_id);
		$stateName = $this->customer_model->getStateByID($data['customer']->state_id);
		$data['customer']->country = $countryName->name;
		$data['customer']->state = $stateName->name;
		
		$this->load->view('common/header');
		$this->load->view('customer/customer_view', $data);
		$this->load->view('common/footer');

	}
	
	public function getCustomerName(){
		$name = $this->input->post('name');
		$customers = $this->customer_model->getCustomerName($name);			
		echo json_encode($customers);
	}
	
	public function getDefaultAddressCustomerById() {
		$customer_id = $this->input->post('customer_id');
		$customers = $this->customer_model->getDefaultAddressCustomerById($customer_id);		
		echo json_encode($customers);
	}
	
	public function addNewAddress(){
		$data = $this->input->post();
		
		$addresses = $this->customer_model->addNewAddress($data);			
		echo json_encode($addresses);
	}
	
	public function getAddressByAddressId(){
		$data = $this->input->post();
		
		if($data['address_id'] > 0){
			$addresses = $this->customer_model->getAddressByAddressId($data['address_id']);
		} else {
			$addresses = $this->customer_model->getDefaultAddress($data['customer_id']);
		}
		
		$adrss = array(
			'company_name'	 	=> $addresses->company_name,
			'address_1'	 		=> $addresses->address_1,
			'address_2'	 		=> $addresses->address_2,	
			'country_name'	 	=> $addresses->country_name,	
			'state_name'	 	=> $addresses->state_name,	
			'city'	 			=> $addresses->city,	
			'district'	 		=> $addresses->district,	
			'pin'	 			=> $addresses->pin,	
			'phone'	 			=> $addresses->phone,	
			'mobile'	 		=> $addresses->mobile,	
			'email'	 			=> $addresses->email,	
			'contact_person'   	=> $addresses->person_title .' '. $addresses->contact_person,	
		);
					
		echo json_encode($adrss);
	}
	
	public function customerHistory($customer_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$data['page_heading'] = "Customer History";
		
		$data['customer'] = $this->customer_model->getCustomerById($customer_id);
		
		$data['quotations'] = array();		
		$quotations = $this->customer_model->getCustomerQuotationById($customer_id);
		
		$net_total1 =0;
		foreach($quotations as $quotation){	
			$net_total1 = $quotation['net_amount'];
			$freight_charge = $quotation['freight_charge'];
			$freight_gst = $quotation['freight_gst'];
			$totwithgst = 0;
			if($quotation['currency'] == 'INR') {
				$quoteProductInfo = $this->quotation_model->getQuotationProductGroupGst($quotation['quote_id']);		
				
				#$net_total = array_sum(array_column($quoteProductInfo,'net_amount'));
				
				
				foreach($quoteProductInfo as $progst){
					/*$perProFrch = ($freight_charge / $net_total1) * $progst['net_amount'];
					$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;*/
					
					$perProFrchWthGst=0;
					if($freight_gst==0){
						$perProFrch = ($freight_charge / $quotation['net_amount']) * $progst['net_amount'];
						$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					}
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
					
				}
				
				if($freight_gst>0){
    				$perProFrchWthGst = ($freight_charge * $freight_gst/100);
    				$totwithgst= $totwithgst + $perProFrchWthGst;
    			}
			}
			
			$quotation['grand_total'] = number_format((float)($net_total1 + $freight_charge + $totwithgst), 2, '.', '');	
			
			$data['quotations'][] = $quotation;			
		}			
				
		$data['orders'] = array();
		$data['advices'] = array();
		$orders = $this->customer_model->getCustomerOrderById($customer_id);
		foreach($orders as $order){
			#$orderProducts = $this->order_model->getOrderProductById($order['order_id'], $order['quotation_id']);
			$totalChallan = $this->order_model->getOrderProductChallan($order['order_id'], $order['quotation_id']);
			$net_total2 = $order['net_amount'];
			$totwithgst = 0;
			$freight_charge = $order['freight_charge'];
			$freight_gst = $order['freight_gst'];
			if($order['currency'] == 'INR'){
				$productgst = $this->order_model->getOrderProductGroupGst($order['order_id'], $order['quotation_id']);
				
				foreach($productgst as $progst){
					/*$perProFrch = ($freight_charge / $net_total2) * $progst['net_amount'];
					$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;*/
					
					$perProFrchWthGst=0;
					if($freight_gst==0){
						$perProFrch = ($freight_charge / $net_total2) * $progst['net_amount'];
						$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					}
					#Added by Arun end
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
				}
				
				if($freight_gst>0){
    				$perProFrchWthGst = ($freight_charge * $freight_gst/100);
    				$totwithgst= $totwithgst + $perProFrchWthGst;
    			}
			}
			
			$orderTotal = number_format((float)($net_total2 + $order['freight_charge'] + $totwithgst), 2, '.', '');			
			
			$totalOrderQty = array_sum(array_column($totalChallan,'qty'));
			 $totalOrderedQty = array_sum(array_column($totalChallan,'challan_qty'));
			$advices = $this->order_model->getAdvices($order['order_id']);
			
			$advicesTotal = array_sum(array_column($advices,'amount'));
			
			$totOrdQty = $totalOrderQty - $totalOrderedQty;
			
			$data['orders'][] = array(
				'order_id' 				=> $order['order_id'],
				'quotation_id' 			=> $order['quotation_id'],
				'customer_name' 		=> $order['customer_name'],
				'currency_faclass' 		=> $order['currency_faclass'],
				'order_total' 			=> $orderTotal,
				'advice_total' 			=> $advicesTotal,
				'order_date' 			=> $order['order_date'],		
				//'totalChallan' 			=> $totalChallan,		
				'totalOrderProduct' 	=> $totOrdQty		
			);

		    $data['advices'] = $advices;
			
		}
		$inr=0;
		$usd=0;
		$gbp=0;
		$eur=0;
		
		foreach($advices as $advice){
			if($advice['currency_id'] == 1){
				$inr = $inr + $advice['amount'];
			}
			if($advice['currency_id'] == 2){
				$usd = $usd + $advice['amount'];
			}
			if($advice['currency_id'] == 3){
				$eur = $eur + $advice['amount'];
			}
			if($advice['currency_id'] == 4){
				$gbp = $gbp + $advice['amount'];
			}
		}
		
		$data['inr'] = $inr;
		$data['usd'] = $usd;
		$data['gbp'] = $gbp;
		$data['eur'] = $eur;
		
		$data['challanInfo'] = array();
		$challanInfo = $this->customer_model->getCustomerChallanById($customer_id);
		#$freight_charge_challan = $challanInfo['freight_charge'];
		foreach($challanInfo as $challan){
			#$challanInfoProduct = $this->challan_model->getChallanProductById($challan['challan_id']);			
			$freight_charge_challan = $challan['freight_charges'];
			$net_total = $challan['net_total'];
			$ordersInfo = $this->order_model->getOrderById($challan['order_id']);
			$totwithgst = 0;
			if($ordersInfo->currency == 'INR'){
				$challanproductgst = $this->challan_model->getOrderProductGroupGst($challan['challan_id']);			
												
				foreach($challanproductgst as $progst){																
					$totwithgst = $totwithgst + $progst['gst_total_amount'];
				}
			}
			
			$challan['grand_total'] = number_format((float)($net_total + $freight_charge_challan + $totwithgst), 2, '.', '');			
			$challan['currency_faclass'] = $ordersInfo->currency_faclass;			
			$data['challanInfo'][] = $challan;
		}
		
		$data['returnInfo'] = $this->customer_model->getReturnProductById($customer_id);		
		
		$data['returnQty'] = array_sum(array_column($data['returnInfo'],'return_qty'));
		
		$this->load->view('common/header');
		$this->load->view('customer/customer_history', $data);
		$this->load->view('common/footer');			
			
	}
	
	public function payment(){
	    
		$data['page_heading'] = "Customer Payment";
		
		$data['success'] = $_SESSION['success'];
		
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$customer_id = $this->input->get('customer_id');
		$year = $this->input->get('year');
		
		//$data['form_action']= 'customer/payment?customer_id='.$customer_id;
		
		
		$data['customerInfo'] = $this->customer_model->getCustomerById($customer_id);
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['modeOfPaymentInfo'] = $this->customer_model->getModeOfPayment();
		
		$data['ChallanTotal'] = $this->customer_model->getChallanTotalByCustomerId($customer_id);
		$In = array();
		$Out = array();
		$customerPayments = $this->customer_model->getCustomerPaymentById($customer_id,$year);
		$customerPaymentTotal = $this->customer_model->getCustomerPaymentTotal($customer_id);
		$customerGoodsReturnTotal = $this->customer_model->getCustomerGoodsReturnTotal($customer_id);
		#exit;
		$customerTotalPayment = 0;
		foreach($customerPayments as $customerPayment){
			$customerTotalPayment = $customerTotalPayment + $customerPayment['amount'];
			
			if($customerPayment['file_total'] > 0){
				//$refChallan = '<a href="'.base_url().'uploads/bank/'.$customerPayment['reference_document'].'">'.$customerPayment['reference_number'].'</a>';
				$refChallan = '<a href="#" class="viewFile" id="'.$customerPayment['customer_payment_id'].'">'.$customerPayment['reference_number'].'</a>';
			}else{
				$refChallan = $customerPayment['reference_number'];
			}
			
			
			$In[] = array(				
				'date_time' 			=> $customerPayment['date_of_payment'],
				'status' 				=>	'',
				'mark' 					=>	'',
				'challan_id' 			=> $refChallan,
				'in' 					=> $customerPayment['amount'],
				'note' 					=> $customerPayment['note'],
				'bank_name' 			=> $customerPayment['bank_name'],
				'customer_payment_id' 	=> $customerPayment['customer_payment_id'],
				'currency_faclass' 		=> $customerPayment['currency_faclass'],
				'action' 				=> '<a target="_blank" href="'.site_url('customer/paymentView').'?customer_id='.$customer_id.'&payment_id='.$customerPayment['customer_payment_id'].'"><i class="fas fa-eye"></i></a>'
			);
		}
		
		$data['all_paymentIn'] = $In;
		
		#$data['total_amount'] = $customerTotalPayment;
		$data['total_amount'] = $customerPaymentTotal->amount+round($customerGoodsReturnTotal);
		
		$challanPayments = $this->customer_model->getChallanPaymentById($customer_id,$year);
		
		
		foreach($challanPayments as $challanPayment){
			
			#print_r($challanPayment);exit;
			$currencyInfo = $this->customer_model->getCurrencyById($challanPayment['currency_id']);
			$challanPaymentStatus = $this->customer_model->getChallanPaymentStatus($challanPayment['challan_id']);
			$status = '';
			if($challanPaymentStatus->user_modify_mark){
				$status = $challanPaymentStatus->user_modify_mark;
			}else{
				$status = $challanPaymentStatus->user_mark;
			}
			
			$grand_total =  $challanPayment['netTotal'] + $challanPayment['freight_charges'] + $challanPayment['gst_total_amount'];
			$Out[] = array(
				'date_time' 			=>	$challanPayment['challan_date'],
				'cid' 					=>	$challanPayment['challan_id'],
				'status' 				=>	$status,
				'mark' 					=>	$challanPayment['challan_id'],
				'challan_id' 			=>	'<a target="_blank" href="'.site_url('challanView').'/'.$challanPayment['challan_id'].'">'.getChallanNo($challanPayment['challan_id']).'</a>',
				'out' 					=> $grand_total,
				'note' 					=> '',
				'bank_name' 			=> '',
				'customer_payment_id' 	=> '',
				'currency_faclass' 		=> $currencyInfo->currency_faclass,
				'action' 				=> ''
			);
		}
		
		$data['all_paymentBill'] = $Out;
		
		$paymentSummary = array();
		$paymentSummary = array_merge($In, $Out);
		
		foreach ($paymentSummary as $key => $part) {
			$date_time = new DateTime($part['date_time']);			
		   $sort[$key] = str_replace('-', '', $date_time->format('Y-m-d'));		 
		}
		array_multisort($sort, SORT_DESC, $paymentSummary);		
		
		//$data['paymentSummary'] = $paymentSummary;
		$data['paymentSummary'] = $paymentSummary;
				
		$data['banks'] = $this->quotation_model->getBanks();
		
		//$data['html'] = $this->load->view('customer/customer_payment_form', $data,true);
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		$this->form_validation->set_rules('date_of_payment', 'Date of Payment', 'required');		
	    
		if ($this->form_validation->run() == false) {
			
			$this->load->view('common/header');
			$this->load->view('customer/customer_payment', $data);
			$this->load->view('common/footer');	
			unset($_SESSION['success']);
		} else {
			
			/* if(!empty($_FILES['bank_file']['name'])){
				$config['upload_path'] = 'uploads/bank';
				$config['allowed_types'] = '*';
				$config['file_name'] = $_FILES['bank_file']['name'];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('bank_file')){
					$uploadData = $this->upload->data();						
					$bank_file = $uploadData['file_name'];
				}else{
					$bank_file = '';
				}					
			}else{
				$bank_file = '';
			} */
			
			$bank_file=array();
			 if(!empty($_FILES['bank_file']['name']) && count(array_filter($_FILES['bank_file']['name'])) > 0){ 
                $filesCount = count($_FILES['bank_file']['name']); 
                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     	= $_FILES['bank_file']['name'][$i]; 
                    $_FILES['file']['type']     	= $_FILES['bank_file']['type'][$i]; 
                    $_FILES['file']['tmp_name'] 	= $_FILES['bank_file']['tmp_name'][$i]; 
                    $_FILES['file']['error']     	= $_FILES['bank_file']['error'][$i]; 
                    $_FILES['file']['size']     	= $_FILES['bank_file']['size'][$i]; 
					
					$config['upload_path'] = 'uploads/bank';
					$config['allowed_types'] = '*';
					$config['file_name'] = $_FILES['bank_file']['name'][$i];
   					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					                     
                    // Upload file to server 
                    if($this->upload->do_upload('file')){                       
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];   
						$bank_file[] = $filename; 
                    } 
                }
			 } 	
			
			
			$this->customer_model->addCustomerPyament($this->input->post(),$customer_id,$bank_file);			
			$_SESSION['success']      = "Success: You have Added Customer Payment";
			redirect('/customer/payment?customer_id='.$customer_id);
		}		
		
	}
	
	public function paymentEdit(){
		$data['page_heading'] = "Customer Payment Edit";
		
		$data['success'] = $_SESSION['success'];
		
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$customer_id = $this->input->get('customer_id');
		$payment_id = $this->input->get('payment_id');
		
		$data['customerInfo'] = $this->customer_model->getCustomerById($customer_id);
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['modeOfPaymentInfo'] = $this->customer_model->getModeOfPayment();
		
		$data['ChallanTotal'] = $this->customer_model->getChallanTotalByCustomerId($customer_id);
		$data['outstand_balance'] = $this->customer_model->getOutStandingBalanceById($customer_id);	
		
		$data['customerPayments'] = $this->customer_model->getPaymentById($customer_id,$payment_id);
		$data['customerPaymentFile'] = $this->customer_model->getPaymentFile($payment_id);
		$data['banks'] = $this->quotation_model->getBanks();
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		$this->form_validation->set_rules('date_of_payment', 'Date of Payment', 'required');		
	    
		if ($this->form_validation->run() == false) {
			
			$this->load->view('common/header');
			$this->load->view('customer/customer_payment_form', $data);
			$this->load->view('common/footer');	
			unset($_SESSION['success']);
		} else {
			
			/* if(!empty($_FILES['bank_file']['name'])){
				$config['upload_path'] = 'uploads/bank';
				$config['allowed_types'] = '*';
				$config['file_name'] = $_FILES['bank_file']['name'];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('bank_file')){
					$uploadData = $this->upload->data();						
					$bank_file = $uploadData['file_name'];
				}else{
					$bank_file = '';
				}					
			} */
			
			
			$bank_file=array();
			 if(!empty($_FILES['bank_file']['name']) && count(array_filter($_FILES['bank_file']['name'])) > 0){ 
                $filesCount = count($_FILES['bank_file']['name']); 
                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     	= $_FILES['bank_file']['name'][$i]; 
                    $_FILES['file']['type']     	= $_FILES['bank_file']['type'][$i]; 
                    $_FILES['file']['tmp_name'] 	= $_FILES['bank_file']['tmp_name'][$i]; 
                    $_FILES['file']['error']     	= $_FILES['bank_file']['error'][$i]; 
                    $_FILES['file']['size']     	= $_FILES['bank_file']['size'][$i]; 
					
					$config['upload_path'] = 'uploads/bank';
					$config['allowed_types'] = '*';
					$config['file_name'] = $_FILES['bank_file']['name'][$i];
   					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					                     
                    // Upload file to server 
                    if($this->upload->do_upload('file')){                       
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];   
						$bank_file[] = $filename; 
                    } 
                }
			 } 	
			
			$this->customer_model->editCustomerPyament($this->input->post(),$customer_id,$bank_file,$payment_id);			
			$_SESSION['success']      = "Success: You have Added Customer Payment";
			redirect('/customer/payment?customer_id='.$customer_id);
		}		
		
	}
	
	public function paymentView(){
		$data['page_heading'] = "Customer Payment View";
		
		$data['success'] = $_SESSION['success'];
		
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Customers', '/customer');
		
		$customer_id = $this->input->get('customer_id');
		$payment_id = $this->input->get('payment_id');
		
		$data['customerInfo'] = $this->customer_model->getCustomerById($customer_id);
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['modeOfPaymentInfo'] = $this->customer_model->getModeOfPayment();
		
		$data['ChallanTotal'] = $this->customer_model->getChallanTotalByCustomerId($customer_id);
		$data['outstand_balance'] = $this->customer_model->getOutStandingBalanceById($customer_id);	
		
		$data['customerPayments'] = $this->customer_model->getPaymentById($customer_id,$payment_id);
		$data['payment_file'] = $this->customer_model->getPaymentFile($payment_id);
		/* echo "<pre>";
		print_r($data['customerPayments']);exit; */
		$data['banks'] = $this->quotation_model->getBanks();
							
		$this->load->view('common/header');
		$this->load->view('customer/customer_payment_view', $data);
		$this->load->view('common/footer');			
	}
	
	public function paymentPrint(){
				
		$this->load->library('m_pdf');
		//load mPDF library
		$customer_id = $this->input->get('customer_id');
		$year = $this->input->get('year');
		
		$data['customerInfo'] = $this->customer_model->getCustomerById($customer_id);
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['modeOfPaymentInfo'] = $this->customer_model->getModeOfPayment();
		
		$data['ChallanTotal'] = $this->customer_model->getChallanTotalByCustomerId($customer_id);
				
		$In = array();
		$Out = array();
		$customerPayments = $this->customer_model->getCustomerPaymentById($customer_id,$year);
		$customerPaymentTotal = $this->customer_model->getCustomerPaymentTotal($customer_id);
		$customerGoodsReturnTotal = $this->customer_model->getCustomerGoodsReturnTotal($customer_id);
		
		$customerTotalPayment = 0;
		foreach($customerPayments as $customerPayment){
			$customerTotalPayment = $customerTotalPayment + $customerPayment['amount'];
			
			if($customerPayment['reference_document']){
				$refChallan = '<a href="'.base_url().'uploads/bank/'.$customerPayment['reference_document'].'">'.$customerPayment['reference_number'].'</a>';
			}else{
				$refChallan = $customerPayment['reference_number'];
			}
			
			if(empty($customerPayment['currency_html'])){
				$customerPayment['currency_html']='<img src="'.base_url().'/assets/img/rupee.png" style="width:6px;">';
			}
			
			$In[] = array(				
				'date_time' 			=> $customerPayment['date_of_payment'],
				'challan_id' 			=> $refChallan,
				'in' 					=> $customerPayment['amount'],
				'note' 					=> $customerPayment['note'],
				'bank_name' 			=> $customerPayment['bank_name'],
				'currency_faclass' 		=> $customerPayment['currency_html']
			);
		}
		
		$data['all_paymentIn'] = $In;
		
		#$data['total_amount'] = $customerTotalPayment;
		$data['total_amount'] = $customerPaymentTotal->amount+round($customerGoodsReturnTotal);
		
		$challanPayments = $this->customer_model->getChallanPaymentById($customer_id,$year);
		
		foreach($challanPayments as $challanPayment){
			
			$currencyInfo = $this->customer_model->getCurrencyById($challanPayment['currency_id']);
			
			if(empty($currencyInfo->currency_html)){
				$currencyInfo->currency_html='<img src="'.base_url().'/assets/img/rupee.png" style="width:6px;">';
			}
			
			$grand_total =  $challanPayment['netTotal'] + $challanPayment['freight_charges'] + $challanPayment['gst_total_amount'];
			$Out[] = array(
				'date_time' 	=>	$challanPayment['challan_date'],
				'cid' 	=>	$challanPayment['challan_id'],
				'challan_id' 	=>	'<a target="_blank" href="'.site_url('challanView').'/'.$challanPayment['challan_id'].'">'.getChallanNo($challanPayment['challan_id']).'</a>',
				'out' 			=> $grand_total,
				'note' 			=> '',
				'bank_name' 	=> '',
				'currency_faclass' 		=> $currencyInfo->currency_html
			);
		}
		
		$data['all_paymentBill'] = $Out;
		
		$paymentSummary = array();
		$paymentSummary = array_merge($In, $Out);
		
		foreach ($paymentSummary as $key => $part) {
			$date_time = new DateTime($part['date_time']);			
		    $sort[$key] = str_replace('-', '', $date_time->format('Y-m-d'));		 
		}
		array_multisort($sort, SORT_DESC, $paymentSummary);		
		
		//$data['paymentSummary'] = $paymentSummary;
		$data['paymentSummary'] = $paymentSummary;
		
		$html= $this->load->view('customer/customer_payment_print', $data,true);
		
		//this the the PDF filename that user will get to download
		#$filename = str_pad($challan_id, 6, "C00000", STR_PAD_LEFT);
		$filename = getChallanNo($challan_id);
		$pdfFilePath = "uploads/challan/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:0px solid black;"><div style="width:100%;font-size:20px;text-align:center;">Customer Payments</div></div>';

		$footer = '<div style="font-size:12px;text-align:right;"><span>Page - {PAGENO}</span></div>';
		
		$pdf->SetHTMLHeader($header);
		$pdf->SetHTMLFooter($footer);
		$pdf->AddPage('', // L - landscape, P - portrait 
        '', '', '', '',
        15, // margin_left
        15, // margin right
       20, // margin top
       20, // margin bottom
        0, // margin header
        0); // margin footer	
		
		
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "I");
		$url = base_url().$pdfFilePath;		
		redirect($url);	
		
	}
	
	public function addChallanPaymentStatus(){
		$data = $this->input->post();
		if($data['status']=="off" && $_SESSION['username']=="admin"){
			$challanPaymentStatus = $this->customer_model->addChallanPaymentStatus($data);
		}else if($data['status']=="on"){
			$challanPaymentStatus = $this->customer_model->addChallanPaymentStatus($data);
		}else{
			$challanPaymentStatus = array("error" => "You are not admin.");
		}					
		echo json_encode($challanPaymentStatus);
	}
	
	public function getCustomerPaymentNote(){
		$customer_id = $this->input->post('customer_id');		
		$payment_id = $this->input->post('payment_id');		
		$customerPayments = $this->customer_model->getPaymentById($customer_id,$payment_id);
		$customerPayments->amount = number_format((float)$customerPayments->amount, 2, '.', '');
		echo json_encode($customerPayments);
	}
	
	public function getPaymentFile(){
		$customer_payment_id = $this->input->post('customer_payment_id');		
		$results = $this->customer_model->getPaymentFile($customer_payment_id);	
		echo json_encode($results);
	}
	
	public function delPaymentFile(){
		$file_id = $this->input->post('file_id');
		$results = $this->customer_model->delPaymentFile($file_id);	
		echo json_encode($results);
	}
	
	public function getChallanPaymentStatus(){
		$challan_id = $this->input->post('challan_id');
		$results = $this->customer_model->getChallanPaymentStatus($challan_id);
		echo json_encode($results);
	}
}