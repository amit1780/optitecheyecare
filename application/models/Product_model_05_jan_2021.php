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
	
	 public function getProducts($limit, $start,$data) {
		
		$qryArr=Array();

		if(!empty($data['category_id'])){
			$qryArr['product.category_id']=$data['category_id'];
		}
		
		if(!empty($data['model'])){
			$qryArr['product.product_id']=trim($data['model']);
		}

		if(!empty($data['hsn'])){
			$qryArr['hsn']=trim($data['hsn']);
		}
		
		$this->db->select('*')
            ->from('product');
		$this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->where($qryArr);

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
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result_array();
	}
	
	public function getTotalProducts($data) {
		$qryArr=Array();

		if(!empty($data['category_id'])){
			$qryArr['product.category_id']=$data['category_id'];
		}
		
		if(!empty($data['model'])){
			$qryArr['product.product_id']=trim($data['model']);
		}

		if(!empty($data['hsn'])){
			$qryArr['hsn']=trim($data['hsn']);
		}
		
		$this->db->select('*')
            ->from('product');
		$this->db->join('category', 'category.category_id = product.category_id', 'left');	
        $this->db->where($qryArr);

		if(!empty($data['product_name'])){
			$this->db->like('product_name',trim($data['product_name']));
			$this->db->or_like('description',trim($data['product_name'])); 
		}
       $this->db->limit( $limit, $start );	
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by("product_id", "desc");
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
		$this->db->select('SUM(qty) as stock_qty, (SELECT SUM(qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) as out_qty, (SELECT SUM(return_qty) FROM svi_challan_product cp LEFT JOIN svi_challan sc ON (cp.challan_id=sc.challan_id) WHERE sc.is_deleted="N" AND cp.product_id = svi_stock.product_id AND cp.store_id = svi_stock.store_id) as in_qty')
            ->from('stock');
		$array = array('store_id' => $store_id, 'product_id' => $product_id, 'status' => 'A');
		$this->db->where($array);
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
	
}
