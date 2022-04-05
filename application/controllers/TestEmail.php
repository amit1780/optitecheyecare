<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TestEmail extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper('date');
		$this->load->helper(array('url'));
	}

	public function index(){
		
		$this->sendEmail();
		print "arun";
	}

	protected function sendEmail(){
		
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
		$this->email->from('info@optitecheyecare.in', 'Optitech Eye Care');
		$this->email->to('arunpandey1985@gmail.com');
		

		$this->email->subject('test message');
		$messages="This is test message";
		$this->email->message($messages);

		$this->email->send();
	}

	
}
