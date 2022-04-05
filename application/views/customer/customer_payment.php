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
					<a href="<?php echo site_url('customer/paymentPrint'); ?>?customer_id=<?php echo $this->input->get('customer_id'); ?>&year=<?php echo $this->input->get('year'); ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="top" title="Payment Print"> <i class="fas fa-print"></i></a>					
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
	<style>
		.btn-danger{background-color: #ff4e4e !important;}
		.btn-success{background-color: #00ff00 !important;}
	</style>
	<div class="row">		
		<div class="col-sm-12">
			
			<span>Customer Name: <b><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customerInfo->customer_id; ?>"><?php echo $customerInfo->company_name; ?></a></b></span>&nbsp; | &nbsp;
			
			<span>Total Bills: <b><?php if($ChallanTotal['currency_id'] == 1){ echo '<l class="fas fa-rupee-sign"></i>'; } else { echo $ChallanTotal['currency_html']; } ?> <?php echo number_format((float)($ChallanTotal['net_total']), 2, '.', '') ; ?></b></span>&nbsp;  &nbsp;
			
			<span>Outstanding Balance: <b><?php if($ChallanTotal['currency_id'] == 1){ echo '<l class="fas fa-rupee-sign"></i>'; } else { echo $ChallanTotal['currency_html']; } ?> <?php echo number_format((float)($ChallanTotal['net_total'] - $total_amount), 2, '.', '') ; ?></b></span>&nbsp;  &nbsp;
			
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
					
						<input type="text" name="amount" style="width:75%;" value="" id="amount" class="form-control text-capitalize" required>
						
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
						<option value="<?php echo $modeOfPayment['mode_payment_id']; ?>"><?php echo $modeOfPayment['mode_name']; ?></option>
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
						<option value="<?php echo $bank['id']; ?>">
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
				 <input type="text" name="reference_number" value="<?php if(isset($advicesById->reference_number)){ echo $advicesById->reference_number; } ?>" id="reference_number" class="form-control" autocomplete='off'>
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
				 <input type="text" name="date_of_payment" value="<?php if(isset($advicesById->date_of_payment)){ echo dateFormat('Y-m-d',$advicesById->date_of_payment); } ?>" id="date_of_payment" class="form-control date" autocomplete='off' required>
			</div>
		</div>
		
		<div class="col-sm-3">
		   <div class="form-group">
			<div class="control-label" >Note</div>					 
				 <textarea name="note" id="note" class="form-control" ></textarea>
			</div>
		</div>
		
		<div class="col-sm-6" id="subBtn">
			<br>
			<button type="submit" id="submit" class="btn btn-primary float-right"> 
				Save
			</button>	
		</div>													
	</div>			
</form>
<br>
	
	<br>
	<div class="row">		
		<div class="col-sm-12">
			<h4>Show All Payment</h4>
			<form>
				<div class="row">
					<div class="col-sm-4">
						<label class="radio-inline">
						  <input type="radio" name="show_payment" id="all_payments"> All Payments
						</label>
						<label class="radio-inline">
						  <input type="radio" name="show_payment" id="all_bills"> All Bills
						</label>
						<label class="radio-inline">
						  <input type="radio" name="show_payment" id="both" checked> Both
						</label>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<div class="control-label" >Financial Year</div> 
							<select name="years" id="years" class="form-control">
							<option value=''>All</option>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php $CI =& get_instance(); ?>
	<div id="allPayment">
		<div class="table-responsive">
			<style>
				.quote_view p{margin-bottom:0px;}		
				.borderbox{border:2px solid gray;}
				.quote_view .border_left{border-left:2px solid gray;}
				.quote_view .border_right{border-right:2px solid gray;}
				.quote_view .border_bottom{border-bottom:2px solid gray;}
				.quote_view .border_top{border-top:2px solid gray;}		
				table {
					table-layout:fixed;
				}		
				.table-bordered td{
					border: 0px solid gray;			
				}		
				.space_bottom{margin-bottom:15px;}
				.card{border:0px solid rgba(0,0,0,.125) !important;}
			</style>
			<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0" style="font-size:13px;">
			  <thead>
				<tr>
				  <th style="width:20%;">Date</th>
				  <th style="text-align:center;width:20%;">Reference Number</th>
				  <th style="text-align:center;width:20%;">Out</th>
				  <th style="text-align:center;width:20%;">In </th>
				  <th style="text-align:right;width:20%;">Balance</th>
				  <!-- <th style="text-align:right;width:20%;">&nbsp;</th> --> 
				</tr>
			  </thead>		 
			  <tbody>
				<?php
					$in = 0;
					$out = 0;
					$avil = 0;
					
				?>
				<?php foreach($all_paymentIn as $payment){  ?>
				<?php
					if($payment['in']){
						$in = $in + $payment['in'];
					}									
					if($payment['out']){
						$out = $out + $payment['out'];						
					}
					$avil = $in - $out;
				?>
					<tr>
						<td><?php echo dateFormat('d-m-Y',$payment['date_time']); ?></td>
						<td style="text-align:center;"><?php echo $payment['challan_id']; ?></td>						
						<td style="text-align:center;"><?php if($payment['out'] > 0){ ?> <i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($payment['out']), 2, '.', ''); } echo $returnAmount; ?></td>						
						<td data-placement="bottom" title="<?php echo $payment['bank_name']; ?>" style="text-align:center;"><?php if($payment['in'] > 0){ ?><i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($payment['in']), 2, '.', ''); } ?></td>						
						<td style="text-align:right;"><?php if($avil > 0){ echo number_format((float)($avil), 2, '.', ''); } ?></td>
						<!-- <td style="text-align:right;"><a class="tdBtn" target="_blank" href="<?php echo site_url('customer/paymentEdit'); ?>?customer_id=<?php echo $this->input->get('customer_id'); ?>&payment_id=<?php echo $payment['customer_payment_id']; ?>"  title="Edit"><i class="far fa-edit"></i></a></td> -->
					</tr>
				<?php } ?>
			  </tbody>
			</table>
		</div>
	</div>
	
	<div id="allBillPayment">
		<div class="table-responsive">
			<style>
				.quote_view p{margin-bottom:0px;}		
				.borderbox{border:2px solid gray;}
				.quote_view .border_left{border-left:2px solid gray;}
				.quote_view .border_right{border-right:2px solid gray;}
				.quote_view .border_bottom{border-bottom:2px solid gray;}
				.quote_view .border_top{border-top:2px solid gray;}		
				table {
					table-layout:fixed;
				}		
				.table-bordered td{
					border: 0px solid gray;			
				}		
				.space_bottom{margin-bottom:15px;}
				.card{border:0px solid rgba(0,0,0,.125) !important;}
			</style>
			<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0" style="font-size:13px;">
			  <thead>
				<tr>
				  <th style="width:20%;">Date</th>				  
				  <th style="text-align:center;width:20%;">Reference Number</th>
				  <th style="text-align:center;width:20%;">Out</th>
				  <th style="text-align:center;width:20%;">In </th>
				  <th style="text-align:right;width:20%;">Balance</th>
				</tr>
			  </thead>		 
			  <tbody>
				<?php
					$in = 0;
					$out = 0;
					$avil = 0;
				?>
				
				<?php foreach($all_paymentBill as $payment){  ?>
				<?php
					if($payment['in']){
						$in = $in + $payment['in'];
					}									
					if($payment['out']){
						$out = $out + $payment['out'];	
					}
					#$avil = $in - $out;
					$avil = $payment['out'];
					
				?>
					<tr>
						<td><?php echo dateFormat('d-m-Y',$payment['date_time']); ?></td>						
						<td style="text-align:center;"><?php echo $payment['challan_id']; ?></td>						
						<td style="text-align:center;"><?php if($payment['out'] > 0){ ?> <i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($payment['out']), 2, '.', ''); }  ?><?php //echo $returnAmount; ?></td>						
						<td style="text-align:center;"><?php if($payment['in'] > 0){ ?><i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($payment['in']), 2, '.', ''); } ?></td>						
						<td style="text-align:right;"><?php if($avil > 0){ echo number_format((float)($avil), 2, '.', ''); } ?></td>
					</tr>
				<?php } ?>
			  </tbody>
			</table>
		</div>
	</div>
	
	<div  id="bothPayment">
			
		<div class="table-responsive">
			<style>
				.quote_view p{margin-bottom:0px;}		
				.borderbox{border:2px solid gray;}
				.quote_view .border_left{border-left:2px solid gray;}
				.quote_view .border_right{border-right:2px solid gray;}
				.quote_view .border_bottom{border-bottom:2px solid gray;}
				.quote_view .border_top{border-top:2px solid gray;}		
				table {
					table-layout:fixed;
				}		
				.table-bordered td{
					border: 0px solid gray;			
				}		
				.space_bottom{margin-bottom:15px;}
				.card{border:0px solid rgba(0,0,0,.125) !important;}
			</style>
			<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0" style="font-size:13px;">
			  <thead>
				<tr>
				  <th style="width:20%;">Date</th>
				  <th style="text-align:center;width:20%;">Payment status</th>
				  <th style="text-align:center;width:20%;">Reference Number</th>
				  <th style="text-align:center;width:20%;">Out</th>
				  <th style="text-align:center;width:20%;">In </th>
				  <th style="text-align:right;width:20%;">Balance</th>
				  <th style="text-align:right;width:20%;">Action</th>				  
				</tr>
			  </thead>		 
			  <tbody>
				<?php
					$in = 0;
					$inTot = 0;
					$out = 0;
					$outTot = 0;
					$avil = 0;
				?>
				<?php foreach($paymentSummary as $payment){  ?>
				<?php
					$returnAmount=0;
					if($payment['in']){
						$in = $in + $payment['in'];
					}									
					if($payment['out']){
						$out = $out + $payment['out'];	
						$returnAmount = $CI->customer_model->getGoodsReturnAmountForChallan($payment['cid'],$this->input->get('customer_id'));			
						$returnAmount=round($returnAmount);
					}
					if(!empty($returnAmount)){
						$in = $in + $returnAmount;
						$inTot = $inTot + $returnAmount;
					}
					$avil = $in - $out;
					$inTot = $inTot + $payment['in'];
					$outTot = $outTot + $payment['out'];
					
					
				?>
					<tr>
						<td data-placement="bottom" title="<?php echo $payment['note']; ?>" ><?php echo dateFormat('d-m-Y',$payment['date_time']); ?></td>
						<td style="text-align:center;" > 
						<?php if($payment['mark']){ ?>
							
							<?php if($payment['status'] == "on"){  ?>
								<input type="checkbox" id="<?php echo $payment['mark']; ?>" class="marksOn" data-toggle="toggle" data-size="xs" data-on="Paid" data-off="Unpaid" data-onstyle="success" data-offstyle="danger" checked <?php if($_SESSION['username']!="admin"){ echo "disabled"; } ?>>
							<?php }else{  ?>
								<input type="checkbox" id="<?php echo $payment['mark']; ?>" class="marksOff" data-toggle="toggle" data-size="xs" data-on="Paid" data-off="Unpaid" data-onstyle="success" data-offstyle="danger" >
							<?php } ?>
														
						<?php } else { ?>
							<?php echo "&nbsp;"; ?>
						<?php } ?>
						</td>
						<td style="text-align:center;"><?php echo $payment['challan_id']; ?></td>						
						<td style="text-align:center;"><?php if($payment['out'] > 0){ ?> <i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($payment['out']), 2, '.', ''); } ?></td>
						
						<?php if(!empty($returnAmount)){ ?>
							<td data-placement="bottom" class='text-danger' style="text-align:center;"><i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($returnAmount), 2, '.', '');  ?><br><i>Goods return</i></td>
						<?php }else{ ?>
						<td data-placement="bottom" title="<?php echo $payment['bank_name']; ?>" style="text-align:center;"><?php if($payment['in'] > 0){ ?><i class="<?php echo $payment['currency_faclass']; ?>"></i> <?php echo number_format((float)($payment['in']), 2, '.', ''); } ?></td>		
						<?php } ?>					
						<td style="text-align:right;"><?php  echo number_format((float)($avil), 2, '.', '');  ?></td>
						
						<td style="text-align:right;">
							<?php echo $payment['action']; ?>
							<?php if($payment['note']){ ?>
								<a class="tdBtn noteView" id="<?php echo $payment['customer_payment_id']; ?>" href="#" title="Notes"><i class="far fa-sticky-note"></i></a>							
								
							<?php } ?>
							<?php if($payment['in']){ ?>
								<!-- <a class="tdBtn" target="_blank" href="<?php echo site_url('customer/paymentEdit'); ?>?customer_id=<?php echo $this->input->get('customer_id'); ?>&payment_id=<?php echo $payment['customer_payment_id']; ?>"  title="Edit"><i class="far fa-edit"></i></a>								
								 <a class="tdBtn viewFile" href="#" id="<?php echo $payment['customer_payment_id']; ?>" title="View File">
									<i class="fa fa-file" aria-hidden="true"></i>
								</a> -->							
							<?php } ?>
							<?php if($payment['mark']){ ?>
								<a class="tdBtn statusView" id="<?php echo $payment['mark']; ?>" href="#" title="View"><i class="fas fa-eye"></i></a>	
							<?php } ?>
						</td> 
						
					</tr>
				<?php } ?>
				<tr>
						<td>&nbsp;</td>
						<td style="text-align:center;">&nbsp;</td>						
						<td style="text-align:center;">&nbsp;</td>						
						<td style="text-align:center;"><b><?php  echo number_format((float)($outTot), 2, '.', '');  ?></b></td>						
						<td style="text-align:center;"><b><?php  echo number_format((float)($inTot), 2, '.', ''); ?></b></td>						
						<td style="text-align:right;">&nbsp;</td>
						<td style="text-align:right;">&nbsp;</td>
						
					</tr>
			  </tbody>
			</table>
		</div>
	
	</div>
	
</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" style="max-width: 700px;">				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding: 9px 0 9px 11px;">
				<h4 class="modal-title">Customer Payment Note</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<div class="row">		
					<div class="col-sm-12">					
						<span>Customer Name: <b><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customerInfo->customer_id; ?>"><?php echo $customerInfo->company_name; ?></a></b></span>					
					</div>
				</div><br>
				<div class="row">						
					<div class="col-sm-2"><b>Amount :</b></div>															
					<div class="col-sm-10"><div id="note_amount"></div></div>
				</div>	
				<div class="row">						
					<div class="col-sm-2"><b>Note :</b></div>															
					<div class="col-sm-10"><div id="note_text"></div></div>
				</div>						
					
			</div>
		</div>				  
	</div>
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

<div class="modal fade" id="myModalViewStatus" role="dialog" >
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Payment Status</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>			
			<div class="modal-body">
				<p id="userinfo"></p>
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
			changeMonth: true,
			changeYear: true
		});		
		var base_url = '<?php echo base_url(); ?>';
		
		$("#currency_id").val(1);	
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
		
		/* $(".otherFeilds").hide();
		$('#mode_of_payment').change(function() {
			var selectedText = $(this).find("option:selected").text();
			if(selectedText == 'Bank'){
				$(".otherFeilds").show();
			}else{
				$(".otherFeilds").hide();
			}				
		});  
		*/
		$(".otherFeildsBank").hide();
		$('#mode_of_payment').change(function() {
			var selectedText = $(this).find("option:selected").text();
			if(selectedText == 'Bank'){
				$(".otherFeildsBank").show();
				$("#subBtn").attr('class', 'col-sm-3');
			}else{
				$(".otherFeildsBank").hide();
				$("#subBtn").attr('class', 'col-sm-6');
			}				
		}); 
		
		$("#bothPayment").show();
		$("#allBillPayment").hide();
		$("#allPayment").hide();
		
		$('input[type=radio][name=show_payment]').change(function() {
			var selectId = $('input[type=radio][name=show_payment]:checked').attr('id');
			if(selectId == 'all_payments'){
				$("#allPayment").show();
				$("#bothPayment").hide();
				$("#allBillPayment").hide();
			}
			if(selectId == 'all_bills'){
				$("#allBillPayment").show();
				$("#bothPayment").hide();
				$("#allPayment").hide();
			}
			if(selectId == 'both'){
				$("#bothPayment").show();
				$("#allBillPayment").hide();
				$("#allPayment").hide();
			}
		});
		
		var mySelect = $('#years');
		var year = '<?php echo $this->input->get('year'); ?>';
		var currentMonth=new Date().getMonth();
		var startYear = new Date().getFullYear();
		if(currentMonth>2){
			startYear=startYear+1;
		}
		var prevYear = startYear + 1;
		for (var i = 0; i < 30; i++) {
		  startYear = startYear - 1;
		  prevYear = prevYear - 1;
		  
		  var yearVal = startYear + "-" + prevYear;
		  if(yearVal == year){
			  mySelect.append(
				$('<option selected></option>').val(yearVal).html(yearVal)
			  );
		  }else{
			  mySelect.append(
				$('<option></option>').val(yearVal).html(yearVal)
			  );
		  }
		  
		}
				
		
		$('#years').change(function() {
			var customer_id = '<?php echo $this->input->get('customer_id'); ?>';
			var url = base_url + 'index.php/customer/payment?customer_id='+ customer_id + '&year='+ $(this).val();
			location.href = url;
		});
		$('[data-toggle="tooltip"]').tooltip();  
		
		$('.marksOff').on('change', function(e) {		
			var challan_id = $(this).attr('id');
			var username = '<?php echo $_SESSION['username']; ?>';			
			if($(this).prop("checked") == true){				
				var vall = "on";
				$.confirm({
					title: 'Please Confirm!',
					content: 'Are you sure to mark this challan Paid ? If mark Paid only admin can revert it.',
					type: 'red',
					buttons: {					
						 confirm: function () {
							$.ajax({
								url:'<?php echo site_url('customer/addChallanPaymentStatus'); ?>',
								method: 'post',
								data: {challan_id: challan_id, status: vall},
								dataType: 'json',
								success: function(response){
								}
							});
						},
						cancel: function () {
							$("#"+challan_id).bootstrapToggle('off');							
						}					
					}
				});				
			}
		});
		
		$('.marksOn').on('change', function(e) {
			var challan_id = $(this).attr('id');
			var username = '<?php echo $_SESSION['username']; ?>';			
			if($(this).prop("checked") == false){	
				var vall1 = "off";	
				$.confirm({
					title: 'Please Confirm!',
					content: 'Are you sure to mark this challan Unpaid',
					type: 'red',
					buttons: {					
						 confirm: function () {
							$.ajax({
								url:'<?php echo site_url('customer/addChallanPaymentStatus'); ?>',
								method: 'post',
								data: {challan_id: challan_id, status: vall1},
								dataType: 'json',
								success: function(response){
									if(response.error){							
										alert(response.error);
										$("#"+challan_id).bootstrapToggle('on');
									}
								}
							});
						},
						cancel: function () {
							$("#"+challan_id).bootstrapToggle('on');							
						}					
					}
				});
			}			
		});
		
		$(".noteView").click(function(){
			$("#note_text").html('');
			$("#note_amount").html('');
			var payment_id = this.id;
			var customer_id = <?php echo $this->input->get('customer_id'); ?>;
			$.ajax({
				url:'<?php echo site_url('customer/getCustomerPaymentNote'); ?>',
				method: 'post',
				data: {payment_id: payment_id, customer_id: customer_id}, 
				dataType: 'json',
				beforeSend: function(){
					   $('.loader').show();
				   },
				complete: function(){
					   $('.loader').hide();
				},
				success: function(response){
				    if(response){
						var amt11 = response.amount;						
						var amount = '<i class="'+ response.currency_faclass +'"></i>'+ amt11;
						$("#note_amount").html(amount);						
						$("#note_text").html(response.note);						
					}					
					$("#myModal").modal();		
				}
			}); 
				
		});
		
		// View File		
		$(".viewFile").click(function() {
			$('#bankFiles').html("");
			var base_url = '<?php echo base_url(); ?>';
			var customer_payment_id = $(this).attr('id');
			$.ajax({
				url:'<?php echo site_url('customer/getPaymentFile'); ?>',
				method: 'post',
				data: {customer_payment_id: customer_payment_id},
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
		
		// Status View 		
		$(".statusView").click(function() {
			$('#userinfo').html("");	
			var challan_id = $(this).attr('id');
			$.ajax({
				url:'<?php echo site_url('customer/getChallanPaymentStatus'); ?>',
				method: 'post',
				data: {challan_id: challan_id},
				dataType: 'json',
				success: function(response){
					var htm = '';
					if(response.user_modify_mark == ''){
						htm += "Payment status set Paid by <b>"+response.user_paid+"</b> on <span style='font-style:italic;'>"+formatDate(response.user_datetime)+"</span>";
					}else if(response.user_modify_mark == 'on'){
						htm += "Payment status set Paid by <b>"+response.user_unpaid+"</b> on <span style='font-style:italic;'>"+formatDate(response.user_modify_datetime)+"</span>";
					}else if(response.user_modify_mark == 'off'){
						htm += "Payment status set Unpaid by <b>"+response.user_unpaid+"</b> on <span style='font-style:italic;'>"+formatDate(response.user_modify_datetime)+"</span>";
					}					
					$('#userinfo').html(htm);					
					$("#myModalViewStatus").modal();
				}
			});
			
			$("#myModalViewStatus").modal();
			
		});
		
	});
	function formatDate(date) {
		 var d = new Date(date),
			 month = '' + (d.getMonth() + 1),
			 day = '' + d.getDate(),
			 year = d.getFullYear();

		 if (month.length < 2) month = '0' + month;
		 if (day.length < 2) day = '0' + day;

		 return [day, month, year].join('-');
	 }
</script>		