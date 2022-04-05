<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-8">
				<h1 style="float: left;"><?php echo $customer->company_name; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
			</div>
			<!-- <div class="col-sm-4">
				<div class="float-right">
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('editCustomer'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top"  title="Edit"><i class="far fa-edit"></i></a>&nbsp;
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('notes'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top" title="Notes"><i class="far fa-sticky-note"></i></a>&nbsp;
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('priceList'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top" title="Price List"><i class="fas fa-list"></i></a>&nbsp;
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('customerHistory'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top" title="Customer History"><i class="fas fa-history"></i></a>
				</div>
			</div> -->
		</div>
	</div>

<div class="col-sm-12">
		
	<span>Customer Name: <b><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customerInfo->customer_id; ?>"><?php echo $customerInfo->company_name; ?></a></b></span>	
	
</div>	
	
<fieldset class="proinfo">
	<legend>Customer Payment Information</legend>
	<div class="row" style='border:1px solid gray;'>
								
		<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Amount:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'><b><i class="<?php echo $customerPayments->currency_faclass; ?>"></i> <?php echo  number_format((float)($customerPayments->amount), 2, '.', '') ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Mode of payment:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customerPayments->mode_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Bank:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customerPayments->bank_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Reference Number:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customerPayments->reference_number; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Reference Document:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php if($customerPayments->reference_document){ ?><a href="#" class="viewFile" id="<?php echo $this->input->get('payment_id'); ?>" >Documents</a><?php } ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Date Of Payment:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo dateFormat('d-m-Y',$customerPayments->date_of_payment); ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Note:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customerPayments->note; ?></b></label>
					</div>
				</div>
			</div>
			
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Added By:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customerPayments->username; ?></b> On <span style="font-style:italic;"><?php echo dateFormat('d-m-Y',$customerPayments->date_added); ?></span></label>
					</div>
				</div>
			</div>
			
			<!-- <div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Created Date:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo dateFormat('d-m-Y',$customerPayments->date_added); ?></b></label>
					</div>
				</div>
			</div> -->
			
</fieldset>
</br>	
<div class="col-sm-12 mt-5"> </div>
<div></br>

<div class="modal fade" id="myModalViewFIle" role="dialog" >
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Bank Files</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>			
			<div class="modal-body">
				<?php foreach($payment_file as $file){ ?>
					<a target='_blank' href="<?php echo base_url()."uploads/bank/".$file['bank_file']; ?>"><?php echo $file['bank_file']; ?></a><br>
				<?php } ?>
			</div>
		</div>				  
	</div>
</div>

<script>
$(document).ready(function() {
	// View File		
	$(".viewFile").click(function() {
		/* $('#bankFiles').html("");
		var base_url = '<?php echo base_url(); ?>';
		var customer_payment_id = $(this).attr('id');
		//alert(customer_payment_id);
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
		}); */ 
		$("#myModalViewFIle").modal();
	});
});
</script>