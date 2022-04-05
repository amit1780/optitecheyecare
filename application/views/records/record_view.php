<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>
	</div>
</div>
<div class="container-fluid">	
	<div class="row proinfo" style='border:1px solid gray;margin: 0px;'>
		
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Customer Name:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'><b><?php echo $recordInfo->company_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4" style='border:0px solid red;'>
						<label class='float-left'>Financial Year:</label>
					</div>
					<div class="col-sm-8" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $recordInfo->financial_year; ?></b></label>
					</div>
				</div>
			</div>
			
			
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Bill No:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'><b><?php echo $recordInfo->bill_no; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4" style='border:0px solid red;'>
						<label class='float-left'>Bill Date:</label>
					</div>
					<div class="col-sm-8" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo date('d-m-Y',strtotime($recordInfo->bill_date)); ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4" style='border:0px solid red;'>
						<label class='float-left'>Bill Currency:</label>
					</div>
					<div class="col-sm-8" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $recordInfo->currency; ?></b></label>
					</div>
				</div>
			</div>

			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Bill Amount:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'><b><?php echo $recordInfo->bill_amount; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4" style='border:0px solid red;'>
						<label class='float-left'>Challan Id:</label>
					</div>
					<div class="col-sm-8" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo str_pad($recordInfo->challan_id, 6, "C00000", STR_PAD_LEFT); ?></b></label>
					</div>
				</div>
			</div>

			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Challan Date:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'><b><?php echo dateFormat('d-m-Y',$recordInfo->challan_date); ?></b></label>
					</div>
				</div>
			</div>
			
			
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Payment Bank:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'><b><?php echo $recordInfo->bank_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Payment Ref. No:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'>
							<b><?php echo $recordInfo->payment_ref_no; ?></b>
						</label>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>AWB:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'>
							<b><?php echo $recordInfo->awb; ?></b>
						</label>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>AWB Date:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'>
							<b><?php echo dateFormat('d-m-Y',$recordInfo->awb_date); ?></b>
						</label>
					</div>
				</div>
			</div>
			
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Method of Shipment:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'>
							<b><?php echo $recordInfo->method_of_shipment; ?></b>
						</label>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>BOE / SDF / SB:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'>
							<b><?php echo $recordInfo->boe_sdf; ?></b>
						</label>
					</div>
				</div>
			</div>
			
						
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-4">
						<label class='float-left'>Bank Sub. Date:</label>
					</div>
					<div class="col-sm-8">
						<label class='float-left'>
							<b><?php echo dateFormat('d-m-Y',$recordInfo->bank_sub_date); ?></b>
						</label>
					</div>
				</div>
			</div>
			
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Note:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'>
							<b><?php echo $recordInfo->note; ?></b>
						</label>
					</div>
				</div>
			</div>	
	</div>
</div>