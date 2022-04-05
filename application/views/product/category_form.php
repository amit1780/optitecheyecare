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


	<form role="form" method="post" action="<?php echo site_url('editCategory/'.$categoryInfo->category_id);?>" enctype="multipart/form-data" class="needs-validation" novalidate>
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<input type="hidden" name="category_id" value="<?php echo $categoryInfo->category_id; ?>">
				<fieldset class="proinfo">
					<legend>Category Edit</legend>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<div class="control-label">Category name</div>								
								<input type="text" name="category_name" value="<?php echo $categoryInfo->name; ?>"  id="category_name" class="form-control" required>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<div class="control-label">Expiry Year</div>
								<select name="expiry_year" id="expiry_year" class="form-control" required>
									<option value="">-- Select --</option>
									<?php for($i=1; $i<=10; $i++){ ?>
										<option value="<?php echo $i; ?>" <?php if(!empty($categoryInfo->expiry_year) && $categoryInfo->expiry_year == $i){ echo 'selected="selected"'; } ?> ><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<br>
								<button type="submit" id="addCategory" class="btn btn-primary float-right"> Save</button>	
							</div>
						</div>							
					</div>
				</fieldset>
			</div>				
		</div>
	</form>	
</div>