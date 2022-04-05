<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Stock_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function addStock($data) {		
		
		$stock_data = array(
			'store_id'   			=> $data['store_id'],
			'user_id'   			=> $this->session->userdata('user_id'),
			'product_id'   			=> $data['product_id'],
			'batch_id'   			=> $data['batch_id'],
			'qty'   				=> $data['qty'],
			'added_datetime' 		=> date('Y-m-d H:i:s')
		);
		
		$this->db->insert('stock', $stock_data);
		$batch_id = $this->db->insert_id();		
			
		return true;		
	}

	public function getStockListUpdate($limit, $start,$data) {
		return false;
		#Query to update Knives stocks
		$this->db->select("*, SUM(qty) as qty, `svi_batch`.`mfg_date` as `s_mfg_date`, `svi_batch`.`exp_date` as `s_exp_date`, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted='N' AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id ) as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted='N' AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id ) as return_qty FROM `svi_stock` LEFT JOIN `svi_batch` ON `svi_batch`.`batch_id` = `svi_stock`.`batch_id` LEFT JOIN `svi_product` ON `svi_product`.`product_id` = `svi_batch`.`product_id` LEFT JOIN `svi_packunit` ON `svi_packunit`.`id` = `svi_product`.`pack_unit` LEFT JOIN `svi_store` ON `svi_store`.`store_id` = `svi_stock`.`store_id` WHERE `svi_stock`.`status` = 'A' AND ( `svi_product`.`product_name` LIKE '%Knives%' and `pack_unit` = 1 ) GROUP BY `svi_stock`.`batch_id`, `svi_stock`.`store_id`");
		#$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getStockList($limit, $start,$data) {
		
		$qryArr=Array();
		 
		$qryArr['stock.status']='A';
		 
		if(!empty($data['batch_no'])){
			$qryArr['batch_no']= trim($data['batch_no']);
		}
		
		if(!empty($data['store_id'])){
			$qryArr['stock.store_id'] = trim($data['store_id']);
		}
		
		if(!empty($data['model'])){
			$qryArr['product.product_id']=trim($data['model']);
		} 
		
	   /*  if(!empty($data['date_from'])){		
			$date_from = 'AND date_added <= "'.$data['date_from'].' 23:59:59"';
		} else {
			$date_from = '';
		}
		
		if(!empty($data['date_from'])){		
			$date_from2 = 'AND return_datetime <= "'.$data['date_from'].' 23:59:59"';
		} else {
			$date_from2 = '';
		} */
		  
		$this->db->select("*, SUM(qty) as qty, batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted='N' AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id $date_from) as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted='N' AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id $date_from) as return_qty")
            ->from('stock');
			$this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
			$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			//$this->db->join('category', 'category.category_id = product.category_id', 'left');
			$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
			$this->db->join('store', 'store.store_id = stock.store_id', 'left');
			
			$this->db->where($qryArr);

			/* Added on 1 Sep 2021 to check if batch has expired or not */
			$curDate=date('Y-m-d 00:00:00');
			if(empty($data['is_expired']) or $data['is_expired']=='N'){
				$this->db->where("batch.exp_date >='$curDate'");
			}elseif(!empty($data['is_expired']) and $data['is_expired']=='Y'){
				$this->db->where("batch.exp_date <'$curDate'");
			}
			
		    if(!empty($data['date_from'])){
				$date_from3 = $data['date_from'].' 23:59:59';
				$this->db->where('stock.approved_datetime <=', $date_from3);
			}
			
			if(!empty($data['product_name'])){
				$this->db->group_start();
					$this->db->like('product.product_name',trim($data['product_name']));
					$this->db->or_like('description',trim($data['product_name']));					
				$this->db->group_end();
			}
			
			/* if(!empty($data['model'])){
				$this->db->group_start();
					$this->db->like('product.model',trim($data['model']));
				$this->db->group_end();
			}  */
			
			//$this->db->group_by('batch_no');
			$this->db->group_by(array('stock.batch_id', 'stock.store_id'));
			
			$this->db->limit( $limit, $start );
			
			if($data['order'] && $data['sort']){
				$this->db->order_by($data['sort'], $data['order']);
			} else {
				$this->db->order_by("product.product_name", "ASC");
				$this->db->order_by("product.model", "ASC");
			}
			
			$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getTotalStock($data){
		$qryArr=Array();
		 
		$qryArr['stock.status']='A';
		 
		if(!empty($data['batch_no'])){
			$qryArr['batch_no']= trim($data['batch_no']);
		}
		
		if(!empty($data['store_id'])){
			$qryArr['stock.store_id'] = trim($data['store_id']);
		}
		
		if(!empty($data['model'])){
			$qryArr['product.product_id']=trim($data['model']);
		} 
		
	    /* if(!empty($data['date_from'])){		
			$date_from = 'AND date_added <= "'.$data['date_from'].' 23:59:59"';
		} else {
			$date_from = '';
		}
		
		if(!empty($data['date_from'])){		
			$date_from2 = 'AND return_datetime <= "'.$data['date_from'].' 23:59:59"';
		} else {
			$date_from2 = '';
		} */
		  
		$this->db->select("*, SUM(qty) as qty, batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted='N' AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id $date_from) as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted='N' AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id $date_from) as return_qty")
            ->from('stock');
			$this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
			$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			//$this->db->join('category', 'category.category_id = product.category_id', 'left');
			$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
			$this->db->join('store', 'store.store_id = stock.store_id', 'left');
			
			$this->db->where($qryArr);
			/* Added on 1 Sep 2021 to check if batch has expired or not */
			$curDate=date('Y-m-d 00:00:00');
			if(empty($data['is_expired']) or $data['is_expired']=='N'){
				$this->db->where("batch.exp_date >='$curDate'");
			}elseif(!empty($data['is_expired']) and $data['is_expired']=='Y'){
				$this->db->where("batch.exp_date <'$curDate'");
			}
		    if(!empty($data['date_from'])){
				$date_from3 = $data['date_from'].' 23:59:59';
				$this->db->where('stock.approved_datetime <=', $date_from3);
			}
			
			if(!empty($data['product_name'])){
				$this->db->group_start();
					$this->db->like('product.product_name',trim($data['product_name']));
					$this->db->or_like('description',trim($data['product_name']));					
					
					//$this->db->like('category.name',trim($data['product_name']));
					//$this->db->or_like('description',trim($data['product_name']));
				$this->db->group_end();
			}
			
			/* if(!empty($data['model'])){
				$this->db->group_start();
					$this->db->like('product.model',trim($data['model']));
				$this->db->group_end();
			}  */
			
			//$this->db->group_by('batch_no');
			$this->db->group_by(array('stock.batch_id', 'stock.store_id'));
			
			$this->db->limit( $limit, $start );
			
			if($data['order'] && $data['sort']){
				$this->db->order_by($data['sort'], $data['order']);
			} else {
				$this->db->order_by("product.product_name", "ASC");
				$this->db->order_by("product.model", "ASC");
			}
			
			$query = $this->db->get();		
		return $query->num_rows();
	}
	
	 	
	public function getProductName($name){
		$this->db->select('*')
            ->from('product');
			$this->db->like('product_name', $name);
			$this->db->group_by('product_name'); 
			$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function getProductModel($name){
		$this->db->select('*')
            ->from('product');
			$this->db->where('product_name', $name);
			$this->db->order_by("model", "ASC");
			$query = $this->db->get();		
		return $query->result_array();
	} 
	
	public function getProductName2($name){
		$this->db->select('*')
            ->from('category');
			$this->db->like('name', $name);
			//$this->db->group_by('product_name'); 
			$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function getProductModel2($name){
		$this->db->select('*')
            ->from('product');
		$this->db->join('category', 'category.category_id = product.category_id', 'left');
			$this->db->where('category.name', $name);
			$this->db->order_by("model","ASC");
			$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getBatch($data){
		#$exp_before = $this->config->item('exp_before');
		$exp_before = $this->dbvars->__get('config_exp_before');
		$currentMonthAfter = date('Y-m-t', strtotime('+'.$exp_before.' months'));		
		
		$exp_before = $this->dbvars->__get('config_exp_before');		
	    $this->db->select('*')
            ->from('batch');				
		$array = array('product_id' => $data['product_id'], 'exp_date >=' => $currentMonthAfter);
		$this->db->where($array);		
		$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function getStockInStoreBase($data){		
	    $this->db->select('SUM(qty) as total_qty, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) as return_qty')
            ->from('stock');				
		$array = array('product_id' => $data['product_id'], 'store_id' => $data['store_id'], 'status' => 'A');
		$this->db->where($array);
		$this->db->group_by('product_id');
			$query = $this->db->get();
		
		return $query->row();
	}
	
	public function getBatchInfo($data) {		
		$qryArr=Array();		
		if(!empty($data['batch_id'])){
			$qryArr['batch_id']=$data['batch_id'];
		}
		if(!empty($data['product_id'])){
			$qryArr['product_id']=$data['product_id'];
		}
		
		$this->db->select('*, (SELECT SUM(qty) FROM svi_stock WHERE batch_id = svi_batch.batch_id AND store_id = '.$data['store_id'].'  AND status = "P") as pending_qty, (SELECT SUM(qty) FROM svi_stock WHERE batch_id = svi_batch.batch_id AND store_id = '.$data['store_id'].'  AND status = "A") as approve_qty, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.product_id = svi_batch.product_id AND cp.batch_id = svi_batch.batch_id AND cp.store_id = '.$data['store_id'].') as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.product_id = svi_batch.product_id AND cp.batch_id = svi_batch.batch_id AND cp.store_id = '.$data['store_id'].') as return_qty');
		$this->db->from('batch');
		$this->db->where($qryArr);
		$query = $this->db->get();		
		return $query->row();	
	}
	
	public function getProductExpiryYear($data){
		$this->db->select('pack_unit,unit_name,category_id, (SELECT expiry_year FROM svi_category WHERE category_id = svi_product.category_id) as expiry_year')
            ->from('product')
			->join('packunit', 'packunit.id = product.pack_unit', 'left')
			->where('product_id', $data['product_id']);
			$query = $this->db->get();
		return $query->row();
	}
	
	public function getStore(){
	    $this->db->select('*')
            ->from('store');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getStockByStockId($stock_id){
	    $this->db->select('*,batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date,(SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id) as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id) as return_qty')
            ->from('stock')
			->join('product', 'product.product_id = stock.product_id', 'left')
			->join('batch', 'batch.batch_id = stock.batch_id', 'left')
			->join('store', 'store.store_id = stock.store_id', 'left');
		$array = array('stock.stock_id' => $stock_id, 'stock.status' => 'A');
		$this->db->where($array);
			$query = $this->db->get();		
		return $query->row();
	} 
	
	public function getStockSummary($data){
		
		$stockIIn = array();
		$stockOOut = array();
		$stockReturn = array();
		
	    $this->db->select('*')
            ->from('stock');
		$array = array('batch_id' => $data['batch_id'], 'store_id' => $data['store_id'], 'status' => 'A');
		$this->db->where($array);		
		$this->db->order_by('approved_datetime',"ASC");
		$query = $this->db->get();
		$stocksIn = $query->result_array();
		
		foreach($stocksIn as $stockIn){
			$date_time = new DateTime($stockIn['approved_datetime']);
			$date_time = $date_time->format('Y-m-d')." 00:00:00";
			$stockIIn[] = array(
				'date_time'			=> 	$date_time,
				'challan_id'		=> 	'',
				'company_name'		=> 	'TARUN ENTERPRISES'. (($stockIn['challan_id'] > 0) ? (' <span style="color:red;">Inter Store Transfer</span>') : ('')),
				'qty_in'			=> 	$stockIn['qty'],
				'qty_out'			=> 	''				
			);
		}
		
		$this->db->select('*,(SELECT company_name FROM svi_customer WHERE customer_id = svi_challan_product.customer_id) as company_name, (SELECT challan_date FROM svi_challan WHERE challan_id = svi_challan_product.challan_id) as challan_date')
            ->from('challan_product');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		#$array = array('challan.is_deleted' => 'N', 'challan_product.order_id' => $order_id);	
		$array = array('challan.is_deleted' => 'N', 'challan_product.batch_id' => $data['batch_id'], 'challan_product.store_id' => $data['store_id']);
		$this->db->where($array);
		$this->db->order_by('challan_date',"ASC");
		$query = $this->db->get();
		$stocksOut = $query->result_array();
		
		foreach($stocksOut as $stockOut){
			$dateTimeOut = new DateTime($stockOut['challan_date']);
			$dateTimeOut = $dateTimeOut->format('Y-m-d')." 00:00:00";
			$stockOOut[] = array(
				'date_time'			=> 	$dateTimeOut,
				'challan_id'		=> '<a href="'.site_url('challanView').'/'.$stockOut['challan_id'].'" target="_blank">'.getChallanNo($stockOut['challan_id']).'</a>',
				'company_name'		=> 	$stockOut['company_name'],
				'qty_in'			=> 	'',
				'qty_out'			=> 	$stockOut['qty'],
				'pack_unit'			=> 	$this->db->get_where('order_products',array('order_id'=>$stockOut['order_id'],'prod_id'=>$stockOut['product_id']))->row()->unit	
			);
		}
		
		$this->db->select('*,(SELECT company_name FROM svi_customer WHERE customer_id = svi_challan_product.customer_id) as company_name,')
            ->from('challan_product');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$array = array('challan.is_deleted' => 'N', 'challan_product.batch_id' => $data['batch_id'], 'challan_product.store_id' => $data['store_id']);
		$this->db->where($array);
		$this->db->order_by('return_datetime',"D");
		$query = $this->db->get();
		$stocksRIn = $query->result_array();
		
		foreach($stocksRIn as $stockRIn){
			$dateTimeIn = new DateTime($stockRIn['return_datetime']);
			$dateTimeIn = $dateTimeIn->format('Y-m-d')." 00:00:00";
			if($stockRIn['return_qty'] > 0){							
				$stockReturn[] = array(
					'date_time'			=> 	$dateTimeIn,
					'challan_id'		=> '<a href="'.site_url('challanView').'/'.$stockRIn['challan_id'].'" target="_blank">'.getChallanNo($stockRIn['challan_id']).'</a>',
					'company_name'		=> $stockRIn['company_name']." (Return)",
					'qty_in'			=> 	$stockRIn['return_qty'],
					'qty_out'			=> 	''					
				);
			}
		}
		
		
		$stockSummary = array();
		$stockSummary = array_merge($stockIIn, $stockOOut);
		$stockSummary = array_merge($stockSummary, $stockReturn);
		
		foreach ($stockSummary as $key => $part) {
			$date_time = new DateTime($part['date_time']);			
		   $sort[$key] = str_replace('-', '', $date_time->format('Y-m-d'));		 
		}
		array_multisort($sort, SORT_ASC, $stockSummary);
		return $stockSummary;
	}
	
 	public function getStockBatchDetals($data)
	{
		 $this->db->select('*')
            ->from('stock')
			->join('product', 'product.product_id = stock.product_id', 'left')
			->join('batch', 'batch.batch_id = stock.batch_id', 'left')
			->join('store', 'store.store_id = stock.store_id', 'left');
		$array = array('stock.batch_id' => $data['batch_id'], 'stock.store_id' => $data['store_id'], 'stock.status' => 'A');
		$this->db->where($array);		
		$this->db->order_by('approved_datetime',"ASC");
		$query = $this->db->get();
		return $query->row();
	}	
	
	public function getStockListDownload() {
		
		$qryArr=Array();
		 
		$qryArr['stock.status']='A';
		 
		
		$this->db->select('*, SUM(qty) as qty, batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id) as challan_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.store_id = svi_stock.store_id) as return_qty')
            ->from('stock');
			$this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
			$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
			$this->db->join('store', 'store.store_id = stock.store_id', 'left');
			
			$this->db->where($qryArr);
			
			$this->db->group_by(array('stock.batch_id', 'stock.store_id'));
			$this->db->order_by('stock.stock_id',"DESC");		
			$query = $this->db->get();
		return $query->result_array();
	}
	
}