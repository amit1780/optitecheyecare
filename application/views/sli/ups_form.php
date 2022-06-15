<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
	
	<?php
		$freight_charges = $challan_total->freight_charges;
		$net_total = $challan_total->net_total;	
	?>
	
	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>UPS A/C</b></div> 
			<input type="text" name="post_contact_person" value="<?php if($sliDetailInfo->post_contact_person){ echo $sliDetailInfo->post_contact_person; } else { echo "SHIPPER"; } ?>"> 
	  </div></br>
	  <div class="form-group">
		<div class="control-label" ><b>UPS A/C : 32200V</b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "CONSIGNEE"; } ?>">
	  </div>
	</div>

	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>INV NO.</b></div> 
			<input type="text" name="post_contact_person" value="<?php if($sliDetailInfo->post_contact_person){ echo $sliDetailInfo->post_contact_person; } else { echo "SHIPPER"; } ?>"> 
	  </div></br>
	  <div class="form-group">
		<div class="control-label" ><b>DATE</b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "CONSIGNEE"; } ?>">
	  </div>
	</div>

	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>IEC NO.</b></div> 
			<input type="text" name="post_contact_person" value="<?php if($sliDetailInfo->post_contact_person){ echo $sliDetailInfo->post_contact_person; } else { echo "SHIPPER"; } ?>"> 
	  </div></br>
	  <div class="form-group">
		<div class="control-label" ><b>GSTN ID</b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "CONSIGNEE"; } ?>">
	  </div>
	</div>	
</div>
<div class="row">
	
	<?php
		$freight_charges = $challan_total->freight_charges;
		$net_total = $challan_total->net_total;	
	?>
	
	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>SHIPPER</b></div> 
			<input type="text" name="post_contact_person" value="<?php if($sliDetailInfo->post_contact_person){ echo $sliDetailInfo->post_contact_person; } else { echo "M/S. TARUN ENTERPRISES"; } ?>"> 
	  </div></br>
	  <div class="form-group">
		<div class="control-label" ><b>PHONE NO.</b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "91 532 3290204"; } ?>">
	  </div>
	  <div class="form-group">
		<div class="control-label" ><b>NAME</b></div> 
			<input type="text" name="post_contact_person" value="<?php if($sliDetailInfo->post_contact_person){ echo $sliDetailInfo->post_contact_person; } else { echo "Mr. Tarun Jaggi"; } ?>"> 
	  </div></br>
	  <div class="form-group">
		<div class="control-label" ><b>ADDRESS</b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "8/8 STRACHY ROAD,ALLAHABAD 211 001, U.P, INDIA"; } ?>">
	  </div>
	  <div class="form-group">
		<div class="control-label" ><b>Contact person name & Cell no.</b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "Mr Ratnesh Shukla 9807777732"; } ?>">
	  </div>
	</div>

	<div class="col-sm-4">						  
		<div class="form-group">
			<div class="control-label" ><b>Contract Type</b></div> 
				<input type="radio" name="incoterms" value="FOB" <?php if($frec == 1 && $sliDetailInfo->incoterms == ''){ echo "checked"; } elseif($sliDetailInfo->incoterms == 'FOB') { echo "checked"; } ?>>&nbsp; FOB &nbsp;
				<input type="radio" name="incoterms" value="C & F" <?php if($frec_cost == 1 && $sliDetailInfo->incoterms == ''){ echo "checked"; } elseif($sliDetailInfo->incoterms == 'C & F') { echo "checked"; } ?>>&nbsp; C & F &nbsp;
				<?php if($sli_id == 1){ ?>
				<input type="radio" name="incoterms" value="C & I" <?php if($sliDetailInfo->incoterms == 'C & I') { echo "checked"; } ?>>&nbsp; C & I &nbsp;
				<?php } ?>
				<input type="radio" name="incoterms" value="CIF" <?php if($sliDetailInfo->incoterms == 'CIF') { echo "checked"; } ?>>&nbsp; CIF &nbsp;
		</div>	  
	</div>

	<div class="col-sm-4">						  
		<div class="form-group">
			<div class="control-label" ><b>Currency</b></div> 
				<input type="radio" name="incoterms" value="Euro" <?php if($frec == 1 && $sliDetailInfo->incoterms == ''){ echo "checked"; } elseif($sliDetailInfo->incoterms == 'FOB') { echo "checked"; } ?>>&nbsp; Euro &nbsp;
				<input type="radio" name="incoterms" value="INR" <?php if($frec_cost == 1 && $sliDetailInfo->incoterms == ''){ echo "checked"; } elseif($sliDetailInfo->incoterms == 'C & F') { echo "checked"; } ?>>&nbsp; INR &nbsp;
				
		</div>	  
	</div>


</div>






<div class="row">

		
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

	
		<div class="col-sm-2">						  
		  <div class="form-group">
			<div class="control-label" ><b>MARKS AND NUMBERS</b></div> 
				<input type="text" name="marks_and_number" value="<?php if($sliDetailInfo->marks_and_number) { echo $sliDetailInfo->marks_and_number; } ?>">
		  </div>
		</div>
	

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
	
	<div class="col-sm-4">	
		<div class="form-group">					
			<div class="control-label" ><b>DESCRIPTION OF GOODS</b></div> 
			<textarea name="description_good" class="form-control"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } ?></textarea>
		</div>							
	</div>	
	
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
	
	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>Tel No</b></div> 
			<input type="text" name="tel_number" value="<?php if($customer_info->mobile) { echo $customer_info->mobile; } ?>">
	  </div>
	</div>
	
	<div class="col-sm-6">						  
	  <div class="form-group">
		<div class="control-label" ><b>Email ID</b></div> 
			<input type="text" name="email_id" value="<?php if($customer_info->email) { echo $customer_info->email; } ?>">
	  </div>
	</div>
	
</div>

<div class="row">
	<div class="col-sm-12">						  
	  <div class="form-group">					
			<div class="control-label" ><b>DOCUMENTS</b></div> 
	  </div>
	</div>
	
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
	
</div>

<div class="row">
	<div class="col-sm-12">						  
	  <div class="form-group">					
			<div class="control-label" ><b>Post Shipping Information</b></div> 
	  </div>
	</div>
	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>Contact person </b></div> 
			<input type="text" name="post_contact_person" value="<?php if($sliDetailInfo->post_contact_person){ echo $sliDetailInfo->post_contact_person; } else { echo "Ms. Neelam"; } ?>"> 
	  </div>
	</div>
	<div class="col-sm-4">						  
	  <div class="form-group">
		<div class="control-label" ><b>Telephone / Mobile </b></div> 
			<input type="text" name="post_mobile" value="<?php if($sliDetailInfo->post_mobile){ echo $sliDetailInfo->post_mobile; } else { echo "+91 8176080204"; } ?>">
	  </div>
	</div>
</div>

