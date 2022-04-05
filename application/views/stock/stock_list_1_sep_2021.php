<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	 
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">				
				<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
			</div> 
			<div class="col-sm-6">
				<div class="float-right">
					<button type="button" id="create_excel" class="btn btn-primary" title="Create Excel File"><i class="far fa-file-excel"></i></button>&nbsp; 
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
	
		<form role="form" class="needs-validation" id="filterForm" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>	
			<div class="row">														
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Batch No</div> 
					<input type="text" name="batch_no" value="<?php if(!empty($this->input->get('batch_no'))){ echo $this->input->get('batch_no'); } ?>" id="batch_no" class="form-control" >
					</div>
				</div>
			
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Product Name / Description</div> 
					<!--  <div class="control-label">Product / Category Name</div> -->
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" autocomplete="off">
					</div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Model</div> 
					<!-- <input type="text" name="model" value="<?php if(!empty($this->input->get('model'))){ echo $this->input->get('model'); } ?>" id="model" class="form-control"> -->
					<select name="model" id="input-model" class="form-control"></select>
					</div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Store</div> 
					<select name="store_id" id="store_id" class="form-control" required>
						<option value="">-- Select Store --</option>
						<?php if(isset($stores)){ ?>
							<?php foreach($stores as $store){ ?>
								
								<option value="<?php echo $store['store_id']; ?>" <?php if(isset($store_id) && $store_id == $store['store_id']) { echo ' selected="selected"'; } ?>><?php echo $store['store_name']; ?></option>
								
							<?php } ?>
						<?php } ?>
					</select>
					
				  </div>
				</div>
				
			    <div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Date</div> 
					<input type="text" name="date_from" value="<?php if(!empty($this->input->get('date_from'))){ echo $this->input->get('date_from'); } ?>" id="model" class="form-control date">
					</div>
				</div>
				
				<div class="col-sm-2 float-right">
					<div class="form-group"><br>
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button>
					</div>
					
				</div>
				
			</div>	
			
		</form>		
	
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
			  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'store_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $store_sort; ?>" >Store name</a></th>
			  
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'product_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $product_name_sort; ?>" >Product Name</a></th>
			   
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'model')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $model_sort; ?>" >Model</a></th>
			   
			  <th>Quantity</th>
			  
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'unit_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $pack_unit_sort; ?>" >Pack Unit</a></th>
			   
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'batch_no')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $batch_no_sort; ?>" >Batch No</a></th>
			  
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
						<!-- <td><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $stock['product_id']; ?>"><?php echo $stock['name']; ?></a></td> -->
						<td><?php echo $stock['model']; ?></td>
						<td><?php echo ($stock['qty'] - $stock['challan_qty']) + $stock['return_qty']; ?></td>
						<td><?php echo $stock['unit_name']; ?></td>
						<td><?php echo $stock['batch_no']; ?></td>						
						<td><?php echo dateFormat('m/Y', $stock['s_exp_date']); ?></td>
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
		var productId = '<?php echo $this->input->get("model"); ?>';
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
	});
</script>
<script> 
 $(document).ready(function(){  
	var base_url = '<?php echo site_url(); ?>';
	$('#create_excel').click(function(){  
		var excel_data = $('#searchResponce').html();  
		var urlll = base_url +"/downloadExcelFile";		
		window.location = urlll;		
		//var formData = $('#advanceSearchForm').serialize();		
		//$.post(urlll, formData)
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