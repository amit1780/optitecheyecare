<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
		
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
	
	 <!-- DataTables Example -->
	
	<?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
		 
  <div class="card mb-3">	
	<div class="card-body">
	  <form role="form" class="needs-validation" id="filterForm" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">														
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">IQC</div> 
					<input type="text" name="iqc" value="<?php if(!empty($this->input->get('iqc'))){ echo $this->input->get('iqc'); } ?>" id="iqc" class="form-control" >
					
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
				
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Batch No</div> 
					<input type="text" name="batch_no" value="<?php if(!empty($this->input->get('batch_no'))){ echo $this->input->get('batch_no'); } ?>" id="batch_no" class="form-control" >
					
				  </div>
				</div>
				
				<div class="col-sm-4">
					<div class="form-group"><br>
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button>
					</div>
				</div>
				
			</div>	
		</form>
	
	
	  <div class="table-responsive">
		<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  <th>IQC</th>
			  <th>Product Name</th>
			  <th>Model No.</th>			 
			  <th>Batch No.</th>
			  <th>Mfg. Date</th>
			  <th>Exp. Date</th>			 
			  <th>Action</th>
			</tr>
		  </thead>
		  
		  <tbody>
			<?php if(($batches)){ ?>
				<?php foreach($batches as $batch){ ?>				       
					  <tr>
						<td><?php echo $batch['iqc']; ?></td>
						<td><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $batch['product_id']; ?>"><?php echo $batch['product_name']; ?></a></td>
						<td><?php echo $batch['model']; ?></td>						
						
						<td><?php echo $batch['batch_no']; ?></td>
						<td><?php echo dateFormat('m/Y',$batch['mfg_date']);  ?></td>
						<td><?php echo dateFormat('m/Y',$batch['exp_date']); ?></td>
						
						<td> 
							<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='PRODUCTION'){ ?>
								<a href="<?php echo site_url('editBatch'); ?>/<?php echo $batch['batch_id']; ?>"><i class="far fa-edit"></i></a> &nbsp;
								<?php if($batch['del_status'] == 0){ ?>
									<a href="javascript:delPro(<?php echo $batch['batch_id']; ?>);" ><i class="fa fa-trash"></i></a> 
								<?php } ?>
							<?php } ?>
						</td>	
						
					  </tr>
				<?php } ?>  
			<?php } else { ?>
					<tr>
						<td class="text-center" colspan="7">No results!</td>
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
	function delPro(batch_id){
		var checkstr =  confirm('Are you sure you want to delete this Batch?');
		if(checkstr == true){
			var url = '<?php echo site_url('deleteBatch');?>/'+batch_id;
			location = url; 
		} 
	}
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