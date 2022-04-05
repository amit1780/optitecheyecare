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
	<style>
		.auto ul{width:100%;padding-left:6px;}
		.auto ul{max-height: 200px;overflow-y: scroll};		
	</style>
  <div class="card mb-3">	
	<div class="card-body">		
		<form role="form" class="needs-validation" id="filterForm" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">
			
				<div class="col-sm-3">
					<div class="form-group">
						<div class="control-label" >Complaint id</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titleComplain"><?php echo "SR".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
									
									<?php echo financialList($dropdown='complaindropdown',$type='SR'); ?>
									
								</div>
							 </div>	
							 
							<input type="text" name="complaint_id" style="width:50%;" value="<?php echo idFormat($this->input->get('complaint_id')); ?>" id="complaint_id" class="form-control">						
							<input type="hidden" name="fcomyear" value="" id="fcomyear" class="form-control">						
						</div>
					</div>
				</div>
				
			
				<!-- <div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Complaint id</div> 
					<input type="text" name="complaint_id" value="<?php if(!empty($this->input->get('complaint_id'))){ echo $this->input->get('complaint_id'); } ?>" id="complaint_id" class="form-control" >				
				  </div>
				</div> -->	
				
				
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Username</div> 
					<select name="user_id" class="form-control">
						<option value=''>-Select-</option>
						<?php if(isset($users)){ ?>
						<?php foreach($users as $user){ ?>
							
							<option value="<?php echo $user['user_id']; ?>" <?php if($this->input->get('user_id') == $user['user_id']) { echo ' selected="selected"'; } ?>>
							<?php echo $user['username']; ?></option>
							
						<?php } ?>
					<?php } ?>
					</select>					
				  </div>
				</div>	
			
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Company Name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" >				
				  </div>
				</div>	
				
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Category of Complaint</div> 
					<select name="complaint_category_id" id="complaint_category_id" class="form-control" required>
						<option value="">-- Seclect --</option>
						<?php if($complaintCategories){ ?>
							<?php foreach($complaintCategories as $complaintCategory){ ?>
								<option value="<?php echo $complaintCategory['complaint_category_id']; ?>" <?php if($this->input->get('complaint_category_id') == $complaintCategory['complaint_category_id']) { echo ' selected="selected"'; } ?> ><?php echo $complaintCategory['complaint_category_name']; ?></option>
							<?php } ?>
						<?php } ?>									
					</select>					
				  </div>
				</div>

				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Sub-Category of Complaint</div> 
					<select name="category_id" id="category_id" class="form-control" required>
						<option value="">-- Seclect --</option>
						<?php if($categories){ ?>
							<?php foreach($categories as $category){ ?>
								<option value="<?php echo $category['category_id']; ?>" <?php if($this->input->get('category_id') == $category['category_id']) { echo ' selected="selected"'; } ?> ><?php echo $category['name']; ?></option>
							<?php } ?>
						<?php } ?>
					</select>					
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Mode of Complaint</div> 
					<select name="complaint_mode_id" id="complaint_mode_id" class="form-control" required>
						<option value="">-- Seclect --</option>
						<?php if($complaintModes){ ?>
							<?php foreach($complaintModes as $complaintMode){ ?>
								<option value="<?php echo $complaintMode['complaint_mode_id']; ?>" <?php if($this->input->get('complaint_mode_id') == $complaintMode['complaint_mode_id']) { echo ' selected="selected"'; } ?> ><?php echo $complaintMode['complaint_mode_name']; ?></option>
							<?php } ?>
						<?php } ?>
					</select>				
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Status</div> 
					<select name="status" id="status" class="form-control" required>
						<option value="">-- Seclect --</option>
						<option value="Unresolved">Unresolved</option>
						<option value="Resolved">Resolved</option>						
					</select>				
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
				
				
				<div class="col-sm-4">
					<div class="form-group"><br>
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button><br>
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
				  <th>Complaint id</th>				 
				  <th>Company Name</th>
				  <th>Category of Complaint</th>
				  <th>Sub-Category of Complaint</th>
				  <th>Mode of Complaint</th>
				  <th>Concern Department for Action </th>					  
				  <th>Date of Customer Intimation </th>					  
				  <th>Date of Complaint </th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>		 
				<?php if($complaints){ ?>
					<?php foreach($complaints as $compaint){ ?>
						  <tr>							
							<td><a href="<?php echo site_url('complaintView'); ?>/<?php echo $compaint['complaint_id']; ?>"  title="View" ><?php echo getComplaintId($compaint['complaint_id']); ?></a></td>							
							<td><?php echo $compaint['company_name']; ?></td>
							<td><?php echo $compaint['complaint_category_name']; ?></td>
							<td><?php echo $compaint['product_category']; ?></td>
							<td><?php echo $compaint['complaint_mode_name']; ?></td>
							<td><?php echo $compaint['concern_dept_name']; ?></td>							
							<td><?php echo dateFormat('d-m-Y',$compaint['date_of_customer_info']); ?> </td>					
							<td><?php echo dateFormat('d-m-Y',$compaint['date_of_complaint']); ?></td>
							<?php
								if($compaint['status'] == 'Unresolved'){
									$color = 'red';
								} else {
									$color = 'green';
								}
							?>							
							<td style="color:<?php echo $color; ?>;"><?php echo $compaint['status']; ?></td>					
							
							<td class="">
								<a class="tdBtn" href="<?php echo site_url('complaintView'); ?>/<?php echo $compaint['complaint_id']; ?>"  title="View" ><i class="fas fa-eye"></i></a>
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
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
</div>
<script>
$(document).ready(function() {
	var date_input=$('.date'); //our date input has the name "date"
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input.datepicker({
		dateFormat: 'yy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
	});

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
			//$('#customer_id').val(ui.item['id']);
		},
		minLength : 3
	});
	
}); 
</script> 