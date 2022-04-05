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
		p{margin-bottom:0px;}
	</style>
	
	<div class="card mb-3" id="printableArea">
		<!-- <div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
		</div> -->
		
		<div class="card-body" style="padding-left: 45%;padding-top: 15%;">
			<!-- <h3 style="text-align:center;">Package and Shipment Details (<?php echo $package_no; ?>)</span></h3> -->
			<div class="row quote_view">				
				
				<div class="col-sm-12  " style="font-size: 26px;line-height:1.2;">
					<p ><b>SHIPMENT  <span style="float:right;">CASE: <?php echo $package_no; ?>/<?php echo $total; ?></span></b><br>
					<b>CHALLAN: <?php echo getChallanNo($challan_id) ?></b><br>
					<b>MADE IN INDIA</b></p><br>
				
				
					<?php if($getaddressslip->address_type == 'B'){ ?>
					
						<p ><b>To,</b></p>
						<?php $billingAddress=nl2br($getOrderDetails->billing_details);
							while(preg_match("/(.*?)\n/is",$billingAddress,$matcher)){
								print "<b>$matcher[1]</b>";
								$billingAddress=after($matcher[0],$billingAddress);
								break;
							}
						?>
						<?php echo $billingAddress; ?>
						
					<?php } else if($getaddressslip->address_type == 'S') { ?>
							<p><b>To,</b></p>
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
					<p ><b>GST No.:</b> <?php echo $customerInfo->gst; ?></p>
					<?php } ?>
					<?php if($customerInfo->company_registration_no){ ?>
					<p ><b>Reg. No.:</b> <?php echo $customerInfo->company_registration_no; ?></p>
					<?php } ?>	
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