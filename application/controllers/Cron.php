<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();		
		$this->load->helper(array('url'));
		$this->load->model('cron_model');				
		$this->load->model('bulkmessage_model');
		$this->load->library('curl');
	}
	
	public function index()
	{		
		$data['pendingOrders'] = $this->cron_model->getPendingOrders();
		
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
		
		
		$admin_email = $this->config->item('admin_email');
		$replyto_email = $this->config->item('replyto_email');
		$copy_email = $this->config->item('copy_email');
		
		$to = $copy_email;
		$subject = 'Pending Orders at '.date('d-m-Y  h:i:sa');
		$message = $this->load->view('email_template/order_pending', $data, true);
	//	echo $message;exit;
		
		//$challan_file = $this->input->post('challan_file');
		//$email_cc = $this->input->post('email_cc');
		
		$this->email->from($admin_email, 'Optitech eye care');
	//	$this->email->reply_to('info@optitecheyecare.com', 'Optitech eye care');
		$this->email->to($to);
		
		//$this->email->cc($email_cc);
		$this->email->bcc('arunpandey1985@gmail.com');		

		$this->email->subject($subject);
		$this->email->message($message);		
	   
		//$attachfile = getcwd().'/'.$challan_file;
		//$this->email->attach($attachfile);		
		
		$this->email->send();
	}
	public function sendWaMsg() {
		
		(int)$hour=date('H');
		#print $hour;
		if($hour<9 || $hour>18){
			#print " Break";
			return false;
			exit;
		}
		$rows=$this->bulkmessage_model->getWaMsgList();
		/*print "<pre>";
		print_r($rows);
		exit;*/
		foreach($rows as $row){
			$instance= $this->config->item('WhatsappInstanceID');
			$whatsappApiUrl= $this->config->item('WhatsappBaseURL');
			$message =trim($row['message']);
			$message=urlencode($message);
			$number=$row['wa_mobile'];
			

			$url=$whatsappApiUrl.'sendText?token='.$instance.'&phone='.$number.'&message='.$message;
			//echo $url;
			$this->curl->create($url);
			$curlResponse = $this->curl->execute();
			
			$curlJson=json_decode($curlResponse);
			$messageId=$curlJson->data->messageIDs[0];
				
			$dataToupdate = array(
				'status'   		=> 'C',
				'ref_number'	=> $messageId,
				'send_date'		=> date('Y-m-j H:i:s')
			);					
			$this->db->where('id', $row['id'] );
			$this->db->update('whatsapp_schedule', $dataToupdate);

			if(!empty($row['file_name'])){
				$urlpdf=$whatsappApiUrl.'sendFiles?token='.$instance.'&phone='.$number.'&link='.$row['file_name'];
				//echo $urlpdf;
				$this->curl->create($urlpdf);				
				$dataCurl = $this->curl->execute();				
			}
		}
       
    }
}