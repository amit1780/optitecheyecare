<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">		
	<div class="page_heading">			
		<h1 style="float: left;">Goods Return</h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
	
	<?php if (isset($error)) { ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php } ?>
	
	<script>
		$(document).ready(function() {						
			$("#quotationform").validate({
				rules: {
					customer_name1: "required",				
					//quotation_date: "required",				
					user_id: "required",				
					Currency: "required",				
					Bank: "required",				
				},
				messages: {
					product_name: "Please Select product",
					model: "Please Select model",
					batch: "Please Select batch",
					qty: "Please Enter Quntity"
					
				}
			})

			$('#submit').click(function() {
				$("#quotationform").valid();
			});
		});
	</script>
	<style>
		.borderbox{border:2px solid gray;}
	</style>
	
	<div class="borderbox" style="padding:15px;">
		<form role="form" class="needs-validation"  method="get" action="<?php echo site_url('addReturns');?>">
			<div class="row">
				<div class="col-sm-12">			
					<div class="row" >				
						<div class="col-sm-3">						  
						  <div class="form-group">
							 <div class="control-label" >Challan No.</div> 
							 <input type="text" name="challan_no" value="<?php if(isset($challan_no)){ echo $challan_no;} ?>" id="challan_id" class="form-control" autocomplete='off'>
							 <span style="color:gray;font-size:11px;">(Ex. Enter only number without C)</span>								
						  </div>
						</div>
						<div class="col-sm-3">						  
						  <div class="form-group">
							 <div class="control-label" >Invoice No</div> 
							 <input type="text" name="invoice_no" value="<?php if(isset($challanInfo->invoice_no)){ echo $challanInfo->invoice_no;} ?>" id="invoice_no" class="form-control" autocomplete='off'>								
						  </div>
						</div>
						<div class="col-sm-3">						  
						  <div class="form-group">
							 <div class="control-label" >Product</div> 
							 <input type="text" name="product_name" value="<?php if(!empty($this->input->get('product_name'))){ echo $this->input->get('product_name'); } ?>" id="product_name" class="form-control" >								
						  </div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="control-label">Model</div> 
								<select name="model" id="input-model" class="form-control"></select>
							</div>
						</div>
						
						<div class="col-sm-3">						  
						  <div class="form-group">
							 <div class="control-label" >Customer</div> 
							 <input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" autocomplete='off'>								
							 <input type="hidden" name="customer_id" value="<?php if(!empty($this->input->get('customer_id'))){ echo $this->input->get('customer_id'); } ?>" id="customer_id" class="form-control" autocomplete='off'>								
						  </div>
						</div>
						<div class="col-sm-9">					 
							<button type="submit" class="btn btn-primary float-right"> Search</button>						  
						</div>				
					</div>			
				</div>
			</div>			
		</form>
		
		<div class="row">
			<div class="col-sm-12">
				Order No:&nbsp;<b><span id="order_id"><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challanInfo->order_id; ?>"><?php if(isset($challanInfo->order_id)){ echo getOrderNo($challanInfo->order_id); } ?></a></span></b>
				&nbsp;&nbsp;&nbsp;Invoice No:&nbsp;<b><span id="invoiceNo"><?php if(isset($challanInfo->invoice_no)){ echo $challanInfo->invoice_no; } ?></span></b>
				<?php $order_date = new DateTime($orderInfo->order_date); ?>
				
				&nbsp;&nbsp;&nbsp;Order Date:&nbsp;<b id="order_date"><?php if($orderInfo->order_date){ echo $order_date->format('d-m-Y'); }  ?></b>
				&nbsp;&nbsp;&nbsp;Customer Name:&nbsp;<b id="customerName"><a target="_blank" href="<?php echo site_url('customerView'); ?>/<?php echo $challanInfo->customer_id; ?>" ><?php echo $orderInfo->customer_name;  ?></a></b>
			</div>
		</div>
		
		<!-- <form role="form" class="needs-validation" id="quotationform" method="post" action="<?php //echo site_url('addReturns');?>" enctype="multipart/form-data" > -->
		<form role="form" class="needs-validation" id="quotationform" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" >
		
			<input type="hidden" name="order_id" id="orderid" value="<?php echo $challanInfo->order_id; ?>">
			<input type="hidden" name="challan_id" id="challanid" value="<?php echo $challan_no; ?>">
			<input type="hidden" name="invoiceno" value="<?php echo $challanInfo->invoice_no; ?>">
			
			<table class="table-sm table-bordered" id="protable" width="100%" cellspacing="0">
				<tr>					
					<th class="" style="width:10%;">Challan No</th>
					<th class="" style="width:10%;">Store</th>
					<th class="" style="width:40%;">Product Description</th>					
					<th class="" style="width:10%;">Batch No.</th>
					<th class="" style="width:10%;">Exp. Date</th>
					
					<th class="" style="width:10%;">Qty Sold</th>
					<th class="" style="width:10%;">Qty Returns</th>
					<th class="" style="width:10%;">Return Date</th>
					
				</tr>			
				<?php foreach($challanProInfo as $challanPro){ ?>
				<?php //$expDate = new DateTime($challanIn['batch_exp_date']); 
				      $expDate = date('m/Y',strtotime($challanPro['batch_exp_date']));
						/* if(($challanPro['return_datetime'] != '0000-00-00 00:00:00') || ($challanPro['return_qty'] != '')){
							continue;
						} */
				?>				
					<input type="hidden" name="product_id[]" value="<?php echo $challanPro['challan_pro_id']; ?>" >					
					<tr> 
						<td class="" style=""><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challanPro['challan_id']; ?>" ><?php echo getChallanNo($challanPro['challan_id']); ?></a></td>
						<td class="" style=""><?php echo $challanPro['store_name']; ?></td>
						<td class="" style=""><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $challanPro['product_id']; ?>"><b><?php echo $challanPro['pro_model']; ?></b></b> | <?php echo $challanPro['pro_description']; ?></a></td>
						
						<td class="" style=""><?php echo $challanPro['batch_no']; ?></td>
						<td class="" style=""><?php echo $expDate;//->format('m-Y'); ?></td>
						<!-- <td class="" style=""><?php //echo $challanPro['invoice_no']; ?></td> -->
						<input type="hidden" name="sold_qty[]" value="<?php echo $challanPro['qty']; ?>" style="width:100px;" autocomplete="off">
						<td class="" style=""><?php echo $challanPro['qty']; ?></td>
						<td class="" style=""><input type="text" name="qty_returns[]" class="qty_returns" value="<?php if($challanPro['return_qty']){ echo $challanPro['return_qty'];} else { echo "0"; } ?>" style="width:100px;" autocomplete="off"></td>
						<?php
							if($challanPro['return_datetime'] == '0000-00-00 00:00:00'){
								$challanPro['return_datetime'] = '';
							}
						?>
						<td class="" style=""><input type="text" name="returns_date[]" value="<?php if($challanPro['return_datetime']){ echo $challanPro['return_datetime']; } ?>" style="width:100px;" class="date" autocomplete="off"></td>				
					</tr>
				<?php } ?>
			</table>
			<br>
			<div class="row">	
				<div class="col-sm-12">
					<div class="form-group">
						<div class="control-label" >Return Note</div> 
						<textarea name="return_note" class="form-control"><?php	if($returnNotes->return_note){ echo $returnNotes->return_note;}	?></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">	
				<div class="col-sm-12">
					<div class="form-group">
						<div class="control-label" >Reason For no Invoice</div> 
						<textarea name="invoice_reason" class="form-control"><?php	if($returnNotes->invoice_reason){ echo $returnNotes->invoice_reason;}	?></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">	
				<div class="col-sm-12">	<br>					 
					<button type="submit" id="submit" class="btn btn-primary float-right"> Save</button>						  
				</div>
			</div>
		</form>
		
	</div>
</div>
<script>
$(document).ready(function() {	
	// Date time
	var date_input=$('.date'); //our date input has the name "date"
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input.datepicker({
		dateFormat: 'yy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
		changeMonth: true,
		changeYear: true
	});
	// End Date time
	
	$('.qty_returns').keyup(function() {
		var qty_sold = $(this).closest('tr').find("td:eq(3)").html();
		var input_qty = this.value;		
		if(parseInt(input_qty) > parseInt(qty_sold)){
			alert("Please Enter Sold Qty Or Less then");
		}
	});	
	
	
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
			$('#customer_id').val(ui.item['id']);
		},
		minLength : 3
	});
	
	var productId = '<?php echo $this->input->get("model"); ?>';
	var customer_id = '<?php echo $this->input->get("customer_id"); ?>';
	
	if(productId != '' || customer_id != ''){
		$('#invoice_no').val('');
		$('#challan_no').val('');
		$('#order_id').html('');
		$('#invoiceNo').html('');
		$('#order_date').html('');
		$('#customerName').html('');
	}
	
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