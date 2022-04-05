<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<?php //echo $this->breadcrumbs->show(); ?>	
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
	$("#changePasswordForm").validate({
		rules: {
			new_pass: "required",					
			confirm_pass: {
				required: true,
				equalTo: '#new_pass'
			}					
								
		},
		messages: {
			new_pass: "Please Enter New Password",
			confirm_pass: "Please Enter Same new Password"
		}
	})

	$('#submitForm').click(function() {
		$("#changePasswordForm").valid();
	});
});
</script>
	<form role="form" method="post" action="<?php echo site_url('changePassword');?>" id="changePasswordForm" >
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<fieldset class="proinfo">
					<legend>Change Password</legend>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<div class="control-label">New Password</div>								
								<input type="password" name="new_pass" value=""  id="new_pass" class="form-control" autocomplete="off" required>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<div class="control-label">Confirm Password</div>
								<input type="password" name="confirm_pass" value=""  id="confirm_pass" class="form-control" autocomplete="off" required>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<br>
								<button type="submit" id="submitForm" class="btn btn-primary float-right"> Change Password</button>	
							</div>
						</div>							
					</div>
				</fieldset>
			</div>				
		</div>
	</form>	
</div>