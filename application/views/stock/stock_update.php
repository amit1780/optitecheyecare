<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	 
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">				
				<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
			</div> 
			
		</div> 		
	</div>
	 
	 <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
		 
  <div class="card mb-3">	
	<div class="card-body">
	
			
	
	  <div class="table-responsive">
		
		<table class="table-sm table-bordered" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'store_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $store_sort; ?>" >Store name</a></th>
			  
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'product_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $product_name_sort; ?>" >Product Name</a></th>
			   
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'model')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $model_sort; ?>" >Model</a></th>
			   
			  <th>Available Quantity</th>
			  <th>Available Quantity</th>
			  
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'unit_name')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $pack_unit_sort; ?>" >Pack Unit</a></th>
			   
			   <th <?php if($this->input->get('order') && ($this->input->get('sort') == 'batch_no')){ echo 'class=sort_'.$this->input->get('order'); } else { echo ''; } ?> ><a href="<?php echo $batch_no_sort; ?>" >Batch No</a></th>
			  
			  <th>Expiry Date</th>
			  
			</tr>
		  </thead>		 
		  <tbody>
			<?php if(($stocks)){ 
				file_put_contents('updated_batch.csv', "Store,Model,Batch No".PHP_EOL , FILE_APPEND | LOCK_EX);	
			?>
				<?php foreach($stocks as $stock){ ?>
				        
				        <?php
							$availableQty=$stock['qty'] - $stock['challan_qty']+ $stock['return_qty'];
							if($availableQty <=0){
								continue;
							}
							
							#$stockData = #$ci->db->get_where('stock',array('batch_id'=>$stock['batch_id'],'store_id'=>$stock['store_id'],"qty>$availableQty"))->row();
							$ci = get_instance();
							$ci->db->select('*');
							$ci->db->from('stock');
							$ci->db->where('batch_id',$stock['batch_id']);
							$ci->db->where('store_id',$stock['store_id']);
							$ci->db->where("qty>=$availableQty");
							$ci->db->limit( 1, 0);
							$query = $ci->db->get();
							$stockData=$query->row();
							#print_r($query->row());
							
							
							$qtyToupdate=$stockData->qty-$availableQty;
							$dataArray = array(
								'qty'   => $qtyToupdate
							);
							
							$this->db->where('stock_id', $stockData->stock_id);
							$this->db->update('stock', $dataArray);
							$finalcontent='';
							$finalcontent .='"'.$stock['store_name'].'",';							
							$finalcontent .='"'.$stock['model'].'",';
							$finalcontent .='"'.$stock['batch_no'].'",';


							file_put_contents('updated_batch.csv', $finalcontent.PHP_EOL , FILE_APPEND | LOCK_EX);

						    $expDate = new DateTime($stock['s_exp_date']);
						    $mfgDate = new DateTime($stock['s_mfg_date']);
						?>
					  <tr>
						<td><?php echo $stock['store_name']; ?></td>
						<td><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $stock['product_id']; ?>"><?php echo $stock['product_name']; ?></a></td> 
						<td><?php echo $stock['model']; ?></td>
						<td><?php echo $availableQty." --> ".$stockData->qty; echo "-->".($qtyToupdate); ?></td>
						<td><?php echo $stock['unit_name']; ?></td>
						<td><?php echo $stock['batch_no']; ?></td>						
						<td><?php echo dateFormat('m/Y', $stock['s_exp_date']); ?></td>
						
					  </tr>
				<?php } ?>  
			<?php } else { ?>
				<tr>
					<td class="text-center" colspan="8">No results!</td>
				</tr>
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	  <?php echo $pagination; ?>
	</div>
	
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
</div>

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
</script>
<script>
	$(document).ready(function(){
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
<script> 
 $(document).ready(function(){  
	var base_url = '<?php echo site_url(); ?>';
	$('#create_excel').click(function(){  
		var excel_data = $('#searchResponce').html();  
		var urlll = base_url +"/downloadExcelFile";		
		window.location = urlll;		
		//var formData = $('#advanceSearchForm').serialize();		
		//$.post(urlll, formData)
	});  
 });  
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".form-control").keypress(function(event) { 
		if (event.keyCode === 13) { 
			$("#button-filter").click();				
		} 
	});
	
	$("#button-filter").click(function(){
		var url = '<?php echo site_url($form_action);?>';		
		var data_form = $("#filterForm :input")
				.filter(function(index, element) {
					return $(element).val() != '';
				})
				.serialize();
		
		if (data_form) {
			url += '?' + (data_form);
		}		
		location = url; 
	});
}); 
</script> 