<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Certificate_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	

	public function getCertificates() {
		
		$qryArr=Array();
		
		//$qryArr['status']='1';
		$this->db->select('*');
		$this->db->from('certificates');
		$this->db->where($qryArr);		
		$this->db->order_by('certificate_name', 'ASC');		
		return $this->db->get()->result_array();		
	}

	public function getCertificateById($certificate_id) {
		
		$qryArr=Array();
		
		//$qryArr['status']='1';
		$qryArr['certificate_id']=$certificate_id;
		$this->db->select('*');
		$this->db->from('certificates');
		$this->db->where($qryArr);
		$query = $this->db->get();
		
		return $query->row();		
	}
	
	public function addCertificate($data,$file){
		
		$certificate_data = array(
			'certificate_name'   	=> $data['certificate_name'],
			'path'   				=> $file,
			'date_time'   			=> date('Y-m-j H:i:s'),
			'expire_date_time'   	=> date("Y-m-d", strtotime($data['certificate_expiry_date']))
		);
		
		
		$this->db->insert('certificates', $certificate_data);
		return true;
	}

	public function updateCertificate($data,$file) {
		$certificate_data = array(
			'certificate_name'   	=> $data['certificate_name'],
			'expire_date_time'   	=> date("Y-m-d", strtotime($data['certificate_expiry_date']))
		);	
		
		if(!empty($file)){
			$certificate_data ['path']= $file;				
		}		
				
		$this->db->where('certificate_id', $data['certificate_id']);
		$this->db->update('certificates', $certificate_data);		
		return true;		
	}

	public function getUsers($data) {
		
		$qryArr=Array();
		
		$qryArr['store_id']='0';
		$this->db->select('*');
		$this->db->from('user');
		//$this->db->where($qryArr);
		
		return $this->db->get()->result_array();		
	}

	public function getCurrencies($data) {
		
		$qryArr=Array();
		
		
		$this->db->select('*');
		$this->db->from('currency');
		
		return $this->db->get()->result_array();		
	}

	
	

}