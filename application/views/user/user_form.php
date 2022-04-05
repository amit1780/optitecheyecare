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
	$("#userForm").validate({
		rules: {
			firstname: "required",					
			//lastname: "required",					
			email: "required",					
			//username: "required",
			username: {
			  required: true,
			  minlength: 4
			},			
			group_id: "required",
			store_id: "required",
			new_pass: "required",					
			confirm_pass: {
				required: true,
				equalTo: '#new_pass'
			}									
		},
		messages: {			
			firstname: "Please Enter First Name",
			//lastname: "Please Enter Last Name",
			email: "Please Enter Email",
			username: {
				required: "Please Enter username",
				minlength: "Enter at least 4 characters"
			},			
			group_id: "Please Select Group",
			store_id: "Please Select Store",
			new_pass: "Please Enter New Password",
			confirm_pass: "Please Enter Same new Password"
		}
	})

	$('#submitForm').click(function() {
		$("#changePasswordForm").valid();
	});
	
	var user_id = '<?php echo $user_id; ?>';
	
	if(user_id){
		$('#passSection').hide();
	} else {
		$('#changeSection').hide();
		$('#passSection').show();
	}
	
	
	$('#changepass').click(function() {
        if(this.checked) {
           $('#passSection').show();
        } else {
			$('#passSection').hide();
		}
             
    });
	
});
</script>
	<form role="form" method="POST" action="<?php echo site_url($form_action);?>" name="userForm" id="userForm" >
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<fieldset class="proinfo">
					<legend>User Information</legend>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">First Name</div>								
								<input type="text" name="firstname" value="<?php if(!empty($userInfo->firstname)){ echo $userInfo->firstname; } ?>"  id="firstname" class="form-control" autocomplete="off" required>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Last Name</div>
								<input type="text" name="lastname" value="<?php if(!empty($userInfo->lastname)){ echo $userInfo->lastname; } ?>"  id="lastname" class="form-control" autocomplete="off" >
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">Email</div>
								<input type="text" name="email" value="<?php if(!empty($userInfo->email)){ echo $userInfo->email; } ?>"  id="email" class="form-control" autocomplete="off" required>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">Username <span style="color:gray;font-size:14px;">(Enter at least 4 characters)</span></div>
								<input type="text" name="username" value="<?php if(!empty($userInfo->username)){ echo $userInfo->username; } ?>"  id="username" class="form-control" autocomplete="off" required>
								
							</div>
						</div>
						
						
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Mobile</div>
								<input type="text" name="mobile" value="<?php if(!empty($userInfo->mobile)){ echo $userInfo->mobile; } ?>"  id="mobile" class="form-control" autocomplete="off" >
							</div>
						</div>	
						
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">User Groups</div>								
								<select name="group_id" class="form-control" id="group_id" required>
									<option value="">-- Select --</option>
									<?php foreach($userGroups as $userGroup ) { ?>
										<option value="<?php echo $userGroup['id']; ?>" <?php if(!empty($userInfo->group_id) && $userInfo->group_id == $userGroup['id']){ echo "Selected='Selected'"; } ?>  ><?php echo $userGroup['group_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="col-sm-3" id="store">
							<div class="form-group required">
								<div class="control-label">Store</div>
								<select name="store_id" class="form-control" id="store_id">
									<option value="">-- Select --</option>
									<?php foreach($stores as $store ) { ?>
										<option value="<?php echo $store['store_id']; ?>" <?php if(!empty($userInfo->store_id) && $userInfo->store_id == $store['store_id']){ echo "Selected='Selected'"; } ?> ><?php echo $store['store_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Status</div>
								<select name="status" class="form-control" id="store_id">
									
									<option value="1" <?php if($userInfo->status == '1'){ echo "Selected='Selected'"; } ?> >Enable</option>
									<option value="0" <?php if($userInfo->status == '0'){ echo "Selected='Selected'"; } ?>>Disable</option>									
								</select>
							</div>
						</div>	
												
					</div>
				</fieldset>
				<br>
				
				<div class="row" id="changeSection">
					<div class="col-sm-3">
						<div class="control-label">Change Password <input type="checkbox" name="changepass" id="changepass" value="1" > </div>
					</div>
				</div>
				
				
				<fieldset class="proinfo" id="passSection">
					<legend>  Password</legend>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">New Password</div>								
								<input type="password" name="new_pass" value=""  id="new_pass" class="form-control" autocomplete="off" required>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group required">
								<div class="control-label">Confirm Password</div>
								<input type="password" name="confirm_pass" value=""  id="confirm_pass" class="form-control" autocomplete="off" required>
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