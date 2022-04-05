<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<form action="<?php echo site_url('updateOrder'); ?>" method="POST" name="updateOrderForm" id="updateOrderForm">
	<input type="hidden" name="order_id" value="<?php echo $ordersInfo->order_id; ?>">	
	<input type="hidden" name="quotation_id" value="<?php echo $ordersInfo->quotation_id; ?>">	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">
				<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>
			</div>
			<div class="col-sm-6">
				<div class="float-right">
					<button type="button" id="updateOrder" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Update Order"><i class="far fa-save"></i></button>					
				</div>
			</div>
		</div>
	</div>
	
	<?php if(isset($success)){ ?>
		<div class="alert alert-success">
		  <?php echo $success; ?>
		</div>
	<?php } ?>
	
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
		.card {border:0px solid rgba(0,0,0,.125);}
	</style>
	
	<div class="card mb-3">	
		<div class="card-body">
			<div class="row quote_view borderbox">
				<div class="col-sm-6 border_right">
					<p><b>Exporter:</b></p>
					<p><b>TARUN ENTERPRISES</b></p>
					<p><?php echo $ordersInfo->store_address; ?></p>
					<p>Phone: <?php echo $ordersInfo->store_phone; ?></p>
					<p>Email: <?php echo $ordersInfo->store_email; ?></p>
					<p>GST No: <?php echo $ordersInfo->store_gst_no; ?></p>
					<?php if($ordersInfo->store_name == 'Allahabad'){  ?>
						<p>Drug Licence: <?php echo $ordersInfo->drug_licence_no; ?></p>
						<p>Dt. <?php echo $ordersInfo->drug_date; ?></p>
					<?php } else { ?>
						<p>&nbsp;</p>						
					<?php } ?>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-6 border_right border_bottom">
							<p><b>Order No:</b></p>
							<p style="margin-bottom: 15px;"><?php echo getOrderNo($ordersInfo->order_id); ?></p>
						</div>
						<div class="col-sm-6 border_bottom">
							<p><b>Order Date:</b></p>
							<p style="margin-bottom: 15px;"><?php echo dateFormat('F, d, Y', $ordersInfo->order_date); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 border_right border_bottom">
							<p><b>Issued From:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->store_name; ?></p>
							
						</div>
						<div class="col-sm-6 border_bottom">
							<p><b>Currency:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->currency; ?></p>
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 border_right ">
							<p><b>Insurance:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->insurance; ?></p>
						</div>
						<div class="col-sm-6 ">
							<p><b>Generated by:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->firstname .' '.$ordersInfo->lastname; ?></p>
						</div>
					</div>
				</div>
				
				<div class="col-sm-6 border_top border_right">
					<p><b>Customer(Bill to):</b></p>
					<?php //echo nl2br($quotationInfo->billing_details); ?>
					<select name="billing_details_default" id="billing_details_default" class="form-control">
						<option value="">-- Select --</option>
						<?php $i=1; foreach($addresses as $address){ ?>							
							<option value="<?php echo $address['address_id']; ?>"><?php $address['address_id'] = ''; ?><?php echo implode(', ',array_filter($address)); ?></option>
						<?php $i++; } ?>
					</select>
					<textarea name="billing_details" id="billing_details" rows="8"  class="form-control" required><?php if($ordersInfo->billing_details) { echo $ordersInfo->billing_details; } ?></textarea>
				</div>
				
				<div class="col-sm-6 border_top">
					<p><b>Consingee(Ship to):</b> &nbsp;&nbsp; <input type="checkbox" name="same_address" id="same_address"><span style="color:gray;"> Same as Bill Details</span></p>					
					<?php //echo nl2br($quotationInfo->shipping_details); ?>
					<select name="shipping_details_default" id="shipping_details_default" class="form-control">	
						<option value="">-- Select --</option>
						<?php $i=1; foreach($addresses as $address){ ?>							
							<option value="<?php echo $address['address_id']; ?>"><?php $address['address_id'] = ''; ?><?php echo implode(', ',array_filter($address)); ?></option>
						<?php $i++; } ?>
					</select>
					<textarea name="shipping_details" id="shipping_details" rows="8" class="form-control" required><?php if($ordersInfo->shipping_details) { echo $ordersInfo->shipping_details; } ?></textarea>
				</div>
				
				<div class="col-sm-6 border_top border_right border_bottom">
					<div class="row">
						<div class="col-sm-6 border_right">
							<p><b>Terms of Delivery:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->delivery; ?></p>
						</div>
						<div class="col-sm-6">
							<p><b>Terms of Payments:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->payment_terms; ?></p>
						</div>
					</div>
				</div>
				
				<div class="col-sm-6 border_top border_bottom">
					<p><b>Terms & Conditions:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $ordersInfo->terms_conditions; ?></p>
				</div>
				
				<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">
					<tr>
						<td class="border_right" style="width:4%;">S.N.</td>
						<td class="border_right" style="width:45.3%;">Product Description</td>
						<td class="border_right" style="width:10.5%;">HSN</td>
						<td class="border_right" style="width:6%;">Qty</td>
						<td class="border_right" style="width:6%;">Unit</td>
						<td class="border_right" style="width:6%;">Rate</td>
						<td class="border_right" style="width:12%;">Discount (Per Unit)</td>
						<td style="width:9%;" align="right">Net Amount</td>
					</tr>
					
					<?php
						$net_total = 0;
						$i=1;
						foreach($orderProducts as $productInfo){ 
							$net_total = $net_total + $productInfo['net_amount'];
							$gstAmount=(((float)$productInfo['rate']-(float)$productInfo['discount'])*$productInfo['product_gst'])/100;
							$gstAmount=$gstAmount*$productInfo['qty'];
					?>						
						<tr class="prtr" data-val="<?php echo $productInfo['prod_id'];?>">
							<!-- <input type="hidden" name="gst[<?php echo $productInfo['product_gst'];?>]" id="gst_<?php echo $productInfo['prod_id'];?>" value="<?php echo $productInfo['product_gst'];?>">
							<input type="hidden" name="gstAmount[<?php echo $productInfo['product_gst'];?>]" id="gstAmt_<?php echo $productInfo['prod_id'];?>" value="<?php echo number_format((float)$gstAmount, 2, '.', ''); ?>"> -->
							<td class="border_right border_top"><!-- <input type="checkbox" name="product_id[]" class="procheckbox" id="pro_<?php echo $productInfo['prod_id'];?>" value="<?php echo $productInfo['prod_id'];?>" checked> -->&nbsp;&nbsp;<?php echo $i; ?></td>
							<td class="border_right border_top"><?php echo $productInfo['description']; ?></td>
							<td class="border_right border_top"><?php echo $productInfo['hsn']; ?></td>
							<!-- <td class="border_right border_top"><input type="text" name="qty[<?php echo $productInfo['prod_id'];?>]" class="qty" id="proqty_<?php echo $productInfo['prod_id'];?>" style="width:57px;border: 1px solid gray;" value="<?php echo $productInfo['qty']; ?>"></td> -->
							<td class="border_right border_top"><?php echo $productInfo['qty']; ?></td>
							<td class="border_right border_top"><?php echo $productInfo['unit']; ?></td>
							<td class="border_right border_top"><?php echo number_format((float)$productInfo['rate'], 4, '.', ''); ?></td>
							<td class="border_right border_top"><?php echo number_format((float)$productInfo['discount'], 4, '.', ''); ?></td>
							
							<!-- <input type="hidden" name="pro_amount[<?php echo $productInfo['prod_id'];?>]" id="proamt_<?php echo $productInfo['prod_id'];?>" value="<?php echo number_format((float)$productInfo['net_amount'], 2, '.', ''); ?>"> -->
							<td class="border_top" align="right"><?php echo number_format((float)$productInfo['net_amount'], 2, '.', ''); ?></td>
						</tr>
					
					<?php $i++; } ?>					
					<tr class="nettottr">
						<td class="border_right border_top" colspan="7" align="right" >Net Total</td>
						<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="net_total"><?php echo number_format((float)$net_total, 2, '.', ''); ?></span></td>
					</tr>
					<tr class="ftr">
						 <td class="border_right border_top" colspan="7" align="right" ><!-- <span style="float:left;"><b>Please enter Freight Charges : </b><input type="text" name="freightcharge" autocomplete="off" id="freightcharge" style="width:100px;border: 1px solid gray;" value="<?php echo number_format((float)$quotationInfo->freight_charge, 2, '.', ''); ?>"> --></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Freight Charges</td> 
						<td colspan="" class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; 
						<span id="freight_charge"><?php echo number_format((float)$ordersInfo->freight_charge, 2, '.', ''); ?></span></td>
					</tr>
					<tbody id="progstall">
							<?php
								if(($ordersInfo->currency == 'INR') && ($customerInfo->countryId == '99')){	
								if($productgst){ 
								$totwithgst = 0;
								$freight_charge = $ordersInfo->freight_charge;
								foreach($productgst as $progst){
								$perProFrch = ($freight_charge / $net_total) * $progst['net_amount'];
								$perProFrchWthGst = ($perProFrch * $progst['product_gst']/100);
								$totgst = $perProFrchWthGst + ($progst['net_amount'] * $progst['product_gst']/100);
								$totgst = number_format((float)$totgst, 2, '.', '');
								$totwithgst = $totwithgst + $totgst;
							?>
							
								<tr class="gstrow" data-val="<?php echo $progst['product_gst']; ?>" id="gs_<?php echo $progst['product_gst']; ?>">
									<td class="border_right border_top" colspan="7" align="right" >GST @ <?php echo $progst['product_gst']; ?>%</td>
									<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id='gstTotal_<?php echo $progst['product_gst']; ?>'><?php echo number_format((float)$totgst, 2, '.', ''); ?></span></td>
								</tr>
							
						<?php } ?>
						<?php } ?>
						<?php } ?>
					</tbody>
					<tr class="grndtr">
						<td class="border_right border_top" colspan="7" align="right" >Grand Total</td>
						<td class="border_right border_top" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="grand_total"><?php echo number_format((float)($net_total + $ordersInfo->freight_charge + $totwithgst), 2, '.', ''); ?></span></td>
					</tr>
				</table>
			</div>
			</br>
			<div class="row">
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
						<p style="margin: 0px;">Greetings!<br>
Thank you for your valued order. Same is under process. We request you to please check all the details as above and arrange payment as per banking details below. In case you wish to use online payment , please use our payment gateway at our website <a href="http://www.optitecheyecare.com/payment.php">www.optitecheyecare.com</a> .</p> 
						<p style="margin: 0px;"></p>						
					</div>					
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
						<p style="margin: 0px;">Remit to:</p>
					</div>
					
					<div class="col-sm-6" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Payment :</b></p><p style="margin: 0px;float:left;">100% T/T(wire)</p>
						</div>	
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Beneficiary's Name:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->beneficiary_name; ?></p>
						</div>
						
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Bank Name:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_name; ?></p>
						</div>
						
					</div>
					
					<div class="col-sm-6" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:40%;float:left;"><b>Bank Details for</b></p><p style="margin: 0px;float:left;"> (<?php echo $ordersInfo->currency; ?>)</p>
						</div>	
						<div style="width:100%;float:left;">	
							<p style="margin: 0px;width:40%;float:left;"><b>Account No.:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->account_number; ?></p>
						</div>
						
						<?php if($ordersInfo->currency == 'INR'){ ?>
							<?php if(!empty($bankInfo->ifsc_code)){ ?>
								<div style="width:100%;float:left;">
									<p style="margin: 0px;width:40%;float:left;"><b>IFSC Code :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->ifsc_code; ?></p>
								</div>
							<?php } ?>
						<?php } else { ?>						
							<?php if(!empty($bankInfo->swift_code)){ ?>
								<div style="width:100%;float:left;">
									<p style="margin: 0px;width:40%;float:left;"><b>SWIFT Code :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->swift_code; ?></p>
								</div>
							<?php } ?>	
						<?php } ?>						
					</div>
					
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">					
						<div style="width:100%;float:left;">
							<p style="margin: 0px;width:20%;float:left;"><b>Bank Address :</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_address; ?></p>
						</div>										
					</div>				
				
					<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">						
						<p style="margin: 0px;">Bank remittance charge shall be paid by payer(buyer)</p><br>
						<p style="margin: 0px;">For Tarun Enterprises</p><br><br>
						<p style="margin: 0px;">Order Processing Team</p><br>
						<!-- <p style="margin: 0px;font-size:14px;">Created by (<?php echo $ordersInfo->firstname .' '.$ordersInfo->lastname; ?>)</p> --> 
					</div>					
				</div>
		</div>		
	</div>	
	</form>	
</div>
<script>
	$(document).ready(function() {		
		$("#updateOrder").click(function(){
			 $("#updateOrderForm").submit();
		});

		$('#billing_details_default').change(function() {
			
			var address_id = $("#billing_details_default option:selected").val();
			if(address_id == ''){
				$("#billing_details").val('');
				return false;
			}
			var customer_id = '<?php echo $customerInfo->customer_id; ?>';			
			$.ajax({
				url:'<?php echo site_url('getAddressByAddressId');?>',
				method: 'post',					
				data: {address_id: address_id, customer_id: customer_id},
				dataType: 'json',
				success: function(response){						
					var company_name1 			= (response.company_name) ? response.company_name : '';
					var contact_person1 		= (response.contact_person) ? "\n" + response.contact_person : '';
					var address_11 				= (response.address_1) ? "\n" + response.address_1 : '';
					var address_21 				= (response.address_2) ? "\n" +response.address_2 : '';
					var city1 					= (response.city) ? "\n" +response.city : '';						
					var district1 				= (response.district) ? "," +response.district : '';
					var state1 					= (response.state_name) ? "," +response.state_name : '';
					var pin1 					= (response.pin) ? "\n" +response.pin : '';
					var country1 				= (response.country_name) ? "," +response.country_name : '';
					var phone1 					= (response.phone) ? " " + response.phone : '';
					var mobile1 				= (response.mobile) ? " " + response.mobile : '';
					
					var mob = '';
					if(phone1 && mobile1){ 
						mob = "\nMobile: "+phone1 + ", "+mobile1;
					}else if((phone1) && (mobile1 == '')) {
						mob = "\nMobile: "+phone1;
					} else if((mobile1) && (phone1 == '')){
						mob = "\nMobile: "+mobile1;
					}
					var email1 					= (response.email) ? "\nEmail: " +response.email : '';						
				
					var billing_address = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;	
					
					$("#billing_details").val(billing_address);
				}
			});
			
			
		});
		
		$('#shipping_details_default').change(function() {
			$("#same_address").prop('checked', false);
			
			var address_id = $("#shipping_details_default option:selected").val();
			if(address_id == ''){
				$("#shipping_details").val('');
				return false;
			}
			var customer_id = '<?php echo $customerInfo->customer_id; ?>';			
			$.ajax({
				url:'<?php echo site_url('getAddressByAddressId');?>',
				method: 'post',					
				data: {address_id: address_id, customer_id: customer_id},
				dataType: 'json',
				success: function(response){						
					var company_name1 			= (response.company_name) ? response.company_name : '';
					var contact_person1 		= (response.contact_person) ? "\n" + response.contact_person : '';
					var address_11 				= (response.address_1) ? "\n" + response.address_1 : '';
					var address_21 				= (response.address_2) ? "\n" +response.address_2 : '';
					var city1 					= (response.city) ? "\n" +response.city : '';						
					var district1 				= (response.district) ? "," +response.district : '';
					var state1 					= (response.state_name) ? "," +response.state_name : '';
					var pin1 					= (response.pin) ? "\n" +response.pin : '';
					var country1 				= (response.country_name) ? "," +response.country_name : '';
					var phone1 					= (response.phone) ? " " + response.phone : '';
					var mobile1 				= (response.mobile) ? " " + response.mobile : '';
					
					var mob = '';
					if(phone1 && mobile1){ 
						mob = "\nMobile: "+phone1 + ", "+mobile1;
					}else if((phone1) && (mobile1 == '')) {
						mob = "\nMobile: "+phone1;
					} else if((mobile1) && (phone1 == '')){
						mob = "\nMobile: "+mobile1;
					}
					var email1 					= (response.email) ? "\nEmail: " +response.email : '';						
				
					var shipping_details = company_name1 + address_11 + address_21 + city1 + district1 + state1 + pin1 + country1 + mob + email1 + contact_person1;	
					
					$("#shipping_details").val(shipping_details);
				}
			});
			
		});
		
		$("#same_address").on("click", function () {			
			if($(this).is(":checked")) {
				 $("#shipping_details").val($("#billing_details").val());   
		    } else {
				$("#shipping_details").val('');  
			}			
		});		
	});	
		
</script>