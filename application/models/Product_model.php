<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Product_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}	
	
	public function addProduct($data,$photo,$product_pdf) {
		
		$product_data = array(
			'product_name'   	=> trim($data['product_name']),
			'model'				=> trim($data['model']),
			'description'   	=> trim($data['description']),
			'category_id'		=> $data['category_id'],
			'cost_price'   		=> $data['cost_price'],
			'pack_unit'   		=> $data['pack_unit'],
			'hsn'   			=> $data['hsn'],
			'gst'   			=> $data['gst'],
			'mrp'   			=> $data['mrp'],
			'photo'   			=> $photo,
			'product_pdf'   	=> $product_pdf,
			'create_user_id'   	=> $_SESSION['user_id'],
			'date_time' 		=> date('Y-m-j H:i:s')
		);
		
		$this->db->insert('product', $product_data);
		$product_id = $this->db->insert_id();
		
		#INR
		$product_price_inr = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_1'],
			'min_price'   		=> $data['min_price_inr'],
			'currency_id'   		=> '1'
			
		);
		$this->db->insert('product_price', $product_price_inr);
		
		#USD
		$product_price_usd = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_2'],
			'min_price'   		=> $data['min_price_usd'],
			'currency_id'   		=> '2'
			
		);
		$this->db->insert('product_price', $product_price_usd);
		
		#EUR
		$product_price_eur = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_3'],
			'min_price'   		=> $data['min_price_eur'],
			'currency_id'   		=> '3'
			
		);
		$this->db->insert('product_price', $product_price_eur);
		
		#GBP
		$product_price_gbp = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_4'],
			'min_price'   		=> $data['min_price_gbp'],
			'currency_id'   		=> '4'
			
		);
		$this->db->insert('product_price', $product_price_gbp);
		$dateTime=date('Y-m-j H:i:s');
		$certificates=$this->input->post('certificate_id');
		if(!empty($certificates)){
			foreach($certificates as $certificate){
				$certificateArr=Array(
					'product_id'   		=> $product_id,
					'certificate_id'   	=> $certificate,
					'date_updated'   	=> $dateTime
				);
				$this->db->insert('product_certificate', $certificateArr);
			}	
		}
				
		return true;		
	}
	
	public function editProduct($data,$photo,$product_pdf) {		
		$product_data = array(
			'product_name'   	=> trim($data['product_name']),
			'model'				=> trim($data['model']),
			'description'   	=> trim($data['description']),
			'category_id'		=> $data['category_id'],
			'cost_price'   		=> $data['cost_price'],
			'pack_unit'   		=> $data['pack_unit'],
			'hsn'   			=> $data['hsn'],
			'gst'   			=> $data['gst'],
			'mrp'   			=> $data['mrp'],
			'photo'   			=> $photo,
			'product_pdf'   	=> $product_pdf,
			'modifi_user_id'   	=> $_SESSION['user_id'],
			'modifi_datetime' 	=> date('Y-m-j H:i:s')
		);
		
		$this->db->where('product_id', $data['product_id']);
		$this->db->update('product', $product_data);
		
		$product_id = $data['product_id'];
		
		
		$this->db->where('product_id', $product_id);
		$this->db->delete('product_price'); 
		
		#INR
		$product_price_inr = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_1'],
			'min_price'   		=> $data['min_price_inr'],
			'currency_id'   		=> '1'
			
		);
		$this->db->insert('product_price', $product_price_inr);
		
		#USD
		$product_price_usd = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_2'],
			'min_price'   		=> $data['min_price_usd'],
			'currency_id'   		=> '2'
			
		);
		$this->db->insert('product_price', $product_price_usd);
		
		#EUR
		$product_price_eur = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_3'],
			'min_price'   		=> $data['min_price_eur'],
			'currency_id'   		=> '3'
			
		);
		$this->db->insert('product_price', $product_price_eur);
		
		#GBP
		$product_price_gbp = array(
			'product_id'   		=> $product_id,
			'price'   		=> $data['price_4'],
			'min_price'   		=> $data['min_price_gbp'],
			'currency_id'   		=> '4'
			
		);
		
		$this->db->insert('product_price', $product_price_gbp);

		$this->db->where('product_id', $product_id);
		$this->db->delete('product_certificate');
		
		$dateTime=date('Y-m-j H:i:s');
		$certificates=$this->input->post('certificate_id');
		if(!empty($certificates)){
			foreach($certificates as $certificate){
				$certificateArr=Array(
					'product_id'   		=> $product_id,
					'certificate_id'   	=> $certificate,
					'date_updated'   	=> $dateTime
				);				
				$this->db->insert('product_certificate', $certificateArr);				
			}	
		}
	}
	

	public function getProductsByNameModel($data) {
		 $searchArr=array();
		 if(!empty($data['product_name'])){
			$searchArr['product_name']=trim($data['product_name']);
		 }
		 if(!empty($data['model'])){
			$searchArr['model']=trim($data['model']);
		 }
		 $this->db->select('*')
            ->from('product');
		 $this->db->where($searchArr);	
			$query = $this->db->get();
			
		return $query->row();
	}
	
	public function getProductsByNameModelId($data,$product_id) {
		 $searchArr=array();
		 if(!empty($data['product_name'])){
			$searchArr['product_name']=trim($data['product_name']);
		 }
		 if(!empty($data['model'])){
			$searchArr['model']=trim($data['model']);
		 }
		 $this->db->select('*')
            ->from('product');
		 $this->db->where($searchArr);
	     $this->db->where('product_id != ',$product_id);
			$query = $this->db->get();
			
		return $query->row();
	}
	
	 public function getProducts($limit, $start,$data,$fnDate=Array()) {
		
		$qryArr=Array();

		if(!empty($data['category_id'])){
			$qryArr['sp.category_id']=$data['category_id'];
		}
		
		if(!empty($data['model'])){
			$qryArr['sp.product_id']=trim($data['model']);
		}

		if(!empty($data['hsn'])){
			$qryArr['hsn']=trim($data['hsn']);
		}
		$fnQry='';
		if(!empty($fnDate['fyStDt'])){
			$fnQry .=" and sop.date_added BETWEEN '".$fnDate['fyStDt']."' AND '".$fnDate['fyEndDt']."'";
		}
		
		$totalSell='';
		#For product search by country
		if(!empty($data['country_id'])){
			$totalSell=" ,(SELECT SUM(qty) FROM svi_order_products sop WHERE sop.order_id IN (SELECT oc.order_id FROM svi_order_customer oc LEFT JOIN svi_customer sc ON sc.customer_id=oc.customer_id WHERE sc.country_id=".$data['country_id'].") AND prod_id=sp.product_id $fnQry ) AS total_sold ";
		}else{
			$totalSell=" ,(SELECT SUM(sop.qty) FROM svi_order_products sop WHERE sop.prod_id=sp.product_id $fnQry) AS total_sold ";
		}
		

		$this->db->select("sp.*,category.* $totalSell")
            ->from('product sp');
		$this->db->join('category', 'category.category_id = sp.category_id', 'left');
		//$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		//$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		
        $this->db->where($qryArr);

		#For product search by country
		if(!empty($data['country_id'])){
			$this->db->where("sp.product_id IN (SELECT DISTINCT sop.prod_id FROM svi_order_products sop WHERE sop.order_id IN (SELECT oc.order_id FROM svi_order_customer oc LEFT JOIN svi_customer sc ON sc.customer_id=oc.customer_id WHERE sc.country_id=".$data['country_id']."))");
		}

		if(!empty($data['product_name'])){
			$this->db->group_start();
			$this->db->like('product_name',trim($data['product_name']));
			$this->db->or_like('description',trim($data['product_name']));
			$this->db->group_end();			
		}
		
        $this->db->limit( $limit, $start );	
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by("product_id", "desc");
		}	
		#$this->db->order_by("total_sold", "desc");
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalProducts($data,$fnDate=Array()) {
		$qryArr=Array();

		if(!empty($data['category_id'])){
			$qryArr['sp.category_id']=$data['category_id'];
		}
		
		if(!empty($data['model'])){
			$qryArr['sp.product_id']=trim($data['model']);
		}

		if(!empty($data['hsn'])){
			$qryArr['hsn']=trim($data['hsn']);
		}
		$fnQry='';
		if(!empty($fnDate['fyStDt'])){
			$fnQry .=" and sop.date_added BETWEEN '".$fnDate['fyStDt']."' AND '".$fnDate['fyEndDt']."'";
		}
		
		$totalSell='';
		#For product search by country
		if(!empty($data['country_id'])){
			$totalSell=" ,(SELECT SUM(qty) FROM svi_order_products sop WHERE sop.order_id IN (SELECT oc.order_id FROM svi_order_customer oc LEFT JOIN svi_customer sc ON sc.customer_id=oc.customer_id WHERE sc.country_id=".$data['country_id'].") AND prod_id=sp.product_id $fnQry ) AS total_sold ";
		}else{
			$totalSell=" ,(SELECT SUM(sop.qty) FROM svi_order_products sop WHERE sop.prod_id=sp.product_id $fnQry) AS total_sold ";
		}
		

		$this->db->select("sp.*,category.* $totalSell")
            ->from('product sp');
		$this->db->join('category', 'category.category_id = sp.category_id', 'left');
		//$this->db->join('country', 'country.country_id = customer.country_id', 'left');
		//$this->db->join('customer', 'order_customer.customer_id = customer.customer_id', 'left');
		
        $this->db->where($qryArr);

		#For product search by country
		if(!empty($data['country_id'])){
			$this->db->where("sp.product_id IN (SELECT DISTINCT sop.prod_id FROM svi_order_products sop WHERE sop.order_id IN (SELECT oc.order_id FROM svi_order_customer oc LEFT JOIN svi_customer sc ON sc.customer_id=oc.customer_id WHERE sc.country_id=".$data['country_id']."))");
		}

		if(!empty($data['product_name'])){
			$this->db->group_start();
			$this->db->like('product_name',trim($data['product_name']));
			$this->db->or_like('description',trim($data['product_name']));
			$this->db->group_end();			
		}		
		$query = $this->db->get();
			
		return $query->num_rows();
	}
	
	public function getPackUnit() {
		
		 $this->db->select('*')
            ->from('packunit');
			$query = $this->db->get();
			
		return $query->result_array();
	}
	
	public function getPackUnitByID($id) {
		
		 $this->db->select('*')
            ->from('packunit');
		 $this->db->where('id', $id);
			$query = $this->db->get();
			
		return $query->row();
	}
	
	public function getProductById($product_id) {
		
		$this->db->select('*')
            ->from('product');
		$this->db->join('packunit', 'packunit.id = product.pack_unit', 'left');
		$this->db->where('product.product_id', $product_id);	
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getProductPriceById($product_id) {
		
		$this->db->select('*')
            ->from('product_price');
		$this->db->where('product_id', $product_id);	
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getProductCertificateById($product_id) {
		
		$this->db->select('*')
            ->from('product_certificate');
		$this->db->join('certificates', 'certificates.certificate_id = product_certificate.certificate_id', 'left');
		$this->db->where('product_id', $product_id);	
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCategories(){
		$this->db->select('*')
            ->from('category');
        $this->db->order_by("name", "ASC");
			$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCategoryByID($id){
		$this->db->from('category');
		$this->db->where('category_id', $id);
		return $this->db->get()->row();
	}
	
	public function addCategory($data){
		$name = $data['category_name'];
		$expiry_year = $data['expiry_year'];
				
		$this->db->select('name');
		$this->db->from('category');
		$this->db->where('name', $name);

		$catName = $this->db->get()->row('name');
		$data = array();
		if(empty($catName)){
			$category_data = array(
				'name'   		=> $name,
				'expiry_year'  => $expiry_year
			);
			$this->db->insert('category', $category_data);
			$category_id = $this->db->insert_id();
			
			$data = 'success';
			$data = array(
				'id' => $category_id,
				'name' => $name,
			);
		} else {
			$data = array(
				'error' => 'Category already exists.'
			);
		}
		return $data;
	}
	
	public function updateCategory($data){
		$name = $data['category_name'];
		$expiry_year = $data['expiry_year'];
				
		$cate_data = array(
			'name'   	=> $name,
			'expiry_year'		=> $expiry_year
		);
		
		$this->db->where('category_id', $data['category_id']);
		$this->db->update('category', $cate_data);
		return true;
	}
	
    public function addCertificate($data,$file){
		
		$certificate_data = array(
			'certificate_name'   	=> $data['certificate_name'],
			'path'   				=> $file,
			'date_time'   			=> date('Y-m-j H:i:s'),			
			'expire_date_time'   	=> $data['certificate_expiry_date']
		);
		
		
		$this->db->insert('certificates', $certificate_data);
		$certificate_id = $this->db->insert_id();
		unset($_SESSION['file_name']);
		
		$certificateInfo = $this->getCertificateByID($certificate_id);
		
		$result = array(
			'id' => $certificate_id,
			'name' => $certificateInfo->certificate_name,
			'date_time' => dateFormat('d-m-Y', $certificateInfo->expire_date_time)
		);
		
		return $result;
	}
	
	public function getCertificates(){
		$this->db->select('*')
            ->from('certificates');
			$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCertificateByID($id){
		$this->db->from('certificates');
		$this->db->where('certificate_id', $id);
		return $this->db->get()->row();
	}
	
	public function getProductInstock($product_id,$store_id){
		$currentDate=date('Y-m-d 00:00:00.000000');
		
		$this->db->select("SUM(ss.qty) as stock_qty,(SELECT SUM(scp.qty) FROM svi_challan_product scp , `svi_batch` `sb`, svi_challan sc WHERE scp.store_id = $store_id AND scp.product_id = $product_id AND sb.exp_date >= '".$currentDate."' AND scp.batch_id = `sb`.`batch_id` AND sc.challan_id=scp.challan_id AND sc.is_deleted='N') as out_qty,(SELECT IFNULL(SUM(scp.return_qty),0) FROM svi_challan_product scp , `svi_batch` `sb`, svi_challan sc WHERE scp.store_id = $store_id AND scp.product_id = $product_id AND sb.exp_date >= '".$currentDate."' AND scp.batch_id = `sb`.`batch_id` AND sc.challan_id=scp.challan_id AND sc.is_deleted='N') as in_qty")->from('stock ss,svi_batch sb');

		$array = array('ss.store_id' => $store_id, 'ss.product_id' => $product_id, 'ss.status' => 'A');
		$this->db->where($array);
		$this->db->where("sb.exp_date>='".$currentDate."'");
		$this->db->where("ss.batch_id=sb.batch_id");
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getLastTradePrice($product_id,$customer_id){
		/* $this->db->select('*,order_products.date_added as op_date_added')
            ->from('order_products');
		$this->db->join('order_customer', 'order_customer.customer_id = order_products.customer_id', 'left');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$arr = array('order_products.prod_id' => $product_id, 'order_products.customer_id' => $customer_id);
		$this->db->where($arr);
		$this->db->order_by("order_products.date_added", "desc");	
		$query = $this->db->get(); */ 
		
		$this->db->select('*,quote_products.date_added as op_date_added')
            ->from('quote_products');
		$this->db->join('quote_customer', 'quote_customer.customer_id = quote_products.customer_id', 'left');
		$this->db->join('currency', 'currency.id = quote_customer.currency_id', 'left');
		$arr = array('quote_products.prod_id' => $product_id, 'quote_products.customer_id' => $customer_id, 'quote_products.rate >' => 0);
		$this->db->where($arr);
		$this->db->order_by("quote_products.date_added", "desc");	
		$query = $this->db->get();
		
		return $query->row();
	}
	
	public function getLowestTradePrice($product_id,$customer_id){
		
		$this->db->select('*,order_products.date_added as op_date_added')
            ->from('order_products');
		$this->db->join('customer', 'customer.customer_id = order_products.customer_id', 'left');
		$this->db->join('order_customer', 'order_customer.customer_id = order_products.customer_id', 'left');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$where = "order_products.prod_id=$product_id AND svi_customer.country_id = (SELECT country_id FROM `svi_customer` Where customer_id = $customer_id) AND order_products.ltp > '0'";
		$this->db->where($where);
		$this->db->order_by("order_products.ltp", "ASC");
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->row();
	}
	
	public function getHightestTradePrice($product_id,$customer_id){
		
		$this->db->select('*,order_products.date_added as op_date_added')
            ->from('order_products');
		$this->db->join('customer', 'customer.customer_id = order_products.customer_id', 'left');
		$this->db->join('order_customer', 'order_customer.customer_id = order_products.customer_id', 'left');
		$this->db->join('currency', 'currency.id = order_customer.currency_id', 'left');
		$where = "order_products.prod_id=$product_id AND svi_customer.country_id = (SELECT country_id FROM `svi_customer` Where customer_id = $customer_id) AND order_products.ltp > '0'";
		$this->db->where($where);
		$this->db->order_by("order_products.ltp", "DESC");
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		return $query->row();
	}
	public function getProductsRecords(){
		$this->db->select('p.*,c.name as category_name');
		$this->db->from('product p');
		$this->db->join('category c','c.category_id=p.category_id','LEFT');
		$query = $this->db->get();
		//print $this->db->last_query();exit;
		return $query->result_array();	

		
	}
}
