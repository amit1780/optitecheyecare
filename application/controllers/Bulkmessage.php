<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulkmessage extends CI_Controller {
	
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
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index() {
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Bulk Message', '/bulkMessage');
		
		$data['page_heading'] = "Bulk Message";
	    
		$data['success'] = $this->session->success;
		
		$data['form_action']= 'bulkMessage';
		$data['customers'] = array();
		$data['countries'] = $this->customer_model->getCountry();
		
		
		
		$this->load->view('common/header');
		$this->load->view('customer/customer_list_bulk_msg', $data);
		$this->load->view('common/footer');		
		unset($_SESSION['success']);
	}

	public function customerList(){

		$total_rows = $this->customer_model->getTotalCustomers($this->input->get());	
		$customers = $this->customer_model->getCustomers($per_page, $start,$this->input->get());
		#print_r($customers);
		$customerData=Array();
		foreach ($customers as $customer){
			$dataArray=Array();
			
			$dataArray[]=$customer['customer_id'];
			$dataArray[]=$customer['customer_id'];
			$dataArray[]=$customer['company_name'];
			$dataArray[]=$customer['person_title']." ".$customer['contact_person'];
			$dataArray[]=$customer['email'];
			$dataArray[]=$customer['mobile'];
			$customerData[]=$dataArray;
		}
		$finalData['data']=$customerData;
		print(json_encode($finalData));
	}

	public function scheduleWA(){
		
		$formData=$this->input->post();
		
		if(empty($formData['schedule_date'])){
			$formData['schedule_date']=date('Y-m-d');
		}
		$subject='';
		$messageType='W';
		$message=trim($formData['wa_message']);
		if(!empty($formData['messageType']) && $formData['messageType']=='email'){
			$messageType='E';
			$subject=trim($formData['email_subject']);
			$message=$formData['email_message'];
		}

		$attachmentUrl='';
		$success=false;
		

		if(!empty($_FILES['wa_file']['name'])){ 
			$_FILES['file']['name']     	= $_FILES['wa_file']['name']; 
			$_FILES['file']['type']     	= $_FILES['wa_file']['type']; 
			$_FILES['file']['tmp_name'] 	= $_FILES['wa_file']['tmp_name']; 
			$_FILES['file']['error']     	= $_FILES['wa_file']['error']; 
			$_FILES['file']['size']     	= $_FILES['wa_file']['size']; 
			
			$config['upload_path'] = 'uploads/wafiles';
			$config['allowed_types'] = '*';
			$config['file_name'] = $_FILES['wa_file']['name'];
			
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
									
			// Upload file to server 
			if($this->upload->do_upload('file')){                       
				$uploadData = $this->upload->data();
				$filename = $uploadData['file_name'];   
				//$bank_file[] = $filename; 
				$attachfile = getcwd().'/uploads/wafiles/'.$filename;
				//print "$attachfile";
				$attachmentUrl=base_url('').'uploads/wafiles/'.$filename;
			} 			
		}

		$messageData = array(
			'message'   		=> $message,
			'file_name'			=> $attachmentUrl,
			'message_type'		=> $messageType,
			'subject'			=> $subject,
			'added_by'			=> $_SESSION['user_id']
		);
		$this->db->insert('wa_messages', $messageData);
		$msgId=$this->db->insert_id();
		if(!empty($msgId)){
			$customers=explode(',',$formData['allCustomers']);
			
			foreach($customers as $customer){
				if(!empty($customer)){
					$customerInfo=$this->customer_model->getCustomerById($customer);
					if($messageType=='E'){
						$customerInfo->mobile=preg_replace( '/\D+/is', '', $customerInfo->mobile);
						$customerInfo->code=preg_replace( '/\D+/is', '', $customerInfo->code);
						if(!empty($customerInfo->email)){
							$email=$customerInfo->email;
							$uid=$this->db->get_where('email_schedule', array('msg_id' => $msgId,'email' => $email))->row()->id;
							if(empty($uid)){
								$customerData = array(
									'customer_id' => $customer,
									'msg_id' => $msgId,
									'email' => $email,
									'scheduled_date' => $formData['schedule_date'],
									'added_by' =>  $_SESSION['user_id']
								);
								$this->db->insert('email_schedule', $customerData);
								$success=true;
							}
						}
					}else{
						$customerInfo->mobile=preg_replace( '/\D+/is', '', $customerInfo->mobile);
						$customerInfo->code=preg_replace( '/\D+/is', '', $customerInfo->code);
						if(!empty($customerInfo->mobile)){
							$number=$customerInfo->code.$customerInfo->mobile;
							$uid=$this->db->get_where('whatsapp_schedule', array('msg_id' => $msgId,'wa_mobile' => $number))->row()->id;
							if(empty($uid)){
								$customerData = array(
									'customer_id' => $customer,
									'msg_id' => $msgId,
									'wa_mobile' => $number,
									'scheduled_date' => $formData['schedule_date']
								);
								$this->db->insert('whatsapp_schedule', $customerData);
								$success=true;
							}
						}
					}
				}
			}
		}
		if($success){
			print "success";
		}else{
			print "failed";
		}
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
}
