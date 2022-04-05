<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
	</div>

	<?php if (validation_errors()) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
			<?php echo validation_errors(); ?>
		</div>
	</div>
	<?php elseif (!empty($errorMsg)) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
				<?php echo $errorMsg; ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if (isset($error)) : ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php endif; ?>
	<style>
		.alertmess {
			position: relative;
			padding: .75rem 1.25rem;
			margin-bottom: 1rem;
			border: 1px solid transparent;
				border-top-color: transparent;
				border-right-color: transparent;
				border-bottom-color: transparent;
				border-left-color: transparent;
			border-radius: .25rem;
		}
		.alertdanger {
			color: #721c24;
			background-color: #f8d7da;
			border-color: #f5c6cb;
		}
		
		.auto ul{width:100%;padding-left:6px;}
		.auto ul{max-height: 200px;overflow-y: scroll};	
	</style>
	<?php if (!empty($unique_mess)) : ?>
		<div class="col-md-12" id="masserror">
			<div class="alertmess alertdanger"  role="alert">
				<?php echo $unique_mess; ?> <a href="#" onClick="addUniqueCustomer();" >OK</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="#" onClick="hideuniquemess();" >SKIP</a> 
			</div>
		</div>
	<?php endif; ?>

<script>
$(document).ready(function() {						
	$("#complaintForm").validate({
		rules: {
			company_name: "required",					
			contact_person: "required",				
			/* email: {				
				if ($("#mobile").val()) {
				   return true;
				} else {
					return false;
				}				
			},				
			
			mobile: {
				if ($("#email").val()) {
				   return true;
				} else {
					return false;
				}	
			},			 */		
			country_id: "required"					
		},
		messages: {
			company_name: "Please Select Customer",
			contact_person: "Please Enter Contact Person",
			/* email: "Please enter Email",
			mobile: "Please Enter Mobile", */
			country_id: "Please Enter Quntity"
			
		}
	})

	$('#submit').click(function() {
		$("#complaintForm").valid();
	});
});
</script>

	<form role="form" class="needs-validation" id="complaintForm" data-toggle="validator" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
	<div class="row" style="margin:0px;">
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Complaint Information - <?php if($_SESSION['username']){ echo $_SESSION['username']; } else { echo set_value('username'); } ?></legend>
					<div class="row">

						<!-- <div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label" >User name</div> 
							<input type="text" name="username" value="<?php if($_SESSION['username']){ echo $_SESSION['username']; } else { echo set_value('username'); } ?>" id="username" class="form-control" autocomplete="off" required>							
						  </div>
						</div> -->						
						<input type="hidden" name="user_id" value="<?php if($_SESSION['user_id']) { echo $_SESSION['user_id']; }  ?>">
						
						<div class="col-sm-3 auto">
						  <div class="form-group required">
							<div class="control-label" >Company Name</div> 
							<input type="text" name="company_name" value="<?php echo set_value('company_name'); ?>" id="company_name" class="form-control" autocomplete="off" required>
							
						  </div>
						</div>						
						<input type="hidden" name="customer_id" id="customer_id" value="<?php echo set_value('customer_id'); ?>">

						
						
						<div class="col-sm-3">
						  <div class="form-group required">
							<div class="control-label">Category of Complaint</div> 
								<select name="complaint_category_id" id="complaint_category_id" class="form-control" required>
									<option value="">-- Seclect --</option>
									<?php if($complaintCategories){ ?>
										<?php foreach($complaintCategories as $complaintCategory){ ?>
											<option value="<?php echo $complaintCategory['complaint_category_id']; ?>" <?php echo set_select('complaint_category_id', $complaintCategory['complaint_category_id']); ?>><?php echo $complaintCategory['complaint_category_name']; ?></option>
										<?php } ?>
									<?php } ?>									
								</select>								
						  </div>
						</div>
						
						<div class="col-sm-3" id="categoryProduct">
						  <div class="form-group required">
							<div class="control-label">Sub-Category of Complaint</div> 
								<select name="category_id" id="category_id" class="form-control" required>
									<option value="">-- Seclect --</option>
									<?php if($categories){ ?>
										<?php foreach($categories as $category){ ?>
											<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?> ><?php echo $category['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>		
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group required">
							<div class="control-label">Mode of Complaint</div> 
								<select name="complaint_mode_id" id="complaint_mode_id" class="form-control" required>
									<option value="">-- Seclect --</option>
									<?php if($complaintModes){ ?>
										<?php foreach($complaintModes as $complaintMode){ ?>
											<option value="<?php echo $complaintMode['complaint_mode_id']; ?>" <?php echo set_select('complaint_mode_id', $complaintMode['complaint_mode_id']); ?> ><?php echo $complaintMode['complaint_mode_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>		
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group required">
							<div class="control-label">Concern Department for Action </div> 
								<select name="concern_dept_id" id="concern_dept_id" class="form-control" required>
									<option value="">-- Seclect --</option>
									<?php if($complaintConcernDepts){ ?>
										<?php foreach($complaintConcernDepts as $complaintConcernDept){ ?>
											<option value="<?php echo $complaintConcernDept['concern_dept_id']; ?>" <?php echo set_select('concern_dept_id', $complaintConcernDept['concern_dept_id']); ?> ><?php echo $complaintConcernDept['concern_dept_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>		
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group required">
							<div class="control-label" >Date of Complaint </div> 
							<input type="text" name="date_of_complaint" value="<?php echo set_value('date_of_complaint'); ?>" id="date_of_complaint" class="form-control date" autocomplete="off" required>
							
						  </div>
						</div>	
						
						<!-- <div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label" >Date of Customer Intimation </div> 
							<input type="text" name="date_of_customer_info" value="<?php echo set_value('date_of_customer_info'); ?>" id="date_of_customer_info" class="form-control date" autocomplete="off" required>
							
						  </div>
						</div> -->
						
					</div>
			</fieldset>
		</div>
			
		
			
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Details</legend>
					<div class="row">													
						<div class="col-sm-12">
						   <div class="form-group required">
							<div class="control-label" >Details of Complaint</div> 
							<textarea name="message[complaint]"  id="details_of_complaint" class="form-control" rows="4" required></textarea>
							<span style="color:gray;font-size:11px;">(Please summarise the complaint within 500 words.)</span>
						  </div>
						  <input type="file" name="complaint_file">
						</div>
						
						<!-- <div class="col-sm-6">
						   <div class="form-group">
							<div class="control-label" >Brief of Corrective Action Taken</div> 
							<textarea name="message[corrective]"  id="brief_of_corrective_action" class="form-control text-capitalize" rows="2" required></textarea>							
						  </div>
						  <input type="file" name="corrective_file" required>
						</div>
						
						 <div class="col-sm-6">
							<br/>
						   <div class="form-group">
							<div class="control-label" >Brief of Preventive Action Taken </div> 
							<textarea name="message[preventive]"  id="brief_of_preventive_action" class="form-control text-capitalize" rows="2" required></textarea>							
						  </div>
						</div> -->
						
						<div class="col-sm-12">
							<button type="submit" id="submit" class="btn btn-primary float-right"> Save</button>	
						</div>
					</div>
			</fieldset>
		</div>				
	</div>		
	</form>
</div>

<script>
	$(document).ready(function() {
		var date2 = new Date();		
		date2.setDate(date2.getDate()-15);

		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
			startDate: date2,
		});
	});

    $(document).ready(function () {		
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
								//label: item['company_name']+" # "+item['customer_id'],
								label: item['company_name'],
								id: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				if(item['value']){
					$('#company_name').val(item['label']);				
					$('#customer_id').val(item['value']);					
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
				$('#customer_id').val(ui.item['id']);
			},
			minLength : 3
		});
		
		$("#categoryProduct").hide();
		$("#complaint_category_id").change(function() {
			var val = this.value;
			if(val == 1){
				$("#categoryProduct").show();
			} else {
				$("#categoryProduct").hide();
			}			
		});
		
    }); 
</script>