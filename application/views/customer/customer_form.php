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
	<style>
		.alertmess {
			position: relative;
			padding: .75rem 1.25rem;
			margin-bottom: 1rem;
			border: 1px solid transparent;
				border-top-color: transparent;
				border-right-color: transparent;
				border-bottom-color: transparent;
				border-left-color: transparent;
			border-radius: .25rem;
		}
		.alertdanger {
			color: #721c24;
			background-color: #f8d7da;
			border-color: #f5c6cb;
		}
	</style>
	<?php if (!empty($unique_mess)) : ?>
		<div class="col-md-12" id="masserror">
			<div class="alertmess alertdanger"  role="alert">
				<?php echo $unique_mess; ?> <a href="#" onClick="addUniqueCustomer();" >OK</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="#" onClick="hideuniquemess();" >SKIP</a> 
			</div>
		</div>
	<?php endif; ?>
	
	<div id="successmess">
		
	</div>
	
<script>
 // Example starter JavaScript for disabling form submissions if there are invalid fields
/* (function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})(); */
 </script>
	<script>
/* !function(e){e.extend({uploadPreviewSig:function(l){var i=e.extend({input_field:".image-input",preview_box:".image-preview-sign",label_field:".image-label",label_default:"Choose File",label_selected:"Change Signature",no_label:!1,success_callback:null},l);return window.File&&window.FileList&&window.FileReader?void(void 0!==e(i.input_field)&&null!==e(i.input_field)&&e(i.input_field).change(function(){var l=this.files;if(l.length>0){var a=l[0],o=new FileReader;o.addEventListener("load",function(l){var o=l.target;a.type.match("image")?(e(i.preview_box).css("background-image","url("+o.result+")"),e(i.preview_box).css("background-size","cover"),e(i.preview_box).css("background-position","center center")):a.type.match("audio")?e(i.preview_box).html("<audio controls><source src='"+o.result+"' type='"+a.type+"' />Your browser does not support the audio element.</audio>"):alert("This file type is not supported yet.")}),0==i.no_label&&e(i.label_field).html(i.label_selected),o.readAsDataURL(a),i.success_callback&&i.success_callback()}else 0==i.no_label&&e(i.label_field).html(i.label_default),e(i.preview_box).css("background-image","none"),e(i.preview_box+" audio").remove()})):(alert("You need a browser with file reader support, to use this form properly."),!1)}})}(jQuery); */</script>
<style>
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	  -webkit-appearance: none; 
	  margin: 0; 
	}

</style>
<script>
$(document).ready(function() {					
	$("#customerForm").validate({
		rules: {
			company_name: "required",					
			contact_person: "required",				
			/* email: {				
				if ($("#mobile").val()) {
				   return true;
				} else {
					return false;
				}				
			},				
			
			mobile: {
				if ($("#email").val()) {
				   return true;
				} else {
					return false;
				}	
			},			 */		
			country_id: "required"					
		},
		messages: {
			company_name: "Please Enter Company name",
			contact_person: "Please Enter Contact Person",
			/* email: "Please enter Email",
			mobile: "Please Enter Mobile", */
			country_id: "Please Select Country"			
		}
	})

	$('#submit').click(function() {
		$("#customerForm").valid();
	});
});
</script>
	<form role="form" class="needs-validation" id="customerForm" data-toggle="validator" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
	<div class="row" style="margin:0px;">
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Company Information</legend>
					<div class="row">							
						<div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label" >Company Name</div> 
							<input type="text" name="company_name" value="<?php if($customer->company_name) { echo htmlspecialchars($customer->company_name); } else { echo set_value('company_name'); } ?>" id="company_name" class="form-control text-capitalize" required>
							
						  </div>
						</div>
						<input type="hidden" name="ref_id" value="<?php if($ref_id) { echo $ref_id; }  ?>">
						<input type="hidden" name="customer_id" value="<?php if($customer->customer_id) { echo $customer->customer_id; }  ?>">
						<div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label">Contact Person</div>
							<div class="input-group">
								<div class="input-group-prepend dropdown">
									<button class="btn btn-outline-secondary dropdown-toggle title-text " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dr</button>
									<div class="dropdown-menu">
									<?php foreach($titles as $title) { ?>
									  <a class="dropdown-item" href="#"><?php echo $title['title']; ?></a>
									<?php } ?>								  									 
									</div>
								 </div>
							
    							<input type="text" name="contact_person" style="width:75%;" value="<?php if($customer->contact_person) { echo $customer->contact_person; } else { echo set_value('contact_person'); } ?>" id="contact_person" class="form-control text-capitalize" required>
    							
							</div>
							
							<input type="hidden" name="person_title" value="<?php if($customer->person_title) { echo $customer->person_title; } else { echo set_value('person_title'); } ?>" id="person_title">
							
						  </div>
						</div>	
						
						<div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label">Email</div> 
							<input type="text" name="email" value="<?php if($customer->email) { echo $customer->email; } else { echo set_value('email'); } ?>" id="email" class="form-control" >
							
						  </div>
						</div>	
						
						<div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label">Mobile</div> 
							<input type="text" name="mobile" value="<?php if($customer->mobile) { echo $customer->mobile; } else { echo set_value('mobile'); } ?>" id="mobile" class="form-control" >
							
						  </div>
						</div>	
						
						<div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label">Phone</div> 
							<input type="text" name="phone" value="<?php if($customer->phone) { echo $customer->phone; } else { echo set_value('phone'); } ?>" id="phone" class="form-control" >
							
						  </div>
						</div>								
						<div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label">Fax</div> 
							<input type="text" name="fax" value="<?php if($customer->fax) { echo $customer->fax; } else { echo set_value('fax'); } ?>" id="fax" class="form-control" >
							
						  </div>
						</div>	
						<!-- <div class="col-sm-4">
						  <div class="form-group">
							<div class="control-label">UID</div> 
							<input type="text" name="uid" value="<?php if($customer->uid) { echo $customer->uid; } ?>" id="uid" class="form-control" required>
							<div class="invalid-feedback">
								Required
							</div>
						  </div>
						</div> -->	
					</div>
			</fieldset>
		</div>
			
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Address Information</legend>
					<div class="row">							
						<div class="col-sm-6">
						   <div class="form-group">
							<div class="control-label" >Address 1</div> 
							<textarea name="address_1"  id="address_1" class="form-control text-capitalize" rows="2" ><?php if($customer->address_1) { echo $customer->address_1; } else { echo set_value('address_1'); } ?></textarea>
							
						  </div>
						</div>
						
						<div class="col-sm-6">
						   <div class="form-group">
							<div class="control-label" >Address 2</div> 
							<textarea name="address_2"  id="address_2" class="form-control text-capitalize" rows="2" ><?php if($customer->address_2) { echo $customer->address_2; } else { echo set_value('address_2'); } ?></textarea>
							
						  </div>
						</div>
						
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Country</div> 
								<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" required>
									<option value="">-- Seclect --</option>
									<?php foreach($countries as $country){ ?>
										<?php $country_id = $customer->country_id; ?>
										<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } else { echo set_select('country_id', $country['country_id']); } ?> ><?php echo $country['name']; ?></option>										
									<?php } ?>
								</select>
								
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">State</div> 
								<select name="state_id" id="state_id" class="form-control" >
									
								</select>
								
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">District</div> 
							<input type="text" name="district" value="<?php if($customer->district) { echo $customer->district; } else { echo set_value('district'); } ?>" id="district" class="form-control text-capitalize" >
							
						  </div>
						</div>
						
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">City</div> 
							<input type="text" name="city" value="<?php if($customer->city) { echo $customer->city; } else { echo set_value('city'); } ?>" id="city" class="form-control text-capitalize" >
							
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Pin</div> 
							<input type="text" name="pin" value="<?php if($customer->pin) { echo $customer->pin; } else { echo set_value('pin'); } ?>" id="pin" class="form-control" >
							
						  </div>
						</div>								
					</div>
			</fieldset>
		</div>
			
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Identification</legend>
					<div class="row">													
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Company Registration No.</div> 
							<input type="text" name="company_registration_no" value="<?php if($customer->company_registration_no) { echo $customer->company_registration_no; } else { echo set_value('company_registration_no'); } ?>" id="company_registration_no" class="form-control">
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">GST</div> 
							<input type="text" name="gst" value="<?php if($customer->gst) { echo $customer->gst; } else { echo set_value('gst'); } ?>" id="gst" class="form-control">
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">PAN</div> 
							<input type="text" name="pan" value="<?php if($customer->pan) { echo $customer->pan; } else { echo set_value('pan'); } ?>" id="pan" class="form-control">
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">I/E Code</div> 
							<input type="text" name="ie_code" value="<?php if($customer->ie_code) { echo $customer->ie_code; } else { echo set_value('ie_code'); } ?>" id="ie_code" class="form-control">
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Drug licence No.</div> 
							<input type="text" name="drug_licence_no" value="<?php if($customer->drug_licence_no) { echo $customer->drug_licence_no; } else { echo set_value('drug_licence_no'); } ?>" id="drug_licence_no" class="form-control">
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Carrier </div> 
								<select name="sli_id" id="sli_id" class="form-control" >
									<option value="">-- Select --</option>
									<?php foreach($carriers as $carrier){ ?>
										<option value="<?php echo $carrier['sli_id']; ?>" <?php if($carrier['sli_id'] == $customer->sli_id){ echo ' selected="selected"'; } ?> ><?php echo $carrier['sli_name']; ?></option>
									<?php } ?>
									<option value="addCarrier" style="color: #007bff;">Add Carrier</option>
								</select>
								
						  </div>
						</div>
						
						<div class="col-sm-3">
						  <div class="form-group">
							<div class="control-label">Account Number</div> 
							<input type="text" name="account_number" value="<?php if($customer->account_number) { echo $customer->account_number; } else { echo set_value('account_number'); } ?>" id="account_number" class="form-control">
						  </div>
						</div>
						
						<div class="col-sm-12">
							<button type="submit" id="submit" class="btn btn-primary float-right"> Save</button>	
						</div>
					</div>
			</fieldset>
		</div>				
	</div>		
	</form>
</div>

<script>
		$(document).ready(function() {						
			$("#addnewstate").validate({
				rules: {
					state_name: "required"				
				},
				messages: {
					state_name: "Please Enter State name"
				}
			})
		});
	</script>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width: 350px;">		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add State</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body" style="padding:2rem;">
				<form method="post" action="" enctype="multipart/form-data" id="addnewstate" name="addnewstate">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<div class="control-label">State name</div>
								<input type="text" name="state_name" value=""  id="state_name" class="form-control" required>								
							</div>
						</div>						
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="addState" class="btn btn-primary float-right">Save</button>	
							</div>
						</div>
					</div>
				</form>							  
			</div>
		  </div>		  
		</div>
	</div>
	
	<div class="modal fade" id="myModalCarriers" role="dialog">
		<div class="modal-dialog" style="max-width: 600px;">		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add Carrier</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger12"></div>
			<div class="modal-body" style="padding:2rem;">
				<form method="post" action="" enctype="multipart/form-data" id="addnewCarrier" name="addnewCarrier">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Carrier name</div>
								<input type="text" name="sli_name" value=""  id="sli_name" class="form-control" required>								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Account number for Tarun Enterprises</div>
								<input type="text" name="sli_account_number" value=""  id="sli_account_number" class="form-control" >								
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="addCarrier" class="btn btn-primary float-right">Save</button>	
							</div>
						</div>
					</div>
				</form>							  
			</div>
		  </div>		  
		</div>
	</div>

<script>
	$(document).ready(function() {		
	    var title = '<?php echo $customer->person_title; ?>';
		if(title != ''){
			$(".title-text").html(title);
		} else {			
			$(".title-text").html('Dr');
			$("#person_title").val('Dr');
		}	    
	    
		var country_id = $("#country_id").val();
		var state_id = '<?php echo $customer->state_id; ?>';
		$.ajax({
			url:'<?php echo site_url('ajaxGetSatetByCountryId'); ?>',
			method: 'post',
			data: {country_id: country_id},
			dataType: 'json',
			success: function(response){
				var htm = '<option value="">-- Select State --</option>';					
				$.each(response, function(i,res) {
					if(res.state_id == state_id){
						htm += '<option value="'+ res.state_id +'" selected>'+ res.name +'</option>';
					} else {
						htm += '<option value="'+ res.state_id +'" >'+ res.name +'</option>';
					}
				});
				htm += '<option value="addState" style="color: #007bff;">Add State</option>';
				$("#state_id").html(htm);			
			}
		});
		
		$('#state_id').on('change', function() {
			var value = $(this).val();
			if(value == 'addState'){
				$("#myModal").modal();
			}
		});
				
		$("#addState").click(function(){		
			if(! $("#addnewstate").valid()) return false;			
			var country_id = $("#country_id").val();
			var name = $("#state_name").val();
			
			var dataString = 'state_name='+ name + '&country_id=' + country_id; 
			$.ajax({
				url:'<?php echo site_url('addNewState'); ?>',
				method: 'post',
				data: dataString,
				dataType: 'json',
				success: function(response){
					$("#alert-danger").html('');
					if(response.error){
						var html = '<div class="alert alert-danger" role="alert">'+response.error+'</div>';
						$("#alert-danger").html(html);
					} else {
						var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
						$("#alert-danger").html(htm);
						
						var html = '<option value="'+ response.id +'" selected>'+ response.name +'</option>';					
						$("#state_id option").eq(-2).after(html);						
						
						setTimeout(function(){
							$("#myModal .close").click();
							$("#state_name").val('');
							$("#alert-danger").html('');
						}, 3000);
						
					}
				}
			});
		});
		
		$('#sli_id').on('change', function() {
			var value = $(this).val();
			if(value == 'addCarrier'){
				$("#myModalCarriers").modal();
			}
		});
		
		$("#addCarrier").click(function(){		
			if(! $("#addnewCarrier").valid()) return false;			
			var name = $("#sli_name").val();			
			var sli_account_number = $("#sli_account_number").val();			
			var dataString = 'sli_name='+ name + '&sli_account_number=' + sli_account_number;
			$.ajax({
				url:'<?php echo site_url('customer/addCarrier'); ?>',
				method: 'post',
				data: dataString,
				dataType: 'json',
				success: function(response){
					$("#alert-danger12").html('');
					if(response.error){
						var html = '<div class="alert alert-danger" role="alert">'+response.error+'</div>';
						$("#alert-danger12").html(html);
					} else {
						var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
						$("#alert-danger12").html(htm);
						
						var html = '<option value="'+ response.sli_id +'" selected>'+ response.sli_name +'</option>';					
						$("#sli_id option").eq(-2).after(html);						
						
						setTimeout(function(){
							$("#myModalCarriers .close").click();
							$("#sli_name").val('');
							$("#alert-danger12").html('');
						}, 3000);
						
					}
				}
			});
		});
		
		$("#close").click(function(){
			$("#state_name").val('');
			$("#alert-danger").html('');
		});
		
		$(".dropdown-item").click(function(){
			var title = $(this).text();
			$(".title-text").html(title);
			$("#person_title").val(title);
		});	
		
	});
</script>
<script>
	function addUniqueCustomer(){
		var base_url = '<?php echo site_url('customer'); ?>';
		var checkstr =  confirm('Are you sure you want to Create');
		if(checkstr == true){
			var data_form = $('#customerForm').serialize();	
			$.ajax({
				url:'<?php echo site_url('addUniqueCustomer');?>',
				method: 'post',
				data: data_form,
				dataType: 'json',
				success: function(response){
					//if(response){
						$("#masserror").hide();
						var htm = '<div class="col-md-12"><div class="alert alert-success" role="alert">Success: You have Added New Customer</div></div>';
						$("#successmess").html(htm);							
						setTimeout(function(){
							window.location.replace(base_url);
						}, 3000);		
						
					//}
				}
			});
		}
	}
	
	function hideuniquemess(){
		$("#masserror").hide();
	}
</script>						