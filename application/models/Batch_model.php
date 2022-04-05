<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Batch_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function addBatch($data,$otherData) {
		if(empty($_SESSION['file_name'])){
			$_SESSION['file_name']='';
		}
		$batch_data = array(
			'iqc'   					=> $data['iqc'],
			'user_id'   			    => $_SESSION['user_id'],
			'store_id'   			    => $data['store_id'],
			'product_id'   			    => $data['product_id'],
			'brand'   					=> $data['brand_name'],
			'ce'   						=> $data['ce'],
			'batch_size' 				=> $data['batch_size'],
			'batch_no' 					=> $data['batch_no'],
			'mfg_date' 					=> $otherData['mfg_date'],
			'exp_date' 					=> $otherData['exp_date'],
			'mfg_neutral_code' 			=> $data['neutral_code'],
			'sterlization' 				=> $data['sterlization'],
			'sterlization_file' 		=> $_SESSION['file_name'],
			'good_recive_on' 			=> date("Y-m-d", strtotime($data['good_received_on'])),
			'added_datetime' 			=> date('Y-m-d H:i:s')
		);
		
		$this->db->insert('batch', $batch_data);
		$batch_id = $this->db->insert_id();
		
		if($data['stock_popup']){
			$resData = array(
				'batch_id' => $batch_id,
				'batch_no' => $data['batch_no']
			);
			
			return $resData;
		} else {
			return true;
		}				
	}
	
	public function editBatch($data,$otherData) {
		if(empty($_SESSION['file_name'])){
			$_SESSION['file_name']='';
		}
		
		
		$batch_data = array(
			'iqc'   					=> $data['iqc'],
			'ce'   						=> $data['ce'],
			'product_id'   				=> $data['product_id'],
			'mfg_date' 					=> $otherData['mfg_date'],
			'exp_date' 					=> $otherData['exp_date'],
			'mfg_neutral_code' 			=> $data['neutral_code'],
			'sterlization' 				=> $data['sterlization'],
			'sterlization_file' 		=> $_SESSION['file_name'],
			'good_recive_on' 			=> date("Y-m-d", strtotime($data['good_received_on']))
		);
		
		$this->db->where('batch_id', $otherData['batch_id']);
		$this->db->update('batch', $batch_data);		
	}
	

	public function getBatchByData($data) {
		
		$qryArr=Array();
		
		if(!empty($data['batch_no'])){
			$qryArr['batch_no']=trim($data['batch_no']);
		}
		if(!empty($data['batch_id'])){
			$qryArr['batch_id']=trim($data['batch_id']);
		}

		$this->db->select('*');
		$this->db->from('batch');
		$this->db->where($qryArr);
		
		return $this->db->get()->result_array();		
	}

	public function getBatchList($limit, $start,$data) {
		$qryArr=Array();
		
		if(!empty($data['batch_no'])){
			$qryArr['batch_no']= trim($data['batch_no']);
		}
		
		if(!empty($data['iqc'])){
			$qryArr['iqc']= trim($data['iqc']);
		}
		
		if(!empty($data['model'])){
			$qryArr['product.product_id']=trim($data['model']);
		} 
		
		$this->db->select('*')
            ->from('batch');
		$this->db->join('product', 'product.product_id = batch.product_id', 'left');
		
		$this->db->where($qryArr);
		
		if(!empty($data['product_name'])){
			$this->db->group_start();
				$this->db->like('product.product_name',trim($data['product_name']));
				$this->db->or_like('product.description',trim($data['product_name']));				
			$this->db->group_end();
		}
		
		
		$this->db->limit( $limit, $start );	
		$this->db->order_by("product.product_name ASC, product.model ASC");
		//$this->db->order_by("product.model", "ASC");
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalBatch($data) {
		
		$qryArr=Array();
		
		if(!empty($data['batch_no'])){
			$qryArr['batch_no']= trim($data['batch_no']);
		}
		
		if(!empty($data['iqc'])){
			$qryArr['iqc']= trim($data['iqc']);
		}
		
		if(!empty($data['model'])){
			$qryArr['product.product_id']=trim($data['model']);
		} 
		
		$this->db->select('*')
            ->from('batch');
		$this->db->join('product', 'product.product_id = batch.product_id', 'left');
		
		$this->db->where($qryArr);
		
		if(!empty($data['product_name'])){
			$this->db->group_start();
				$this->db->like('product.product_name',trim($data['product_name']));
				$this->db->or_like('product.description',trim($data['product_name']));				
			$this->db->group_end();
		}
		
		
		//$this->db->limit( $limit, $start );	
		$this->db->order_by("product.product_name", "ASC");
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->num_rows();
	}
	
	public function getBatchById($batch_id) {		
		$this->db->select('*')
            ->from('batch');
		$this->db->join('product', 'product.product_id = batch.product_id', 'left');
		$this->db->where('batch.batch_id', $batch_id);
		$query = $this->db->get();			
		
		return $query->row();
	}
	
	public function getDelStatus($batch_id) {		
		$this->db->select('*')
            ->from('stock');
		$this->db->where('batch_id', $batch_id);
		$query = $this->db->get();		
		return $query->num_rows();
	}
	
	public function checkBatchIdInChallan($batch_id) {		
		$this->db->select('*')
            ->from('challan_product');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$arr = array('challan.is_deleted' => 'N', 'challan_product.batch_id' => $batch_id);
		$this->db->where($arr);
		$query = $this->db->get();		
		return $query->num_rows();
	}
	
	public function deleteBatch($batch_id) {		
		$this->db->where('batch_id', $batch_id);
		$this->db->delete('batch');
		return true;
	}
}