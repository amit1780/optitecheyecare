<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">		
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> (<?php echo $customer->company_name; ?>)</h1> <?php echo $this->breadcrumbs->show(); ?>		
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
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	
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
						
			<div class="col-sm-12">
				<fieldset class="proinfo">
					<legend>Add Notes</legend>
						<div class="row">							
							<div class="col-sm-12">
							   <div class="form-group">
								<div class="control-label" >Notes</div> 
								<textarea name="notes" id="notes" class="form-control" rows="6" required></textarea>
								<div class="invalid-feedback">
									Required
								</div>
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
	
	<div class="row" style="margin:0px;">
		<div class="col-sm-12">
			<fieldset class="proinfo">
				<legend>Notes List</legend>
				<?php foreach($notes as $note){ ?>
					<div class="notes" style="margin-top: 20px;">
						<p style="color:gray;margin-bottom:0px;"><?php echo $note['username'];  ?> | <?php echo $note['notes_date_added']; ?></p>
						
						<p style="border:1px solid #ced4da ;padding:10px;"><?php echo $note['notes'];  ?></p>
						
					</div>
				<?php } ?>
			</fieldset>
		</div>	
	</div>	
</div>

		