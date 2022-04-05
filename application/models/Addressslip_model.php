<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Addressslip_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function addAddressSlip($data){
		if($data['addressslip_id']){
			
			$addressslip_data=array(
				'challan_id' 				=> $data['challan_id'],
				'no_of_package' 			=> $data['no_of_packs'],
				'package_identical' 		=> $data['package_identical'],
				'weight' 					=> $data['weight_all'],
				'weight_units' 				=> $data['weight_unit'],									
				'address_type' 				=> $data['address_type'],									
				'date_added'				=> date('Y-m-d H:i:s')
			);
			
			$this->db->where('addressslip_id',$data['addressslip_id']);
			$this->db->update('addressslip',$addressslip_data);
			
			$addAddressSlip_id = $data['addressslip_id']; 
			
			$this->db->where('addressslip_id', $addAddressSlip_id);
			$this->db->delete('addressslip_packages');
			
			$packData = $data['pack'];		
			foreach($packData as $index => $pack ){
				
				$addressslip_package=array(
					'addressslip_id' 		=> $addAddressSlip_id,
					'package_no' 			=> $pack,
					'qty' 					=> $data['qty'][$index],
					'weight' 				=> $data['weight'][$index],
					'product_id' 			=> $data['product'][$index]
				);
				
				$this->db->insert('addressslip_packages',$addressslip_package);			
			} 
			
			
		} else {
			$addressslip_data=array(
				'challan_id' 				=> $data['challan_id'],
				'no_of_package' 			=> $data['no_of_packs'],
				'package_identical' 		=> $data['package_identical'],
				'weight' 					=> $data['weight_all'],
				'weight_units' 				=> $data['weight_unit'],
				'address_type' 				=> $data['address_type'],				
				'date_added'				=> date('Y-m-d H:i:s')
			);
			
			$this->db->insert('svi_addressslip',$addressslip_data);
			$addAddressSlip_id = $this->db->insert_id(); 
			
			$packData = $data['pack'];		
			foreach($packData as $index => $pack ){
				
				$addressslip_package=array(
					'addressslip_id' 		=> $addAddressSlip_id,
					'package_no' 			=> $pack,
					'qty' 					=> $data['qty'][$index],
					'weight' 				=> $data['weight'][$index],
					'product_id' 			=> $data['product'][$index]
				);
				
				$this->db->insert('addressslip_packages',$addressslip_package);			
			} 
		}
	} 

	public function getChallanProductById($challan_id){		
	    $this->db->select('*,(SELECT description FROM svi_product WHERE product_id=svi_challan_product.product_id) as pro_des, (SELECT model FROM svi_product WHERE product_id=svi_challan_product.product_id) as pro_model')
            ->from('challan_product');		
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);
		$this->db->group_by('challan_product.product_id');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getAddressSlipById($challan_id){	
		
	    $this->db->select('*')
            ->from('addressslip');		
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getAddressSlipBySlipId($addressslip_id){	
		
	    $this->db->select('*')
            ->from('addressslip');		
		$array = array('addressslip_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getAddressSliPackagepById($addressslip_id){		
	    $this->db->select('*,(SELECT challan_id FROM svi_addressslip WHERE addressslip_id = svi_addressslip_packages.addressslip_id) as challan_id')
            ->from('addressslip_packages');
		$this->db->join('product', 'product.product_id = addressslip_packages.product_id', 'left');
		$array = array('addressslip_id' => $addressslip_id);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getAddressSliPackagepByGroup($addressslip_id){		
	    $this->db->select('*,(SELECT challan_id FROM svi_addressslip WHERE addressslip_id = svi_addressslip_packages.addressslip_id) as challan_id, SUM(qty) AS qty, SUM(weight) AS weight')
            ->from('addressslip_packages');
		$this->db->join('product', 'product.product_id = addressslip_packages.product_id', 'left');
		$array = array('addressslip_id' => $addressslip_id);
		$this->db->where($array);
		$this->db->group_by('package_no');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getAddressSliPackagepBySingleId($package_no,$addressslip_id){		
	    $this->db->select('*')
            ->from('addressslip_packages');
		$this->db->join('product', 'product.product_id = addressslip_packages.product_id', 'left');
		$array = array('package_no' => $package_no, 'addressslip_id' => $addressslip_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getBatchDetailsBaseChallanProduct($challan_id,$product_id){		
	    $this->db->select('*')
            ->from('challan_product');
		$this->db->join('batch', 'batch.batch_id = challan_product.batch_id', 'left');
		$array = array('challan_id' => $challan_id, 'challan_product.product_id' => $product_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getOrderDetails($challan_id){		
	    $this->db->select('*')
            ->from('challan');
		$this->db->join('order_customer', 'order_customer.order_id = challan.order_id', 'left');
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}
	
}