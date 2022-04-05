<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
  <?php echo $this->breadcrumbs->show(); ?>	
	<div class="page_heading">
		<h5><?php echo $page_heading; ?></h5>		
	</div>
	
	 <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	<div id="mass"></div>
	<style>
		.reject{color:white !important;}
		.btn{color:white !important;}
		.tile{margin-bottom: 15px;
		border-radius: 3px;
		/* background-color: #279FE0; */
		color: #FFFFFF;
		transition: all 1s;
		}
		.tile-heading {
			padding: 5px 8px;
			text-transform: uppercase;
			/* background-color: #1E91CF; */
			color: #FFF;
			}
		.tile-body {
			padding: 15px;
			color: #FFFFFF;
			line-height: 48px;
		}
		.tile-footer {
			padding: 0px;
			background-color: #3DA9E3;
		}
		.tile a {
			color: #FFFFFF;
		}
		.tile .tile-body i {
			font-size: 50px;
			opacity: 0.3;
			transition: all 1s;
		}
		.tile .tile-body h2 {
			font-size: 42px;
		}
		.pull-right {
			float: right !important;
		}
		.orange{background-color: #e9967a;}
		.blue{background-color: #1E90FF;}
		.green{background-color: #00C292;}
		.perpal{background-color: #9675CE;}
	</style>
	
	
	
	<div id="dashboard" class="tab-pane active">				
			<div class="row">
				<div class="col-sm-3">
					<div class="tile orange">
					<a target="_blank" href="<?php echo site_url('quotation'); ?>">
					  <div class="tile-heading">Pending Quotation </div>
					  <div class="tile-body"><i class="fas fa-quote-left"></i>
						<h2 class="pull-right"><?php echo count($quotations); ?></h2>
					  </div>
					</a>
					  <!-- <div class="tile-footer"><a target="_blank" class="nav-link"  href="<?php echo site_url('quotation'); ?>">View more...</a></div> -->
					</div> 
				</div>
				<div class="col-sm-3">
					<div class="tile blue">
					<a target="_blank" href="<?php echo site_url('orderList'); ?>">
					  <div class="tile-heading">Pending Orders </div>
					  <div class="tile-body"><i class="fa fa-shopping-cart"></i>
						<h2 class="pull-right"><?php echo count($orders); ?></h2>
					  </div>
					 </a>
					  <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('orderList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				<div class="col-sm-3">
					<div class="tile green">
					<a target="_blank" href="<?php //echo site_url('challanList'); ?>">
					  <div class="tile-heading">Pending Stock</div>
					  <div class="tile-body"><i class="fas fa-file-invoice"></i>
						<h2 class="pull-right"><?php echo count($pending_stocks); ?></h2>
					  </div>
					 </a>
					<!--  <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div>  -->
					</div>  
				</div>
				<div class="col-sm-3">
					<div class="tile perpal">
					  <div class="tile-heading">Pending Payment Received Advice </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php //echo $returnQty; ?></h2>
					  </div>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> -->
					</div>  
				</div>
				
				<!--   Totals  -->				
				<div class="col-sm-3">
					<div class="tile blue">
					  <div class="tile-heading">Totals Challans</div>
					  <div class="tile-body"><i class="fas fa-file-invoice"></i>
						<h2 class="pull-right"><?php echo count($pending_stocks); ?></h2>
					  </div>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				<div class="col-sm-3">
					<div class="tile orange">
					  <div class="tile-heading">Totals Customers </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php //echo $returnQty; ?></h2>
					  </div>
					  <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> -->
					</div>  
				</div>	
				
				<div class="col-sm-3">
					<div class="tile perpal">
					  <div class="tile-heading">Stock Rejected </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php //echo $returnQty; ?></h2>
					  </div>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> -->
					</div>  
				</div>	
				
				<div class="col-sm-3">
					<div class="tile green">
					  <div class="tile-heading">Payment Received Advice Rejected </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php //echo $returnQty; ?></h2>
					  </div>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> -->
					</div>  
				</div>	
				
			</div>
		</div>						
			<!-- End Dashboard -->
	<div class="row">
		<div class="col-sm-12">
			<div class="card mb-3">
				<div class="card-header">
				  <i class="fa fa-globe"></i>
				  Worldwide Business</div>				
				  <div class="panel-body">
					<div id="vmap" style="width: 100%; height: 260px;"></div>
				  </div>
			
			</div>
		</div>
	</div>
	
	<link type="text/css" href="<?php echo base_url(); ?>assets/js/jqvmap/jqvmap.css" rel="stylesheet" media="screen" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqvmap/jquery.vmap.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqvmap/maps/jquery.vmap.world.js"></script> 
	
	<script type="text/javascript">
		/* $(document).ready(function() {							
			$("#vmap").vectorMap({
				map: 'world_en',
				backgroundColor: '#FFFFFF',
				borderColor: '#FFFFFF',
				color: '#9FD5F1',
				hoverOpacity: 0.7,
				selectedColor: '#666666',
				enableZoom: true,
				showTooltip: true,
				//values: data,
				normalizeFunction: 'polynomial'
				 onLabelShow: function(event, label, code) {
					 if (json[code]) {
						label.html('<strong>' + label.text() + '</strong><br />' + '<?php echo $text_order; ?> ' + json[code]['total'] + '<br />' + '<?php echo $text_sale; ?> ' + json[code]['amount']);
					} 
				} 
			});				
		}); */
		
		$(document).ready(function() {
			
			$.ajax({
				url:'<?php echo site_url('getMapDetails'); ?>',
				dataType: 'json',
				success: function(json) {
					data = [];
								
					for (i in json) {
						data[i] = json[i]['total'];
					} 
							
					$('#vmap').vectorMap({
						map: 'world_en',
						backgroundColor: '#FFFFFF',
						borderColor: '#FFFFFF',
						color: '#9FD5F1',
						hoverOpacity: 0.7,
						selectedColor: '#666666',
						enableZoom: true,
						showTooltip: true,
						values: data,
						normalizeFunction: 'polynomial',
						onLabelShow: function(event, label, code) {	
							
							if (json[code]) {
								label.html('<strong>' + label.text() + '</strong><br />' + '<?php echo "Customers"; ?> ' + json[code]['total'] + '<br />');
							} 
						}
					});			
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});			
		});
		
	</script> 

<!-- Pandeing Stock -->
<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){ ?>
	<div id="pendingStock"></div>
	<div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Stock Pending</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped display" id="" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Store name</th>
				  <th>Product name</th>
				  <th>Model</th>
				  <th>Batch No</th>
				  <th>Quantity</th>
				  <th>Unit</th>
				  <th>Expiry Date</th>				  
				  <th style="width:25%;">Action</th>
				</tr>
			  </thead>
		  <tbody>			
			<?php if(isset($pending_stocks)){ ?>
				<?php foreach($pending_stocks as $stock){ ?>				        
				        <?php
						    $expDate = new DateTime($stock['s_exp_date']);
						    $mfgDate = new DateTime($stock['s_mfg_date']);
						?>
					  <tr>
						<td><?php echo $stock['store_name']; ?></td>
						<td><?php echo $stock['product_name']; ?></td>
						<td><?php echo $stock['model']; ?></td>
						<td><?php echo $stock['batch_no']; ?></td>
						<td><?php echo $stock['qty']; ?></td>
						<td><?php echo $stock['unit_name']; ?></td>
						<td><?php echo $expDate->format('m/Y'); ?></td>						
						<td class="text-center">
						<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){ ?>
							<a class="reject btn btn-primary" id="reject_<?php echo $stock['stock_id']; ?>">Reject</a>&nbsp;&nbsp;
						<?php } ?>
						<a class="approved btn btn-primary" id="approve_<?php echo $stock['stock_id']; ?>">Approve</a></td>
					  </tr>
				<?php } ?>  
			<?php } ?>			
		  </tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
  
  
  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width:800px;">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Approve Stock</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess"></div>
			<div class="modal-body" style="padding:2rem;">
				<div id="batch_details">
					
				</div><br>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="hidden" name="stock_id" id="stock_id" value="">
							<button type="button" id="approvedBtn" class="btn btn-primary float-right"> Approve</button>	
						</div>
					</div>
				</div>			  
			</div>
		  </div>
		</div>
	</div>
  <!-- End Pandeing Stock --> 
<?php } ?>  

<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='PRODUCTION'){ ?>
   <!-- Reject Stock List -->
  <div id="rejectedStock"></div>
  <div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Stock Rejected</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped display" id="" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Store name</th>
				  <th>Product name</th>
				  <th>Model</th>
				  <th>Batch No</th>
				  <th>Quantity</th>
				  <th>Unit</th>
				  <th>Expiry Date</th>				  
				  <th>Action</th>
				</tr>
			  </thead>
		  <tbody>			
			<?php if(isset($reject_stocks)){ ?>
				<?php foreach($reject_stocks as $stock){ ?>
				        
				        <?php
						    $expDate = new DateTime($stock['s_exp_date']);
						    $mfgDate = new DateTime($stock['s_mfg_date']);
						?>
					  <tr>
						<td><?php echo $stock['store_name']; ?></td>
						<td><?php echo $stock['product_name']; ?></td>
						<td><?php echo $stock['model']; ?></td>
						<td><?php echo $stock['batch_no']; ?></td>
						<td><?php echo $stock['qty']; ?></td>
						<td><?php echo $stock['unit_name']; ?></td>
						<td><?php echo $expDate->format('m/Y'); ?></td>						
						<td class="text-center">
							&nbsp;&nbsp;&nbsp;<a href="#" class="addStock" id="addStockId_<?php echo $stock['stock_id']; ?>" title="Add Stock"><i class="fas fa-plus"></i></a>
							&nbsp;&nbsp;&nbsp;<a href="#" onClick="delStock(<?php echo $stock['stock_id']; ?>);" title="Delete Stock"><i class="fa fa-trash"></i></a>
						</td>
					  </tr>
				<?php } ?>  
			<?php } ?>  
			
		  </tbody>
		</table>
	  </div>
	</div>
	 
	<div class="modal fade" id="myModalReject" role="dialog">
		<div class="modal-dialog" style="max-width:900px;">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add Stock</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess1"></div>
			<div class="modal-body" style="padding:1rem;">
				<form method="post" action="" id="addStockform" >
					<table class="table-sm table-bordered table-striped" id="" width="100%" cellspacing="0">
							<thead>
								<tr>								  
								  <th>Product name</th>
								  <th>Model</th>
								  <th>Batch No</th>
								  <th>Qty</th>
								  <th>Unit</th>
								  <th>Expiry Date</th>								  
								</tr>
							</thead>
							<tbody id="stockdetails">			
							</tbody>
					</table>				
					<br>				
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label" ><b>Store</b> </div> 
								<?php $i=0; foreach($stores as $store){ ?>										
									<div class="form-check form-check-inline">
									  <!-- <input class="form-check-input storeId" type="radio" name="store_id" value="<?php //echo $store['store_id']; ?>" required <?php //if($i==0){ echo "checked"; } ?>> --> 
									  <input class="form-check-input storeId" type="radio" name="store_id" id="storeId_<?php echo $store['store_id']; ?>" value="<?php echo $store['store_id']; ?>" <?php if($stocks->store_id == $store['store_id']){ echo "checked"; } ?> required>  
									  <label class="form-check-label"><?php echo $store['store_name']; ?></label>
									</div>
								<?php $i++; } ?>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label" ><b>Quantity</b></div> 
									<input type="text" name="qty" value="" id="input-qty" class="form-control" style="width:30%;" required>
							</div>
						</div>
					</div>	
				
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<button type="button" id="addStockBtn" class="btn btn-primary float-right"> Add Stock</button>	
							</div>
						</div>
					</div>	
				</form>
			</div>
		  </div>
		</div>
	</div>
	
  </div>
  <!-- End Reject Stock List --> 
  <?php } ?>  
 <!-- Pandeing Order List --> 
  <!-- <div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Order Pending</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped display" id="" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Order Id</th>
				  <th>Quotation No</th>
				  <th>Customer Name</th>
				  <th>Currency</th>
				  <th>Order Date</th>
				  <th>Action</th>
				 </tr>
			  </thead>
		  <tbody>
			<?php if(isset($orders)){ ?>				
				<?php foreach($orders as $order){ ?>				
					  <tr>
						<td><?php echo str_pad($order['order_id'], 6, "O00000", STR_PAD_LEFT); ?></td>
						<td><?php echo str_pad($order['quotation_id'], 6, "Q00000", STR_PAD_LEFT); ?></td>
						<td><?php echo $order['customer_name']; ?></td>
						<td><?php echo $order['currency']; ?></td>
						<td><?php echo date('d-m-Y',strtotime($order['order_date'])); ?></td>						
						<td class="">
							&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>" title="Order View" ><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
							<?php  if($order['totalOrderProduct'] > 0){  ?>
								<a href="<?php echo site_url('challan'); ?>?order_id=<?php echo $order['order_id']; ?>" title="Create Challan"><i class="fas fa-plus"></i></a>
							<?php } ?>
						</td>
					  </tr>
				<?php } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	</div>
	
  </div> -->
  <!-- End Pandeing Order List --> 
  
  <!-- Pandeing Payment Receive Advice List --> 
  <div id="mass3"></div>
  <div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Payment Received Advice Pending</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped display" id="" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Bank Name</th>					
					<th>Bank Ref. No</th>
					<!-- <th>Currency</th> -->
					<th>Amount</th>
					<th>Bank File</th>
					<th>Date Of Payment</th>
					<th style="width:25%;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($advices as $advice){ ?>
					<?php $date_added = new DateTime($advice['date_added']); ?>
					<tr>	
						<td><?php echo $advice['bank_name']; ?></td>
						<td><?php echo $advice['bank_ref_no']; ?></td>
						<!-- <td><?php echo $advice['currency']; ?></td> -->
						<td><?php echo $advice['amount']; ?></td>
						<td><a href="<?php echo base_url().'uploads/bank/'.$advice['bank_file']; ?>"><?php echo $advice['bank_file']; ?></a></td>
						<td><?php echo $date_added->format('d-m-Y'); ?></td>
						<td class="text-center">
							<?php if($this->session->userdata('group_type')=='SADMIN'){ ?>
								<a class="advice_reject btn btn-primary" id="advicereject_<?php echo $advice['payment_advice_id']; ?>">Reject</a> &nbsp;&nbsp;							
								<a class="advice_approved btn btn-primary" id="adviceapprove_<?php echo $advice['payment_advice_id']; ?>" target="_blank">Approve</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
  
  <div id="mass4"></div>
  <div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Payment Received Advice Rejected</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped display" id="" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Bank Name</th>					
					<th>Bank Ref. No</th>
					<!-- <th>Currency</th> -->
					<th>Amount</th>
					<th>Bank File</th>
					<th>Date Of Payment</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($advicesRejects as $advice_reject){ ?>
					<?php $date_added = new DateTime($advice_reject['date_added']); ?>
					<tr>	
						<td><?php echo $advice_reject['bank_name']; ?></td>
						<td><?php echo $advice_reject['bank_ref_no']; ?></td>
						<!-- <td><?php echo $advice_reject['currency']; ?></td> -->
						<td><?php echo $advice_reject['amount']; ?></td>
						<td><a href="<?php echo base_url().'uploads/bank/'.$advice_reject['bank_file']; ?>"><?php echo $advice_reject['bank_file']; ?></a></td>
						<td><?php echo $date_added->format('d-m-Y'); ?></td>
													
						<td class="text-center">
							&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('paymentAdvice'); ?>/<?php echo $advice_reject['order_id']; ?>?advice_id=<?php echo $advice_reject['payment_advice_id']; ?>" class="addAdvice" id="addAdvice_<?php echo $advice_reject['payment_advice_id']; ?>" title="Add Stock"><i class="fas fa-plus"></i></a>
							&nbsp;&nbsp;&nbsp;<a href="#" onClick="delAdvice(<?php echo $advice_reject['payment_advice_id']; ?>);" title="Delete Stock"><i class="fa fa-trash"></i></a>
						</td>
						
					</tr>
				<?php } ?>
			</tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
  <!-- End Pandeing Order List --> 
	
</div>
<script>
$(document).ready(function(){
	$(".approved").click(function(){
		var stock = (this.id).split('_');
		var stock_id = stock[1];
		$("#stock_id").val(stock_id);
		var base_url = '<?php echo base_url(); ?>';
		$.ajax({
			url:'<?php echo site_url('getStockBatchDetails');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				var	htm2=''
				var	htm=''
					if(response.ce==0){
						response.ce='Non CE';
					}else{
						response.ce='CE';
					}
					if(response.sterlization==1){
						response.sterlization='Yes';
					}else{
						response.sterlization='No';
					}

					var mfg_date = response.mfg_date.split("-");
					var exp_date = response.exp_date.split("-");
					var good_recive_on = response.good_recive_on.split("-");


				htm += '<fieldset class="proinfo"><legend style="font-weight: normal;"><span>Quantity: <b>'+response.qty+'</b> </span> | <span>Pack Unit: <b>'+response.unit_name+'</b></span> </legend>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">IQC:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.iqc+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Product Name:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.product_name+'</b></label></div></div></div>';
				htm += '</div>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Model:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.model+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">CE/Non CE:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.ce+'</b></label></div></div></div>';
				htm += '</div>';

				/*htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">CE/Non CE:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.ce+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Batch Size:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.batch_size+'</b></label></div></div></div>';
				htm += '</div>';*/

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Batch Number:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.batch_no+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Mfg./Neutral Code:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.mfg_neutral_code+'</b></label></div></div></div>';
				htm += '</div>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Mfg. Date:</label></div><div class="col-sm-6"><label class="float-left"><b>'+mfg_date[1]+'/'+mfg_date[0]+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Expiry Date:</label></div><div class="col-sm-6"><label class="float-left"><b>'+exp_date[1]+'/'+exp_date[0]+'</b></label></div></div></div>';
				htm += '</div>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Good Received on:</label></div><div class="col-sm-6"><label class="float-left"><b>'+good_recive_on[2]+'-'+good_recive_on[1]+'-'+good_recive_on[0]+'</b></label></div></div></div>';


				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Sterlization:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.sterlization+'</b></label></div></div></div>';
				htm += '</div>';
				
				if (response.sterlization_file!='')
				{
					htm +='<div class="row" style="border:1px solid gray;">';
					htm +='<div class="col-sm-12" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">File:</label></div><div class="col-sm-6"><label class="float-left"><b><a href='+base_url+'/uploads/'+response.sterlization_file+'></a></b></label></div></div></div>';


				}
				htm += '</fieldset>';

				$("#batch_details").html(htm);
			}
		});
		
		$("#myModal").modal();		
	});
	
	$("#approvedBtn").click(function(){
		var stock_id = $("#stock_id").val();
		var base_url = '<?php echo site_url('dashboard'); ?>';
		$.ajax({
			url:'<?php echo site_url('addStockApprove');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-success" role="alert">Successfully Approved.</div>';
					$("#mess").html(htm);
					
					setTimeout(function(){
						$("#myModal .close").click();						
						$("#mess").html('');
						window.location.replace(base_url);
					}, 2000);
					
					
				}
			}
		});
	});
	
	$('.reject').click(function() {
		if (confirm('Are you sure?')) {
			var stock = (this.id).split('_');
			var stock_id = stock[1];
			var base_url = '<?php echo site_url('dashboard'); ?>';
			$.ajax({
				url:'<?php echo site_url('stockReject');?>',
				method: 'post',
				data: 'stock_id=' + stock_id,
				dataType: 'json',
				success: function(response){
					if(response){
						var htm = '<div class="alert alert-success" role="alert">Successfully Reject.</div>';
						$("#mass").html(htm);
						
						setTimeout(function(){
							$("#mess").html('');
							window.location.replace(base_url);
						}, 3000);
						
						
					}
				}
			});
		}
	});
	
	$(document).ready(function() {
		$('table.display').DataTable();
	} );
	
	$(".addStock").click(function(){
		var stock = (this.id).split('_');
		var stock_id = stock[1];
		$("#stock_id").val(stock_id);
		var base_url = '<?php echo base_url(); ?>';
		$.ajax({
			url:'<?php echo site_url('getStockBatchDetails');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				$('input[name=store_id]').each(function(){
					var store_id = $(this).val();
					if(store_id == response.store_id){
						$("#storeId_"+store_id).prop("checked", true);
					}
				});
				
				$("#input-qty").val(response.qty);
				
				var htm = '';
				var exp_date = response.exp_date.split("-");				
				htm += '<input type="hidden" name="stock_id" value="'+response.stock_id+'">';
				htm += '<tr>';
				htm += '<td>'+response.product_name+'</td>';
				htm += '<td>'+response.model+'</td>';
				htm += '<td>'+response.batch_no+'</td>';
				htm += '<td>'+response.qty+'</td>';
				htm += '<td>'+response.unit_name+'</td>';
				htm += '<td>'+exp_date[1]+'/'+exp_date[0]+'</td>';
				htm += '</tr>';
				
				$("#stockdetails").html(htm);
				
			}
		});
		
		$("#myModalReject").modal();		
	});
	
	$('#addStockBtn').click(function() {		
		var base_url = '<?php echo site_url('dashboard'); ?>';
		var data_form = $('#addStockform').serialize();			
		$.ajax({
			url:'<?php echo site_url('stockUpdate');?>',
			method: 'post',
			data: data_form,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-success" role="alert">Successfully Add.</div>';
					$("#mess1").html(htm);
					
					setTimeout(function(){
						$("#myModalReject .close").click();						
						$("#mess1").html('');
						window.location.replace(base_url);
					}, 3000);
					
					
				}
			}
		});
		
	});
	
	//Advice Approve
	$(".advice_approved").click(function(){
		var advice = (this.id).split('_');
		var advice_id = advice[1];
		var base_url = '<?php echo site_url('dashboard'); ?>';
		
		var checkstr =  confirm('Are you sure you want to Approve?');
		if(checkstr == true){
			$.ajax({
				url:'<?php echo site_url('adviceApprove');?>',
				method: 'post',
				data: 'advice_id=' + advice_id,
				dataType: 'json',
				success: function(response){
					if(response){
						var htm = '<div class="alert alert-success" role="alert">Successfully Approved.</div>';
						$("#mass3").html(htm);
						
						setTimeout(function(){						
							$("#mass3").html('');
							window.location.replace(base_url);
						}, 3000);		
						
					}
				}
			});
		}		
	});
	
	$('.advice_reject').click(function() {
		if (confirm('Are you sure?')) {
			var advice = (this.id).split('_');
			var advice_id = advice[1];
			var base_url = '<?php echo site_url('dashboard'); ?>';
			$.ajax({
				url:'<?php echo site_url('adviceReject');?>',
				method: 'post',
				data: 'advice_id=' + advice_id,
				dataType: 'json',
				success: function(response){
					if(response){
						var htm = '<div class="alert alert-success" role="alert">Successfully Reject.</div>';
						$("#mass3").html(htm);
						
						setTimeout(function(){
							$("#mass3").html('');
							window.location.replace(base_url);
						}, 3000);
						
						
					}
				}
			});
		}
	});
});

function delStock(stock_id){
	var base_url = '<?php echo site_url('dashboard'); ?>';
	var checkstr =  confirm('Are you sure you want to delete Stock?');
	if(checkstr == true){
		$.ajax({
			url:'<?php echo site_url('stockDelete');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-danger" role="alert">Successfully Delete.</div>';
					$("#mass").html(htm);
					
					setTimeout(function(){
						$("#myModal .close").click();						
						$("#mess").html('');
						window.location.replace(base_url);
					}, 3000);		
					
				}
			}
		});
	}
}

function delAdvice(advice_id){
	var base_url = '<?php echo site_url('dashboard'); ?>';
	var checkstr =  confirm('Are you sure you want to delete advice?');
	if(checkstr == true){
		$.ajax({
			url:'<?php echo site_url('adviceDelete');?>',
			method: 'post',
			data: 'advice_id=' + advice_id,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-danger" role="alert">Successfully Delete.</div>';
					$("#mass").html(htm);
					
					setTimeout(function(){
						$("#myModal .close").click();						
						$("#mass").html('');
						window.location.replace(base_url);
					}, 3000);		
					
				}
			}
		});
	}
}
</script>