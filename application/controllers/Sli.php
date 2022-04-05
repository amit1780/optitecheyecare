<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sli extends CI_Controller {
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
		$this->load->model('sli_model');
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
		$this->breadcrumbs->push('Carrier', '/sli');
		$data['page_heading'] = "Carrier List";
		/* $this->load->helper('form');
		$this->load->library('form_validation');
		$data['success'] = $this->session->success; */
		$data['carriers'] = $this->challan_model->getSli();

		$this->load->view('common/header');
		$this->load->view('sli/sli_list', $data);
		$this->load->view('common/footer');	
		//$this->session->unset_userdata('success');
	}
	
	public function editCarrier() {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Carrier', '/sli');
		
		$data['page_heading'] = "Edit Carrier";
		$data['success'] = $this->session->success;
		
		$data['sli_id'] = $this->input->get('sli_id');

		$data['carrier'] = $this->sli_model->getSliById($data['sli_id']);
		
		//print_r($data['bank']);
		$data['form_action']= 'sli/editCarrier?sli_id='.$data['sli_id'];		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('sli_account_number', 'Account No', 'required');		
		$this->form_validation->set_rules('sli_name', 'Sli Name', 'required');		
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('sli/sli_form', $data);
			$this->load->view('common/footer');	
			unset($_SESSION['success']);
		} else {			
			$this->sli_model->editSli($this->input->post());			
			$_SESSION['success']="Success: You have Updated Carrier Successfully!!";			
			redirect('sli/editCarrier?sli_id='.$data['sli_id']);			
		}		
	}

	
	public function createSli() {		
		
		$data['challan_id'] = $this->input->get('challan_id');
		$data['sli_id'] = $this->input->get('sli_id');
		$data['sli'] = $this->challan_model->getSli();
		$data['challanInfo'] = $this->challan_model->getChallanById($data['challan_id']);
		$data['customer_info'] = $this->customer_model->getDefaultAddress($data['challanInfo']->customer_id);
		
		$data['challan_sli_id'] = $data['challanInfo']->sli_id;
		
		if($data['sli_id'] == '' && $data['challan_sli_id'] != ''){
			redirect('/sli/createSli?challan_id='.$data['challan_id'].'&sli_id='.$data['challan_sli_id']);
			exit;
		}
						
		$data['ordersInfo'] = $this->order_model->getOrderById($data['challanInfo']->order_id);		
		$data['sliDocLabel'] = $this->sli_model->getSliDocLabel($data['sli_id']);
		
		
		$data['sliDetailInfo'] = $this->sli_model->getSliDetailsByID($data['sli_id'],$data['challan_id']);			
		$data['sliDocInfo'] = $this->sli_model->getSliDocByID($data['sli_id'],$data['sliDetailInfo']->sli_detail_id);
		
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
			
			if(empty($this->input->post('country_id')) && (($data['sli_id'] == 2) || ($data['sli_id'] == 3))){				
				$data['error']      = "Please Select Destination Country.";								
				$this->load->view('common/header');
				$this->load->view('sli/challan_sli', $data);				
				$this->load->view('common/footer');
				return false;
			}
			
						
			$this->sli_model->addSliDetails($this->input->post());			
			$_SESSION['success']      = "Success: You have Added SLI Details";
			redirect('/sli/createSli?challan_id='.$data['challan_id'].'&sli_id='.$data['sli_id']);
		} else {
			$this->load->view('common/header');
			$this->load->view('sli/challan_sli', $data);				
			$this->load->view('common/footer');	
		}
	}
	
	public function fileData($challan_id,$sli_id){
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
		$data['sliDocLabel'] = $this->sli_model->getSliDocLabel($sli_id);
		$data['sliDetailInfo'] = $this->sli_model->getSliDetailsById($sli_id,$challan_id);
				
		$data['sliDocInfo'] = $this->sli_model->getSliDocByID($sli_id,$data['sliDetailInfo']->sli_detail_id);
		
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
		
		return $data;
	}
	
	public function printSli() {
		$this->load->library('m_pdf');
		
		$challan_id = $this->input->get('challan_id');
		$sli_id = $this->input->get('sli_id');
		
		$data = $this->fileData($challan_id,$sli_id);
		
		$pdf = $this->m_pdf->load();
		
		$data['tick_img'] = '<img src="'.base_url().'/assets/img/tick.jpg" style="width:10px;">';
		
		if($sli_id == '1'){
			$this->load->view('sli/dhl_print', $data);
		} else if($sli_id == '2'){
			
			$html= $this->load->view('sli/fedex_print', $data,true);
			$filename = "Fedex-".getChallanNo($challan_id);			
			$this->pdf($filename,$html);			 	 
				
		} else if($sli_id == '3'){	

			$html = $this->load->view('sli/tnt_print', $data,true);
			$filename = "TNT-".getChallanNo($challan_id);			
			$this->pdf($filename,$html);
			
		}
	}
	
	public function pdf($filename,$html){	
			
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
		
		 $pdf->Output($pdfFilePath, "I");
		$url = base_url().$pdfFilePath;		
		redirect($url);	
	}
	
	public function sliSavePdf(){
		$this->load->library('m_pdf');
		
		$challan_id = $this->input->post('challan_id');
		$sli_id = $this->input->post('sli_id');
		
		$data = $this->fileData($challan_id,$sli_id);
		
		$pdf = $this->m_pdf->load();
		
		$data['tick_img'] = '<img src="'.base_url().'/assets/img/tick.jpg" style="width:10px;">';
		
		if($sli_id == '1'){
			$this->load->view('sli/dhl_print', $data);
		} else if($sli_id == '2'){
			
			$html= $this->load->view('sli/fedex_print', $data,true);
			$filename = "Fedex-".getChallanNo($challan_id);			
			$this->savePdf($filename,$html,$customerInfo);			 	 
				
		} else if($sli_id == '3'){	

			$html = $this->load->view('sli/tnt_print', $data,true);
			$filename = "TNT-".getChallanNo($challan_id);			
			$this->savePdf($filename,$html,$customerInfo);
		}
		
	}
	
	public function savePdf($filename,$html,$customerInfo){	
			
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
		ob_end_clean();
		$json = array();
		$json[] = array(
			'challan_file' 			=> $pdfFilePath,
			'challan_file_name' 	=> $filename,
			'person' 				=> $customerInfo->person_title ." ". $customerInfo->contact_person,
			'email_to' 				=> $customerInfo->email
		);		
		echo json_encode($json);
	}
	
	public function SendMail() {
		
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
	   
		$attachfile = getcwd().'/'.$challan_file;
		$this->email->attach($attachfile);		
		
		$this->email->send();
		
		echo json_encode($json);
		
	}
	
}