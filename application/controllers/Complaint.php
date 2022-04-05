<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('complaint_model');
		$this->load->model('quotation_model');
		$this->load->library('breadcrumbs');	
		$this->load->library('pagination');		
	}
	
	
	public function index() {
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Complaint', '/complaint');
		
		$data['page_heading'] = "Complaint List";			    
		$data['success'] = $this->session->success;
		
		$data['form_action']= 'complaint';
		
		$data['categories'] = $this->complaint_model->getProductCategory();	
		$data['complaintCategories'] = $this->complaint_model->getComplaintCategory();	
		$data['complaintConcernDepts'] = $this->complaint_model->getComplaintConcernDept();	
		$data['complaintModes'] = $this->complaint_model->getComplaintMode();
		$data['users'] = $this->quotation_model->getUsers();
		/* if (date('m') > 3) {
			$year = date('Y')."".substr((date('Y') +1),2);
		}
		else {
			$year = (date('Y')-1)."".substr(date('Y'),2);
		} */
		
		
		/* Pagination */	
		$total_rows = $this->complaint_model->getTotalComplaint($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/complaint/index';	
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
						
		$data['complaints'] = $this->complaint_model->getComplaint($per_page, $start,$this->input->get());
		
		$this->load->view('common/header');
		$this->load->view('complaint/complaint_list', $data);
		$this->load->view('common/footer');		
		unset($_SESSION['success']);
	}
	
	
	public function addComplaint() {
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Complaint', '/addComplaint');
		$data['page_heading'] = "Add Complaint";
	    
		$data['form_action']= 'addComplaint';
		
		$data['categories'] = $this->complaint_model->getProductCategory();	
		$data['complaintCategories'] = $this->complaint_model->getComplaintCategory();	
		$data['complaintConcernDepts'] = $this->complaint_model->getComplaintConcernDept();	
		$data['complaintModes'] = $this->complaint_model->getComplaintMode();	
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
			
		$this->form_validation->set_rules('company_name', 'Company name', 'required');		
		$this->form_validation->set_rules("message[complaint]", 'Complaint', 'callback_word_check');
		$this->form_validation->set_rules("date_of_complaint", 'Date of Complaint ', 'callback_date_check');

		if ($this->form_validation->run() == false) {
			
			$this->load->view('common/header');
			$this->load->view('complaint/complaint_form', $data);
			$this->load->view('common/footer');			
		} else {
						
			if(!empty($_FILES['complaint_file']['name'])){
				$config['upload_path'] = 'uploads/complaint/';
				$config['allowed_types'] = 'jpg|jpeg|png|pdf';
				$config['file_name'] = $_FILES['complaint_file']['name'];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('complaint_file')){
					$uploadData = $this->upload->data();						
					$complaint_file = $config['upload_path'].$uploadData['file_name'];
				}else{
					$complaint_file = '';
				}					
			}else{
				$complaint_file = '';
			}			
			
			$complaint_id = $this->complaint_model->addComplaint($this->input->post(),$complaint_file);
			if(!empty($complaint_id)){
			    $this->sendMail($complaint_id,$this->input->post());
			}
			$_SESSION['success']      = "Success: You have Added New Complaint";
			redirect('/complaint');
		}			
	}
	
	public function word_check($str) {
		$count = str_word_count($str);		
		if ($count > 500)		{
			$this->form_validation->set_message('word_check', 'The {field} field enter maximum 500 Words.');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function date_check($str) {		
		$endDate = date('d-m-Y',strtotime("-15 days"));
		$postDate = date('d-m-Y',strtotime($str));
		
		$endDate=strtotime($endDate);
		$postDate=strtotime($postDate);

		if($postDate < $endDate){
			$this->form_validation->set_message('date_check', 'The {field} Not beyond 15 days back date..');
			return false;
		} else {
			return true;
		}
	}
	
	public function complaintView($complaint_id){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Complaint List', '/complaint');
		$data['page_heading'] = "Complaint View";
	    
		$data['form_action']= 'complaintView/'.$complaint_id;
				
		$data['compaint'] = $this->complaint_model->getComplaintById($complaint_id);
		
		$data['compaintDetails'] = $this->complaint_model->getComplaintDetailById($complaint_id);
		$data['compaintCorrectives'] = $this->complaint_model->getComplaintCorrectiveById($complaint_id);
		$data['compaintPreventives'] = $this->complaint_model->getComplaintPreventiveById($complaint_id);	
		
		$this->load->helper('form');
		$this->load->library('form_validation');			
		$this->form_validation->set_rules("date_of_customer_info", 'Date of Customer Intimation', 'required|callback_date_check');		
		$this->form_validation->set_rules('status', 'Status', 'required');	
		
		
		if ($this->form_validation->run() == false) {
			
			$this->load->view('common/header');
			$this->load->view('complaint/complaint_view', $data);
			$this->load->view('common/footer');			
		} else {			
			
			$this->complaint_model->updateComplaint($this->input->post());
			if(!empty($complaint_id)){
				$data['compaint']->resolved = 1;
			    $this->sendMail($complaint_id,$data['compaint']);
			}
			$_SESSION['success']      = "Success: You have Added New Complaint";
			redirect('/complaintView/'.$complaint_id);
		}			
		unset($_SESSION['success']);
	}
	
	public function addComplaintMessage(){
		$checkword = str_word_count($this->input->post('complaint'));
		$mess_type = $this->input->post('mess_type');
		$json = array();
		if($checkword > 500){			
			$json[$mess_type] = "Your enter exceed 500 words";			
			echo json_encode($json);			
		} else {
			
			if(!empty($_FILES['complaint_file']['name'])){
				$config['upload_path'] = 'uploads/complaint/';
				$config['allowed_types'] = 'jpg|jpeg|png|pdf';
				$config['file_name'] = $_FILES['complaint_file']['name'];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('complaint_file')){
					$uploadData = $this->upload->data();						
					$complaint_file = $config['upload_path'].$uploadData['file_name'];
				}else{
					$complaint_file = '';
				}					
			}else{
				$complaint_file = '';
			}			
			
			$json['success'] = $this->complaint_model->addComplaintMessage($this->input->post(),$complaint_file);	
			echo json_encode($json);			
		}	
	}
	
	public function complaintDownload($complaint_id) {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
						
		$data['compaint'] = $this->complaint_model->getComplaintById($complaint_id);
		$data['compaintDetails'] = $this->complaint_model->getComplaintDetailById($complaint_id);
		$data['compaintCorrectives'] = $this->complaint_model->getComplaintCorrectiveById($complaint_id);
		$data['compaintPreventives'] = $this->complaint_model->getComplaintPreventiveById($complaint_id);
		
		$html= $this->load->view('complaint/complaint_download', $data,true);
		
		//this the the PDF filename that user will get to download
		$filename = $complaint_id;
		$pdfFilePath = $filename.".pdf";

		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		//$stylesheet = file_get_contents('http://localhost/optitecheyecare/assets/vendor/bootstrap/css/bootstrap.min.css');
		//$pdf->WriteHTML($stylesheet,1);
		
		$header = '<div style="margin-right: 25px;margin-left: 25px;padding-top: 15px;font-size:12px;border-bottom:0px solid black;">	
	<div style="width:100%;padding-top:30px;padding-bottom:25px;">
		<div style="width:100%;text-align:center;"><img src="'.base_url().'uploads/logo/allahabad.png"></div>	
	</div>	
	<div style="width:64%;float:left;font-size:17px;text-align:left;">Complaint</div>
	
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
	
	public function sendMail($complaint_id,$data) {
			    
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
		
		if($data->resolved == 1){
			$concern_dept_id = $data->concern_dept_id;
			$userInfo2 = $this->complaint_model->getUserInfoByUserId($data->user_id);
		} else {
			$concern_dept_id = $data['concern_dept_id'];
		}	
		
		$userInfo = $this->complaint_model->getUserInfoByDepartmentId($concern_dept_id);
		
		#$to = $userInfo->email;
		$to = array_filter(array($userInfo->email, $userInfo2->email, $_SESSION['email']));
		
	
		$message .= "Dear ".$userInfo->username."<br><br>";
		if($data->resolved == 1){
			$subject = 'SR'.$complaint_id.' - Closed By '.$_SESSION['username'];
			$message .= "Closed";
		} else {
			$subject = 'SR'.$complaint_id.' - Raised By '.$_SESSION['username'];
			$message .= $data['message']['complaint'];
		}	
		
		//$quote_file = $this->input->post('quote_file');
		//$email_cc = $userInfo['email'];
		
		$admin_email = $this->config->item('admin_email');
		$replyto_email = $this->config->item('replyto_email');
		$copy_email = $this->config->item('copy_email');
		
		$this->email->from($admin_email, 'Optitech eye care');
		$this->email->reply_to($replyto_email, 'Optitech eye care');
		$this->email->to($to);
		$this->email->bcc($copy_email);
		
	    /*if($data->resolved == 1){
	        $this->email->cc($userInfo2->email);
	    }
	    
		if($to != $_SESSION['email']){
			$this->email->cc($_SESSION['email']);
		}*/
	
		$this->email->subject($subject);
		$this->email->message(nl2br($message));
		
	    /* foreach($quote_file as $file){
		    $attachfile = getcwd().'/'.$file;
			$this->email->attach($attachfile);
		}  */
		
		$this->email->send();
		
	}
	
}