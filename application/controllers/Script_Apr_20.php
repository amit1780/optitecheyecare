<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Script extends CI_Controller {
	
		
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
			$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('script_model');
		$this->load->library('dbvars');
	}
	
	public function index()	{	    
		//$this->script_model->updateOrderTable();	
		if(date('m') == 4){			
			if (date('m') > 3) {
				$year = date('Y')."".substr((date('Y') +1),2);
			} else {
				$year = (date('Y')-1)."".substr(date('Y'),2);
			}			
			$result =$this->script_model->createId($year);
			if($result == true){
				echo "success";
			}
		}		
	}
	
}