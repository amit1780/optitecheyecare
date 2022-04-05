<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Quotation_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function addCustomerToQuote($data,$customerInfo) {
		
		$quote_customer_data = array(
			'store_id'   				=> $data['store_id'],
			'customer_name'   			=> $customerInfo->company_name,
			'customer_id'   			=> $customerInfo->customer_id,
			'contact_person'   			=> $customerInfo->contact_person,
			'contact_email'   			=> $customerInfo->email,
			'contact_phone'   			=> $customerInfo->phone,
			'contact_fax' 				=> $customerInfo->fax,					
			'quotation_date' 			=> $data['quotation_date'],
			'user_id' 					=> $data['user_id'],
			'currency_id' 				=> $data['currency_id'],
			'bank_id' 					=> $data['bank_id'],
			'billing_details' 			=> $data['billing_details'],
			'shipping_details' 			=> $data['shipping_details'],
			'delivery' 					=> $data['delivery'],
			'insurance' 				=> $data['insurance'],
			'terms_conditions' 			=> $data['terms_conditions'],
			'payment_terms' 			=> $data['payment_terms'],
			'freight_charge' 			=> $data['freight_charge'],
			'discount_type' 			=> $data['discount_type'],
			'pan_no' 					=> $data['pan_no'],
			'gst' 						=> $data['gst'],
			'special_instruction' 		=> $data['special_instruction'],
			'is_sample' 				=> $data['is_sample'],			
			'created_by' 				=> $this->session->userdata('user_id'),			
			'valid_for' 				=> $data['valid_for'],			
			'created_time' 				=> date('Y-m-j H:i:s')		
		);

		$this->db->insert('quote_customer', $quote_customer_data);
		$quotation_id = $this->db->insert_id();
		return $quotation_id;					
	}
	
	public function addProductsToQuote($data,$discount,$total,$discountRate) {	
		
		$quote_product_data = array(
			'customer_id'   		=> $data->customer_id,
			'quotation_id'   		=> $data->quotation_id,
			'prod_id'   			=> $data->product_id,
			'prod_name'   			=> $data->product_name,
			'model_name'   			=> $data->model,
			'description'   		=> $data->description,
			'hsn' 					=> $data->hsn,
			'qty' 					=> $data->qty,
			'unit' 					=> $data->unit,
			'mrp' 					=> $data->mrp,
			'rate' 					=> $data->price,
			'ltp' 					=> $data->ltp,
			'discount' 				=> $discount,
			'discount_per' 			=> $discountRate,
			'net_amount' 			=> $total,	
			'product_gst' 			=> $data->gst,				
			'date_added'			=> date('Y-m-j H:i:s')
		);	
		$this->db->insert('quote_products', $quote_product_data);
	}
	
	public function editCustomerToQuote($data,$quotation_id,$customerInfo) {
		
		$quote_customer_data = array(
			'store_id'   				=> $data['store_id'],
			'customer_name'   			=> $customerInfo->company_name,
			'customer_id'   			=> $customerInfo->customer_id,
			'contact_person'   			=> $customerInfo->contact_person,
			'contact_email'   			=> $customerInfo->email,
			'contact_phone'   			=> $customerInfo->phone,
			'contact_fax' 				=> $customerInfo->fax,					
			'quotation_date' 			=> $data['quotation_date'],
			'user_id' 					=> $data['user_id'],
			'currency_id' 				=> $data['currency_id'],
			'bank_id' 					=> $data['bank_id'],
			'billing_details' 			=> $data['billing_details'],
			'shipping_details' 			=> $data['shipping_details'],
			'delivery' 					=> $data['delivery'],
			'insurance' 				=> $data['insurance'],
			'terms_conditions' 			=> $data['terms_conditions'],
			'payment_terms' 			=> $data['payment_terms'],
			'freight_charge' 			=> $data['freight_charge'],
			'discount_type' 			=> $data['discount_type'],
			'pan_no' 					=> $data['pan_no'],
			'gst' 						=> $data['gst'],
			'special_instruction' 		=> $data['special_instruction'],
			'is_sample' 				=> $data['is_sample'],	
			'valid_for' 				=> $data['valid_for'],
			'created_by' 				=> $this->session->userdata('user_id')	
		);
		
		
		

		$this->db->where('id', $quotation_id);
		$this->db->update('quote_customer', $quote_customer_data);
		
		return true; 
		
	}
	
	public function deleteProductsToQuote($quotation_id) {
		$this->db->where('quotation_id', $quotation_id);
		$this->db->delete('quote_products');
		return true;
	}
	
	public function editProductsToQuote($data,$discount,$total,$discountRate) {		
		$quote_product_data = array(
			'customer_id'   		=> $data->customer_id,
			'quotation_id'   		=> $data->quotation_id,
			'prod_id'   			=> $data->product_id,
			'prod_name'   			=> $data->product_name,
			'model_name'   			=> $data->model,
			'description'   		=> $data->description,
			'hsn' 					=> $data->hsn,
			'qty' 					=> $data->qty,
			'unit' 					=> $data->unit,
			'mrp' 					=> $data->mrp,
			'rate' 					=> $data->price,
			'ltp' 					=> $data->ltp,
			'discount' 				=> $discount,
			'discount_per' 			=> $discountRate,
			'net_amount' 			=> $total,
			'product_gst' 			=> $data->gst,				
			'date_added'			=> date('Y-m-j H:i:s')
		);		
		$this->db->insert('quote_products', $quote_product_data);
	}

	public function getBatchByData($data) {
		
		$qryArr=Array();
		
		if(!empty($data['batch_no'])){
			$qryArr['batch_no']=$data['batch_no'];
		}
		if(!empty($data['batch_id'])){
			$qryArr['batch_id']=$data['batch_id'];
		}

		$this->db->select('*');
		$this->db->from('batch');
		$this->db->where($qryArr);
		
		return $this->db->get()->result_array();		
	}
	
	
	public function getQuoteCustomerList($limit, $start,$data) {
		$qryArr=Array();
		 
		if(!empty($data['quote_id'])){
			$qryArr['quote_customer.id']= trim($data['quote_id']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['quote_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['customerid'])){
			$qryArr['quote_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_phone'])){
			$qryArr['quote_customer.contact_phone']= trim($data['contact_phone']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['quote_customer.contact_email']= trim($data['contact_email']);
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
		
		if(!empty($data['user_id'])){
			$qryArr['quote_customer.created_by']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['quote_customer.store_id']=$data['store_id'];
		}
		
		if(!empty($data['is_deleted'])){
			$qryArr['quote_customer.is_deleted']=$data['is_deleted'];
		}
		
		$qryArr['order_id']= null;
		
		if(!empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->where('prod_id',$data['model']);					
			$query3 = $this->db->get();
			$quotationIdPmodel = $query3->result_array();			
			$quotationIdPmodel = array_column($quotationIdPmodel, 'quotation_id');
			if(empty($quotationIdPmodel)){
				$quotationIdPmodel = 'null';
			}
		}
		
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->group_start();
				$this->db->like('quote_products.prod_name',trim($data['product_name']));
				$this->db->or_like('quote_products.description',trim($data['product_name']));	
			$this->db->group_end();	
			$query3 = $this->db->get();
			$quotationIdPname = $query3->result_array();			
			$quotationIdPname = array_column($quotationIdPname, 'quotation_id');
			if(empty($quotationIdPname)){
				$quotationIdPname = 'null';
			}
		}
		
	/* 	if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quote_products.quotation_id as quotation_id');
			$this->db->from('category');
			$this->db->join('product', 'product.category_id = category.category_id', 'left');
			$this->db->join('quote_products', 'quote_products.prod_id = product.product_id', 'left');
			$this->db->where('category.name',$data['product_name']);
			$query4 = $this->db->get();
			//echo $this->db->last_query();exit;
			$quotationIds1 = $query4->result_array();			
			$quotationIds1 = array_column($quotationIds1, 'quotation_id');
			if(empty($quotationIds1)){
				$quotationIds1 = 'null';
			}
		} */
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_quote_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_quote_customer.store_id) as store_name')
            ->from('quote_customer');
			
		$this->db->join('customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		$this->db->where($qryArr);
		
		if(!empty($data['model'])){			
			$this->db->where_in('id',$quotationIdPmodel);			
		}
		
		if(!empty($data['product_name'])){		
			$this->db->where_in('id',$quotationIdPname);			
		}
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("quote_customer.created_time >=", $start_date);
				$this->db->where("quote_customer.created_time <=", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('quote_customer.created_time',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('quote_customer.created_time',$end_date);
			$this->db->group_end();
		}
		
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('quote_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('quote_customer.contact_person',trim($data['company_name']));
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
			$this->db->order_by('quote_customer.order_id',"ASC");
			$this->db->order_by('quote_customer.id',"DESC");
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalQuotation($data) {
		$qryArr=Array();
		 
		if(!empty($data['quote_id'])){
			$qryArr['quote_customer.id']= trim($data['quote_id']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['quote_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['customerid'])){
			$qryArr['quote_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_phone'])){
			$qryArr['quote_customer.contact_phone']= trim($data['contact_phone']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['quote_customer.contact_email']= trim($data['contact_email']);
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
		
		if(!empty($data['user_id'])){
			$qryArr['quote_customer.created_by']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['quote_customer.store_id']=$data['store_id'];
		}
		
		if(!empty($data['is_deleted'])){
			$qryArr['quote_customer.is_deleted']=$data['is_deleted'];
		}
		
		$qryArr['order_id']= null;
		
		if(!empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->where('prod_id',$data['model']);					
			$query3 = $this->db->get();
			$quotationIdPmodel = $query3->result_array();			
			$quotationIdPmodel = array_column($quotationIdPmodel, 'quotation_id');
			if(empty($quotationIdPmodel)){
				$quotationIdPmodel = 'null';
			}
		}
		
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->group_start();
				$this->db->like('quote_products.prod_name',trim($data['product_name']));
				$this->db->or_like('quote_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$quotationIdPname = $query3->result_array();			
			$quotationIdPname = array_column($quotationIdPname, 'quotation_id');
			if(empty($quotationIdPname)){
				$quotationIdPname = 'null';
			}
		}
		
		/* if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quote_products.quotation_id as quotation_id');
			$this->db->from('category');
			$this->db->join('product', 'product.category_id = category.category_id', 'left');
			$this->db->join('quote_products', 'quote_products.prod_id = product.product_id', 'left');
			$this->db->where('category.name',$data['product_name']);
			$query4 = $this->db->get();
			//echo $this->db->last_query();exit;
			$quotationIds1 = $query4->result_array();			
			$quotationIds1 = array_column($quotationIds1, 'quotation_id');
			if(empty($quotationIds1)){
				$quotationIds1 = 'null';
			}
		} */
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_quote_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_quote_customer.store_id) as store_name')
            ->from('quote_customer');
			
		$this->db->join('customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		$this->db->where($qryArr);
		
		if(!empty($data['model'])){			
			$this->db->where_in('id',$quotationIdPmodel);			
		}
		
		if(!empty($data['product_name'])){		
			$this->db->where_in('id',$quotationIdPname);			
		}
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("quote_customer.created_time >=", $start_date);
				$this->db->where("quote_customer.created_time <=", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('quote_customer.created_time',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('quote_customer.created_time',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('quote_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('quote_customer.contact_person',trim($data['company_name']));
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
			$this->db->order_by('quote_customer.order_id',"ASC");
			$this->db->order_by('quote_customer.id',"DESC");
		}
		
		$query = $this->db->get();
			
		return $query->num_rows();
	}
	
	public function getCompleteQuoteCustomerList($limit, $start,$data) {
		$qryArr=Array();
		 
		if(!empty($data['quote_id'])){
			$qryArr['quote_customer.id']= trim($data['quote_id']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['quote_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['customerid'])){
			$qryArr['quote_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_phone'])){
			$qryArr['quote_customer.contact_phone']= trim($data['contact_phone']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['quote_customer.contact_email']= trim($data['contact_email']);
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
		
		if(!empty($data['user_id'])){
			$qryArr['quote_customer.created_by']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['quote_customer.store_id']=$data['store_id'];
		}
		
		if(!empty($data['order_id'])){
			$qryArr['quote_customer.order_id']= trim($data['order_id']);
		}
		
		if(!empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->where('prod_id',$data['model']);						
			$query3 = $this->db->get();
			$quotationIdPmodel = $query3->result_array();			
			$quotationIdPmodel = array_column($quotationIdPmodel, 'quotation_id');
			if(empty($quotationIdPmodel)){
				$quotationIdPmodel = 'null';
			}
		}
		
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->group_start();
				$this->db->like('quote_products.prod_name',trim($data['product_name']));
				$this->db->or_like('quote_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$quotationIdPname = $query3->result_array();			
			$quotationIdPname = array_column($quotationIdPname, 'quotation_id');
			if(empty($quotationIdPname)){
				$quotationIdPname = 'null';
			}
		}
		
		/* if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quote_products.quotation_id as quotation_id');
			$this->db->from('category');
			$this->db->join('product', 'product.category_id = category.category_id', 'left');
			$this->db->join('quote_products', 'quote_products.prod_id = product.product_id', 'left');
			$this->db->where('category.name',$data['product_name']);
			$query4 = $this->db->get();
			//echo $this->db->last_query();exit;
			$quotationIds1 = $query4->result_array();			
			$quotationIds1 = array_column($quotationIds1, 'quotation_id');
			if(empty($quotationIds1)){
				$quotationIds1 = 'null';
			}
		} */
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_quote_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_quote_customer.store_id) as store_name')
            ->from('quote_customer');
			
		$this->db->join('customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		if(!empty($data['model'])){			
			$this->db->where_in('id',$quotationIdPmodel);			
		}
		
		if(!empty($data['product_name'])){		
			$this->db->where_in('id',$quotationIdPname);			
		}
		
		$this->db->where($qryArr);
		$this->db->where('quote_customer.order_id >', '0');
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("quote_customer.created_time >", $start_date);
				$this->db->where("quote_customer.created_time <", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('quote_customer.created_time',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('quote_customer.created_time',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('quote_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('quote_customer.contact_person',trim($data['company_name']));
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
			$this->db->order_by('quote_customer.order_id',"ASC");
			$this->db->order_by('quote_customer.id',"DESC");
		}	
		
		$query = $this->db->get();
			
		return $query->result_array();
	}
	
	public function getTotalCompleteQuotation($data) {
		$qryArr=Array();
		 
		if(!empty($data['quote_id'])){
			$qryArr['quote_customer.id']= trim($data['quote_id']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['quote_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['customerid'])){
			$qryArr['quote_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_phone'])){
			$qryArr['quote_customer.contact_phone']= trim($data['contact_phone']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['quote_customer.contact_email']= trim($data['contact_email']);
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
		
		if(!empty($data['user_id'])){
			$qryArr['quote_customer.created_by']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['quote_customer.store_id']=$data['store_id'];
		}
		
		if(!empty($data['order_id'])){
			$qryArr['quote_customer.order_id']= trim($data['order_id']);
		}
		
		if(!empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->where('prod_id',$data['model']);						
			$query3 = $this->db->get();
			$quotationIdPmodel = $query3->result_array();			
			$quotationIdPmodel = array_column($quotationIdPmodel, 'quotation_id');
			if(empty($quotationIdPmodel)){
				$quotationIdPmodel = 'null';
			}
		}
		
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quotation_id');
			$this->db->from('quote_products');
			$this->db->group_start();
				$this->db->like('quote_products.prod_name',trim($data['product_name']));
				$this->db->or_like('quote_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$quotationIdPname = $query3->result_array();			
			$quotationIdPname = array_column($quotationIdPname, 'quotation_id');
			if(empty($quotationIdPname)){
				$quotationIdPname = 'null';
			}
		}
		
		/* if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('quote_products.quotation_id as quotation_id');
			$this->db->from('category');
			$this->db->join('product', 'product.category_id = category.category_id', 'left');
			$this->db->join('quote_products', 'quote_products.prod_id = product.product_id', 'left');
			$this->db->where('category.name',$data['product_name']);
			$query4 = $this->db->get();
			//echo $this->db->last_query();exit;
			$quotationIds1 = $query4->result_array();			
			$quotationIds1 = array_column($quotationIds1, 'quotation_id');
			if(empty($quotationIds1)){
				$quotationIds1 = 'null';
			}
		} */
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_quote_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_quote_customer.store_id) as store_name')
            ->from('quote_customer');
			
		$this->db->join('customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		if(!empty($data['model'])){			
			$this->db->where_in('id',$quotationIdPmodel);			
		}
		
		if(!empty($data['product_name'])){		
			$this->db->where_in('id',$quotationIdPname);			
		}
		
		$this->db->where($qryArr);
		$this->db->where('quote_customer.order_id >', '0');
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("quote_customer.created_time >", $start_date);
				$this->db->where("quote_customer.created_time <", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('quote_customer.created_time',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('quote_customer.created_time',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('quote_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('quote_customer.contact_person',trim($data['company_name']));
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
			$this->db->order_by('quote_customer.order_id',"ASC");
			$this->db->order_by('quote_customer.id',"DESC");
		}	
		
		$query = $this->db->get();
			
		return $query->num_rows();
	}
	
	
	public function getBatchList() {
		
		$this->db->select('*')
            ->from('batch');
		$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getBanks() {
		
		$qryArr=Array();
		
		$qryArr['status']='1';
		$this->db->select('*');
		$this->db->from('bank');
		$this->db->where($qryArr);
		$this->db->order_by('bank_name',"ASC");
		return $this->db->get()->result_array();		
	}

	public function getUsers() {
		
		$qryArr=Array();		
		//$qryArr['username'] != 'developer';
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username !=', 'developer');
		$this->db->order_by('firstname',"ASC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCurrencies() {
		
		$qryArr=Array();
		
		
		$this->db->select('*');
		$this->db->from('currency');
		
		return $this->db->get()->result_array();		
	}
	
	public function getStore(){
	    $this->db->select('*')
            ->from('store');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getLastQuotationId(){
			$this->db->select('*');
			$this->db->from('quote_customer');
			$this->db->limit(1);
			$this->db->order_by('id',"DESC");
			$query = $this->db->get();
			$result = $query->row();
			$last_id =$result->id +1;
		return	$last_id;
	}
	
	public function getQuotationCustomerById($quotation_id){
		
		$this->db->select('*, quote_customer.id as quote_id');
		$this->db->from('quote_customer');
		$this->db->join('store', 'store.store_id = quote_customer.store_id', 'left');
		$this->db->join('currency', 'currency.id = quote_customer.currency_id', 'left');
		$this->db->join('user', 'user.user_id = quote_customer.user_id', 'left');
		$this->db->where('quote_customer.id', $quotation_id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getQuotationByCustomerIdCurrentDate($customer_id){
		$currentDate = date('Y-m-j')." 00:00:00";
		$this->db->select('*');
		$this->db->from('quote_customer');
		$arry = array('customer_id' => $customer_id, 'created_time >' => $currentDate);
		$this->db->where($arry);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getQuotationProductById($quotation_id){
		
		$this->db->select('*');
		$this->db->from('quote_products');
		$this->db->where('quotation_id', $quotation_id);
		$this->db->order_by('product_gst',"ASC");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getProductIfuById($product_id) {
		
		$this->db->select('photo')
            ->from('product');
		$this->db->where('product.product_id', $product_id);	
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getBankById($bank_id) {
		
		$this->db->select('*');
		$this->db->from('bank');
		$this->db->where('id', $bank_id);
		$query = $this->db->get();
		return $query->row();		
	}
	
	public function getQuotationProductGroupGst($quotation_id) {		
		$this->db->select('product_gst,SUM(net_amount) AS net_amount');
		$this->db->from('quote_products');
		$this->db->where('quotation_id', $quotation_id);
		$this->db->where('product_gst != ',0,FALSE);
		$this->db->group_by('product_gst');
		$query = $this->db->get();
		return $query->result_array();		
	}
	
	public function deleteQuotationById($data) {
		$deldata=array(			
				'is_deleted' 			=> 'Y',			
				'deleted_user_id' 		=> $_SESSION['user_id'],			
				'deleted_date' 			=> date('Y-m-d H:i:s'),			
				'deleted_reason' 		=> $data['deleted_reason']		
		);		
		$this->db->where('id', $data['delquotation_id']);		
		$this->db->update('quote_customer', $deldata);				
		return true;
	} 
	
	public function getDeleteReason($data) {	
		$this->db->select('*, (SELECT firstname FROM svi_user WHERE user_id = svi_quote_customer.deleted_user_id) as firstname, (SELECT lastname FROM svi_user WHERE user_id = svi_quote_customer.deleted_user_id) as lastname');
		$this->db->from('quote_customer');	
		$array = array('is_deleted' => 'Y', 'id' => $data['id']);
		$this->db->where($array);		
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->row();
	} 
	
}