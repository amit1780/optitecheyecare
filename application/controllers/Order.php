<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
			$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('order_model');
		$this->load->model('quotation_model');
		$this->load->model('customer_model');
		$this->load->model('product_model');
		$this->load->language('language_lang');	
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index()
	{		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Quotation', '/quotation');
		
		$data['page_heading'] = "Create Order";
		
		$quotation_id = $this->input->get('quotation_id');
		
		$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($quotation_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['quotationInfo']->customer_id);
		
		$customerAddressInfo = $this->order_model->getCustomerAddressById($data['quotationInfo']->customer_id);
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
		
		if($data['quotationInfo']->order_id){
			$_SESSION['error']      = "Already Create order this Quotation.";
			redirect('/quotation');
		}		
		$data['bankInfo'] = $this->quotation_model->getBankById($data['quotationInfo']->bank_id);
		$data['quoteProductInfo'] = $this->quotation_model->getQuotationProductById($quotation_id);
		
		$data['productgst'] = $this->quotation_model->getQuotationProductGroupGst($quotation_id);
		
		$this->load->view('common/header');
		$this->load->view('order/order_form', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);		
	}
	
	public function saveOrder(){
		
		$this->order_model->saveOrder($this->input->post());
		
		$_SESSION['success']      = "Success: You have create order";
		redirect('/orderList');
	} 
	
	public function editOrder($order_id)
	{		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order List', '/orderList');
		
		$data['page_heading'] = "Edit Order";		
		
		//$quotation_id = $this->input->get('quotation_id');
		
		//$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($quotation_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);		
		$customerAddressInfo = $this->order_model->getCustomerAddressById($data['ordersInfo']->customer_id);
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
		
		/* if($data['quotationInfo']->order_id){
			$_SESSION['error']      = "Already Create order this Quotation.";
			redirect('/quotation');
		}	 */	
		$data['bankInfo'] = $this->quotation_model->getBankById($data['ordersInfo']->bank_id);
		//$data['quoteProductInfo'] = $this->quotation_model->getQuotationProductById($quotation_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		
		//$data['productgst'] = $this->quotation_model->getQuotationProductGroupGst($quotation_id);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		
		$this->load->view('common/header');
		$this->load->view('order/order_edit_form', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);		
	}
	
	public function updateOrder(){		
		$this->order_model->updateOrder($this->input->post());		
		$_SESSION['success']      = "Success: You have update order";
		redirect('/orderList');
	}
	
	public function orderList(){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order list', '/orderList');
		$data['page_heading'] = "Order List";
		
		$data['success'] = $this->session->success;
		
		$data['stores'] = $this->quotation_model->getStore();
		$data['users'] = $this->quotation_model->getUsers();		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['countries'] = $this->customer_model->getCountry();		
		$data['states'] = $this->customer_model->getState($this->input->get('country_id'));
		
		$data['form_action']= 'orderList';	


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
		
		
		$data['customer_name_sort'] = site_url().'/orderList?sort=customer_name'. $order . $pageUrl .$url;
		$data['country_sort'] = site_url().'/orderList?sort=country_name'. $order . $pageUrl .$url;
		$data['state_sort'] = site_url().'/orderList?sort=state_name'. $order . $pageUrl .$url;

		
		/* Pagination */
		$total_rows = $this->order_model->getOrderTotal($this->input->get());
		$per_page =25;
		$config['base_url'] = site_url().'/orderList';
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
		$data['orders'] =array();
		$orders = $this->order_model->getOrderList($per_page, $start,$this->input->get());
		
		foreach($orders as $order){
			#$orderProducts = $this->order_model->getOrderProductById($order['order_id'], $order['quotation_id']);
			$totalChallan = $this->order_model->getOrderProductChallan($order['order_id'], $order['quotation_id']);
			$customerInfo = $this->order_model->getCustomerById($order['customer_id']);	
			#$net_total = array_sum(array_column($orderProducts,'net_amount'));
			$net_total = $order['net_amount'];
			$totwithgst = 0;
			$freight_charge = $order['freight_charge'];
			$freight_gst = $order['freight_gst'];
			if(($order['currency_id'] == 1) && ($customerInfo->countryId == '99')){
				$productgst = $this->order_model->getOrderProductGroupGst($order['order_id'], $order['quotation_id']);
				foreach($productgst as $progst){
				    $perProFrchWthGst=0;
				    if($freight_gst==0){
					    $perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
						$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					}
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
				}
			}
			
			if($freight_gst>0){
				$perProFrchWthGst = ($freight_charge * $freight_gst/100);
				$totwithgst= $totwithgst + $perProFrchWthGst;
			}
			
			$orderTotal = number_format((float)($net_total + $order['freight_charge'] + $totwithgst), 2, '.', '');				
			
			$totalOrderQty = array_sum(array_column($totalChallan,'qty'));
			$totalOrderedQty = array_sum(array_column($totalChallan,'challan_qty'));
			//$advices = $this->order_model->getAdvices($order['order_id']);
			//$advicesTotal = array_sum(array_column($advices,'amount'));
			
			$totOrdQty = $totalOrderQty - $totalOrderedQty;
			
			/* if($orderTotal == '0'){
				continue;
			}   */
			if($this->input->get('incomplete_order') == 'incomplete'){
				if($order['total_advice_payment'] >= 0 || $order['total_advice_payment'] < $orderTotal ){
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
						'order_total' 			=> number_format((float)($orderTotal), 2, '.', ''),
						//'advice_total' 			=> $advicesTotal,
						'advice_total' 			=> number_format((float)($order['total_advice_payment']), 2, '.', ''),
						'order_date' 			=> $order['order_date'],		
						'wa_status' 			=> $order['wa_status'],		
						'mobile' 				=> $order['mobile'],		
						//'totalChallanQty' 		=> $order['challan_qty'],		
						'totalOrderProduct' 	=> $totOrdQty		
					);
				}
			} else {
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
					'order_total' 			=> number_format((float)($orderTotal), 2, '.', ''),
					//'advice_total' 			=> $advicesTotal,
					'advice_total' 			=> number_format((float)($order['total_advice_payment']), 2, '.', ''),
					'order_date' 			=> $order['order_date'],	
					'wa_status' 			=> $order['wa_status'],		
					'mobile' 				=> $order['mobile'],	
					//'totalChallanQty' 		=> $order['challan_qty'],		
					'totalOrderProduct' 	=> $totOrdQty		
				);				
			}
		}		
		
		$data['model']=$this->input->get('model');
		$this->load->view('common/header');
		$this->load->view('order/order_list', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function orderView($order_id){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order list', '/orderList');
		
		
		$data['page_heading'] = "Order View";
		
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);	
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
						
		$this->load->view('common/header');
		$this->load->view('order/order_view', $data);
		$this->load->view('common/footer');
	}
	
	public function orderPrint($order_id){		
		
		/* $data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);						
		
		$this->load->view('order/order_print', $data); */
		
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		//$order_id = $this->input->post('order_id');
		
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);	
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
						
		
		$html = $this->load->view('order/order_download', $data,true);
				
		//this the the PDF filename that user will get to download
		$filename = getOrderNo($order_id);
		$pdfFilePath = "uploads/order/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['ordersInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:60%;float:left;font-size:15px;text-align:left;">Order In Process</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'.getQuotationNo($data['ordersInfo']->quotation_id).' / '. getOrderNo($order_id).'</b></div>
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
	
	
	public function downloadPdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$order_id = $this->input->get('order_id');
		
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);	
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
						
		
		$html = $this->load->view('order/order_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = getOrderNo($order_id);
		$pdfFilePath = $filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['ordersInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:60%;float:left;font-size:15px;text-align:left;">Order In Process</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'.getQuotationNo($data['ordersInfo']->quotation_id).' / '. getOrderNo($order_id).'</b></div>
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
	
	public function getOrderProductList(){
		$order_id = $this->input->post('order_id');
		$orderProducts= $this->order_model->getOrderProduct($order_id);
		if(empty($orderProducts)){
			$this->order_model->deleteOrder($order_id);
		}
		$json = array();
		foreach($orderProducts as $orderProduct){
			if($orderProduct['qty'] == $orderProduct['challan_qty']){
				continue;
			}
			
			$netTotal = $orderProduct['qty']  * ($orderProduct['rate'] - $orderProduct['discount']);
			
			$json[]= array(
				'id' 			=>  $orderProduct['id'],
				'order_id' 		=>  $orderProduct['order_id'],
				'model_name' 	=>  $orderProduct['model_name'],
				'description' 	=>  $orderProduct['description'],
				'hsn' 			=>  $orderProduct['hsn'],
				'qty' 			=>  $orderProduct['qty'],
				'challan_qty' 	=>  $orderProduct['challan_qty'],
				'rate' 			=>  $orderProduct['rate'],
				'unit' 			=>  $orderProduct['unit'],
				'discount' 		=>  $orderProduct['discount'],				
				'net_amount' 	=>  $netTotal
			);
		}
		
		if(empty($json)){
			$this->order_model->updateOrderStatus($order_id);
		}
		 		
		echo json_encode($json);
	}
	
	public function getOrderProductNotList(){
		$order_id = $this->input->post('order_id');		
		$orderProducts= $this->order_model->getOrderProductNot($order_id);
		if(empty($orderProducts)){			
			$result =$this->order_model->deleteOrder($order_id);
			
		}
		echo json_encode($result);
	}
	
	public function deleteOrderProduct(){
		$order_product_id = $this->input->post('order_product_id');
		$result= $this->order_model->deleteOrderProduct($order_product_id);		
		echo json_encode($result);
	}	
	
	public function orderSavePdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$order_id = $this->input->post('order_id');
		
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);	
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
						
		
		$html = $this->load->view('order/order_download', $data,true);
				
		//this the the PDF filename that user will get to download
		$filename = getOrderNo($order_id);
		$pdfFilePath = "uploads/order/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['ordersInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:60%;float:left;font-size:15px;text-align:left;">Order In Process</div>
	<div style="float:right;text-align:right;"><b style="font-size:18px;">'.getQuotationNo($data['ordersInfo']->quotation_id).' / '. getOrderNo($order_id).'</b></div>
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
		$ord_id = getOrderNo($order_id);
    	$json = array();
		$json[] = array(
			'order_id' 			=> $ord_id,
			'order_file' 		=> $pdfFilePath,
			'order_file_name' 	=> $filename,
			'person' 			=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
			'email_to' 			=> $data['customerInfo']->email
		);
		
		echo json_encode($json);
	}
	
	public function orderSendMail() {
	    
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
		$order_file = $this->input->post('order_file');
		$email_cc = $this->input->post('email_cc');
		
		$admin_email = $this->config->item('admin_email');
		$replyto_email = $this->config->item('replyto_email');
		$copy_email = $this->config->item('copy_email');
		
		$this->email->from($admin_email, 'Optitech eye care');
		$this->email->reply_to($replyto_email, 'Optitech eye care');
		
		$user_email = $_SESSION['email'];		
		//$this->email->to($to,$user_email);
		$recipientArr = array($to, $user_email);
        $this->email->to($recipientArr);
		
		$this->email->cc($email_cc);
		$this->email->bcc($copy_email);		

		$this->email->subject($subject);
		$this->email->message(nl2br($message));		
	   
		$attachfile = getcwd().'/'.$order_file;
		$this->email->attach($attachfile);		
		
		$this->email->send();
		
		echo json_encode($json);
	}
	
	public function paymentAdvice($order_id){
	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order list', '/orderList');
		
		
		$data['success'] = $this->session->success;
		
		$data['page_heading'] = "Payment Receive Advice";
		$data['form_action']= 'paymentAdvice/'.$order_id;		
		$advice_id = $this->input->get('advice_id');
		
		$data['banks'] = $this->quotation_model->getBanks();
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['advices'] = $this->order_model->getAdvices($order_id);
		$data['advicesById'] = $this->order_model->getAdviceById($order_id,$advice_id);
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$orderProducts = $this->order_model->getOrderProductById($order_id, $data['ordersInfo']->quotation_id);
		$net_total = array_sum(array_column($orderProducts,'net_amount'));
		$freight_charge = $data['ordersInfo']->freight_charge;
		$customerInfo = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
		if(($data['ordersInfo']->currency == 'INR') && ($customerInfo->countryId == '99')){
			$productgst = $this->order_model->getOrderProductGroupGst($order_id, $data['ordersInfo']->quotation_id);
			$totwithgst = 0;
			
			foreach($productgst as $progst){
				$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
				$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
				$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
				$totwithgst = $totwithgst + $totgst;
			}
		}	
		
		$data['orderTotal'] = number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', '');
		
		$data['paymentAdviceFiles'] = $this->order_model->getAdviceFile($advice_id);
		
		$data['order_id'] = $order_id;		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('bank_id', 'Bank', 'required');
		$this->form_validation->set_rules('date_of_payment', 'Date of Payment', 'required');
		$this->form_validation->set_rules('bank_ref_no', 'Bank Ref. no', 'required');
		//$this->form_validation->set_rules('currency_id', 'Currency', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		
		if($advice_id == ''){
			if (empty($_FILES['bank_file']['name'])){
				$this->form_validation->set_rules('bank_file', 'Bank File', 'required');
			}
		}
		
		
		if ($this->form_validation->run() == false) {			
		
			$this->load->view('common/header');
			$this->load->view('order/order_payment_advice', $data);
			$this->load->view('common/footer');
			
		} else {
			#upload for Product Photo
			
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

			if($advice_id == ''){
				$this->order_model->addPaymentAdvice($this->input->post(),$bank_file);
				$_SESSION['success']      = "Success: You have Added Payment Receive Advice";
				redirect('/paymentAdvice/'.$order_id);
			} else {
				
				 
				$this->order_model->editPaymentAdvice($this->input->post(),$advice_id,$bank_file);
				$_SESSION['success']      = "Success: You have Update Payment Receive Advice";
				redirect('/paymentAdvice/'.$order_id.'?advice_id='.$advice_id);
			}
		}		
		unset($_SESSION['success']);
	}
	
	public function ordChallan($order_id){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order list', '/orderList');		
		
		$data['page_heading'] = "Order Challan";
		$data['order_id'] = $order_id;
		
		$data['pendingChallanLists'] = $this->order_model->getPendingChallanList($order_id);		
		#print "<pre>";
		#print_r($data['pendingChallanLists']);
		$data['completeChallanLists'] = $this->order_model->getCompleteChallanList($order_id);		
		
		
		$this->load->view('common/header');
		$this->load->view('order/order_challan', $data);
		$this->load->view('common/footer');
	}
	
	public function orderPendingProduct(){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order Pending Products', '/orderPendingProduct');
		$data['page_heading'] = "Order Pending Products";
		
		$data['success'] = $this->session->success;
		
		$data['form_action']= 'orderPendingProduct';		
		/* Pagination */
		$total_rows = $this->order_model->getTotalOrderPendingProduct($this->input->get());
		$per_page =25;
		$config['base_url'] = site_url().'/orderPendingProduct';
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
		
		$data['orders'] = $this->order_model->getOrderPendingProduct($per_page, $start,$this->input->get());
		
		$this->load->view('common/header');
		$this->load->view('order/order_pending_product', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function orderPendingProductView($product_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order Pending Products', '/orderPendingProduct');
		
		$data['page_heading'] = "Order Pending Products View";
		
		$data['success'] = $this->session->success;
		$data['product_id'] = $product_id;		
		$data['orders'] = $this->order_model->getOrderPendingProductView($product_id);
		
		$this->load->view('common/header');
		$this->load->view('order/order_pending_product_view', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function orderPendingCustomer(){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order Pending Customer', '/orderPendingCustomer');
		$data['page_heading'] = "Order Pending Customer";
		
		$data['success'] = $this->session->success;
		
		$data['form_action']= 'orderPendingCustomer';
		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		
		/* Pagination */
		$total_rows = $this->order_model->getTotalOrderPendingCustomer($this->input->get());
		$per_page =25;
		$config['base_url'] = site_url().'/orderPendingCustomer';
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
		
		$data['orders'] = $this->order_model->getOrderPendingCustomer($per_page, $start,$this->input->get());
		
		$this->load->view('common/header');
		$this->load->view('order/order_pending_customer', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function orderPendingCustomerView($customer_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order Pending Customer', '/orderPendingCustomer');
		
		$data['page_heading'] = "Order Pending Customer View";
		
		$data['success'] = $this->session->success;
				
		$data['orders'] = $this->order_model->getOrderPendingCustomerView($customer_id);
		
		$this->load->view('common/header');
		$this->load->view('order/order_pending_customer_view', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function orderProductView($order_id){
		
		$product_id = $this->input->get('product_id');
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order Pending Products View', '/orderPendingProductView/'.$product_id);
		
		
		$data['page_heading'] = "Order View";
		
		
		
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);	
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
						
		$this->load->view('common/header');
		$this->load->view('order/order_product_view', $data);
		$this->load->view('common/footer');
	}
	
	public function orderCustomerView($order_id){
		
		$customer_id = $this->input->get('customer_id');
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Order Pending Customer View', '/orderPendingCustomerView/'.$customer_id);
		
		
		$data['page_heading'] = "Order View";
		
		
		
		$data['ordersInfo'] = $this->order_model->getOrderById($order_id);
		$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);	
		$data['bankInfo'] = $this->order_model->getBankById($data['ordersInfo']->bank_id);
		$data['orderProducts'] = $this->order_model->getOrderProductById($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
		$data['totalChallan'] = $this->order_model->getOrderProductChallan($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);		
		$data['totalOrderProduct'] = count($data['orderProducts']);
		$data['productgst'] = $this->order_model->getOrderProductGroupGst($data['ordersInfo']->order_id, $data['ordersInfo']->quotation_id);
						
		$this->load->view('common/header');
		$this->load->view('order/order_product_view', $data);
		$this->load->view('common/footer');
	}
	
	public function getChallanMissingFields(){
		$order_id = $this->input->post('order_id');
		$results= $this->order_model->getChallanMissingFields($order_id);
		$json = array();
		foreach($results as $result){
			$json[] = array(
				'challan_id' 			=> $result['challan_id'],
				'challan_no' 			=> getChallanNo($result['challan_id']),
				'order_id' 				=> '<a target="_blank" href="'.site_url('orderView').'/'.$result['order_id'].'">'.getOrderNo($result['order_id']).'</a>',
				'method_of_shipment' 	=> $result['method_of_shipment'],
				'docket_no' 			=> $result['docket_no'],
				'sb_number' 			=> $result['sb_number'],
				'invoice_no' 			=> $result['invoice_no'],
			);
		}			
		echo json_encode($json);
	}
	
	public function getPaymentAdviceFile(){
		$advice_id = $this->input->post('payment_advice_id');
		$order_id = $this->input->post('order_id');
		$results = $this->order_model->getAdviceFile($advice_id);	
		echo json_encode($results);
	}
	
	public function delPaymentAdviceFile(){
		$advice_file_id = $this->input->post('advice_file_id');
		$results = $this->order_model->delAdviceFile($advice_file_id);	
		echo json_encode($results);
	}
	
}