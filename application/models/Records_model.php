<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Records_model extends CI_Model {

	
	public function __construct() {		
		parent::__construct();
		$this->load->database();		
	}
	
	public function addRecord($data) {		
	
		$record_data = array(
			'user_id'   			=> $_SESSION['user_id'],
			'customer_id'   		=> $data['customer_id'],
			'financial_year'   		=> $data['financial_year'],
			'bill_no'   			=> $data['bill_no'],
			'bill_date'   			=> $data['bill_date'],
			'bill_currency'   		=> $data['bill_currency'],
			'bill_amount'   		=> $data['bill_amount'],
			'challan_id'   			=> $data['challan_id'],
			'challan_date'   		=> $data['challan_date'],
			'payment_bank'   		=> $data['payment_bank'],
			'payment_ref_no'   		=> $data['payment_ref_no'],
			'awb'   				=> $data['awb'],
			'awb_date'   			=> $data['awb_date'],
			'method_of_shipment'   	=> $data['method_of_shipment'],
			'boe_sdf'   			=> $data['boe_sdf'],
			//'sb'   					=> $data['sb'],
			'bank_sub_date'   		=> $data['bank_sub_date'],
			'note'   				=> $data['note'],			
			'date_added' 			=> date('Y-m-j H:i:s')
		);		
		$this->db->insert('records', $record_data);
		$record_id = $this->db->insert_id();						
		return true;		
	}
	
	public function editRecord($data) {		
	
		$record_data = array(
			'user_id'   			=> $_SESSION['user_id'],
			'customer_id'   		=> $data['customer_id'],
			'financial_year'   		=> $data['financial_year'],
			'bill_no'   			=> $data['bill_no'],
			'bill_date'   			=> $data['bill_date'],
			'bill_currency'   		=> $data['bill_currency'],
			'bill_amount'   		=> $data['bill_amount'],
			'challan_id'   			=> $data['challan_id'],
			'challan_date'   		=> $data['challan_date'],
			'payment_bank'   		=> $data['payment_bank'],
			'payment_ref_no'   		=> $data['payment_ref_no'],
			'awb'   				=> $data['awb'],
			'awb_date'   			=> $data['awb_date'],
			'method_of_shipment'   	=> $data['method_of_shipment'],
			'boe_sdf'   			=> $data['boe_sdf'],
			//'sb'   					=> $data['sb'],
			'bank_sub_date'   		=> $data['bank_sub_date'],
			'note'   				=> $data['note'],			
			'date_added' 			=> date('Y-m-j H:i:s')
		);
		
		$this->db->where('record_id', $data['record_id']);
		$this->db->update('records', $record_data);		
		return true;				
	}
	
		
	public function getRecords($limit, $start,$data) {
		
		$qryArr=Array();

		if(!empty($data['bill_no'])){
			$qryArr['records.bill_no']=$data['bill_no'];
		}
		
		if(!empty($data['challan_id'])){
			$qryArr['records.challan_id']=$data['challan_id'];
		}
		
		if(!empty($data['payment_ref_no'])){
			$qryArr['records.payment_ref_no']=$data['payment_ref_no'];
		}
		
		if(!empty($data['awb'])){
			$qryArr['records.awb']=$data['awb'];
		}
				
		$this->db->select('*');
        $this->db->from('records');
		$this->db->join('customer', 'customer.customer_id = records.customer_id', 'left');
		$this->db->join('bank', 'bank.id = records.payment_bank', 'left');
		$this->db->join('currency', 'currency.id = records.bill_currency', 'left');
		$this->db->where($qryArr);		
		$this->db->order_by('record_id', 'DESC');
		$this->db->limit( $limit, $start );
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getTotalRecords($data) {
		
		$qryArr=Array();

		if(!empty($data['bill_no'])){
			$qryArr['records.bill_no']=trim($data['bill_no']);
		}
		
		if(!empty($data['challan_id'])){
			$qryArr['records.challan_id']=trim($data['challan_id']);
		}
		
		if(!empty($data['payment_ref_no'])){
			$qryArr['records.payment_ref_no']=trim($data['payment_ref_no']);
		}
		
		if(!empty($data['awb'])){
			$qryArr['records.awb']=trim($data['awb']);
		}
		
		
		$this->db->select('*');
        $this->db->from('records');		
		
		$this->db->where($qryArr);			
		$this->db->order_by('record_id', 'DESC');		
		$query = $this->db->get();		 	
		return $query->num_rows();
	}
	
	public function getRecordById($record_id) {
		
		$this->db->select('*');
        $this->db->from('records');
		$this->db->join('customer', 'customer.customer_id = records.customer_id', 'left');
		$this->db->join('bank', 'bank.id = records.payment_bank', 'left');
		$this->db->join('currency', 'currency.id = records.bill_currency', 'left');
		$this->db->where('record_id', $record_id);		
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getRecordByBankRefNo($payment_ref_no) {
		
		$this->db->select('*');
        $this->db->from('records');
		$this->db->where('payment_ref_no', $payment_ref_no);		
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getBanks() {		
		$qryArr=Array();		
		$qryArr['status']='1';
		$this->db->select('*');
		$this->db->from('bank');
		$this->db->where($qryArr);		
		return $this->db->get()->result_array();		
	}
	
	public function getCurrencies() {				
		$this->db->select('*');
		$this->db->from('currency');		
		return $this->db->get()->result_array();		
	}
	
}
