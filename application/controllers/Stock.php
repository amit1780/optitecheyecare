<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
	
		
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('stock_model');
		$this->load->language('language_lang');
		$this->load->library('breadcrumbs');
		$this->load->library('pagination');
		$this->load->library('dbvars');
	}
	
	public function index()	{
	    
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Stocks', '/stock');
		$data['page_heading'] = "Stock List";
	    $data['form_action']= 'stock';
		
		$data['success'] = $this->session->success;
		$data['store_id'] = $this->input->get('store_id');
		$data['is_expired'] = $this->input->get('is_expired');
		$data['stock_availability'] = $this->input->get('stock_availability');
		if(empty($data['stock_availability'])){
			$data['stock_availability']='AVAIL';
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
				
		$data['store_sort'] = site_url().'/stock/index?sort=store_name'. $order . $pageUrl .$url;
		$data['product_name_sort'] = site_url().'/stock/index?sort=product_name'. $order . $pageUrl .$url;
		$data['model_sort'] = site_url().'/stock/index?sort=model'. $order . $pageUrl .$url;
		$data['pack_unit_sort'] = site_url().'/stock/index?sort=unit_name'. $order . $pageUrl .$url;
		$data['batch_no_sort'] = site_url().'/stock/index?sort=batch_no'. $order . $pageUrl .$url;
		
		
		/* Pagination */
		$total_rows = $this->stock_model->getTotalStock($this->input->get());	
		$per_page =25;
		$config['base_url'] = site_url().'/stock/index';		
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
		$data['stores'] = $this->stock_model->getStore();
		
		$data['stocks'] = array();
		$data['stocks'] = $this->stock_model->getStockList($per_page, $start,$this->input->get());		
		/* echo "<pre>";
		print_r($data['stocks']);exit; */
		$this->load->view('common/header');
		$this->load->view('stock/stock_list', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function addStock(){
		//$this->session->userdata('username')
		#print_r($this->config->item('STOCKADD'));exit;
		if (!in_array($this->session->userdata('username'),$this->config->item('STOCKADD'))) {
			redirect('/dashboardtwo');
			exit;
		}
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add Stock', '/addStock');
		$data['page_heading'] = "Add Stock";
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('store_id', 'Store', 'required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
				
		if ($this->form_validation->run() == false) {
			//$data['batches'] = $this->stock_model->getBatch();			
			$data['stores'] = $this->stock_model->getStore();						
			$this->load->view('common/header');
			$this->load->view('stock/stock_form', $data);
			$this->load->view('common/footer');		
		}else{
			if($this->input->post()){				
				$this->stock_model->addStock($this->input->post());
				$_SESSION['success']  = "Success: You have Add Stock";
				redirect('/dashboard');
			}			
		}
	}
	
	public function stockPrint($stock_id){
		$data['stocks'] =$this->stock_model->getStockByStockId($stock_id);		
		$this->load->view('stock/stock_print', $data);
	} 
	
	public function stockSummary(){		
		$data['stockDetails'] =$this->stock_model->getStockBatchDetals($this->input->get());		
		$data['stocks'] =$this->stock_model->getStockSummary($this->input->get());		
		$data['packUnit']=$this->db->get_where('packunit',array('id'=>$data['stockDetails']->pack_unit))->row()->unit_name; 
		$this->load->view('stock/stock_summary', $data);
	}
	
	public function getProductName(){
		$name = $this->input->post('name');
		$products = $this->stock_model->getProductName($name);
		echo json_encode($products);
	}
	
	public function getProductModel(){
		$name = $this->input->post('name');
		$model = $this->stock_model->getProductModel($name);
		echo json_encode($model);
	}
	
	public function getProductName2(){
		$name = $this->input->post('name');
		$products = $this->stock_model->getProductName2($name);
		echo json_encode($products);
	}
	
	public function getProductModel2(){
		$name = $this->input->post('name');
		$model = $this->stock_model->getProductModel2($name);
		echo json_encode($model);
	}
	
	public function getBatch(){
		
		$expiry_year = $this->stock_model->getProductExpiryYear($this->input->post());
		$json=array(); 
		$batch = $this->stock_model->getBatch($this->input->post());		
		$json['batch']=$batch;
		$stockInoQty = $this->stock_model->getStockInStoreBase($this->input->post());
		$json['stock_in']= ($stockInoQty->total_qty - $stockInoQty->challan_qty) + $stockInoQty->return_qty;		
		$json['expiry_year']=$expiry_year->expiry_year;
		$json['unit_name']=$expiry_year->unit_name;
		$json['gst']=$expiry_year->gst;
		echo json_encode($json);
		
	}
	
	public function getBatchInfo(){	
		$batchData=$this->stock_model->getBatchInfo($this->input->post());
		$batchData->approve_qty = ($batchData->approve_qty - $batchData->challan_qty) + $batchData->return_qty;
		if($batchData->approve_qty < 0){
			$batchData->approve_qty = 0;
		}
		echo json_encode($batchData);
	}
	
	public function getStockInStoreBase(){
		$json=array();			
		$stockInoQty = $this->stock_model->getStockInStoreBase($this->input->post());
		if($this->input->post('batch_id')){
			$batchData=$this->stock_model->getBatchInfo($this->input->post());
			
			$json['batch_no'] = $batchData->batch_no;
			$json['approve_qty'] = ($batchData->approve_qty - $batchData->challan_qty) + $batchData->return_qty;
			if($json['approve_qty'] < 0){
				$json['approve_qty'] = 0;
			}			
			$json['pending_qty'] = $batchData->pending_qty;	
		}			
		$json['stock_in']= ($stockInoQty->total_qty - $stockInoQty->challan_qty) + $stockInoQty->return_qty;
		if($json['stock_in'] < 0){
			$json['stock_in'] = 0;
		}
		echo json_encode($json);
	}
	
	public function stockListDownload(){
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library
		$data['stocks'] = $this->stock_model->getStockListDownload($this->input->get());
		
		$html= $this->load->view('stock/stock_list_download', $data,true);
		
		//this the the PDF filename that user will get to download
		//$filename = str_pad($quotation_id, 6, "Q00000", STR_PAD_LEFT);
		$pdfFilePath = "Stock_list.pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		$pdf->SetHTMLHeader('<div style="width:100%;float:left;height:50px;text-align:center;"></div>');
		$pdf->SetHTMLFooter('<div style="width:100%;float:left;height:50px;text-align:center;"></div>');
		$pdf->AddPage('', // L - landscape, P - portrait 
        '', '', '', '',
        5, // margin_left
        5, // margin right
       15, // margin top
       15, // margin bottom
        0, // margin header
        0); // margin footer
		$pdf->WriteHTML($html,2);
		
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
	}
	
	public function downloadExcelFile() {		
		// create file name
         $fileName = 'data-'.time().'.xlsx';
		// load excel library
        $this->load->library('excel');
        
		$stocks = $this->stock_model->getStockListDownload($this->input->get());
		
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Store name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Qty');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Pack Unit');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Batch No');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Expiry Date');       
           
        
		$rowCount = 2;	
		 foreach($stocks as $stock){
			
			$Qty = ($stock['qty'] - $stock['challan_qty']) + $stock['return_qty'];
			$expDate = new DateTime($stock['s_exp_date']);
			$mfgDate = new DateTime($stock['s_mfg_date']);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $stock['store_name']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $stock['product_name']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $stock['model']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $Qty); 
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $stock['unit_name']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $stock['batch_no']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $expDate->format('m/Y')); 								
			$rowCount++;		
		 }
		
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/stock/'.$fileName);
		// download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url().'uploads/stock/'.$fileName);        
    }
}