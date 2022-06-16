<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function  saveOrder($data){
		
		 $this->db->select('store_id,customer_name,customer_id,contact_person,contact_email,contact_phone,contact_fax,user_id,currency_id,bank_id,billing_details,shipping_details,delivery,insurance,terms_conditions,payment_terms,discount_type,pan_no,gst,special_instruction,created_by');
		$this->db->from('quote_customer');
		$this->db->where('id', $data['quotation_id']);
		$query = $this->db->get();
		$customer_id = $query->row()->customer_id;
		
		$this->db->insert('order_customer',$query->row());
		$order_id = $this->db->insert_id();
		
		$order_data=array(
			'quotation_id' 		=> $data['quotation_id'],
			'billing_details' 		=> $data['billing_details'],
			'shipping_details' 		=> $data['shipping_details'],
			'freight_charge' 	=> $data['freightcharge'],
			'freight_gst' 	=> $this->config->item('PER_FREIGHT_GST'),
			'order_date'		=> date('Y-m-d H:i:s'),
			'status'			=> 'Y',
			'date_added'		=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('order_id',$order_id);
		$this->db->update('order_customer',$order_data);	
		
		$address_data=array(			
			'billing_details' 		=> $data['billing_details'],
			'shipping_details' 		=> $data['shipping_details']			
		);
		
		$this->db->where('id',$data['quotation_id']);
		$this->db->update('quote_customer',$address_data);
		
		$i=0;
		foreach($data['product_id'] as $product_id){			
			
			$this->db->select('`customer_id`, `quotation_id`, `prod_id`, `prod_name`, `model_name`, `description`, `hsn`, `qty`, `unit`, `rate`, `ltp`, `discount`, `net_amount`, `product_gst`');
			$this->db->from('quote_products');
			$array = array('prod_id' => $product_id, 'quotation_id' => $data['quotation_id']);
			$this->db->where($array);
			$query = $this->db->get();
				
			$query->row()->order_id 	= $order_id;
			$query->row()->customer_id 	= $customer_id;
			$query->row()->qty 			= $data['qty'][$product_id];
			$query->row()->net_amount 	= $data['pro_amount'][$product_id];
			
			$query->row()->date_added 	= date('Y-m-d H:i:s');
			$this->db->insert('order_products',$query->row()); 
		$i++; }
		
		$ord=array(
			'order_id' 	=> $order_id			
		);		
		$this->db->where('id',$data['quotation_id']);
		$this->db->update('quote_customer',$ord);
		
		return $order_id;
	}
	
	public function updateOrder($data){
		$address_data=array(			
			'billing_details' 		=> $data['billing_details'],
			'shipping_details' 		=> $data['shipping_details']			
		);
		
		$this->db->where('order_id',$data['order_id']);
		$this->db->update('order_customer',$address_data);
		
		$this->db->where('id',$data['quotation_id']);
		$this->db->update('quote_customer',$address_data);
		
	   return ;
	}
	
	public function getOrderList($limit, $start,$data) {
		$qryArr=Array();
		
		if(!empty($data['order_id'])){
			$qryArr['order_id']= trim(financialOrderId($data['order_id'],$data['foyear']));
		}
		
		if(!empty($data['quote_id'])){
			$qryArr['quotation_id']= trim(financialQuoteId($data['quote_id'],$data['fqyear']));
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['order_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['user_id'])){
			$qryArr['order_customer.created_by']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['order_customer.store_id']=$data['store_id'];
		}
		
		if(!empty($data['customerid'])){
			$qryArr['order_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['order_customer.contact_email']= trim($data['contact_email']);
		}
		
		if(!empty($data['country_id'])){
			$qryArr['customer.country_id']=$data['country_id'];
		}
		
		if(!empty($data['state_id'])){
			$qryArr['customer.state_id']=$data['state_id'];
		}
		
		if(!empty($data['pin_code'])){
			$qryArr['customer.pin']=$data['pin_code'];
		}
		
		if(!empty($data['model'])){			
			$this->db->select('order_id');
			$this->db->from('order_products');
			$this->db->where('prod_id',$data['model']);
			$query3 = $this->db->get();
			$orderIdpmodel = $query3->result_array();			
			$orderIdpmodel = array_column($orderIdpmodel, 'order_id');
			if(empty($orderIdpmodel)){
				$orderIdpmodel = 'null';
			}
		}
		
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('order_id');
			$this->db->from('order_products');
			$this->db->group_start();
				$this->db->like('order_products.prod_name',trim($data['product_name']));
				$this->db->or_like('order_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$orderIdPname = $query3->result_array();			
			$orderIdPname = array_column($orderIdPname, 'order_id');
			if(empty($orderIdPname)){
				$orderIdPname = 'null';
			}
		}
		
		/* if(!empty($data['product_name']) && empty($data['model'])){			
			$this->db->select('order_id');
			$this->db->from('category');
			$this->db->join('product', 'product.category_id = category.category_id', 'left');
			$this->db->join('order_products', 'order_products.prod_id = product.product_id', 'left');
			$this->db->where('category.name',$data['product_name']);
			$query4 = $this->db->get();
			//echo $this->db->last_query();exit;
			$orderIds1 = $query4->result_array();			
			$orderIds1 = array_column($orderIds1, 'order_id');
			if(empty($orderIds1)){
				$orderIds1 = 'null';
			}
		} */
		
		if(!empty($data['incomplete_order'])){
			$order_ids = $this->getMissingField($data['incomplete_order']);			
		}
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, svi_order_customer.date_added as ord_date_added, (SELECT store_name FROM svi_store WHERE store_id = svi_order_customer.store_id) as store_name, (SELECT SUM(amount) FROM svi_order_payment_advice WHERE svi_order_payment_advice.order_id = svi_order_customer.order_id AND svi_order_payment_advice.status = "A") as total_advice_payment')
            ->from('order_customer');			
		
		$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		if(!empty($data['model'])){			
			$this->db->where_in('order_customer.order_id',$orderIdpmodel);			
		}		
		if(!empty($data['product_name']) && empty($data['model'])){		
			$this->db->where_in('order_customer.order_id',$orderIdPname);			
		}	
		
		if(!empty($data['incomplete_order']) && !empty($order_ids)){			
			$this->db->where_in('order_customer.order_id',$order_ids);
		}
		
		$this->db->where($qryArr);
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("order_customer.date_added >", $start_date);
				$this->db->where("order_customer.date_added <", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('order_customer.date_added',$start_date);
			$this->db->group_end();
		} else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('order_customer.date_added',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('order_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('order_customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['contact_phone'])){
			$this->db->group_start();
				$this->db->like('contact_phone',trim($data['contact_phone']));
			$this->db->group_end();
		}
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('customer.city', trim($data['city']));
				$this->db->or_like('customer.district',trim($data['city']));
			$this->db->group_end();
		}
		
		$this->db->limit( $limit, $start );	
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('challan_status',"DESC");
			$this->db->order_by('order_customer.date_added',"DESC");
		}	
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;		
		return $query->result_array();
	}
	
	public function getOrderTotal($data) {
		$qryArr=Array();
		 
		if(!empty($data['order_id'])){
			$qryArr['order_id']= trim(financialOrderId($data['order_id'],$data['foyear']));
		}
		
		if(!empty($data['quote_id'])){
			$qryArr['quotation_id']= trim(financialQuoteId($data['quote_id'],$data['fqyear']));
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['order_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['user_id'])){
			$qryArr['order_customer.created_by']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['order_customer.store_id']=$data['store_id'];
		}
		
		if(!empty($data['customerid'])){
			$qryArr['order_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['order_customer.contact_email']= trim($data['contact_email']);
		}
		
		if(!empty($data['country_id'])){
			$qryArr['customer.country_id']=$data['country_id'];
		}
		
		if(!empty($data['state_id'])){
			$qryArr['customer.state_id']=$data['state_id'];
		}
		
		if(!empty($data['pin_code'])){
			$qryArr['customer.pin']=$data['pin_code'];
		}
		
		if(!empty($data['model'])){			
			$this->db->select('order_id');
			$this->db->from('order_products');
			$this->db->where('prod_id',$data['model']);
			$query3 = $this->db->get();
			$orderIdpmodel = $query3->result_array();			
			$orderIdpmodel = array_column($orderIdpmodel, 'order_id');
			if(empty($orderIdpmodel)){
				$orderIdpmodel = 'null';
			}
		}
		
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('order_id');
			$this->db->from('order_products');
			$this->db->group_start();
				$this->db->like('order_products.prod_name',trim($data['product_name']));
				$this->db->or_like('order_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$orderIdPname = $query3->result_array();			
			$orderIdPname = array_column($orderIdPname, 'order_id');
			if(empty($orderIdPname)){
				$orderIdPname = 'null';
			}
		}
		
		/* if(!empty($data['product_name']) && empty($data['model'])){			
			$this->db->select('order_id');
			$this->db->from('category');
			$this->db->join('product', 'product.category_id = category.category_id', 'left');
			$this->db->join('order_products', 'order_products.prod_id = product.product_id', 'left');
			$this->db->where('category.name',$data['product_name']);
			$query4 = $this->db->get();
			//echo $this->db->last_query();exit;
			$orderIds1 = $query4->result_array();			
			$orderIds1 = array_column($orderIds1, 'order_id');
			if(empty($orderIds1)){
				$orderIds1 = 'null';
			}
		} */
		
		if(!empty($data['incomplete_order'])){
			$order_ids = $this->getMissingField($data['incomplete_order']);			
		}
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, svi_order_customer.date_added as ord_date_added, (SELECT store_name FROM svi_store WHERE store_id = svi_order_customer.store_id) as store_name, (SELECT SUM(amount) FROM svi_order_payment_advice WHERE svi_order_payment_advice.order_id = svi_order_customer.order_id AND svi_order_payment_advice.status = "A") as total_advice_payment')
            ->from('order_customer');			
		
		$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		if(!empty($data['model'])){			
			$this->db->where_in('order_customer.order_id',$orderIdpmodel);			
		}		
		if(!empty($data['product_name']) && empty($data['model'])){		
			$this->db->where_in('order_customer.order_id',$orderIdPname);			
		}	
		
		if(!empty($data['incomplete_order']) && !empty($order_ids)){		
			$this->db->where_in('order_customer.order_id',$order_ids);
		}
		
		$this->db->where($qryArr);
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("order_customer.date_added >", $start_date);
				$this->db->where("order_customer.date_added <", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('order_customer.date_added',$start_date);
			$this->db->group_end();
		} else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('order_customer.date_added',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('order_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('order_customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['contact_phone'])){
			$this->db->group_start();
				$this->db->like('contact_phone',trim($data['contact_phone']));
			$this->db->group_end();
		}
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('customer.city', trim($data['city']));
				$this->db->or_like('customer.district',trim($data['city']));
			$this->db->group_end();
		}
		
		$this->db->limit( $limit, $start );	
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('challan_status',"DESC");
			$this->db->order_by('order_customer.date_added',"DESC");
		}	
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;				
		return $query->num_rows();
	}
	
	public function getMissingField($fields) {		
		if(!empty($fields) && $fields == 'incomplete'){
			$this->db->select('order_id')
            ->from('challan');
			if($_SESSION['group_id'] > 1){
				$array = array('challan.user_id' => $_SESSION['user_id']);
				$this->db->where($array);
			}			
			$this->db->group_start();
			$this->db->where('method_of_shipment', '')					  
					  ->or_where('docket_no', '')
					  ->or_where('invoice_no', '')
					  ->or_where('sb_number', '');					 
			$this->db->group_end();			
			$query = $this->db->get();
			$order_ids = $query->result_array();
			$order_ids = array_column($order_ids, 'order_id');
			return $order_ids;
		} else {
			$this->db->select('order_id')
            ->from('challan');
			if($_SESSION['group_id'] > 1){
				$array = array('challan.user_id' => $_SESSION['user_id']);
				$this->db->where($array);
			}
			
			if($fields == 'sb_number'){
				$this->db->where(array($fields => '', 'challan_type' => 'Export'));
			} else {
				$this->db->where($fields, '');
			}
			
			$query = $this->db->get();			
			$order_ids = $query->result_array();
			$order_ids = array_column($order_ids, 'order_id');
			
			return $order_ids;
		}		
	}
	
	public function getOrderById($order_id) {
		$this->db->select('*')
            ->from('order_customer');
		$this->db->join('store', 'store.store_id = order_customer.store_id', 'left');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$this->db->join('user', 'user.user_id = order_customer.user_id', 'left');
		$this->db->where('order_customer.order_id', $order_id);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getOrderProductById($order_id,$quotation_id) {
		$this->db->select('*')
            ->from('order_products');
		$array = array('order_id' => $order_id, 'quotation_id' => $quotation_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getOrderProductChallan($order_id,$quotation_id){
		$this->db->select('*,(SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.order_id = svi_order_products.order_id AND cp.product_id = svi_order_products.prod_id) as challan_qty')
            ->from('order_products');
		$array = array('order_id' => $order_id, 'quotation_id' => $quotation_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getOrderProductGroupGst($order_id,$quotation_id) {		
		$this->db->select('product_gst,SUM(net_amount) AS net_amount');
		$this->db->from('order_products');
		$array = array('order_id' => $order_id, 'quotation_id' => $quotation_id);
		$this->db->where($array);
		$this->db->where('product_gst != ',0,FALSE);
		$this->db->group_by('product_gst');
		$query = $this->db->get();
		return $query->result_array();		
	}
	
	public function getBankById($bank_id) {
		
		$this->db->select('*');
		$this->db->from('bank');
		$this->db->where('id', $bank_id);
		$query = $this->db->get();
		return $query->row();		
	}
	
	public function getCustomerById($customer_id){
		$this->db->select('*,svi_country.name as country_name,svi_state.name as state_name, customer.country_id as countryId');
		$this->db->from('customer');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->where('customer.customer_id', $customer_id);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->row();
	}
	
	public function getCustomerAddressById($customer_id){
		$this->db->select('*,svi_country.name as country_name,svi_state.name as state_name');
		$this->db->from('customer_address');
		$this->db->join('country', 'country.country_id = customer_address.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer_address.state_id', 'left');
		$this->db->where('customer_address.customer_id', $customer_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getOrderProduct($order_id) {
		$this->db->select('*')
            ->from('order_products');
		$array = array('order_id' => $order_id);
		$this->db->where($array);
		$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function getOrderProductNot($order_id) {
		$this->db->select('*')
            ->from('order_products');
		$array = array('order_id' => $order_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function deleteOrder($order_id) {
		$this->db->where('order_id', $order_id);
		$this->db->delete('order_customer');
		
		$ord=array(			
				'order_id' 		=> null		
		);		
		$this->db->where('order_id', $order_id);
		$this->db->update('quote_customer', $ord);	
		
		return true;
	}
	
	public function deleteOrderProduct($order_product_id) {
		$this->db->select('*')
            ->from('order_products');
		$array = array('id' => $order_product_id);
		$this->db->where($array);
		$query = $this->db->get();		
		$orderInfoPro =$query->row();
		if($orderInfoPro->challan_qty > 0){
			
			$qty = $orderInfoPro->challan_qty;			
			
			$ordQty=array(			
				'qty' 			=> $qty,		
				'net_amount' 	=> $qty * ($orderInfoPro->rate - $orderInfoPro->discount)		
			);
			
			$this->db->where('id',$order_product_id);
			$this->db->update('order_products',$ordQty);
			return true;
		} else {
			
			$this->db->where('id', $order_product_id);
			$this->db->delete('order_products');		
			return true;
			
		}
		
	}
	
	public function updateOrderStatus($order_id){
		$ord=array(			
				'status' 			=> 'Y',		
				'challan_status' 	=> 'C'		
			);
			
		$this->db->where('order_id',$order_id);
		$this->db->update('order_customer',$ord);
		return true;
	}
	
	public function addPaymentAdvice($data,$bank_file){
		
		$advice_data=array(
			'user_id' 				=> $_SESSION['user_id'],
			'order_id' 				=> $data['order_id'],			
			'bank_id' 				=> $data['bank_id'],
			'date_of_payment' 		=> $data['date_of_payment'],
			'bank_ref_no'			=> $data['bank_ref_no'],
			'currency_id'			=> $data['currency_id'],
			'amount'				=> $data['amount'],
			'status'				=> 'A',
			'bank_file'				=> $bank_file[0],
			'date_added'			=> date('Y-m-d H:i:s')
		);
		
		$this->db->insert('order_payment_advice',$advice_data);
		$advice_id = $this->db->insert_id();
		
		$filesCount = count($bank_file);
		if(!empty($bank_file) && count(array_filter($bank_file)) > 0){ 
			for($i = 0; $i < $filesCount; $i++){
				$advice_file_data=array(
					'payment_advice_id' 		=> $advice_id,
					'bank_file' 				=> $bank_file[$i],											
					'date_added'				=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('order_payment_advice_file',$advice_file_data);				
			}
		}
							
		return true;
	}
	
	public function editPaymentAdvice($data,$advice_id,$bank_file){
		
		$this->db->select('*')
            ->from('order_payment_advice');	
		$array = array('order_payment_advice.order_id' => $data['order_id'], 'order_payment_advice.payment_advice_id' => $advice_id);
		$this->db->where($array);
		$query = $this->db->get();
		$adviceInfo = $query->row();
		if($adviceInfo->status == 'A'){
			$status = 'A';
		} else {
			$status = 'p';
		}			
		
		$advice_data=array(
			'user_id' 				=> $_SESSION['user_id'],
			'order_id' 				=> $data['order_id'],			
			'bank_id' 				=> $data['bank_id'],
			'date_of_payment' 		=> $data['date_of_payment'],
			'bank_ref_no'			=> $data['bank_ref_no'],
			'currency_id'			=> $data['currency_id'],
			'amount'				=> $data['amount'],
			'status'				=> $status,
			'modifi_user_id' 		=> $_SESSION['user_id'],
			'modifi_date'			=> date('Y-m-d H:i:s'),
			'date_added'			=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('payment_advice_id',$advice_id);
		$this->db->update('order_payment_advice',$advice_data);
		
		$filesCount = count($bank_file);
		if(!empty($bank_file) && count(array_filter($bank_file)) > 0){ 
			for($i = 0; $i < $filesCount; $i++){
				$advice_file_data=array(
					'payment_advice_id' 		=> $advice_id,
					'bank_file' 				=> $bank_file[$i],				
					'modifi_user_id' 			=> $_SESSION['user_id'],
					'modifi_date'				=> date('Y-m-d H:i:s'),
					'date_added'				=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('order_payment_advice_file',$advice_file_data);				
			}
		}
				
		return true;
	}
	
	public function getAdvices($order_id){
		$this->db->select('*')
            ->from('order_payment_advice');
		$this->db->join('bank', 'bank.id = order_payment_advice.bank_id', 'left');
		$this->db->join('currency', 'currency.id = order_payment_advice.currency_id', 'left');
		$array = array('order_payment_advice.order_id' => $order_id, 'order_payment_advice.status' => 'A');
		$this->db->where($array);
		$this->db->order_by('order_payment_advice.approved_datetime',"DESC");
		$query = $this->db->get();		
		return $query->result_array();		
	}
	
	public function getAdviceById($order_id,$advice_id){
		$this->db->select('*')
            ->from('order_payment_advice');
		$this->db->join('bank', 'bank.id = order_payment_advice.bank_id', 'left');
		$this->db->join('currency', 'currency.id = order_payment_advice.currency_id', 'left');
		$array = array('order_payment_advice.order_id' => $order_id, 'order_payment_advice.payment_advice_id' => $advice_id);
		$this->db->where($array);
		$query = $this->db->get();	
		return $query->row();		
	}
	
	public function getPendingChallanList($order_id){
		$this->db->select('*')
            ->from('order_products');
		#$this->db->join('order_products', 'order_products.order_id = challan_product.order_id', 'left');
		$array = array('order_products.order_id' => $order_id);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCompleteChallanList($order_id){
		$this->db->select('*, (SELECT qty FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as ord_qty, (SELECT description FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as description, (SELECT unit FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as unit, svi_challan_product.qty as challan_qty')
            ->from('challan_product');
		#$this->db->join('order_products', 'order_products.order_id = challan_product.order_id', 'left');		
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$array = array('challan.is_deleted' => 'N', 'challan_product.order_id' => $order_id);	
		$this->db->where($array);		
		#$array = array('challan_product.order_id' => $order_id);
		#$this->db->where($array);		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getOrderPendingProduct($limit, $start,$data) {		
	
		$this->db->select('*, SUM(qty) as order_qty, (SELECT SUM(qty) FROM svi_stock WHERE product_id = svi_order_products.prod_id and status = "A" GROUP BY product_id) as in_stock, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted AND cp.product_id = svi_order_products.prod_id GROUP BY cp.product_id) as out_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted AND cp.product_id = svi_order_products.prod_id GROUP BY cp.product_id) as return_qty, (SELECT SUM(qty) FROM svi_stock WHERE product_id = svi_order_products.prod_id and status = "P" GROUP BY product_id) as pending_stock')
            ->from('order_products');
			
		$array = array('challan_qty' => '0');
		$this->db->group_start();
		$this->db->where($array);
		$this->db->or_where('challan_qty < qty');
		$this->db->group_end();
		
		if(!empty($data['product_name'])){
			$this->db->group_start();
				$this->db->like('order_products.prod_name',trim($data['product_name']));
				$this->db->or_like('description',trim($data['product_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['model_name'])){
			$this->db->group_start();
				$this->db->like('order_products.model_name',trim($data['model_name']));
			$this->db->group_end();
		}
		
		$this->db->group_by('prod_id'); 

		$this->db->order_by('prod_name',"ASC");
		$this->db->limit( $limit, $start );		
		$query = $this->db->get();	
		return $query->result_array();
	}

	public function getTotalOrderPendingProduct($data) {		
		$this->db->select('*, SUM(qty) as order_qty, (SELECT SUM(qty) FROM svi_stock WHERE product_id = svi_order_products.prod_id and status = "A" GROUP BY product_id) as in_stock, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted AND cp.product_id = svi_order_products.prod_id GROUP BY cp.product_id) as out_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted AND cp.product_id = svi_order_products.prod_id GROUP BY cp.product_id) as return_qty, (SELECT SUM(qty) FROM svi_stock WHERE product_id = svi_order_products.prod_id and status = "P" GROUP BY product_id) as pending_stock')
            ->from('order_products');	
		
		$array = array('challan_qty' => '0');
		$this->db->group_start();
		$this->db->where($array);
		$this->db->or_where('challan_qty < qty');
		$this->db->group_end();
		
		if(!empty($data['product_name'])){
			$this->db->group_start();
				$this->db->like('order_products.prod_name',trim($data['product_name']));
				$this->db->or_like('description',trim($data['product_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['model_name'])){
			$this->db->group_start();
				$this->db->like('order_products.model_name',trim($data['model_name']));
			$this->db->group_end();
		}
		
		$this->db->group_by('prod_id');				
		$this->db->order_by('prod_name',"ASC");
		$query = $this->db->get();		
		return $query->num_rows();
	}

	public function getOrderPendingProductView($product_id) {		
		
		$this->db->select('*, (SELECT customer_name FROM svi_order_customer where order_id = svi_order_products.order_id) as customer_name')
            ->from('order_products');	
		
		$this->db->where('prod_id', $product_id);
		
		$array = array('challan_qty' => '0');
		$this->db->group_start();		
		$this->db->where($array);
		$this->db->or_where('challan_qty < qty');
		$this->db->group_end();		
		$this->db->order_by('date_added',"DESC");	
		$query = $this->db->get();		
		return $query->result_array();
	}

	public function getOrderPendingCustomer($limit,$start,$data) {		
		$qryArr = array();
		if(!empty($data['contact_email'])){
			$qryArr['contact_email']= trim($data['contact_email']);
		}
						
		if(!empty($data['currency_id'])){
			$qryArr['currency_id']= trim($data['currency_id']);
		}
				
		$this->db->select('*')
            ->from('order_customer');	
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		
		$this->db->where($qryArr);
		
		$array = array('status' => 'Y', 'challan_status' => 'P');				
		$this->db->where($array);

		if(!empty($data['customer_name'])){
			$this->db->group_start();
				$this->db->like('customer_name',trim($data['customer_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['contact_phone'])){
			$this->db->group_start();
				$this->db->like('contact_phone',trim($data['contact_phone']));
			$this->db->group_end();
		}
		
		$this->db->group_by('customer_id');
		$this->db->order_by('customer_name',"ASC");
		$this->db->limit( $limit, $start);		
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getTotalOrderPendingCustomer($data) {		
		$qryArr = array();
		if(!empty($data['contact_email'])){
			$qryArr['contact_email']= trim($data['contact_email']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['currency_id']= trim($data['currency_id']);
		}
				
		$this->db->select('*')
            ->from('order_customer');	
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		
		$this->db->where($qryArr);
		
		$array = array('status' => 'Y', 'challan_status' => 'P');				
		$this->db->where($array);

		if(!empty($data['customer_name'])){
			$this->db->group_start();
				$this->db->like('customer_name',trim($data['customer_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['contact_phone'])){
			$this->db->group_start();
				$this->db->like('contact_phone',trim($data['contact_phone']));
			$this->db->group_end();
		}
		
		$this->db->group_by('customer_id');
		$this->db->order_by('customer_name',"ASC");		
		$query = $this->db->get();		
		return $query->num_rows();
	}	
	
	public function getOrderPendingCustomerView($customer_id) {		
		
		$this->db->select('*, (SELECT SUM(qty) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as order_qty, (SELECT SUM(challan_qty) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as challan_qty ')
            ->from('order_customer');	
		
		$array = array('customer_id' => $customer_id, 'status' => 'Y', 'challan_status' => 'P');				
		$this->db->where($array);
		$this->db->order_by('date_added',"DESC");		
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	public function getChallanMissingFields($order_id) {		
		$this->db->select('*')
            ->from('challan');		
		$array = array('is_deleted' => 'N', 'order_id' => $order_id);				
		$this->db->where($array);				
		$query = $this->db->get();	
		return $query->result_array();
	}	
	
	public function getAdviceFile($advice_id) {		
		$this->db->select('*')
            ->from('order_payment_advice_file');		
		$array = array('payment_advice_id' => $advice_id);				
		$this->db->where($array);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function delAdviceFile($advice_file_id) {
		$this->db->where('advice_file_id', $advice_file_id);
		$this->db->delete('order_payment_advice_file');		
		return true;
	}
	
	public function getChallanQtybyOrderAndModel($condition) {
		$this->db->select('IFNULL(sum(cp.qty), 0) as total_challan_qty')
            ->from('challan_product cp');		
		#$array = array('payment_advice_id' => $advice_id);	
		$this->db->join('challan c', 'cp.challan_id = c.challan_id', 'left');			
		$this->db->where('cp.order_id',$condition['order_id']);
		$this->db->where('cp.product_id',$condition['product_id']);
		$this->db->where('c.is_deleted="N"');
		$query = $this->db->get();
		#print $this->db->last_query();exit;
		return $query->row();
	}
	
}