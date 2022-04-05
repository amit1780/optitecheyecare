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

	 <script src="<?php echo base_url(); ?>assets/script.js"></script>
	<form role="form" method="post" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" class="needs-validation" novalidate>
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				<input type="hidden" name="certificate_id" value="<?php if($certificate_id) { echo $certificate_id; } ?>">
				<fieldset class="proinfo">
					<legend>Certificate Details</legend>
						<div class="row">
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Certificate Name</div>
								<input type="text" name="certificate_name" value="<?php if(!empty($certificate_name)){ echo $certificate_name; } ?>"  id="certificate_name" class="form-control" autocomplete='off' required>
								<div class="invalid-feedback">
										Please Enter Certificate Name
								</div>
							  </div>
							</div>
						
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Expiry Date</div>
								<input type="text" name="certificate_expiry_date" value="<?php if(!empty($certificate_expiry_date)){ echo $certificate_expiry_date; } ?>" autocomplete='off'  id="certificate_expiry_date" class="form-control date" required>
								<div class="invalid-feedback">
										Please Enter Expiry Date
								</div>
							  </div>
							</div>
							<div class="col-sm-4">
							  <div class="form-group">
									<div class="control-label" for="input-product-pdf">Certificate PDF</div>
									<input type="file" name="certificate_file" class="form-control-file" id="certificate_file">
									<?php if(!empty($certificate_file)){ ?>
										<a href="<?php echo $certificate_file; ?>" target='_blank'>View</a>
									<?php } ?>
								</div>
							</div>							
						</div>					
							
						<div class="row">
							
							<div class="col-sm-12 mt-3">
								<button type="submit" id="addbatch" class="btn btn-primary float-right">Save Certificate</button>
							</div>
						</div>	
								
							
						</div>
						
				</fieldset>
			</div>
			
		</div>
	</form>
	
	

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/> -->

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
		
		var date_input=$('.MMYYYY'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'mm/yy',
			container: container,
			todayHighlight: true,
			minViewMode: "months", 
			autoclose: true,
		});
		
	});
	
	$(document).ready(function(){
		
		$("#sterliz").hide();
		
		$("input[name='ce']").click(function(){
			if(this.value == '1'){
				$("#non_ce").text('CE');
			} else {
				$("#non_ce").text('Non CE');
			}			
		});
		
		$("input[name='sterlization']").click(function(){
			if(this.value == '1'){
				$("#sterliz").show();
			} else {
				$("#sterliz").hide();
			}			
		});
		
	});
</script>
<script>
    $(document).ready(function () {
        $('#generic_product').typeahead({			
            source: function (query, result) {
                $.ajax({
                    url:'<?php echo site_url('getProductName'); ?>',
					data: 'name=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item.product_name;
                        }));

                    }
                });
            }
        });
		if($('#product_id').val()!=''){
			var model_no=$('#product_id').val();
			
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + $('#generic_product').val(), 
				dataType: 'json',
				success: function(response){
					var htm = '<option value=""> - select model - </option>';					
					$.each(response, function(i,res) {
						var selected='';
						if(model_no==res.product_id){
							selected=" selected ";
						}
						htm += '<option value="'+ res.product_id +'"'+selected+'>'+ res.model +'</option>';
					});		
					$("#input-model").html(htm);
					
				}
			}); 
		}
		
		$('#generic_product').on('autocompletechange change', function () {
			var model_no=$('#product_id').val();
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + this.value, 
				dataType: 'json',
				success: function(response){
					var htm = '<option value=""> - select model - </option>';					
					$.each(response, function(i,res) {
						var selected='';
						if(model_no==res.product_id){
							selected=" selected ";
						}
						htm += '<option value="'+ res.product_id +'"'+selected+'>'+ res.model +'</option>';
					});		
					$("#input-model").html(htm);
					
				}
			}); 	
		}).change();
	
		$('#input-model').change(function() {
		  var val = $(this).val(); 
		  $("#product_id").val(val);
		});
		
    });
</script>
	
</div>