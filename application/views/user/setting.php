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

	
	<?php if (isset($error)) : ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php endif; ?> 
<script>
$(document).ready(function() {						
	$("#settingForm").validate({
		rules: {
			config_exp_before: "required",								
		},
		messages: {			
			config_exp_before: "Please Enter Expiry Before Value",
		}
	})

	$('#submitForm').click(function() {
		$("#changePasswordForm").valid();
	});
	
});
</script>
	<form role="form" method="POST" action="<?php echo site_url($form_action);?>" name="settingForm" id="settingForm" >
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<fieldset class="proinfo">
					<legend>Setting</legend>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Expiry Before (Month)</div>								
								<!-- <input type="text" name="config_exp_before" value="<?php echo $Config_data->value; ?>"  id="config_exp_before" class="form-control" autocomplete="off" required> -->
								<Select name="config_exp_before" id="config_exp_before" class="form-control" required>
									<?php for($i=0; $i<=6; $i++){ ?>
										<option value="<?php echo $i; ?>" <?php if($Config_data->value == $i) { echo ' selected="selected"'; } ?> ><?php echo $i; ?></option>
									<?php } ?>
								<Select>
							</div>
						</div>												
					</div>
				</fieldset>
				<br>
				
				
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
<script>
$(document).ready(function() {
	var user_id	 = '<?php echo $user_id; ?>';
	var group_id	 = '<?php echo $userInfo->group_id; ?>';
	
	if(user_id && (group_id == 3)){
		$("#store").show();
	} else {
		$("#store").hide();
	}
	
	$("#group_id").change(function() {
		var val = this.value;
		if(val == 3){
			$("#store").show();
		} else {
			$("#store").hide();
		}			
	});
});
</script>