<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model('common_model');
		$this->load->model('order_model');
		$this->load->model('quotation_model');
    }

    public function index() {
        return false;
    }

	public function getEmail() {	
		$formData=$this->input->get();	
		$data=Array();
		if(!empty($formData['order_id'])){
			$data['ordersInfo'] =  $this->order_model->getOrderById($formData['order_id']);
			$data['customerInfo'] = $this->order_model->getCustomerById($data['ordersInfo']->customer_id);
			$data['lastEmailInfo'] = $this->common_model->getLastSendEmail($data['ordersInfo']->customer_id);
			$lastEmailInfo='';
			
			if(!empty($data['lastEmailInfo'])){

				$userInfo = $this->common_model->getUserDetails($data['lastEmailInfo']->sent_by);

				$userName=$userInfo->firstname." ".$userInfo->lastname;

				$lastEmailInfo="Previous email with subject <b>'".$data['lastEmailInfo']->subject."'</b> was sent on <i>".dateFormat('d-m-Y',$data['lastEmailInfo']->send_date)." by ".$userName."<i>";
			}
			$json = array();
			$json[] = array(
				'person' 			=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
				'email_to' 			=> $data['customerInfo']->email,
				'customer_id' 		=> $data['ordersInfo']->customer_id,
				'lastEmailInfo' 	=> $lastEmailInfo
			);	
			print json_encode($json);
		}else if(!empty($formData['quotation_id'])){
			$data['quotationInfo'] = $this->quotation_model->getQuotationCustomerById($formData['quotation_id']);
			$data['customerInfo'] = $this->order_model->getCustomerById($data['quotationInfo']->customer_id);
			$data['lastEmailInfo'] = $this->common_model->getLastSendEmail($data['quotationInfo']->customer_id);
			$lastEmailInfo='';
			
			if(!empty($data['lastEmailInfo'])){

				$userInfo = $this->common_model->getUserDetails($data['lastEmailInfo']->sent_by);

				$userName=$userInfo->firstname." ".$userInfo->lastname;

				$lastEmailInfo="Previous email with subject <b>'".$data['lastEmailInfo']->subject."'</b> was sent on <i>".dateFormat('d-m-Y',$data['lastEmailInfo']->send_date)." by ".$userName."<i>";
			}
			$json = array();
			$json[] = array(
				'person' 			=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
				'email_to' 			=> $data['customerInfo']->email,
				'customer_id' 		=> $data['quotationInfo']->customer_id,
				'lastEmailInfo' 	=> $lastEmailInfo
			);	
			print json_encode($json);
		}else if(!empty($formData['customer_id'])){
			$data['customerInfo'] = $this->order_model->getCustomerById($formData['customer_id']);
			$data['lastEmailInfo'] = $this->common_model->getLastSendEmail($formData['customer_id']);
			$lastEmailInfo='';
			
			if(!empty($data['lastEmailInfo'])){

				$userInfo = $this->common_model->getUserDetails($data['lastEmailInfo']->sent_by);

				$userName=$userInfo->firstname." ".$userInfo->lastname;

				$lastEmailInfo="Previous email with subject <b>'".$data['lastEmailInfo']->subject."'</b> was sent on <i>".dateFormat('d-m-Y',$data['lastEmailInfo']->send_date)." by ".$userName."<i>";
			}
			$json = array();
			$json[] = array(
				'person' 			=> $data['customerInfo']->person_title ." ". $data['customerInfo']->contact_person,
				'email_to' 			=> $data['customerInfo']->email,
				'customer_id' 		=> $formData['customer_id'],
				'lastEmailInfo' 	=> $lastEmailInfo
			);	
			print json_encode($json);
		}
    }

	public function sendEmail() {	
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
		
		
		$to = $this->input->post('common_email_to');
		$subject = $this->input->post('common_email_subject');
		$message = $this->input->post('common_email_massage');

		$email_cc = $this->input->post('common_email_cc');
		
		$admin_email = $this->config->item('admin_email');
		$replyto_email = $this->config->item('replyto_email');
		$copy_email = $this->config->item('copy_email');
		
		$this->email->from($admin_email, 'Optitech eye care');
		$this->email->reply_to($replyto_email, 'Optitech eye care');
		
		$user_email = $_SESSION['email'];		
		$recipientArr = array($to, $user_email);
        $this->email->to($recipientArr);
		
		$this->email->cc($email_cc);
		$this->email->bcc($copy_email);		

		$this->email->subject($subject);
		$this->email->message(nl2br($message));		
	   	if(!empty($_FILES['email_files']['name']) && count(array_filter($_FILES['email_files']['name'])) > 0){ 
			$filesCount = count($_FILES['email_files']['name']); 
			for($i = 0; $i < $filesCount; $i++){ 
				$_FILES['file']['name']     	= $_FILES['email_files']['name'][$i]; 
				$_FILES['file']['type']     	= $_FILES['email_files']['type'][$i]; 
				$_FILES['file']['tmp_name'] 	= $_FILES['email_files']['tmp_name'][$i]; 
				$_FILES['file']['error']     	= $_FILES['email_files']['error'][$i]; 
				$_FILES['file']['size']     	= $_FILES['email_files']['size'][$i]; 
				
				$config['upload_path'] = 'uploads/emails';
				$config['allowed_types'] = '*';
				$config['file_name'] = $_FILES['email_files']['name'][$i];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
									 
				// Upload file to server 
				if($this->upload->do_upload('file')){                       
					$uploadData = $this->upload->data();
					$filename = $uploadData['file_name'];   
					//$bank_file[] = $filename; 
					$attachfile = getcwd().'/uploads/emails/'.$filename;
					print "$attachfile";
					$this->email->attach($attachfile);	
				} 
			}
		}
		$data=Array();
		$data['email']=$this->input->post('common_email_to');
		$data['subject']=$this->input->post('common_email_subject');
		$data['customer_id']=$this->input->post('common_customer_id');
		$this->common_model->addEmail($data);
		$this->email->send();
		
		echo "1";
    }

	
}