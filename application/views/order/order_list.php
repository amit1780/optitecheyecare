<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<h1 style="float: left;">Order List</h1> <?php echo $this->breadcrumbs->show(); ?>			
	</div>
	 <!-- Breadcrumbs-->
	<!-- <ol class="breadcrumb">
		<li class="breadcrumb-item">
		  <a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Tables</li>
	</ol> -->
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->	 
	 
  <div class="card mb-3">	
	<div class="card-body">	
	<style>
		.form-group ul{width:100%;padding-left:6px;}
		.form-group ul{max-height: 200px;overflow-y: scroll;}
		.form-group{margin-bottom: 0.5rem !important;}
		.form-control{height:36px !important; padding-left:5px !important;}
	</style>	
		<form role="form" class="needs-validation" id="filterForm" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">

			<div class="col-sm-3">
				<div class="form-group">
					<div class="control-label" >Order No</div> 
					<div class="input-group">
						<div class="input-group-prepend dropdown">
							<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titleorder"><?php echo "O".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
							
							<div class="dropdown-menu">
								
								<?php echo financialList($dropdown='orderdropdown',$type='O'); ?>
							</div>
						 </div>	
						 
						<input type="text" name="order_id" style="width:50%;" value="<?php echo idFormat($this->input->get('order_id')); ?>" id="order_id" class="form-control">						
						<input type="hidden" name="foyear" value="" id="foyear" class="form-control">						
					</div>
				</div>
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<div class="control-label" >Quotation No</div> 
					<div class="input-group">
						<div class="input-group-prepend dropdown">
							<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titlequote"><?php echo "Q".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
							
							<div class="dropdown-menu">
								
								<?php echo financialList($dropdown='quotedropdown',$type='Q'); ?>
								
							</div>
						 </div>	
						 
						<input type="text" name="quote_id" style="width:50%;" value="<?php echo idFormat($this->input->get('quote_id')); ?>" id="quote_id" class="form-control">						
						<input type="hidden" name="fqyear" value="" id="fqyear" class="form-control">						
					</div>
				</div>
			</div>


			
				<!-- <div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Order No</div> 
					<input type="text" name="order_id" value="<?php if(!empty($this->input->get('order_id'))){ echo $this->input->get('order_id'); } ?>" id="order_id" class="form-control">
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without O)</span>
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Quotation No</div> 
					<input type="text" name="quote_id" value="<?php if(!empty($this->input->get('quote_id'))){ echo $this->input->get('quote_id'); } ?>" id="quote_id" class="form-control">
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without Q)</span>
				  </div>
				</div> -->
				
				<div class="col-sm-2">
				  <div class="form-group">
					 <div class="control-label" >Currency</div> 
						<select name="currency_id" id="currency_id" class="form-control" >
							<option value=''>--Select--</option>
							<?php if(isset($currencies)){ ?>
							<?php foreach($currencies as $currency){ ?>								
								<option value="<?php echo $currency['id']; ?>" <?php if($this->input->get('currency_id') == $currency['id']) { echo ' selected="selected"'; } ?> ><?php echo $currency['currency']; ?></option>								
							<?php } ?>
						<?php } ?>
						</select>								
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
						 <div class="control-label" >Created By</div> 
							<select name="user_id" class="form-control" >
								<option value=''>--Select--</option>
								<?php if(isset($users)){ ?>
								<?php foreach($users as $user){ ?>
									
									<option value="<?php echo $user['user_id']; ?>" <?php if($this->input->get('user_id') == $user['user_id']) { echo ' selected="selected"'; } ?> ><?php echo $user['firstname']." ".$user['lastname']; ?></option>
									
								<?php } ?>
							<?php } ?>
							</select>								
					  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
						 <div class="control-label" >Store</div> 
							<select name="store_id" class="form-control" >
								<option value=''>--Select--</option>
								<?php if(isset($stores)){ ?>
								<?php foreach($stores as $store){ ?>									
									<option value="<?php echo $store['store_id']; ?>" <?php if($this->input->get('store_id') == $store['store_id']) { echo ' selected="selected"'; } ?> >	<?php echo $store['store_name']; ?></option>									
								<?php } ?>
							<?php } ?>
							</select>								
					  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Customer Id</div> 
					<input type="text" name="customerid" value="<?php if(!empty($this->input->get('customerid'))){ echo $this->input->get('customerid'); } ?>" id="customerid" class="form-control">					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Customer name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Customer Email</div> 
					<input type="text" name="contact_email" value="<?php if(!empty($this->input->get('contact_email'))){ echo $this->input->get('contact_email'); } ?>" id="contact_email" class="form-control">					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Contact Phone</div> 
					<input type="text" name="contact_phone" value="<?php if(!empty($this->input->get('contact_phone'))){ echo $this->input->get('contact_phone'); } ?>" id="contact_phone" class="form-control">					
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label" >Country</div> 
					<?php $country_id = $this->input->get('country_id'); ?>
					<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" >
						<option value="">--Seclect--</option>
						<?php foreach($countries as $country){ ?>
							<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>
						<?php } ?>
					</select>					
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">State</div> 
						<select name="state_id" id="state_id" class="form-control" >
							<option value="">--Select--</option>
							<?php if($states && $this->input->get('country_id')){ ?> 
								<?php foreach($states as $state){ ?>
									<option value="<?php echo $state['state_id']; ?>" <?php if($this->input->get('state_id') == $state['state_id']) { echo ' selected="selected"'; } ?> ><?php echo $state['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>					
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">City</div> 
					<input type="text" name="city" value="<?php if(!empty($this->input->get('city'))){ echo $this->input->get('city'); } ?>" id="city" class="form-control" >
					
				  </div>
				</div>	

				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">Pin Code</div> 
					<input type="text" name="pin_code" value="<?php if(!empty($this->input->get('pin_code'))){ echo $this->input->get('pin_code'); } ?>" id="pin_code" class="form-control">
					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Start Date</div> 
					<input type="text" name="start_date" value="<?php if(!empty($this->input->get('start_date'))){ echo $this->input->get('start_date'); } ?>" id="start_date" class="form-control date" >					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">End Date</div> 
					<input type="text" name="end_date" value="<?php if(!empty($this->input->get('end_date'))){ echo $this->input->get('end_date'); } ?>" id="end_date" class="form-control date" >					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					 <div class="control-label">Product Name / Description</div> 					
					<!-- <div class="control-label">Product / Category Name</div> -->
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" autocomplete="off" >

					</div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Model</div> 
					<!-- <input type="text" name="model" value="<?php if(!empty($this->input->get('model'))){ echo $this->input->get('model'); } ?>" id="model" class="form-control"> -->
					<select name="model" id="input-model" class="form-control"></select>
					</div>
				</div> 
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">Incomplete Status</div> 
						<?php
							$incomplete_status = array(
								'incomplete'	 			=> 'Incomplete Order',
								'method_of_shipment'	 	=> 'Missing Method of Shipment',
								//'date_of_shipment'	 		=> 'Missing Date of Shipment',
								'docket_no'	 				=> 'Missing Docket Number',
								'invoice_no'	 			=> 'Missing Invoice Number',
								//'invoice_date'	 			=> 'Missing Invoice Date',
								'sb_number'	 				=> 'Missing SB Number',
								//'advices_payment'	 		=> 'Unmatched payment',
							);
						?>
						<select name="incomplete_order" id="incomplete_order" class="form-control" >
							<option value="">--Select--</option>
							<?php foreach($incomplete_status as $key => $value){ ?>
								<option value="<?php echo $key; ?>" <?php if(!empty($this->input->get('incomplete_order')) && $this->input->get('incomplete_order') == $key){ echo ' selected="selected"';  } ?> ><?php echo $value; ?></option>
							<?php } ?>	
						</select>					
				  </div>
				</div>
				
			</div>	
			<div class="row">	
				<div class="col-sm-12 float-right">
					<div class="form-group">
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button>
					</div>
					<br>
				</div>			
			</div> 	
		</form>
		<br>
		<div class="table-responsive">
			<style>
				table thead th.sort_ASC a:after {
					content: "▲" !important;
					color:black !important;
					font-size: 12px !important;
					padding: 15px !important;
				}
				
				table thead th.sort_DESC a:after {
					content: "▼" !important;
					color:black !important;
					font-size: 12px !important;
					padding: 15px !important;
				}				
			</style>
			<table class="table-sm table-bordered" width="100%" cellspacing="0">
				  <thead>
					<tr>
					  <th style="width:9%;">Order No</th>
					  	<?php if(!empty($model)){ ?>
							<th style="width:9%;">Pending Qty.</th>
						<?php }else{ ?>
					  		<th style="width:9%;">Quotation No</th>
					  	<?php } ?>

					  <th style="width:8%;">Order Date</th>
					 
					   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'customer_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $customer_name_sort; ?>">Customer Name</a></th>
					   
					  <th width="5%">Customer Id</th>
					   <!-- <th>Contact&nbsp;No</th> -->
					  
					  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'country_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $country_sort; ?>">Country</a></th>
				  
					 <!-- <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'state_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $state_sort; ?>">State</a></th> -->
					  
					  <th width="12%">Order Total</th>
					  <th width="10%">Payment Received</th>
					   
					  <th>Action</th>
					 </tr>
				  </thead>
			  <tbody>
				<?php $ci=& get_instance(); if(($orders)){ ?>				
					<?php foreach($orders as $order){
						
						$pendingQty='';
						if(!empty($model)){
							$condition=Array();
							$condition['order_id']=$order['order_id'];
							$condition['product_id']=$model;
							$orderedQty=$this->db->get_where('order_products',array('prod_id'=>$model,'order_id'=>$order['order_id']))->row()->qty;		
							$challanQuantity=$ci->order_model->getChallanQtybyOrderAndModel($condition);

							$pendingQty=$orderedQty-$challanQuantity->total_challan_qty;
						}
						?>	
					
						<tr class="<?php if($order['totalOrderProduct'] > 0){ echo "alert-danger";} ?>">
							<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>"> <?php echo getOrderNo($order['order_id']); ?></a></td>
							<td>
								<?php if(!empty($model)){ 
									echo "<b>".$pendingQty."</b>";	
								}else{ ?>
									<a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $order['quotation_id']; ?>"><?php echo $orderedQty-$challanQuantity; echo getQuotationNo($order['quotation_id']); ?></a>
								<?php } ?>
							</td>
							<td><?php echo dateFormat('d-m-Y',$order['order_date']); ?></td>	
							<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $order['customer_id']; ?>"><?php echo $order['customer_name']; ?></a></td>
							<td><?php echo $order['customer_id']; ?></td>
							 <!-- <td><?php echo $order['contact_phone']; ?></td> -->
							<td><?php echo $order['country_name']; ?></td>
							<!-- <td><?php echo $order['state_name']; ?></td> -->
							<td><i class="<?php echo $order['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo $order['order_total']; ?></td>
							<td><i class="<?php echo $order['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo $order['advice_total']; ?></td>
											
							<td class="">
								<a style="padding-left:7px;" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>" title="Order View" ><i class="fas fa-eye"></i></a>
								<?php  if($order['totalOrderProduct'] > 0){  ?>
								<a style="padding-left:7px;" href="<?php echo site_url('challan'); ?>?order_id=<?php echo $order['order_id']; ?>" title="Create Challan"><i class="fas fa-plus"></i></a>
								<?php } ?>								
								<a style="padding-left:7px;" href="<?php echo site_url('editOrder'); ?>/<?php echo $order['order_id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
								<a style="padding-left:7px;" href="<?php echo site_url('orderPrint'); ?>/<?php echo $order['order_id']; ?>" target="_blank" title="Print order"><i class="fas fa-print"></i></a>
								<a style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $order['order_id']; ?>" title="Email"><i class="fas fa-envelope"></i></a>
								<a style="padding-left:7px;" href="<?php echo site_url('order/downloadPdf'); ?>?order_id=<?php echo $order['order_id']; ?>" title="Download"> <i class="fas fa-download"></i></a>
								<?php if($order['totalOrderProduct'] > 0){ ?>
								<a style="padding-left:7px;" href="#" class="delOrderPro" onClick="getDelProList(<?php echo $order['order_id']; ?>);" title="Delete Order Product"><i class="fa fa-trash"></i></a>
								<?php } ?>								
								<a style="padding-left:7px;" href="<?php echo site_url('paymentAdvice'); ?>/<?php echo $order['order_id']; ?>" title="Payment Recive Advice"><i class="fa fa-file-alt"></i></a>	
								<a style="padding-left:7px;" href="<?php echo site_url('ordChallan'); ?>/<?php echo $order['order_id']; ?>" title="Challan List"><i class="fa fa-list"></i></a>								
								<a style="padding-left:7px;" data-value="<?php echo $order['order_total']; ?>" data-currency="<?php echo $order['currency_faclass']; ?>" data-payment="<?php echo $order['advice_total']; ?>" href="#" class="missingFields" id="<?php echo $order['order_id']; ?>" title="Incomplete Order fields"><i class="fa fa-filter" aria-hidden="true"></i></a>	
								<a style="padding-left:7px;" href="#" class="commonMailbox" id="oid_<?php echo $order['order_id']; ?>" title="Email"><i class="fas fa-envelope text-danger"></i></a>
								<a style="padding-left:7px;" href="#" class="whatsAppMessageBox" id="waqid_<?php echo $order['order_id']; ?>" title="WhatsApp">
									<?php 
										if($order['wa_status']=='P'){
											echo"<i class='fab fa-whatsapp-square text-warning'></i>";
										}elseif($order['wa_status']=='I'){
											echo"<i class='fab fa-whatsapp-square text-danger'></i>";
										}elseif($order['wa_status']=='C'){
											echo"<i class='fab fa-whatsapp-square text-success'></i>";
										}										
									?>
								</a>
							</td>
						</tr>
					<?php } ?>  
				<?php } else { ?>
					<tr>
						<td class="text-center" colspan="11">No results!</td>
					</tr>
				<?php } ?>  
			  </tbody>
			</table>
		</div>
	</div>
	<?php echo $pagination; ?>
  </div>
  
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width:1000px;">		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Delete Order Product</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body" style="padding:2rem;">
				<table class="table-sm table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Product Description</th>
							<th>HSN</th>
							<th>Order Qty</th>
							<th>Challan Qty</th>
							<th>Pending Qty</th>							
							<th>Pack</th>
							<th>Rate</th>
							<th>Discount/Unit</th>
							<th>Net Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="delProList">												 
					</tbody>
				</table>
			</div>
		  </div>		  
		</div>
	</div>  
</div>

<div class="modal fade" id="myModalSendMail" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Mail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" id="orderMailForm" enctype="multipart/form-data" >					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="email_to" value="<?php echo $ordersInfo->contact_email; ?>" autocomplete='off'  id="email_to" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">CC :</div>															
							<div class="col-sm-10"> <input type="text" name="email_cc" value=""  id="email_cc" autocomplete='off' class="form-control"></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Subject:</div>															
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Order / Performa Invoice - <?php echo getOrderNo($ordersInfo->order_id); ?>"  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Massage:</div>															
							<div class="col-sm-10">
								<textarea class="form-control" style="height:180px !important;" rows="7" name="email_massage" id="email_massage"></textarea>
							</div>
						</div>						
					</div>
					
					<div id="orderfiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">File:</div>															
							<div class="col-sm-10">
								<div id="orderfile"></div>
							</div>
						</div>						
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="sendMail" class="btn btn-primary float-right"> Send Mail</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
	</div>
</div>

<div class="modal fade" id="myModalSendCommonMail" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send email</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger-common"></div>

			<div class="modal-body">
				<form method="post" action="" id="common_email_form" enctype="multipart/form-data" >
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2"></div>															
							<div class="col-sm-10 text-warning" id='last_email'></div>
						</div>						
					</div>
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="common_email_to" value="" autocomplete='off'  id="common_email_to" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">CC :</div>															
							<div class="col-sm-10"> <input type="text" name="common_email_cc" value=""  id="common_email_cc" autocomplete='off' class="form-control"></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Subject:</div>															
							<div class="col-sm-10"> <input type="text" name="common_email_subject" autocomplete='off' value=""  id="common_email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Massage:</div>															
							<div class="col-sm-10">
								<textarea class="form-control" style="height:180px !important;" rows="7" name="common_email_massage" id="common_email_massage"></textarea>
							</div>
						</div>						
					</div>
					
					<div id="orderfiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">File(s):</div>															
							<div class="col-sm-10">
								 <input type="file" name="email_files[]" id="email_file" multiple>
							</div>
						</div>						
					</div>
					<input type='hidden' id='common_customer_id' name='common_customer_id' value=''>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="common_sendMail" class="btn btn-primary float-right"> Send email</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
	</div>
</div>
<div class="modal fade" id="myModalSendWhatsApp" role="dialog">
	<div class="modal-dialog" >
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send WhatsApp</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			
			</div>
			<div id="alert-danger-common"></div>
			<div class="modal-body">
				<form method="post" action="" id="whatsapp_form" enctype="multipart/form-data" >
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Message:</div>															
							<div class="col-sm-10">
								<textarea class="form-control" style="height:180px !important;" rows="7" name="wa_message" id="wa_message"></textarea>
							</div>
						</div>						
					</div>
					<div class="row">
						<div class="col-sm-12">
																				
							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" name="pdf_check" class="form-check-input" value="1">Check to send Order along with message in pdf format.
								</label>
							</div>
						</div>									
					</div>
					<div>
						<input type="hidden" name="wa_order_id" id="wa_order_id" >
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="whatsapp_message" class="btn btn-primary float-right"> Send WhatsApp</button>	
							</div>
						</div>						
					</div>	
				</form>
			</div>
		</div>		
	</div>
</div>

<div class="modal fade" id="filterMissingFields" role="dialog">
	<div class="modal-dialog" style="max-width:700px;" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Missing Fields # <span id="ordMiss"></span></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body" style="padding-bottom:0;">
				<h6>Order Payment</h6>
				<p>Order Amount &nbsp;:&nbsp; <span id="orderTotal"></span> &nbsp;|&nbsp; Payment Received &nbsp;:&nbsp; <span id="orderPayment"></span> &nbsp;|&nbsp; <span id="paymentLink"></span></p>						
			</div>	
			<div class="modal-body">
				<table class="table-sm table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
						  <th width="9%">Challan&nbsp;No</th>					   
						  <th width="13%">Method&nbsp;of&nbsp;Shipment</th>						  				   
						  <th>Docket&nbsp;No</th>
						  <th>SB&nbsp;Number</th>
						  <th>Invoice&nbsp;No</th>						  			   
						  <th>Action</th>
						</tr>
					</thead>
					<tbody id="challanlist"></tbody>					
				</table>			
			</div>			
					
		</div>				  
	</div>
</div>

<style>
.isdisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
}
</style>
<script>
	function getDelProList(order_id){
		$.ajax({
			url:'<?php echo site_url('getOrderProductList'); ?>',
			method: 'post',
			data: {order_id: order_id},
			dataType: 'json',
			success: function(response){
				var htm = '';
				var disable = '';
				var isDisabled = '';
				$.each(response, function(i,res) {
					if(res.challan_qty > 0){						
						var disable = '';
						var chQty = '<b style="color:green;">'+res.challan_qty+'</b>';
						var isDisabled = 'isdisabled';						
					} else {
						var chQty = 0;
					}
					htm += '<tr class='+disable+'>';
					htm += '<td><b>'+res.model_name+' | </b>'+res.description+'</td>';				
					htm += '<td>'+res.hsn+'</td>';				
					htm += '<td>'+res.qty+'</td>';				
					htm += '<td>'+chQty+'</td>';
					htm += '<td>'+ (parseInt(res.qty) - parseInt(res.challan_qty)) +'</td>';
					htm += '<td>'+res.unit+'</td>';				
					htm += '<td>'+res.rate+'</td>';				
					htm += '<td>'+res.discount+'</td>';				
					htm += '<td>'+res.net_amount+'</td>';
					if(isDisabled){
						htm += '<td><a  href="#" onClick="delPro('+res.id+','+order_id+');" title="Delete Order Product" ><i class="fa fa-trash"></i></a></td>';
					} else {
						htm += '<td><a  href="#" onClick="delPro('+res.id+','+order_id+');" title="Delete Order Product" ><i class="fa fa-trash"></i></a></td>';
					}					
					htm += '</tr>';
				});
				$("#delProList").html(htm);
			}
		}); 
		$("#myModal").modal(); 		
	}
	
	function delPro(id,order_id){
		var checkstr =  confirm('Are you sure you want to delete this Order product?');
		if(checkstr == true){
			$.ajax({
				url:'<?php echo site_url('deleteOrderProduct'); ?>',
				method: 'post',
				data: {order_product_id: id},
				dataType: 'json',
				success: function(response){
					if(response == true){						
						$.ajax({
							url:'<?php echo site_url('getOrderProductList'); ?>',
							method: 'post',
							data: {order_id: order_id},
							dataType: 'json',
							success: function(response){
								var htm = '';
								var disable = '';
								var isDisabled = '';
								$.each(response, function(i,res) {
									if(res.challan_qty > 0){										
											var disable = 'alert-danger';
											var isDisabled = 'isdisabled';										
									} 
									
									htm += '<tr class='+disable+'>';
									htm += '<td>'+res.description+'</td>';				
									htm += '<td>'+res.hsn+'</td>';				
									htm += '<td>'+res.qty+'</td>';				
									htm += '<td>'+res.challan_qty+'</td>';
									htm += '<td>'+ (parseInt(res.qty) - parseInt(res.challan_qty)) +'</td>';
									htm += '<td>'+res.unit+'</td>';				
									htm += '<td>'+res.rate+'</td>';				
									htm += '<td>'+res.discount+'</td>';
									
									htm += '<td>'+res.net_amount+'</td>';
									if(isDisabled){
										htm += '<td><a  href="#" onClick="delPro('+res.id+','+order_id+');" title="Delete Order Product" ><i class="fa fa-trash"></i></a></td>';
									} else {
										htm += '<td><a  href="#" onClick="delPro('+res.id+','+order_id+');" title="Delete Order Product" ><i class="fa fa-trash"></i></a></td>';
									}					
									htm += '</tr>';
								});
								$("#delProList").html(htm);
							}
						});						
						
						var mess = '<div class="alert alert-success">Successfully Delete order product.</div>';
						$("#alert-danger").html(mess);						
						setTimeout(function(){							
							$("#alert-danger").html('');
						}, 2000);
					}
				}
			});
			
			$.ajax({
				url:'<?php echo site_url('getOrderProductNotList'); ?>',
				method: 'post',
				data: {order_id: order_id},
				dataType: 'json',
				success: function(response){
					if(response == true){
						 window.onload
					}
				}
			});	
	
			
		} else {
			return false;
		}
	}
	
	$(document).ready(function(){	
		
		$(".commonMailbox").click(function(){
			//var id = this.id;
			var id=this.id.split("_");
			var order_id = id[1];
			var urlAjax='<?php echo site_url('common/getEmail'); ?>';
			urlAjax = urlAjax+"/?order_id="+order_id;
			$.ajax({
				url:urlAjax,
				method: 'post',
				data: 'order_id='+order_id, 
				dataType: 'json',
				beforeSend: function(){
					   $('.loader').show();
				   },
				complete: function(){
					   $('.loader').hide();
				},
				success: function(response){
				    //alert(response)
					var email='';
					var customer_id='';
					var last_email='';
					$.each(response, function(i,res) {						
						email = res.email_to;							
						customer_id = res.customer_id;						
						last_email = res.lastEmailInfo;						
					});
					//alert(email);
					$("#last_email").html(last_email); 
					$("#common_email_to").val(email); 
					$("#common_customer_id").val(customer_id); 
					$("#myModalSendCommonMail").modal();		
				}
			});				
		});

		$(".whatsAppMessageBox").click(function(){
			var id = this.id.split("_");
			var wa_order_id = id[1];
			$("#wa_order_id").val(wa_order_id);
			$("#myModalSendWhatsApp").modal();			
		});

		$("#whatsapp_message").click(function(){
			var data_form = $('#whatsapp_form').serialize();
			//console.log(data_form);
			var formData = new FormData($('#whatsapp_form')[0]);
			$.ajax({
				url:'<?php echo site_url('common/sendWhatsAppOrder'); ?>',
				type: 'POST',
			    data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				beforeSend: function(){
					   $("#whatsapp_message").prop('disabled', true);
					   $("#whatsapp_message").attr('disabled', true);
				},
				complete: function(){
					  $("#whatsapp_message").prop('disabled', false);
				},
				success: function(response){
					$("#alert-danger-common").html('');
					var htm = '<div class="alert alert-success" role="alert">Message Sent Successfully.</div>';
					$("#alert-danger-common").html(htm);
					setTimeout(function(){
						$("#myModalSendWhatsApp .close").click();
						$("#alert-danger-common").html('');
					}, 3000);
				}
			});
		});

		$("#common_sendMail").click(function(){		
			var data_form = $('#common_email_form').serialize();
			var formData = new FormData($('#common_email_form')[0]);
			
			$.ajax({
				url:'<?php echo site_url('common/sendEmail'); ?>',
				type: 'POST',
			    data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				beforeSend: function(){
					   $("#common_sendMail").prop('disabled', true);
					   $("#common_sendMail").attr('disabled', true);
				},
				complete: function(){
					  $("#common_sendMail").prop('disabled', false);
				},
				success: function(response){
					$("#alert-danger-common").html('');
					var htm = '<div class="alert alert-success" role="alert">Successfully Mail Send.</div>';
					$("#alert-danger-common").html(htm);
					setTimeout(function(){
						$("#myModalSendCommonMail .close").click();
						$("#alert-danger-common").html('');
					}, 3000);
				}
			});				
		});

		$(".mailbox").click(function(){
			var order_id = this.id;
			$.ajax({
				url:'<?php echo site_url('order/orderSavePdf'); ?>',
				method: 'post',
				data: 'order_id='+order_id, 
				dataType: 'json',
				beforeSend: function(){
					   $('.loader').show();
				   },
				complete: function(){
					   $('.loader').hide();
				},
				success: function(response){
				    if(response){						
						var htm = '';
						var hiddentext = '';
						var email = '';						
						var subject = '';						
						var massage = '';
						
						$.each(response, function(i,res) {							
							htm += '<a href="<?php echo base_url(); ?>'+ res.order_file +'" target="_blank" > '+ res.order_file_name +' </a> &nbsp;';							
							hiddentext += '<input type="hidden" name="order_file" value="'+res.order_file+'">';
							email = res.email_to;
							subject = res.order_id;
							massage = 'Dear '+res.person+'\n\n';
							massage += 'Please find the Order as attached in email bellow.'+'\n\n';
							massage += 'Thank you,'+'\n';
							massage += 'Optitech Eye Care';
						});
						
						$("#orderfile").html(htm);						
						$("#orderfiletextbox").html(hiddentext);
						$("#email_to").val(email); 
						$("#email_subject").val('Order / Performa Invoice - '+subject); 
						$("#email_massage").val(massage); 
					}
					$("#myModalSendMail").modal();		
				}
			});				
		});
		
		$("#sendMail").click(function(){		
			var data_form = $('#orderMailForm').serialize();
			$.ajax({
				url:'<?php echo site_url('orderSendMail'); ?>',
				method: 'post',
				data: data_form,
				dataType: 'json',
				success: function(response){
					$("#alert-danger").html('');
					var htm = '<div class="alert alert-success" role="alert">Successfully Mail Send.</div>';
					$("#alert-danger").html(htm);
					setTimeout(function(){
						$("#myModalSendMail .close").click();
						$("#alert-danger").html('');
					}, 3000);
				}
			});				
		});
		
		// Get Customer name autocomplete
		/* $('#company_name').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url:'<?php echo site_url('getCustomerName'); ?>',
					type: "POST",
					data: 'name=' + request,  
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {							
							return {								
								label: item['company_name'],
								value: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				if(item['value']){
					$('#company_name').val(item['label']);									
				}
			}
		}); */
		
		$('#company_name').autocomplete({
			'source': function(request, response) {
				var apiUrl='<?php echo site_url('getCustomerName'); ?>';
				var value = $('#company_name').val();
				$.ajax({
					url:apiUrl,
					data: 'name=' + value,  
					type: "POST",
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {	
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item['company_name'],
								id: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(event , ui) {
				$('#company_name').val(ui.item['label']);
			},
			minLength : 3
		});
		
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
		
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".form-control").keypress(function(event) { 
		if (event.keyCode === 13) {
			if(this.id!='email_massage' && this.id!='email_subject' && this.id!='email_cc' && this.id!='email_to' && this.id!='common_email_massage' && this.id!='common_email_subject' && this.id!='common_email_cc' && this.id!='common_email_to'  && this.id!='wa_message'){
				$("#button-filter").click();				
			}
			//$("#button-filter").click();				
		} 
	});

	
	
	$("#button-filter").click(function(){
		var url = '<?php echo site_url($form_action);?>';		
		var data_form = $("#filterForm :input")
				.filter(function(index, element) {
					return $(element).val() != '';
				})
				.serialize();
		
		if (data_form) {
			url += '?' + (data_form);
		}		
		location = url; 
	});
	
	
		var productId = '<?php echo $this->input->get("model"); ?>';
		$('#product_name').autocomplete({
			'source': function(request, response) {
				var apiUrl='<?php echo site_url('getProductName'); ?>';
				var value = $('#product_name').val();
				$.ajax({
					url:apiUrl,
					data: 'name=' + value,
					type: "POST",
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {	
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item.product_name
							}
						}));
					}
				});
			},
			'select': function(event , ui) {
				$('#product_name').val(ui.item['label']);
				 var value = ui.item['label'];
				$.ajax({
					url:'<?php echo site_url('getProductModel');?>',
					method: 'post',
					data: 'name=' + encodeURIComponent(value), 
					dataType: 'json',
					success: function(response){
						var htm = '<option value="">Select model</option>';					
						$.each(response, function(i,res) {
							if(res.product_id == productId){
								htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
							} else {
								htm += '<option value="'+ res.product_id +'"  >'+ res.model +'</option>';
							}						
						});		
						$("#input-model").html(htm);
					}
				});	 	
			},
			minLength : 3
		});
		
		/* $('#product_name').typeahead({			
				source: function (query, result) {				
					$.ajax({
						url:'<?php echo site_url('getProductName'); ?>',
						data: 'name=' + query,            
						dataType: "json",
						type: "POST",
						success: function (data) {
							result($.map(data, function (item) {
								return item.product_name;
								//return item.name;
							}));
						}
					});
				}
		}); */
		
		$('#product_name').on('autocompletechange change', function () {			
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + encodeURIComponent(this.value), 
				dataType: 'json',
				success: function(response){
					var htm = '<option value="">Select model</option>';					
					$.each(response, function(i,res) {
						if(res.product_id == productId){
							htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
						} else {
							htm += '<option value="'+ res.product_id +'"  >'+ res.model +'</option>';
						}						
					});		
					$("#input-model").html(htm);
				}
			}); 	
		}).change();
		
		
	
		$(".missingFields").click(function(){
			var order_id = this.id;
			var payLink = '<a class="btn btn-primary" target="_blank" href="<?php echo site_url('paymentAdvice'); ?>/'+order_id+'">Manage Payment</a>';
			var order_currency = $(this).attr("data-currency");	
			var orderTotal = $(this).attr("data-value");
			var orderPayment = $(this).attr("data-payment");					
			var	order_total = '<i class="'+order_currency+'" style="font-size:13px;"></i>&nbsp;' + orderTotal;
			var order_payment = '<i class="'+order_currency+'" style="font-size:13px;"></i>&nbsp;' + orderPayment;
			
			$.ajax({
				url:'<?php echo site_url('order/getChallanMissingFields'); ?>',
				method: 'post',
				data: 'order_id='+order_id, 
				dataType: 'json',
				beforeSend: function(){
					   $('.loader').show();
				   },
				complete: function(){
					   $('.loader').hide();
				},
				success: function(response){
						var htm = '';
						var ord = '';
						if(response != ''){
							$.each(response, function(i,res) {							
								var invoice_date = '';
								if(res.invoice_date != '0000-00-00 00:00:00'){
									invoice_date = formatDate(res.invoice_date);
								}
								var date_of_shipment = '';
								if(res.date_of_shipment != '0000-00-00 00:00:00'){	
									date_of_shipment = formatDate(res.date_of_shipment);
								}
								
								var actionBtn = '';
								if(res.method_of_shipment == '' || res.docket_no == '' || res.sb_number == '' || res.invoice_no == ''){
									var actionBtn = '<a target="_blank" href="<?php echo site_url('dispatchNote'); ?>/'+res.challan_id+'" title="Add Missing Field"><i class="fas fa-plus"></i></a>';
								}							
																
								var cross = '<td align="center"><i class="fa fa-times" style="color:red" aria-hidden="true"></i></td>';
								var tick = '<td align="center"><i class="fa fa-check" style="color:green" aria-hidden="true"></i></td>';
								
								htm += '<tr>';							
								htm += '<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/'+res.challan_id+'">'+res.challan_no+'</a></td>';
								
								if(res.method_of_shipment){
									htm += tick;
								} else {
									htm += cross;
								}								
								
								if(res.docket_no){
									htm += tick;
								} else {
									htm += cross;
								}
								
								if(res.sb_number){
									htm += tick;
								} else {
									htm += cross;
								}
								
								if(res.invoice_no){
									htm += tick;
								} else {
									htm += cross;
								}
															
								htm += '<td align="center">&nbsp;&nbsp;'+actionBtn+'&nbsp;&nbsp;</td>';							
								htm += '</tr>';	
								ord = res.order_id	
							});
						} else {
							htm += '<tr>';
							htm += '<td align="center" colspan="11">Challan not created for this order.</td>';					
							htm += '</tr>';	
						}
						
						$("#orderTotal").html(order_total);					
						$("#orderPayment").html(order_payment);					
						$("#ordMiss").html(ord);					
						$("#paymentLink").html(payLink);					
						$("#challanlist").html(htm);					
					$("#filterMissingFields").modal();			
				}
			});				
			
		});
		
	function formatDate(date) {
		var d = new Date(date),
			 month = '' + (d.getMonth() + 1),
			 day = '' + d.getDate(),
			 year = d.getFullYear();

		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		return [day, month, year].join('-');
	}
	
	
	
}); 
</script> 