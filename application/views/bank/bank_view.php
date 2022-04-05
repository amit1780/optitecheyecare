<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">		
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>		
	</div>
<fieldset class="proinfo">
	<legend>Bank Information</legend>
	<div class="row" style='border:1px solid gray;'>			
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>Bank Name:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'><b><?php echo $bank->bank_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4" style='border:0px solid red;'>
						<label class='float-left'>Beneficiary Name:</label>
					</div>
					<div class="col-sm-8" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $bank->beneficiary_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>Swift Code:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $bank->swift_code; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>IFSC Code:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $bank->ifsc_code; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Bank ad Code:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'><b><?php echo $bank->bank_ad_code; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Bank Address:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'><b><?php echo $bank->bank_address; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Account No:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'><b><?php echo $bank->account_number; ?></b></label>
					</div>
				</div>
			</div>


		
</fieldset>



	<div class="col-sm-12 mt-5"> </div>

<div></br>