<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->
  <div class="card mb-3">

	<div class="card-body">
	    
	    
	     <form role="form" class="needs-validation" id="filterForm"  data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">														
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label" >Category</div> 
					<?php
						$category_id = $this->input->get('category_id');
					?>
					<select name="category_id" id="input-category" class="form-control" required>
						<option value="0">Select Category</option>
						<?php if(isset($categories)){ ?>
							<?php foreach($categories as $category){ ?>
								
								<option value="<?php echo $category['category_id']; ?>" <?php if(isset($category_id) && $category_id == $category['category_id']) { echo ' selected="selected"'; } ?>><?php echo $category['name']; ?></option>
								
							<?php } ?>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Required
					</div>
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
					<!-- <input type="text" name="model" value="<?php //if(!empty($this->input->get('model'))){ echo $this->input->get('model'); } ?>" id="model" class="form-control"> -->
					<select name="model" id="input-model" class="form-control"></select>
					</div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">HSN</div> 
					<input type="text" name="hsn" value="<?php if(!empty($this->input->get('hsn'))){ echo $this->input->get('hsn'); } ?>" id="hsn" class="form-control">
					
				  </div>
				</div>			
			</div>	
			<div class='row'>
				<div class="col-sm-12 float-right">
					<div class="form-group">
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button>
					</div>
					<br>
				</div>
			</div>
		</form>
	    <br/>
	  <div class="table-responsive">
		<!--<table class="table-sm table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">-->
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
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'product_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $product_name_sort; ?>" >Product Name</a></th>
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'model')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $model_sort; ?>" >Model</a></th>
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $category_name_sort; ?>" >Category Name</a></th>
				  
				  <th>HSN</th>
				  <th>MRP</th>
				  <th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if(($products)){ ?>
					<?php foreach($products as $product){ ?>				
						<tr>
							<td><?php echo $product['name']; ?></td>
							<td><?php echo $product['model']; ?></td>
							<td><?php echo $product['category_name']; ?></td>
							<td><?php echo $product['hsn']; ?></td>
							<td><?php echo $product['mrp']; ?></td>							
							<td class="text-center">
							    <a href="<?php echo site_url('productView'); ?>/<?php echo $product['product_id']; ?>"><i class="fas fa-eye"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
							    <?php if(($this->session->userdata('user_id') == '1') || ($this->session->userdata('user_id') == '2') || ($this->session->userdata('user_id') == '7') || ($this->session->userdata('user_id') == '11') || ($this->session->userdata('user_id') == '14') || ($this->session->userdata('user_id') == '4')){ ?>
							    <a href="<?php echo site_url('editProduct'); ?>/<?php echo $product['product_id']; ?>" data-toggle="tooltip" data-placement="top" ><i class="far fa-edit"></i></a>
							    <?php } ?>
							  </td>							
						</tr>
					<?php } ?>  
				<?php } else { ?>
					<tr>
						<td class="text-center" colspan="6">No results!</td>
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