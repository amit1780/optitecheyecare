<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
	
		
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		$this->load->helper(array('url'));
		$this->load->model('search_model');
		$this->load->model('customer_model');
		$this->load->model('quotation_model');
		$this->load->model('order_model');
		$this->load->model('challan_model');
		$this->load->language('language_lang');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index()
	{
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Advance search', '/search');		
		$data['page_heading'] = 'Advance search';
	    $data['countries'] = $this->customer_model->getCountry();
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['stores'] = $this->quotation_model->getStore();
		$data['users'] = $this->quotation_model->getUsers();
	
		$data['success'] = $this->session->success;
		$data['form_action']= 'search';
		
		

		$this->load->view('common/header');
		$this->load->view('search/search_form', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);
	}
	
	public function customerSearch() {
		
		/* Pagination */
		
		echo "<pre>";
		print_r($this->input->post());exit;
		
		$total_rows = $this->search_model->getTotalCustomers($this->input->post());	
		$per_page =25;
		$config['base_url'] = site_url().'/customerSearch';	
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;
		
		$page = 1;		
		
		/*if(!empty($this->uri->segment(3,0))){
			$page = $this->uri->segment(3,0);
		}*/		
		if(!empty($this->input->post('per_page'))){
			$page = $this->input->post('per_page');
		}
		$start = ($page-1)*$per_page;				
		$this->pagination->initialize($config);			
		$pagination = $this->pagination->create_links();
		
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$data['pagination'] = '<p style="margin-top: 10px;">We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';			
		}		
		/* Pagination */
		
		$data['customers'] = $this->search_model->getCustomers($per_page, $start,$this->input->post());
				
		$html = $this->load->view('search/search_customer', $data,true);	
		echo json_encode($html);		
	}
	
	public function quotationSearch() {
		
		/* Pagination */	
		$total_rows = $this->search_model->getTotalQuotations($this->input->post());	
		$per_page =25;
		$config['base_url'] = site_url().'/quotationSearch';	
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;
		
		$page = 1;		
		
		/*if(!empty($this->uri->segment(3,0))){
			$page = $this->uri->segment(3,0);
		}*/		
		if(!empty($this->input->post('per_page'))){
			$page = $this->input->post('per_page');
		}
		$start = ($page-1)*$per_page;				
		$this->pagination->initialize($config);			
		$pagination = $this->pagination->create_links();
		
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$data['pagination'] = '<p style="margin-top: 10px;">We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';			
		}		
		/* Pagination */
		
		
		$data['based_on'] = $this->input->post('basedOn');		
		$data['quotations'] = $this->search_model->getQuotations($per_page, $start,$this->input->post());
		$i=0;
		foreach($data['quotations'] as $quotation){
			$totwithgst = 0;
			$freight_charge = $quotation['freight_charge'];
			if($quotation['currency_id'] == 1){
				$productgst = $this->quotation_model->getQuotationProductGroupGst($quotation['id']);
				
				
				
				foreach($productgst as $progst){
					$perProFrch = ($freight_charge / $quotation['net_amount']) * $progst['net_amount'];
					$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
				}
			}
			
			$data['quotations'][$i]['net_amount'] = $quotation['net_amount'] + $freight_charge + $totwithgst;
			
			$i++;
		}		
		$html = $this->load->view('search/search_quotation', $data,true);		
		echo json_encode($html);
	}
		
	public function orderSearch() {
		
		/* Pagination */	
		$total_rows = $this->order_model->getOrderTotal($this->input->post());	
		$per_page =25;
		$config['base_url'] = site_url().'/orderSearch';	
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;
		
		$page = 1;		
		
		/*if(!empty($this->uri->segment(3,0))){
			$page = $this->uri->segment(3,0);
		}*/		
		if(!empty($this->input->post('per_page'))){
			$page = $this->input->post('per_page');
		}
		$start = ($page-1)*$per_page;				
		$this->pagination->initialize($config);			
		$pagination = $this->pagination->create_links();
		
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$data['pagination'] = '<p style="margin-top: 10px;">We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';			
		}		
		/* Pagination */
		
		$orders = $this->order_model->getOrderList($per_page, $start,$this->input->post());
		foreach($orders as $order){
			#$orderProducts = $this->order_model->getOrderProductById($order['order_id'], $order['quotation_id']);
			$totalChallan = $this->order_model->getOrderProductChallan($order['order_id'], $order['quotation_id']);
			#$net_total = array_sum(array_column($orderProducts,'net_amount'));
			$net_total = $order['net_amount'];
			$totwithgst = 0;
			$freight_charge = $order['freight_charge'];
			if($order['currency_id'] == 1){
				$productgst = $this->order_model->getOrderProductGroupGst($order['order_id'], $order['quotation_id']);
				
				
				foreach($productgst as $progst){
					$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
					$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
				}
			}	
			
			$orderTotal = number_format((float)($net_total + $order['freight_charge'] + $totwithgst), 2, '.', '');	
			
			$totalOrderQty = array_sum(array_column($totalChallan,'qty'));
			$totalOrderedQty = array_sum(array_column($totalChallan,'challan_qty'));
			$advices = $this->order_model->getAdvices($order['order_id']);
			$advicesTotal = array_sum(array_column($advices,'amount'));
			
			$totOrdQty = $totalOrderQty - $totalOrderedQty;
			
			if($this->input->post('basedOn') == 'Pending'){
				if($totOrdQty == '0'){
					continue;
				} 
			}
			
			/* if($orderTotal == '0'){
				continue;
			}   */
			
			$data['orders'][] = array(
				'order_id' 				=> $order['order_id'],
				'quotation_id' 			=> $order['quotation_id'],
				'store_name' 			=> $order['store_name'],
				'customer_name' 		=> $order['customer_name'],
				'customer_id' 			=> $order['customer_id'],
				'country_name' 			=> $order['country_name'],
				'state_name' 			=> $order['state_name'],
				'contact_phone' 		=> $order['contact_phone'],
				'currency' 				=> $order['currency'],
				'currency_faclass' 		=> $order['currency_faclass'],
				'order_total' 			=> $orderTotal,
				'advice_total' 			=> $advicesTotal,
				'order_date' 			=> $order['order_date'],		
				//'totalChallanQty' 		=> $order['challan_qty'],		
				'totalOrderProduct' 	=> $totOrdQty		
			);
		}
		
		$html = $this->load->view('search/search_order', $data,true);		
		echo json_encode($html);	
	}
	
	public function challanSearch() {

		/* Pagination */	
		$total_rows = $this->challan_model->getTotalChallan($this->input->post());	
		$per_page =25;
		$config['base_url'] = site_url().'/challanSearch';	
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;
		
		$page = 1;		
		
		/*if(!empty($this->uri->segment(3,0))){
			$page = $this->uri->segment(3,0);
		}*/		
		if(!empty($this->input->post('per_page'))){
			$page = $this->input->post('per_page');
		}
		$start = ($page-1)*$per_page;				
		$this->pagination->initialize($config);			
		$pagination = $this->pagination->create_links();
		
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$data['pagination'] = '<p style="margin-top: 10px;">We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';			
		}		
		/* Pagination */
	
		$data['challanInfo'] = $this->challan_model->getChallan($per_page, $start,$this->input->post());
		
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
		
		$html = $this->load->view('search/search_challan', $data,true);		
		echo json_encode($html);	
	}		
	
	public function orderPendingProductSearch(){		
		$data['orders'] = $this->search_model->getOrderPendingProduct($this->input->post());		
		$html = $this->load->view('search/search_order_pending_product', $data,true);	
		echo json_encode($html);
	}
	
	public function orderPendingCustomerSearch(){
		$data['orders'] = $this->search_model->getOrderPendingCustomer($this->input->post());		
		$html = $this->load->view('search/search_order_pending_customer', $data,true);	
		echo json_encode($html);
	}
	
}