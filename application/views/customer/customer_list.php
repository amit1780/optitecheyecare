<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">	
			<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
			</div> 
			<?php $queryString=SVI_Get_Query_string(); ?>
			<div class="col-sm-6">
				<div class="float-right">
					<button type="button" id="create_excel" class="btn btn-primary" title="Create Excel File"><i class="far fa-file-excel"></i></button>&nbsp; 
					<a href="<?php echo site_url('customer/customerListDownload')."?".$queryString; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> &nbsp; 
					
				</div>
			</div> 
		</div> 		
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
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">Customer Id</div> 
					<input type="text" name="customerid" value="<?php if(!empty($this->input->get('customerid'))){ echo $this->input->get(customerid); } ?>" id="customerid" class="form-control" >
					
				  </div>
				</div>	
				
				<div class="col-sm-2 ">
				  <div class="form-group auto">
					<div class="control-label">Customer Name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" >
					
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">Email</div> 
					<input type="text" name="email" value="<?php if(!empty($this->input->get('email'))){ echo $this->input->get('email'); } ?>" id="email" class="form-control" >
					
				  </div>
				</div>
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label">Mobile</div> 
					<input type="text" name="mobile" value="<?php if(!empty($this->input->get('mobile'))){ echo $this->input->get('mobile'); } ?>" id="mobile" class="form-control" >
					
				  </div>
				</div>
				
			
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label" >Country</div> 
					<?php $country_id = $this->input->get('country_id'); ?>
					<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" >
						<option value="">-- Seclect --</option>
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
				
				
				
				<div class="col-sm-8">
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
		td a{color:black;} 

	</style>
		<table class="table-sm table-bordered" width="100%" cellspacing="0">
				  <thead>
					<tr>
					  <th style="width:5%;">Customer Id</th>
					  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'company_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $company_name_sort; ?>" >Company Name</a></th>
					  
					  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'contact_person')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?>><a href="<?php echo $contact_person_sort; ?>" >Contact Person</a></th>
					  
					  <th style="width:15%;" <?php if($this->input->get('order') && ($this->input->get('sort') == 'email')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?>><a href="<?php echo $email_sort; ?>" >Email</a></th>
					  
					  <th style="width:10%;" >Mobile</th>
					   <!-- <th>Phone</th> -->
					  <th style="width:10%;" >Country</th>
					  <th style="width:10%;" >Outstanding Balance</th>
					  <!-- <th>State</th>
					  <th>District</th>
					  <th>City</th>
					  <th>Pin</th>	-->			  
					  <th width="10%" >Action</th>
					</tr>
				  </thead>
				  <tbody>		 
					<?php if($customers){ ?>
						<?php foreach($customers as $customer){ ?>
							<?php
								$outstand_balance = $this->customer_model->getOutStandingBalanceById($customer['customer_id']);
								$customer_amount = ($customer['customer_amount']=='') ? 0 : $customer['customer_amount'];
								$challanTotal = $this->customer_model->getChallanTotalByCustomerId($customer['customer_id']);
								$goodsReturnTotal = $this->customer_model->getCustomerGoodsReturnTotal($customer['customer_id']);
								
								#$outstand_balance=$outstand_balance-$goodsReturnTotal;
								
								$color='';
								
								$outstand_balance = strip_tags($outstand_balance);
								$outstand_balance = preg_replace('/[^0-9-.]+/', '', $outstand_balance);
								$outstand_balance=$outstand_balance-$goodsReturnTotal;
								$outstand_balance=number_format((float)($outstand_balance), 2, '.', '');
								if(($outstand_balance > '0') && ($customer_amount == '0')){
									$color='#ff3b3b';
								}
								
								if(($outstand_balance > '0') && ($customer_amount > '0')){
									$color='#fffa70'; //pink
								}
								
								if(($outstand_balance == '0') && ($challanTotal['net_total'] > '0') && ($customer_amount > '0')){
									$color='#3bff3b';  //green
								}
								
																	
								if(($outstand_balance == '0') && ($customer_amount == '0')){
									$color='';  //white
								}
							?>
						
						
						
							  <tr style="background-color:<?php echo $color; ?>">
								<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customer['customer_id']; ?>"><?php echo $customer['customer_id']; ?></a></td>
								<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customer['customer_id']; ?>"><?php echo $customer['company_name']; ?></a></td>
								<td><?php echo $customer['person_title']." ".$customer['contact_person']; ?></td>
								<td><?php echo $customer['email']; ?></td>
								<td><?php echo $customer['mobile']; ?></td>
								<!-- <td><?php echo $customer['phone']; ?></td> -->
								<td><?php echo $customer['country_name']; ?></td>
								<td><?php echo $outstand_balance; //$customer['outstand_balance']; ?></td>
								<!-- <td><?php echo $customer['state_name']; ?></td>
								<td><?php echo $customer['district']; ?></td>
								<td><?php echo $customer['city']; ?></td>
								<td><?php echo $customer['pin']; ?></td> -->				
								
								<td class="">
									<a class="tdBtn" target="_blank" href="<?php echo site_url('customerView'); ?>/<?php echo $customer['customer_id']; ?>"  title="View" ><i class="fas fa-eye"></i></a>
									<a class="tdBtn" target="_blank" href="<?php echo site_url('editCustomer'); ?>/<?php echo $customer['customer_id']; ?>"  title="Edit"><i class="far fa-edit"></i></a>
									<a class="tdBtn" target="_blank" href="<?php echo site_url('notes'); ?>/<?php echo $customer['customer_id']; ?>"  title="Notes"><i class="far fa-sticky-note"></i></a>
									<a class="tdBtn" target="_blank" href="<?php echo site_url('priceList'); ?>/<?php echo $customer['customer_id']; ?>"  title="Price List"><i class="fas fa-list"></i></a>
									<a class="tdBtn" target="_blank" href="<?php echo site_url('customerHistory'); ?>/<?php echo $customer['customer_id']; ?>"  title="Customer History"><i class="fas fa-history"></i></a>
									<a class="tdBtn" target="_blank" href="<?php echo site_url('customer/payment'); ?>?customer_id=<?php echo $customer['customer_id']; ?>" title="Customer Payment"><i class="fas fa-rupee-sign"></i></a>	
									<a class="tdBtn commonMailbox" href="#"  id="cid_<?php echo $customer['customer_id']; ?>" title="Email"><i class="fas fa-envelope text-danger"></i></a>
									<a style="padding-left:7px;" href="#" class="whatsAppMessageBox" id="wacus_<?php echo $customer['customer_id']; ?>" title="WhatsApp">
									<?php 
										if($customer['wa_status']=='P'){
											echo"<i class='fab fa-whatsapp-square text-warning'></i>";
										}elseif($customer['wa_status']=='I'){
											echo"<i class='fab fa-whatsapp-square text-danger'></i>";
										}elseif($customer['wa_status']=='V'){
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
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
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
							<div class="col-sm-2">File:</div>															
							<div class="col-sm-10">
								 <input type="file" name="wa_file" id="wa_file">
							</div>
						</div>	
					<div>
						<input type="hidden" name="wa_customer_id" id="wa_customer_id" >
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

<script>
    $(document).ready(function () {

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

		$(".whatsAppMessageBox").click(function(){
			var id = this.id.split("_");
			var wa_customer_id = id[1];
			$("#wa_customer_id").val(wa_customer_id);
			$('#wa_message').val('');
			$('#wa_file').val('');
			$("#myModalSendWhatsApp").modal();			
		});

		$("#whatsapp_message").click(function(){
			var data_form = $('#whatsapp_form').serialize();
			//console.log(data_form);
			var formData = new FormData($('#whatsapp_form')[0]);
			$.ajax({
				url:'<?php echo site_url('common/sendWhatsAppCustomer'); ?>',
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

		$(".commonMailbox").click(function(){
			//var id = this.id;
			var id=this.id.split("_");
			var cus_id = id[1];
			var urlAjax='<?php echo site_url('common/getEmail'); ?>';
			urlAjax = urlAjax+"/?customer_id="+cus_id;
			$.ajax({
				url:urlAjax,
				method: 'post',
				data: 'customer_id='+cus_id, 
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
					var htm = '<div class="alert alert-success" role="alert">Email sent successfully.</div>';
					$("#alert-danger-common").html(htm);
					setTimeout(function(){
						$("#myModalSendCommonMail .close").click();
						$("#alert-danger-common").html('');
					}, 3000);
				}
			});				
		});

		
		
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
								value: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				if(item['value']){
					$('#company_name').val(item['label']);				
					//$('#customer_id').val(item['value']);					
				}
			}
		}); */		
    });    
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".form-control").keypress(function(event) { 
			if (event.keyCode === 13) { 
				if(this.id!='common_email_massage' && this.id!='common_email_subject' && this.id!='common_email_cc' && this.id!='common_email_to' && this.id!='wa_message'){
					$("#button-filter").click();				
				}		
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

	$('#create_excel').click(function(){  
		var base_url = '<?php echo site_url(); ?>';
		var qry_string='<?php echo SVI_Get_Query_string(); ?>';
		var excel_data = $('#searchResponce').html();  
		var urlll = base_url +"/customer/downloadContactsExcel?"+qry_string;	
		window.location = urlll;		
	}); 
}); 
</script> 