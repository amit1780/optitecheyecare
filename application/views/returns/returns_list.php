<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;">Goods Return List</h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
	<?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>	    
	<?php } ?>
	 <!-- DataTables Example -->
		<form role="form" class="needs-validation" id="filterForm" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" >
			 <div class="row">														
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Order No</div> 
					<input type="text" name="order_id" id="order_id" value="<?php if(!empty($this->input->get('order_id'))){ echo $this->input->get('order_id'); } ?>" class="form-control" autocomplete="off">
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without O)</span>
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Challan No</div> 
					<input type="text" name="challan_id" id="challan_id" value="<?php if(!empty($this->input->get('challan_id'))){ echo $this->input->get('challan_id'); } ?>" class="form-control" autocomplete="off">
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without C)</span>
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Product Name / Description</div> 
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" autocomplete="off">					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Batch No</div> 
					<input type="text" name="batch_no" value="<?php if(!empty($this->input->get('batch_no'))){ echo $this->input->get('batch_no'); } ?>" class="form-control" autocomplete="off">					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Store</div> 
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
					<div class="form-group"></br>
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button>
					</div>
				</div>
				
			</div> 	
		</form> 
	 
  <div class="card mb-3">
	
	<div class="card-body">
		
	  <div class="table-responsive">
		<table class="table-sm table-bordered" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Order&nbsp;No</th>
				  <th>Challan&nbsp;No</th>
				   <th>Store</th>
				  <th>Product Description</th>
				 
				  <th>Batch&nbsp;No.</th>
				  <th>Exp. Date</th>
				  <th>Qty Sold</th>
				  <th>Qty Returns</th>
				  <th>Return Date</th>
				  <th>Action</th>
				 </tr>
			  </thead>
		  <tbody>
			<?php if(($challanProInfo)){ ?>
				
				<?php foreach($challanProInfo as $challanPro){ ?>
					<?php
						if($challanPro['return_qty'] == 0){
							continue;
						}					
						$expDate = dateFormat('m/Y',$challanPro['batch_exp_date']);						
					?>
					  <tr>
						<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challanPro['order_id']; ?>" ><?php echo getOrderNo($challanPro['order_id']); ?></a></td>
						<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challanPro['challan_id']; ?>" ><?php echo getChallanNo($challanPro['challan_id']); ?></a></td>
						<td><?php echo $challanPro['store_name']; ?></td>
						<td><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $challanPro['product_id']; ?>"><b><?php echo $challanPro['pro_model']; ?></b> | <?php echo $challanPro['pro_description']; ?></a></td>
						
						<td><?php echo $challanPro['batch_no']; ?></td>
						<td><?php echo $expDate; ?></td>
						<td><?php echo $challanPro['qty']; ?></td>
						<td><?php echo $challanPro['return_qty']; ?></td>
						<td><?php echo dateFormat('d-m-Y', $challanPro['return_datetime']); ?></td>						

						<td class="text-center"> 
							<a href="<?php echo site_url('addReturns'); ?>?challan_no=<?php echo $challanPro['challan_id']; ?>&id=<?php echo $challanPro['challan_pro_id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
							
							<!-- <a style="padding-left:7px;" href="<?php echo site_url('returnsPrint'); ?>?challan_no=<?php echo $challanPro['challan_id']; ?>&id=<?php echo $challanPro['challan_pro_id']; ?>" title="Returns Print" target="_blank"> <i class="fas fa-print"></i></a> -->
							<a style="padding-left:7px;" href="<?php echo site_url('returnsPrint'); ?>?challan_no=<?php echo $challanPro['challan_id']; ?>" title="Returns Print" target="_blank"> <i class="fas fa-print"></i></a>
						</td>
					  </tr>
				<?php } ?>  
			<?php } else { ?>
					<tr>
						<td class="text-center" colspan="10">No results!</td>
					</tr>
			<?php } ?> 
		  </tbody>
		</table>
	  </div>
	</div>
	<?php echo $pagination; ?>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
</div>
<script>
	$(document).ready(function(){
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
						}));
					}
				});
			}
		}); */

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
				 /* var value = ui.item['label'];
				 var product_id = '<?php echo $batchinfo->product_id;  ?>';
				$.ajax({
					url:'<?php echo site_url('getProductModel');?>',
					method: 'post',
					data: 'name=' + encodeURIComponent(value), 
					dataType: 'json',
					success: function(response){
						var htm = '<option value="">Select model</option>';					
						$.each(response, function(i,res) {
							if(res.product_id == product_id){
								htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
							} else {
								htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
							}	
						});		
						$("#input-model").html(htm);
					}
				}); */	 	
			},
			minLength : 3
		});
		
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".form-control").keypress(function(event) { 
		if (event.keyCode === 13) { 
			$("#button-filter").click();				
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
}); 
</script> 