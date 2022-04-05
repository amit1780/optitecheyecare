<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload extends CI_Controller {
	
		
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
	}
	
	public function index()
	{
		if(!empty($_FILES['file']['name'])){
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = '*';
			$config['file_name'] = $_FILES['file']['name'];
			$filesize = $_FILES['file']['size'];
			
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload('file')){
				$uploadData = $this->upload->data();
				$_SESSION['file_name'] = $uploadData['file_name'];
				$file = base_url()."uploads/".$uploadData['file_name'];		  
				$return_arr = array("name" => $uploadData['file_name'],"size" => $filesize, "src"=> $file);
			}else{
				$return_arr = '';
			}					
		}else{
			$return_arr = '';
		}
		
		echo json_encode($return_arr);
	}	
}