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
<script>
 // Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
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
})();
 </script>
	<script>
!function(e){e.extend({uploadPreviewSig:function(l){var i=e.extend({input_field:".image-input",preview_box:".image-preview-sign",label_field:".image-label",label_default:"Choose File",label_selected:"Change Signature",no_label:!1,success_callback:null},l);return window.File&&window.FileList&&window.FileReader?void(void 0!==e(i.input_field)&&null!==e(i.input_field)&&e(i.input_field).change(function(){var l=this.files;if(l.length>0){var a=l[0],o=new FileReader;o.addEventListener("load",function(l){var o=l.target;a.type.match("image")?(e(i.preview_box).css("background-image","url("+o.result+")"),e(i.preview_box).css("background-size","cover"),e(i.preview_box).css("background-position","center center")):a.type.match("audio")?e(i.preview_box).html("<audio controls><source src='"+o.result+"' type='"+a.type+"' />Your browser does not support the audio element.</audio>"):alert("This file type is not supported yet.")}),0==i.no_label&&e(i.label_field).html(i.label_selected),o.readAsDataURL(a),i.success_callback&&i.success_callback()}else 0==i.no_label&&e(i.label_field).html(i.label_default),e(i.preview_box).css("background-image","none"),e(i.preview_box+" audio").remove()})):(alert("You need a browser with file reader support, to use this form properly."),!1)}})}(jQuery);</script>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>


	<form role="form" class="needs-validation" data-toggle="validator" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
		<div class="row" style="margin:0px;">
			<div class="col-sm-6">
				<fieldset class="proinfo">
					<legend>Product Information</legend>
						<div class="row">
							<?php if(isset($product_id)){ ?>
								<input type="hidden" name="product_id" value="<?php if(isset($product_id)){ echo $product_id; } ?>">
							<?php } ?>
							<div class="col-sm-6">
							  <div class="form-group">
								<div class="control-label" >Product Name</div> 
								<input type="text" name="product_name" value="<?php if(isset($product_name)){ echo $product_name; }  ?>" id="product_name" class="form-control" required>
								<div class="invalid-feedback">
									Required
								</div>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
								<div class="control-label">Model</div> 
								<input type="text" name="model" value="<?php if(isset($model)){ echo $model; }  ?>" id="model" class="form-control">
							  </div>
							</div>						
						</div>
						
						<div class="row">
							
							<div class="col-sm-6">
							  <div class="form-group">
								<div class="control-label" >Category</div> 
								<select name="category_id" id="input-category" class="form-control" required>
									<option value="0">Select Category</option>
									<?php if(isset($categories)){ ?>
										<?php foreach($categories as $category){ ?>
											
											<option value="<?php echo $category['category_id']; ?>" <?php if(isset($category_id) && $category_id == $category['category_id']) { echo ' selected="selected"'; } ?>><?php echo $category['name']; ?></option>
											
										<?php } ?>
									<?php } ?>
									<option value="add" style="color: #007bff;">Add Category</option>
								</select>
								<div class="invalid-feedback">
									Required
								</div>
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
							   <div class="control-label" >HSN</div> 
								<input type="text" name="hsn" value="<?php if(isset($hsn)){ echo $hsn; } ?>"  id="input-hsn" class="form-control" required>
								<div class="invalid-feedback">
									Required
								</div>
								
							  </div>
							</div>
							
						</div>
						
						<div class="row">
						    <div class="col-sm-3">							  
							  <div class="form-group">	
							    <div class="control-label" >GST %</div> 
								<!--<div class="input-group-prepend" style='height:38px;'>
									<span class="input-group-text" style='padding: 0px 0px;' id="inputGroupPrepend">%</span>
								</div>-->
								<input type="text" name="gst" value="<?php if(isset($gst)){ echo $gst; } ?>" id="input-gst" class="form-control" maxlength='2'>
							  </div>
							</div>
							<div class="col-sm-3">
							  <div class="form-group">	
							    <div class="control-label">MRP</div> 
								<input type="text" name="mrp" value="<?php if(isset($mrp)){ echo $mrp; } ?>"  id="input-mrp" class="form-control input-class-price">
							  </div>
							</div>
							<div class="col-sm-3">
							  <div class="form-group">		
							    <div class="control-label">Cost Price</div> 
								<input type="text" name="cost_price" value="<?php if(isset($cost_price)){ echo $cost_price; } ?>"  id="input-cost-price" class="form-control input-class-price">
							  </div>
							</div>
							
							<div class="col-sm-3">
							  <div class="form-group">	
								 <div class="control-label" >Pack Unit</div> 
								<!-- <input type="text" name="pack_unit" value="<?php if(isset($pack_unit)){ echo $pack_unit; } ?>"  id="input-pack-unit" class="form-control" required> -->
								<select name="pack_unit" class="form-control" id="pack_unit" required>
									<?php foreach($pack_units as $packunit){ ?>
										<option value="<?php echo $packunit['id']; ?>" <?php if(isset($pack_unit) && $pack_unit == $packunit['id']) { echo ' selected="selected"'; } ?>><?php echo $packunit['unit_name']; ?></option>
									<?php } ?>
								</select>
								<div class="invalid-feedback">
									Required
								</div>
							  </div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
							  <div class="form-group">
							    <div class="control-label" >Description</div> 
								<textarea name="description"  id="input-desc" class="form-control" rows="7" required><?php if(isset($description)){ echo $description; } ?></textarea>
								<div class="invalid-feedback">
									Required
								</div>
							  </div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="control-label" for="input-photo">IFU</div>
									<input type="file" name="photo" class="form-control-file" id="photo">
									<?php if(!empty($photo)){ ?>
										<a href="<?php echo $photo; ?>"  target='_blank'>View</a>
									<?php } ?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="control-label" for="input-product-pdf">Product PDF</div>
									<input type="file" name="product_pdf" class="form-control-file" id="product_pdf">
									<?php if(!empty($product_pdf)){ ?>
										<a href="<?php echo $product_pdf; ?>" target='_blank'>View</a>
									<?php } ?>
								</div>
							</div>
						</div>
					
				</fieldset>
			</div>
			
			<div class="col-sm-6">
				<fieldset class="proPrice">
					<legend>Price</legend>
					
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">	
								    <div class="control-label">INR</div>
									<input type="text" name="price_1" value="<?php if(isset($price[0]['price'])){ echo $price[0]['price']; } elseif (!empty($price_1)){ echo $price_1;} ?>"  id="input-price-inr" class="form-control input-class-price">
								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">	
								    <div class="control-label">USD</div>
									<input type="text" name="price_2" value="<?php if(isset($price[1]['price'])){ echo $price[1]['price']; }elseif (!empty($price_2)){ echo $price_2;} ?> "  id="input-price-usd" class="form-control input-class-price">
								</div>
							</div>
							
							<div class="col-sm-3">							
								<div class="form-group">
									<div class="control-label">EUR</div>
									<input type="text" name="price_3" value="<?php if(isset($price[2]['price'])){ echo $price[2]['price']; }elseif (!empty($price_3)){ echo $price_3;} ?> "  id="input-price-eur" class="form-control input-class-price">
								</div> 
							</div> 
							
							<div class="col-sm-3">
								<div class="form-group">	
									<div class="control-label">GBP</div>
									<input type="text" name="price_4" value="<?php if(isset($price[3]['price'])){ echo $price[3]['price']; }elseif (!empty($price_4)){ echo $price_4;} ?> "  id="input-price-gbp" class="form-control input-class-price input-class-price">
								</div>
							</div>			
						</div>
					</fieldset>
					<fieldset class="proPrice">
						<legend>Minimum Price</legend>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">	
								    <div class="control-label">INR(<i>With GST</i>)</div>
									<input type="text" name="min_price_inr" value="<?php if(isset($price[0]['min_price'])){ echo $price[0]['min_price']; }elseif (!empty($min_price_inr)){ echo $min_price_inr;} ?>"  id="input-min-price-int" class="form-control input-class-price">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">	
									<div class="control-label">USD</div>
									<input type="text" name="min_price_usd" value="<?php if(isset($price[1]['min_price'])){ echo $price[1]['min_price']; }elseif (!empty($min_price_usd)){ echo $min_price_usd;} ?>"  id="input-min-price-usd" class="form-control input-class-price">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">			
									<div class="control-label">EUR</div>
									<input type="text" name="min_price_eur" value="<?php if(isset($price[2]['min_price'])){ echo $price[2]['min_price']; }elseif (!empty($min_price_eur)){ echo $min_price_eur;} ?>"  id="input-min-price-eur" class="form-control input-class-price">
								</div>		
							</div>						
							<div class="col-sm-3">
							  <div class="form-group">		
							   <div class="control-label ">GBP</div>
								<input type="text" name="min_price_gbp" value="<?php if(isset($price[3]['min_price'])){ echo $price[3]['min_price']; }elseif (!empty($min_price_gbp)){ echo $min_price_gbp;} ?>"  id="input-min-price-gbp" class="form-control input-class-price">
							  </div>
							</div>
						</div>
				</fieldset>
				<fieldset class="proOther">
					<legend>Certificates</legend>
					<div class="row">
					    <!-- <div class="col-sm-12" style="margin-top: -22px;margin-bottom: 10px;">
							<a href="#" id="addCertificatePopup">Add Certificate</a>
						</div> -->
						<div class="col-sm-6">
							<div style="overflow:auto;height:204px;">
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
									  <tbody id="certificatesfilename">
											<?php if($certificates){ ?>
												<?php foreach($certificates as $certificate){  
												
													$expire_date_time = $certificate['expire_date_time']; 
													 $expire_date = date("Y-m-d", strtotime($expire_date_time));
												
												?>
													<tr>
														<td>
															<input type="checkbox" name="certificate_id[]" value="<?php echo $certificate['certificate_id']; ?>" class="certificateId" <?php if(!empty($certificate_id) && is_array($certificate_id)){ if (in_array($certificate['certificate_id'], $certificate_id)){ echo "checked='true'"; } } ?> />															
														</td>
														<td><?php echo $certificate['certificate_name']; ?> ( <span style="font-size:11px;font-style: italic;"><?php echo $expire_date; ?></span> )</td>
													</tr>
												<?php } ?>
											<?php } ?>
									  </tbody>
									</table>
								</div>	
							</div>	
						</div>	
						<div class="col-sm-6">
							<div class="form-group">
								<select name="certificates[]" class="form-control" size="8" id="certificates" multiple=""></select>
							</div>
						</div>
					</div>
					
					<button type="submit" id="submit" class="btn btn-primary float-right"> Save</button>						
					
				</fieldset>
			</div>
			
		</div>
	</form>
	<script>
		$(document).ready(function() {						
			$("#addnewcategory").validate({
				rules: {
					category_name: "required",				
					expiry_year: "required"				
				},
				messages: {
					category_name: "Please Enter category name",
					expiry_year: "Please Select Expiry Year"
				}
			})
		});
	</script>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width: 350px;">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add Category</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body" style="padding:2rem;">
				
				<form method="post" action="" enctype="multipart/form-data" id="addnewcategory">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<div class="control-label">Category name</div>								
								<input type="text" name="category_name" value=""  id="category_name" class="form-control" required>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Expiry Year</div>
								<select name="expiry_year" id="expiry_year" class="form-control" required>
									<option value="">-- Select --</option>
									<?php for($i=1; $i<=10; $i++){ ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<br>
								<button type="button" id="addCategory" class="btn btn-primary float-right"> Save</button>	
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
			$("#addnewcertificate").validate({
				rules: {
					certificate_name: "required",				
					certificate_expiry_date: "required",
					certificate_file: {
						required: true, 
						//extension: "png|jpeg|jpg",
						//filesize: 1048576,   
					}
				},
				messages: {
					certificate_name: "Please Enter Certificate name",
					certificate_expiry_date: "Please Select Certificate Expiry Date",
					certificate_file: "Please upload Certificate File"
				}
			})
		});
	</script>
	
	<!-- Start certificate Popup design -->
	<div class="modal fade" id="myModalCertificate" role="dialog">
		<div class="modal-dialog" style="max-width: 500px;">		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add Certificate</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger-certificate"></div>
			<div class="modal-body" style="padding:2rem;">
				<script src="<?php echo base_url(); ?>assets/script.js"></script>
				<form method="post" action="" enctype="multipart/form-data" id="addnewcertificate" name="addnewcertificate">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Certificate name</div>
								<input type="text" name="certificate_name" value=""  id="certificate_name" class="form-control" required>								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="control-label">Expiry Date</div>
								<input type="text" name="certificate_expiry_date" value=""  id="certificate_expiry_date" class="form-control date" required>								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">								
								<!-- <input type="file" name="certificate_file" id="certificate_file"> -->
								
								<input type="file" name="file" id="file" style="margin-top: 15px;">
								<!-- <div class="upload-area"  id="uploadfile">
									Upload file
								</div> -->
								<img src="<?php echo base_url(); ?>assets/img/ajax-loader.gif" class="loader" style="display:none;" >
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">									
								<button type="button" id="addCertificate" class="btn btn-primary float-right">Save</button>	
							</div>
						</div>
					</div>
				</form>
							  
			</div>
		  </div>		  
		</div>
	</div>
	
	<!-- End certificate Popup design -->
<script>
$(document).ready(function(){
	var date_input=$('.date'); //our date input has the name "date"
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input.datepicker({
		dateFormat: 'yy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
	});
});

$(document).ready(function(){
	$('.input-class-price').keyup(function(e){
		this.value = this.value.replace(/[^0-9.]/g, '');
	});
	$('#input-gst').keyup(function(e){
		this.value = this.value.replace(/[^0-9]/g, '');
	});
	$('#input-mrp').keyup(function(e){
		var gst=$('#input-gst').val();
		var mrp=$('#input-mrp').val();
		if(!$.isNumeric($('#input-gst').val())) {
			return false;
		}
		if(!$.isNumeric($('#input-mrp').val())) {
			return false;
		}
		var inr=parseFloat(mrp)*(100/(100+parseInt(gst)));
		inr=parseFloat(inr);
		$('#input-price-inr').val(inr.toFixed(2));
		//this.value = this.value.replace(/[^0-9.]/g, '');
	});
	$('#input-gst').keyup(function(e){
		var gst=$('#input-gst').val();
		var mrp=$('#input-mrp').val();
		if(!$.isNumeric($('#input-gst').val())) {
			return false;
		}
		if(!$.isNumeric($('#input-mrp').val())) {
			return false;
		}
		var inr=parseFloat(mrp)*(100/(100+parseInt(gst)));
		inr=parseFloat(inr);
		$('#input-price-inr').val(inr.toFixed(2));
		//this.value = this.value.replace(/[^0-9.]/g, '');
	});
	
	$(".certificateId").click(function(){
		
		if($(this).is(':checked')){ 
			var certificate_id = $(this).val();
			
			$.ajax({
				url:'<?php echo site_url('ajaxGetCertificateBuyId'); ?>',
				method: 'post',
				data: {certificate_id: certificate_id},
				dataType: 'json',
				success: function(response){
					var id = response.certificate_id;
					var name = response.certificate_name;
					var html = '<option value="'+ id +'">'+ name +'</option>'
					$("#certificates").append(html);
				}
			});
		} else {
			var certificate_id = $(this).val();
			$("#certificates option[value='"+certificate_id+"']").remove();
		}
	});
	
	
	var certificateIdArr = <?php echo json_encode($certificate_id); ?>;
	
	jQuery.each(certificateIdArr, function(index, item) {
		$.ajax({
				url:'<?php echo site_url('ajaxGetCertificateBuyId'); ?>',
				method: 'post',
				data: {certificate_id: item},
				dataType: 'json',
				success: function(response){
					var id = response.certificate_id;
					var name = response.certificate_name;
					var html = '<option value="'+ id +'">'+ name +'</option>'
					$("#certificates").append(html);
				}
			});
	});
	
});
$(document).ready(function(){	
	$('#input-category').on('change', function() {
		var value = $(this).val();
		if(value == 'add'){
			$("#myModal").modal();
		}
	});
});

$(document).ready(function(){
	$("#addCategory").click(function(){
		
	    if(! $("#addnewcategory").valid()) return false;
		/* var name = $("#category_name").val();
		var expiry_year = $("#expiry_year").val(); */
		
		var data_form = $('#addnewcategory').serialize();	
		
		$.ajax({
			url:'<?php echo site_url('addCategory'); ?>',
			method: 'post',
			data: data_form,
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
					$("#input-category option").eq(-2).after(html);
					
					
					setTimeout(function(){
						$("#myModal .close").click();
						$("#category_name").val('');
						$("#alert-danger").html('');
					}, 3000);
					
				}
			}
		});
	});
});


/* Add Certificate  */
$(document).ready(function(){
	$("#addCertificatePopup").click(function(){
		//$(".loader").hide();
		$("#myModalCertificate").modal();
	});
});

$(document).ready(function(){
	$("#addCertificate").click(function(){		
		
		if(! $("#addnewcertificate").valid()) return false;
		
		 var certificate_name = $("#certificate_name").val();
		var certificate_expiry_date = $("#certificate_expiry_date").val();		
		var dataString = 'certificate_name='+ certificate_name + '&certificate_expiry_date=' + certificate_expiry_date; 		
		$.ajax({
			url:'<?php echo site_url('addCertificate'); ?>',
			method: 'post',
			data: dataString,
			dataType: 'json',
			success: function(response){

				 $("#alert-danger-certificate").html('');
				
				var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
				$("#alert-danger-certificate").html(htm);
									
				var html1 = '<tr><td><input type="checkbox" name="certificate_id[]" value='+response.id+' class="certificateId"></td><td>'+response.name+' ( <span style="font-size:11px;font-style: italic;">2019-01-24</span> )</td></tr>';
				
				$("#certificatesfilename").append(html1);				
				
				setTimeout(function(){
					$("#myModalCertificate .close").click();
					$("#certificate_name").val('');
					$("#certificate_expiry_date").val('');
					$("#alert-danger-certificate").html('');
				}, 3000);
					
				
			}
		});
	});
	
	$("#file").change(function(){
		var base_url = '<?php echo base_url(); ?>'+'index.php/fileupload';		
		var fd = new FormData();
		var files = $('#file')[0].files[0];
		fd.append('file',files);
		
		$.ajax({
			url: base_url,
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			dataType: 'json',				
			success: function(response){
				if(response){
					alert("Upload file Successful.");
				}
			}
		});			
	});		
	
});

</script>

	
</div>

							