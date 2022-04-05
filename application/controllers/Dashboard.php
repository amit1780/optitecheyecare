<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct() {
		
		#var $curObj;
		parent::__construct();
		$this->load->library(array('session'));
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('dashboard_model');
		$this->load->model('quotation_model');
		$this->load->model('order_model');
		$this->load->model('challan_model');
		$this->load->library('breadcrumbs');
	}
	
	public function index()
	{
	    $this->breadcrumbs->push('Dashboard', '/dashboard');
		$data['page_heading'] = "Dashboard";
		$data['success'] = $this->session->success;
		$allowed=Array();
		$allowed[]='SADMIN';
		$allowed[]='PRODUCTION';
		$allowed[]='STORE';
	
		
		//if(!empty($this->session->userdata('group_type')) && in_array($this->session->userdata('group_type'),$allowed)){
			
			$data['pending_stocks'] = $this->dashboard_model->getPendingStockList();  //Use for Stock Pending
			$data['reject_stocks'] = $this->dashboard_model->getRejectStockList();  //Use for Stock Reject
			$data['stores'] = $this->dashboard_model->getStore(); 
			#$data['advices'] = $this->dashboard_model->getAdvices(); //Use for Payment Advice Pending
			#$data['advicesRejects'] = $this->dashboard_model->getAdvicesReject(); //Use for Payment Advice Pending
			 $totalChallan = $this->dashboard_model->getTotalChallan(); //Use for Payment Advice Pending
			
			$data['totalChallan']=array();
			$data['challan_inr'] = 0.00;
			$data['challan_usd'] = 0.00;
			$data['challan_gbp'] = 0.00;
			$data['challan_eur'] = 0.00;
						
			foreach($totalChallan as $chaInfo){
				$totwithgst = 0;
				if($chaInfo['currency_id'] == 1){
					$productgst = $this->challan_model->getOrderProductGroupGst($chaInfo['challan_id']);				
					if($productgst){					
											
						foreach($productgst as $progst){						
							$totwithgst = $totwithgst + $progst['gst_total_amount'];
						}					
					}
				}
				$freight_charge = $chaInfo['freight_charge'];
				$net_amount = $chaInfo['net_amount'];				
				$grandTotal = ($net_amount + $freight_charge + $totwithgst);				
				
				if($chaInfo['currency_id'] == 1){
					$data['challan_inr'] += $grandTotal;
				}
				if($chaInfo['currency_id'] == 2){
					$data['challan_usd'] += $grandTotal;
				}
				if($chaInfo['currency_id'] == 3){
					$data['challan_gbp'] += $grandTotal;
				}
				if($chaInfo['currency_id'] == 4){
					$data['challan_eur'] += $grandTotal;
				}
				
				$data['totalChallan'][] = array(
					'grandTotal' => $grandTotal,
					'currency_id' => $chaInfo['currency_id']
				);		
			} 
			
			$data['totalCustomers'] = $this->dashboard_model->getTotalCustomers(); //Use for Payment Advice Pending	
			$orders = $this->dashboard_model->getOrderList();			
			/* Use for order pending */
			/* $data['pendingOrders'] =array();
			
			$data['pendingorder_inr'] = 0.00;
			$data['pendingorder_usd'] = 0.00;
			$data['pendingorder_gbp'] = 0.00;
			$data['pendingorder_eur'] = 0.00;
			foreach($orders as $order){
				$orderProducts = $this->dashboard_model->getOrderProductById($order['order_id'], $order['quotation_id']);
				//$totalChallan = $this->dashboard_model->getOrderProductChallan($order['order_id'], $order['quotation_id']);
				$totalOrderQty = array_sum(array_column($orderProducts,'qty'));
				$totalOrderedQty = array_sum(array_column($orderProducts,'challan_qty'));				
				$totOrdQty = $totalOrderQty - $totalOrderedQty;
				if($totOrdQty > 0){
					
					$net_total = $order['net_amount'];
					$totwithgst = 0;
					$freight_charge = $order['freight_charge'];
					if($order['currency_id'] == 1){
						$productgst = $this->order_model->getOrderProductGroupGst($order['order_id'], $order['quotation_id']);
						
						foreach($productgst as $progst){
							$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
							$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
							$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
							$totwithgst = $totwithgst + $totgst;
						}
					}	
					
					$orderTotal = number_format((float)($net_total + $order['freight_charge'] + $totwithgst), 2, '.', '');
					
					if($order['currency_id'] == 1){
						$data['pendingorder_inr'] += $orderTotal;
					}
					if($order['currency_id'] == 2){
						$data['pendingorder_usd'] += $orderTotal;
					}
					if($order['currency_id'] == 3){
						$data['pendingorder_gbp'] += $orderTotal;
					}
					if($order['currency_id'] == 4){
						$data['pendingorder_eur'] += $orderTotal;
					}
										
					
					$data['pendingOrders'][] = array(
						'order_id' 				=> $order['order_id'],
						'quotation_id' 			=> $order['quotation_id'],
						'customer_name' 		=> $order['customer_name'],
						'currency' 				=> $order['currency'],
						'order_date' 			=> $order['order_date'],		
						//'totalChallan' 		=> $totalChallan,		
						'totalOrderProduct' 	=> $totOrdQty		
					);
				}				
			} */
			$data['totalOrders'] =array();
			$data['pendingOrders'] =array();
			$data['order_inr'] = 0.00;
			$data['order_usd'] = 0.00;
			$data['order_gbp'] = 0.00;
			$data['order_eur'] = 0.00;
			
			$data['pdue_inr'] = 0.00;
			$data['pdue_usd'] = 0.00;
			$data['pdue_gbp'] = 0.00;
			$data['pdue_eur'] = 0.00;
			
			$data['pendingorder_inr'] = 0.00;
			$data['pendingorder_usd'] = 0.00;
			$data['pendingorder_gbp'] = 0.00;
			$data['pendingorder_eur'] = 0.00;
			foreach($orders as $order){
				$orderProducts = $this->dashboard_model->getOrderProductById($order['order_id'], $order['quotation_id']);
				//$totalChallan = $this->dashboard_model->getOrderProductChallan($order['order_id'], $order['quotation_id']);
				$totalOrderQty = array_sum(array_column($orderProducts,'qty'));
				$totalOrderedQty = array_sum(array_column($orderProducts,'challan_qty'));				
				$totOrdQty = $totalOrderQty - $totalOrderedQty;
				
				/* if($totOrdQty > 0){
					
					$net_total = $order['net_amount'];
					$totwithgst = 0;
					$freight_charge = $order['freight_charge'];
					if($order['currency_id'] == 1){
						$productgst = $this->order_model->getOrderProductGroupGst($order['order_id'], $order['quotation_id']);
						
						foreach($productgst as $progst){
							$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
							$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
							$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
							$totwithgst = $totwithgst + $totgst;
						}
					}	
					
					$orderTotal = number_format((float)($net_total + $order['freight_charge'] + $totwithgst), 2, '.', '');
					
					if($order['currency_id'] == 1){
						$data['pendingorder_inr'] += $orderTotal;
					}
					if($order['currency_id'] == 2){
						$data['pendingorder_usd'] += $orderTotal;
					}
					if($order['currency_id'] == 3){
						$data['pendingorder_gbp'] += $orderTotal;
					}
					if($order['currency_id'] == 4){
						$data['pendingorder_eur'] += $orderTotal;
					}
										
					
					$data['pendingOrders'][] = array(
						'order_id' 				=> $order['order_id'],
						'quotation_id' 			=> $order['quotation_id'],
						'customer_name' 		=> $order['customer_name'],
						'currency' 				=> $order['currency'],
						'order_date' 			=> $order['order_date'],		
						//'totalChallan' 		=> $totalChallan,		
						'totalOrderProduct' 	=> $totOrdQty		
					);
				} */	
				
				
				$net_total = $order['net_amount'];
				$totwithgst = 0;
				$freight_charge = $order['freight_charge'];
				if($order['currency_id'] == 1){
					$productgst = $this->order_model->getOrderProductGroupGst($order['order_id'], $order['quotation_id']);
					
					foreach($productgst as $progst){
						$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
						$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
						$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
						$totwithgst = $totwithgst + $totgst;
					}
				}	
				
				$orderTotal = number_format((float)($net_total + $order['freight_charge'] + $totwithgst), 2, '.', '');
				
				if($order['currency_id'] == 1){
					$data['order_inr'] += $orderTotal;
				}
				if($order['currency_id'] == 2){
					$data['order_usd'] += $orderTotal;
				}
				if($order['currency_id'] == 3){
					$data['order_gbp'] += $orderTotal;
				}
				if($order['currency_id'] == 4){
					$data['order_eur'] += $orderTotal;
				}
				
				//$advices = $this->order_model->getAdvices($order['order_id']);				
				//$advicesTotal = array_sum(array_column($advices,'amount'));
				$advicesTotal = number_format((float)($order['total_advice_payment']), 2, '.', '');
				
				$dueOrderTotal = $orderTotal - $advicesTotal;
				
				if($order['currency_id'] == 1){
					$data['pdue_inr'] += $dueOrderTotal;
				}
				if($order['currency_id'] == 2){
					$data['pdue_usd'] += $dueOrderTotal;
				}
				if($order['currency_id'] == 3){
					$data['pdue_gbp'] += $dueOrderTotal;
				}
				if($order['currency_id'] == 4){
					$data['pdue_eur'] += $dueOrderTotal;
				}
				
				 //if($totOrdQty > 0){
					$data['totalOrders'][] = array(
						'order_id' 				=> $order['order_id'],
						'quotation_id' 			=> $order['quotation_id'],
						'customer_name' 		=> $order['customer_name'],
						'currency' 				=> $order['currency'],
						'order_date' 			=> $order['order_date'],		
						//'totalChallan' 		=> $totalChallan,		
						'total_order' 			=> $orderTotal,		
						'totalOrderProduct' 	=> $totOrdQty		
					);
				//}	

				if($totOrdQty > 0){
					
					$orderTotal1 = number_format((float)($net_total + $order['freight_charge'] + $totwithgst), 2, '.', '');
					
					if($order['currency_id'] == 1){
						$data['pendingorder_inr'] += $orderTotal1;
					}
					if($order['currency_id'] == 2){
						$data['pendingorder_usd'] += $orderTotal1;
					}
					if($order['currency_id'] == 3){
						$data['pendingorder_gbp'] += $orderTotal1;
					}
					if($order['currency_id'] == 4){
						$data['pendingorder_eur'] += $orderTotal1;
					}
										
					
					$data['pendingOrders'][] = array(
						'order_id' 				=> $order['order_id'],
						'quotation_id' 			=> $order['quotation_id'],
						'customer_name' 		=> $order['customer_name'],
						'currency' 				=> $order['currency'],
						'order_date' 			=> $order['order_date'],		
						//'totalChallan' 		=> $totalChallan,		
						'totalOrderProduct' 	=> $totOrdQty		
					);
				}
				
			}
			
			
			
			/* End Use for order pending */			
		//}
		
		$data['quotations'] = $this->dashboard_model->getTotalQuotation();
		$data['quotation_inr'] = 0.00;
		$data['quotation_usd'] = 0.00;
		$data['quotation_gbp'] = 0.00;
		$data['quotation_eur'] = 0.00;
		foreach($data['quotations'] as $quotation){
			$totwithgst = 0;
			$freight_charge = $quotation['freight_charge'];
			if($quotation['currency_id'] == 1){
				$productgst = $this->quotation_model->getQuotationProductGroupGst($quotation['id']);
				
				foreach($productgst as $progst){
					$perProFrch = ($freight_charge / $quotation['net_amount']) * $progst['net_amount'];
					$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
				}
			}
			$quotationToatal = $quotation['net_amount'] + $freight_charge + $totwithgst;
			if(is_nan($quotationToatal)){
				$quotationToatal = 0.00;
			}			
			if($quotation['currency_id'] == 1){
				$data['quotation_inr'] += $quotationToatal;
			}
			if($quotation['currency_id'] == 2){
				$data['quotation_usd'] += $quotationToatal;
			}
			if($quotation['currency_id'] == 3){
				$data['quotation_gbp'] += $quotationToatal;
			}
			if($quotation['currency_id'] == 4){
				$data['quotation_eur'] += $quotationToatal;
			}			
		}		
		
		$data['totalReturns'] = $this->dashboard_model->getTotalReturns();
		
		$data['return_inr'] = 0.00;
		$data['return_usd'] = 0.00;
		$data['return_gbp'] = 0.00;
		$data['return_eur'] = 0.00;
		
		foreach($data['totalReturns'] as $totalReturns){
			if($totalReturns['currency_id'] == 1){
				$pro_gst_inr = ($totalReturns['return_net_total'] * $totalReturns['product_gst'])/100;
				$data['return_inr'] += $totalReturns['return_net_total'] + $pro_gst_inr;
			}
			if($totalReturns['currency_id'] == 2){
				$data['return_usd'] += $totalReturns['return_net_total'];
			}
			if($totalReturns['currency_id'] == 3){
				$data['return_gbp'] += $totalReturns['return_net_total'];
			}
			if($totalReturns['currency_id'] == 4){
				$data['return_eur'] += $totalReturns['return_net_total'];
			}
		}
		
		//$incompleteOrders = 
		$data['incompleteOrder'] = $this->dashboard_model->getTotalIncompleteOrders();
		
		//$data['incompleteOrder'] =array();		
		/* foreach($incompleteOrders as $incompleteOrder){
			$orderProducts = $this->dashboard_model->getOrderProductById($incompleteOrder['order_id'], $incompleteOrder['quotation_id']);
			//$totalChallan = $this->dashboard_model->getOrderProductChallan($order['order_id'], $order['quotation_id']);
			$totalOrderQty = array_sum(array_column($orderProducts,'qty'));
			$totalOrderedQty = array_sum(array_column($orderProducts,'challan_qty'));				
			$totOrdQty = $totalOrderQty - $totalOrderedQty;
			
			$net_total = $incompleteOrder['net_amount'];
			$totwithgst = 0;
			$freight_charge = $incompleteOrder['freight_charge'];
			if($incompleteOrder['currency_id'] == 1){
				$productgst = $this->order_model->getOrderProductGroupGst($incompleteOrder['order_id'], $incompleteOrder['quotation_id']);
				
				foreach($productgst as $progst){
					$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
					$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
					$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);								
					$totwithgst = $totwithgst + $totgst;
				}
			}	
			
			$orderTotal = number_format((float)($net_total + $incompleteOrder['freight_charge'] + $totwithgst), 2, '.', '');			
			 
			if($incompleteOrder['total_advice_payment'] >= 0 || $incompleteOrder['total_advice_payment'] < $orderTotal ){
				
				$data['incompleteOrder'][] =array(
					'order_id' 				=> $incompleteOrder['order_id'],				
					'order_total' 			=> $orderTotal,
					'total_advice_payment' 	=> $incompleteOrder['total_advice_payment']
				);			
			}			
		} */
		
		$this->load->view('common/header');
		$this->load->view('dashboard/dashboard', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	
	public function stockPending(){
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$data['page_heading'] = "Stock Pending";
		
		$data['pending_stocks'] = $this->dashboard_model->getPendingStockList();
		
		$this->load->view('common/header');
		$this->load->view('dashboard/stock_pending', $data);
		$this->load->view('common/footer');		
	}
	
	public function stockRejected(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$data['page_heading'] = "Stock Rejected";
		
		$data['reject_stocks'] = $this->dashboard_model->getRejectStockList();  //Use for Stock Reject
		
		$this->load->view('common/header');
		$this->load->view('dashboard/stock_rejected', $data);
		$this->load->view('common/footer');		
	}
	
	public function advicePending(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$data['page_heading'] = "Advice Pending";
		
		$data['advices'] = $this->dashboard_model->getAdvices(); //Use for Payment Advice Pending
		
		$this->load->view('common/header');
		$this->load->view('dashboard/peyment_received_advice_pending', $data);
		$this->load->view('common/footer');		
	}
	
	public function adviceRejected(){
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$data['page_heading'] = "Advice Rejected";
		
		$data['advicesRejects'] = $this->dashboard_model->getAdvicesReject(); //Use for Payment Advice Pending
		
		$this->load->view('common/header');
		$this->load->view('dashboard/peyment_received_advice_rejected', $data);
		$this->load->view('common/footer');		
	}
	
	
	
	public function getStockBatchDetails(){
		$stock_id = $this->input->post('stock_id');
		$stock_details = $this->dashboard_model->getStockBatchDetails($stock_id);		
		echo json_encode($stock_details);
	}
	
	public function addStockApprove(){
		if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){
			$stock_id = $this->input->post('stock_id');
			$result = $this->dashboard_model->addStockApprove($stock_id);		
			echo json_encode($result);
		}else{
			redirect('/dashboardtwo');
		}
	}
	
	public function stockReject(){
		$stock_id = $this->input->post('stock_id');
		$result = $this->dashboard_model->stockReject($stock_id);		
		echo json_encode($result);
	}
	
	public function stockDelete(){
		$stock_id = $this->input->post('stock_id');
		$result = $this->dashboard_model->stockDel($stock_id);		
		echo json_encode($result);
	}
	
	
	public function stockUpdate(){	
		$result = $this->dashboard_model->stockUpdate($this->input->post());		
		echo json_encode($result);
	}
	
	public function adviceApprove(){
		$advice_id = $this->input->post('advice_id');
		$result = $this->dashboard_model->addAdviceApprove($advice_id);		
		echo json_encode($result);
	}
	
	public function adviceReject(){
		$advice_id = $this->input->post('advice_id');
		$result = $this->dashboard_model->adviceReject($advice_id);		
		echo json_encode($result);
	}
	
	public function adviceDelete(){
		$advice_id = $this->input->post('advice_id');
		$result = $this->dashboard_model->adviceDel($advice_id);		
		echo json_encode($result);
	}
	
	public function getMapDetails(){
		$results = $this->dashboard_model->getTotalCustomerByCountry();		
		foreach ($results as $result) {			
			$quotation = $this->dashboard_model->getTotalQuotationByCountry($result['iso_code_2']);		
			$order = $this->dashboard_model->getTotalOrderByCountry($result['iso_code_2']);		
			$json[strtolower($result['iso_code_2'])] = array(
				'total'  			=> $result['total'],
				'pending_quotation' => ($quotation->quotation_pending != null) ?  $quotation->quotation_pending : 0,
				'pending_order' 	=> ($order->pending_order != null) ? $order->pending_order : 0
			);
		}
		echo json_encode($json);
	}
	
	public function getTotalChallan(){
		$totalChallan = $this->dashboard_model->getTotalChallan(); //Use for Payment Advice Pending
			
		$data['totalChallan']=array();
		$data['challan_inr'] = 0.00;
		$data['challan_usd'] = 0.00;
		$data['challan_gbp'] = 0.00;
		$data['challan_eur'] = 0.00;
					
		foreach($totalChallan as $chaInfo){
			$totwithgst = 0;
			if($chaInfo['currency_id'] == 1){
				$productgst = $this->challan_model->getOrderProductGroupGst($chaInfo['challan_id']);				
				if($productgst){										
					foreach($productgst as $progst){						
						$totwithgst = $totwithgst + $progst['gst_total_amount'];
					}					
				}
			}
			$freight_charge = $chaInfo['freight_charge'];
			$net_amount = $chaInfo['net_amount'];				
			$grandTotal = ($net_amount + $freight_charge + $totwithgst);				
			
			if($chaInfo['currency_id'] == 1){
				$data['challan_inr'] += $grandTotal;
			}
			if($chaInfo['currency_id'] == 2){
				$data['challan_usd'] += $grandTotal;
			}
			if($chaInfo['currency_id'] == 3){
				$data['challan_gbp'] += $grandTotal;
			}
			if($chaInfo['currency_id'] == 4){
				$data['challan_eur'] += $grandTotal;
			}
			
			$data['totalChallan'][] = array(
				'grandTotal' => $grandTotal,
				'currency_id' => $chaInfo['currency_id']
			);		
		}
		
		$json = array();
		$json['totalChallan'] = count($data['totalChallan']);
		$json['challan_inr'] = ($data['challan_inr'] > 0) ? (number_format((float)$data['challan_inr'], 2, '.', '')) : (0.00);
		$json['challan_usd'] = ($data['challan_usd'] > 0) ? (number_format((float)$data['challan_usd'], 2, '.', '')) : (0.00);
		$json['challan_gbp'] = ($data['challan_gbp'] > 0) ? (number_format((float)$data['challan_gbp'], 2, '.', '')) : (0.00);
		$json['challan_eur'] = ($data['challan_eur'] > 0) ? (number_format((float)$data['challan_eur'], 2, '.', '')) : (0.00);
		
		echo json_encode($json);
	}
}
