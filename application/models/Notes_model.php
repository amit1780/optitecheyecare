<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Notes_model extends CI_Model {

	
	public function __construct() {		
		parent::__construct();
		$this->load->database();		
	}
	
	public function addNotes($data,$customer_id) {		
		$notes_data = array(
			'user_id'   			=> $_SESSION['user_id'],
			'customer_id'   		=> $customer_id,			
			'notes'   				=> $data['notes'],			
			'date_added' 			=> date('Y-m-j H:i:s')
		);		
		$this->db->insert('notes', $notes_data);
		$customer_id = $this->db->insert_id();						
		return true;		
	}
	
	public function getNotes($customer_id){
		
		$this->db->select('*, notes.date_added as notes_date_added')
            ->from('notes');
			$this->db->join('user', 'user.user_id = notes.user_id', 'left');
			$this->db->where('customer_id', $customer_id);
			$this->db->order_by('notes.date_added', 'DESC');
			$query = $this->db->get();
			
		return $query->result_array();
	
	}
	
}
