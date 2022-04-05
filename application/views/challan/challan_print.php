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
		
		<div class="card-body">
			<h3 style="text-align:center;">DISPATCH CHALLAN From <?php echo $challanInfo->store_name; ?><span style="float:right"><?php echo str_pad($challanInfo->challan_id, 6, "C00000", STR_PAD_LEFT); ?></span></h3>
			<div class="row quote_view borderbox" style="border: 2px solid black;font-size: 21px;">
				<div class="col-sm-12 justify-content-center">
					<div style="text-align:center;">
						<!-- <p><b>Exporter:</b></p> -->
						<p style="margin-bottom:0px;"><b>TARUN ENTERPRISES</b></p>
						<p style="margin-bottom:0px;"><?php echo $challanInfo->store_address; ?> </p>
						<p style="margin-bottom:0px;">Phone: <?php echo $challanInfo->store_phone; ?></p>
						<p style="margin-bottom:0px;">Email: <?php echo $challanInfo->store_email; ?></p>
						<p style="margin-bottom:0px;">GST No: <?php echo $challanInfo->store_gst_no; ?>
						<?php if($challanInfo->store_name == 'Allahabad'){  ?>
							Drug Licence: ALLD/5/21B/385,ALLD/5/20B/388 Dt. 06.05.2008
						<?php } ?></p>
					</div>
				</div>	
				
				<div class="col-sm-6 border_top border_right" style="border-top:2px solid black;border-right:2px solid black;">
					<p style="margin-bottom:0px;"><b>Bill to:</b></p>
					<?php $billingAddress=nl2br($challanInfo->billing_details);
						while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
							print "<b>$matcher[1]</b>";
							$billingAddress=after($matcher[0],$billingAddress);
							break;
						}
					?>
					<?php echo $billingAddress; ?>
					
					<?php if($customerInfo->gst){ ?>
					<p style="margin-bottom:0px;"><b>GST No.:</b> <?php echo $customerInfo->gst; ?></p>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<p style="margin-bottom:0px;"><b>Reg. No.:</b> <?php echo $customerInfo->company_registration_no; ?></p>
					<?php } ?>	
				</div>
				
				<div class="col-sm-6 border_top" style="border-top:2px solid black;">
					<p style="margin-bottom:0px;"><b>Ship to:</b></p>					
					<?php $shippingAddress=nl2br($challanInfo->shipping_details);
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
				
				<div class="col-sm-6 border_top border_right border_bottom" style="border-top:2px solid black;border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Challan No.</b> <?php echo str_pad($challanInfo->challan_id, 6, "C00000", STR_PAD_LEFT); ?> &nbsp;&nbsp;&nbsp; <b>Dated:</b>  <?php echo date('F, d, Y', strtotime($challanInfo->challan_date)); ?></p>						
				</div>
				
				<div class="col-sm-6 border_top border_bottom" style="border-top:2px solid black;border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Issued From:</b> INDIA</p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Manual Challan No.:</b> <?php echo $challanInfo->manual_challan_no; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom" style="border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Manual Challan Date:</b> <?php if($challanInfo->manual_challan_date != '0000-00-00 00:00:00'){ echo date('F, d, Y', strtotime($challanInfo->manual_challan_date)); } ?></p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Customer Id:</b> <?php echo $challanInfo->customer_id; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom" style="border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Method Of Shipment:</b> <?php echo $challanInfo->method_of_shipment; ?></p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Order Id: <?php echo str_pad($challanInfo->order_id, 6, "O00000", STR_PAD_LEFT); ?></b></p>					
				</div>
				
				<div class="col-sm-6  border_bottom" style="border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Docket No:</b> <?php echo $challanInfo->docket_no; ?></p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Sales Person:</b> <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom" style="border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Payment Terms:</b> <?php if($challanInfo->payment_terms){ echo $challanInfo->payment_terms; }  ?></p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Special Information:</b> <?php echo $ordersInfo->special_instruction; ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom" style="border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Invoice No:</b> <?php echo $challanInfo->invoice_no; ?> &nbsp;&nbsp;&nbsp; <b>Dt:</b> <?php if($challanInfo->invoice_date != '0000-00-00 00:00:00'){ echo date('F, d, Y', strtotime($challanInfo->invoice_date)); } ?></p>
				</div>
				
				<!-- <div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;"> -->
					
				<div class="col-sm-6 border_right" style="border-right:2px solid black;black;">
					<p><b>Terms of Delivery:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $ordersInfo->delivery; ?></p>
				</div>
				<div class="col-sm-6">
					<p><b>Terms of Payments:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $ordersInfo->payment_terms; ?></p>
				</div>
					
				
				<div class="col-sm-12 " style="border-bottom:2px solid black;border-top:2px solid black;">
					<p><b>Terms & Conditions:</b></p>
					<p style="margin-bottom: 15px;"><?php echo $ordersInfo->terms_conditions; ?></p>
				</div>
				
				<table class="" id="protable" width="100%" cellspacing="0" style="font-size: 21px;">
					<tr>
						<th  style="width:4%;border-right:2px solid black;">S.N.</th>
						<th  style="width:25%;border-right:2px solid black;">Product Description</th>
						<th  style="width:8%;border-right:2px solid black;text-align:center;">HSN</th>
						<th  style="width:7%;border-right:2px solid black;text-align:center;">Unit</th>
						<th  style="width:5%;border-right:2px solid black;text-align:center;">Qty</th>
						<th  style="border-right:2px solid black;text-align:center;">Rate</th>
						<th  style="border-right:2px solid black;text-align:center;">Batch No</th>									
						<th  style="width:12%;border-right:2px solid black;text-align:center;">Mfg Dt./Exp Dt.</th>
						<th  style="border-right:2px solid black;text-align:center;">Disc</th>									
						<th style="text-align:right;">Net Amount</th>	
					</tr>
					
					<?php
						$net_total = 0;
						$i=1;
						foreach($challanInfoProduct as $challanProduct){ 
							$net_total = $net_total + $challanProduct['net_total'];
							
						    $mgfDate  = new DateTime($challanProduct['batch_mfg_date']);
						    $expDate = new DateTime($challanProduct['batch_exp_date']);
							$freight_charge = $challanProduct['freight_charges'];	
					?>						
						
						<tr class="prtr">
							<td  style="border-right:2px solid black;border-top:2px solid black;" ><?php echo $i; ?></td>
							<td  style="border-right:2px solid black;border-top:2px solid black;"><b><?php echo $challanProduct['model_name']; ?></b> | <?php echo $challanProduct['pro_des']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanProduct['pro_hsn']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanProduct['pro_unit']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanProduct['qty']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo number_format((float)$challanProduct['rate'], 4, '.', ''); ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanProduct['batch_no']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $mgfDate->format('m-Y'); ?>/<?php echo $expDate->format('m-Y'); ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo number_format((float)$challanProduct['discount'], 4, '.', ''); ?></td>
							<td class="border_top" style="border-top:2px solid black;" align="right"><?php echo number_format((float)$challanProduct['net_total'], 2, '.', ''); ?></td>							
						</tr>
					
					<?php $i++; } ?>					
					<tr class="nettottr">
						<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" colspan="9" align="right" ><b>Net Total</b></td>
						<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="net_total"><?php echo number_format((float)$net_total, 2, '.', ''); ?></span></td>
					</tr>
					<tr class="ftr">
						<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" colspan="9" align="right" ><b>Freight Charges</b></td>
						<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; 
						<span id="freight_charge"><?php echo number_format((float)$freight_charge, 2, '.', ''); ?></span></td>
					</tr>
							<?php
								if($ordersInfo->currency == 'INR'){
								if($productgst){ 
								$totwithgst = 0;
								
								foreach($productgst as $progst){									
								$totwithgst = $totwithgst + $progst['gst_total_amount'];
							?>
						
							<tr>
								<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" colspan="9" align="right" ><b>GST @ <?php echo $progst['gst_rate']; ?>%</b></td>
								<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" align="right"> <i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <?php echo number_format((float)$progst['gst_total_amount'], 2, '.', ''); ?></td>
							</tr>
						<?php } ?>
						<?php } ?>
						<?php } ?>
						
					<tr class="grndtr">
						<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" colspan="9" align="right" ><b>Grand Total</b></td>
						<td class="border_right border_top" style="border-right:2px solid black;border-top:2px solid black;" align="right"> <b><i class="<?php echo $ordersInfo->currency_faclass; ?>" style="font-size:13px;"></i>&nbsp; <span id="grand_total"><?php echo number_format((float)($net_total + $freight_charge + $totwithgst), 2, '.', ''); ?></span></b></td>
					</tr>
				</table>
			</div>
			<div class="row" style="font-size:21px;margin-top:20px;">
				<div class="col-sm-12" style="padding-left: 0px;">
					<p style="margin: 0px;">Doc No. TE/F-7.5-07 For Tarun Enterprises | BANK AD CODE: <?php echo $bankInfo->bank_ad_code;  ?></p> 
					<p style="margin: 0px;">Prepared by <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?>|&nbsp;&nbsp;Packed by</p>
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