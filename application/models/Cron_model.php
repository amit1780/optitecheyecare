<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cron_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function getPendingOrders(){
	    #SELECT * FROM `svi_order_customer` WHERE `challan_status` = 'P'
		/*$this->db->select('*, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount')
            ->from('order_customer');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');		
		$this->db->order_by('challan_status',"DESC");
		$this->db->order_by('date_added',"DESC");		
		$query = $this->db->get();		
		return $query->result_array();*/
		$this->db->select('order_id,quotation_id,customer_name,date_added,(SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount,(SELECT currency FROM svi_currency WHERE id = svi_order_customer.currency_id) as currency');
		$this->db->from('order_customer');
		$this->db->where('challan_status','P');
		$this->db->order_by('date_added',"DESC");		
		$query = $this->db->get();		
		return $query->result_array();
	}
	
}