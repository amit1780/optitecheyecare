<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Search_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function getTotalCustomers($data) {		
		$qryArr=Array();
		
		if(!empty($data['customerid'])){
			$qryArr['customer_id']=$data['customerid'];
		}

		if(!empty($data['country_id'])){
			$qryArr['customer.country_id']=$data['country_id'];
		}
		
		if(!empty($data['state_id'])){
			$qryArr['customer.state_id']=$data['state_id'];
		}
		
	
		if(!empty($data['email'])){
			$qryArr['customer.email']=$data['email'];
		}
		
		if(!empty($data['pin_code'])){
			$qryArr['customer.pin']=$data['pin_code'];
		}	

		
		$this->db->select('*, country.name as country_name, state.name as state_name')
			->from('customer');		
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->where($qryArr);
		
		if(!empty($data['mobile'])){
			$this->db->group_start();
			$this->db->where('mobile', $data['mobile']);
			$this->db->or_where('phone', $data['mobile']);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('company_name', trim($data['company_name']));
				//$this->db->or_like('person_title', trim($data['company_name']));
				$this->db->or_like('contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('city', trim($data['city']));
				$this->db->or_like('district',trim($data['city']));
			$this->db->group_end();
		}
		
		
		$this->db->order_by('customer_id', 'DESC');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getCustomers($limit, $start,$data) {		
		$qryArr=Array();
		
		if(!empty($data['customerid'])){
			$qryArr['customer_id']=$data['customerid'];
		}

		if(!empty($data['country_id'])){
			$qryArr['customer.country_id']=$data['country_id'];
		}
		
		if(!empty($data['state_id'])){
			$qryArr['customer.state_id']=$data['state_id'];
		}
		
	
		if(!empty($data['email'])){
			$qryArr['customer.email']=$data['email'];
		}
		
		if(!empty($data['pin_code'])){
			$qryArr['customer.pin']=$data['pin_code'];
		}	

		
		$this->db->select('*, country.name as country_name, state.name as state_name')
			->from('customer');		
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->where($qryArr);
		
		if(!empty($data['mobile'])){
			$this->db->group_start();
			$this->db->where('mobile', $data['mobile']);
			$this->db->or_where('phone', $data['mobile']);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('company_name', trim($data['company_name']));
				//$this->db->or_like('person_title', trim($data['company_name']));
				$this->db->or_like('contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('city', trim($data['city']));
				$this->db->or_like('district',trim($data['city']));
			$this->db->group_end();
		}
		
		$this->db->limit( $limit, $start );	
		
		$this->db->order_by('customer_id', 'DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalQuotations($data) {
		$qryArr=Array();
		 
		if(!empty($data['quote_id'])){
			$qryArr['id']= trim(financialQuoteId($data['quote_id'],$data['fyear']));
		}
		
		if(!empty($data['order_id'])){
			$qryArr['order_id']= trim(financialOrderId($data['order_id'],$data['foyear']));
		}
		
		
		if($data['basedOn'] == 'Pending'){
			$qryArr['order_id']= null;			
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['quote_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['customerid'])){
			$qryArr['customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['mobile'])){
			$qryArr['contact_phone']= trim($data['mobile']);
		}
		
		if(!empty($data['email'])){
			$qryArr['contact_email']= trim($data['email']);
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
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_quote_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_quote_customer.store_id) as store_name')
            ->from('quote_customer');
			
		$this->db->join('customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');		
		
		$this->db->where($qryArr);
		
				
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
		
		$this->db->order_by('order_id',"ASC");
		$this->db->order_by('id',"DESC");	
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getQuotations($limit, $start,$data) {
		$qryArr=Array();
		 
		if(!empty($data['quote_id'])){
			$qryArr['id']= trim(financialQuoteId($data['quote_id'],$data['fqyear']));
		}
		
		if(!empty($data['order_id'])){
			$qryArr['order_id']= trim(financialOrderId($data['order_id'],$data['foyear']));
		}		
		
		if($data['basedOn'] == 'Pending'){
			$qryArr['order_id']= null;			
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['quote_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['customerid'])){
			$qryArr['customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['mobile'])){
			$qryArr['contact_phone']= trim($data['mobile']);
		}
		
		if(!empty($data['email'])){
			$qryArr['contact_email']= trim($data['email']);
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
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_quote_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_quote_customer.store_id) as store_name')
            ->from('quote_customer');
			
		$this->db->join('customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');		
		
		$this->db->where($qryArr);
		
				
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
		
		$this->db->order_by('order_id',"ASC");
		$this->db->order_by('id',"DESC");	
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalOrders($data) {
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
		
		if(!empty($data['email'])){
			$qryArr['order_customer.contact_email']= trim($data['email']);
		}
		
		if(!empty($data['mobile'])){
			$qryArr['order_customer.contact_phone']= trim($data['mobile']);
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
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, svi_order_customer.date_added as ord_date_added, (SELECT store_name FROM svi_store WHERE store_id = svi_order_customer.store_id) as store_name')
            ->from('order_customer');
			
		$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
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
		}else if(!empty($data['end_date'])){
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
		
		$this->db->order_by('challan_status',"DESC");
		$this->db->order_by('order_customer.date_added',"DESC");
		$query = $this->db->get();		
		return $query->num_rows();
	}
	
	public function getOrders($limit, $start,$data) {
		$qryArr=Array();
		 
		if(!empty($data['order_id'])){
			$qryArr['order_id']= trim(financialOrderId($data['order_id'],$data['foyear']));
		}
		
		if(!empty($data['quote_id'])){
			$qryArr['quotation_id']= trim(financialQuoteId($data['quote_id'],$data['fyear']));
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
		
		if(!empty($data['email'])){
			$qryArr['order_customer.contact_email']= trim($data['email']);
		}
		
		if(!empty($data['mobile'])){
			$qryArr['order_customer.contact_phone']= trim($data['mobile']);
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
		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, svi_order_customer.date_added as ord_date_added, (SELECT store_name FROM svi_store WHERE store_id = svi_order_customer.store_id) as store_name')
            ->from('order_customer');
			
		$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
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
		}else if(!empty($data['end_date'])){
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
		
		$this->db->order_by('challan_status',"DESC");
		$this->db->order_by('order_customer.date_added',"DESC");
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getTotalChallans($data){
		$qryArr=Array();
		 
				
		if(!empty($data['challan_id'])){
			$qryArr['challan.challan_id']= trim(financialChallanId($data['challan_id'],$data['fcyear']));
		}
		
		if(!empty($data['order_id'])){
			$qryArr['challan.order_id']= trim(financialChallanId($data['order_id'],$data['foyear']));
		}
		
		if(!empty($data['docket_no'])){
			$qryArr['challan.docket_no']= trim($data['docket_no']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['order_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['user_id'])){
			$qryArr['challan.user_id']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['challan.store_id']=$data['store_id'];
		}
		
		if(!empty($data['customerid'])){
			$qryArr['challan.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['email'])){
			$qryArr['order_customer.contact_email']= trim($data['email']);
		}
		
		if(!empty($data['mobile'])){
			$qryArr['order_customer.contact_phone']= trim($data['mobile']);
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
		
	    $this->db->select('*,country.name as country_name, state.name as state_name, (SELECT SUM(net_total) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_challan.store_id) as store_name')
            ->from('challan');
			
		$this->db->join('customer', 'customer.customer_id = challan.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->join('order_customer', 'order_customer.order_id = challan.order_id', 'left');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where($qryArr);
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("challan.date_added >", $start_date);
				$this->db->where("challan.date_added <", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('challan.date_added',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('challan.date_added',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();				
				$this->db->like('order_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('order_customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['invoice_no'])){
			$this->db->group_start();
				$this->db->like('challan.invoice_no',trim($data['invoice_no']));
			$this->db->group_end();
		}
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('customer.city', trim($data['city']));
				$this->db->or_like('customer.district',trim($data['city']));
			$this->db->group_end();
		}
		
		$this->db->order_by('challan.challan_id',"DESC");
		
		$query = $this->db->get();	
		return $query->num_rows();
	}
	
	public function getChallans($limit, $start,$data){
		$qryArr=Array();
		 
		if(!empty($data['challan_id'])){
			$qryArr['challan.challan_id']= trim(financialChallanId($data['challan_id'],$data['fcyear']));
		}
		
		if(!empty($data['order_id'])){
			$qryArr['challan.order_id']= trim(financialChallanId($data['order_id'],$data['foyear']));
		}
		
		if(!empty($data['docket_no'])){
			$qryArr['challan.docket_no']= trim($data['docket_no']);
		}
		
		if(!empty($data['currency_id'])){
			$qryArr['order_customer.currency_id']= trim($data['currency_id']);
		}
		
		if(!empty($data['user_id'])){
			$qryArr['challan.user_id']=$data['user_id'];
		}
		
		if(!empty($data['store_id'])){
			$qryArr['challan.store_id']=$data['store_id'];
		}
		
		if(!empty($data['customerid'])){
			$qryArr['challan.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['email'])){
			$qryArr['order_customer.contact_email']= trim($data['email']);
		}
		
		if(!empty($data['mobile'])){
			$qryArr['order_customer.contact_phone']= trim($data['mobile']);
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
		
	    $this->db->select('*,country.name as country_name, state.name as state_name, (SELECT SUM(net_total) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_challan.store_id) as store_name')
            ->from('challan');
			
		$this->db->join('customer', 'customer.customer_id = challan.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->join('order_customer', 'order_customer.order_id = challan.order_id', 'left');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where($qryArr);
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("challan.date_added >", $start_date);
				$this->db->where("challan.date_added <", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('challan.date_added',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('challan.date_added',$end_date);
			$this->db->group_end();
		}
		
		if(!empty($data['company_name'])){
			$this->db->group_start();				
				$this->db->like('order_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('order_customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['invoice_no'])){
			$this->db->group_start();
				$this->db->like('challan.invoice_no',trim($data['invoice_no']));
			$this->db->group_end();
		}
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('customer.city', trim($data['city']));
				$this->db->or_like('customer.district',trim($data['city']));
			$this->db->group_end();
		}
		
		$this->db->limit( $limit, $start );	
		
		$this->db->order_by('challan.challan_id',"DESC");
		
		$query = $this->db->get();	
		
		return $query->result_array();
	}
	
	public function getOrderPendingProduct($data) {		
	
		$this->db->select('*, SUM(qty) as order_qty, SUM(challan_qty) as challan_qty, (SELECT SUM(qty) FROM svi_stock WHERE product_id = svi_order_products.prod_id and status = "A" GROUP BY product_id) as in_stock, (SELECT SUM(qty) FROM svi_challan_product WHERE product_id = svi_order_products.prod_id GROUP BY product_id) as out_qty, (SELECT SUM(return_qty) FROM svi_challan_product WHERE product_id = svi_order_products.prod_id GROUP BY product_id) as return_qty, (SELECT SUM(qty) FROM svi_stock WHERE product_id = svi_order_products.prod_id and status = "P" GROUP BY product_id) as pending_stock')
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
		return $query->result_array();
	}
	
	public function getOrderPendingCustomer($data) {		
		$qryArr = array();
		
		if(!empty($data['customerid'])){
			$qryArr['order_customer.customer_id']= trim($data['customerid']);
		}
		
		if(!empty($data['contact_email'])){
			$qryArr['order_customer.contact_email']= trim($data['contact_email']);
		}
						
		if(!empty($data['currency_id'])){
			$qryArr['order_customer.currency_id']= trim($data['currency_id']);
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
				
		$this->db->select('*, country.name as country_name, state.name as state_name')
            ->from('order_customer');
			
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		
		$this->db->where($qryArr);
		
		$array = array('order_customer.status' => 'Y', 'order_customer.challan_status' => 'P');				
		$this->db->where($array);

		if(!empty($data['company_name'])){
			$this->db->group_start();
				$this->db->like('order_customer.customer_name',trim($data['company_name']));
				$this->db->or_like('order_customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['contact_phone'])){
			$this->db->group_start();
				$this->db->like('order_customer.contact_phone',trim($data['contact_phone']));
			$this->db->group_end();
		}
		
		
		if(!empty($data['city'])){
			$this->db->group_start();
				$this->db->like('customer.city', trim($data['city']));
				$this->db->or_like('customer.district',trim($data['city']));
			$this->db->group_end();
		}
		
		
		$this->db->group_by('order_customer.customer_id');
		$this->db->order_by('order_customer.customer_name',"ASC");			
		$query = $this->db->get();
		return $query->result_array();
	}
	
}