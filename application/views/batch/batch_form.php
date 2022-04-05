<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>

	<!-- <?php //if (validation_errors()) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
				<?php //echo validation_errors(); ?>
			</div>
		</div>
	<?php //endif; ?>
	<?php //if (isset($error)) : ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php //echo $error; ?>
			</div>
		</div>
	<?php //endif; ?> -->
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
<style>
.proinfo legend {
    width: 100% !important;
	
}
</style>
	 <script src="<?php echo base_url(); ?>assets/script.js"></script>
	<form role="form" method="post" action="<?php echo site_url('editBatch');?>/<?php echo $batch_id; ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				
				<fieldset class="proinfo">
					<legend style="text-align:left;font-weight: normal;">Product name:  <b><?php echo $batchinfo->product_name; ?></b> | Model: <b><?php echo $batchinfo->model; ?></b> | Batch No.: <b><?php echo $batchinfo->batch_no; ?></b></legend>
						<div class="row">
						
						<?php if($batch_challan == 0){ ?>
							<div class="col-sm-3">
							  <div class="form-group">
									<div class="control-label" >Product name</div> 
									<input type="text" name="product_name" value="<?php echo $batchinfo->product_name; ?>" id="product_name" class="form-control" required>									
							  </div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<div class="control-label" >Model</div> 
									<select name="model" id="input-model" class="form-control" required>
										
									</select>
								</div>
							</div>
						<?php } ?>
						
							<input type="hidden" name="product_id" value="<?php echo $batchinfo->product_id; ?>" id="pro_id">
							
							<div class="col-sm-3">
							  <div class="form-group">
									<div class="control-label" >IQC</div> 
									<input type="text" name="iqc" value="<?php echo $batchinfo->iqc; ?>" id="iqc" class="form-control" required>
									<div class="invalid-feedback">
										Please Enter IQC
									</div>
							  </div>
							</div>
							
							<div class="col-sm-3">
							  <div class="form-group">							
								<div class="row">
									<div class="col-sm-12">
										<div class="control-label" >&nbsp;</div>
										<div class="form-check form-check-inline">
										  <input class="form-check-input" type="radio" name="ce" id="ce1" value="0" <?php if($batchinfo->ce == '0'){ echo "checked"; } ?> >
										  <label class="form-check-label" >Non CE</label>
										</div>
										<div class="form-check form-check-inline">
										  <input class="form-check-input" type="radio" name="ce" id="ce1" value="1" <?php if($batchinfo->ce == '1'){ echo "checked"; } ?> >
										  <label class="form-check-label" >CE</label>
										</div>										
									</div>									
								</div>								
							  </div>
							</div>

							<div class="col-sm-3">
							  <div class="form-group">	
							   <div class="control-label" >MFG./Neutral Code</div>
								<input type="text" name="neutral_code" value="<?php echo $batchinfo->mfg_neutral_code; ?>" id="neutral_code" class="form-control" placeholder='NA if not applicable' required>
								<div class="invalid-feedback">
										Please Enter MFG./Neutral Code
								</div>
							  </div>
							</div>
							
						
							<?php
								$expDate = new DateTime($batchinfo->exp_date);
								$mgfDate = new DateTime($batchinfo->mfg_date);
							?>							
							<div class="col-sm-3">
							  <div class="form-group">	
							    <div class="control-label" >Mfg. Date</div>
								<input type="text" name="mfg_date" value="<?php echo $mgfDate->format('m/Y');  ?>"  id="mfg_date" class="form-control MMYYYY" placeholder="MM/YYYY" autocomplete="off" pattern="\d{1,2}/\d{4}" required>
								<div class="invalid-feedback">
										Please Select Mfg. Date
								</div>
							  </div>
							</div>							
							
							
							<div class="col-sm-3">
							  <div class="form-group">	
								<div class="control-label" >Exp. Date</div>
								<input type="text" name="exp_date" value="<?php echo $expDate->format('m/Y');  ?>"  id="exp_date" class="form-control MMYYYY" placeholder="MM/YYYY" autocomplete="off" pattern="\d{1,2}/\d{4}" required>
								<div class="invalid-feedback">
										Please Select Exp. Date
								</div>
							  </div>
							</div>
							
							<div class="col-sm-3">
							  <div class="form-group">	
								<div class="control-label" >Good received on</div>
								<?php $good_received_on = new DateTime($batchinfo->good_received_on); ?>
								<input type="text" name="good_received_on" value="<?php echo $good_received_on->format('Y-m-d'); ?>"  id="good_received_on" placeholder="DD/MM/YYYY" class="form-control date" required>
								<div class="invalid-feedback">
										Please Select Good received on Date
								</div>
							  </div>
							</div>
							
													
							<div class="col-sm-3">
							  <div class="form-group">							
								<div class="row">
									
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><b>Sterlization</b></label>
									</div>
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="radio" name="sterlization" value="1" <?php if($batchinfo->sterlization == '1'){ echo "checked"; } ?> > Yes</label>
									</div>
									<div class="col-sm-4 mt-4">
										<label class="radio-inline"><input type="radio" name="sterlization" value="0" <?php if($batchinfo->sterlization == '0'){ echo "checked"; } ?> > No</label>
									</div>									
								</div>
							  </div>
							</div>
							
							<div class="col-sm-3">
								<div class="row">
									<div class="col-sm-6">
										<!-- <input type="file" name="sterlization_file" class="form-control-file" id="sterlization_file"> -->
										<div id="sterliz">
											<input type="file" name="file" id="file" style="margin-top: 15px;">
											<!-- <div class="upload-area"  id="uploadfile">
												Upload file
											</div> -->
											<?php if(($batchinfo->sterlization == '1') && !empty($batchinfo->sterlization_file)) { ?>
												<a href="<?php echo base_url().'uploads/'.$batchinfo->sterlization_file; ?>"><?php echo $batchinfo->sterlization_file; ?></a>
											<?php } ?>
										</div>
									</div>									
								</div>								
							</div>					
							
						</div>
						
						<div class="row">
							<div class="col-sm-12">								
								<button type="submit" id="addbatch" class="btn btn-primary float-right"> Save</button>																
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
		
		var sterlization = '<?php echo $batchinfo->sterlization; ?>';
		if(sterlization == '1'){
			$("#sterliz").show();
		}
		
	});
</script>

<script>
    $(document).ready(function () {
        /* $('#product_name').typeahead({			
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
        });  */
		
		
		$('#product_name').autocomplete({
			'source': function(request, response) {
				var apiUrl='<?php echo site_url('getProductName'); ?>';
				var value = $('#product_name').val();
				$.ajax({
					url:apiUrl,
					data: 'name=' + value,
					type: "POST",
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {	
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item.product_name
							}
						}));
					}
				});
			},
			'select': function(event , ui) {
				$('#product_name').val(ui.item['label']);
				 var value = ui.item['label'];
				 var product_id = '<?php echo $batchinfo->product_id;  ?>';
				$.ajax({
					url:'<?php echo site_url('getProductModel');?>',
					method: 'post',
					data: 'name=' + encodeURIComponent(value), 
					dataType: 'json',
					success: function(response){
						var htm = '<option value="">Select model</option>';					
						$.each(response, function(i,res) {
							if(res.product_id == product_id){
								htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
							} else {
								htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
							}	
						});		
						$("#input-model").html(htm);
					}
				});	 	
			},
			minLength : 3
		});
		
		$('#product_name').on('autocompletechange change', function () {
			var product_id = '<?php echo $batchinfo->product_id;  ?>';
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + encodeURIComponent(this.value), 
				dataType: 'json',
				success: function(response){
					var htm = '<option value="">Select model</option>';					
					$.each(response, function(i,res) {
						if(res.product_id == product_id){
							htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
						} else {
							htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
						}							
					});		
					$("#input-model").html(htm);
				}
			}); 	
		}).change();
		
		$('#input-model').change(function() {
			$("#pro_id").val($(this).val());
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