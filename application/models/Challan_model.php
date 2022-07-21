<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Challan_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function saveChallan($data,$customerInfo){
		
		$stock_transfer = 0;
		if(($customerInfo->store_id > 0) && ($customerInfo->customer_id == $this->config->item('allahabad_customer_id') || $customerInfo->customer_id == $this->config->item('delhi_customer_id'))){			
			$stock_transfer = 1;
		}
		
	 	$challan_data=array(
			'user_id' 				=> $data['user_id'],
			'customer_id' 			=> $data['customer_id'],
			'bank_id' 				=> $data['bank_id'],
			'order_id' 				=> $data['order_id'],
			'store_id' 				=> $data['store_id'],
			'challan_type' 			=> $data['challan_type'],			
			'challan_date' 			=> $data['challan_date'],
			'manual_challan_no' 	=> $data['manual_challan_no'],
			'manual_challan_date' 	=> $data['manual_challan_date'],
			'method_of_shipment' 	=> $data['method_of_shipment'],
			'sli_id' 				=> $data['sli_id'],
			'account_number' 		=> $data['account_number'],
			'date_of_shipment' 		=> $data['date_of_shipment'],
			'docket_no' 			=> $data['docket_no'],
			'sb_number' 			=> $data['sb_number'],			
			'invoice_no' 			=> $data['invoice_no'],			
			'invoice_date' 			=> $data['invoice_date'],
			'payment_terms' 		=> $data['payment_terms'],
			'billing_details' 		=> $data['billing_details'],
			'shipping_details' 		=> $data['shipping_details'],
			'packer_id'				=> $data['packer_id'],
			'created_by'			=> $_SESSION['user_id'],
			'stock_transfer'		=> $stock_transfer,
			'freight_gst' 			=> $this->config->item('PER_FREIGHT_GST'),
			'challan_pdf_id' 			=> md5($data['customer_id'].uniqid()),
			'date_added'			=> date('Y-m-d H:i:s')
		);
		
		$this->db->insert('challan',$challan_data);
		$challan_id = $this->db->insert_id(); 
		
		$proData = $data['productid'];		
		foreach($proData as $index => $product_id ){			
			$challan_product=array(
				'order_id' 				=> $data['order_id'],
				'store_id' 				=> $data['store_id'],
				'challan_id' 			=> $challan_id,
				'customer_id' 			=> $data['customer_id'],
				'product_id' 			=> $product_id,
				'batch_id' 				=> $data['batch_id'][$index],
				'freight_charges' 		=> $data['freightcharges'],
				'product_gst' 			=> $data['gstRate'][$index],
				'qty' 					=> $data['qty'][$index],
				'rate' 					=> $data['rate'][$index],
				'discount' 				=> $data['discount'][$index],
				'net_total' 			=> $data['net_total'][$index],			
				'date_added'			=> date('Y-m-d H:i:s')
			);						
			$this->db->insert('challan_product',$challan_product);
			$qty = $data['qty'][$index];			
			
			$array = array('order_id' => $data['order_id'], 'prod_id' => $product_id);
			$this->db->set('challan_qty', 'challan_qty+'.$qty, FALSE);
			$this->db->where($array);
			$this->db->update('order_products');
		} 
		
		$this->db->select('SUM(qty) as ordQty')
            ->from('order_products');
		$array = array('order_id' => $data['order_id']);
		$this->db->where($array);
		$query = $this->db->get();
		$ordQty = $query->row()->ordQty;
		
		$this->db->select('SUM(qty) as challanQty')
            ->from('challan_product');			
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$array = array('challan.is_deleted' => 'N', 'challan_product.order_id' => $data['order_id']);	
		$this->db->where($array);

		$querya = $this->db->get();
		$challanQty = $querya->row()->challanQty;
		
		if($ordQty == $challanQty){
			$array = array('order_id' => $data['order_id']);
			$this->db->set('challan_status', 'C');
			$this->db->where($array);
			$this->db->update('svi_order_customer');
		}		
		
		$gstTotalAmount = $data['gst_total_amount'];
		if($gstTotalAmount){
			foreach($gstTotalAmount as $index => $amount ){
				$product_gst = array(				
					'challan_id' 			=> $challan_id,				
					'gst_rate' 				=> $index,				
					'gst_total_amount' 		=> $amount,				
				);						
				$this->db->insert('challan_product_gst',$product_gst);
			}
		}
		
		if(($customerInfo->store_id > 0) && ($customerInfo->customer_id == $this->config->item('allahabad_customer_id') || $customerInfo->customer_id == $this->config->item('delhi_customer_id'))){
			
			/* if(($customerInfo->store_id ==1) && ($customerInfo->customer_id == $this->config->item('allahabad_customer_id'))) {
				$store_id = 2;			
			} elseif(($customerInfo->store_id ==2) && ($customerInfo->customer_id == $this->config->item('delhi_customer_id'))) {
				$store_id = 1;	
			} */
			
			foreach($proData as $index => $product_id ){			
				$challan_stock=array(					
					'user_id' 				=> $_SESSION['user_id'],
					'store_id' 				=> $customerInfo->store_id,
					'challan_id' 			=> $challan_id,					
					'product_id' 			=> $product_id,
					'batch_id' 				=> $data['batch_id'][$index],
					'qty' 					=> $data['qty'][$index],
					'added_datetime' 		=> date('Y-m-d H:i:s')
				);				
				$this->db->insert('stock',$challan_stock);
			}
		}
		
		
		return true;
	} 
	
	public function editChallan($data,$challan_id){		
		
		$netTotalChallan = 0.00;
		$netTotalOrder = 0.00;
		$netTotalQuotation = 0.00;
		$proArr = array();
		foreach($data['new_discount'] as $challan_pro_id => $val ){
			/* Update challan Discount */
			$arrChallan = array('challan_id' => $challan_id, 'challan_pro_id' => $challan_pro_id);
			
			$this->db->select('*')
            ->from('challan_product');
			$this->db->where($arrChallan);
			$queryChallan = $this->db->get();
			$challanInfo = $queryChallan->row();
			$oldChallanDiscount = $challanInfo->discount;
			$order_id = $challanInfo->order_id;
			$product_id = $challanInfo->product_id;
			
			$rateChallan = $challanInfo->rate;
			$qtyChallan = $challanInfo->qty;
			$netTotalChallan = ($rateChallan - $val)*$qtyChallan;
			
			$this->db->set('discount', $val);
			$this->db->set('old_discount', $oldChallanDiscount);
			$this->db->set('net_total', $netTotalChallan);
			$this->db->where($arrChallan);
			$this->db->update('challan_product');
			
			$proArr[$product_id ] = $val;
			
		}
		
		foreach($data['gst_total_amount'] as $gst => $val ){
			$array = array('challan_id' => $challan_id, 'gst_rate' => $gst);
			$this->db->set('gst_total_amount', $val);			
			$this->db->where($array);
			$this->db->update('challan_product_gst');
		}
		
		foreach($proArr as $index => $val){			
			/* Update order Discount */
		 	 $arrOrder = array('order_id' => $data['order_id'], 'prod_id' => $index);
			
			$this->db->select('*')
            ->from('order_products');
			$this->db->where($arrOrder);
			$queryOrder = $this->db->get();
			$orderInfo = $queryOrder->row();
			$oldOrdDiscount = $orderInfo->discount;
			$quotation_id = $orderInfo->quotation_id;
			
			$rateOrder = $orderInfo->rate;
			$qtyOrder = $orderInfo->qty;
			$netTotalOrder = ($rateOrder - $val)*$qtyOrder;
			
			$this->db->set('discount', $val);
			$this->db->set('old_discount', $oldOrdDiscount);
			$this->db->set('net_amount', $netTotalOrder);
			$this->db->where($arrOrder);
			$this->db->update('order_products');  
			
			/* Update Quotation Discount */
			 $arrQuotation = array('quotation_id' => $quotation_id, 'prod_id' => $index);
			
			$this->db->select('*')
            ->from('quote_products');
			$this->db->where($arrQuotation);
			$queryQuotation = $this->db->get();
			$quotationInfo = $queryQuotation->row();
			$oldQuoteDiscount = $quotationInfo->discount;
			
			$rateQuote = $quotationInfo->rate;
			$qtyQuote = $quotationInfo->qty;
			$netTotalQuote = ($rateQuote - $val)*$qtyQuote;
			
			$this->db->set('discount', $val);
			$this->db->set('old_discount', $oldQuoteDiscount);
			$this->db->set('net_amount', $netTotalQuote);
			$this->db->where($arrQuotation);
			$this->db->update('quote_products'); 
		}
		
		
			
		return true;
	}
	
	public function getChallan($limit, $start,$data){
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
		
		if(!empty($data['is_deleted'])){
			$qryArr['challan.is_deleted']=$data['is_deleted'];
		}

		if(!empty($data['model'])){			
			$this->db->select('challan_id');
			$this->db->from('challan_product');
			$this->db->where('product_id',$data['model']);
			$query3 = $this->db->get();
			$challanIdpmodel = $query3->result_array();			
			$challanIdpmodel = array_column($challanIdpmodel, 'challan_id');
			if(empty($challanIdpmodel)){
				$challanIdpmodel = 'null';
			}
			
		}
		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('prod_id');
			$this->db->distinct('prod_id');
			$this->db->from('order_products');
			$this->db->group_start();
				$this->db->like('order_products.prod_name',trim($data['product_name']));
				$this->db->or_like('order_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$productIds = $query3->result_array();	
			#echo $this->db->last_query();exit;		
			$productIds = array_column($productIds, 'prod_id');
			if(empty($productIds)){
				$productIds = 'null';
			}
			
			$this->db->select('challan_id');
			$this->db->distinct('challan_id');
			$this->db->from('challan_product');
			$this->db->where_in('challan_product.product_id',$productIds);	

			$query3 = $this->db->get();
			$challanIdProducts = $query3->result_array();			
			$challanIdProducts = array_column($challanIdProducts, 'challan_id');
			if(empty($challanIdProducts)){
				$challanIdProducts = 'null';
			}
		}

	    $this->db->select('*,country.name as country_name, state.name as state_name, (SELECT SUM(net_total) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_challan.store_id) as store_name, (SELECT SUM(return_qty) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as return_qty, challan.order_id as corder_id, order_customer.order_id as ord_id,(SELECT freight_charges FROM svi_challan_product WHERE challan_id = svi_challan.challan_id LIMIT 1) as challan_freight_charges')
            ->from('challan');
			
		$this->db->join('customer', 'customer.customer_id = challan.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->join('order_customer', 'order_customer.order_id = challan.order_id', 'left');
		
		$this->db->where($qryArr);
		
		if(!empty($data['model'])){			
			$this->db->where_in('challan.challan_id',$challanIdpmodel);			
		}

		if(!empty($data['product_name']) && empty($data['model'])){		
			$this->db->where_in('challan.challan_id',$challanIdProducts);			
		}

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
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('challan.challan_id',"DESC");
		}	
		
		$query = $this->db->get();	
		#echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalChallan($data){
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
		
		if(!empty($data['is_deleted'])){
			$qryArr['challan.is_deleted']=$data['is_deleted'];
		}

		if(!empty($data['model'])){			
			$this->db->select('challan_id');
			$this->db->from('challan_product');
			$this->db->where('product_id',$data['model']);
			$query3 = $this->db->get();
			$challanIdpmodel = $query3->result_array();			
			$challanIdpmodel = array_column($challanIdpmodel, 'challan_id');
			if(empty($challanIdpmodel)){
				$challanIdpmodel = 'null';
			}
		}

		if(!empty($data['product_name']) && empty($data['model'])){
			$this->db->select('prod_id');
			$this->db->distinct('prod_id');
			$this->db->from('order_products');
			$this->db->group_start();
				$this->db->like('order_products.prod_name',trim($data['product_name']));
				$this->db->or_like('order_products.description',trim($data['product_name']));
			$this->db->group_end();	
			$query3 = $this->db->get();
			$productIds = $query3->result_array();	
			#echo $this->db->last_query();exit;		
			$productIds = array_column($productIds, 'prod_id');
			if(empty($productIds)){
				$productIds = 'null';
			}
			
			$this->db->select('challan_id');
			$this->db->distinct('challan_id');
			$this->db->from('challan_product');
			$this->db->where_in('challan_product.product_id',$productIds);	

			$query3 = $this->db->get();
			$challanIdProducts = $query3->result_array();			
			$challanIdProducts = array_column($challanIdProducts, 'challan_id');
			if(empty($challanIdProducts)){
				$challanIdProducts = 'null';
			}
		}
		
	    $this->db->select('*,country.name as country_name, state.name as state_name, (SELECT SUM(net_total) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as net_amount, (SELECT currency_faclass FROM svi_currency WHERE id=svi_order_customer.currency_id) as currency_faclass, (SELECT store_name FROM svi_store WHERE store_id = svi_challan.store_id) as store_name, (SELECT SUM(return_qty) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as return_qty')
            ->from('challan');
			
		$this->db->join('customer', 'customer.customer_id = challan.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$this->db->join('state', 'state.state_id = customer.state_id', 'left');
		$this->db->join('order_customer', 'order_customer.order_id = challan.order_id', 'left');
		
		$this->db->where($qryArr);
		
		if(!empty($data['model'])){			
			$this->db->where_in('challan.challan_id',$challanIdpmodel);			
		}

		if(!empty($data['product_name']) && empty($data['model'])){		
			$this->db->where_in('challan.challan_id',$challanIdProducts);			
		}

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
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('challan.challan_id',"DESC");
		}
		
		$query = $this->db->get();
			
		return $query->num_rows();
	}
	
	public function getChallanById($challan_id){
	    $this->db->select('*,challan.store_id as challan_store_id, (SELECT sli_name FROM svi_sli WHERE sli_id = svi_challan.sli_id) as sli_name, (SELECT username FROM svi_user WHERE user_id = svi_challan.created_by) as created_user')
            ->from('challan');
		$this->db->join('user', 'user.user_id = challan.user_id', 'left');	
		$this->db->join('packer', 'packer.packer_id = challan.packer_id', 'left');	
		$this->db->join('store', 'store.store_id = challan.store_id', 'left');	
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getChallanProduct(){
	    $this->db->select('*')
            ->from('challan_product');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getLastChallanId(){
		$this->db->select('*');
		$this->db->from('quote_customer');
		$this->db->limit(1);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		$result = $query->row();
		$last_id =$result->id +1;
		return	$last_id;
	}
	
	public function getChallanProductById($challan_id){
	    $this->db->select('*, (SELECT description FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id=svi_challan_product.product_id) as pro_des, (SELECT hsn FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id=svi_challan_product.product_id) as pro_hsn, (SELECT unit FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id=svi_challan_product.product_id) as pro_unit,(SELECT model_name FROM svi_order_products WHERE order_id = svi_challan_product.order_id AND prod_id=svi_challan_product.product_id) as model_name, (SELECT mfg_date FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_mfg_date, (SELECT exp_date FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_exp_date, (SELECT batch_no FROM svi_batch WHERE batch_id = svi_challan_product.batch_id) as batch_no')
            ->from('challan_product');		
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getStore(){
	    $this->db->select('*')
            ->from('store');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getOrderByOId($order_id) {
		$this->db->select('*')
            ->from('order_customer');
		$this->db->join('store', 'store.store_id = order_customer.store_id', 'left');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$this->db->join('user', 'user.user_id = order_customer.user_id', 'left');
		$array = array('order_customer.order_id' => $order_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getOrderProductById($order_id) {
		#$this->db->select('*,(SELECT SUM(qty) FROM svi_challan_product WHERE order_id = svi_order_products.order_id AND product_id = svi_order_products.prod_id) as challan_qty')
		$this->db->select('*,(SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.order_id = svi_order_products.order_id AND cp.product_id = svi_order_products.prod_id) as challan_qty')
            ->from('order_products');
		$array = array('order_id' => $order_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}

	public function getOrderProByOIdPId($order_id,$product_id) {
		$this->db->select('*,(SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.order_id = svi_order_products.order_id AND cp.product_id = svi_order_products.prod_id) as challan_qty')
            ->from('order_products');
		$array = array('order_id' => $order_id, 'prod_id' => $product_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getProductBatchByProId($data) {
		#$exp_before = $this->config->item('exp_before');
		$exp_before = $this->dbvars->__get('config_exp_before');
		$currentMonthAfter = date('Y-m-t', strtotime('+'.$exp_before.' months'));
				
		$this->db->select('*, SUM(qty) AS stock_qty, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) AS out_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) AS return_qty')
            ->from('stock'); 
		 $this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
		 $this->db->join('store', 'store.store_id = stock.store_id', 'left');
		$array = array('stock.status' => 'A', 'stock.qty >' => '0', 'stock.product_id' => $data['product_id'], 'stock.store_id' => $data['store_id'], 'batch.exp_date >=' => $currentMonthAfter);	
		$this->db->where($array);
		$this->db->group_by(array('stock.batch_id', 'stock.store_id'));
		$this->db->order_by('batch.exp_date', ' DESC');
		$query = $this->db->get();		
		return $query->result_array();
		
	}
	
	
	public function getAllProductBatchByProIdWithExpiry($data) {
		#$exp_before = $this->config->item('exp_before');
		$exp_before = $this->dbvars->__get('config_exp_before');
		$currentMonthAfter = date('Y-m-t', strtotime('+'.$exp_before.' months'));
				
		$this->db->select('*, SUM(qty) AS stock_qty, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) AS out_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) AS return_qty')
            ->from('stock'); 
		 $this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
		 $this->db->join('store', 'store.store_id = stock.store_id', 'left');
		$array = array('stock.status' => 'A', 'stock.qty >' => '0', 'stock.product_id' => $data['product_id'], 'stock.store_id' => $data['store_id'], 'batch.exp_date <' => $currentMonthAfter);	
		//$array = array('stock.status' => 'A', 'stock.qty >' => '0', 'stock.product_id' => $data['product_id'], 'stock.store_id' => $data['store_id']);	
		$this->db->where($array);
		$this->db->group_by(array('stock.batch_id', 'stock.store_id'));
		$this->db->order_by('batch.exp_date', ' DESC');
		$query = $this->db->get();		
		return $query->result_array();
		
	}
	
	public function getProductBatchByProIdBthId($product_id,$batch_id,$store_id,$expVal) {
		#$exp_before = $this->config->item('exp_before');
		$exp_before = $this->dbvars->__get('config_exp_before');
		$currentMonthAfter = date('Y-m-t', strtotime('+'.$exp_before.' months'));
		
		$this->db->select('*, SUM(qty) AS stock_qty, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) AS out_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON(cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.batch_id = svi_stock.batch_id AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) AS return_qty')
            ->from('stock'); 
		 $this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
		#$array = array('stock.status' => 'A', 'stock.qty >' => '0', 'stock.product_id' => $product_id, 'stock.batch_id =' => $batch_id, 'stock.store_id' => $store_id, 'batch.exp_date >=' => $currentMonthAfter);
		if($expVal == 1){
			$array = array('stock.status' => 'A', 'stock.qty >' => '0', 'stock.product_id' => $product_id, 'stock.batch_id =' => $batch_id, 'stock.store_id' => $store_id);
		}else{
			$array = array('stock.status' => 'A', 'stock.qty >' => '0', 'stock.product_id' => $product_id, 'stock.batch_id =' => $batch_id, 'stock.store_id' => $store_id, 'batch.exp_date >=' => $currentMonthAfter);
		}		
		$this->db->where($array);
		//$this->db->group_by(array('stock.batch_id', 'stock.store_id'));
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();		
	}	
	
	public function getProductStockByBatchId($batch_id,$qty) {
		$this->db->select('*')
            ->from('stock');        
		$array = array('status' => 'A', 'batch_id' => $batch_id, 'qty <=' => $qty);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getOrderProductGroupGst($challan_id) {		
		$this->db->select('*');
		$this->db->from('challan_product_gst');		
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);
		$this->db->where('gst_rate != ',0,FALSE);
		$query = $this->db->get();		
		return $query->result_array();	
			
	}
	
	public function addSliDetails($data){
		
		if($data['sli_id'] == 1){
			$data['country_id'] = 0;	
		}
		
		$sli_data=array(
			'challan_id' 					=> $data['challan_id'],
			'sli_id' 						=> $data['sli_id'],
			'igstin_pay_status' 			=> $data['igstin_pay_status'],
			'if_b' 							=> $data['if_b'],
			'igst_amount' 					=> $data['igst_amount'],
			'incoterms' 					=> $data['incoterms'],
			'nob_duty_drawback' 			=> $data['nob_duty_drawback'],
			'ein_no' 						=> $data['ein_no'],
			'nature_of_payment' 			=> $data['nature_of_payment'],
			'fob_value' 					=> $data['fob_value'],
			'no_of_pkgs' 					=> $data['no_of_pkgs'],
			'net_wt' 						=> $data['net_wt'],
			'gross_wt' 						=> $data['gross_wt'],
			'volume_wt' 					=> $data['volume_wt'],
			'lbh' 							=> $data['lbh'],		
			'marks_and_number' 				=> $data['marks_and_number'],			
			'ship_bill_tick' 				=> $data['ship_bill_tick'],			
			'description_good' 				=> $data['description_good'],			
			'destination_country' 			=> $data['country_id'],			
			'date_added'					=> date('Y-m-d H:i:s')
		);
		
		if($data['sli_detail_id']){			
		
			$this->db->where('sli_detail_id', $data['sli_detail_id']);
			$this->db->update('sli_details', $sli_data);				
		} else {
			$this->db->insert('sli_details',$sli_data);
			$id = $this->db->insert_id() ;
		}
		
		if($data['special_instruction']){
			$special_data=array(
				'special_instruction' 	=> $data['special_instruction']
			);
			$this->db->where('challan_id', $data['challan_id']);
			$this->db->update('challan', $special_data);
		}

		if(empty($data['dhl_doc']) && ($data['sli_id'] == 1)){
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
		}	
		
		if($data['dhl_doc'] && ($data['sli_id'] == 1)){
			
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
			
			foreach($data['dhl_doc'] as $doc){
				/* if($doc == 17){
					$doc_label = $data['dhl_doc_17_text'];
				} else if($doc == 18){
					$doc_label = $data['dhl_doc_18_text'];
				} else {
					$doc_label = '';
				} */
				
				$sli_data=array(
					'sli_detail_id' 		=> $id,
					'sli_id' 				=> $data['sli_id'],
					'doc' 					=> $doc,			
					//'doc_label' 			=> $doc_label,			
					'date_added'			=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('sli_doc',$sli_data);				
			}
		}
		
		if(empty($data['fedex_doc']) && ($data['sli_id'] == 2)){
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
		}
		
		if($data['fedex_doc'] && ($data['sli_id'] == 2)){
			
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];				
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
			
			foreach($data['fedex_doc'] as $doc){
				/* if($doc == 17){
					$doc_label = $data['dhl_doc_17_text'];
				} else if($doc == 18){
					$doc_label = $data['dhl_doc_18_text'];
				} else {
					$doc_label = '';
				} */
				$doc_label = '';
				
				$sli_data=array(
					'sli_detail_id' 		=> $id,
					'sli_id' 				=> $data['sli_id'],
					'doc' 					=> $doc,			
					'doc_label' 			=> $doc_label,			
					'date_added'			=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('sli_doc',$sli_data);				
			}
		}
		return true;
	}
	
	public function getSli() {
		$this->db->select('*')
            ->from('sli');
		$this->db->order_by('sli_name ASC');
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getSliDocLabel($sli_id) {
		$this->db->select('*')
            ->from('sli_doc_label');
		$array = array('sli_id' => $sli_id,'status' => 'Y');
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getSliDetailsByID($sli_id,$challan_id){
		$this->db->select('*,(SELECT name FROM svi_country WHERE country_id = svi_sli_details.destination_country) as country_name')
            ->from('sli_details');
		$array = array('sli_id' => $sli_id, 'challan_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getSliDocByID($sli_id,$sli_detail_id){
		$this->db->select('*')
            ->from('sli_doc');
		$array = array('sli_id' => $sli_id, 'sli_detail_id' => $sli_detail_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function addDispatchNote($data){
		$dispacth_data = array(
			'method_of_shipment'   		=> $data['method_of_shipment'],
			'sli_id' 					=> $data['sli_id'],
			'account_number' 			=> $data['account_number'],
			'date_of_shipment' 			=> $data['date_of_shipment'],
			'docket_no'   				=> $data['docket_no'],
			'sb_number'   				=> $data['sb_number'],
			'eway_bill'   				=> $data['eway_bill'],
			'payment_terms'   			=> $data['payment_terms'],
			'invoice_no'				=> $data['invoice_no'],
			'invoice_date'   			=> $data['invoice_date']
		);
		
		$this->db->where('challan_id', $data['challan_id']);
		$this->db->update('challan', $dispacth_data);
		
		return true;
	}
	
	public function getPackers() {		
		$this->db->select('*');
		$this->db->from('packer');
		$this->db->where('packer_status', '1');
		$query = $this->db->get();		
		return $query->result_array();		
	}	
	
	public function getChallanFreightCharge($order_id) {		
		$this->db->select('*');
		$this->db->from('challan_product');
		
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$array = array('challan.is_deleted' => 'N', 'challan_product.order_id' => $order_id);	
		$this->db->where($array);
		
		#$this->db->where('order_id', $order_id);
		$this->db->group_by(array('challan_product.challan_id'));
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();		
	}
	
	public function getChallanFreightChargeList($order_id) {		
		$this->db->select('*');
		$this->db->from('challan_product');
		
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');
		$array = array('challan.is_deleted' => 'N', 'challan_product.order_id' => $order_id);	
		$this->db->where($array);
		
		#$this->db->where('order_id', $order_id);
		$this->db->group_by(array('challan_product.challan_id'));
		$query = $this->db->get();		
		return $query->result_array();		
	}
	
	public function checkPendingQty($order_id,$product_id) {		
		$this->db->select('*')
            ->from('order_products');
		$array = array('order_id' => $order_id, 'prod_id' => $product_id);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getBanks() {		
		$this->db->select('*');
		$this->db->from('bank');		
		$query = $this->db->get();
		return $query->result_array();		
	}
	
	public function getChallanFrcTot($challan_id) {		
		$this->db->select('freight_charges, SUM(net_total) as net_total');
		$this->db->from('challan_product');
		$this->db->where('challan_id', $challan_id);
		$query = $this->db->get();
		return $query->row();		
	}
	
	/* public function deleteChallanById($challan_id,$order_id) {		
		$this->db->where('challan_id', $challan_id);
		$this->db->delete('challan');
		
		$this->db->where('challan_id', $challan_id);
		$this->db->delete('challan_product');
		
		$this->db->where('challan_id', $challan_id);
		$this->db->delete('challan_product_gst');
		
		$this->db->where('challan_id', $challan_id);
		$this->db->delete('challan_return_note');
		
		
		$ord=array(			
				'challan_status' 		=> 'P'		
		);		
		$this->db->where('order_id', $order_id);
		$this->db->update('order_customer', $ord);
		
		$ordPro=array(			
				'challan_qty' 		=> 0		
		);		
		$this->db->where('order_id', $order_id);
		$this->db->update('order_products', $ordPro);
		
		return true;		
	} */
	
	public function deleteChallanById($data) {
		$deldata=array(			
				'is_deleted' 			=> 'Y',			
				'deleted_user_id' 		=> $_SESSION['user_id'],			
				'deleted_date' 			=> date('Y-m-d H:i:s'),			
				'deleted_reason' 		=> $data['deleted_reason']		
		);		
		$this->db->where('challan_id', $data['delchallan_id']);
		$this->db->where('order_id', $data['delorder_id']);
		$this->db->update('challan', $deldata);		
		
		$ord=array(			
				'challan_status' 		=> 'P'		
		);		
		$this->db->where('order_id', $data['delorder_id']);
		$this->db->update('order_customer', $ord);
		
		$ordPro=array(			
				'challan_qty' 		=> 0		
		);		
		$this->db->where('order_id', $data['delorder_id']);
		$this->db->update('order_products', $ordPro); 
		
		return true;
	} 
	
	public function getDeleteReason($data) {	
		$this->db->select('*, (SELECT firstname FROM svi_user WHERE user_id = svi_challan.deleted_user_id) as firstname, (SELECT lastname FROM svi_user WHERE user_id = svi_challan.deleted_user_id) as lastname');
		$this->db->from('challan');	
		$array = array('is_deleted' => 'Y', 'order_id' => $data['order_id'], 'challan_id' => $data['challan_id']);
		$this->db->where($array);		
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->row();
	} 
	
	public function addChallanInvoice($data){
		$challanInvoiceInfo  = $this->getChallanInvoice($data['challan_id']);
		if(empty($challanInvoiceInfo->challan_id)){
			$invoice_data=array(
				'challan_id' 						=> $data['challan_id'],			
				'supplier_ref' 						=> $data['supplier_ref'],			
				'other_ref' 						=> $data['other_ref'],			
				'despatched_through' 				=> $data['despatched_through'],			
				'destination' 						=> $data['destination'],			
				'vessel_flight_no' 					=> $data['vessel_flight_no'],			
				'place_of_receipt_by_shipper' 		=> $data['place_of_receipt_by_shipper'],			
				'city_port_of_loading' 				=> $data['city_port_of_loading'],			
				'city_port_of_discharge' 			=> $data['city_port_of_discharge'],			
				'country_id' 						=> $data['country_id'],			
				'country_of_origin_of_goods' 		=> $data['country_of_origin_of_goods'],			
				'country_of_final_destination' 		=> $data['country_of_final_destination'],
				'created_by'						=> $_SESSION['user_id'],				
				'date_added'						=> date('Y-m-d H:i:s')
			);
			
			$this->db->insert('challan_invoice',$invoice_data);
			if($data['challan_id']){
				//$array = array('challan_id' => $data['challan_id']);
				$arrayData = array('invoice_no' => $data['invoice_no'], 'invoice_date' => $data['invoice_date'], 'docket_no' => $data['docket_no']);
				//$this->db->set('invoice_no', $data['invoice_no']);
				$this->db->where('challan_id', $data['challan_id']);
				$this->db->update('challan', $arrayData);
			}
			if($data['challan_id']){
				$array = array('order_id' => $data['order_id']);
				$this->db->set('delivery', $data['terms_of_delivery']);
				$this->db->where($array);
				$this->db->update('order_customer');
			}
		}else{
			
			$invoice_data=array(
				'challan_id' 						=> $data['challan_id'],			
				'supplier_ref' 						=> $data['supplier_ref'],			
				'other_ref' 						=> $data['other_ref'],			
				'despatched_through' 				=> $data['despatched_through'],			
				'destination' 						=> $data['destination'],			
				'vessel_flight_no' 					=> $data['vessel_flight_no'],			
				'place_of_receipt_by_shipper' 		=> $data['place_of_receipt_by_shipper'],			
				'city_port_of_loading' 				=> $data['city_port_of_loading'],			
				'city_port_of_discharge' 			=> $data['city_port_of_discharge'],			
				'country_id' 						=> $data['country_id'],			
				'country_of_origin_of_goods' 		=> $data['country_of_origin_of_goods'],			
				'country_of_final_destination' 		=> $data['country_of_final_destination'],			
				'created_by'						=> $_SESSION['user_id'],
				'update_date_added'					=> date('Y-m-d H:i:s')
			);
			
			$this->db->where('challan_id', $data['challan_id']);
			$this->db->update('challan_invoice', $invoice_data);

			if($data['challan_id']){
				//$array = array('challan_id' => $data['challan_id']);
				$arrayData = array('invoice_no' => $data['invoice_no'], 'invoice_date' => $data['invoice_date'], 'docket_no' => $data['docket_no']);
				//$this->db->set('invoice_no', $data['invoice_no']);
				$this->db->where('challan_id', $data['challan_id']);
				$this->db->update('challan', $arrayData);
			}
			if($data['challan_id']){
				$array = array('order_id' => $data['order_id']);
				$this->db->set('delivery', $data['terms_of_delivery']);
				$this->db->where($array);
				$this->db->update('order_customer');
			}
		}
			
		return true;
	}
	
	public function getChallanInvoice($challan_id){
		$this->db->select('*,(SELECT name FROM svi_country WHERE country_id = svi_challan_invoice.country_id) as country_name, (SELECT name FROM svi_country WHERE country_id = svi_challan_invoice.country_of_final_destination) as country_destination');
		$this->db->from('challan_invoice');	
		$array = array('challan_id' => $challan_id);
		$this->db->where($array);		
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->row();
	}
	
}