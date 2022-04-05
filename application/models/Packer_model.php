<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Packer_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}	
	
	public function getPackerList() {
		
		$this->db->select('*');
		$this->db->from('packer');
		$this->db->order_by("packer_full_name", "ASC");	
		$query = $this->db->get();		
		return $query->result_array();
		
	}
	
	public function addPacker($data){
		
		$packer_data = array(			
			'packer_full_name'   					=> trim($data['full_name']),					
			'packer_email'   				=> trim($data['email']),						
			'packer_mobile'   				=> trim($data['mobile']),						
			'packer_status'   				=> $data['status'],			
			'packer_date_added' 			=> date('Y-m-j H:i:s')
		);
		
		$this->db->insert('packer', $packer_data);
		$user_id = $this->db->insert_id();						
		return true;	
	}
	
	public function editPacker($data,$packer_id){
		
		$packer_data = array(			
			'packer_full_name'   					=> trim($data['full_name']),					
			'packer_email'   				=> trim($data['email']),						
			'packer_mobile'   				=> trim($data['mobile']),						
			'packer_status'   				=> $data['status'],			
			'packer_date_added' 			=> date('Y-m-j H:i:s')
		);
		
		$this->db->where('packer_id', $packer_id);
		$this->db->update('packer', $packer_data);		
		
		return true;	
	}
	
	public function getPackerById($packer_id){
		$this->db->select('*');
		$this->db->from('packer');
		$this->db->where('packer_id', $packer_id);
		$query = $this->db->get();		
		return $query->row();
	}	
}
