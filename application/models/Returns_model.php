<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Returns_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function getChallanById($challan_id,$invoice_no){
			
			$qryArr=Array();
			
			if(!empty($challan_id)){
				$qryArr['challan_id']=$challan_id;
			}
			if(!empty($invoice_no)){
				$qryArr['invoice_no']=$invoice_no;
			}
			
			$this->db->select('*')
				->from('challan');
			$this->db->join('user', 'user.user_id = challan.user_id', 'left');
			$this->db->join('store', 'store.store_id = challan.store_id', 'left');	
			$this->db->where($qryArr);
			$query = $this->db->get();
			return $query->row();
	}
	
	public function getChallanInfo($challan_id,$invoice_no,$challan_pro_id,$product_id,$customer_id){
		$qryArr=Array();	
		if($challan_pro_id){
			
			if(!empty($challan_id)){
				$qryArr['challan_product.challan_id']=$challan_id;
			}
			if(!empty($invoice_no)){
				$qryArr['challan.invoice_no']=$invoice_no;
			}
			if(!empty($challan_pro_id)){
				$qryArr['challan_product.challan_pro_id']=$challan_pro_id;
			}
			
		} else {
			if(!empty($challan_id)){
				$qryArr['challan_product.challan_id']=$challan_id;
			}
			if(!empty($invoice_no)){
				$qryArr['challan.invoice_no']=$invoice_no;
			}
			if(!empty($product_id)){
				$qryArr['challan_product.product_id']=$product_id;
			}
			if(!empty($customer_id)){
				$qryArr['challan.customer_id']=$customer_id;
			}
		}
		
		$this->db->select('*, (SELECT batch_no FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_no, (SELECT description FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_description, (SELECT model_name FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_model, (SELECT exp_date FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_exp_date,')
            ->from('challan_product');
		
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$this->db->join('store', 'store.store_id = challan_product.store_id', 'left');		
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where($qryArr);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}	
	
	public function addReturns($data){
			
		$proData = $data['product_id'];
		foreach($proData as $index => $product_id ){
			$product_data = array(
				'return_qty'		=> $data['qty_returns'][$index],
				'return_user_id'	=> $_SESSION['user_id'],
				'return_datetime'		=> $data['returns_date'][$index]
			);			
			$this->db->where('challan_pro_id', $product_id);
			$this->db->update('challan_product', $product_data);					
		}
		
		//if($data['return_note']){
			$this->db->where('challan_id', $data['challan_id']);
			$this->db->delete('challan_return_note');
			
			$return_note_data = array(
				'challan_id'   			=> $data['challan_id'],
				'return_note'   		=> $data['return_note'],
				'invoice_reason'   		=> $data['invoice_reason'],	
				'date_added' 			=> date('Y-m-j H:i:s')
			);
			
			$this->db->insert('challan_return_note', $return_note_data);
		//}
		
		return true;
	}
	
	public function getChallanProduct($limit, $start,$data){
		$qryArr=Array();
		 
		if(!empty($data['order_id'])){
			$qryArr['challan_product.order_id']= trim($data['order_id']);
		}
		
		if(!empty($data['challan_id'])){
			$qryArr['challan_product.challan_id']= trim($data['challan_id']);
		}
		
		if(!empty($data['batch_no'])){
			$qryArr['batch.batch_no']= trim($data['batch_no']);
		}
		
		if(!empty($data['store_id'])){
			$qryArr['challan_product.store_id']= trim($data['store_id']);
		}
		
		$this->db->select('*, (SELECT description FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_description, (SELECT model_name FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_model,(SELECT exp_date FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_exp_date,')
            ->from('challan_product');
		$this->db->join('store', 'store.store_id = challan_product.store_id', 'left');
		$this->db->join('batch', 'batch.batch_id = challan_product.batch_id', 'left');
		$this->db->join('order_products', 'order_products.order_id = challan_product.order_id', 'left');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where($qryArr);
		$this->db->where('order_products.prod_id = svi_challan_product.product_id');
		$this->db->where('return_qty != 0');

		if(!empty($data['product_name'])){
			$this->db->group_start();
			$this->db->like('prod_name',trim($data['product_name']));
			$this->db->or_like('description',trim($data['product_name']));
			$this->db->group_end();			
		}
		
		$this->db->order_by('challan_pro_id',"DESC");		
		$this->db->limit( $limit, $start );
		$query = $this->db->get();		
		return $query->result_array();		
	}
	
	
	public function getTotalChallanProduct($data){
		
	    $qryArr=Array();
		 
		if(!empty($data['order_id'])){
			$qryArr['challan_product.order_id']= trim($data['order_id']);
		}
		
		if(!empty($data['challan_id'])){
			$qryArr['challan_product.challan_id']= trim($data['challan_id']);
		}
		
		if(!empty($data['batch_no'])){
			$qryArr['batch.batch_no']= trim($data['batch_no']);
		}
		
		$this->db->select('*, (SELECT description FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_description, (SELECT model_name FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_model,(SELECT exp_date FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_exp_date,')
            ->from('challan_product');
		$this->db->join('store', 'store.store_id = challan_product.store_id', 'left');
		$this->db->join('batch', 'batch.batch_id = challan_product.batch_id', 'left');
		$this->db->join('order_products', 'order_products.order_id = challan_product.order_id', 'left');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where($qryArr);
		$this->db->where('order_products.prod_id = svi_challan_product.product_id');
		$this->db->where('return_qty != 0');
		
		$this->db->order_by('challan_pro_id',"DESC");		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	
	public function getReturnNote($challan_id){
	    $this->db->select('*')
            ->from('challan_return_note');		
		$this->db->where('challan_id', $challan_id);
		$query = $this->db->get();		
		return $query->row();
	}

}