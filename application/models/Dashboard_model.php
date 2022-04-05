<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	
	public function getPendingStockList() {
		
		$qrySearch['stock.status']='P';
		
		if(!empty($this->session->userdata('store_id'))){
			$qrySearch['stock.store_id']=$this->session->userdata('store_id');
		}	

		$this->db->select('*, batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date, stock.status as stock_status, stock.user_id as stock_user_id')
            ->from('stock');
			$this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
			$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
			$this->db->join('store', 'store.store_id = stock.store_id', 'left');
			$this->db->join('user', 'user.user_id = stock.user_id', 'left');
			$this->db->where($qrySearch);
			$this->db->order_by('stock.added_datetime', 'DESC');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getRejectStockList() {
		
		$qrySearch['stock.status']='R';
		
		if(!empty($this->session->userdata('store_id'))){
			$qrySearch['stock.store_id']=$this->session->userdata('store_id');
		}	

		$this->db->select('*, batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date, stock.status as stock_status')
            ->from('stock');
			$this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
			$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
			$this->db->join('store', 'store.store_id = stock.store_id', 'left');
			$this->db->where($qrySearch);
			$this->db->order_by('stock.reject_datetime', 'DESC');
			$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getStockBatchDetails($stock_id) {
		
		$this->db->select('*, batch.mfg_date as s_mfg_date, batch.exp_date as s_exp_date')
            ->from('stock');
			$this->db->join('batch', 'batch.batch_id = stock.batch_id', 'left');
			$this->db->join('product', 'product.product_id = batch.product_id', 'left');
			$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
			$this->db->join('store', 'store.store_id = stock.store_id', 'left');
			$this->db->where('stock_id', $stock_id);
			
		return $this->db->get()->row();
	}
	
	public function addStockApprove($stock_id){
		$data = array( 
			'status'      		=> 'A', 
			'approved_by' 		=> $_SESSION['user_id'],
			'approved_datetime' => date('Y-m-d H:i:s')
		);

		$this->db->where('stock_id', $stock_id);
		$this->db->update('stock', $data);
		
		return true;
	}
	
	public function getOrderList() {		
		$this->db->select('*,(SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount, (SELECT SUM(amount) FROM svi_order_payment_advice WHERE svi_order_payment_advice.order_id = svi_order_customer.order_id AND svi_order_payment_advice.status = "A") as total_advice_payment')
            ->from('order_customer');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');		
		if($_SESSION['group_id'] > 1){ 
			$array = array('order_customer.created_by' => $_SESSION['user_id']);
			$this->db->where($array);
		}		
		$this->db->order_by('order_id',"DESC");
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getOrderProductById($order_id,$quotation_id) {
		$this->db->select('*,(SELECT SUM(qty) FROM svi_challan_product WHERE order_id = svi_order_products.order_id AND product_id = svi_order_products.prod_id) as challan_qty')
            ->from('order_products');
		$array = array('order_id' => $order_id, 'quotation_id' => $quotation_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function stockReject($stock_id){
		$data = array( 
			'status'      		=> 'R', 
			'reject_by' 		=> $_SESSION['user_id'],
			'reject_datetime' => date('Y-m-d H:i:s')
		);

		$this->db->where('stock_id', $stock_id);
		$this->db->update('stock', $data);		
		return true;
	}
	
	public function stockDel($stock_id){
		$this->db->where('stock_id', $stock_id);
		$this->db->delete('stock');		
		return true;
	}
	
	public function getStore(){
	    $this->db->select('*')
            ->from('store');
			$query = $this->db->get();		
		return $query->result_array();
	}
	
	/* public function getTotalChallan(){
	    $this->db->select('*, (SELECT SUM(net_total) FROM svi_challan_product WHERE challan_id = svi_challan.challan_id) as net_amount, (SELECT currency_id FROM svi_order_customer WHERE order_id = svi_challan.order_id) as currency_id, (SELECT freight_charges FROM svi_challan_product WHERE challan_id = svi_challan.challan_id GROUP BY challan_id) as freight_charges')
            ->from('challan');		
            ->from('challan');		
		if($_SESSION['group_id'] > 1){
			$array = array('challan.is_deleted' => 'N', 'challan.user_id' => $_SESSION['user_id']);
			$this->db->where($array);
		}
			$query = $this->db->get();
		return $query->result_array();
	} */
	
	public function getTotalChallan(){	    
		$query1 = $this->db->query('SELECT SUM(cp.net_total+freight_charges) AS net_amount_freight, SUM((SELECT freight_charges FROM svi_challan_product WHERE challan_id = cp.challan_id GROUP BY challan_id)) AS freight_charges, oc.currency_id FROM svi_challan_product cp, svi_order_customer oc, svi_challan c WHERE cp.order_id = oc.order_id AND c.challan_id=cp.challan_id AND c.is_deleted = "N" GROUP BY oc.currency_id');		
		$netTotals = $query1->result_array();	
		return $netTotals;
	}
	
	public function getTotalChallanGst(){		
		$query2 = $this->db->query('SELECT SUM(cg.gst_total_amount) AS gst_amount FROM svi_challan c, svi_challan_product_gst cg WHERE c.challan_id = cg.challan_id AND c.is_deleted="N"');
		
		$gstTotals = $query2->row()->gst_amount;		
		return $gstTotals ;
	}
	
	
	public function getTotalQuotation(){
	    $this->db->select('*,(SELECT SUM(net_amount) FROM svi_quote_products WHERE quotation_id = svi_quote_customer.id) as net_amount')
            ->from('quote_customer');
		$this->db->where('quote_customer.is_deleted', 'N');
		$this->db->where('quote_customer.order_id', null);
		if($_SESSION['group_id'] > 1){ 
			$array = array('quote_customer.created_by' => $_SESSION['user_id']);
			$this->db->where($array);
		}
			$query = $this->db->get();
		return $query->result_array();
	} 
	
	/* public function getTotalQuotation(){
	    $query2 = $this->db->query('SELECT (SELECT SUM((qc.freight_charge/qp.net_amount)*qp.net_amount)) as perProFrch FROM svi_quote_customer qc, svi_quote_products qp WHERE qc.id = qp.quotation_id AND qc.currency_id = "1"');		
		return $query2->result_array();
	} */
	
	
	public function getTotalReturns(){
	    $this->db->select('*, (SELECT currency_id FROM svi_order_customer WHERE order_id = svi_challan_product.order_id) as currency_id, ((rate - discount) * return_qty) as return_net_total')
            ->from('challan_product');			
		$this->db->join('challan', 'challan.challan_id = challan_product.challan_id', 'left');	
		$this->db->where('challan.is_deleted', 'N');
		$this->db->where('challan_product.return_qty != 0');
		if($_SESSION['group_id'] > 1){
			$array = array('challan_product.return_user_id' => $_SESSION['user_id']);
			$this->db->where($array);
		}
		//$this->db->group_by('currency_id'); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	
	public function getTotalCustomers(){
	    $this->db->select('*')
            ->from('customer');
		if($_SESSION['group_id'] > 1){
			$array = array('customer.user_id' => $_SESSION['user_id']);
			$this->db->where($array);
		}
			$query = $this->db->get();
		return $query->result_array();
	}
	
	public function stockUpdate($data){
		$stockData = array( 
			'qty'      		=> $data['qty'],
			'store_id' 		=> $data['store_id'],
			'user_id' 		=> $_SESSION['user_id'],
			'status' 		=> 'P',
			'added_datetime' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('stock_id', $data['stock_id']);
		$this->db->update('stock', $stockData);		
		return true;
	}
	
	public function getAdvices(){
		$this->db->select('*')
            ->from('order_payment_advice');
		$this->db->join('bank', 'bank.id = order_payment_advice.bank_id', 'left');
		$this->db->join('currency', 'currency.id = order_payment_advice.currency_id', 'left');
		$array = array('order_payment_advice.status' => 'P');
		$this->db->where($array);
		$this->db->order_by('order_payment_advice.date_added',"DESC");
		$query = $this->db->get();	
		return $query->result_array();	
	}
	
	public function getAdvicesReject(){
		$this->db->select('*')
            ->from('order_payment_advice');
		$this->db->join('bank', 'bank.id = order_payment_advice.bank_id', 'left');
		$this->db->join('currency', 'currency.id = order_payment_advice.currency_id', 'left');
		$array = array('order_payment_advice.status' => 'R');
		$this->db->where($array);
		$this->db->order_by('order_payment_advice.rejected_datetime',"DESC");
		$query = $this->db->get();	
		return $query->result_array();	
	}	
	
	public function addAdviceApprove($advice_id){
		
		$adviceData = array( 			
			'status' 			=> 'A',
			'approved_by' 		=> $_SESSION['user_id'],
			'approved_datetime' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('payment_advice_id', $advice_id);
		$this->db->update('order_payment_advice', $adviceData);		
		return true;
	}	
	
	public function adviceReject($data){
		$adviceData = array( 			
			'status' 			=> 'R',
			'rejected_by' 		=> $_SESSION['user_id'],
			'rejected_datetime' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('payment_advice_id', $data['advice_id']);
		$this->db->update('order_payment_advice', $adviceData);		
		return true;
	}
	
	public function adviceDel($advice_id){
		$this->db->where('payment_advice_id', $advice_id);
		$this->db->delete('order_payment_advice');		
		return true;
	}
	
	public function getTotalCustomerByCountry(){
		$this->db->select('iso_code_2, COUNT(*) AS total')
            ->from('customer');		
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		#$this->db->join('order_customer', 'order_customer.customer_id = customer.customer_id', 'left');
		#$this->db->join('quote_customer', 'quote_customer.customer_id = customer.customer_id', 'left');
		
		/* $array = array('customer.status' => 'R');
		$this->db->where($array);
		*/	
		
		if($_SESSION['group_id'] > 1){
			$array = array('customer.user_id' => $_SESSION['user_id']);
			$this->db->where($array);
		}
		
		 $this->db->group_by('customer.country_id'); 
		$query = $this->db->get();	
		return $query->result_array();	
	}
	
	public function getTotalQuotationByCountry($countryCode){
		$this->db->select('COUNT(*) AS quotation_pending')
            ->from('quote_customer');		
		$this->db->join('customer', 'customer.customer_id = quote_customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$array = array('country.iso_code_2' => $countryCode, 'quote_customer.order_id' => null, 'quote_customer.is_deleted' => 'N');
		$this->db->where($array);
		
		if($_SESSION['group_id'] > 1){ 
			$array1 = array('quote_customer.created_by' => $_SESSION['user_id']);
			$this->db->where($array1);
		}
		
		 $this->db->group_by('customer.country_id'); 
		$query = $this->db->get();			
		return $query->row();	
	}
	
	public function getTotalOrderByCountry($countryCode){
		$this->db->select('COUNT(*) AS pending_order')
            ->from('order_customer');		
		$this->db->join('customer', 'customer.customer_id = order_customer.customer_id', 'left');
		$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		$array = array('country.iso_code_2' => $countryCode, 'order_customer.challan_status' => 'P');
		$this->db->where($array);
		
		if($_SESSION['group_id'] > 1){ 
			$array1 = array('order_customer.created_by' => $_SESSION['user_id']);
			$this->db->where($array1);
		}
		
		$this->db->group_by('customer.country_id'); 
		$query = $this->db->get();		
		return $query->row();	
	}
	
	public function getTotalIncompleteOrders(){
	    $this->db->select('order_id')
            ->from('challan');			
		if($_SESSION['group_id'] > 1){
			$array = array('challan.is_deleted' => 'N','challan.user_id' => $_SESSION['user_id']);
			$this->db->where($array);
		}		
		$this->db->group_start();
		$this->db->where('method_of_shipment', '')				  
				  ->or_where('docket_no', '')
				  ->or_where('invoice_no', '')
				  ->or_where('sb_number', '');				  				 
		$this->db->group_end();	
		
		$query = $this->db->get();
		$lstQry = $this->db->last_query();
		//$order_ids = $query->result_array();		
		//$orderIds = array_column($order_ids, 'order_id');
		
		$this->db->select('*, (SELECT SUM(net_amount) FROM svi_order_products WHERE order_id = svi_order_customer.order_id) as net_amount, (SELECT SUM(amount) FROM svi_order_payment_advice WHERE svi_order_payment_advice.order_id = svi_order_customer.order_id AND svi_order_payment_advice.status = "A") as total_advice_payment')
            ->from('order_customer');
		
		if($_SESSION['group_id'] > 1){
			$array = array('order_customer.user_id' => $_SESSION['user_id']);
			$this->db->where($array);			
		}
		
		$this->db->where("order_id IN ($lstQry)");
		
		/* if(!empty($orderIds)){			
			$this->db->where_in('order_customer.order_id',$orderIds);
		} */
		 
		$query1 = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query1->result_array();
	}
	
	
}