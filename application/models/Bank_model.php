<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bank_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	

	public function getBanks() {
		
		$qryArr=Array();
		
		$qryArr['status']='1';
		$this->db->select('*');
		$this->db->from('bank');
		$this->db->where($qryArr);
		
		return $this->db->get()->result_array();		
	}

	public function getBankById($bank_id) {
		
		$qryArr=Array();
		
		$qryArr['status']='1';
		$qryArr['id']=$bank_id;
		$this->db->select('*');
		$this->db->from('bank');
		$this->db->where($qryArr);
		$query = $this->db->get();
		
		return $query->row();		
	}
	
	public function addBank($data) {
		
		$bankData = array(
			'beneficiary_name'   	=> $data['beneficiary_name'],
			'account_number'		=> $data['account_no'],
			'bank_name'   			=> $data['bank_name'],
			'bank_address'			=> $data['bank_address'],
			'bank_ad_code'   		=> $data['bank_ad_code'],
			'swift_code'   			=> $data['swift_code'],
			'ifsc_code'   			=> $data['ifsc_code'],
			'date_time' 			=> date('Y-m-j H:i:s')
		);
		
		$this->db->insert('bank', $bankData);
		return true;
	}

	public function editBank($data) {
		
		$bankData = array(
			'beneficiary_name'   	=> $data['beneficiary_name'],
			'account_number'		=> $data['account_no'],
			'bank_name'   			=> $data['bank_name'],
			'bank_address'			=> $data['bank_address'],
			'bank_ad_code'   		=> $data['bank_ad_code'],
			'swift_code'   			=> $data['swift_code'],
			'ifsc_code'   			=> $data['ifsc_code']
		);
		
			
				
		$this->db->where('id', $data['bank_id']);
		$this->db->update('bank', $bankData);		
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