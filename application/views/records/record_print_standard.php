<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Bootstrap core CSS-->
<link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Page level plugin CSS-->

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>

<!-- Custom styles for this template-->
<link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

<div class="container-fluid">
	<style>
		.card{border:0px solid rgba(0,0,0,.125) !important;}
	</style>

	<div class="card mb-3" style="font-size:18px;">
		<div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
		</div>
		
		<div class="row">
			<div class="col-sm-12" >
				<p>To</p>		
				<p style=" text-transform: uppercase;"><?php echo $recordInfo->bank_name; ?></p>		
				<p>ALLAHABAD-211001</p>		
				<p>SUBJECT: EXPORT DOCUMENT SUBMISSION</p>		
				<p>DEAR SIR,</p>		
				<p>GREETINGS!</p>		
				<p>WE ARE PLEASED TO INFORM YOU, WE HAVE COMPLETED A SHIPMENT OF OPHTHALMIC SUPPLIES TO OUR CUSTOMER, AND DETAILS ARE GIVEN BELOW.</p>	
			</div>
		</div>
	
		<div style="border: 2px solid black;display: flex;flex-wrap: wrap;">
			<div style="width:30%;border-right:2px solid black;float:left;padding-left:5px;">				
				<label><b>S.NO</b></label>
			</div>
			<div style="width:70%;float:left;padding:3px;padding-left:5px;">
				<label>&nbsp;</label>
			</div>
			
			<div  style="width:30%;float:left;border-top:2px solid black;border-right:2px solid black;padding-left:5px;">
				<label class='float-left'><b>INV NO</b></label>
			</div>
			
			<div style='width:70%;float:left;border-top:2px solid black;float:left;padding-left:5px;'>
				<label><?php echo $recordInfo->bill_no; ?></label>
			</div>	
			
				
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>INV DATE</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label><?php echo dateFormat('d-m-Y',$recordInfo->bill_date); ?></label>
			</div>
				
				
				
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>GOODS DES</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label>OPTHALMIC GOODS</label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>CURRENCY</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'><?php echo $recordInfo->currency; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>CLIENT NAME</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label><?php echo $recordInfo->company_name; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Inward Reference No. / Payment ref.</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label><?php echo $recordInfo->payment_ref_no; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Inward remittance date</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label ></label>
			</div>
			
			<div  style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>Inward remittance amount</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Shipping Bill No. / SDF / BOE</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'><?php echo $recordInfo->boe_sdf; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Shipping Bill Date</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'><?php echo dateFormat('d-m-Y',$recordInfo->bill_date); ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>Shipping Bill Amount(FCY)</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'><?php echo $recordInfo->bill_amount; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>Shipping Bill Amt. FOP(INR)</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Insurance/Freight/Commission</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>IFC Code</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>Port Code</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>AD Code</b></label>
			</div>
			<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label class='float-left'></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>Buyer name</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label ><?php echo $recordInfo->company_name; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Buyer Address with country</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label ></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label><b>Remitter name</b></label>
			</div>
			<div style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label ><?php echo $recordInfo->company_name; ?></label>
			</div>
			
			<div style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
				<label ><b>Remitter Address with country</b></label>
			</div>
			<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
				<label></label>
			</div>
		</div>
		
		<div class="row" style="margin-top:30px;font-size:18px;">
			<div class="col-sm-12">
				<p>NOW WE ARE SUBMITTING HERE WITH THE COMPLETE OF DOCUMENTS FOR YOUR KIND REFERNCE. PLEASE ACKNOWLEDGE THE SAME AND CLOSE THE MENTIONED TRANSACTION.</p><br>	
				<p>THNAK YOU</p><br>	
				<p>TARUN JAGGI</p><br>	
			</div>
		</div>
		
	</div>
</div>