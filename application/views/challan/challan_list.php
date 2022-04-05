<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;">Challan List</h1> <?php echo $this->breadcrumbs->show(); ?>
	</div>

	 <!-- Breadcrumbs-->
	<!-- <ol class="breadcrumb">
		<li class="breadcrumb-item">
		  <a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Tables</li>
	</ol> -->
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
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
						<div class="control-label" >Challan No</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titlechallan"><?php echo "C".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
																		
									<?php echo financialList($dropdown='challandropdown',$type='C'); ?>
									
								</div>
							 </div>	
							 
							<input type="text" name="challan_id" style="width:50%;" value="<?php echo idFormat($this->input->get('challan_id')); ?>" id="challan_id" class="form-control">						
							<input type="hidden" name="fcyear" value="" id="fcyear" class="form-control">						
						</div>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<div class="control-label" >Order No</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titleorder"><?php echo "O".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
																		
									<?php echo financialList($dropdown='orderdropdown',$type='O'); ?>
									
								</div>
							 </div>	
							 
							<input type="text" name="order_id" style="width:50%;" value="<?php echo idFormat($this->input->get('order_id')); ?>" id="order_id" class="form-control">						
							<input type="hidden" name="foyear" value="" id="foyear" class="form-control">						
						</div>
					</div>
				</div>
								
				<!-- <div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Challan No</div> 
					<input type="text" name="challan_id" value="<?php if(!empty($this->input->get('challan_id'))){ echo $this->input->get('challan_id'); } ?>" id="challan_id" class="form-control" >
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without C)</span>
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Order No</div> 
					<input type="text" name="order_id" value="<?php if(!empty($this->input->get('order_id'))){ echo $this->input->get('order_id'); } ?>" id="order_id" class="form-control" >
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without O)</span>
				  </div>
				</div> -->
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Invoice No</div> 
					<input type="text" name="invoice_no" value="<?php if(!empty($this->input->get('invoice_no'))){ echo $this->input->get('invoice_no'); } ?>" id="invoice_no" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Docket No</div> 
					<input type="text" name="docket_no" value="<?php if(!empty($this->input->get('docket_no'))){ echo $this->input->get('docket_no'); } ?>" id="docket_no" class="form-control" >					
				  </div>
				</div>
				
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
					<div class="control-label">Customer Id</div> 
					<input type="text" name="customerid" value="<?php if(!empty($this->input->get('customerid'))){ echo $this->input->get(customerid); } ?>" id="customerid" class="form-control" >
					
				  </div>
				</div>	
				
				<div class="col-sm-2">
				  <div class="form-group auto">
					<div class="control-label">Customer Name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" >
					
				  </div>
				</div>

				<div class="col-sm-3">
				  <div class="form-group">
					 <div class="control-label">Product Name</div> 					
						<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" autocomplete="off" >
					</div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Model</div> 
					<!-- <input type="text" name="model" value="<?php if(!empty($this->input->get('model'))){ echo $this->input->get('model'); } ?>" id="model" class="form-control"> -->
					<select name="model" id="input-model" class="form-control"></select>
					</div>
				</div> 
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Email</div> 
					<input type="text" name="email" value="<?php if(!empty($this->input->get('email'))){ echo $this->input->get('email'); } ?>" id="email" class="form-control" >
					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Mobile</div> 
					<input type="text" name="mobile" value="<?php if(!empty($this->input->get('mobile'))){ echo $this->input->get('mobile'); } ?>" id="mobile" class="form-control" >
					
				  </div>
				</div>				
			
				<div class="col-sm-2">
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
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">State</div> 
						<select name="state_id" id="state_id" class="form-control" >
							<option value="">--Select--</option>
							<?php if($states && $this->input->get('country_id')){ ?> 
								<?php foreach($states as $state){ ?>
									<option value="<?php echo $state['state_id']; ?>" <?php if($this->input->get('state_id') == $state['state_id']) { echo ' selected="selected"'; } ?> ><?php echo $state['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>					
				  </div>
				</div>
				
				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">City</div> 
					<input type="text" name="city" value="<?php if(!empty($this->input->get('city'))){ echo $this->input->get('city'); } ?>" id="city" class="form-control" >
					
				  </div>
				</div>	

				<div class="col-sm-2">
				  <div class="form-group">
					<div class="control-label">Pin Code</div> 
					<input type="text" name="pin_code" value="<?php if(!empty($this->input->get('pin_code'))){ echo $this->input->get('pin_code'); } ?>" id="pin_code" class="form-control">
					
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
			<div class="row">	
				<div class="col-sm-12 float-right">
					<div class="form-group">
						<button type="button" id="button-filter" class="btn btn-primary float-right">Search</button>
					</div>
					<br>
				</div>			
			</div> 	
		</form>
		
		<br>
	
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
		<table class="table-sm table-bordered" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Challan&nbsp;No</th>
				  <th>Order&nbsp;No</th>
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'customer_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $customer_name_sort; ?>">Customer Name</a></th>
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'challan_type')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $challan_type_sort; ?>">Challan Type</a></th>
				  
				   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'docket_no')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $docket_no_sort; ?>">Docket No</a></th>
				  
				  <th>Invoice No</th>				  
				  <th>Contact No</th>
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'country_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $country_sort; ?>">Country</a></th>
				  
				  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'state_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $state_sort; ?>">State</a></th>
				  
				  <th width="9%">Challan Total</th>
				  <th width="8%">Challan Date</th>
				  <th style="width:12%;">Action</th>
				 </tr>
			  </thead>
		  <tbody>
			<?php if(($challanInfo)){ ?>
				<?php foreach($challanInfo as $challan){ ?>				
					<tr class="<?php if($challan['is_deleted'] == 'Y'){ echo "disabled"; } ?>">						
						<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challan['challan_id']; ?>" ><?php echo getChallanNo($challan['challan_id']); ?></a></td>						
						<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challan['order_id']; ?>" ><?php echo getOrderNo($challan['order_id']); ?></a>
						<?php
							if($challan['return_qty'] > 0){
								echo "<br><b style='color:red;'>Returned</b>";
							}
						?>						
						</td>
						<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $challan['customer_id']; ?>"><?php echo $challan['company_name']; ?></a></td>
						<td><?php echo $challan['challan_type']; ?></td>
						<td><?php echo $challan['docket_no']; ?></td>
						<td>
						<?php if($challan['challan_type'] == "Export"){ ?>
								<a  href="<?php echo site_url('challan/invoice'); ?>?challan_id=<?php echo $challan['challan_id']; ?>"  title="Invoice" ><?php echo $challan['invoice_no']; ?></a>
							<?php }else{ ?>

						<?php echo $challan['invoice_no']; } ?>
						</td>
						<td><?php echo $challan['contact_phone']; ?></td>
						<td><?php echo $challan['country_name']; ?></td>
						<td><?php echo $challan['state_name']; ?></td>
						<td><i class="<?php echo $challan['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo number_format((float)($challan['net_total']), 2, '.', ''); ?></td>
						<td><?php echo dateFormat('d-m-Y',$challan['challan_date']); ?></td>						
						<td class="">
							<?php if($challan['is_deleted'] == 'N'){ ?>
								<?php if($this->session->userdata('group_id')=='1'){ ?>
									<a style="padding-left:5px;" href="<?php echo site_url('challan/edit'); ?>/<?php echo $challan['challan_id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
								<?php	} ?>
								
								<a style="padding-left:7px;" href="<?php echo site_url('challanView'); ?>/<?php echo $challan['challan_id']; ?>" title="Challan View" ><i class="fas fa-eye"></i></a> 
								<a style="padding-left:7px;" href="<?php echo site_url('dispatchNote'); ?>/<?php echo $challan['challan_id']; ?>" title="Dispatch Note"> <i class="far fa-sticky-note"></i></a>
								
								<!-- <a style="padding-left:7px;" href="<?php echo site_url('createSli'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Create SLI"> <i class="fas fa-plus"></i></a> -->
								
								<?php if($challan['challan_type'] == "Export"){ ?>
								<a style="padding-left:7px;" href="<?php echo site_url('sli/createSli'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Create SLI"> <i class="fas fa-plus"></i></a>
								<?php } ?>
								
								<a style="padding-left:7px;" href="<?php echo site_url('challanPrint'); ?>/<?php echo $challan['challan_id']; ?>" title="Challan Print" target="_blank"> <i class="fas fa-print"></i></a>					
								<a style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $challan['challan_id']; ?>" title="Email"><i class="fas fa-envelope"></i></a>
								<a style="padding-left:7px;" href="<?php echo site_url('challan/downloadPdf'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Download"><i class="fas fa-download"></i></a>
								<a style="padding-left:7px;" href="<?php echo site_url('addressslip'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Address Slip"><i class="fa fa-truck" aria-hidden="true"></i></a>
								<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){  ?>
									<?php //if(($challan['return_qty'] == 0) && ($challan['invoice_no'] == '') && ($challan['invoice_date'] == '0000-00-00 00:00:00')){ ?>
									<?php if(($challan['return_qty'] == 0) && ($challan['invoice_no'] == '')){ ?>
										<a style="padding-left:7px;" href="#" onClick="deleteChallan(<?php echo $challan['challan_id']; ?>,<?php echo $challan['order_id']; ?>);" title="Delete Challan"><i class="fa fa-trash" aria-hidden="true"></i></a>
									<?php } ?>
								<?php } ?>
								
							<?php } else { ?>
								<a style="padding-left:7px;" href="#" onClick="viewDeleteReason(<?php echo $challan['challan_id']; ?>,<?php echo $challan['order_id']; ?>);" title="View Deleted Reason" ><i class="fas fa-eye"></i></a> 
							<?php } ?>
							<?php if($challan['challan_type'] == "Export"){ ?>
								<a style="padding-left:7px;" href="<?php echo site_url('challan/invoice'); ?>?challan_id=<?php echo $challan['challan_id']; ?>"  title="Invoice" ><i class="fas fa-file-invoice"></i></a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>  
			<?php } else { ?>
				<tr>
					<td class="text-center" colspan="13">No results!</td>
				</tr>
			<?php } ?>    
		  </tbody>
		</table>
	  </div>
	</div>
	<?php echo $pagination; ?>
  </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Mail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" id="challanMailForm" enctype="multipart/form-data" >					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="email_to" value="" autocomplete='off'  id="email_to" class="form-control" required></div>
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
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Challan / Performa Invoice - "  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Massage:</div>															
							<div class="col-sm-10">
							<textarea class="form-control" style="height:180px !important;" rows="7" name="email_massage" id="email_massage"></textarea>
							</div>
						</div>						
					</div>
					
					<div id="challanfiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">File:</div>															
							<div class="col-sm-10">
								<div id="challanfile"></div>
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
				<form method="post" action="" id="challanDeleteForm" enctype="multipart/form-data" >										
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Reason:</div>															
							<div class="col-sm-10">
							<input type="hidden" name="delchallan_id" id="delchallan_id" value="">
							<input type="hidden" name="delorder_id" id="delorder_id" value="">
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


<script>
	$(document).ready(function(){		
		//$(".disabled").css("pointer-events", "none");
		//$(".disabled").css("cursor", "default");
		
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
	
		$(".mailbox").click(function(){
			var challan_id = this.id;
			$.ajax({
				url:'<?php echo site_url('challan/challanSavePdf'); ?>',
				method: 'post',
				data: 'challan_id='+challan_id, 
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
							
							htm += '<a href="<?php echo base_url(); ?>'+ res.challan_file +'" target="_blank" > '+ res.challan_file_name +' </a> &nbsp;';
							
							hiddentext += '<input type="hidden" name="challan_file" value="'+res.challan_file+'">';
							email = res.email_to;
							subject = res.challan_file_name;
							massage = 'Dear '+res.person+'\n\n';
							massage += 'Please find the Order as attached in email bellow.'+'\n\n';
							massage += 'Thank you,'+'\n';
							massage += 'Optitech Eye Care';
						});						
						$("#challanfile").html(htm);						
						$("#challanfiletextbox").html(hiddentext); 
						$("#email_to").val(email); 
						$("#email_subject").val('Challan / Performa Invoice - '+subject); 
						$("#email_massage").val(massage); 
					}
					
					$("#myModal").modal();		
				}
			});				
		});
		
		$("#sendMail").click(function(){		
			var data_form = $('#challanMailForm').serialize();
			$.ajax({
				url:'<?php echo site_url('challanSendMail'); ?>',
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
			if(this.id!='email_massage' && this.id!='email_subject' && this.id!='email_cc' && this.id!='email_to'){
				$("#button-filter").click();				
			}
			//$("#button-filter").click();
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

function deleteChallan(challan_id,order_id){
	var checkstr =  confirm('Are you sure you want to delete this Challan?');
	if(checkstr == true){
		$("#delchallan_id").val(challan_id);
		$("#delorder_id").val(order_id);
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

function viewDeleteReason(challan_id,order_id){
	$.ajax({
		url:'<?php echo site_url('challan');?>'+'/viewDeleteReason',
		method: 'post',
		data: 'challan_id=' + challan_id + '&order_id=' + order_id,
		dataType: 'json',
		success: function(response){
			var userdetails = '<span style="font-size:16px;"><b>Deleted By</b> - ' + response.username + ' <b>| Deleted On</b> - ' + response.deleted_date +'</span>';
			$('#deleted_reason').prop('disabled', true);
			$("#deletedUser").html(userdetails);
			$("#deleted_reason").val(response.deleted_reason);			
			$("#deleteButton").hide();			
			$("#myModaldel").modal();
				
		}
	});		
}

$(document).ready(function(){
	$("#deleteButton").click(function(){		
		//$("#addbatchform").valid();
		if(! $("#challanDeleteForm").valid()) return false;	
		var data_form = $('#challanDeleteForm').serialize();			
		$.ajax({
			url:'<?php echo site_url('deleteChallan');?>',
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
					window.location.href='<?php echo site_url('challanList');?>';
				}
			}
		});				
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