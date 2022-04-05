<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Bootstrap core CSS-->
<link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Page level plugin CSS-->
<link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

 <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>


<!-- Custom styles for this template-->
<link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css" rel="stylesheet"> 
<script src="<?php echo base_url(); ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/common.js"></script>
<div class="container-fluid">	
<div style="text-align:center;"><input type="button" onclick="printDiv('printableArea')" value="print" /></div>
		<style>
			.quote_view p{margin-bottom:0px;}		
			.borderbox{border:2px solid black;}
			.quote_view .border_left{border-left:2px solid black;}
			.quote_view .border_right{border-right:2px solid black;}
			.quote_view .border_bottom{border-bottom:2px solid black;}
			.quote_view .border_top{border-top:2px solid black;}
			
			table {
				table-layout:fixed;
			}
			
			.table-bordered td{
				border: 0px solid black;			
			}
			
			.space_bottom{margin-bottom:15px;}
			.card{border: 0px solid rgba(0,0,0,.125) !important; }
		</style>
		
		<div class="card mb-3" id="printableArea">
				<div style="width:100%;padding-top:30px;padding-bottom:50px;">
					<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
				</div>
				<input type="hidden" name="challan_id" value="<?php echo $challanInfo->challan_id; ?>">
				<div class="card-body">
					
					<h3 style="text-align:center;">DISPATCH NOTE</h3>
					<div class="row quote_view borderbox" style="border: 2px solid black;font-size:21px;">
						<div class="col-sm-12 justify-content-center ">
							<div style="text-align:center;">
								<!-- <p><b>Exporter:</b></p> -->
								<p style="padding:10px;margin-bottom:0px;">Thank You for valued order.</p>								
							</div>
						</div>	
						<!-- <div class="col-sm-12 justify-content-center border_top" style="border-top: 2px solid black;">
							<div style="text-align:center;">
								
								<p style="margin-bottom:0px;"><b>TARUN ENTERPRISES</b></p>
								<p style="margin-bottom:0px;"><?php echo $challanInfo->store_address; ?> </p>
								<p style="margin-bottom:0px;">Phone: <?php echo $challanInfo->store_phone; ?></p>
								<p style="margin-bottom:0px;">Email: <?php echo $challanInfo->store_email; ?></p>
								<p style="margin-bottom:0px;">GST No: <?php echo $challanInfo->store_gst_no; ?></p>
								<?php if($challanInfo->store_name == 'Allahabad'){  ?>
									<p style="margin-bottom:0px;">Drug Licence: ALLD/5/21B/385,ALLD/5/20B/388</p>
									<p style="margin-bottom:0px;">Dt. 06.05.2008</p>
								<?php } ?>
							</div>
						</div> -->	
						
						<div class="col-sm-6 border_top border_right" style="border-top: 2px solid black;border-right: 2px solid black;">
							<p style="margin-bottom:0px;"><b>Bill to:</b></p>
							
							<?php $billingAddress=nl2br($ordersInfo->billing_details);
								while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
									print "<b>$matcher[1]</b>";
									$billingAddress=after($matcher[0],$billingAddress);
									break;
								}
							?>
							<?php echo $billingAddress; ?>
							
							<?php if($customerInfo->gst){ ?>
							<p style="margin-bottom:0px;">GST No.: <?php echo $customerInfo->gst; ?></p>
							<?php } ?>
							<?php if($customerInfo->company_registration_no){ ?>
							<p style="margin-bottom:0px;">Reg. No.: <?php echo $customerInfo->company_registration_no; ?></p>
							<?php } ?>
						</div>
						
						<div class="col-sm-6 border_top" style="border-top: 2px solid black;">
							<p style="margin-bottom:0px;"><b>Ship to:</b></p>					
							<?php $shippingAddress=nl2br($ordersInfo->shipping_details);
								while(preg_match("/(.*?)\n/is",$shippingAddress,$matcher)){
									print "<b>$matcher[1]</b>";
									$shippingAddress=after($matcher[0],$shippingAddress);
									break;
								}
							?>
							<?php echo $shippingAddress; ?>
							
							<?php if($customerInfo->gst){ ?>
							<p style="margin-bottom:0px;">GST No.: <?php echo $customerInfo->gst; ?></p>
							<?php } ?>
							<?php if($customerInfo->company_registration_no){ ?>
							<p style="margin-bottom:0px;">Reg. No.: <?php echo $customerInfo->company_registration_no; ?></p>
							<?php } ?>
						</div>
						
						<div class="col-sm-6 border_top border_right border_bottom" style="border-top: 2px solid black;border-right: 2px solid black;border-bottom: 2px solid black;">					
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Challan No.<?php echo getChallanNo($challanInfo->challan_id); ?> </b></p>						
						</div>
						
						<div class="col-sm-6 border_top border_bottom" style="border-top: 2px solid black;border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Issued From:</b> INDIA</p>
						</div>
						
						
						
						
						<div class="col-sm-6  border_right border_bottom" style="border-top: 0px solid black;border-right: 2px solid black;border-bottom: 2px solid black;">		
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Challan Date.</b> <?php echo date('F, d, Y', strtotime($challanInfo->challan_date)); ?></p>						
						</div>
						
						<div class="col-sm-6  border_bottom" style="border-top: 0px solid black;border-bottom: 2px solid black;">
						<?php								
								$invoice_date = new DateTime($challanInfo->invoice_date);
								if($challanInfo->invoice_date == '0000-00-00 00:00:00' || $challanInfo->invoice_date == null){
									$invoice_date = '';
								} else {
									$invoice_date = $invoice_date->format('d-m-Y');
								}
							?>
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Invoice Date:</b> <?php echo $invoice_date; ?></p>
						</div>
						
						
						
						
						<div class="col-sm-6  border_right border_bottom" style="border-right: 2px solid black;border-bottom: 2px solid black;">					
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Manual Challan No.:</b> <?php echo $challanInfo->manual_challan_no; ?></p>					
						</div>
						
						<div class="col-sm-6  border_bottom" style="border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Manual Challan Date:</b> <?php if($challanInfo->manual_challan_date != '0000-00-00 00:00:00'){ echo date('F, d, Y', strtotime($challanInfo->manual_challan_date)); } ?></p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom" style="border-right: 2px solid black;border-bottom: 2px solid black;">					
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Customer Id:</b> <?php echo $challanInfo->customer_id; ?></p>					
						</div>
						
						<div class="col-sm-6  border_bottom" style="border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Method Of Shipment:</b> <?php echo $challanInfo->method_of_shipment; ?></p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom" style="border-right: 2px solid black;border-bottom: 2px solid black;">					
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Order No:</b> <b><?php echo getOrderNo($challanInfo->order_id); ?></b></p>					
						</div>
						
						<div class="col-sm-6  border_bottom" style="border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Docket No:</b> <?php echo $challanInfo->docket_no; ?></p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom" style="border-right: 2px solid black;border-bottom: 2px solid black;">					
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Sales Person:</b> <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?></p>					
						</div>
						
						<!-- <div class="col-sm-6  border_bottom" style="border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Payment Terms:</b> <?php echo $ordersInfo->payment_terms; ?></p>
						</div>
						
						<div class="col-sm-6  border_right border_bottom" style="border-right: 2px solid black;border-bottom: 2px solid black;">					
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Special Information:</b> <?php echo $ordersInfo->special_instruction; ?></p>					
						</div> -->
						
						<div class="col-sm-6  border_bottom" style="border-bottom: 2px solid black;">
							
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Invoice No:</b> <?php echo $challanInfo->invoice_no; ?> </b> </p>
						</div>
						
						<div class="col-sm-6 border_right" style="border-right:2px solid black;black;border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">Dispatched From:</b> <?php echo $challanInfo->store_name; ?></p>							
						</div>
						<div class="col-sm-6" style="border-bottom: 2px solid black;">
							<p style="margin-bottom:0px;"><b style="float:left;width:37%;">SB Number:</b> <?php echo $challanInfo->sb_number; ?></p>							
						</div>
						
						<div class="col-sm-6 border_right" style="border-right:2px solid black;black;">
							<p><b>Terms of Delivery:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->delivery; ?></p>
						</div>
						<div class="col-sm-6">
							<p><b>Terms of Payments:</b></p>
							<p style="margin-bottom: 15px;"><?php if($challanInfo->payment_terms){ echo $challanInfo->payment_terms; } ?></p>
						</div>
						
						
						<div class="col-sm-6 border_right" style="border-right:2px solid black;black;border-bottom: 2px solid black;border-top: 2px solid black;">
							<p><b>Special Information:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->special_instruction; ?></p>
						</div>
						<div class="col-sm-6" style="border-bottom: 2px solid black;border-top: 2px solid black;">
							<p><b>Terms & Conditions:</b></p>
							<p style="margin-bottom: 15px;"><?php echo $ordersInfo->terms_conditions; ?></p>
						</div>					
						
												
						<table class="" id="protable" width="100%" cellspacing="0" style="font-size:21px;">
							<tr>
								<th class="border_right" style="width:4%;border-right: 2px solid black;">S.N.</th>
								<th class="border_right" style="width:80%;border-right: 2px solid black;">Product Description</th>
								
								<th class="border_right" style="border-right: 2px solid black;">Unit</th>
								<th class="" style="">Qty</th>
								
							</tr>
							
							<?php
								$net_total = 0;
								$i=1;
								foreach($challanInfoProduct as $challanProduct){ 
									$net_total = $net_total + $challanProduct['net_total'];
									
									$expDate = new DateTime($challanProduct->batch_exp_date);
									$mgfDate = new DateTime($challanProduct->batch_mfg_date);							
							?>						
								
								<tr class="prtr">
									<td class="border_right border_top" style="border-right: 2px solid black;border-top: 2px solid black;"><?php echo $i; ?></td>
									<td class="border_right border_top" style="border-right: 2px solid black;border-top: 2px solid black;"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>							
									<td class="border_right border_top" style="border-right: 2px solid black;border-top: 2px solid black;"><?php echo $challanProduct['pro_unit']; ?></td>
									<td class=" border_top" style="border-top: 2px solid black;"><?php echo $challanProduct['qty']; ?></td>													
								</tr>
							
							<?php $i++; } ?>					
						</table>
					</div>
					<div class="row" style="font-size:21px;">
						<div class="col-sm-12" style="padding-left:0px;margin-top:20px;">
							<p style="margin: 0px;">Doc No. TE/F-7.5-07 For Tarun Enterprises</p> 
							<p style="margin: 0px;">Prepared by <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?>|&nbsp;&nbsp;Packed by </p>
						</div>					
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">
							<p style="margin: 0px;">Remit to:</p> 
							<div style="width:100%;float:left;">
								<p style="margin: 0px;width:25%;float:left;"><b>Payment :</b></p><p style="margin: 0px;float:left;">100% T/T(wire)</p>
							</div>
							<div style="width:100%;float:left;">
								<p style="margin: 0px;width:25%;float:left;"><b>Bank Details for</b></p><p style="margin: 0px;float:left;"> (<?php echo $ordersInfo->currency; ?>)</p>
							</div>
							<div style="width:100%;float:left;">
								<p style="margin: 0px;width:25%;float:left;"><b>Beneficiary's Name:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->beneficiary_name; ?></p>
							</div>
							<div style="width:100%;float:left;">	
								<p style="margin: 0px;width:25%;float:left;"><b>Account No.:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->account_number; ?></p>
							</div>
							<div style="width:100%;float:left;">
								<p style="margin: 0px;width:25%;float:left;"><b>Bank Name:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_name; ?></p>
							</div>
							<div style="width:100%;float:left;">
								<p style="margin: 0px;width:25%;float:left;"><b>Bank Address:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->bank_address; ?></p>
							</div>
							
							<?php if(!empty($bankInfo->swift_code)){ ?>
								<div style="width:100%;float:left;">
									<p style="margin: 0px;width:25%;float:left;"><b>SWIFT Code:</b></p><p style="margin: 0px;float:left;"><?php echo $bankInfo->swift_code; ?></p>
								</div>
							<?php } ?>
							<?php if(!empty($bankInfo->ifsc_code)){ ?>
								<div style="width:100%;float:left;">
									<p style="margin: 0px;width:25%;float:left;"><b>IFSC Code:</b></p><p style="margin: 0px;float:left;"> <?php echo $bankInfo->ifsc_code; ?></p>
								</div>
							<?php } ?>
							<p style="margin: 0px;">Bank remittance charge shall be paid by payer(buyer)</p><br>
							<p style="margin: 0px;">For Tarun Enterprises</p><br><br>
							<p style="margin: 0px;">Order Processing Team</p><br>
							<p style="margin: 0px;font-size:14px;">Created by (<?php echo $ordersInfo->firstname .' '.$ordersInfo->lastname; ?>)</p>
						</div>					
					</div>
					
				</div>			
		</div>	
</div>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<?php 
function after ($inthis, $inthat)
{
if (!is_bool(strpos($inthat, $inthis)))
return substr($inthat, strpos($inthat,$inthis)+strlen($inthis));
}
?>