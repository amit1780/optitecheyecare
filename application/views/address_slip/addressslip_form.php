<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$productToQty = array();
?>
<div class="container-fluid">
		
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">				
				<h1 style="float: left;">Address Slip</h1> <?php echo $this->breadcrumbs->show(); ?>
			</div>
			<div class="col-sm-6">
				<div class="float-right">
					<!-- <a href="<?php echo site_url('addressSlipList'); ?>/<?php echo $getaddressslip->addressslip_id; ?>" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="top" title="Address Slip Print List"> <i class="fa fa-list"></i></a> -->
				</div>
			</div>
		</div>
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
	
	<?php if (isset($error)) { ?>
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
		</div>
	<?php } ?>
	
	<!-- <script>
		$(document).ready(function() {						
			$("#addressSlipForm").validate({
				rules: {
					weight_all: "required",				
									
				},
				messages: {
					weight_all: "Please Select product",					
				}
			})

			$('#submit').click(function() {
				$("#addressSlipForm").valid();
			});
		});
	</script> -->
	<style>
		.borderbox{border:2px solid gray;}
	</style>
	
	<div class="borderbox" style="padding:15px;">
		<form role="form" class="needs-validation" id="addressSlipForm" data-toggle="validator"  method="Post" action="<?php echo site_url('addressslip');?>?challan_id=<?php echo $challan_id; ?>" enctype="multipart/form-data" novalidate>
			<input type="hidden" name="challan_id" value="<?php echo $challan_id ?>" >	
			<input type="hidden" name="addressslip_id" value="<?php echo $getaddressslip->addressslip_id; ?>" >	
			<div class="row">
				<div class="col-sm-12">			
					<div class="row" >				
						<div class="col-sm-1">						  
						  <div class="form-group">
							 <div class="control-label" >Packages</div> 
								<select name="no_of_packs" id="no_of_packs" class="form-control" >
									<option value=""></option>
									<?php for($i=1; $i<=20; $i++){ ?>
										<option value="<?php echo $i; ?>" <?php if($getaddressslip->no_of_package == $i){ echo 'selected="selected"'; } ?> ><?php echo $i; ?></option>
									<?php } ?>
								</select>							
						  </div>
						</div>
						<div class="col-sm-2">						  
						  <div class="form-group">
							 <div class="control-label" >Packages Identical</div> 
								<label class="radio-inline">
									<input type="radio" name="package_identical" value="1" <?php if ($getaddressslip->package_identical == 1) { echo "checked='checked'"; } ?> >Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="package_identical" value="0" <?php if ($getaddressslip->package_identical == 0) { echo "checked='checked'"; } ?>>No
								</label>
															
						  </div>
						</div>	
						
						<div class="col-sm-2" id="weight_section">						  
						  <div class="form-group">
							 <div class="control-label" >Weight</div> 
							 <input type="text" name="weight_all" value="<?php if ($getaddressslip->weight) { echo $getaddressslip->weight; } ?>" id="weight_all" class="form-control" autocomplete='off'>								
						  </div>
						</div>						
						<div class="col-sm-1">						  
							<div class="form-group">
								<div class="control-label" >Unit</div> 
								<select name="weight_unit" id="weight_unit" class="form-control" style="padding:0px;">
									<!-- <option value="">-- Select --</option>	-->								
									<option value="kg" <?php if($getaddressslip->weight_units == 'kg'){ echo 'selected="selected"'; } ?>>Kg</option>
									<!-- <option value="gm" <?php if($getaddressslip->weight_units == 'gm'){ echo 'selected="selected"'; } ?>>Gm</option> -->									
								</select>																
							</div>
						</div>	
						
						<div class="col-sm-2">						  
							<div class="form-group">
								<div class="control-label" >Address Type</div> 
								<select name="address_type" id="address_type" class="form-control">
									<option value="">-- Select --</option>									
									<option value="B" <?php if($getaddressslip->address_type == 'B'){ echo 'selected="selected"'; } ?>>Billing Address</option>
									<option value="S" <?php if($getaddressslip->address_type == 'S'){ echo 'selected="selected"'; } ?>>Shipping Address</option>									
								</select>																
							</div>
						</div>	
						
						<div class="col-sm-4">						  
							<div class="form-group">
								<div class="control-label" >Address</div>
								
								<textarea id="address_billto" class="form-control" disabled><?php echo $getOrderDetails->billing_details ?></textarea>
								<textarea id="address_shipto" class="form-control" disabled><?php echo $getOrderDetails->shipping_details; ?></textarea>															
																							
							</div>
						</div>
						
					</div>			
				</div>
			</div>			
			<div class="row clearfix">
				<div class="col-md-12 table-responsive">
					<table class="table table-bordered table-hover table-sortable" id="tab_logic">
						<thead>
							<tr >
								<th class="text-center">
									Package No.
								</th>
								<th class="text-center">
									Qty
								</th>
								<th class="text-center">
									Weight (<span id="unit_1"></span>)
								</th>
								<!-- <th class="text-center">
									ChallanQty
								</th> -->
								<th class="text-center">
									Product Description
								</th>									
								<th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
									<a id="add_row" class="btn btn-primary" style="color: white;">Add Row</a>
								</th>
							</tr>
						</thead>
						<tbody id="priprotable">
						
							
							<?php if($getaddressslip->addressslip_id && $getaddressslip->no_of_package){ ?>
							<?php  foreach($challanInfoProduct as $challanProduct){ 												
								$challanQty[$challanProduct['product_id']] =$challanProduct['qty'];	
							}										
							?>
								<?php $k=0; foreach($getAddressSliPackages as $addressSliPackage) {  $productToQty = array(); ?>
								
									<tr  data-id="<?php echo $k; ?>" class="trrow hidden">
										<td data-name="pack[]">
											<select name="pack[]" class="form-control packdropdown">
												<option value="">Select</option>
												<?php for($j=1; $j<=$no_of_pack; $j++){ ?>
													<option value="<?php echo $j; ?>" <?php if($addressSliPackage['package_no'] == $j){ echo 'selected="selected"'; } ?> ><?php echo $j; ?></option>
												<?php } ?> 
											</select>											
										</td>
										<td data-name="qty[]">
											<input type="text" name="qty[]" placeholder='Qty' value="<?php if($addressSliPackage['qty']){ echo $addressSliPackage['qty']; } ?>" class="form-control qtyy"/>
										</td>
										<td data-name="weight[]">
											<input type="text" name="weight[]" placeholder='Weight' value="<?php if($addressSliPackage['weight']){ echo $addressSliPackage['weight']; } ?>" class="wgt form-control"/>
										</td>
										
										<!-- <td data-name="challan_qty[]">
											<span class="challan_qty"><?php $pid=$addressSliPackage['product_id']; echo $challanQty[$pid]; ?></span>
										</td> -->
										
										<td data-name="product[]">
											<select name="product[]" class="form-control proDes">
												<option value="">-- Select --</option>
												<?php  foreach($challanInfoProduct as $challanProduct){ 
												
												$productToQty[] = array(
													'key' 	=> $challanProduct['product_id'],
													'value' => $challanProduct['qty']
												);											
												
												?>
												<option title="Challan Qty-<?php echo $challanProduct['qty']; ?>"  value="<?php echo $challanProduct['product_id']; ?>"  <?php if($addressSliPackage['product_id'] == $challanProduct['product_id']){ echo 'selected="selected"'; } ?> ><b><?php echo $challanProduct['pro_model']; ?></b> | <?php echo $challanProduct['pro_des']; ?></option>	
												<?php } ?>											
											</select>
										</td>
										<td data-name="del">											
											<button type="button" name="del<?php echo $k; ?>" class='btn btn-danger glyphicon glyphicon-remove row-remove'><span aria-hidden="true">×</span></button>											
										</td>
									</tr>	
								<?php $k++; } ?>								
							<?php } else { ?>
							
									<tr  data-id="0" class="trrow hidden">
										<td data-name="pack[]">
											<select name="pack[]" class="form-control packdropdown">
												
											</select>
										</td>
										<td data-name="qty[]">
											<input type="text" name="qty[]" placeholder='Qty' class="form-control qtyy"/>
										</td>
										<td data-name="weight[]">
											<input type="text" name="weight[]" placeholder='Weight' class="wgt form-control"/>
										</td>
										
										<!-- <td data-name="challan_qty[]">
											<span class="challan_qty"></span>
										</td> -->
										
										<td data-name="product[]">
											<select name="product[]" class="form-control proDes2">
												<option value="">-- Select --</option>
												<?php foreach($challanInfoProduct as $challanProduct){ 
													
													$productToQty[] = array(
														'key' 	=> $challanProduct['product_id'],
														'value' => $challanProduct['qty']
													);	
												
												?>
												<option title="Challan Qty-<?php echo $challanProduct['qty']; ?>" value="<?php echo $challanProduct['product_id']; ?>"><b><?php echo $challanProduct['pro_model']; ?></b> | <?php echo $challanProduct['pro_des']; ?></option>	
												<?php } ?>											
											</select>
										</td>
										<td data-name="del">
											<button type="button" name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'><span aria-hidden="true">×</span></button>
										</td>
									</tr>
								
							<?php } ?>
							
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">	<br>					 
					<button type="submit" id="submit" class="btn btn-primary float-right"> Save</button>						  
				</div>
			</div>			
		</form>		
	</div>
	
	
	<div class="card mb-3">	
		<div class="card-body">	
		  <div class="table-responsive">
			<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0">
				  <thead>
					<tr>
					  <th>Package No.</th>
					  <th>Qty</th>
					  <th style="width:10%;">Weight (<span id="unit_2"></span>)</th>
					  <!-- <th>Product Description </th> -->				 
					  <th style="text-align:center;" >Action</th>
					 </tr>
				  </thead>
			  <tbody>
				<?php if(isset($getaddresssliplists)){ ?>
					<?php $grandWeight = 0; foreach($getaddresssliplists as $getaddresssliplist){ 
						$grandWeight = $grandWeight + $getaddresssliplist['weight'];
					?>				
						<tr>
							<td><?php echo $getaddresssliplist['package_no']; ?></td>
							<td><?php echo $getaddresssliplist['qty']; ?></td>
							<td align="right"><?php echo $getaddresssliplist['weight']; ?></td>
							<!-- <td><b><?php echo $getaddresssliplist['model']; ?> | </b><?php echo $getaddresssliplist['description']; ?></td> -->					
							<td style="text-align:center;">							
								<a style="padding-left:7px;" href="<?php echo site_url('addSlipPrint'); ?>?package_no=<?php echo $getaddresssliplist['package_no']; ?>&addressslip_id=<?php echo $getaddresssliplist['addressslip_id']; ?>&challan_id=<?php echo $getaddresssliplist['challan_id']; ?>" title="Address Slip Print" target="_blank"> <i class="fas fa-print"></i></a>	
								
								<a style="padding-left:7px;" href="<?php echo site_url('addSlipDetailPrint'); ?>?package_no=<?php echo $getaddresssliplist['package_no']; ?>&addressslip_id=<?php echo $getaddresssliplist['addressslip_id']; ?>&challan_id=<?php echo $getaddresssliplist['challan_id']; ?>" title="Product Detail Print" target="_blank"> <i class="fas fa-print"></i></a>	
							</td>
						</tr>
					<?php } ?>  
				<?php } ?>
				
				<!-- <tr>
					<td colspan="2" align="right" ><b>Grand Weight</b></td>
					<td align="right" ><b><?php echo number_format((float)$grandWeight, 2, '.', ''); ?></b></td>
					<td  >&nbsp;</td>
				</tr> -->
				
			  </tbody>
			</table>
		  </div>
		</div>	
	</div>
	
	
</div>
<script>
$(document).ready(function() { 
	var val1 = $("#weight_unit").val();
	$("#unit_1").html(val1);	
	$("#unit_2").html(val1);
	$("#weight_unit").change(function() {
		var val = this.value;
		$("#unit_1").html(val);	
		$("#unit_2").html(val);	
	});
	
	$("#no_of_packs").change(function() {		
		//packdropdown		
		var htm = '';
		htm += '<option value="">Select</option>';
		var opt = this.value;
		
		for(var p=1; p<=opt; p++){
			htm += '<option value="'+p+'">'+p+'</option>'
		}
		$(".packdropdown").html(htm);
		
		/* $("#tab_logic tr").each(function(){			
			if (parseInt($(this).data("id")) > 0) {				
				var idd = $(this).data("id");
				$('#priprotable').find("[data-id='"+ idd +"']").remove();
			}
		});
		
        var row = this.value;		
		for(var i=1; i< row; i++) {		
			var newid = 0;
			$.each($("#tab_logic tr"), function() {
				if (parseInt($(this).data("id")) > newid) {
					newid = parseInt($(this).data("id"));
				}
			});
			newid++;
			
			var tr = $("<tr></tr>", {
				id: "addr"+newid,
				"data-id": newid
			});
			
			// loop through each td and create new elements with name of newid
			$.each($("#tab_logic tbody tr:nth(0) td"), function() {
				var td;
				var cur_td = $(this);
				
				var children = cur_td.children();
				
				// add new td and element if it has a nane
				if ($(this).data("name") !== undefined) {
					td = $("<td></td>", {
						"data-name": $(cur_td).data("name")
					});
					
					var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
					c.attr("name", $(cur_td).data("name") + newid);
					c.appendTo($(td));
					td.appendTo($(tr));
					
				} else {
					td = $("<td></td>", {
						'text': $('#tab_logic tr').length
					}).appendTo($(tr));
				}
			});
			
			
			// add the new row
			$(tr).appendTo($('#tab_logic'));
			
			$(tr).find("td button.row-remove").on("click", function() {
				 $(this).closest("tr").remove();
			});
			
			var val = $("input[name='weight_all']").val();
			$(".wgt").val(val);
		} */
		
    });	
	
    $("#add_row").on("click", function() {
       // Get max row id and set new id
        var newid = 0;
        $.each($("#tab_logic tr"), function() {
            if (parseInt($(this).data("id")) > newid) {
                newid = parseInt($(this).data("id"));
            }
        });
        newid++;
        
        var tr = $("<tr></tr>", {
            id: "addr"+newid,
            "data-id": newid
        });
        
        // loop through each td and create new elements with name of newid
        $.each($("#tab_logic tbody tr:nth(0) td"), function() {
            var td;
            var cur_td = $(this);
            
            var children = cur_td.children();
            
            // add new td and element if it has a nane
            if ($(this).data("name") !== undefined) {
                td = $("<td></td>", {
                    "data-name": $(cur_td).data("name")
                });
                
                var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                c.attr("name", $(cur_td).data("name") + newid);
                c.appendTo($(td));
                td.appendTo($(tr));
            } else {
                td = $("<td></td>", {
                    'text': $('#tab_logic tr').length
                }).appendTo($(tr));
            }
        });
        
        // add delete button and td
        /*
        $("<td></td>").append(
            $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
                .click(function() {
                    $(this).closest("tr").remove();
                })
        ).appendTo($(tr));
        */
       
        // add the new row
        $(tr).appendTo($('#tab_logic'));
        
        $(tr).find("td button.row-remove").on("click", function() {
             $(this).closest("tr").remove();
        });
		var weight_all = $("#weight_all").val();
		$("#priprotable").find("tr:last .wgt").val(weight_all);
		$("#priprotable").find("tr:last .challan_qty").html('');
		
});


$("td button.row-remove").on("click", function() {
	 $(this).closest("tr").remove();
}); 

    // Sortable Code
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
    
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        
        return $helper;
    };
  
    $(".table-sortable tbody").sortable({
        helper: fixHelperModified      
    }).disableSelection();

    $(".table-sortable thead").disableSelection();

    $("#add_row").trigger("click");
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
		$("#weight_section").hide();
		var weight_box = '<?php echo $getaddressslip->package_identical; ?>';
		if(weight_box == 1){
			$("#weight_section").show();
		}
        $("input[type='radio']").click(function(){
            var value = this.value;
			if(value == 1){
				$("#weight_section").show();
			} else {
				$("#weight_section").hide();
			}
        });
		
		$("input[name='weight_all']").keyup(function(){		
			//if( $("input[name='weight_all']").val()){
				var val = $("input[name='weight_all']").val();
				$(".wgt").val(val);
			//}   
		});		
		
		$("#address_billto").hide();
		$("#address_shipto").hide();
		
		var address_type = '<?php echo $getaddressslip->address_type; ?>';
		if(address_type == 'B'){
			$("#address_billto").show();
		}
		if(address_type == 'S'){
			$("#address_shipto").show();
		}
		
		$("#address_type").change(function() {
			if(this.value == 'B'){
				$("#address_billto").show();
				$("#address_shipto").hide();
			}
			
			if(this.value == 'S'){
				$("#address_shipto").show();
				$("#address_billto").hide();
			}
			
			if(this.value == ''){
				$("#address_billto").hide();
				$("#address_shipto").hide();
			}
		});
		
		
		var total_qty1 = '<?php echo $total_qty; ?>'; 
		var sum1 = 0;     
		$(".qtyy").each(function () {				
			var value111 = $(this).val();						
			if ($.isNumeric(value111)) {
				sum1 += parseInt(value111);
			}                 
		});
		
		if(sum1 == total_qty1){
			//$(".qtyy").attr("disabled", "disabled"); 
			//$("#submit").attr("disabled", "disabled"); 
			//$("#add_row").hide(); 
		}
		
		$("input[name='qty[]']").keyup(function(){		
			var total_qty = '<?php echo $total_qty; ?>';  
			
			var sum = 0;     
			$(".qtyy").each(function () {				
				var value11 = $(this).val();
							
				if ($.isNumeric(value11)) {
					sum += parseInt(value11);
				}                 
			});
			
			if(sum > total_qty){
				alert("Qty of product must be same as qty in challan.");
			}

			if(sum == total_qty){
				//$(".qtyy").attr("disabled", "disabled"); 
				//$("#submit").attr("disabled", "disabled"); 
				//$("#add_row").hide(); 
			}
		});
		
		$("tr .proDes").change(function() {			
			var pro_id = this.value;
			//alert(pro_id);
			if(pro_id){
				var qty = JSON.parse('<?php echo json_encode($productToQty); ?>');
				for(var i=0; i < qty.length; i++){
					if(qty[i].key == pro_id){
						$(this).parent().parent().find('.challan_qty').html(qty[i].value);
					}
				}
			} else {
				$(this).parent().parent().find('.challan_qty').html('');
			}				
		});
		
		$("tr .proDes2").change(function() {			
			var pro_id = this.value;
			//alert(pro_id);
			if(pro_id){
				var qty = JSON.parse('<?php echo json_encode($productToQty); ?>');
				for(var i=0; i < qty.length; i++){
					if(qty[i].key == pro_id){
						$(this).parent().parent().find('.challan_qty').html(qty[i].value);
					}
				}
			} else {
				$(this).parent().parent().find('.challan_qty').html('');
			}				
		});
		
    });
</script>