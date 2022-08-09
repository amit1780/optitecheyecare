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
			<div class="col-md-4">
				  <div class="form-group">
					<div class="control-label" >Country</div> 
					<?php $country_id = $this->input->get('country_id'); ?>
					<select name="country_id" id="country_id" class="form-control-sm" onChange="getState(this.value)" >
						<option value="">-- Seclect --</option>
						<?php foreach($countries as $country){ ?>
							<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>
						<?php } ?>
					</select>					
				  </div>
				</div>
				
				<div class="col-md-3 ">
				  <div class="form-group">
					<div class="control-label">State</div> 
						<select name="state_id" id="state_id" class="form-control-sm" >
							<option value="">-- Seclect State--</option>
						</select>					
				  </div>
				</div>
				
				<div class="col-md-3 ">
				  <div class="form-group">
					<div class="control-label">City</div> 
					<input type="text" name="city" value="<?php if(!empty($this->input->get('city'))){ echo $this->input->get('city'); } ?>" id="city" class="form-control-sm" >
					
				  </div>
				</div>
				
				
				<div class="col-md-2">
					<div class="form-group"><br>
						<button type="button" id="search-btn" class="btn btn-primary btn-sm float-right">Search</button>
					</div>
				</div>
				
			</div>	
		</form>
	</div>
	</div>
	<form name='wa_form' id='wa_form' enctype="multipart/form-data">
		<div class="card mb-3">	
			<div class="card-body">	
				<div class="row">
					<div class="col-md-9">
					<textarea class="form-control" style="height:180px !important;" rows="7" name="wa_message" id="wa_message" placeholder='Type your message here.'></textarea>
					</div>
					<div class="col-md-3">
							<div class="row ">
								<div class="col-md-12">
									<div class="form-group">
										<div class="control-label">Schedule Date</div> 
										<input type="date" min='<?php echo date('Y-m-d'); ?>' class="form-control-md" name="schedule_date" id="schedule_date" value="<?php echo date('Y-m-d'); ?>">								
									</div>								
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="checkbox" class="form-control-md" name="is_file" id="is_file">&nbsp;Attach File
									</div>
								</div>
							</div>
							<div class="row d-none" id='attach_file'>
								<div class="col-md-12">
									<input type="file" class="form-control-md" name="wa_file" id="wa_file">
								</div>
							</div>
							
						</div>
					</div>
					<input type="hidden" name="allCustomers" id="allCustomers">
				</div>
				<div class='row'>
					<div class="col-md-3">
						<div class="form-group"><br>
							<button type="button" id="btn-sendmsg" class="btn btn-primary btn-sm" style='margin-left:20px;'>Schedule Message</button>&nbsp;
							<span id='loader' class='d-none'>
							<img class="processing float-right" src="<?php echo base_url('');?>assets/img/loader.gif" alt="loading..">
							</span><br>
						</div>
					</div>
					<div class="col-md-8">
						<div class="alert alert-danger d-none" style='margin-top:10px;' role="alert" id='alert_danger'>
						
						</div>

						<div class="alert alert-success d-none" style='margin-top:10px;' role="alert" id='alert_success'>
						
						</div>
				</div>
				</div>
			</div>
		</div>

		<div class="card mb-3">	
			<div class="card-body">	
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
				td a{color:black;} 

			</style>
			<table class="table-sm table-bordered" id='customerRecords' width="100%" cellspacing="0" style="font-size:10;">
					<thead>
						<tr>
						<th><input type="checkbox" name="select_all" value="1" id="customerRecords-select-all"></th>
						<th style="width:5%;">Customer Id</th>
						<th> Company Name</th>
						
						<th >Contact Person</th>
						
						<th>Email</th>
						
						<th style="width:10%;" >Mobile</th>					 
						</tr>
					</thead>
					<tbody>						
					</tbody>
				</table>
			</div>
		</div>
	</form>

  </div>
</div>

<script>
    $(document).ready(function () {
		//$('#loader').hide();
		$(document).on('click','#btn-sendmsg',function(){
			var msg=$.trim($('#wa_message').val());
			if(!msg){
				$('#alert_danger').html('Please type message to be sent');
				$('#alert_danger').removeClass('d-none');
				$('#alert_danger').show();
				setTimeout(function(){
					$(".alert").hide();			
				}, 4000);
				$('#wa_message').val('');
				return false;
			}
			var len=0;
			var allCustomers='';
            $('input[class=chk_contacts]:checked').each(function () {
				//alert('arun');
                //array.push($(this).val());
				allCustomers=allCustomers+$(this).val()+',';
				len++;
            });
			if(len>0){
				allCustomers=allCustomers.slice(0,-1);
				$('#allCustomers').val(allCustomers);
				var data_form = $('#wa_form').serialize();
				var formData = new FormData($('#wa_form')[0]);
				$.ajax({
					url:'<?php echo site_url('bulkmessage/scheduleWA'); ?>',
					type: 'POST',
					data: formData,
					//async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					beforeSend: function(){
						$('#loader').show();
						$('#loader').removeClass('d-none');
						$("#btn-sendmsg").prop('disabled', true);
						$("#btn-sendmsg").attr('disabled', true);
					},
					success: function(response){
						$('#loader').hide();
						if(response=='success'){
							$('#alert_success').show();
							$('#alert_success').html('Successfully scheduled.');
							$('#alert_success').removeClass('d-none');
							
						}else{
							$('#alert_danger').show();
							$('#alert_danger').html('Some error occured, Please try again.');
							$('#alert_danger').removeClass('d-none');
							
						}

						setTimeout(function(){
							$(".alert").hide();			
						}, 4000);
					}
				});	
			}else{
				$('#alert_danger').show();
				$('#alert_danger').html('Please select Customers to schedule whatsapp message');
				$('#alert_danger').removeClass('d-none');
				setTimeout(function(){
					$(".alert").hide();			
				}, 4000);
			}
		});
		$('#is_file').click(function(){	
			if(($('#is_file').is(":checked"))){
				$('#attach_file').show();
				$('#attach_file').removeClass('d-none');
			}else{
				$('#attach_file').hide();
				$('#attach_file').addClass('d-none');
			}
		});
		$('#search-btn').click(function(){	
			$("#customerRecords").dataTable().fnDestroy();
			var country_id=$('#country_id').val();
			var city=$('#city').val();
			var state_id=$('#state_id').val();
			var dataUrl='<?php echo site_url('bulkmessage/customerList');?>';
			dataUrl=dataUrl+'?country_id='+country_id+'&state_id='+state_id+'&city='+city;
			$('#customerRecords').DataTable({
				aLengthMenu: [
					[25, 50, 100, 200, -1],
					[25, 50, 100, 200, "All"]
				],
				iDisplayLength: 100,
				'ajax': {
					'url': dataUrl
				},
				'columnDefs': [{
				'targets': 0,
				'searchable': false,
				'orderable': false,
				'className': 'dt-body-center',
				'render': function (data, type, full, meta){
					return '<input class="chk_contacts" type="checkbox" name="chkCustomerId[]" value="' + $('<div/>').text(data).html() + '">';
				}
			}],
				'order': [[1, 'asc']]
			});
			$("#btn-sendmsg").prop('disabled', false);
			$("#btn-sendmsg").attr('disabled', false);
		});	

		$('#customerRecords-select-all').on('click', function(){
			// Get all rows with search applied
			var rows = table.rows({ 'search': 'applied' }).nodes();
			// Check/uncheck checkboxes for all rows in the table
			$('input[type="checkbox"]', rows).prop('checked', this.checked);
		});			
    });    
</script>