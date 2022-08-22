<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model('customer_model');
		$this->load->model('common_model');
		$this->load->model('order_model');
		$this->load->model('quotation_model');
		$this->load->library('curl');
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
	
	public function sendWhatsApp(){
		$instance= $this->config->item('WhatsappInstanceID');
		$whatsappApiUrl= $this->config->item('WhatsappBaseURL');
		$message =trim($this->input->post('wa_message'));
		$message=urlencode($message);
		$quotation_id = $this->input->post('quotation_id');
		
		#$instance='627a19f3f9e0425ac1e33ab6';
		$data=Array();		
		$customerInfo = $this->quotation_model->getCustomerByQuotationId($quotation_id);
		
		$customerInfo->mobile=preg_replace( '/\D+/is', '', $customerInfo->mobile);
		$customerInfo->code=preg_replace( '/\D+/is', '', $customerInfo->code);
		if(empty($customerInfo->mobile)){
			return false;
		}else{


			$uid=$customerInfo->quot_pdf_id;
			$number=$customerInfo->code.$customerInfo->mobile;
			#$number = preg_replace( '/\D+/is', '', $number);

			$url=$whatsappApiUrl.'sendText?token='.$instance.'&phone='.$number.'&message='.$message;
			#echo $url;
			$this->curl->create($url);
			$curlResponse = $this->curl->execute();

			//Hardcoded for testing need to remove.
			#$curlResponse='{"status":"success","message":"00-Success","data":{"connStatus":true,"messageIDs":["6299e54f758e0a8ab4e3d52c"]},"responsetime":0.002160518}';

			if($customerInfo->wa_status =='P'){
				$curlJson=json_decode($curlResponse);
				$messageId=$curlJson->data->messageIDs[0];
				$customerData = array(
					'customer_id' => $customerInfo->customer_id,
					'ref_number' => $messageId,
					'wa_mobile' => $number,
					'send_date' => date('Y-m-j H:i:s')
				);
				$this->db->insert('whatsapp_status', $customerData);
			}

			if(!empty($this->input->post('pdf_check'))){
				if($this->input->post('pdf_check')==1){
					$attachmentUrl=site_url('attachements').'/downloadQuotation/'.$uid;
					$urlpdf=$whatsappApiUrl.'sendFiles?token='.$instance.'&phone='.$number.'&link='.$attachmentUrl;
					#echo $urlpdf;
					$this->curl->create($urlpdf);				
					$dataCurl = $this->curl->execute();
				}
			}
		}
	}

	public function sendWhatsAppOrder(){
		$instance= $this->config->item('WhatsappInstanceID');
		$whatsappApiUrl= $this->config->item('WhatsappBaseURL');
		$message =trim($this->input->post('wa_message'));
		$message=urlencode($message);
		$order_id = $this->input->post('wa_order_id');
		
		#$instance='627a19f3f9e0425ac1e33ab6';
		$data=Array();		
		$customerInfo = $this->order_model->getCustomerByOrderId($order_id);
		
		$customerInfo->mobile=preg_replace( '/\D+/is', '', $customerInfo->mobile);
		$customerInfo->code=preg_replace( '/\D+/is', '', $customerInfo->code);
		if(empty($customerInfo->mobile)){
			return false;
		}else{

			$uid=$customerInfo->order_pdf_id;
			#$customerInfo->code='91';
			#$customerInfo->mobile='9451738701';
			$number=$customerInfo->code.$customerInfo->mobile;
			#$number = preg_replace( '/\D+/is', '', $number);

			$url=$whatsappApiUrl.'sendText?token='.$instance.'&phone='.$number.'&message='.$message;
			#echo $url;
			$this->curl->create($url);
			$curlResponse = $this->curl->execute();

			//Hardcoded for testing need to remove.
			#$curlResponse='{"status":"success","message":"00-Success","data":{"connStatus":true,"messageIDs":["6299e54f758e0a8ab4e3d52c"]},"responsetime":0.002160518}';

			if($customerInfo->wa_status =='P'){
				$curlJson=json_decode($curlResponse);
				$messageId=$curlJson->data->messageIDs[0];
				$customerData = array(
					'customer_id' => $customerInfo->customer_id,
					'ref_number' => $messageId,
					'wa_mobile' => $number,
					'send_date' => date('Y-m-j H:i:s')
				);
				$this->db->insert('whatsapp_status', $customerData);
			}

			//https://enotify.app/api/sendText?token=627a19f3f9e0425ac1e33ab6&phone=919451738701&message=aaa
			
			if(!empty($this->input->post('pdf_check'))){
				if($this->input->post('pdf_check')==1){
					$attachmentUrl=site_url('attachements').'/downloadOrder/'.$uid;
					$urlpdf=$whatsappApiUrl.'sendFiles?token='.$instance.'&phone='.$number.'&link='.$attachmentUrl;
					#echo $urlpdf;
					$this->curl->create($urlpdf);				
					$dataCurl = $this->curl->execute();
				}
			}
		}
	}

	public function sendWhatsAppChallan(){
		$instance= $this->config->item('WhatsappInstanceID');
		$whatsappApiUrl= $this->config->item('WhatsappBaseURL');
		$message =trim($this->input->post('wa_message'));
		$message=urlencode($message);
		$challan_id = $this->input->post('wa_challan_id');
		
		#$instance='627a19f3f9e0425ac1e33ab6';
		$order_id = $this->db->get_where('challan', array('challan_id' => $challan_id))->row()->order_id;
		$data=Array();		
		$customerInfo = $this->order_model->getCustomerByOrderId($order_id);
		
		$customerInfo->mobile=preg_replace( '/\D+/is', '', $customerInfo->mobile);
		$customerInfo->code=preg_replace( '/\D+/is', '', $customerInfo->code);
		if(empty($customerInfo->mobile)){
			return false;
		}else{

			$uid=$this->db->get_where('challan', array('challan_id' => $challan_id))->row()->challan_pdf_id;;
			#$customerInfo->code='91';
			#$customerInfo->mobile='9451738701';
			$number=$customerInfo->code.$customerInfo->mobile;
			$number = preg_replace( '/\D+/is', '', $number);

			$url=$whatsappApiUrl.'sendText?token='.$instance.'&phone='.$number.'&message='.$message;
			#echo $url;
			$this->curl->create($url);
			$curlResponse = $this->curl->execute();

			//Hardcoded for testing need to remove.
			#$curlResponse='{"status":"success","message":"00-Success","data":{"connStatus":true,"messageIDs":["6299e54f758e0a8ab4e3d52c"]},"responsetime":0.002160518}';

			if($customerInfo->wa_status =='P'){
				$curlJson=json_decode($curlResponse);
				$messageId=$curlJson->data->messageIDs[0];
				$customerData = array(
					'customer_id' => $customerInfo->customer_id,
					'ref_number' => $messageId,
					'wa_mobile' => $number,
					'send_date' => date('Y-m-j H:i:s')
				);
				$this->db->insert('whatsapp_status', $customerData);
			}

			//https://enotify.app/api/sendText?token=627a19f3f9e0425ac1e33ab6&phone=919451738701&message=aaa
			
			if(!empty($this->input->post('pdf_check'))){
				if($this->input->post('pdf_check')==1){
					$attachmentUrl=site_url('attachements').'/downloadChallan/'.$uid;
					$urlpdf=$whatsappApiUrl.'sendFiles?token='.$instance.'&phone='.$number.'&link='.$attachmentUrl;
					#echo $urlpdf;
					$this->curl->create($urlpdf);				
					$dataCurl = $this->curl->execute();
				}
			}
		}
	}
	
	
	public function sendWhatsAppCustomer(){
		$instance= $this->config->item('WhatsappInstanceID');
		$whatsappApiUrl= $this->config->item('WhatsappBaseURL');
		$message =trim($this->input->post('wa_message'));
		$message=urlencode($message);
		$customer_id = $this->input->post('wa_customer_id');
		
		
		$data=Array();		
		$customerInfo = $this->customer_model->getCustomerById($customer_id);
		
		$customerInfo->mobile=preg_replace( '/\D+/is', '', $customerInfo->mobile);
		$customerInfo->code=preg_replace( '/\D+/is', '', $customerInfo->code);
		if(empty($customerInfo->mobile)){
			return false;
		}else{
			#$customerInfo->mobile='919919113035';
			$number=$customerInfo->code.$customerInfo->mobile;
			$number = preg_replace( '/\D+/is', '', $number);

			$url=$whatsappApiUrl.'sendText?token='.$instance.'&phone='.$number.'&message='.$message;
			//echo $url;
			$this->curl->create($url);
			$curlResponse = $this->curl->execute();

			//Hardcoded for testing need to remove.
			#$curlResponse='{"status":"success","message":"00-Success","data":{"connStatus":true,"messageIDs":["6299e54f758e0a8ab4e3d52c"]},"responsetime":0.002160518}';

			if($customerInfo->wa_status =='P'){
				$curlJson=json_decode($curlResponse);
				$messageId=$curlJson->data->messageIDs[0];
				$customerData = array(
					'customer_id' => $customerInfo->customer_id,
					'ref_number' => $messageId,
					'wa_mobile' => $number,
					'send_date' => date('Y-m-j H:i:s')
				);
				$this->db->insert('whatsapp_status', $customerData);
			}

			//https://enotify.app/api/sendText?token=<token>&phone=<Phone>&message=aaa
			
			if(!empty($_FILES['wa_file']['name'])){ 
				//$filesCount = count($_FILES['wa_file']['name']); 
				//for($i = 0; $i < $filesCount; $i++){ 
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
						$urlpdf=$whatsappApiUrl.'sendFiles?token='.$instance.'&phone='.$number.'&link='.$attachmentUrl;
						//echo $urlpdf;
						$this->curl->create($urlpdf);				
						$dataCurl = $this->curl->execute();
					} 
				//}
			}
		}
	}

	public function sendWhatsAppDispatchNote(){
		$instance= $this->config->item('WhatsappInstanceID');
		$whatsappApiUrl= $this->config->item('WhatsappBaseURL');
		$message =trim($this->input->post('wa_message'));
		$message=urlencode($message);
		$challan_id = $this->input->post('wa_challan_id');
		
		#$instance='627a19f3f9e0425ac1e33ab6';
		$order_id = $this->db->get_where('challan', array('challan_id' => $challan_id))->row()->order_id;
		$data=Array();		
		$customerInfo = $this->order_model->getCustomerByOrderId($order_id);
		
		$uid=$this->db->get_where('challan', array('challan_id' => $challan_id))->row()->challan_pdf_id;
		print $uid."-->".$challan_id;
		#$customerInfo->code='91';
		#$customerInfo->mobile='9451738701';
		$number=$customerInfo->code.$customerInfo->mobile;
		$number = preg_replace( '/\D+/is', '', $number);

		$url=$whatsappApiUrl.'sendText?token='.$instance.'&phone='.$number.'&message='.$message;
		#echo $url;
		$this->curl->create($url);
		$curlResponse = $this->curl->execute();

		//Hardcoded for testing need to remove.
		#$curlResponse='{"status":"success","message":"00-Success","data":{"connStatus":true,"messageIDs":["6299e54f758e0a8ab4e3d52c"]},"responsetime":0.002160518}';

		if($customerInfo->wa_status =='P'){
			/*$curlJson=json_decode($curlResponse);
			$messageId=$curlJson->data->messageIDs[0];

			$messageId='6299e54f758e0a8ab4e3d52c';
			$url=$whatsappApiUrl."campaignStatus?token=".$instance."&msg_id=".$messageId;
			$this->curl->create($url);
			$curlResponse = $this->curl->execute();
			print($curlResponse);
			//print($curlJson->data->messageIDs[0]);
			#print_r($curlJson['data']);*/
		}

		//https://enotify.app/api/sendText?token=627a19f3f9e0425ac1e33ab6&phone=919451738701&message=aaa
		 
		if(!empty($this->input->post('pdf_check'))){
			if($this->input->post('pdf_check')==1){
				$attachmentUrl=site_url('attachements').'/downloadDispatchNote/'.$uid;
				$urlpdf=$whatsappApiUrl.'sendFiles?token='.$instance.'&phone='.$number.'&link='.$attachmentUrl;
			    #echo $urlpdf;
				$this->curl->create($urlpdf);				
				$dataCurl = $this->curl->execute();
			}
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