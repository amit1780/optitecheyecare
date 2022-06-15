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
}