<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	
	<div class="page_heading">
		<h1 style="float: left;">Quotation List (Pending for order)</h1> <?php echo $this->breadcrumbs->show(); ?>			
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	<?php if(isset($error)){ ?>
    <div class="alert alert-danger">
      <?php echo $error; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example --> 
	
  <div class="card mb-3">	
	<div class="card-body">
	<style>
		.form-group ul{width:100%;padding-left:6px;}
		.form-group ul{max-height: 200px;overflow-y: scroll;}
		.form-group{margin-bottom: 0.5rem !important;}
		.form-control{height:36px !important; padding-left:5px !important;}
	</style>
	
	<form role="form" class="needs-validation" id="filterForm" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			 <div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<div class="control-label" >Quotation No</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titlequote"><?php echo "Q".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
																	
									<?php echo financialList($dropdown='quotedropdown',$type='Q'); ?>
									
								</div>
							 </div>							 
							<input type="text" name="quote_id" style="width:50%;" value="<?php echo idFormat($this->input->get('quote_id')); ?>" id="quote_id" class="form-control">				
							<input type="hidden" name="fqyear" value="" id="fqyear" class="form-control">						
						</div>
					</div>
				</div>
			 
				
				<!-- <div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Quotation No</div> 
					<input type="text" name="quote_id" value="<?php if(!empty($this->input->get('quote_id'))){ echo $this->input->get('quote_id'); } ?>" id="quote_id" class="form-control" >
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without Q)</span>					
				  </div>
				</div> -->				
				
				<div class="col-sm-2">
				  <div class="form-group">
					 <div class="control-label" >Currency</div> 
						<select name="currency_id" id="currency_id" class="form-control" >
							<option value=''>--Select--</option>
							<?php if(isset($currencies)){ ?>
							<?php foreach($currencies as $currency){ ?>								
								<option value="<?php echo $currency['id']; ?>" <?php if($this->input->get('currency_id') == $currency['id']) { echo ' selected="selected"'; } ?> ><?php echo $currency['currency']; ?></option>								
							<?php } ?>
						<?php } ?>
						</select>								
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
						 <div class="control-label" >Created By</div> 
							<select name="user_id" class="form-control" >
								<option value=''>--Select--</option>
								<?php if(isset($users)){ ?>
								<?php foreach($users as $user){ ?>
									
									<option value="<?php echo $user['user_id']; ?>" <?php if($this->input->get('user_id') == $user['user_id']) { echo ' selected="selected"'; } ?> ><?php echo $user['firstname']." ".$user['lastname']; ?></option>
									
								<?php } ?>
							<?php } ?>
							</select>								
					  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
						 <div class="control-label" >Store</div> 
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
				  <div class="form-group">
					<div class="control-label">Customer ID</div> 
					<input type="text" name="customerid" value="<?php if(!empty($this->input->get('customer_id'))){ echo $this->input->get('customer_id'); } ?>" id="customerid" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Customer name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" autocomplete="off">
					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Customer Email</div> 
					<input type="text" name="contact_email" value="<?php if(!empty($this->input->get('contact_email'))){ echo $this->input->get('contact_email'); } ?>" id="contact_email" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Contact No</div> 
					<input type="text" name="contact_phone" value="<?php if(!empty($this->input->get('contact_phone'))){ echo $this->input->get('contact_phone'); } ?>" id="contact_phone" class="form-control" >					
				  </div>
				</div>
				
				
				<div class="col-sm-2 ">
				  <div class="form-group">
					<div class="control-label" >Country</div> 
					<?php $country_id = $this->input->get('country_id'); ?>
					<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" >
						<option value="">--Seclect--</option>
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
							<option value="">--Seclect--</option>
							<?php if($states && $this->input->get('country_id')){ ?> 
								<?php foreach($states as $state){ ?>
									<option value="<?php echo $state['state_id']; ?>" <?php if($this->input->get('state_id') == $state['state_id']) { echo ' selected="selected"'; } ?> ><?php echo $state['name']; ?></option>
								<?php } ?>
							<?php } ?>
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
				
				<div class="col-sm-2">
				  <div class="form-group">
					 <div class="control-label">Product Name / Description</div>					
					<!-- <div class="control-label">Product / Category Name</div> -->
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" autocomplete="off" >

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
					<div class="control-label">Is Deleted</div> 
						<select name="is_deleted" id="is_deleted" class="form-control" >
							<option value="">--Select--</option>							
							<option value="Y" <?php if($this->input->get('is_deleted') == 'Y') { echo ' selected="selected"'; } ?> >Yes</option>
							<option value="N" <?php if($this->input->get('is_deleted') == 'N') { echo ' selected="selected"'; } ?> >No</option>
						</select>					
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
	<br>
		
	 <!-- <div class="table-responsive text-nowrap"> -->
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
			
			.disabled {			  
			  opacity: 0.55;
			}
			
		</style>
		<table class="table table-sm table-bordered" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <!-- <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'store_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $store_sort; ?>" >Store</a></th> -->
				  
				  <th style="width:9%;">Quotation No</th>
				 <th style="width:9%;">Quotation Date</th>
				
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'customer_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $customer_name_sort; ?>">Customer Name</a></th>
				  
				  <th style="width:7%;">Customer Id</th>
				 <!--  <th>Contact No</th> -->
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'country_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $country_sort; ?>">Country</a></th>
				  
				  <!-- <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'state_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $state_sort; ?>">State</a></th> --> 
				  
				  <th>Total Amount</th>
				   
				  <th width="13%">Action</th>
				 </tr>
			  </thead>
		  <tbody>
			<?php if(($quotations)){ ?>
				<?php foreach($quotations as $quotation){ ?>				
					<tr class="<?php if($quotation['is_deleted'] == 'Y'){ echo "disabled"; } ?>">
						<!-- <td><?php echo $quotation['store_name']; ?></td> -->
						<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['id']; ?>"><?php echo getQuotationNo($quotation['id']); ?></a></td>
						
						<td> <?php echo dateFormat('d-m-Y',$quotation['quotation_date']); ?> </td>						
						<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $quotation['customer_id']; ?>"><?php echo $quotation['customer_name']; ?></a></td>
						<td><?php echo $quotation['customer_id']; ?></td>
						<!-- <td><?php echo $quotation['contact_phone']; ?></td> -->
						<td><?php echo $quotation['country_name']; ?></td>
						<!-- <td><?php echo $quotation['state_name']; ?></td> -->
						<td><i class="<?php echo $quotation['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo number_format((float)$quotation['net_amount'], 2, '.', ''); ?> </td>
						
						<td class="">
							<?php if($quotation['is_deleted'] == 'N'){ ?>
								<a style="padding-left:7px;" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['id']; ?>" title="View" ><i class="fas fa-eye"></i></a>
								<?php if(empty($quotation['order_id'])) { ?>
								<a style="padding-left:7px;" href="<?php echo site_url('editQuotation'); ?>/<?php echo $quotation['id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
								<a style="padding-left:7px;" href="<?php echo site_url('order'); ?>?quotation_id=<?php echo $quotation['id']; ?>"  title="Generate Order"> <i class="fas fa-plus"></i></a>
								<?php } ?>
								<a style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $quotation['id']; ?>" title="Email"><i class="fas fa-envelope"></i></a>
								<a style="padding-left:7px;" href="<?php echo site_url('quotation/downloadPdf'); ?>?quotation_id=<?php echo $quotation['id']; ?>" title="Download"> <i class="fas fa-download"></i></a>
								<a style="padding-left:7px;" target="_blank" href="<?php echo site_url('quotation/quotePrint'); ?>?quotation_id=<?php echo $quotation['id']; ?>" title="Print"> <i class="fas fa-print"></i></a>
								<a style="padding-left:7px;" href="#" class="commonMailbox" id="qid_<?php echo $quotation['id']; ?>" title="Email"><i class="fas fa-envelope text-danger"></i></a>
								
								<!-- <a style="padding-left:7px;" href="#" onClick="deleteQuotation(<?php echo $quotation['id']; ?>);" title="Delete Quotation"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
							<?php } else { ?>
								<!-- <a style="padding-left:7px;" href="#" onClick="viewDeleteReason(<?php echo $quotation['id']; ?>);" title="View Deleted Reason" ><i class="fas fa-eye"></i></a> -->
							<?php } ?>
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

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" style="max-width: 600px;">				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Mail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" id="quotationmailform" enctype="multipart/form-data" >					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="email_to" value="<?php echo $quotationInfo->contact_email; ?>" autocomplete='off'  id="email_to" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">CC :</div>															
							<div class="col-sm-10"> <input type="text" name="email_cc" value=""  id="email_cc" autocomplete='off' class="form-control"></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Subject:</div>															
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Quotation / Performa Invoice - <?php echo getQuotationNo($quotationInfo->quote_id); ?>"  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Message:</div>															
							<div class="col-sm-10">
							<textarea style="height:197px !important;" class="form-control" rows="7" name="email_massage" id="email_massage">Dear <?php echo $customerInfo->person_title; ?> <?php echo $quotationInfo->contact_person; ?>,

Please find the Quotation as attached in email bellow.

Thank you,
Optitech Eye Care</textarea>
							</div>
						</div>						
					</div>
					
					<div id="quotefiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Attachments:</div>															
							<div class="col-sm-10">
								<div id="quotefile"></div>
								<div id="product_file"></div>
								<div id="certificate_file"></div>
								<input type="hidden" name="sendMailFormQuotationId" id="sendMailFormQuotationId" value="">
							</div>
						</div>						
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="sendMail" class="btn btn-primary float-right"> Send Mail</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
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


<div class="modal fade" id="myModaldel" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="deletedUser">Deleted Reason</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess"></div>
			<div class="modal-body">
				<form method="post" action="" id="quotationDeleteForm" enctype="multipart/form-data" >										
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Reason:</div>															
							<div class="col-sm-10">
							<input type="hidden" name="delquotation_id" id="delquotation_id" value="">
							<textarea class="form-control" style="height:180px !important;" rows="5" name="deleted_reason" id="deleted_reason"></textarea>
							</div>
						</div>						
					</div>										
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="deleteButton" class="btn btn-primary float-right">Delete</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
	</div>
</div>

<div class="modal fade" id="myModalProCertificate" role="dialog">
	<div class="modal-dialog" style="max-width: 600px;">				
	  <!-- Modal content-->
		<div class="modal-content" style="height:550px;">
			<div class="modal-header">
				<h4 class="modal-title" id="file_heading">Product File</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess"></div>
			<div class="modal-body">
				<div class="list">
					
				</div>
			</div>
		</div>				  
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

		$(".commonMailbox").click(function(){
			//var id = this.id;
			var id=this.id.split("_");
			var quotation_id = id[1];
			var urlAjax='<?php echo site_url('common/getEmail'); ?>';
			urlAjax = urlAjax+"/?quotation_id="+quotation_id;
			$.ajax({
				url:urlAjax,
				method: 'post',
				data: 'quotation_id='+quotation_id, 
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
					var htm = '<div class="alert alert-success" role="alert">Successfully Mail Send.</div>';
					$("#alert-danger-common").html(htm);
					setTimeout(function(){
						$("#myModalSendCommonMail .close").click();
						$("#alert-danger-common").html('');
					}, 3000);
				}
			});				
		});
	
		$(".mailbox").click(function(){
			$("#product_file").html('');
			$("#certificate_file").html('');
			var quotation_id = this.id;
			$.ajax({
				url:'<?php echo site_url('quotation/savePdf'); ?>',
				method: 'post',
				data: 'quotation_id='+quotation_id, 
				dataType: 'json',
				beforeSend: function(){
					   $('.loader').show();
				   },
				complete: function(){
					   $('.loader').hide();
				},
				success: function(response){
				    if(response){						
						var htm = '';
						var hiddentext = '';
						var email = '';						
						var subject = '';						
						var massage = '';
						
						$.each(response, function(i,res) {
							if(i == 0){
								htm += '<a href="<?php echo base_url(); ?>'+ res.quote_file +'" target="_blank" > '+ res.quote_file_name +' </a>';
							}
							
							hiddentext += '<input type="hidden" name="quote_file[]" value="'+res.quote_file+'">';
						//alert(res.email_to);
							
							if(i == 0){
							    email = res.email_to;
								subject = res.quote_file_name;
								massage = 'Dear '+res.person+'\n\n';
								massage += 'Please find the Quotation as attached in email bellow.'+'\n\n';
								massage += 'Thank you,'+'\n';
								massage += 'Optitech Eye Care';
							}														
						});
						
						$("#quotefile").html(htm);						
						$("#quotefiletextbox").html(hiddentext);
						$("#email_to").val(email); 
						$("#email_subject").val('Quotation / Performa Invoice - '+subject); 
						$("#email_massage").val(massage);
						
						$("#sendMailFormQuotationId").val(quotation_id); 
						
						var product_count = '';
						if(response.product_count>0){
							product_count = '<a href="javascript:void(0);">Product Files ('+response.product_count+' Numbers)</a>';							
							$("#product_file").html(product_count);
							
						}
						
						
						var certificate_count = '';
						if(response.certificate_count>0){
							certificate_count = '<a href="javascript:void(0);">Certificates ('+response.certificate_count+' Numbers)</a>';
							$("#certificate_file").html(certificate_count); 
						}
						
					}
					$("#myModal").modal();		
				}
			});				
		});
		
		$("#product_file").click(function(){
			var quotation_id = $("#sendMailFormQuotationId").val();			
			$("#file_heading").html("Product File");
			$.ajax({
				url:'<?php echo site_url('quotation/quotationProductFile'); ?>',
				method: 'post',
				data: 'quotation_id='+quotation_id, 
				dataType: 'json',
				success: function(response){
					var htm = '';						
					$.each(response, function(i,res) {						
						htm += '<a href="<?php echo base_url(); ?>'+ res.file_url +'" target="_blank" > '+ res.file_name +' </a> <br>';												
					});	
					$(".list").html(htm);					
				}
			});
			
			$("#myModalProCertificate").modal();	
		});
		
		$("#certificate_file").click(function(){
			var quotation_id = $("#sendMailFormQuotationId").val();	
			$("#file_heading").html("Certificate File");
			$.ajax({
				url:'<?php echo site_url('quotation/quotationCertificateFile'); ?>',
				method: 'post',
				data: 'quotation_id='+quotation_id, 
				dataType: 'json',
				success: function(response){
					var htm = '';						
					$.each(response, function(i,res) {						
						htm += '<a href="<?php echo base_url(); ?>'+ res.file_url +'" target="_blank" > '+ res.file_name +' </a> <br>';												
					});	
					$(".list").html(htm);					
				}
			});
			
			$("#myModalProCertificate").modal();	
		});
		
		$("#sendMail").click(function(){
		
			 var data_form = $('#quotationmailform').serialize();
			$.ajax({
				url:'<?php echo site_url('sendMail'); ?>',
				method: 'post',
				data: data_form,
				dataType: 'json',
				success: function(response){
					$("#alert-danger").html('');
					var htm = '<div class="alert alert-success" role="alert">Successfully Mail Send.</div>';
					$("#alert-danger").html(htm);
					setTimeout(function(){
						$("#myModal .close").click();
						$("#alert-danger").html('');
						$("#product_file").html('');
						$("#certificate_file").html('');
					}, 3000);
				}
			});
			
				
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
			},
			minLength : 3
		});
		
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".form-control").keypress(function(event) { 
		if (event.keyCode === 13) { 
			if(this.id!='email_massage' && this.id!='email_subject' && this.id!='email_cc' && this.id!='email_to' && this.id!='common_email_massage' && this.id!='common_email_subject' && this.id!='common_email_cc' && this.id!='common_email_to'){
				$("#button-filter").click();				
			}		
		} 
	});
	
	$("#button-filter").click(function(){
		var url = '<?php echo site_url('quotation'); ?>';		
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
	});
	*/
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
	
	$("#deleteButton").click(function(){		
		//$("#addbatchform").valid();
		if(! $("#quotationDeleteForm").valid()) return false;	
		var data_form = $('#quotationDeleteForm').serialize();			
		$.ajax({
			url:'<?php echo site_url('quotation');?>'+ '/deleteQuotation',
			method: 'post',
			data: data_form,
			dataType: 'json',
			success: function(response){				
				if(response.error){
					var htm = '<div class="alert alert-danger" role="alert">'+response.error+'</div>';
					$("#mess").html(htm);
					setTimeout(function(){
						$("#mess").html('');
					}, 2000);
				} else {					
					var htm = '<div class="alert alert-success" role="alert">'+response.success+'</div>';
					$("#mess").html(htm);
					setTimeout(function(){
						$("#myModaldel .close").click();
						$("#mess").html('');
					}, 2000);
					window.location.href='<?php echo site_url('quotation');?>';
				}
			}
		});				
	});
	
	
});

function deleteQuotation(quotation_id){
	var checkstr =  confirm('Are you sure you want to delete this Challan?');
	if(checkstr == true){
		$("#delquotation_id").val(quotation_id);
		var userdetails = 'Deleted Reason';
		$("#deletedUser").html(userdetails);
		$("#deleted_reason").val('');
		$('#deleted_reason').prop('disabled', false);
		$("#deleteButton").show();
		$("#myModaldel").modal();
	} else {
		return false;
	}
}

function viewDeleteReason(quotation_id){
	$.ajax({
		url:'<?php echo site_url('quotation');?>'+'/viewDeleteReason',
		method: 'post',
		data: 'id=' + quotation_id,
		dataType: 'json',
		success: function(response){
			var userdetails = '<span style="font-size:16px;"><b>Deleted User</b> - ' + response.username + ' <b>| Deleted Date</b> - ' + response.deleted_date +'</span>';
			$('#deleted_reason').prop('disabled', true);
			$("#deletedUser").html(userdetails);
			$("#deleted_reason").val(response.deleted_reason);			
			$("#deleteButton").hide();			
			$("#myModaldel").modal();
				
		}
	});		
}
</script> 