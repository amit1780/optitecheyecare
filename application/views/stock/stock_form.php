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
	<?php endif; ?>
	<?php if (isset($error)) : ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php endif; ?>
	<style>
		#store_id-error{margin-top: 46px;position: fixed;}
		.color_blue{
			color:blue;
		}
	</style>
	<script>
		$(document).ready(function() {						
			$("#addstockform").validate({
				rules: {
					store_id: "required",					
					product_name: "required",					
					model: "required",				
					batch: "required",					
					qty: "required"					
				},
				messages: {
					store_id: "Please Select Store",
					product_name: "Please Select product",
					model: "Please Select model",
					batch: "Please Select batch",
					qty: "Please Enter Quntity"
					
				}
			})

			$('#submit').click(function() {
				$("#addstockform").valid();
			});
		});
	</script>
	
	<form role="form" method="post" action="<?php echo site_url('addStock');?>" enctype="multipart/form-data"  class="needs-validation" id="addstockform">
		<div class="row" style="margin:0px;">
			<div class="col-sm-12">
				
				<fieldset class="proinfo">
					<legend>Add Stock</legend>
						<div class="row">
								<div class="col-sm-12">	
									<?php $i=0; foreach($stores as $store){ ?>										
										<div class="form-check form-check-inline">
										  <!-- <input class="form-check-input storeId" type="radio" name="store_id" value="<?php //echo $store['store_id']; ?>" required <?php //if($i==0){ echo "checked"; } ?>> --> 
										  <input class="form-check-input storeId" type="radio" name="store_id" value="<?php echo $store['store_id']; ?>" required>  
										  <label class="form-check-label"><?php echo $store['store_name']; ?></label>
										</div>
									<?php $i++; } ?>
									&nbsp;&nbsp; | &nbsp;&nbsp;<span>Pack Unit: <b class='color_blue' id="unit_name"></b></span>&nbsp;&nbsp; | &nbsp;&nbsp;<span>Total Stock: <b class='color_blue' id="InStock"></b></span>&nbsp;&nbsp; | &nbsp;&nbsp;<span><span>GST: <b class='color_blue' id="gst"></b></span>&nbsp;&nbsp; | &nbsp;&nbsp;<span>Batch No: <b class='color_blue' id="batchNo"></b> &nbsp;&nbsp; | &nbsp;&nbsp;In stock : <b class='color_blue' id="available"></b> &nbsp;&nbsp;|&nbsp;&nbsp; Pending : <b class='color_blue' id="pending"></b> </span>
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
							
							<input type="hidden" name="product_id" value="" id="pro_id">
						
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
	<script>
		$(document).ready(function() {
			jQuery.validator.addMethod("greaterThan", 
			function(value, element, params) {
				
				if (!/Invalid|NaN/.test(new Date(value))) {
					return new Date(value) > new Date($(params).val());
				}
				
				var date1 = new Date(value);
				var date2 = new Date($(params).val());
				
				return isNaN(value) && isNaN($(params).val()) 
					|| (date1 > date2); 
			},'Must be greater than {0}.');
			
			$("#addbatchform").validate({
				rules: {
					iqc: "required",
					generic_product: "required",
					model_no: "required",
					brand_name: "required",
					batch_size: "required",
					batch_no: "required",
					neutral_code: "required",
					mfg_date: "required",
					exp_date: {
						 required: true,
						 greaterThan: "#mfg_date"
						},
					good_received_on: "required"
				},
				messages: {
					iqc: "Please Enter IQC",
					generic_product: "Please Select Product Name",
					model_no: "Please Select Model",
					brand_name: "Please Enter Brand Name of Product",
					batch_size: "Please Enter Batch Size",
					batch_no: "Please Enter Batch Number",
					neutral_code: "Please Enter MFG./Neutral Code",
					mfg_date: "Please Select Mfg. Date",
					exp_date: {
							required:"Please Select Exp. Date",
							greaterThan: "Please Select Exp. Date greater Than Mfg. Date"
						},
					good_received_on: "Please Select Goods received on Date"
				}
			})

			/* $('#addbatch').click(function() {
				$("#addbatchform").valid();
			}); */
		});
	</script>
	
	
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width:700px;">		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" style="width:100%;float:left;">Add Batch</h4>			  
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div style="width:100%;float:left;">
				<span style="padding:10px;" >Product name:&nbsp;&nbsp;<span id="popup_proname"></span></span>
				<span style="padding:10px;">Model: &nbsp;&nbsp;<span id="popup_model"></span></span></div>
			<div id="mess"></div>
			<div class="modal-body" style="padding:2rem;">
					<form method="post" action="" enctype="multipart/form-data" id="addbatchform">
						<input type="hidden" name="stock_popup" value="stock_popup">
						<input type="hidden" name="product_id" value="" id="product_id">
						<input type="hidden" name="store_id" value="" id="storeid">
						<input type="hidden" name="proexpiry_year" value="" id="proexpiry_year">
						<div class="row">						
							<div class="col-sm-6">
							  <div class="form-group">
									<div class="control-label" >IQC</div> 
									<input type="text" name="iqc" value="<?php if(!empty($iqc)){ echo $iqc; } ?>" id="input-iqc" class="form-control" required>
							  </div>
							</div>							
							<div class="col-sm-6">
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
							
							<div class="col-sm-6">
							  <div class="form-group">		
								  <div class="control-label" >Batch No</div>
								<input type="text" name="batch_no" value="<?php if(!empty($batch_no)){ echo $batch_no; } ?>"  id="batch_no" class="form-control" required>
							  </div>
							</div>
							
							<div class="col-sm-6">
							  <div class="form-group">	
							   <div class="control-label" >MFG./Neutral Code</div>
								<input type="text" name="neutral_code" value="<?php if(!empty($neutral_code)){ echo $neutral_code; } ?>" id="neutral_code" class="form-control" placeholder='NA if not applicable' required>
							  </div>
							</div>
							
							<div class="col-sm-3">
							  <div class="form-group">	
							    <div class="control-label" >Mfg. Date</div>
								<input type="text" name="mfg_date" value="<?php if(!empty($mfg_date)){ echo $mfg_date; } ?>"  id="mfg_date" class="form-control MMYYYY" placeholder="MM/YYYY" autocomplete="off" pattern="\d{1,2}/\d{4}" required>
							  </div>
							</div>
							<div class="col-sm-3">
							  <div class="form-group">	
								<div class="control-label" >Exp. Date</div>
								<input type="text" name="exp_date" value="<?php if(!empty($exp_date)){ echo $exp_date; } ?>"  id="exp_date" class="form-control MMYYYY" placeholder="MM/YYYY" autocomplete="off" pattern="\d{1,2}/\d{4}" required>
							  </div>
							</div>
							
							<div class="col-sm-6">
							  <div class="form-group">	
								<div class="control-label" >Goods received on</div>
								<input type="text" name="good_received_on" value="<?php if(!empty($good_received_on)){ echo $good_received_on; } ?>"  id="good_received_on" placeholder="DD/MM/YYYY" class="form-control date" required>

							  </div>
							</div>	
							
							<div class="col-sm-6">
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
						
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-6">
										<!-- <input type="file" name="sterlization_file" class="form-control-file" id="sterlization_file"> -->
										<div id="sterliz">
											<input type="file" name="file" id="file" style="margin-top: 15px;">
											<!-- <div class="upload-area"  id="uploadfile">
												Upload file
											</div> -->
										</div>
									</div>
									<div class="col-sm-6 mt-2">
										<button type="button" id="addbatch" value="Validate" class="btn btn-primary float-right"> Add Batch</button>
									</div>
								</div>								
							</div>											
						</div>					
					</form>
			</div>
		  </div>
		</div>
	</div>
	
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

})
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
							//return item.name;
                        }));

                    }
                });
            }
        }); */
		
		
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
				$.ajax({
					url:'<?php echo site_url('getProductModel');?>',
					method: 'post',
					data: 'name=' + encodeURIComponent(value), 
					dataType: 'json',
					success: function(response){
						var htm = '<option value="">Select model</option>';					
						$.each(response, function(i,res) {
							htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
						});		
						$("#input-model").html(htm);
					}
				});	 	
			},
			minLength : 3
		});
		
		
		$('#product_name').on('autocompletechange change', function () {
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + encodeURIComponent(this.value), 
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
        
        /* $('#generic_product').typeahead({			
            source: function (query, result) {
                $.ajax({
                    url:'<?php echo site_url('getProductName'); ?>',
					data: 'name=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item.product_name;
							//return item.name;
                        }));

                    }
                });
            }
        }); */
		
		/* $('#generic_product').on('autocompletechange change', function () {
			$.ajax({
				url:'<?php echo site_url('getProductModel');?>',
				method: 'post',
				data: 'name=' + encodeURIComponent(this.value), 
				dataType: 'json',
				success: function(response){
					var htm = '<option value="">Select model</option>';					
					$.each(response, function(i,res) {
						htm += '<option value="'+ res.product_id +'">'+ res.model +'</option>';
					});		
					$("#input-model-popup").html(htm);
				}
			}); 	
		}).change(); */
    });    
</script>
<script>
	$(document).ready(function(){	
		$('#input-batch').on('change', function() {
			var value = $(this).val();
			if(value == ''){
				$("#batchNo").html('');
				$("#available").html('');
				$("#pending").html('');
				
				$("#mfg_date_s").val('');
				$("#exp_date_s").val('');
				
				return false;
			}
			var product_name = $("#product_name").val();
			var product_model_id = $("#input-model").val();			
			var product_model = $("#input-model option:selected").text();
			var store_id = $('input[name=store_id]:checked').val();
			if(store_id == undefined){
				alert("Please Select Store");
				return false;
			} 
			if(product_name == ''){
				alert("Please select Product.");				
			} else if(product_model_id == ''){ 
				alert("Please select Model.");
			} else {		
				if(value == 'add'){
					var prname = '<b>'+product_name+'</b>';
					var prmodel = '<b>'+product_model+'</b>';
					$("#popup_proname").html(prname);					
					$("#popup_model").html(prmodel);
					
					$("#myModal").modal();
				}else if(value != ''){
					$.ajax({
						url:'<?php echo site_url('getBatchInfo');?>',
						method: 'post',
						data: 'batch_id=' + this.value + '&store_id=' + store_id + '&product_id=' + product_model_id,
						dataType: 'json',
						success: function(response){
							var mfg_date = response.mfg_date.split("-");
							var exp_date = response.exp_date.split("-");
							var approve_qty = 0;
							var pending_qty = 0;
							if(response.approve_qty){ 
								approve_qty = response.approve_qty;								
							} 
							if(response.pending_qty){ 
								pending_qty = response.pending_qty;								
							} 
							
							$("#batchNo").html(response.batch_no);
							$("#available").html(approve_qty);
							$("#pending").html(pending_qty);
							
							$("#mfg_date_s").val(mfg_date[1]+'/'+mfg_date[0]);
							$("#exp_date_s").val(exp_date[1]+'/'+exp_date[0]);
						}
					}); 
				}				
			}			
		});
	});	
	$(document).ready(function(){		
		$("#sterliz").hide();		
		$("#addbatch").click(function(){
			
			//$("#addbatchform").valid();
			if(! $("#addbatchform").valid()) return false;
			
			var mfg_date = $("#mfg_date").val();
			var exp_date = $("#exp_date").val();
			
			var data_form = $('#addbatchform').serialize();			
			$.ajax({
				url:'<?php echo site_url('addBatch');?>',
				method: 'post',
				data: data_form,
				dataType: 'json',
				success: function(response){
					if(response.batch_id){
						$('#addbatch').prop('disabled', true);
					}
					
					if(response.error!=''){
					  var htm = '<div class="alert alert-danger" role="alert">'+response.error+'</div>';
					  $("#mess").html(htm);  
					  
					}else{
    					var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
    					$("#mess").html(htm);
					
    					var html = '<option value="'+ response.batch_id +'">'+ response.batch_no +'</option>';					
    					$("#input-batch option").eq(-2).after(html);
    					$('#batch_id').val(response.batch_id);
    					$('#input-batch option[value='+response.batch_id+']').attr('selected', 'selected');
    					
    					$("#mfg_date_s").val(mfg_date);
    					$("#exp_date_s").val(exp_date);
    					
    					setTimeout(function(){
    						$("#myModal .close").click();
    						$("#mess").html('');
    					}, 2000);
					}
					
					/*var htm = '<div class="alert alert-success" role="alert">Successfully Added.</div>';
					$("#mess").html(htm);
					var html = '<option value="'+ response.batch_id +'">'+ response.batch_no +'</option>';					
					$("#input-batch option").eq(-2).after(html);
					$('#batch_id').val(response.batch_id);
					$('#input-batch option[value='+response.batch_id+']').attr('selected', 'selected');
					
					$("#mfg_date_s").val(mfg_date);
					$("#exp_date_s").val(exp_date);
					
					setTimeout(function(){
						$("#myModal .close").click();
						$("#mess").html('');
					}, 2000);*/
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

		$('#input-model').change(function() {
			
			$("#batchNo").html('');
			$("#available").html('');
			$("#pending").html('');			
			$("#mfg_date_s").val('');
			$("#exp_date_s").val('');
			
			var val = $(this).val(); 	
			$("#pro_id").val(val);
			$("#product_id").val(val);
			var store_id = $('input[name=store_id]:checked').val();
			if(store_id == undefined){
				alert("Please Select Store");
				return false;
			} 
			
			$.ajax({
				url:'<?php echo site_url('getBatch');?>',
				method: 'post',
				data: 'product_id=' + val + '&store_id=' + store_id, 
				dataType: 'json',
				success: function(response){					
					var htm = '<option value="">- Select Batch -</option>';					
					$.each(response.batch, function(i,res) {
						htm += '<option value="'+ res.batch_id +'">'+ res.batch_no +'</option>';
					});
					htm += '<option value="add" style="color: #007bff;">Add Batch</option>';
					$("#input-batch").html(htm);
					$("#proexpiry_year").val(response.expiry_year);
					$("#unit_name").html(response.unit_name);
					$("#InStock").html(response.stock_in);
					$("#gst").html(response.gst +' % ');
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
		
		var store_id = $('input[name=store_id]:checked').val();
		$('#storeid').val(store_id);
		$('.storeId').click(function () {
           store_id = $(this).val();		  
			$('#storeid').val(store_id);
			var product_id = $("#input-model option:selected").val();
			/* if(product_id == ''){
				alert("Please Select product Model");
				return false;
			} else */ 
			if(product_id) {
				var batch_id = $("#input-batch").val();				
				$.ajax({
					url:'<?php echo site_url('getStockInStoreBase');?>',
					method: 'post',
					data: 'product_id=' + product_id + '&store_id=' + store_id + '&batch_id=' + batch_id, 
					dataType: 'json',
					success: function(response){
						$("#InStock").html(response.stock_in);
						var approve_qty = 0;
						var pending_qty = 0;
						var batchNo = '';
						if(response.approve_qty){ 
							approve_qty = response.approve_qty;								
						} 
						if(response.pending_qty){ 
							pending_qty = response.pending_qty;								
						} 
						if(response.batch_no){
							batchNo = response.batch_no;
						}
						$("#batchNo").html(batchNo);
						$("#available").html(approve_qty);
						$("#pending").html(pending_qty);
					}
				});
			}
       });
	   
	});
	
	$(document).ready(function(){
		$('#mfg_date').on('change', function() {
			var expiry_year = $("#proexpiry_year").val();
			if(expiry_year > 0){
				var mfg_date = this.value;
				var results = mfg_date.split("/");
				var mfg_month = results[0];
				var mfg_year = results[1];
				var lstYer = parseInt(mfg_year) + parseInt(expiry_year);
				
				mfg_month = parseInt(mfg_month) - 1;
				if(mfg_month == 0){
					mfg_month = 12;					
					lstYer = parseInt(lstYer) - 1;
				}				
				var exp_date = mfg_month+'/'+lstYer;	
				
				$("#exp_date").val(exp_date);
			}			
		});
		
		
		$("#product_name").keyup(function(){				
			if(this.value == ''){
				$("#input-batch").html('');
				$("#proexpiry_year").val('');
				$("#unit_name").html('');
				$("#gst").html('');
				$("#InStock").html('');				
				$("#batchNo").html('');
				$("#available").html('');
				$("#pending").html('');			
				$("#mfg_date_s").val('');
				$("#exp_date_s").val('');
			}
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
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
</div>