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
					&nbsp;				
				</div>
			</div> 	
		</div>
	</div>
	
	<?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	
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

	<script>
		$(document).ready(function() {						
			$("#paymentAdviceForm").validate({
				rules: {
										
					date_of_payment: "required",										
					amount: "required"	
				},
				messages: {					
					date_of_payment: "Please Select Date of Payment",					
					amount: "Please Enter Amount"			
				}
			})

			$('#submit').click(function() {
				$("#paymentAdviceForm").valid();
			});
		});
	</script>
<div class="row">		
	<div class="col-sm-12">
		
		<span>Customer Name: <b><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customerInfo->customer_id; ?>"><?php echo $customerInfo->company_name; ?></a></b></span>&nbsp; | &nbsp;
		
		<span>Total Bills: <b><?php if($ChallanTotal['currency_id'] == 1){ echo '<l class="fas fa-rupee-sign"></i>'; } else { echo $ChallanTotal['currency_html']; } ?> <?php echo number_format((float)($ChallanTotal['net_total']), 2, '.', '') ; ?></b></span>&nbsp;  &nbsp;
		
		<span>Outstanding Balance: <b><?php echo $outstand_balance; ?></b></span>&nbsp;  &nbsp;
		
	</div>
</div>
<br>

<form role="form" method="post" id="paymentAdviceForm" enctype="multipart/form-data" style="border: 1px solid #ced4da;padding: 13px;">		
	<div class="row">			
		<div class="col-sm-3">
		   <div class="form-group">
			<div class="control-label" >Amount</div> 
				 
				 <div class="input-group">
						<div class="input-group-prepend dropdown">
							<button class="btn btn-outline-secondary dropdown-toggle title-text " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>/assets/img/rupee.png" style="width:8px;"></button>
							<div class="dropdown-menu">
							<?php foreach($currencies as $currency) { ?>
								<?php
									if(empty($currency['currency_html'])){
										$currency['currency_html']='<img src="'.base_url().'/assets/img/rupee.png" style="width:8px;">';
									}
								?>
							  <a class="dropdown-item" id="<?php echo $currency['id']; ?>" href="#"><?php echo $currency['currency_html']; ?></a>
							<?php } ?>								  									 
							</div>
						 </div>
					
						<input type="text" name="amount" style="width:75%;" value="<?php if($customerPayments->amount){ echo $customerPayments->amount; } ?>" id="amount" class="form-control text-capitalize" required>
						
				</div>						
				<input type="hidden" name="currency_id" value="<?php echo set_value('currency_id'); ?>" id="currency_id">					 
			</div>
		</div>
		
		<div class="col-sm-3">
		   <div class="form-group">
			<div class="control-label" >Mode of payment</div> 
				<select name="mode_of_payment" id="mode_of_payment" class="form-control" required>
					<option value="">- Select Option -</option>
					<?php foreach($modeOfPaymentInfo as $modeOfPayment){ ?>
						<option value="<?php echo $modeOfPayment['mode_payment_id']; ?>" <?php if($customerPayments->mode_of_payment == $modeOfPayment['mode_payment_id']) { echo ' selected="selected"'; } ?>>
							<?php echo $modeOfPayment['mode_name']; ?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="col-sm-3 otherFeildsBank">						  
		  <div class="form-group">
			 <div class="control-label" >Bank</div> 
			 <select name="bank_id" class="form-control" required>
				<option value=''>- Select -</option>
				<?php if(isset($banks)){ ?>
					<?php foreach($banks as $bank){ ?>						
						<option value="<?php echo $bank['id']; ?>" <?php if($customerPayments->bank_id == $bank['id']) { echo ' selected="selected"'; } ?> >
							<?php echo $bank['bank_name']." - ".$bank['account_number']; ?>
						</option>						
					<?php } ?>
				<?php } ?>
			</select>								
		  </div>
		</div>
		
		<div class="col-sm-3 otherFeilds">
		   <div class="form-group">
			<div class="control-label" >Reference Number</div> 
				 <input type="text" name="reference_number" value="<?php if(isset($customerPayments->reference_number)){ echo $customerPayments->reference_number; } ?>" id="reference_number" class="form-control" autocomplete='off'>
			</div>
		</div>
		
		<div class="col-sm-3 otherFeilds">
		   <div class="form-group">
			<div class="control-label" >Reference Document</div> 
				 <input type="file" name="bank_file[]" id="bank_file" multiple>
			</div>
		</div>
		
		<div class="col-sm-3">
		   <div class="form-group">
			<div class="control-label" >Date Of Payment</div> 
				 <input type="text" name="date_of_payment" value="<?php if(isset($customerPayments->date_of_payment)){ echo dateFormat('Y-m-d',$customerPayments->date_of_payment); } ?>" id="date_of_payment" class="form-control date" autocomplete='off' required>
			</div>
		</div>
		
		<div class="col-sm-3">
		   <div class="form-group">
			<div class="control-label" >Note</div>					 
				 <textarea name="note" id="note" class="form-control" ><?php if(isset($customerPayments->note)){ echo $customerPayments->note; } ?></textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<?php foreach($customerPaymentFile as $File){ ?>
					<p class="m-0">
						<a target="_blank" href="<?php echo base_url(); ?>uploads/bank/<?php echo $File['bank_file']; ?>"><?php echo $File['bank_file']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#" id="<?php echo $File['file_id']; ?>" class="fileDel"><i class="fa fa-trash" style="color:red;"></i></a>
					</p>			
				<?php } ?>
			</div>
		</div>
		
		<div class="col-sm-6" id="subBtn">
		
			<button type="submit" id="submit" class="btn btn-primary float-right"> 
				Save
			</button>	
		</div>													
	</div>			
</form>
<br>
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
			changeMonth: true,
			changeYear: true
		});	
		var base_url = '<?php echo base_url(); ?>';
		
		var currency_id = '<?php echo $customerPayments->currency_id; ?>';
		
		if(currency_id){
			$("#currency_id").val(currency_id);
		}else{
			$("#currency_id").val(1);
		}
			
		$(".dropdown-item").click(function(){
			var title = $(this).text();
			var id = $(this).attr("id");
			if($(this).attr("id") == 1){
				title = '<img src="'+base_url+'/assets/img/rupee.png" style="width:6px;">';
			}			
			$(".title-text").html(title);
			$("#currency_id").val(id);
		});

				
		$('#amount').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
		var mode_of_payment = '<?php echo $customerPayments->mode_of_payment; ?>';
		if(mode_of_payment == 2){
			$(".otherFeildsBank").show();
			//$("#subBtn").attr('class', 'col-sm-3');
		}else{
			$(".otherFeildsBank").hide();
			//$("#subBtn").attr('class', 'col-sm-6');
		}
		
		
		$('#mode_of_payment').change(function() {			
			var selectedText = $(this).val();			
			if(selectedText == 2){
				$(".otherFeildsBank").show();
				//$("#subBtn").attr('class', 'col-sm-3');
			}else{
				$(".otherFeildsBank").hide();
			//	$("#subBtn").attr('class', 'col-sm-6');
			}				
		});
		
		$(".fileDel").click(function() {					
			var file_id = $(this).attr('id');			
			$.confirm({
				title: 'Please Confirm!',
				content: 'Are you sure to delete ?',
				type: 'red',
				buttons: {					
					 confirm: function () {
						$("#"+file_id).parent().remove();	
						$.ajax({
							url:'<?php echo site_url('customer/delPaymentFile'); ?>',
							method: 'post',
							data: {file_id: file_id},
							dataType: 'json',
							success: function(response){
								
							}
						});
					},
					cancel: function () {
													
					}					
				}
			});
		});	
		
	}); 
</script>