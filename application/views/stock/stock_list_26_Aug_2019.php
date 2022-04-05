<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	 <?php echo $this->breadcrumbs->show(); ?>	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">
				<h5><?php echo $page_heading; ?></h5>
			</div> 
			<div class="col-sm-6">
				<div class="float-right">
					<a href="<?php echo site_url('stock/stockListDownload'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> &nbsp; 
				</div>
			</div> 
		</div> 		
	</div>
	 
	 <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
		 
  <div class="card mb-3">	
	<div class="card-body">
	
		<form role="form" class="needs-validation" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>	
			<div class="row">														
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Batch No</div> 
					<input type="text" name="batch_no" value="<?php if(!empty($this->input->get('batch_no'))){ echo $this->input->get('batch_no'); } ?>" id="batch_no" class="form-control" >
					</div>
				</div>
			
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Product Name / Description</div> 
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" >
					</div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Model</div> 
					<input type="text" name="model" value="<?php if(!empty($this->input->get('model'))){ echo $this->input->get('model'); } ?>" id="model" class="form-control">
					</div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Store</div> 
					<select name="store_id" id="store_id" class="form-control" required>
						<option value="0">-- Select Store --</option>
						<?php if(isset($stores)){ ?>
							<?php foreach($stores as $store){ ?>
								
								<option value="<?php echo $store['store_id']; ?>" <?php if(isset($store_id) && $store_id == $store['store_id']) { echo ' selected="selected"'; } ?>><?php echo $store['store_name']; ?></option>
								
							<?php } ?>
						<?php } ?>
					</select>
					
				  </div>
				</div>
				
			    <div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Date</div> 
					<input type="text" name="date_from" value="<?php if(!empty($this->input->get('date_from'))){ echo $this->input->get('date_from'); } ?>" id="model" class="form-control date">
					</div>
				</div>
				
			</div>	
			<div class='row'>
				<div class="col-sm-12 float-right">
					<div class="form-group">
						<button type="submit" id="submit" class="btn btn-primary float-right">Search</button>
					</div>
					<br>
				</div>
			</div>
		</form>		
	
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  <th>Store name</th>
			  <th>Product Name</th>
			  <th>Model</th>
			  <th>Quantity</th>
			  <th>Pack Unit</th>
			  <th>Batch No</th>
			  <th>Expiry Date</th>
			  <th>Action</th>
			</tr>
		  </thead>		 
		  <tbody>
			<?php if(($stocks)){ ?>
				<?php foreach($stocks as $stock){ ?>
				        
				        <?php
						    $expDate = new DateTime($stock['s_exp_date']);
						    $mfgDate = new DateTime($stock['s_mfg_date']);
						?>
					  <tr>
						<td><?php echo $stock['store_name']; ?></td>
						<td><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $stock['product_id']; ?>"><?php echo $stock['product_name']; ?></a></td>
						<td><?php echo $stock['model']; ?></td>
						<td><?php echo ($stock['qty'] - $stock['challan_qty']) + $stock['return_qty']; ?></td>
						<td><?php echo $stock['unit_name']; ?></td>
						<td><?php echo $stock['batch_no']; ?></td>						
						<td><?php echo $expDate->format('m/Y'); ?></td>
						 <!-- <td>&nbsp;&nbsp;&nbsp;<a href="<?php //echo site_url('stockPrint'); ?>/<?php echo $stock['batch_id']; ?>" target="_blank" title="Print Stock"><i class="fas fa-print"></i></a> &nbsp;</td> --> 
						<td>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('stockSummary'); ?>?batch_id=<?php echo $stock['batch_id']; ?>&store_id=<?php echo $stock['store_id']; ?>" target="_blank" title="Stock Summary"><i class="fas fa-print"></i></a> &nbsp;</td>
					  </tr>
				<?php } ?>  
			<?php } else { ?>
				<tr>
					<td class="text-center" colspan="8">No results!</td>
				</tr>
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	  <?php echo $pagination; ?>
	</div>
	
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
</div>

<script>
	$(document).ready(function(){
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
<script>
	$(document).ready(function(){
		$('#product_name').typeahead({			
			source: function (query, result) {				
				$.ajax({
					url:'<?php echo site_url('getProductName'); ?>',
					data: 'name=' + query,            
					dataType: "json",
					type: "POST",
					success: function (data) {
						result($.map(data, function (item) {
							return item.product_name;
						}));
					}
				});
			}
		});		
	});
</script>	