<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>

	<?php if (validation_errors()) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
			<?php echo validation_errors(); ?>
		</div>
	</div>
	<?php elseif (!empty($errorMsg)) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
				<?php echo $errorMsg; ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if (isset($error)) : ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php endif; ?>
	
	  <?php if(isset($success)){ ?>
	  <div class="col-md-12">
		<div class="alert alert-success">
		  <?php echo $success; ?>
		</div>
	</div>
	<?php } ?>

	<form role="form" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" class="needs-validation" novalidate>
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<input type="hidden" name="sli_id" value="<?php if($carrier->sli_id) { echo $carrier->sli_id; } ?>">
				<fieldset class="proinfo">
					<legend>Carrier Details</legend>
						<div class="row">
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Carrier Name</div>
								<input type="text" name="sli_name" value="<?php if(!empty($carrier->sli_name)){ echo $carrier->sli_name; } ?>"  id="sli_name" class="form-control" required>
								
							  </div>
							</div>
						
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Account Number</div>
								<input type="text" name="sli_account_number" value="<?php if(!empty($carrier->sli_account_number)){ echo $carrier->sli_account_number; } ?>"  id="sli_account_number" class="form-control" required>
								
							  </div>
							</div>
							<div class="col-sm-4"><br>
							  <button type="submit" id="addbatch" class="btn btn-primary float-right"> Save</button>
							</div>							
						</div>
												
				</div>
						
				</fieldset>
			</div>
			
		</div>
	</form>
	
	

</div>