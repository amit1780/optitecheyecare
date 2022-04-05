<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
	</div>
	 <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>

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
<script>
$(document).ready(function() {						
	$("#packerForm").validate({
		rules: {
			full_name: "required"						
			//email: "required"										
		},
		messages: {			
			full_name: "Please Enter Full Name"			
			//email: "Please Enter Email"
		}
	})

	$('#submitForm').click(function() {
		$("#packerForm").valid();
	});
		
});
</script>
	<form role="form" method="POST" action="<?php echo site_url($form_action);?>" name="packerForm" id="packerForm" >
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<fieldset class="proinfo">
					<legend>Packer Information</legend>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">Full Name</div>								
								<input type="text" name="full_name" value="<?php if(!empty($packerInfo->packer_full_name)){ echo $packerInfo->packer_full_name; } ?>"  id="full_name" class="form-control" autocomplete="off" required>
							</div>
						</div>			
						
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Email</div>
								<input type="text" name="email" value="<?php if(!empty($packerInfo->packer_email)){ echo $packerInfo->packer_email; } ?>"  id="email" class="form-control" autocomplete="off" >
							</div>
						</div>					
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Mobile</div>
								<input type="text" name="mobile" value="<?php if(!empty($packerInfo->packer_mobile)){ echo $packerInfo->packer_mobile; } ?>"  id="mobile" class="form-control" autocomplete="off" >
							</div>
						</div>	
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Status</div>
								<select name="status" class="form-control" id="store_id">
									
									<option value="1" <?php if($packerInfo->packer_status == '1'){ echo "Selected='Selected'"; } ?> >Enable</option>
									<option value="0" <?php if($packerInfo->packer_status == '0'){ echo "Selected='Selected'"; } ?>>Disable</option>									
								</select>
							</div>
						</div>	
												
					</div>
				</fieldset>			
				
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<br>
							<button type="submit" id="submitForm" class="btn btn-primary float-right"> Save</button>	
						</div>
					</div>	
				</div>	
				
			</div>				
		</div>
	</form>	
</div>