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

	<div class="card mb-3">
		<div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></div>	
		</div>
		
		<div class="row">
			<div class="col-sm-12" style="font-size:25px;">
				<p>To</p>		
				<p style=" text-transform: uppercase;"><?php echo $recordInfo->bank_name; ?></p>		
				<p>ALLAHABAD-211001</p>		
				<p>SUBJECT: EXPORT DOCUMENT SUBMISSION</p>		
				<p>DEAR SIR,</p>		
				<p>GREETINGS!</p>		
				<p>WE ARE PLEASED TO INFORM YOU, WE HAVE COMPLETED A SHIPMENT OF OPHTHALMIC SUPPLIES TO OUR CUSTOMER, AND DETAILS ARE GIVEN BELOW.</p>	
			</div>
		</div>

		<div style="border: 2px solid black;display: flex;flex-wrap: wrap;margin-bottom:20px;height:100px;font-size:25px;">			
			<div  style='width:30%;float:left;border-right:2px solid black;padding-left:5px;'>
				<label ><b>PARTY</b></label>
			</div>
			<div style="width:70%;float:left;padding-left:5px;" >
				<label ><?php echo $recordInfo->company_name; ?></label>
			</div>			
		</div>
				
		<div style="border: 2px solid black;display: flex;flex-wrap: wrap;font-size:25px;">	

				<div style='width:30%;float:left;border-right:2px solid black;padding-left:5px;'>
					<label ><b>INVOICE</b></label>
				</div>
				<div style="width:70%;float:left;padding-left:5px;">
					<label ><?php echo $recordInfo->bill_no; ?></label>
				</div>	
				
				<div  style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
					<label ><b>PARTICULAR</b></label>
				</div>
				<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
					<label ></label>
				</div>	
				
				<div  style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
					<label ><b>AWB/SPEEDPOST</b></label>
				</div>
				<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
					<label ><?php echo $recordInfo->awb; ?></label>
				</div>	
				
				<div  style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
					<label ><b>SDF & BOE</b></label>
				</div>
				<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
					<label ><?php echo $recordInfo->boe_sdf; ?></label>
				</div>	
				
				<div  style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
					<label ><b>PAYMENT REF#</b></label>
				</div>
				<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
					<label ><?php echo $recordInfo->payment_ref_no; ?></label>
				</div>	
				
				<div  style='width:30%;float:left;border-right:2px solid black;border-top:2px solid black;padding-left:5px;'>
					<label ><b>FIRC</b></label>
				</div>
				<div  style='width:70%;float:left;border-top:2px solid black;padding-left:5px;'>
					<label ></label>
				</div>	
		</div>
		
		<div class="row" style="margin-top:30px;font-size:25px;">
			<div class="col-sm-12">
				<p>NOW WE ARE SUBMITTING HERE WITH THE COMPLETE OF DOCUMENTS FOR YOUR KIND REFERNCE. PLEASE ACKNOWLEDGE THE SAME AND CLOSE THE MENTIONED TRANSACTION.</p><br>	
				<p>THNAK YOU</p><br>	
				<p>TARUN JAGGI</p><br>	
			</div>
		</div>
		
	</div>
</div>