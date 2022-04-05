<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
		  <a href="#">Add Stock</a>
		</li>
	</ol>

	<?php if (validation_errors()) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
				<?php echo validation_errors(); ?>
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

	<form role="form" method="post" action="<?php echo site_url('addStock');?>" enctype="multipart/form-data"  class="needs-validation" novalidate>
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				
				<fieldset class="proinfo">
					<legend>Add Stock</legend>
						<div class="row">
								<div class="col-sm-12">	
								<?php $i=0; foreach($stores as $store){ ?>						
									
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="store_id" value="<?php echo $store['store_id']; ?>" required <?php if($i==0){ echo "checked"; } ?>>  
									  <label class="form-check-label"><?php echo $store['store_name']; ?></label>
									</div>
								<?php $i++; } ?>
							</div>
						</div>
						<div class="row mt-3">
						</div>
					
						<div class="row">
							<div class="col-sm-2">						  
							  <div class="form-group">
								 <div class="control-label" >Product Name</div> 
								 <input type="text" name="product_name" value="" id="product_name" class="form-control typeahead" autocomplete="off" required>
							  </div>
							</div>
							
							<div class="col-sm-2">						  
							  <div class="form-group">
								
								<div class="control-label" >Model</div> 
								<select name="model" id="input-model" class="form-control" required>
									
								</select>
								
							  </div>
							</div>
						
							<div class="col-sm-2">	
							  <div class="form-group">
									<div class="control-label" >Batch</div> 
									<select name="batch" id="input-batch" class="form-control" required>
										<option value="">Select Batch</option>	
										<option value="add" style="color: #007bff;">Add Batch</option>	
								    </select>
									<input type="hidden" name="batch_id" value="" id="batch_id">
							  </div>
							</div>
							
							
							<div class="col-sm-2">	
								<div class="form-group">
									<div class="control-label" >Qty</div> 
									<input type="number" name="qty" value="" id="input-name" class="form-control" required>
								</div>
							</div>
							
							<div class="col-sm-2">	
								<div class="form-group">
									<div class="control-label" >Mfg. Date</div> 
									<input class="form-control date" name="mfg_date" id="mfg_date_s" type="text" placeholder="MM/YYYY" disabled/>
								</div>
							</div>
							
							<div class="col-sm-2">	
								<div class="form-group">
									<div class="control-label" >Exp. Date</div> 
									<input class="form-control date"  name="exp_date" id="exp_date_s" type="text" placeholder="MM/YYYY" disabled />
								</div>
							</div>							
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" id="submit" class="btn btn-primary float-right"> Save</button>	
							</div>
						</div>
						
				</fieldset>
			</div>
			
		</div>
	</form>
	
	<script src="<?php echo base_url(); ?>assets/script.js"></script>
	
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width:1054px;">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Add Batch</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess"></div>
			<div class="modal-body" style="padding:2rem;">
				<form method="post" action="" enctype="multipart/form-data" id="addbatchform">
				    <input type="hidden" name="stock_popup" value="stock_popup">
					<div class="row">						
							<div class="col-sm-4">
							  <div class="form-group">
									<div class="control-label" >IQC</div> 
									<input type="text" name="iqc" value="<?php if(!empty($iqc)){ echo $iqc; } ?>" id="iqc" class="form-control" required>
									<div class="invalid-feedback">
										Required
									</div>
							  </div>
							</div>
							
							<div class="col-sm-4">
							  <div class="form-group">	
							   <div class="control-label" >Product Name</div> 
								<input type="text" name="generic_product" value="" autocomplete="off"  id="generic_product" class="form-control typeahead" required>
							  </div>
							</div>
						
							<div class="col-sm-4">
							  <div class="form-group">
									<div class="control-label" >Model</div>
									
								<select name="model_no" id="input-model-popup" class="form-control" required>
								</select>
									<div class="invalid-feedback">
										Required
									</div>
								<input type="hidden" name="product_id" value="" id="product_id">
							  </div>
							</div>						
						</div>
						
						<div class="row">
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Brand Name of Product</div>
								<input type="text" name="brand_name" value="<?php if(!empty($brand_name)){ echo $brand_name; } ?>"  id="brand_name" class="form-control" required>
								<div class="invalid-feedback">
										Required
								</div>
							  </div>
							</div>
						
							<div class="col-sm-4">
							  <div class="form-group">							
								<div class="row">
									<div class="col-sm-12">
										<div class="control-label" >&nbsp;</div>
										<div class="form-check form-check-inline">
										  <input class="form-check-input" type="radio" name="ce" id="ce1" value="0" checked>
										  <label class="form-check-label" >Non CE</label>
										</div>
										<div class="form-check form-check-inline">
										  <input class="form-check-input" type="radio" name="ce" id="ce1" value="1">
										  <label class="form-check-label" >CE</label>
										</div>										
									</div>									
								</div>
								
							  </div>
							</div>						
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Batch Size</div>
								<input type="text" name="batch_size" value="<?php if(!empty($batch_size)){ echo $batch_size; } ?>"  id="batch_size" class="form-control" required>
							  </div>
							</div>			
							
						</div>
						
						<div class="row">
							
							<div class="col-sm-4">
							  <div class="form-group">		
								  <div class="control-label" >Batch No</div>
								<input type="text" name="batch_no" value="<?php if(!empty($batch_no)){ echo $batch_no; } ?>"  id="batch_no" class="form-control" required>
							  </div>
							</div>
							
							<div class="col-sm-4">
							  <div class="form-group">	
							   <div class="control-label" >MFG./Neutral Code</div>
								<input type="text" name="neutral_code" value="<?php if(!empty($neutral_code)){ echo $neutral_code; } ?>" id="neutral_code" class="form-control" placeholder='NA if not applicable' required>
							  </div>
							</div>	
							<div class="col-sm-2">
							  <div class="form-group">	
							    <div class="control-label" >Mfg. Date</div>
								<input type="text" name="mfg_date" value="<?php if(!empty($mfg_date)){ echo $mfg_date; } ?>"  id="mfg_date" class="form-control MMYYYY" placeholder="MM/YYYY" autocomplete="off" pattern="\d{1,2}/\d{4}" required>
							  </div>
							</div>
							<div class="col-sm-2">
							  <div class="form-group">	
								<div class="control-label" >Exp. Date</div>
								<input type="text" name="exp_date" value="<?php if(!empty($exp_date)){ echo $exp_date; } ?>"  id="exp_date" class="form-control MMYYYY" placeholder="MM/YYYY" autocomplete="off" pattern="\d{1,2}/\d{4}" required>
							  </div>
							</div>
						</div>
						
						<!--<div class="row">							
							
							<div class="col-sm-4">
							  <div class="form-group">							
								<input type="text" name="purchase_order_date" value=""  id="purchase_order_date" class="form-control date" required>
								<label class="form-control-placeholder" for="input-hsn">Purchase order Date</label>
							  </div>
							</div>
						</div>-->
						
						<div class="row">
							<div class="col-sm-4">
							  <div class="form-group">	
								<div class="control-label" >Good received on</div>
								<input type="text" name="good_received_on" value="<?php if(!empty($good_received_on)){ echo $good_received_on; } ?>"  id="good_received_on" class="form-control date" required>

							  </div>
							</div>
							
							<div class="col-sm-4">
							  <div class="form-group">							
								<div class="row">
									
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><b>Sterlization</b></label>
									</div>
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="radio" name="sterlization" value="1"> Yes</label>
									</div>
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="radio" name="sterlization" value="0" checked> No</label>
									</div>									
								</div>
							  </div>
							</div>
							
							<div class="col-sm-4">
								<div class="row">
									<div class="col-sm-6">
										<!-- <input type="file" name="sterlization_file" class="form-control-file" id="sterlization_file"> -->
										<div id="sterliz">
											<input type="file" name="file" id="file">
											<div class="upload-area"  id="uploadfile">
												Upload file
											</div>
										</div>
									</div>
									<div class="col-sm-6 mt-2">
										<button type="button" id="addbatch" class="btn btn-primary float-right"> Add Batch</button>
									</div>
								</div>	
								
								
							</div>
						</div>
				</form>
			</div>
		  </div>
		</div>
	</div>
	
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

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


})
</script>
<script>
    $(document).ready(function () {
        $('#product_name').typeahead({			
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
    });
    
    
</script>
<script>
	$(document).ready(function(){	
		$('#input-batch').on('change', function() {
			var value = $(this).val();
			if(value == 'add'){
				$("#myModal").modal();
			}else if(value != ''){
				$.ajax({
					url:'<?php echo site_url('getBatchDetail');?>',
					method: 'post',
					data: 'batch_id=' + this.value, 
					dataType: 'json',
					success: function(response){
						var mfg_date = response[0].mfg_date.split("-");
						var exp_date = response[0].exp_date.split("-");
						$("#mfg_date_s").val(mfg_date[1]+'/'+mfg_date[0]);
						$("#exp_date_s").val(exp_date[1]+'/'+exp_date[0]);
					}
				}); 
			}
		});
	});
	
	$(document).ready(function(){
		
		$("#sterliz").hide();
		
		$("#addbatch").click(function(){
			
			var data_form = $('#addbatchform').serialize();			
			
			$.ajax({
				url:'<?php echo site_url('addBatch');?>',
				method: 'post',
				data: data_form,
				dataType: 'json',
				success: function(response){
					var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
					$("#mess").html(htm);
					var html = '<option value="'+ response.batch_id +'" selected>'+ response.batch_no +'</option>';					
					$("#input-batch option").eq(-2).after(html);
					
					setTimeout(function(){
						$("#myModal .close").click();
						$("#mess").html('');
					}, 3000);
				}
			}); 		
			
				
		});
		
		$("input[name='sterlization']").click(function(){
			if(this.value == '1'){
				$("#sterliz").show();
			} else {
				$("#sterliz").hide();
			}			
		});
		
		
		$('#product_name').on('autocompletechange change', function () {
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + this.value, 
				dataType: 'json',
				success: function(response){
					var htm = '<option value="">Select model</option>';					
					$.each(response, function(i,res) {
						htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
					});		
					$("#input-model").html(htm);
				}
			}); 	
		}).change();
		
		
		$('#generic_product').on('autocompletechange change', function () {
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + this.value, 
				dataType: 'json',
				success: function(response){
					var htm = '<option value="">Select model</option>';					
					$.each(response, function(i,res) {
						htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
					});		
					$("#input-model-popup").html(htm);
				}
			}); 	
		}).change();
		

		$('#input-model').change(function() {
		  var val = $(this).val(); 		  
			$.ajax({
				url:'<?php echo site_url('getBatch');?>',
				method: 'post',
				data: 'product_id=' + val, 
				dataType: 'json',
				success: function(response){
					var htm = '<option value="">- Select Batch -</option>';					
					$.each(response, function(i,res) {
						htm += '<option value="'+ res.batch_id +'">'+ res.batch_no +'</option>';
					});
					htm += '<option value="add" style="color: #007bff;">Add Batch</option>';
					$("#input-batch").html(htm);
				}
			}); 	
		});

		$('#input-batch').change(function() {
			var val = $(this).val();
			$("#batch_id").val(val);
		});	
		
		$('#input-model-popup').change(function() {
		  var val = $(this).val(); 
		  $("#product_id").val(val);
		});
		
		
	});
</script>	
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
</div>