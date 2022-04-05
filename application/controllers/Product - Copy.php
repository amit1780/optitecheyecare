<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	
		
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
			$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('product_model');
		$this->load->language('language_lang');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
	}
	
	public function index()
	{
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Product List', '/product');
		
		$data['page_heading'] = $this->lang->line('product_list_heading');
	    
	
		$data['success'] = $this->session->success;
		$data['form_action']= 'product';

		$data['categories'] = array();
		$categories = $this->product_model->getCategories();
		foreach($categories as $category){
			$data['categories'][] = array(
				'category_id' 	=> $category['category_id'],
				'name' 			=> $category['name']
			);
		}
		
		if($this->input->get('per_page')){
			$pageUrl = '&per_page='.$this->input->get('per_page');
		} else {
			$pageUrl = '';
		}
			
		if($this->input->get('order') == 'ASC'){
			$order = '&order=DESC';
		} else {
			$order = '&order=ASC';
		}
		
		$filtered_array = array_filter(array_unique($this->input->get())); 
		unset($filtered_array['sort']);
		unset($filtered_array['order']);		
		$url = http_build_query($filtered_array);
		if($url){
			$url = '&'.$url;
		}
		
		$data['product_name_sort'] = site_url().'/product/index?sort=product_name'. $order . $pageUrl .$url;
		$data['model_sort'] = site_url().'/product/index?sort=model'. $order . $pageUrl .$url;
		$data['category_name_sort'] = site_url().'/product/index?sort=name'. $order . $pageUrl .$url;
		
		/* Pagination */
		$total_rows = $this->product_model->getTotalProducts($this->input->get());
		$per_page = 25;
		$config['base_url'] = site_url().'/product/index';		
		$config['per_page'] = $per_page;		
		$config['total_rows'] = $total_rows;		
		$this->pagination->initialize($config);
		$page = 1;
		/*if(!empty($this->uri->segment(3,0))){
			$page = $this->uri->segment(3,0);
		}*/
		
		if(!empty($this->input->get('per_page'))){
			$page = $this->input->get('per_page');
		}
		$start = ($page-1)*$per_page;
		$pagination = $this->pagination->create_links();
		
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$data['pagination'] = '<p style="margin-top: 10px;">We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';
			
		}		
		/* Pagination */
		
		$data['products'] = array();
		$products = $this->product_model->getProducts($per_page, $start,$this->input->get());
		foreach($products as $product){
			
			//$category = $this->product_model->getCategoryByID($product['category_id']);		
			
			$data['products'][] = array(
				'product_id' 	=> $product['product_id'],
				'name' 			=> $product['product_name'],
				'model' 		=> $product['model'],
				'cost_price' 	=> $product['cost_price'],
				'pack_unit' 	=> $product['pack_unit'],
				'hsn' 			=> $product['hsn'],
				'gst' 			=> $product['gst'],
				'mrp' 			=> $product['mrp'],
				'date_time' 	=> $product['date_time'],
				'category_name' => $product['name'],
				'description' 	=> $product['description']
			);
		}
		
		$this->load->view('common/header');
		$this->load->view('product/product_list', $data);
		$this->load->view('common/footer');
		
		unset($_SESSION['success']);
	}
	
	protected function getPostFields(){
		$data=Array();
		foreach ($this->input->post() as $name => $value){
			$data[$name]=$value;
		}
		return $data;
	}
	
	public function addProduct() {
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Product', '/addProduct');
		
		
		$data=$this->getPostFields();
		
		$data['page_heading'] = "Add Product";
		
		$data['title'] = $data['heading_title'];
		$data['form_action']='addProduct';

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('product_name', 'Product name', 'required');
		
		$data['categories'] = array();
		$categories = $this->product_model->getCategories();
		$data['pack_units'] = $this->product_model->getPackUnit();
		foreach($categories as $category){
			$data['categories'][] = array(
				'category_id' 	=> $category['category_id'],
				'name' 			=> $category['name']
			);
		}
		
		$data['certificates'] = array();
		$certificates = $this->product_model->getCertificates();
		
		foreach($certificates as $certificate){
			$data['certificates'][] = array(
				'certificate_id' 	=> $certificate['certificate_id'],
				'certificate_name' 			=> $certificate['certificate_name'],
				'date_time' 			=> $certificate['date_time'],
				'expire_date_time' 			=> $certificate['expire_date_time']
			);
		}
		
		if ($this->form_validation->run() == false) {			
						
			$this->load->view('common/header');
			$this->load->view('product/product_form', $data);
			$this->load->view('common/footer');
			
			
		} else {			
			
			if ($this->input->post()) {
				$product = $this->product_model->getProductsByNameModel($this->input->post());				
				if(!empty($product->product_id)){
					
					$data['errorMsg']="Product <b>$data[product_name]</b> with model <b>$data[model]</b> already exists";
					$this->load->view('common/header');
					$this->load->view('product/product_form', $data);
					$this->load->view('common/footer');
					return false;
				}
				#upload for Product Photo
				if(!empty($_FILES['photo']['name'])){
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name'] = $_FILES['photo']['name'];
					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('photo')){
						$uploadData = $this->upload->data();						
						$photo = $config['upload_path'].$uploadData['file_name'];
					}else{
						$photo = '';
					}					
				}else{
					$photo = '';
				}
				
				#upload for Product Pdf
				if(!empty($_FILES['product_pdf']['name'])){
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'pdf';
					$config['file_name'] = $_FILES['product_pdf']['name'];
					
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('product_pdf')){
						$uploadData = $this->upload->data();
						$product_pdf = $config['upload_path'].$uploadData['file_name'];
					}else{
						$product_pdf = '';
					}
				}else{
					$product_pdf = '';
				}
								
				$this->product_model->addProduct($this->input->post(),$photo,$product_pdf);
				$_SESSION['success']      = "Success: You have Added Product";
				redirect('/product');
				
			}
		}
	}
	
	public function ajaxGetCertificateBuyId() {
		$certificate_id = $this->input->post('certificate_id');
		
		$certificates = $this->product_model->getCertificateByID($certificate_id);
		
		echo json_encode($certificates);
	}
	
	public function addCategory() {
		$category_data = $this->input->post();		
		$result = $this->product_model->addCategory($category_data);
		echo json_encode($result);
	}
	
	public function categoryList() {
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Category List', '/categoryList');
		$data['page_heading'] = "Category List";
		$data['success'] = $this->session->success;
		
		$data['categories'] = $this->product_model->getCategories();
		
		$this->load->view('common/header');
		$this->load->view('product/category_list', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function editCategory($category_id){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Category List', '/categoryList');
		
		$data['page_heading'] = "Category Edit";
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('category_name', 'Category name', 'required');
		
		if ($this->form_validation->run() == false) {			
				
			$data['categoryInfo'] = $this->product_model->getCategoryByID($category_id);
			
			$this->load->view('common/header');
			$this->load->view('product/category_form', $data);
			$this->load->view('common/footer');			
			
		} else {
			$category_data = $this->input->post();
			$result = $this->product_model->updateCategory($category_data);
			$_SESSION['success']      = "Success: You have Updated category.";
			redirect('/categoryList');
		}		
	}

		
	public function editProduct($product_id) {
	    
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Product List', '/product');
		$data['page_heading'] = "Edit Product";
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['categories'] = array();
		$categories = $this->product_model->getCategories();
		foreach($categories as $category){
			$data['categories'][] = array(
				'category_id' 	=> $category['category_id'],
				'name' 			=> $category['name']
			);
		}
		
		$data['certificates '] = array();
		$certificates = $this->product_model->getCertificates();
		$data['pack_units'] = $this->product_model->getPackUnit();
		foreach($certificates as $certificate){
			$data['certificates'][] = array(
				'certificate_id' 	=> $certificate['certificate_id'],
				'certificate_name' 			=> $certificate['certificate_name'],
				'date_time' 			=> $certificate['date_time'],
				'expire_date_time' 			=> $certificate['expire_date_time']
			);
		}		
		
		
		$productInfo = $this->product_model->getProductById($product_id);
		
		$productPriceInfo = $this->product_model->getProductPriceById($product_id);
		$productCertificateInfo = $this->product_model->getProductCertificateById($product_id);
		//print_r($productCertificateInfo);
		
		$certificateArr=array();
		$i=0;
		foreach($productCertificateInfo as $pcInfo){
			$certificateArr[$i]=$pcInfo['certificate_id'];
			$i++;
		}
		
		$data['certificate_id']=$certificateArr;
				
		$data['price'] = $productPriceInfo;
		
		if (!empty($productInfo)) {
			$data['cost_price'] = $productInfo->cost_price;
		} else {
			$data['cost_price'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['pack_unit'] = $productInfo->pack_unit;
		} else {
			$data['pack_unit'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['hsn'] = $productInfo->hsn;
		} else {
			$data['hsn'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['gst'] = $productInfo->gst;
		} else {
			$data['gst'] = '';
		}
		
		if (!empty($productInfo->photo)) {
			$data['photo'] = base_url().$productInfo->photo;
		} else {
			$data['photo'] = '';
		}
		
		if (!empty($productInfo->product_pdf)) {
			$data['product_pdf'] = base_url().$productInfo->product_pdf;
		} else {
			$data['product_pdf'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['product_name'] = $productInfo->product_name;
		} else {
			$data['product_name'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['model'] = $productInfo->model;
		} else {
			$data['model'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['description'] = $productInfo->description;
		} else {
			$data['description'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['category_id'] = $productInfo->category_id;
		} else {
			$data['category_id'] = '';
		}
		
		if (!empty($productInfo)) {
			$data['mrp'] = $productInfo->mrp;
		} else {
			$data['mrp'] = '';
		}
		
		if (!empty($product_id)) {
			$data['product_id'] = $product_id;
		} else {
			$data['product_id'] = '';
		}
		
		
		$data['heading_title'] = $productInfo->product_name;
		$data['title'] = $data['heading_title'];
		
		$data['product_id'] = $product_id; 
		
		$data['form_action']= 'editProduct/'.$product_id;		
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		$this->form_validation->set_rules('product_name', 'Product name', 'required');		
		
		if ($this->form_validation->run() == false) {
			
			$this->load->view('common/header');
			$this->load->view('product/product_form', $data);
			$this->load->view('common/footer');
			
		} else {
			
			$product = $this->product_model->getProductsByNameModelId($this->input->post(),$product_id);										 
			if(!empty($product->product_id)){
				
				$data['errorMsg']="Product <b>$product->product_name</b> with model <b>$product->model</b> already exists";
				$this->load->view('common/header');
				$this->load->view('product/product_form', $data);
				$this->load->view('common/footer');
				return false;
			}			
			
			#upload for Product Photo
			if(!empty($_FILES['photo']['name'])){
				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = '*';
				$config['file_name'] = $_FILES['photo']['name'];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('photo')){
					$uploadData = $this->upload->data();						
					$photo = $config['upload_path'].$uploadData['file_name'];
				}else{
					$photo = $productInfo->photo;
				}					
			}else{
				$photo = $productInfo->photo;
			}
						
			#upload for Product Pdf
			if(!empty($_FILES['product_pdf']['name'])){
				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = '*';
				$config['file_name'] = $_FILES['product_pdf']['name'];
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('product_pdf')){
					$uploadData = $this->upload->data();
					$product_pdf = $config['upload_path'].$uploadData['file_name'];
				}else{
					$product_pdf = $productInfo->product_pdf;
				}
			}else{
				$product_pdf = $productInfo->product_pdf;
			}			
						
			$this->product_model->editProduct($this->input->post(),$photo,$product_pdf);			
			$_SESSION['success']      = "Success: You have Update Product";
			redirect('/product');			
		}		
	}

	public function productView($product_id)
	{
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Product List', '/product');
	
		$data['page_heading'] = "Product View";
		
		$productInfo = $this->product_model->getProductById($product_id);
		$productPriceInfos = $this->product_model->getProductPriceById($product_id);
		$category = $this->product_model->getCategoryByID($productInfo->category_id);
		$pack_unit=$this->product_model->getPackUnitByID($productInfo->pack_unit);
		$productCertificateInfo = $this->product_model->getProductCertificateById($product_id);
		
		$data['certificates'] = array();
		foreach($productCertificateInfo as $productCertificate){
			if($productCertificate['path']){
				$filepath = base_url().'uploads/'.$productCertificate['path'];
				$data['certificates'][] =  '<a href="'.$filepath.'">'.$productCertificate['certificate_name'].'</a>';
			} else {
				$data['certificates'][] =  $productCertificate['certificate_name'];
			}			
		}
		
	
		if (!empty($productInfo->product_name)) {
			$data['product_name'] = $productInfo->product_name;
		} else {
			$data['product_name'] = '';
		}
		if (!empty($category->name)) {
			$data['category_name'] =  $category->name;
		} else {
			$data['category_name'] = '';
		}
		if (!empty($productInfo->model)) {
			$data['model'] = $productInfo->model;
		} else {
			$data['model'] = '';
		}
		if (!empty($productInfo->hsn)) {
			$data['hsn'] = $productInfo->hsn;
		} else {
			$data['hsn'] = '';
		}
		if (!empty($productInfo->mrp)) {
			$data['mrp'] = $productInfo->mrp;
		} else {
			$data['mrp'] = '';
		}
		if (!empty($productInfo->gst)) {
			$data['gst'] = $productInfo->gst;
		} else {
			$data['gst'] = '';
		}
		if (!empty($productInfo->cost_price)) {
			$data['cost_price'] = $productInfo->cost_price;
		} else {
			$data['cost_price'] = '';
		}
		if (!empty($pack_unit->unit_name)) {
			$data['pack_unit'] = $pack_unit->unit_name;
		} else {
			$data['pack_unit'] = '';
		}
		if (!empty($productInfo->description)) {
			$data['description'] = $productInfo->description;
		} else {
			$data['description'] = '';
		}

		if (!empty($productInfo->photo)) {
			$data['photo'] = base_url().$productInfo->photo;
		} else {
			$data['photo'] = '';
		}
		
		if (!empty($productInfo->product_pdf)) {
			$data['product_pdf'] = base_url().$productInfo->product_pdf;
		} else {
			$data['product_pdf'] = '';
		}


		foreach($productPriceInfos as $productPriceInfo){
			if($productPriceInfo['currency_id']==1){
				if (!empty($productPriceInfo['price'])) {
				$data['price_inr'] = $productPriceInfo['price'];
				} else {
					$data['price_inr'] = '';
				}
				if (!empty($productPriceInfo['min_price'])) {
				$data['min_price_inr'] = $productPriceInfo['min_price'];
				} else {
					$data['min_price_inr'] = '';
				}
			}
			if($productPriceInfo['currency_id']==2){
				if (!empty($productPriceInfo['price'])) {
				$data['price_usd'] = $productPriceInfo['price'];
				} else {
					$data['price_usd'] = '';
				}
				if (!empty($productPriceInfo['min_price'])) {
				$data['min_price_usd'] = $productPriceInfo['min_price'];
				} else {
					$data['min_price_usd'] = '';
				}
			}	
			if($productPriceInfo['currency_id']==3){
				if (!empty($productPriceInfo['price'])) {
				$data['price_eur'] = $productPriceInfo['price'];
				} else {
					$data['price_eur'] = '';
				}
				if (!empty($productPriceInfo['min_price'])) {
				$data['min_price_eur'] = $productPriceInfo['min_price'];
				} else {
					$data['min_price_eur'] = '';
				}
			}					

			if($productPriceInfo['currency_id']==4){
				if (!empty($productPriceInfo['price'])) {
				$data['price_gbp'] = $productPriceInfo['price'];
				} else {
					$data['price_gbp'] = '';
				}
				if (!empty($productPriceInfo['min_price'])) {
				$data['min_price_gbp'] = $productPriceInfo['min_price'];
				} else {
					$data['min_price_gbp'] = '';
				}
			}
		}
		
		$this->load->view('common/header');
		$this->load->view('product/product_view', $data);
		$this->load->view('common/footer');
		
	}
	
	public function getProductById() {
		
		$product_id = $this->input->post('product_id');
		$customer_id = $this->input->post('customer_id');
		$store_id = $this->input->post('store_id');
		$productInfo = $this->product_model->getProductById($product_id);
		$productPriceInfos = $this->product_model->getProductPriceById($product_id);
		$productInstock = $this->product_model->getProductInstock($product_id,$store_id);
		$getLastTradePrice = $this->product_model->getLastTradePrice($product_id,$customer_id);
		
		$price = array();
		$min_price = array();
		foreach($productPriceInfos as $priceInfos ){
			$price[$priceInfos['currency_id']] 		= $priceInfos['price'];
			if($priceInfos['currency_id'] == 1){
				if($productInfo->gst){					
					$min_price[$priceInfos['currency_id']] 	= (($priceInfos['min_price'] * $productInfo->gst)/100) + $priceInfos['min_price'];
				} else {
					$min_price[$priceInfos['currency_id']] 	= $priceInfos['min_price'];
				}
			} else {
				$min_price[$priceInfos['currency_id']] 	= $priceInfos['min_price'];
			}
			
		}
		
		$productInfo->price = $price;
		$productInfo->min_price = $min_price;
		if($getLastTradePrice){			
			
			$ltpPrice = number_format((float)$getLastTradePrice->ltp, 2, '.', '');
						
			$productInfo->last_trade_price = '<i class="'.$getLastTradePrice->currency_faclass .'" style="font-size:13px;"></i>&nbsp;'.($ltpPrice);				
			
			$lastTradeDate = new DateTime($getLastTradePrice->op_date_added);
			$productInfo->last_trade_date = $lastTradeDate->format('d-m-Y');
		}
		
		$productInfo->stock_qty = ($productInstock->stock_qty - $productInstock->out_qty) + $productInstock->in_qty;		
		echo json_encode($productInfo);
		
	}
	
	public function addCertificate() {		
		$result = $this->product_model->addCertificate($this->input->post());
		echo json_encode($result);
	}
	
}