<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<?php echo $this->breadcrumbs->show(); ?>

<style>
input{border: 1px solid gray;}	
textarea{border: 1px solid gray;}	
</style>	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">				
				<h1 >Create Sli</h1> <?php echo $this->breadcrumbs->show(); ?>	
			</div>
			<!-- <div class="col-sm-6">
				<div class="float-right">
					<a href="<?php //echo site_url('challan'); ?>?order_id=<?php //echo $ordersInfo->order_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Create Challan"><i class="fas fa-plus"></i></a> &nbsp;					
				</div>
			</div> -->			
		</div>
	</div>
	
	<?php if(isset($success)){ ?>
		<div class="alert alert-success">
		  <?php echo $success; ?>
		</div>
	<?php } ?>
	
	<?php if(isset($error)){ ?>
		<div class="alert alert-danger">
		  <?php echo $error; ?>
		</div>
	<?php } ?>

	<form role="form" class="needs-validation"  method="get" action="<?php echo site_url('createSli');?>" >
		<input type="hidden" name="challan_id" value="<?php echo $challan_id; ?>">
		<div class="row">
			<div class="col-sm-12">			
				<div class="row" >				
					<div class="col-sm-3">						  
					  <div class="form-group">
						<div class="control-label" >Select SLI</div> 
						<select name="sli_id" id="sli_id" class="form-control">
							<option value="0">--Select--</option>
							<?php foreach($sli as $sl){ ?>
								<option value="<?php echo $sl['sli_id'] ?>" <?php if (isset($sl['sli_id']) && $sl['sli_id'] == $sli_id) { echo ' selected="selected"'; } ?>><?php echo $sl['sli_name'] ?></option>
							<?php } ?>
						</select>
					  </div>
					</div>										
				</div>			
			</div>
		</div>			
	</form>
	
	<?php if(!empty($sli_id)){ ?>
	
	<span>Consignee Name: <b><?php echo $ordersInfo->customer_name; ?></b></span> &nbsp;&nbsp;|&nbsp;&nbsp; <span>Invoice No.: <b><?php echo $challanInfo->invoice_no; ?></b></span>
	<div style="border:1px solid gray;padding:10px;">
		<form role="form" class="needs-validation"  method="post" action="<?php echo site_url('createSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" >
			<input type="hidden" name="challan_id" value="<?php echo $challan_id; ?>">
			<input type="hidden" name="sli_id" value="<?php echo $sli_id; ?>">
			<?php if($sliDetailInfo->sli_detail_id) { ?>
				<input type="hidden" name="sli_detail_id" value="<?php if($sliDetailInfo->sli_detail_id) { echo $sliDetailInfo->sli_detail_id; } ?>">
			<?php } ?>
				<div class="row">
				<?php if($sli_id == 1){ ?>
					<div class="col-sm-6">						  
					  <div class="form-group">
						<div class="control-label" ><b>IGSTIN Payment Status</b></div> 
							<input type="radio" name="igstin_pay_status" value="A" <?php if($sliDetailInfo->igstin_pay_status == 'A') { echo "checked"; } ?>>&nbsp; A) Not Appicable &nbsp;
							<input type="radio" name="igstin_pay_status" value="B" <?php if($sliDetailInfo->igstin_pay_status == 'B') { echo "checked"; } ?>>&nbsp; B) LUT - export under bound &nbsp;
							<input type="radio" name="igstin_pay_status" value="C" <?php if($sliDetailInfo->igstin_pay_status == 'C') { echo "checked"; } ?>>&nbsp; C) LUT - export under bound &nbsp;
					  </div>
					</div>
					<div class="col-sm-6">						  
					  <div class="form-group">
						<div class="control-label" ><b>If B, Undertaking of Bound provided ?</b></div> 
							<input type="radio" name="if_b" value="Yes" <?php if($sliDetailInfo->if_b == 'Yes') { echo "checked"; } ?>>&nbsp; Yes
							<input type="radio" name="if_b" value="No" <?php if($sliDetailInfo->if_b == 'No') { echo "checked"; } ?>>&nbsp; No &nbsp;&nbsp;
							If C, mention the taxable & IGST Amount : <input type="text" name="igst_amount" value="<?php if($sliDetailInfo->igst_amount) { echo $sliDetailInfo->igst_amount; } ?>"> 
					  </div>
					</div>
				<?php } ?>	
					<?php
						$freight_charges = $challan_total->freight_charges;
						$net_total = $challan_total->net_total;	
					?>
					<div class="col-sm-4">						  
						<div class="form-group">
							<div class="control-label" ><b>Incoterms</b></div> 
								<input type="radio" name="incoterms" value="FOB" <?php if($frec == 1 && $sliDetailInfo->incoterms == ''){ echo "checked"; } elseif($sliDetailInfo->incoterms == 'FOB') { echo "checked"; } ?>>&nbsp; FOB &nbsp;
								<input type="radio" name="incoterms" value="C & F" <?php if($frec_cost == 1 && $sliDetailInfo->incoterms == ''){ echo "checked"; } elseif($sliDetailInfo->incoterms == 'C & F') { echo "checked"; } ?>>&nbsp; C & F &nbsp;
								<?php if($sli_id == 1){ ?>
								<input type="radio" name="incoterms" value="C & I" <?php if($sliDetailInfo->incoterms == 'C & I') { echo "checked"; } ?>>&nbsp; C & I &nbsp;
								<?php } ?>
								<input type="radio" name="incoterms" value="CIF" <?php if($sliDetailInfo->incoterms == 'CIF') { echo "checked"; } ?>>&nbsp; CIF &nbsp;
						</div>
					</div>
					
					<?php if($sli_id == 1){ ?>
					<div class="col-sm-4">						  
					  <div class="form-group">
						<div class="control-label" ><b>NON DUTY DRAWBACK</b></div> 
							<input type="radio" name="nob_duty_drawback" value="1" <?php if($sliDetailInfo->nob_duty_drawback == '1') { echo "checked"; } ?>>&nbsp; Yes &nbsp;
							<input type="radio" name="nob_duty_drawback" value="0" <?php if($sliDetailInfo->nob_duty_drawback == '0') { echo "checked"; } ?>>&nbsp; No							
					  </div>
					</div>
					<?php } ?>
					
					<?php if($sli_id == 2){ ?>
					<div class="col-sm-3">						  
					  <div class="form-group">
						<div class="control-label" ><b>EIN No.</b></div> 
							<input type="text" name="ein_no" value="<?php if($sliDetailInfo->ein_no) { echo $sliDetailInfo->ein_no; } ?>">
					  </div>
					</div>
					<?php } ?>
				</div>
				<div class="row">
				
					<?php if($sli_id == 1){ ?>
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>Nature of payment</b></div> 
							<input type="text" name="nature_of_payment" value="<?php if($sliDetailInfo->nature_of_payment) { echo $sliDetailInfo->nature_of_payment; } ?>">
					  </div>
					</div>
					
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>FOB Value</b></div> 
							<input type="text" name="fob_value" value="<?php if($sliDetailInfo->fob_value) { echo $sliDetailInfo->fob_value; } ?>">
					  </div>
					</div>					
					
					<?php } ?>
					
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>No. Of PKGS</b></div> 
							<input type="text" name="no_of_pkgs" value="<?php if($sliDetailInfo->no_of_pkgs) { echo $sliDetailInfo->no_of_pkgs; } ?>">
					  </div>
					</div>
					
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>NET WT</b></div> 
							<input type="text" name="net_wt" value="<?php if($sliDetailInfo->net_wt) { echo $sliDetailInfo->net_wt; } ?>">
					  </div>
					</div>
					
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>GROSS WT</b></div> 
							<input type="text" name="gross_wt" value="<?php if($sliDetailInfo->gross_wt) { echo $sliDetailInfo->gross_wt; } ?>">
					  </div>
					</div>
					
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>Volume WT</b></div> 
							<input type="text" name="volume_wt" value="<?php if($sliDetailInfo->volume_wt) { echo $sliDetailInfo->volume_wt; } ?>">
					  </div>
					</div>
					
					<div class="col-sm-2">						  
					  <div class="form-group">
						<div class="control-label" ><b>Dimension ( L x B x H)</b></div> 
							<textarea name="lbh" class="form-control"><?php if($sliDetailInfo->lbh) { echo $sliDetailInfo->lbh; } ?></textarea>
					  </div>
					</div>
					<?php if($sli_id == 1){ ?>
					<div class="col-sm-6">	
						<div class="form-group">					
							<div class="control-label" ><b>Special Instruction, If any</b></div> 
							<textarea name="special_instruction" class="form-control" ><?php if($challanInfo->special_instruction){ echo $challanInfo->special_instruction; } ?></textarea>
						</div>							
					</div>	
					<?php } ?>
					<?php if($sli_id == 2){ ?>
						<div class="col-sm-2">						  
						  <div class="form-group">
							<div class="control-label" ><b>MARKS AND NUMBERS</b></div> 
								<input type="text" name="marks_and_number" value="<?php if($sliDetailInfo->marks_and_number) { echo $sliDetailInfo->marks_and_number; } ?>">
						  </div>
						</div>
					<?php } ?>
				
					<?php if($sli_id == 2){ ?>
						<div class="col-sm-12">						  
							  <div class="form-group">					
									<div class="control-label" ><b>TYPE OF SHIPPING BILL (tick one)</b></div> 
							  </div>
						</div>
						<div class="col-sm-4">						 
							<input type="radio" name="ship_bill_tick" value="1" <?php if($sliDetailInfo->ship_bill_tick == 1) {  echo "checked"; } ?>>&nbsp; Duty Drawback <br>
							<input type="radio" name="ship_bill_tick" value="2" <?php if($sliDetailInfo->ship_bill_tick == 2) {  echo "checked"; } ?>>&nbsp; Non-Drawback <br>
							<input type="radio" name="ship_bill_tick" value="7" <?php if($sliDetailInfo->ship_bill_tick == 7) {  echo "checked"; } ?>>&nbsp; NFEI <br>
							<input type="radio" name="ship_bill_tick" value="9" <?php if($sliDetailInfo->ship_bill_tick == 9) {  echo "checked"; } ?>>&nbsp; Jobbing <br>
							<input type="radio" name="ship_bill_tick" value="10" <?php if($sliDetailInfo->ship_bill_tick == 10) {  echo "checked"; } ?>>&nbsp; Repair Return <br>
							<!-- <input type="radio" name="ship_bill_tick" value="3" <?php if($sliDetailInfo->ship_bill_tick == 3) {  echo "checked"; } ?>>&nbsp; DEPB <br>
							<input type="radio" name="ship_bill_tick" value="4" <?php if($sliDetailInfo->ship_bill_tick == 4) {  echo "checked"; } ?>>&nbsp; DEEC --> <br>												
						</div>						
						<!-- <div class="col-sm-4">						
							<input type="radio" name="ship_bill_tick" value="5" <?php if($sliDetailInfo->ship_bill_tick == 5) {  echo "checked"; } ?>>&nbsp; EPCG <br>
							<input type="radio" name="ship_bill_tick" value="6" <?php if($sliDetailInfo->ship_bill_tick == 6) {  echo "checked"; } ?>>&nbsp; DFRC <br>
							<input type="radio" name="ship_bill_tick" value="8" <?php if($sliDetailInfo->ship_bill_tick == 8) {  echo "checked"; } ?>>&nbsp; RE-EXPORT <br>							
						</div> -->
					<?php } ?>
					<div class="col-sm-4">	
						<div class="form-group">					
							<div class="control-label" ><b>DESCRIPTION OF GOODS</b></div> 
							<textarea name="description_good" class="form-control"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } ?></textarea>
						</div>							
					</div>	
					
					<?php if($sli_id == 2){ ?>
						<div class="col-sm-4">	
							<div class="form-group required">					
								<div class="control-label" ><b>Destination Country</b></div> 
								<select name="country_id" id="country_id" class="form-control" >
									<option value="">-- Seclect --</option>
									<?php foreach($countries as $country){ ?>
										<?php $country_id = $sliDetailInfo->destination_country; ?>
										<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; }  ?> ><?php echo $country['name']; ?></option>										
									<?php } ?>
								</select>
							</div>							
						</div>
					<?php } ?>
				</div>
				
				<div class="row">
					<div class="col-sm-12">						  
					  <div class="form-group">					
							<div class="control-label" ><b>DOCUMENTS</b></div> 
					  </div>
					</div>
					<?php if($sli_id == 1){ ?>
						<div class="col-sm-4">						  
							<div class="form-group">
								<?php  for($i=0; $i<=5; $i++){ ?>									
									<input type="checkbox" name="dhl_doc[]" value="<?php echo $sliDocLabel[$i]['label_id']; ?>" <?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "checked"; } ?>  >&nbsp; <?php echo $sliDocLabel[$i]['doc_label']; ?> <br>
								<?php } ?>
							</div>
						</div>
						
						<div class="col-sm-4">						  
							<div class="form-group">					
								<?php  for($i=6; $i<=11; $i++){ ?>									
									<input type="checkbox" name="dhl_doc[]" value="<?php echo $sliDocLabel[$i]['label_id']; ?>" <?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "checked"; } ?>  >&nbsp; <?php echo $sliDocLabel[$i]['doc_label']; ?> <br>
								<?php } ?>
							</div>
						</div>
						
						<div class="col-sm-4">						  
							<div class="form-group">					
								<?php  for($i=12; $i<=17; $i++){ ?>									
									<input type="checkbox" name="dhl_doc[]" value="<?php echo $sliDocLabel[$i]['label_id']; ?>" <?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "checked"; } ?>  >&nbsp; <?php echo $sliDocLabel[$i]['doc_label']; ?> <br>
								<?php } ?>								
							</div>
						</div>
					<?php } else if($sli_id == 2){ ?>
						<div class="col-sm-4">						  
							<div class="form-group">					
								<?php  for($i=0; $i<=6; $i++){ ?>									
									<input type="checkbox" name="fedex_doc[]" value="<?php echo $sliDocLabel[$i]['label_id']; ?>" <?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "checked"; } ?>  >&nbsp; <?php echo $sliDocLabel[$i]['doc_label']; ?> <br>
								<?php } ?> 
							</div>
						</div>
						
						<div class="col-sm-4">						  
							<div class="form-group">					
								
								<?php  for($i=7; $i<=8; $i++){ ?>									
									<input type="checkbox" name="fedex_doc[]" value="<?php echo $sliDocLabel[$i]['label_id']; ?>" <?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "checked"; } ?>  >&nbsp; <?php echo $sliDocLabel[$i]['doc_label']; ?> <br>
								<?php } ?>
							</div>
						</div>
						
						<!-- <div class="col-sm-4">						  
							<div class="form-group">							
								<?php  for($i=14; $i<=15; $i++){ ?>									
									<input type="checkbox" name="fedex_doc[]" value="<?php echo $sliDocLabel[$i]['label_id']; ?>" <?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "checked"; } ?>  >&nbsp; <?php echo $sliDocLabel[$i]['doc_label']; ?> <br>
								<?php } ?>
							</div>
						</div> -->
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-sm-12">	
						<a target="_blank" href="<?php echo site_url('printSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" class="btn btn-primary float-right" style="margin-left:10px;">Print Sli</a>
						<button type="submit" class="btn btn-primary float-right" style="margin-left:10px;">Save</button>																	  
					</div>	
				</div>	
		</form>
	</div>
	<?php } ?>	
</div>

<script>
$(document).ready(function() {
	 $('#sli_id').change(function() {
        this.form.submit();
    });
});
</script>