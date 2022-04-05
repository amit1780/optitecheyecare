<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">		
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>		
	</div>
	
<fieldset class="proinfo">
	<legend>Product Information</legend>
	<div class="row" style='border:1px solid gray;'>
								
		<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>Product Name:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'><b><?php echo $product_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>Model:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $model; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>Category:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'><b><?php echo $category_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>HSN:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $hsn; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>MRP:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $mrp; ?></b></label>
					</div>
				</div>
			</div>

			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>GST %:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'><b><?php echo $gst; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>Cost Price:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $cost_price; ?></b></label>
					</div>
				</div>
			</div>

			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>Pack Unit:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'><b><?php echo $pack_unit; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Description:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'><b><?php echo $description; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>IFU:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'>
							<?php if(!empty($photo)){ ?>
								<a href="<?php echo $photo; ?>"  target='_blank'>View</a>
							<?php }else{
								echo "<b>Not uploaded</b>";
							} ?>
						</label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>Product PDF:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'>
							<?php if(!empty($product_pdf)){ ?>
								<a href="<?php echo $product_pdf; ?>" target='_blank'>View</a>
							<?php }else{
								echo "<b>Not uploaded</b>";
							} ?>
						</label>
					</div>
				</div>
			</div>
</fieldset>
</br>
<fieldset class="proinfo">
	<legend>Price</legend>
	<div class="row" style='border:1px solid gray;'>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>INR:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $price_inr; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>USD:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $price_usd; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>EUR:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $price_eur; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>GBP:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $price_gbp; ?></b></label>
				</div>
			</div>
		</div>
	</div>

</fieldset>
</br>

<fieldset class="proinfo">
	<legend>Minimum Price</legend>
	<div class="row" style='border:1px solid gray;'>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>INR:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $min_price_inr; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>USD:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $min_price_usd; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>EUR:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $min_price_eur; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>GBP:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $min_price_gbp; ?></b></label>
				</div>
			</div>
		</div>
	</div>

</fieldset>

<fieldset class="proinfo">
	<legend>Certificate</legend>
	<div class="row" style='border:1px solid gray;'>
		<div class="col-sm-12" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-2" style='border-right:2px solid gray;'>
					<label class='float-left'>Certificate:</label>
				</div>
				<div class="col-sm-8" style='border:0px solid red;'>
					<label class='float-left'><?php echo implode(' | ', $certificates); ?></label>
				</div>
			</div>
		</div>
		
	</div>

</fieldset>

</br>	

	<div class="col-sm-12 mt-5"> </div>

<div>