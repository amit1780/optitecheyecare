<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> </h1> <?php echo $this->breadcrumbs->show(); ?>
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
					bank_id: "required",					
					date_of_payment: "required",					
					bank_ref_no: "required",				
					//currency_id: "required",					
					amount: "required"					
				},
				messages: {
					bank_id: "Please Select Bank",
					date_of_payment: "Please Select Date of Payment",
					bank_ref_no: "Please Enter Bank ref. no",
					//currency_id: "Please Select currency",
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
			<span>Order No: <a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $ordersInfo->order_id; ?>"><b><?php echo getOrderNo($ordersInfo->order_id); ?></b></a></span>&nbsp; | &nbsp;
			<span>Customer Name: <b><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $ordersInfo->customer_id; ?>"><?php echo $ordersInfo->customer_name; ?></a></b></span>&nbsp; | &nbsp;
			<span>Currency: <b><?php echo $ordersInfo->currency; ?></b></span>&nbsp; | &nbsp;
			<span>Order Total: <b><?php echo number_format((float)$orderTotal, 2, '.', ''); ?></b></span>
		</div>
	</div>
	<br>
	<form role="form" method="post" action="" id="paymentAdviceForm" enctype="multipart/form-data" >
		<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" id="order_id" >
		<div class="row">		
			<div class="col-sm-2">
			   <div class="form-group">
				<div class="control-label" >Bank</div> 
					<select name="bank_id" class="form-control" required>
						<option value=''>Select</option>
						<?php if(isset($banks)){ ?>
						<?php foreach($banks as $bank){ ?>							
							<option value="<?php echo $bank['id']; ?>" <?php if(isset($advicesById->bank_id) && $advicesById->bank_id == $bank['id'] ) { echo ' selected="selected"'; } ?>>
							<?php echo $bank['bank_name']." - ".$bank['account_number']; ?></option>							
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-2">
			   <div class="form-group">
				<div class="control-label" >Date Of Payment</div> 
					 <input type="text" name="date_of_payment" value="<?php if(isset($advicesById->date_of_payment)){ echo dateFormat('Y-m-d',$advicesById->date_of_payment); } ?>" id="date_of_payment" class="form-control date" autocomplete='off' required>
				</div>
			</div>
			
			<div class="col-sm-2">
			   <div class="form-group">
				<div class="control-label" >Bank Ref. No</div> 
					 <input type="text" name="bank_ref_no" value="<?php if(isset($advicesById->bank_ref_no)){ echo $advicesById->bank_ref_no; } ?>" id="bank_ref_no" class="form-control" autocomplete='off' required>
				</div>
			</div>
			
			<!-- <div class="col-sm-2">
			   <div class="form-group">
				<div class="control-label" >Currency</div> 
					<select name="currency_id" id="currency_id" class="form-control" required>
						<option value=''>Select</option>
						<?php if(isset($currencies)){ ?>
						<?php foreach($currencies as $currency){ ?>
							
							<option value="<?php echo $currency['id']; ?>" <?php if(isset($advicesById->currency_id) && $advicesById->currency_id == $currency['id'] ) { echo ' selected="selected"'; } ?>><?php echo $currency['currency']; ?></option>
							
						<?php } ?>
					<?php } ?>
					</select>	
				</div>
			</div> -->
			
			<input type="hidden" name="currency_id" value="<?php echo $ordersInfo->currency_id; ?>">
			
			<div class="col-sm-2">
			   <div class="form-group">
				<div class="control-label" >Amount</div> 
					 <input type="text" name="amount" value="<?php if(isset($advicesById->amount)){ echo $advicesById->amount; } ?>" id="amount" class="form-control" autocomplete='off' required>
					
				</div>
			</div>
			
			<div class="col-sm-2">
			   <div class="form-group">
				<div class="control-label" >File Upload </div> 
					 <input type="file" name="bank_file[]" multiple value="" <?php if($advicesById->bank_file == ''){ echo 'required';}?>>
					 
				</div>										
			</div>
			
			<div class="col-sm-6">
				<?php foreach($paymentAdviceFiles as $adviceFile){ ?>
				<p class="m-0"><a target="_blank" href="<?php echo base_url(); ?>uploads/bank/<?php echo $adviceFile['bank_file']; ?>"><?php echo $adviceFile['bank_file']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#" id="<?php echo $adviceFile['advice_file_id']; ?>" class="fileDel"><i class="fa fa-trash" style="color:red;"></i></a></p>
				
				<?php } ?>
			</div>
			
			
			<div class="col-sm-12">
				<button type="submit" id="submit" class="btn btn-primary float-right"> 
					<?php if($this->input->get('advice_id')){ ?>
						Save
					<?php } else { ?>
						Add New
					<?php } ?>
				</button>	
			</div>													
		</div>			
	</form>
	
	<div class="row" style="margin:0px;">
		<div class="col-sm-12">			
			<?php foreach($notes as $note){ ?>
				<div class="notes" style="margin-top: 20px;">
					<p style="color:gray;margin-bottom:0px;"><?php echo $note['username'];  ?> | <?php echo $note['notes_date_added']; ?></p>
					
					<p style="border:1px solid #ced4da ;padding:10px;"><?php echo $note['notes'];  ?></p>
					
				</div>
			<?php } ?>
			
		</div>	
	</div>
	<br>
	<?php if($this->input->get('advice_id') == ''){ ?>
		<div class="table-responsive">
			<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Bank Name</th>					
						<th>Bank Ref. No</th>
						<!-- <th>Currency</th> -->
						<th>Amount</th>
						<th>Bank File</th>
						<th>Date Of Payment</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($advices as $advice){ ?>
						<?php $date_added = new DateTime($advice['date_added']); ?>
						<tr>	
							<td><?php echo $advice['bank_name']; ?></td>
							<td><?php echo $advice['bank_ref_no']; ?></td>
							<!-- <td><?php //echo $advice['currency']; ?></td> -->
							<td><li class="<?php echo $advice['currency_faclass']; ?>"></li> <?php echo $advice['amount']; ?></td>
							<td>
								<!-- <a href="<?php //echo base_url().'uploads/bank/'.$advice['bank_file']; ?>" target="_blank"><?php //echo $advice['bank_file']; ?></a> -->
								<a href="#" class="viewFile" id="<?php echo $advice['payment_advice_id']; ?>">View File</a>
							</td>
							<td><?php echo dateFormat('d-m-Y', $advice['date_added']); ?></td>
							<td align="center">
							<?php if($this->session->userdata('group_type')=='SADMIN'){ ?>
								<a href="<?php echo site_url('paymentAdvice'); ?>/<?php echo $advice['order_id']; ?>?advice_id=<?php echo $advice['payment_advice_id']; ?>" class="addAdvice" id="addAdvice_<?php echo $advice_reject['payment_advice_id']; ?>" title="Add Advice"><i class="fas fa-edit"></i></a>
							<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
	
</div>

<div class="modal fade" id="myModalViewFIle" role="dialog" >
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Bank Files</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>			
			<div class="modal-body">
				<div id="bankFiles"></div>
			</div>
		</div>				  
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
		
		$(".viewFile").click(function() {
			$('#bankFiles').html("");
			var base_url = '<?php echo base_url(); ?>';
			var payment_advice_id = $(this).attr('id');
			var order_id = '<?php echo $order_id; ?>';
			$.ajax({
				url:'<?php echo site_url('order/getPaymentAdviceFile'); ?>',
				method: 'post',
				data: {payment_advice_id: payment_advice_id,order_id: order_id},
				dataType: 'json',
				success: function(response){
					var htm = "";
										
					$.each(response , function(index, val) {
						htm += "<a target='_blank' href='"+base_url+"uploads/bank/"+ val.bank_file +"'>"+ val.bank_file + "</a><br>";
					});
					
					$('#bankFiles').html(htm);
					$("#myModalViewFIle").modal();
				}
			});
		});
		
		$(".fileDel").click(function() {					
			var advice_file_id = $(this).attr('id');			
			$.confirm({
				title: 'Please Confirm!',
				content: 'Are you sure to delete ?',
				type: 'red',
				buttons: {					
					 confirm: function () {
						$("#"+advice_file_id).parent().remove();	
						$.ajax({
							url:'<?php echo site_url('order/delPaymentAdviceFile'); ?>',
							method: 'post',
							data: {advice_file_id: advice_file_id},
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