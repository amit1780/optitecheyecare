<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attachements extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			//redirect('/');
		}
		$this->load->helper(array('url'));
		$this->load->model('quotation_model');
		$this->load->model('order_model');
		$this->load->model('challan_model');
		$this->load->model('bank_model');
		$this->load->model('customer_model');
		$this->load->model('product_model');
		$this->load->language('language_lang');	
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index(){
		
	}

	public function downloadQuotation($uid) {
		
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library	
		
		//$quotation_id = $this->input->get('quotation_id');
		$quotation_id = $this->db->get_where('quote_customer', array('quot_pdf_id' => $uid))->row()->id;
		//echo $this->db->last_query();exit;
		
				
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
		
		//$pdf->WriteHTML($stylesheet,1);		
		
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:2px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().$data['quotationInfo']->store_logo.'"></div>	
	</div>	
	<div style="width:82%;float:left;font-size:15px;text-align:left;">Quotation / Performa Invoice</div>
	<div style="width:18%;float:left;text-align:right;"><b style="font-size:18px;">'.getQuotationNo($quotation_id).'</b></div>
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
	public function downloadOrder($uid) {

		$this->load->library('m_pdf');
		//load mPDF library
		#$order_id = $this->input->get('order_id');
		$order_id = $this->db->get_where('order_customer', array('order_pdf_id' => $uid))->row()->order_id;
		
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
	
	public function downloadChallan($uid) {

		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		#$challan_id = $this->input->get('challan_id');
		$challan_id = $this->db->get_where('challan', array('challan_pdf_id' => $uid))->row()->challan_id;
				
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
	<div style="width:40%;float:left;font-size:15px;text-align:left;">DISPATCH CHALLAN</div>
	<div style="float:right;"><b style="font-size:18px;">'. getQuotationNo($data['ordersInfo']->quotation_id) .' / '.getOrderNo($data['challanInfo']->order_id).' / '. getChallanNo($challan_id).'</b></div>
</div>';

		$footer = '<div style="margin-right: 25px;margin-left: 25px;font-size:12px;width:100%;text-align:right;"><span>Page - {PAGENO}</span></div>';
		
		$pdf->SetHTMLHeader($header);
		$pdf->SetHTMLFooter($footer);
		$pdf->AddPage('', // L - landscape, P - portrait 
        '', '', '', '',
        0, // margin_left
        0, // margin right
       55, // margin top
       //25, // margin bottom
       5, // margin bottom
        0, // margin header
        0); // margin footer		
		
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");

	}
	
	public function downloadDispatchNote($uid) {

		$this->load->library('m_pdf');
		//load mPDF library
		#$challan_id = $this->input->post('challan_id');
		$challan_id = $this->db->get_where('challan', array('challan_pdf_id' => $uid))->row()->challan_id;
		 
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
		$filename = $filename.".pdf";


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
		$pdf->Output($filename, "D");
	}	
}