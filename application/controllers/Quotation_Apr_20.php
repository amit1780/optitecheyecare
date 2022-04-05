<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		$this->load->helper(array('url'));
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
		$this->breadcrumbs->push('Quotations', '/quotation');		
		
		$data['heading_title'] = $this->lang->line('quotation_list_heading');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['stores'] = $this->quotation_model->getStore();
		$data['users'] = $this->quotation_model->getUsers();		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['countries'] = $this->customer_model->getCountry();		
		$data['states'] = $this->customer_model->getState($this->input->get('country_id'));
		
		$data['success'] = $this->session->success;
		$data['error'] = $this->session->error;
		$data['form_action']= 'quotation';
		
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
		
		$data['store_sort'] = site_url().'/quotation/index?sort=store_name'. $order . $pageUrl .'&'.$url;
		$data['customer_name_sort'] = site_url().'/quotation/index?sort=customer_name'. $order . $pageUrl .'&'.$url;
		$data['country_sort'] = site_url().'/quotation/index?sort=country_name'. $order . $pageUrl .'&'.$url;
		$data['state_sort'] = site_url().'/quotation/index?sort=state_name'. $order . $pageUrl .'&'.$url;
		
		
		/* Pagination */
		$total_rows = $this->quotation_model->getTotalQuotation($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/quotation/index';
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
		
		$data['quotations'] = $this->quotation_model->getQuoteCustomerList($per_page, $start,$this->input->get());
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
			$amt =$quotation['net_amount'] + $freight_charge + $totwithgst;
			if(is_nan($amt)){
				$amt = 0.00;
			}
			
			$data['quotations'][$i]['net_amount'] = $amt;
			
			$i++;
		}
		
		$this->load->view('common/header');
		$this->load->view('quotation/quotation_list', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);
		unset($_SESSION['error']);
		
	}

	public function quoteComplete()
	{
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Quotation History', '/quoteComplete');
		
		$data['heading_title'] = $this->lang->line('quotation_list_heading');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['stores'] = $this->quotation_model->getStore();
		$data['users'] = $this->quotation_model->getUsers();		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['countries'] = $this->customer_model->getCountry();		
		$data['states'] = $this->customer_model->getState($this->input->get('country_id'));
		
		$data['success'] = $this->session->success;
		$data['error'] = $this->session->error;
		$data['form_action']= 'quotation/quoteComplete';
		
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
				
		$data['store_sort'] = site_url().'/quotation/quoteComplete/index?sort=store_name'. $order . $pageUrl .$url;
		$data['customer_name_sort'] = site_url().'/quotation/quoteComplete/index?sort=customer_name'. $order . $pageUrl .$url;
		$data['country_sort'] = site_url().'/quotation/quoteComplete/index?sort=country_name'. $order . $pageUrl .$url;
		$data['state_sort'] = site_url().'/quotation/quoteComplete/index?sort=state_name'. $order . $pageUrl .$url;
		
		
		/* Pagination */
		$total_rows = $this->quotation_model->getTotalCompleteQuotation($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/quotation/quoteComplete/index';
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
		
		$data['quotations'] = $this->quotation_model->getCompleteQuoteCustomerList($per_page, $start,$this->input->get());
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
			$amt = $quotation['net_amount'] + $freight_charge + $totwithgst;
			if(is_nan($amt)){
				$amt = 0.00;
			}			
			$data['quotations'][$i]['net_amount'] = $amt;
			
			$i++;
		}
		
		$this->load->view('common/header');
		$this->load->view('quotation/quotation_complete_list', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);
		unset($_SESSION['error']);
		
	}	

	public function addQuote()
	{
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Generate Quotation', '/addQuote');
		
		
		$data['heading_title'] = $this->lang->line('quotation_list_heading');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['countries'] = $this->customer_model->getCountry();
		
		$data['stores'] = $this->quotation_model->getStore();
		$data['banks'] = $this->quotation_model->getBanks();		
		$data['users'] = $this->quotation_model->getUsers();		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		$data['lastQuotationId'] = $this->quotation_model->getLastQuotationId();		
		
		$data['success'] = $this->session->success;
		$data['form_action']= 'genQuote';
		
		$this->load->view('common/header');
		$this->load->view('quotation/quotation_form', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);
	}

	
	protected function getPostFields(){
		$data=Array();
		foreach ($this->input->post() as $name => $value){
			$data[$name]=$value;
		}
		return $data;
	}
	
	
	public function generateQuote() {
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Generate Quotation', '/addQuote');	
		
		$data['heading_title'] = $this->lang->line('quotation_list_heading');
		
		/* $custArr = explode("#", $data['customer_name1']);
		$data['cust_id']=preg_replace('/\D+/is','',$custArr[1]); */
		$data['form_action']= 'genQuote';
		$data['error'] = $_SESSION['error'];
		$this->load->helper('form');
		$this->load->library('form_validation');
				
		$data['countries'] = $this->customer_model->getCountry();		
		
		$this->form_validation->set_rules('customer_name1', 'customer Name', 'required');
		$this->form_validation->set_rules('user_id', 'Genrated By', 'required');
		$this->form_validation->set_rules('currency_id', 'Currency', 'required');
		$this->form_validation->set_rules('bank_id', 'Bank', 'required');
		//$this->form_validation->set_rules('billing_details', 'Billing details', 'required');
		//$this->form_validation->set_rules('shipping_details', 'Shipping details', 'required');
		
		if ($this->form_validation->run() == false) {
			
			$data['stores'] = $this->quotation_model->getStore();
			$data['banks'] = $this->quotation_model->getBanks();		
			$data['users'] = $this->quotation_model->getUsers();		
			$data['currencies'] = $this->quotation_model->getCurrencies();
			$data['lastQuotationId'] = $this->quotation_model->getLastQuotationId();
			
			$this->load->view('common/header');
			$this->load->view('quotation/quotation_form', $data);
			$this->load->view('common/footer');
			unset($_SESSION['error']);
			
		} else {
			
			$data=$this->getPostFields();
			
			$customerInfo = $this->customer_model->getCustomerById($data['customer_id']);	
			$countryName=$this->customer_model->getCountryByID($customerInfo->country_id);
			$customerInfo->country=$this->customer_model->getCountryByID($customerInfo->country_id)->name;
			$customerInfo->state=$this->customer_model->getStateByID($customerInfo->state_id)->name;
			
			$quotation_id=$this->quotation_model->addCustomerToQuote($data,$customerInfo);
			$products =$data['prod_id'];
		
			foreach($products as $index => $product_id ){			
				$productInfo = $this->product_model->getProductById($product_id);			
				$price1 = $data['price'][$index];				
				if(($data['currency_id'] == '1') && ($customerInfo->country_id == '99')){
					$progst1 = $data['pro_gst'][$index];
					$basePrice = $price1 * (100/(100+$progst1));
				} else {
					$basePrice = $price1;
					$progst1 = '';
				}
							
				$qty = $data['qty'][$index];			
				$productInfo->qty=$data['qty'][$index];
				//$productInfo->price=$data['price'][$index];
				$productInfo->mrp=$price1;
				$productInfo->price=$basePrice;
				$discount = $data['discount'][$index];
				$productInfo->ltp=$price1 - $discount;
				
				$productInfo->unit=$data['unit_name'][$index];
				$productInfo->quotation_id=$quotation_id;
				$productInfo->customer_id=$data['customer_id'];
				
				if(($data['currency_id'] == '1') && ($customerInfo->country_id == '99')){
					$productInfo->gst=$data['pro_gst'][$index];
					$discount = $discount * (100/(100+$progst1));
				} else {
					$productInfo->gst= '';
				}		
				$discountRate = $data['discount_rate'][$index];
				
				//$total 	  = $data['total'][$index];
				$total 	  	  = 	$qty * ($basePrice - $discount);			
				$this->quotation_model->addProductsToQuote($productInfo,$discount,$total,$discountRate);		
			}			
			$_SESSION['success']      = "Success: You have Added Quotation";
			redirect('/quotation');	
		}
	}
	
	public function quotationView($quotation_id)
	{		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Quotations', '/quotation');
		
		$data['page_heading'] = "Quotation View";
		
		$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($quotation_id);
		$data['customerInfo'] = $this->customer_model->getCustomerById($data['quotationInfo']->customer_id);
		
		$data['bankInfo'] = $this->quotation_model->getBankById($data['quotationInfo']->bank_id);
		$data['quoteProductInfo'] = $this->quotation_model->getQuotationProductById($quotation_id);
		
		$data['productgst'] = $this->quotation_model->getQuotationProductGroupGst($quotation_id);
						
		$this->load->view('common/header');
		$this->load->view('quotation/quotation_view', $data);
		$this->load->view('common/footer');
	}
	
	public function editQuotation($quotation_id) {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Quotations', '/quotation');
		
		$data['page_heading'] = "Edit Quotation";
		
		$data['form_action']= 'editQuotation/'.$quotation_id;		
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$data['stores'] = $this->quotation_model->getStore();
		$data['banks'] = $this->quotation_model->getBanks();		
		$data['users'] = $this->quotation_model->getUsers();		
		$data['currencies'] = $this->quotation_model->getCurrencies();
		
		$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($quotation_id);		
		$data['quoteProductInfo'] = $this->quotation_model->getQuotationProductById($quotation_id);
		if($data['quotationInfo']->order_id){
			$_SESSION['error']      = "You can not edit this quotation.";
			redirect('/quotation');
		}
		
		$this->form_validation->set_rules('customer_name1', 'customer Name', 'required');
		
		if ($this->form_validation->run() == false) {
			$data['customerInfo'] = $this->customer_model->getCustomerById($data['quotationInfo']->customer_id);
			$this->load->view('common/header');
			$this->load->view('quotation/quotation_form', $data);
			$this->load->view('common/footer');	
			
		} else {
				
			$data=$this->getPostFields();
			$customerInfo = $this->customer_model->getCustomerById($data['customer_id']);
			$countryName=$this->customer_model->getCountryByID($customerInfo->country_id);
			$customerInfo->country=$this->customer_model->getCountryByID($customerInfo->country_id)->name;
			$customerInfo->state=$this->customer_model->getStateByID($customerInfo->state_id)->name;			
			$this->quotation_model->editCustomerToQuote($data,$quotation_id,$customerInfo);
			$products =$data['prod_id'];
						
			$this->quotation_model->deleteProductsToQuote($quotation_id);
			
			foreach($products as $index => $product_id ){				
				$productInfo = $this->product_model->getProductById($product_id);
				
				$price1 = $data['price'][$index];
							
				if(($data['currency_id'] == '1') && ($customerInfo->country_id == '99')){
					$progst1 = $data['pro_gst'][$index];
					$basePrice = $price1 * (100/(100+$progst1));
				} else {
					$basePrice = $price1;
					$progst1 = '';
				}			
				$qty = $data['qty'][$index];
				
				$productInfo->qty=$data['qty'][$index];
				//$productInfo->price=$data['price'][$index];
				$productInfo->mrp=$price1;
				$productInfo->price=$basePrice;
				$discount = $data['discount'][$index];
				$productInfo->ltp=$price1 - $discount;
				
				$productInfo->unit=$data['unit_name'][$index];
				$productInfo->quotation_id=$quotation_id;
				$productInfo->customer_id=$data['customer_id'];
				
				if(($data['currency_id'] == '1') && ($customerInfo->country_id == '99')){
					$productInfo->gst=$data['pro_gst'][$index];
					$discount = $discount * (100/(100+$progst1));
				} else {
					$productInfo->gst= '';
				}					
				$discountRate = $data['discount_rate'][$index];
				//$total 	  = $data['total'][$index];
				$total 	  	  = 	$qty * ($basePrice - $discount);
				
				$this->quotation_model->editProductsToQuote($productInfo,$discount,$total,$discountRate);		
			}			
			$_SESSION['success']      = "Success: You have Update Quotation";
			redirect('/quotation');			
		}
	}
	
	
	public function downloadPdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$quotation_id = $this->input->get('quotation_id');
				
		$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($quotation_id);		
		$data['customerInfo'] = $this->customer_model->getCustomerById($data['quotationInfo']->customer_id);
		$data['bankInfo'] = $this->quotation_model->getBankById($data['quotationInfo']->bank_id);
		$data['quoteProductInfo'] = $this->quotation_model->getQuotationProductById($quotation_id);
		
		$data['productgst'] = $this->quotation_model->getQuotationProductGroupGst($quotation_id);
		
		$html= $this->load->view('quotation/quotation_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = getQuotationNo($quotation_id);
		$pdfFilePath = $filename.".pdf";

		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);		
		
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['quotationInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:89%;float:left;font-size:15px;text-align:left;">Quotation / Performa Invoice</div>
	<div style="width:11%;float:left;"><b style="font-size:18px;">'.getQuotationNo($quotation_id).'</b></div>
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
        0);// margin footer
		
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
	}
	
	public function savePdf() {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$quotation_id = $this->input->post('quotation_id');
				
		$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($quotation_id);
		$data['customerInfo'] = $this->customer_model->getCustomerById($data['quotationInfo']->customer_id);
		$data['bankInfo'] = $this->quotation_model->getBankById($data['quotationInfo']->bank_id);
		$data['quoteProductInfo'] = $this->quotation_model->getQuotationProductById($quotation_id);	

		$data['productgst'] = $this->quotation_model->getQuotationProductGroupGst($quotation_id);
		
		$html= $this->load->view('quotation/quotation_download', $data,true);
				
		//this the the PDF filename that user will get to download
		$filename = getQuotationNo($quotation_id);
		$pdfFilePath = "uploads/quotation/".$filename.".pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['quotationInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:89%;float:left;font-size:15px;text-align:left;">Quotation / Performa Invoice</div>
	<div style="width:11%;float:left;"><b style="font-size:18px;">'.getQuotationNo($quotation_id).'</b></div>
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
			'quote_file' 		=> $pdfFilePath,
			'quote_file_name' 	=> $filename,
			'person' 			=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
			'email_to' 			=> $data['customerInfo']->email
		);
		
		foreach($data['quoteProductInfo'] as $quoteProduct){
			$productPdf = $this->product_model->getProductById($quoteProduct['prod_id']);
			if($productPdf->product_pdf){
				$file = $productPdf->product_pdf;
				$json[] = array(
					'quote_file' 		=> $file,
					'quote_file_name' 	=> 'Product File',
					'person' 			=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
					'email_to' 			=> $data['customerInfo']->email
				);
			}	
		}
		
		echo json_encode($json);
	}
	
	public function sendMail() {
	    
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
		$quote_file = $this->input->post('quote_file');
		$email_cc = $this->input->post('email_cc');
		
		$this->email->from('info@optitecheyecare.in', 'Optitech eye care');
		$this->email->reply_to('info@optitecheyecare.com', 'Optitech eye care');
		$this->email->to($to);
		
		$this->email->cc($email_cc);
		$this->email->bcc('info@optitecheyecare.com');		

		$this->email->subject($subject);
		$this->email->message(nl2br($message));
		
	    foreach($quote_file as $file){
		    $attachfile = getcwd().'/'.$file;
			$this->email->attach($attachfile);
		} 
		
		$this->email->send();
		
		echo json_encode($json);
	}
	
	public function deleteQuotation() {
		
		if(empty($this->input->post('deleted_reason'))){
			$result['error']="Please Enter delete reason.";
			echo json_encode($result);
		}else {
			$this->quotation_model->deleteQuotationById($this->input->post());
			$result['success'] = "Successfully delete Quotation.";
			echo json_encode($result);
		}				
	}
	
	public function viewDeleteReason() {
		
		$result = $this->quotation_model->getDeleteReason($this->input->post());
		
		$json['username'] = $result->firstname .' '.$result->lastname;
		$json['deleted_reason'] = $result->deleted_reason;
		$json['deleted_date'] = dateFormat('d-m-Y',$result->deleted_date);
		echo json_encode($json);						
	}
	
}