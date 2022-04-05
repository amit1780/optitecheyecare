<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
	

	
	<div class="col-sm-4">	
		<div class="form-group">					
			<div class="control-label" ><b>DESCRIPTION OF GOODS</b></div> 
			<textarea name="description_good" class="form-control"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } ?></textarea>
		</div>							
	</div>	
	
	
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
	<?php } ?>	
</div>
<div class="row">
	<div class="col-sm-3">						  
		<div class="form-group">
			<div class="control-label" ><b>RoDTEP </b></div> 
			<!-- <label class="radio-inline"><input type="radio" name="rodtep" value="1" <?php if($sliDetailInfo->rodtep == 1) {  echo "checked"; } ?> > Yes</label>
			<label class="radio-inline"><input type="radio" name="rodtep" value="0" <?php if($sliDetailInfo->rodtep == 0) {  echo "checked"; } ?> > No</label> -->
			<input type="checkbox" name="rodtep" value="1" <?php if($sliDetailInfo->rodtep == "1"){ echo "checked"; } ?> >
		</div>
	</div>
</div>