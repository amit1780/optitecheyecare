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
		<!-- <div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
		</div> -->
		
		<div class="card-body" style="padding: 4.25rem;">
			
			<div class="row quote_view" style="font-size: 21px;">				
				
				<div class="col-sm-12  " style="border-right:0px solid black;border-bottom:2px solid black;padding: 20px;font-size: 35px;">
					<p style="text-align:center;">MARKS <?php echo $package_no; ?>/<?php echo $total; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  SHIPMENT OF <?php echo $total; ?> <?php if($total > 1){ echo "BOXES";  } else {echo "BOX";} ?> </p>
					<p>CONTAINS</p>
				</div>				
				
								
				<table class="" id="protable" width="100%" cellspacing="0" style="font-size: 21px;">
					<tr>
						<th align="center" style="text-align:center;width:10%;border-right:2px solid black;border-left:2px solid black;">S.N.</th>
						<th style="border-right:2px solid black;text-align:center;">Product Description</th>
						<th align="center" style="text-align:center;width:10%;border-right:2px solid black;">Qty</th>
						<th align="right" style="width:30%;border-right:2px solid black;text-align:center;">Batch Details</th>
													
					</tr>
					<?php $grandWeight=0; $i=1; foreach($getAddressSliPackages as $addressSliPackage) { 
							$grandWeight = $grandWeight + $addressSliPackage['weight'];
					?>
						<tr class="prtr">
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;border-left:2px solid black;border-bottom:2px solid black;" ><?php echo $i; ?></td>
							<td style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"><b><?php echo $addressSliPackage['model']; ?></b> | <?php echo $addressSliPackage['description']; ?></td>
							<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"><?php echo $addressSliPackage['qty']; ?></td>
							<td style="text-align:center;border-right:2px solid black;border-bottom:2px solid black;border-top:2px solid black;"><?php echo $addressSliPackage['batch']; ?><br><?php echo 'Mfg: '.$addressSliPackage['mfg_date'].', Exp: '.$addressSliPackage['exp_date'];  ?></td>														
						</tr>
					<?php $i++; } ?>
					
				</tr>
					
				</table>
				
				<div class="col-sm-12  " style="padding: 40px 20px 20px 20px;font-size: 30px;">
					<?php if($getaddressslip->address_type == 'B'){ ?>
					
						<p style="margin-bottom:0px;"><b>To,</b></p>
						<?php $billingAddress=nl2br($getOrderDetails->billing_details);
							while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
								print "<b>$matcher[1]</b>";
								$billingAddress=after($matcher[0],$billingAddress);
								break;
							}
						?>
						<?php echo $billingAddress; ?>
						
					<?php } else if($getaddressslip->address_type == 'S') { ?>
							<p style="margin-bottom:0px;"><b>To,</b></p>
							<?php $shipping_details=nl2br($getOrderDetails->shipping_details);
								while(preg_match("/(.*?)\n/is",$shipping_details,$matcher)){
									print "<b>$matcher[1]</b>";
									$shipping_details=after($matcher[0],$shipping_details);
									break;
								}
							?>
							<?php echo $shipping_details; ?>
					<?php } ?>					
					
					<?php if($customerInfo->gst){ ?>
					<p style="margin-bottom:0px;"><b>GST No.:</b> <?php echo $customerInfo->gst; ?></p>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<p style="margin-bottom:0px;"><b>Reg. No.:</b> <?php echo $customerInfo->company_registration_no; ?></p>
					<?php } ?>	
				</div>		
				
			</div>
			<!-- <div class="row" style="font-size:21px;margin-top:20px;">
				<div class="col-sm-12" style="padding-left: 0px;">
					<p style="margin: 0px;">Doc No. TE/F-7.5-07 For Tarun Enterprises | BANK AD CODE: <?php echo $bankInfo->bank_ad_code;  ?></p> 
					<p style="margin: 0px;">Prepared by <?php echo $challanInfo->firstname; ?>&nbsp;&nbsp;<?php echo $challanInfo->lastname; ?>|&nbsp;&nbsp;Packed by</p>
				</div>					
			</div> -->
			
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