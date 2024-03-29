<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Customer_model extends CI_Model {

	
	public function __construct() {		
		parent::__construct();
		$this->load->database();		
	}
	
	public function addCustomer($data) {	
		$address_1 = str_replace( ',', '', $data['address_1'] );
		$address_2 = str_replace( ',', '', $data['address_2'] );
		
				
		$customer_data = array(
			'user_id'   			=> $_SESSION['user_id'],
			'company_name'   		=> ucwords(strtolower(trim($data['company_name']))),
			'person_title'			=> $data['person_title'],
			'contact_person'		=> ucwords(strtolower(trim($data['contact_person']))),
			'email'   				=> trim($data['email']),
			'mobile'				=> trim($data['mobile']),
			'phone'					=> trim($data['phone']),
			'fax'   				=> trim($data['fax']),
			//'uid'   				=> $data['uid'],
			'address_1'   			=> ucwords(strtolower($address_1)),
			'address_2'   			=> ucwords(strtolower($address_2)),
			'country_id'   			=> $data['country_id'],
			'state_id'   			=> $data['state_id'],
			'district'   			=> ucwords(strtolower($data['district'])),
			'city'   				=> ucwords(strtolower($data['city'])),
			'pin'   				=> trim($data['pin']),
			'company_registration_no'   	=> $data['company_registration_no'],
			'gst'   				=> trim($data['gst']),
			'pan'   				=> trim($data['pan']),
			'ie_code'   			=> trim($data['ie_code']),
			'drug_licence_no'   	=> trim($data['drug_licence_no']),
			'ref_id'   				=> ($data['ref_id']),
			'sli_id'   				=> $data['sli_id'],
			'account_number'   		=> $data['account_number'],
			'date_added' 			=> date('Y-m-j H:i:s')
		);		
		$this->db->insert('customer', $customer_data);
		$customer_id = $this->db->insert_id();
		if($data['ref_id'] == ''){
			$ref_data = array(
				'ref_id'   				=> $customer_id
			);			
			$this->db->where('customer_id', $customer_id);
			$this->db->update('customer', $ref_data);
		}			
		return true;		
	}
	
	public function editCustomer($data) {
		
		$address_1 = str_replace( ',', '', $data['address_1'] );
		$address_2 = str_replace( ',', '', $data['address_2'] );
		$customerData=$this->db->get_where('customer', array('customer_id' => $data['customer_id']))->row();

		$customer_data = array(
			'company_name'   				=> ucwords(strtolower(trim($data['company_name']))),
			'person_title'					=> $data['person_title'],
			'contact_person'				=> ucwords(strtolower(trim($data['contact_person']))),
			'email'   						=> trim($data['email']),
			'mobile'						=> trim($data['mobile']),
			'phone'							=> trim($data['phone']),
			'fax'   						=> trim($data['fax']),
			//'uid'   						=> $data['uid'],
			'address_1'   					=> ucwords(strtolower(trim($address_1))),
			'address_2'   					=> ucwords(strtolower(trim($address_2))),
			'country_id'   					=> $data['country_id'],
			'state_id'   					=> $data['state_id'],
			'district'   					=> ucwords(strtolower(trim($data['district']))),
			'city'   						=> ucwords(strtolower(trim($data['city']))),
			'pin'   						=> trim($data['pin']),
			'company_registration_no'   	=> trim($data['company_registration_no']),
			'gst'   						=> trim($data['gst']),
			'pan'   						=> trim($data['pan']),
			'ie_code'   					=> trim($data['ie_code']),
			'drug_licence_no'   			=> trim($data['drug_licence_no']),
			//'ref_id'   						=> $data['customer_id'],
			'sli_id'   						=> $data['sli_id'],
			'account_number'   				=> $data['account_number'],
			'modifi_user_id' 				=> $_SESSION['user_id'],
			'date_modified' 				=> date('Y-m-j H:i:s')
		);	

		if($customerData->mobile !=trim($data['mobile'])){
			$customer_data['wa_status']='P';
		}elseif($customerData->country_id !=$data['country_id']){
			$customer_data['wa_status']='P';
		}
			
		$this->db->where('customer_id', $data['customer_id']);
		$this->db->update('customer', $customer_data);		
		return true;		
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

		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(amount) FROM `svi_customer_payment` WHERE customer_id=svi_customer.customer_id) as customer_amount')
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
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('company_name', 'ASC');
			$this->db->order_by('contact_person', 'ASC');
		}
		
		$query = $this->db->get();
		
		return $query->result_array();
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

		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(amount) FROM `svi_customer_payment` WHERE customer_id=svi_customer.customer_id) as customer_amount')
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
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('company_name', 'ASC');
			$this->db->order_by('contact_person', 'ASC');
		}
		
		$query = $this->db->get();		 	
		return $query->num_rows();
	}

	public function getCustomersDownload($data) {
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
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT SUM(amount) FROM `svi_customer_payment` WHERE customer_id=svi_customer.customer_id) as customer_amount')
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
		
		#$this->db->limit( $limit, $start );		
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('company_name', 'ASC');
			$this->db->order_by('contact_person', 'ASC');
		}		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getCustomerById($customer_id) {		
		$this->db->select('*, (SELECT sli_name FROM svi_sli WHERE sli_id = svi_customer.sli_id) as sli_name, (SELECT code FROM svi_country WHERE country_id = svi_customer.country_id) as code')
            ->from('customer');
		$this->db->where('customer_id', $customer_id);	
		$query = $this->db->get();
		return $query->row();
	}
	
	/*AMIT*/
	public function getCustomerName($name){
		
		$this->db->select('*')
            ->from('customer');
			
			$this->db->group_start();
			$this->db->like('contact_person', trim($name));
			$this->db->or_like('company_name',trim($name));
			$this->db->group_end();
			//$this->db->order_by('contact_person asc, company_name asc');
			//$this->db->order_by('company_name', 'ASC');
			$this->db->order_by('contact_person ASC');
			//$this->db->limit( 10, 0);
			//$this->db->group_by('company_name'); 
			$query = $this->db->get();
			
		return $query->result_array();
	}
	/*AMIT*/
	
	public function getCountry() {
		
		$this->db->select('*')
            ->from('country');
			$this->db->order_by('name', 'ASC');
			$query = $this->db->get();
			
		return $query->result_array();
	}
	
	public function getTitle() {		
		$this->db->select('*')
            ->from('title');
			$query = $this->db->get();			
		return $query->result_array();
	}
	
	public function getCountryByID($country_id) {
		
		$this->db->select('*')
            ->from('country');
		$this->db->where('country_id', $country_id);
			$query = $this->db->get();
			
		return $query->row();
	}
	
	public function getStateByID($state_id) {
		
		$this->db->select('*')
            ->from('state');
		$this->db->where('state_id', $state_id);
			$query = $this->db->get();
			
		return $query->row();
	}
	
	function getState($country_id='')
	 {
		$this->db->select('*');
		$this->db->where('country_id', $country_id);
		$query = $this->db->get('state');
		
		return $query->result_array();
	 }
	 
	 public function addState($data) {
		
		$state_data = array(
				'country_id'   			=> $data['country_id'],
				'name'   				=> trim($data['state_name'])
			);
						
		$this->db->select('*');
		$this->db->from('state');
		$where = array('name' => $state_data['name'], 'country_id' => $state_data['country_id']);
		$this->db->where($where);		
		$stateName = $this->db->get()->row();
		
		$dataArr = array();
		if(empty($stateName->name)){
			
			$this->db->insert('state', $state_data);
			$state_id = $this->db->insert_id();
			
			$dataArr = 'success';
			$dataArr = array(
				'id' => $state_id,
				'name' => $data['state_name'],
			);
		} else {
			$dataArr = array(
				'error' => 'State already exists.'
			);
		}
		
		return $dataArr;		
	}	
	
	 public function addCarrier($data) {
		 		
		$sli_data = array(
			'sli_name'   				=> trim($data['sli_name']),
			'sli_account_number'   		=> $data['sli_account_number']
		);
						
		$this->db->select('*');
		$this->db->from('sli');
		$where = array('sli_name' => $sli_data['sli_name']);
		$this->db->where($where);		
		$sliName = $this->db->get()->row();
		
		$dataArr = array();
		if(empty($sliName->sli_name)){
			
			$this->db->insert('sli', $sli_data);
			$sli_id = $this->db->insert_id();
			
			$dataArr = 'success';
			$dataArr = array(
				'sli_id' => $sli_id,
				'sli_name' => $data['sli_name'],
			);
		} else {
			$dataArr = array(
				'error' => 'Carrier already exists.'
			);
		}
		
		return $dataArr;		
	}
	
	public function getDefaultAddressCustomerById($customer_id) {		
		$this->db->select('*, country.name as country_name, state.name as state_name, customer.country_id as countryId')
            ->from('customer');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->where('customer.customer_id', $customer_id);	
		$query = $this->db->get();
		
		$defaultAddress = $query->row();		
		
		$multipleAddress = $this->getAddressByCustomerId($customer_id);		
		$lastCurrency = $this->getLastQuotationCurrency($customer_id);	
		$allAddress = array();
		$currencyID="";
		if($lastCurrency->currency_id){
			$currencyID=$lastCurrency->currency_id;
		}
		$allAddress[] = array(
			'customer_id'   		=> $defaultAddress->customer_id,
			'company_name'   		=> $defaultAddress->company_name,
			'contact_person'   		=> $defaultAddress->person_title .' '. $defaultAddress->contact_person,
			'email'   				=> $defaultAddress->email,
			'phone'   				=> $defaultAddress->phone,
			'mobile'   				=> $defaultAddress->mobile,
			'address_1'   			=> $defaultAddress->address_1,
			'address_2'   			=> $defaultAddress->address_2,
			'country_id'   			=> $defaultAddress->countryId,
			'country_name'   		=> $defaultAddress->country_name,
			'state_name'   			=> $defaultAddress->state_name,
			'city'   				=> $defaultAddress->city,
			'district'   			=> $defaultAddress->district,
			'pin'   				=> $defaultAddress->pin,
			'pan'   				=> $defaultAddress->pan,
			'gst'   				=> $defaultAddress->gst,
			'lastCurrency'   		=> $currencyID
		);
		
		foreach($multipleAddress as $multipleAdd){
			
			$allAddress[] = array(
				'customer_id'   		=> $multipleAdd['customer_id'],
				'company_name'   		=> $defaultAddress->company_name,
				'contact_person'   		=> $defaultAddress->person_title .' '. $defaultAddress->contact_person,
				'email'   				=> $defaultAddress->email,
				'phone'   				=> $defaultAddress->phone,
				'mobile'   				=> $defaultAddress->mobile,
				'address_1'   			=> $multipleAdd['address_1'],
				'address_2'   			=> $multipleAdd['address_2'],
				'country_id'   			=> $multipleAdd['country_id'],
				'country_name'   		=> $multipleAdd['country_name'],
				'state_name'   			=> $multipleAdd['state_name'],
				'city'   				=> $multipleAdd['city'],
				'district'   			=> $multipleAdd['district'],
				'pin'   				=> $multipleAdd['pin'],
				'pan'   				=> $defaultAddress->pan,
				'gst'   				=> $defaultAddress->gst
			);
		}
		
		return $allAddress;
	}
	
	//To get the currency for the customer of previous quotation
	private function getLastQuotationCurrency($customer_id){
		$this->db->select('currency_id')
            ->from('quote_customer');
		$this->db->where('customer_id', $customer_id);	
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1, 0 );		
		$query = $this->db->get();
		return $query->row();
	}

	public function addNewAddress($data) {	
		$address_1 = str_replace( ',', '', $data['address_1'] );
		$address_2 = str_replace( ',', '', $data['address_2'] );
	
		$address_data = array(			
			'customer_id'   		=> $data['customer_id'],
			'address_1'   			=> ucwords(strtolower($address_1)),
			'address_2'   			=> ucwords(strtolower($address_2)),
			'country_id'   			=> $data['country_id'],
			'state_id'   			=> $data['state_id'],
			'district'   			=> ucwords(strtolower($data['district'])),
			'city'   				=> ucwords(strtolower($data['city'])),
			'pin'   				=> $data['pin'],
			'date_added' 			=> date('Y-m-j H:i:s')
		);		
		$this->db->insert('customer_address', $address_data);
		$address_id = $this->db->insert_id();
		
		$lastAddress = $this->getAddressByAddressId($address_id);
		
		return $lastAddress;		
	}
	
	public function getAddressByAddressId($address_id) {		
		$this->db->select('*, country.name as country_name, state.name as state_name, (SELECT company_name FROM svi_customer WHERE customer_id = svi_customer_address.customer_id) as company_name, (SELECT person_title FROM svi_customer WHERE customer_id = svi_customer_address.customer_id) as person_title, (SELECT contact_person FROM svi_customer WHERE customer_id = svi_customer_address.customer_id) as contact_person, (SELECT email FROM svi_customer WHERE customer_id = svi_customer_address.customer_id) as email, (SELECT mobile FROM svi_customer WHERE customer_id = svi_customer_address.customer_id) as mobile, (SELECT phone FROM svi_customer WHERE customer_id = svi_customer_address.customer_id) as phone')
            ->from('customer_address');
		$this->db->join('country', 'country.country_id = customer_address.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer_address.state_id', 'left');
		$this->db->where('customer_address.address_id', $address_id);	
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getAddressByCustomerId($customer_id) {		
		$this->db->select('*, country.name as country_name, state.name as state_name')
            ->from('customer_address');
		$this->db->join('country', 'country.country_id = customer_address.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer_address.state_id', 'left');
		$this->db->where('customer_address.customer_id', $customer_id);	
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCustomerPriceList($customer_id) {		
		/* $this->db->select('*,order_products.date_added as op_dateadded, (SELECT product_name FROM svi_product WHERE product_id = svi_order_products.prod_id) as product_name')
            ->from('order_products');
		$this->db->join('order_customer', 'order_customer.order_id = order_products.order_id', 'left');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');		
		$this->db->where('order_products.customer_id', $customer_id);
		$this->db->order_by('order_products.date_added', 'DESC');
		$this->db->group_by('order_products.prod_id');		
		$query = $this->db->get(); */
		
		$this->db->select('quotation_id, prod_id, quote_products.date_added as op_dateadded, ltp, model_name, (SELECT product_name FROM svi_product WHERE product_id = svi_quote_products.prod_id) as product_name')
            ->from('quote_products');
		$this->db->join('quote_customer', 'quote_customer.id = quote_products.quotation_id', 'left');
		$this->db->join('currency', 'currency.id = quote_customer.currency_id', 'left');
		$arr = array('quote_products.customer_id' => $customer_id, 'quote_products.rate >' => 0, 'quote_customer.is_deleted' => 'N');
		//$this->db->where($arr);		
		$this->db->where('quote_products.id IN( SELECT MAX(id) FROM svi_quote_products WHERE customer_id='.$customer_id.' GROUP BY prod_id)');		
		$this->db->order_by('quote_products.date_added', 'DESC');
		//$this->db->group_by('quote_products.prod_id');		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getDefaultAddress($customer_id) {	
		
		$this->db->select('*, country.name as country_name, state.name as state_name')
            ->from('customer');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->where('customer.customer_id', $customer_id);	
		$query = $this->db->get();
		
		return $query->row();		
	}
	
	
	public function getCustomerQuotationById($customer_id) {		
		$this->db->select('*, svi_quote_customer.id as quote_id, (SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount')
            ->from('quote_customer');
		$this->db->join('currency', 'currency.id = quote_customer.currency_id', 'left');
		$this->db->where('is_deleted', 'N');
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by('created_time', 'DESC');				
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getCustomerOrderById($customer_id) {		
		$this->db->select('*, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount')
            ->from('order_customer');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by('date_added', 'DESC');				
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCustomerChallanById($customer_id) {		
		$this->db->select('*, (SELECT quotation_id FROM svi_order_customer WHERE order_id = svi_challan.order_id) as quotation_id, (SELECT SUM(net_total) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as net_total, (SELECT freight_charges FROM svi_challan_product WHERE challan_id = svi_challan.challan_id GROUP BY svi_challan_product.challan_id) as freight_charges')
            ->from('challan');
		$this->db->join('customer', 'customer.customer_id = challan.customer_id', 'left');
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where('challan.customer_id', $customer_id);
		$this->db->order_by('challan.date_added', 'DESC');		
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getReturnProductById($customer_id){
	    $this->db->select('*, (SELECT batch_no FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_no, (SELECT description FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id = svi_challan_product.product_id) as pro_description,(SELECT exp_date FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_exp_date,')
            ->from('challan_product');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where('challan_product.customer_id', $customer_id, 'challan_product.return_qty != 0');
		$this->db->order_by('challan_product.challan_pro_id',"DESC");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCustomerByMobile($mobile) {		
		$this->db->select('*')
            ->from('customer');
		$this->db->where('mobile', $mobile);	
		$query = $this->db->get();
		return $query->row();
	}

	public function getCustomerByEmail($email) {		
		$this->db->select('*')
            ->from('customer');
		$this->db->where('email', $email);	
		$query = $this->db->get();
		return $query->row();
	}
	
	public function addCustomerPyament($data,$customer_id,$bank_file) {	
			
		$customer_payment = array(
			'customer_id'   		=> $customer_id,
			'currency_id'   		=> $data['currency_id'],
			'amount'   				=> $data['amount'],			
			'mode_of_payment'   	=> $data['mode_of_payment'],			
			'bank_id'   			=> $data['bank_id'],			
			'reference_number'   	=> $data['reference_number'],			
			'reference_document'   	=> $bank_file[0],			
			'date_of_payment' 		=> $data['date_of_payment'],
			'note'					=> $data['note'],
			'created_user_id'		=> $_SESSION['user_id'],
			'date_added'			=> date('Y-m-j H:i:s')			
		);		
		$this->db->insert('customer_payment', $customer_payment);
		$customer_payment_id = $this->db->insert_id();
		
		$filesCount = count($bank_file);
		if(!empty($bank_file) && count(array_filter($bank_file)) > 0){ 
			for($i = 0; $i < $filesCount; $i++){
				$file_data=array(
					'customer_payment_id' 		=> $customer_payment_id,
					'bank_file' 				=> $bank_file[$i],											
					'date_added'				=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('customer_payment_file',$file_data);				
			}
		}		
		return true;		
	}
	
	public function editCustomerPyament($data,$customer_id,$bank_file,$payment_id) {
		
		$customer_payment = array(
			'currency_id'   		=> $data['currency_id'],
			'amount'   				=> $data['amount'],			
			'mode_of_payment'   	=> $data['mode_of_payment'],			
			'bank_id'   			=> $data['bank_id'],			
			'reference_number'   	=> $data['reference_number'],						
			'date_of_payment' 		=> $data['date_of_payment'],
			'note'					=> $data['note'],
			'modifi_user_id'		=> $_SESSION['user_id'],
			'modifi_date'			=> date('Y-m-j H:i:s')
		);
		
				
		$this->db->where('customer_id', $customer_id);
		$this->db->where('customer_payment_id', $payment_id);
		$this->db->update('customer_payment', $customer_payment);
		
		$filesCount = count($bank_file);
		if(!empty($bank_file) && count(array_filter($bank_file)) > 0){ 
			for($i = 0; $i < $filesCount; $i++){
				$file_data=array(
					'customer_payment_id' 		=> $payment_id,
					'bank_file' 				=> $bank_file[$i],				
					'modifi_user_id' 			=> $_SESSION['user_id'],
					'modifi_date'				=> date('Y-m-d H:i:s'),
					'date_added'				=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('customer_payment_file',$file_data);				
			}
		}
		
		return true;		
	}
	
	public function getChallanTotalByCustomerId($customer_id){
		$this->db->select('(SELECT currency_id FROM svi_order_customer WHERE order_id=svi_challan.order_id) as currency_id, SUM(net_total) as netTotal, freight_charges, (SELECT SUM(gst_total_amount) FROM svi_challan_product_gst WHERE challan_id = svi_challan.challan_id) as gst_total_amount')
            ->from('challan_product');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id and challan.is_deleted="N"', 'left');
		$this->db->where('challan.customer_id', $customer_id);
		$this->db->group_by('challan_product.challan_id');
		$query = $this->db->get();		
		$ChallanTotalInfo = $query->result_array();
							
		$net_total = 0;
		foreach($ChallanTotalInfo as $challanProduct){ 
			$net_total = $net_total + $challanProduct['netTotal'] + $challanProduct['freight_charges'] + $challanProduct['gst_total_amount'];
			$currency_id = 	$challanProduct['currency_id'];
		}
		
		$this->db->select('*')
            ->from('currency');
		$this->db->where('id', $currency_id);	
		$query = $this->db->get();
		$currency_html = $query->row();
		
		$dataArr = array(
			'net_total' 		=> $net_total,
			'currency_id'		=> $currency_id,
			'currency_html'		=> $currency_html->currency_html
		);

		return $dataArr;
	}
	
	public function getChallanPaymentById($customer_id,$year){  
	
		$yearArr = explode("-",$year);
		$year1 = $yearArr[0].'-'.'04-01';
		$year2 = $yearArr[1].'-'.'03-31';
		
		$this->db->select('challan.challan_id,challan_date,freight_charges, SUM(net_total) as netTotal, (SELECT SUM(gst_total_amount) FROM svi_challan_product_gst WHERE challan_id = svi_challan.challan_id) as gst_total_amount, (SELECT currency_id FROM svi_order_customer WHERE order_id = svi_challan.order_id) as currency_id')
            ->from('challan_product');
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id and challan.is_deleted="N"', 'left');
		$this->db->where('challan.customer_id', $customer_id);
		
		if($year){
			$this->db->where('challan.challan_date >=', $year1);
			$this->db->where('challan.challan_date <=', $year2);
		}
		
		$this->db->order_by('challan.challan_date', 'ASC');
		$this->db->group_by('challan_product.challan_id');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getCustomerPaymentById($customer_id,$year){
		
		$yearArr = explode("-",$year);
		$year1 = $yearArr[0].'-'.'04-01';
		$year2 = $yearArr[1].'-'.'03-31';
		
		$this->db->select('*, (SELECT mode_name FROM svi_mode_of_payment WHERE mode_payment_id = svi_customer_payment.mode_of_payment) as mode_name, (SELECT currency_faclass FROM svi_currency WHERE id = svi_customer_payment.currency_id) as currency_faclass, (SELECT currency_html FROM svi_currency WHERE id = svi_customer_payment.currency_id) as currency_html, (SELECT bank_name FROM svi_bank WHERE id = svi_customer_payment.bank_id) as bank_name, (SELECT COUNT(file_id) FROM svi_customer_payment_file WHERE customer_payment_id = svi_customer_payment.customer_payment_id) as file_total')
            ->from('customer_payment');		
		$this->db->where('customer_id', $customer_id);
		if($year){
			$this->db->where('date_of_payment >=', $year1);
			$this->db->where('date_of_payment <=', $year2);
		}
		$this->db->order_by('date_of_payment', 'ASC');				
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getModeOfPayment(){
		$this->db->select('*')
            ->from('mode_of_payment');				
		$this->db->order_by('mode_payment_id', 'ASC');				
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getCustomerPaymentTotal($customer_id){
		$this->db->select('SUM(amount) as amount, (SELECT currency_faclass FROM svi_currency WHERE id = svi_customer_payment.currency_id) as currency_faclass');
		$this->db->from('customer_payment');
		$this->db->where('customer_id', $customer_id);		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}
	public function getGoodsReturnAmountForChallan($challan_id,$customer_id){
		
		#$this->db->select('`qty`, `product_gst`, `rate`, `return_qty`, ((net_total/qty)*return_qty) AS returnnet_total, (SELECT (returnnet_total*product_gst)/100) AS gst_amount, (SELECT (returnnet_total+gst_amount)) AS total_return_amount');
		
		$qry='';
		$country_id=$this->db->get_where('customer',array('customer_id'=>$customer_id))->row()->country_id;
		if($country_id==99){
			$qry='`qty`, `product_gst`, `rate`, `return_qty`, ((net_total/qty)*return_qty) AS returnnet_total, 		(SELECT (returnnet_total*product_gst)/100) AS gst_amount, (SELECT (returnnet_total+gst_amount)) AS total_return_amount';
		}else{
			$qry='`qty`, `product_gst`, `rate`, `return_qty`, ((net_total/qty)*return_qty) AS total_return_amount';
		}
		$this->db->select($qry);
		#FROM svi_challan_product WHERE customer_id=27 AND return_qty>0'
		$this->db->from('challan_product');
		$this->db->where('return_qty>0');		
		$this->db->where('customer_id', $customer_id);		
		$this->db->where('challan_id', $challan_id);
		$query = $this->db->get();		
		
		$results = $query->result_array();
		#echo $this->db->last_query();exit;
		$total=0;
		foreach($results as $result){
			$total=$total+$result['total_return_amount'];
		}
		
		return $total;
	}

	public function getCustomerGoodsReturnTotal($customer_id){

		$qry='';
		$country_id=$this->db->get_where('customer',array('customer_id'=>$customer_id))->row()->country_id;
		if($country_id==99){
			$qry='`qty`, `product_gst`, `rate`, `return_qty`, ((net_total/qty)*return_qty) AS returnnet_total, 		(SELECT (returnnet_total*product_gst)/100) AS gst_amount, (SELECT (returnnet_total+gst_amount)) AS total_return_amount';
		}else{
			$qry='`qty`, `product_gst`, `rate`, `return_qty`, ((net_total/qty)*return_qty) AS total_return_amount';
		}
		$this->db->select($qry);
		#FROM svi_challan_product WHERE customer_id=27 AND return_qty>0'
		$this->db->from('challan_product');
		$this->db->where('return_qty>0');		
		$this->db->where('customer_id', $customer_id);		
		$query = $this->db->get();		
		
		$results = $query->result_array();
		$total=0;
		foreach($results as $result){
			$total=$total+$result['total_return_amount'];
		}		
		return $total;
	}
	
	public function getOutStandingBalanceById($customer_id){
		$challanTotal = $this->getChallanTotalByCustomerId($customer_id);
		$total_amount = $this->getCustomerPaymentTotal($customer_id);
			
		$outstand_balance = number_format((float)($challanTotal['net_total'] - $total_amount->amount), 2, '.', '');
		
		if($challanTotal['currency_id']){
			$outstand_balance = ($challanTotal['currency_id'] == 1) ? '<l class="fas fa-rupee-sign"></i> '.$outstand_balance : '<b>'.$challanTotal['currency_html'].' '. $outstand_balance.'</b>';
		}else {
			$outstand_balance = '<l class="'. $total_amount->currency_faclass .'"></i> <b>'. abs($outstand_balance) .'</b>';
		}
		
		return $outstand_balance;
	}
	
	public function getPaymentById($customer_id,$payment_id){
		$this->db->select('*,(SELECT mode_name FROM `svi_mode_of_payment` WHERE mode_payment_id=svi_customer_payment.mode_of_payment) as mode_name, (SELECT currency_faclass FROM `svi_currency` WHERE id=svi_customer_payment.currency_id) as currency_faclass, (SELECT bank_name FROM `svi_bank` WHERE id=svi_customer_payment.bank_id) as bank_name,(SELECT username FROM `svi_user` WHERE user_id=svi_customer_payment.created_user_id) as username');
		$this->db->from('customer_payment');
		$this->db->where('customer_id', $customer_id);		
		$this->db->where('customer_payment_id', $payment_id);		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}
	
	public function getCurrencyById($currency_id){
		$this->db->select('*');
		$this->db->from('currency');
		$this->db->where('id', $currency_id);				
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();		
	}
	
	public function getChallanPaymentStatus($challan_id){
		$this->db->select('*,(SELECT username FROM `svi_user` WHERE user_id=svi_challan_payment.user_id) as user_paid, (SELECT username FROM `svi_user` WHERE user_id=svi_challan_payment.user_modify_id) as user_unpaid');
		$this->db->from('challan_payment');
		$this->db->where('challan_id', $challan_id);				
		$query = $this->db->get();
		return $query->row();		
	}
	
	public function addChallanPaymentStatus($data){
		$challanPaymentStatus = $this->getChallanPaymentStatus($data['challan_id']);
				
		if(!empty($challanPaymentStatus->challan_id)){
			$challan_data = array(
				'user_modify_id'   		=> $_SESSION['user_id'],
				'user_modify_mark'   	=> $data['status'],
				'user_modify_datetime'  => date('Y-m-j H:i:s')
			);			
			$this->db->where('challan_id', $data['challan_id']);
			$this->db->update('challan_payment', $challan_data);
		}else {
			$challan_data = array(
				'challan_id'   			=> $data['challan_id'],
				'user_id'   			=> $_SESSION['user_id'],
				'user_mark'   			=> $data['status'],
				'user_datetime'   		=> date('Y-m-j H:i:s')
			);			
			$this->db->insert('challan_payment', $challan_data);
		}		
	}
	
	public function getPaymentFile($customer_payment_id) {		
		$this->db->select('*')
            ->from('customer_payment_file');		
		$array = array('customer_payment_id' => $customer_payment_id);				
		$this->db->where($array);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function delPaymentFile($file_id) {
		$this->db->where('file_id', $file_id);
		$this->db->delete('customer_payment_file');		
		return true;
	}
	
}