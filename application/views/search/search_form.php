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
	 <!-- DataTables Example -->
	
  <div class="card mb-3">	
	<div class="card-body">	
		<style>
		    .auto ul{width:100%;padding-left:6px;}
			.auto ul{max-height: 200px;overflow-y: scroll};
			.form-group{margin-bottom:1rem;}
			.form-control{height:36px;padding-left:5px;}
		</style>
		<form name="advanceSearchForm" id="advanceSearchForm" role="form" data-toggle="validator" method="POST" action="" enctype="multipart/form-data">
		
		<div class="row justify-content-center">
			<div class="col-sm-3">
				<div class="form-group">
					<!-- <div class="control-label" >Search</div> -->					
					<select name="search_form" id="search_form" class="form-control">
						<option value="">Seclect Search Option </option>						
						<option value="customerSearch">Customer</option>						
						<option value="quotationSearch">Quotation</option>						
						<option value="orderSearch">Order</option>						
						<option value="challanSearch">Challan</option>						
						<option value="orderPendingProductSearch">Pending Orders - By Product</option>						
						<option value="orderPendingCustomerSearch">Pending Orders - By Customer</option>						
					</select>					
				</div>
			</div> 
			
			<div class="col-sm-3" id="allPendingBase">
				<div class="form-group">
					<!-- <div class="control-label" >Search</div> -->					
					<select name="basedOn" id="basedOn" class="form-control">					
						<option value="All">All</option>											
						<option value="Pending">Pending</option>											
					</select>					
				</div>
			</div>			
			<div style="padding:4px;" title="Hide search Box"><i class="searchSlide fa fa-chevron-circle-down" id="down"></i><i class="searchSlide fa fa-chevron-circle-up" id="up"></i></div>
		</div>	
			
			<div class="row" id="customer">	

				<div class="col-sm-3 quotation hideChallan">
					<div class="form-group">
						<div class="control-label" >Quotation No</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="titlequote" style="font-size:14px;"><?php echo "Q".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
									
									<?php echo financialList($dropdown='quotedropdown',$type='Q'); ?>
									
								</div>
							 </div>	
							 
							<input type="text" name="quote_id" style="width:50%;" value="<?php echo idFormat($this->input->get('quote_id')); ?>" id="quote_id" class="form-control">
							<input type="hidden" name="fqyear" value="" id="fqyear" class="form-control">						
						</div>
					</div>
				</div>
			
				
				<!-- <div class="col-sm-2 quotation hideChallan">
				  <div class="form-group">
					<div class="control-label">Quotation No</div> 
					<input type="text" name="quote_id" value="<?php if(!empty($this->input->get('quote_id'))){ echo $this->input->get('quote_id'); } ?>" id="quote_id" class="form-control" >
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without Q)</span>
					
				  </div>
				</div> -->
				
				
				<div class="col-sm-3 quotation">
					<div class="form-group">
						<div class="control-label" >Order No</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titleorder"><?php echo "O".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
																		
									<?php echo financialList($dropdown='orderdropdown',$type='O'); ?>
									
								</div>
							 </div>	
							 
							<input type="text" name="order_id" style="width:50%;" value="<?php echo idFormat($this->input->get('order_id')); ?>" id="order_id" class="form-control">
							<input type="hidden" name="foyear" value="" id="foyear" class="form-control">						
						</div>
					</div>
				</div>
				
				<!-- <div class="col-sm-2 quotation">
				  <div class="form-group">
					<div class="control-label">Order No</div> 
					<input type="text" name="order_id" value="<?php if(!empty($this->input->get('order_id'))){ echo $this->input->get('order_id'); } ?>" id="order_id" class="form-control">
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without O)</span>
				  </div>
				</div> -->
				
				<div class="col-sm-3 Challan">
					<div class="form-group">
						<div class="control-label" >Challan No</div> 
						<div class="input-group">
							<div class="input-group-prepend dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle title-text" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:14px;" id="titlechallan"><?php echo "C".$year = date('Y')."".substr((date('Y') +1),2); ?></button>
								
								<div class="dropdown-menu">
									
									<?php echo financialList($dropdown='challandropdown',$type='C'); ?>
									
								</div>
							 </div>	
							 
							<input type="text" name="challan_id" style="width:50%;" value="<?php echo idFormat($this->input->get('challan_id')); ?>" id="challan_id" class="form-control">						
							<input type="hidden" name="fcyear" value="" id="fcyear" class="form-control">						
						</div>
					</div>
				</div>
				
				<!-- <div class="col-sm-2 Challan">
				  <div class="form-group">
					<div class="control-label">Challan No</div> 
					<input type="text" name="challan_id" value="<?php if(!empty($this->input->get('challan_id'))){ echo $this->input->get('challan_id'); } ?>" id="challan_id" class="form-control">
					<span style="color:gray;font-size:11px;">(Ex. Enter only number without C)</span>
				  </div>
				</div> -->
				
				<div class="col-sm-2 Challan">
				  <div class="form-group">
					<div class="control-label">Docket No</div> 
					<input type="text" name="docket_no" value="<?php if(!empty($this->input->get('docket_no'))){ echo $this->input->get('docket_no'); } ?>" id="docket_no" class="form-control">
				  </div>
				</div>
				
				<div class="col-sm-2 Challan">
				  <div class="form-group">
					<div class="control-label">Invoice No</div> 
					<input type="text" name="invoice_no" value="<?php if(!empty($this->input->get('invoice_no'))){ echo $this->input->get('invoice_no'); } ?>" id="invoice_no" class="form-control">
				  </div>
				</div>
				
				
				<div class="col-sm-2 quotation penCust">
				  <div class="form-group">
					 <div class="control-label" >Currency</div> 
						<select name="currency_id" id="currency_id" class="form-control" >
							<option value=''>Select</option>
							<?php if(isset($currencies)){ ?>
							<?php foreach($currencies as $currency){ ?>								
								<option value="<?php echo $currency['id']; ?>"><?php echo $currency['currency']; ?></option>								
							<?php } ?>
						<?php } ?>
						</select>								
				  </div>
				</div>
				
				<div class="col-sm-2 quotation">
				  <div class="form-group">
						 <div class="control-label" >Created By</div> 
							<select name="user_id" class="form-control" >
								<option value=''>Select</option>
								<?php if(isset($users)){ ?>
								<?php foreach($users as $user){ ?>
									
									<option value="<?php echo $user['user_id']; ?>" >
									<?php echo $user['firstname']." ".$user['lastname']; ?></option>
									
								<?php } ?>
							<?php } ?>
							</select>								
					  </div>
				</div>
				
				<div class="col-sm-2 quotation">
				  <div class="form-group">
						 <div class="control-label" >Store</div> 
							<select name="store_id" class="form-control" >
								<option value=''>Select</option>
								<?php if(isset($stores)){ ?>
								<?php foreach($stores as $store){ ?>									
									<option value="<?php echo $store['store_id']; ?>" >	<?php echo $store['store_name']; ?></option>									
								<?php } ?>
							<?php } ?>
							</select>								
					  </div>
				</div>
				
				
				<div class="col-sm-2 quotation">
				  <div class="form-group">
					<div class="control-label">Start Date</div> 
					<input type="text" name="start_date" value="" id="start_date" class="form-control date" >					
				  </div>
				</div>
				
				<div class="col-sm-2 quotation">
				  <div class="form-group">
					<div class="control-label">End Date</div> 
					<input type="text" name="end_date" value="" id="end_date" class="form-control date" >					
				  </div>
				</div>

			
				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label">Customer Id</div> 
					<input type="text" name="customerid" value="<?php if(!empty($this->input->get('customerid'))){ echo $this->input->get(customerid); } ?>" id="customerid" class="form-control" >
					
				  </div>
				</div>	
				
				<div class="col-sm-2 customerFields">
				  <div class="form-group auto">
					<div class="control-label">Customer Name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" >
					
				  </div>
				</div>
				
				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label">Email</div> 
					<input type="text" name="email" value="<?php if(!empty($this->input->get('email'))){ echo $this->input->get('email'); } ?>" id="email" class="form-control" >
					
				  </div>
				</div>
				
				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label">Mobile</div> 
					<input type="text" name="mobile" value="<?php if(!empty($this->input->get('mobile'))){ echo $this->input->get('mobile'); } ?>" id="mobile" class="form-control" >
					
				  </div>
				</div>
				
			
				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label" >Country</div> 
					<?php $country_id = $this->input->get('country_id'); ?>
					<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" >
						<option value="">-- Seclect --</option>
						<?php foreach($countries as $country){ ?>
							<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>
						<?php } ?>
					</select>					
				  </div>
				</div>
				
				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label">State</div> 
						<select name="state_id" id="state_id" class="form-control" >
							
						</select>					
				  </div>
				</div>
				
				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label">City</div> 
					<input type="text" name="city" value="<?php if(!empty($this->input->get('city'))){ echo $this->input->get('city'); } ?>" id="city" class="form-control" >
					
				  </div>
				</div>	

				<div class="col-sm-2 customerFields">
				  <div class="form-group">
					<div class="control-label">Pin Code</div> 
					<input type="text" name="pin_code" value="<?php if(!empty($this->input->get('pin_code'))){ echo $this->input->get('pin_code'); } ?>" id="pin_code" class="form-control">
					
				  </div>
				</div>
				
				
				<div class="col-sm-2 pendingProduct">
				  <div class="form-group">
					<div class="control-label">Product Name / Description</div> 
					<input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" autocomplete="off" >					
				  </div>
				</div>
				<div class="col-sm-2 pendingProduct">
				  <div class="form-group">
					<div class="control-label">Model name</div> 
					<select name="model" id="input-model" class="form-control"></select>				
				  </div>
				</div>	
				
			</div>
			
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group"><br>
						<button type="button" id="submit" class="btn btn-primary float-right">Search</button>
					</div>
				</div>	
			</div>			
		</form>
		<br>
		
		<div>
			<div align="center"><img class="processing" src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading.."></div>
			<div class="table-responsive" id="searchResponce">
			</div>
		</div>
  </div>
</div>

<script>
    $(document).ready(function () {
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
		
		// Get Customer name autocomplete
		/* $('#company_name').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url:'<?php echo site_url('getCustomerName'); ?>',
					type: "POST",
					data: 'name=' + request,  
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {							
							return {								
								label: item['company_name'],
								value: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				if(item['value']){
					$('#company_name').val(item['label']);									
				}
			}
		}); */
		
		$('#company_name').autocomplete({
			'source': function(request, response) {
				var apiUrl='<?php echo site_url('getCustomerName'); ?>';
				var value = $('#company_name').val();
				$.ajax({
					url:apiUrl,
					data: 'name=' + value,  
					type: "POST",
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {	
							return {
								//label: item['company_name']+" # "+item['customer_id'],
								label: item['company_name'],
								id: item['customer_id']
							}
						}));
					}
				});
			},
			'select': function(event , ui) {
				$('#company_name').val(ui.item['label']);
			},
			minLength : 3
		});
		
		
		//Search Form
		 $("#allPendingBase").hide();
		 $(".customerFields").hide();
		 $(".quotation").hide();
		  $(".Challan").hide();
		 $(".processing").hide();
		 $(".pendingProduct").hide();
		 var base_url = '<?php echo site_url(); ?>';
		 
		$('#search_form').change(function() {
			$("#down").show();
			 var url = '';
			var search_option = $(this).val();
			
			 url = base_url +'/'+search_option;	
			 $("#searchResponce").html('');
			 if(search_option == 'customerSearch') {							 
				 $('#advanceSearchForm').attr('action', url);
				 $(".quotation").hide();
				 $(".customerFields").show();
				 $("#allPendingBase").hide();
				 $(".Challan").hide();
				 $(".pendingProduct").hide();
			 } else if(search_option == 'quotationSearch') {				 
				  $("#allPendingBase").show();
				  $('#advanceSearchForm').attr('action', url);
				  $(".quotation").show();
				  $(".customerFields").show();
				  $(".Challan").hide();
				  $(".pendingProduct").show();
			 } else if(search_option == 'orderSearch') {				 
				  $("#allPendingBase").show();
				  $('#advanceSearchForm').attr('action', url);
				  $(".quotation").show();
				  $(".customerFields").show();
				  $(".Challan").hide();
				  $(".pendingProduct").show();
			 }	else if(search_option == 'challanSearch') {				 
				  $("#allPendingBase").hide();
				  $('#advanceSearchForm').attr('action', url);
				  $(".quotation").show();
				  $(".Challan").show();
				  $(".customerFields").show();
				  $(".hideChallan").hide();
				  $(".pendingProduct").hide();
			 } else if(search_option == 'orderPendingProductSearch'){
				  $(".pendingProduct").show();
				  $("#allPendingBase").hide();
				  $('#advanceSearchForm').attr('action', url);
				  $("#customer").show();
				  $(".quotation").hide();
				  $(".Challan").hide();
				  $(".customerFields").hide();
			 } else if(search_option == 'orderPendingCustomerSearch'){
				  $(".pendingProduct").hide();
				  $("#allPendingBase").hide();
				  $('#advanceSearchForm').attr('action', url);
				  $("#customer").show();
				  $(".quotation").hide();
				  $(".Challan").hide();
				  $(".customerFields").show();
				  $(".penCust").show();
			 } else {
				 url = '';
				  $("#searchResponce").html('');
				  $('#advanceSearchForm').attr('action', url);
				  $(".customerFields").hide();
				  $(".quotation").hide();
				  $(".Challan").hide();
				  $("#allPendingBase").hide();
			 }				 
    	});
		
		$(".form-control").keypress(function(event) { 
			if (event.keyCode === 13) { 
				$("#submit").click();				
			} 
		}); 

		$('#submit').click(function() {
			$("#searchResponce").html('');
			var form = $("#advanceSearchForm");
			var urlAction = form.attr('action');
			var formData = $('#advanceSearchForm').serialize();		
			$.ajax({
				url: urlAction,
				type: "POST",
				data: formData,  
				dataType: 'json',
				beforeSend: function() {
					$(".processing").show();
				},
				success: function(response) {
				    $(".processing").hide();
					$("#searchResponce").html(response);
					$('#dataTable').DataTable({ 
                      "destroy": true, //use for reinitialize datatable
                      "pageLength": 25,
                      "autoWidth": false,
					  "searching": false,
					  "lengthChange": false
                    }); 
				}
			});
		});
		
		
		
		$(".searchSlide").hide();
		$(".searchSlide").click(function() {			
			var srcFrm = $('#search_form').val();
			var id = $(this).attr('id');			
			if(srcFrm != ''){
				$("#customer").slideToggle( "slow" );
				if(id == 'down'){
					$("#up").show();
					$("#down").hide();
				} else if(id == 'up'){
					$("#up").hide();
					$("#down").show();
				}
			}		  
		});
		
		
		/* $('#product_name').typeahead({			
            source: function (query, result) {				
                $.ajax({
                    url:'<?php echo site_url('getProductName'); ?>',
					data: 'name=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							//return item.product_name;
							return item.name;
                        }));
                    }
                });
            }
        }); */
		
		var productId = '<?php echo $this->input->get("model"); ?>';
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
							if(res.product_id == productId){
							htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
							} else {
								htm += '<option value="'+ res.product_id +'"  >'+ res.model +'</option>';
							}		
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
						if(res.product_id == productId){
							htm += '<option value="'+ res.product_id +'" selected>'+ res.model +'</option>';
						} else {
							htm += '<option value="'+ res.product_id +'"  >'+ res.model +'</option>';
						}						
					});		
					$("#input-model").html(htm);
				}
			}); 	
		}).change();
		
		
});    
</script>