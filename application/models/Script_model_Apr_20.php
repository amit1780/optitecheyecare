<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Script_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();		
	}
		
	public function updateOrderTable() {

		$this->db->select('*')
            ->from('order_customer');		
		$query = $this->db->get();
		$orders = $query->result_array();
		foreach($orders as $order){
		
			$this->db->select('SUM(qty) as ordQty')
				->from('order_products');
			$array = array('order_id' => $order['order_id']);
			$this->db->where($array);
			$query = $this->db->get();
			$ordQty = $query->row()->ordQty;
			
			$this->db->select('SUM(qty) as challanQty')
				->from('challan_product');
			$array = array('order_id' => $order['order_id']);
			$this->db->where($array);
			$querya = $this->db->get();
			$challanQty = $querya->row()->challanQty;
			
			if($ordQty == $challanQty){
				$array = array('order_id' => $order['order_id']);
				$this->db->set('challan_status', 'C');
				$this->db->where($array);
				$this->db->update('svi_order_customer');
			}		
		}	
		return true;		
	}
	
	
	public function createId($year) {
		
		/* Quotation  */		
		$quotation = array(
			'id'   			=> $year.'0000',
			'user_id'   	=> 12
		);
		
		$this->db->insert('quote_customer', $quotation);
		$id = $this->db->insert_id();
		
		$this->db->where('id', $last_id);
		$this->db->delete('quote_customer');
				
		/* Order  */		
		$order = array(
			'order_id'   	=> $year.'0000',
			'user_id'   	=> 12
		);
		
		$this->db->insert('order_customer', $order);
		$order_id = $this->db->insert_id();
		
		$this->db->where('order_id', $order_id);
		$this->db->delete('order_customer');
		
		/* Challan  */		
		$challan = array(
			'challan_id'   	=> $year.'0000',
			'user_id'   	=> 12
		);
		
		$this->db->insert('challan', $challan);
		$challan_id = $this->db->insert_id();
		
		$this->db->where('challan_id', $challan_id);
		$this->db->delete('challan');		
		
		return true;
	}	
	
}