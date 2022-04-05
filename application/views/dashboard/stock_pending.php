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
	<div id="mass"></div>
	<style>
		.reject{color:white !important;}
		.btn{color:white !important;}		
	</style>
	
	
	
<!-- Pandeing Stock -->

	<div id="pendingStock"></div>
	<div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Stock Pending</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered display" id="" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Store name</th>
				  <th>User name</th>
				  <th>Product name</th>
				  <th>Model</th>
				  <th>Batch No</th>
				  <th>Quantity</th>
				  <th>Unit</th>
				  <th>Expiry Date</th>		
				  <?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){ ?>		  
				  	<th style="width:25%;">Action</th>
				  <?php } ?>
				</tr>
			  </thead>
		  <tbody>			
			<?php if(isset($pending_stocks)){ ?>
				<?php foreach($pending_stocks as $stock){ ?>				        
				        <?php
						    $expDate = new DateTime($stock['s_exp_date']);
						    $mfgDate = new DateTime($stock['s_mfg_date']);
						?>
					  <tr>
						<td><?php echo $stock['store_name']; ?></td>
						<td><?php echo $stock['firstname'].' '.$stock['lastname']; ?></td>
						<td><?php echo $stock['product_name']; ?></td>
						<td><?php echo $stock['model']; ?></td>
						<td><?php echo $stock['batch_no']; ?></td>
						<td><?php echo $stock['qty']; ?></td>
						<td><?php echo $stock['unit_name']; ?></td>
						<td><?php echo $expDate->format('m/Y'); ?></td>	
						<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){ ?>					
						<td class="text-center">
						<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='STORE'){ ?>
							<?php if($stock['challan_id'] == 0){ ?>
								<a class="reject btn btn-primary" id="reject_<?php echo $stock['stock_id']; ?>">Reject</a>&nbsp;&nbsp;
							<?php } ?>
						<?php } ?>
						<a class="approved btn btn-primary" id="approve_<?php echo $stock['stock_id']; ?>"><?php if($stock['challan_id'] > 0){ echo "IST - "; } ?>Approve</a></td>
						<?php } ?>
					  </tr>
				<?php } ?>  
						
		  </tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
  
  
  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" style="max-width:800px;">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">Approve Stock</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="mess"></div>
			<div class="modal-body" style="padding:2rem;">
				<div id="batch_details">
					
				</div><br>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="hidden" name="stock_id" id="stock_id" value="">
							<button type="button" id="approvedBtn" class="btn btn-primary float-right"> Approve</button>	
						</div>
					</div>
				</div>			  
			</div>
		  </div>
		</div>
	</div>
  <!-- End Pandeing Stock --> 
<?php } ?>  	
</div>
<script>
$(document).ready(function(){
	$(".approved").click(function(){
		var stock = (this.id).split('_');
		var stock_id = stock[1];
		$("#stock_id").val(stock_id);
		var base_url = '<?php echo base_url(); ?>';
		$.ajax({
			url:'<?php echo site_url('getStockBatchDetails');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				var	htm2=''
				var	htm=''
					if(response.ce==0){
						response.ce='Non CE';
					}else{
						response.ce='CE';
					}
					if(response.sterlization==1){
						response.sterlization='Yes';
					}else{
						response.sterlization='No';
					}

					var mfg_date = response.mfg_date.split("-");
					var exp_date = response.exp_date.split("-");
					var good_recive_on = response.good_recive_on.split("-");


				htm += '<fieldset class="proinfo"><legend style="font-weight: normal;"><span>Quantity: <b>'+response.qty+'</b> </span> | <span>Pack Unit: <b>'+response.unit_name+'</b></span> </legend>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">IQC:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.iqc+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Product Name:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.product_name+'</b></label></div></div></div>';
				htm += '</div>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Model:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.model+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">CE/Non CE:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.ce+'</b></label></div></div></div>';
				htm += '</div>';

				/*htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">CE/Non CE:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.ce+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Batch Size:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.batch_size+'</b></label></div></div></div>';
				htm += '</div>';*/

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Batch Number:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.batch_no+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Mfg./Neutral Code:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.mfg_neutral_code+'</b></label></div></div></div>';
				htm += '</div>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Mfg. Date:</label></div><div class="col-sm-6"><label class="float-left"><b>'+mfg_date[1]+'/'+mfg_date[0]+'</b></label></div></div></div>';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Expiry Date:</label></div><div class="col-sm-6"><label class="float-left"><b>'+exp_date[1]+'/'+exp_date[0]+'</b></label></div></div></div>';
				htm += '</div>';

				htm +='<div class="row" style="border:1px solid gray;">';
				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Good Received on:</label></div><div class="col-sm-6"><label class="float-left"><b>'+good_recive_on[2]+'-'+good_recive_on[1]+'-'+good_recive_on[0]+'</b></label></div></div></div>';


				htm +='<div class="col-sm-6" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">Sterlization:</label></div><div class="col-sm-6"><label class="float-left"><b>'+response.sterlization+'</b></label></div></div></div>';
				htm += '</div>';
				
				if (response.sterlization_file!='')
				{
					htm +='<div class="row" style="border:1px solid gray;">';
					htm +='<div class="col-sm-12" style="border:1px solid gray;"><div class="row"><div class="col-sm-6"><label class="float-left">File:</label></div><div class="col-sm-6"><label class="float-left"><b><a href='+base_url+'/uploads/'+response.sterlization_file+'></a></b></label></div></div></div>';


				}
				htm += '</fieldset>';

				$("#batch_details").html(htm);
			}
		});
		
		$("#myModal").modal();		
	});
	
	$("#approvedBtn").click(function(){
		$('#approvedBtn').prop('disabled', true);
		var stock_id = $("#stock_id").val();
		var base_url = '<?php echo site_url('stockPending'); ?>';
		$.ajax({
			url:'<?php echo site_url('addStockApprove');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-success" role="alert">Successfully Approved.</div>';
					$("#mess").html(htm);
					
					setTimeout(function(){
						$("#myModal .close").click();
						$('#approvedBtn').prop('disabled', false);
						$("#mess").html('');
						window.location.replace(base_url);
					}, 2000);
					
					
				}
			}
		});
	});
	
	$('.reject').click(function() {
		if (confirm('Are you sure?')) {
			var stock = (this.id).split('_');
			var stock_id = stock[1];
			var base_url = '<?php echo site_url('stockPending'); ?>';
			$.ajax({
				url:'<?php echo site_url('stockReject');?>',
				method: 'post',
				data: 'stock_id=' + stock_id,
				dataType: 'json',
				success: function(response){
					if(response){
						var htm = '<div class="alert alert-success" role="alert">Successfully Reject.</div>';
						$("#mass").html(htm);
						
						setTimeout(function(){
							$("#mess").html('');
							window.location.replace(base_url);
						}, 3000);
						
						
					}
				}
			});
		}
	});
	
	$(document).ready(function() {
		$('table.display').DataTable();
	} );
	
	$(".addStock").click(function(){
		var stock = (this.id).split('_');
		var stock_id = stock[1];
		$("#stock_id").val(stock_id);
		var base_url = '<?php echo base_url(); ?>';
		$.ajax({
			url:'<?php echo site_url('getStockBatchDetails');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				$('input[name=store_id]').each(function(){
					var store_id = $(this).val();
					if(store_id == response.store_id){
						$("#storeId_"+store_id).prop("checked", true);
					}
				});
				
				$("#input-qty").val(response.qty);
				
				var htm = '';
				var exp_date = response.exp_date.split("-");				
				htm += '<input type="hidden" name="stock_id" value="'+response.stock_id+'">';
				htm += '<tr>';
				htm += '<td>'+response.product_name+'</td>';
				htm += '<td>'+response.model+'</td>';
				htm += '<td>'+response.batch_no+'</td>';
				htm += '<td>'+response.qty+'</td>';
				htm += '<td>'+response.unit_name+'</td>';
				htm += '<td>'+exp_date[1]+'/'+exp_date[0]+'</td>';
				htm += '</tr>';
				
				$("#stockdetails").html(htm);
				
			}
		});
		
		$("#myModalReject").modal();		
	});
	
	$('#addStockBtn').click(function() {		
		var base_url = '<?php echo site_url('stockRejected'); ?>';
		var data_form = $('#addStockform').serialize();			
		$.ajax({
			url:'<?php echo site_url('stockUpdate');?>',
			method: 'post',
			data: data_form,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-success" role="alert">Successfully Add.</div>';
					$("#mess1").html(htm);
					
					setTimeout(function(){
						$("#myModalReject .close").click();						
						$("#mess1").html('');
						window.location.replace(base_url);
					}, 3000);
					
					
				}
			}
		});
		
	});
	
	//Advice Approve
	$(".advice_approved").click(function(){
		var advice = (this.id).split('_');
		var advice_id = advice[1];
		var base_url = '<?php echo site_url('stockPending'); ?>';
		
		var checkstr =  confirm('Are you sure you want to Approve?');
		if(checkstr == true){
			$.ajax({
				url:'<?php echo site_url('adviceApprove');?>',
				method: 'post',
				data: 'advice_id=' + advice_id,
				dataType: 'json',
				success: function(response){
					if(response){
						var htm = '<div class="alert alert-success" role="alert">Successfully Approved.</div>';
						$("#mass3").html(htm);
						
						setTimeout(function(){						
							$("#mass3").html('');
							window.location.replace(base_url);
						}, 3000);		
						
					}
				}
			});
		}		
	});	
	
});

function delStock(stock_id){
	var base_url = '<?php echo site_url('stockRejected'); ?>';
	var checkstr =  confirm('Are you sure you want to delete Stock?');
	if(checkstr == true){
		$.ajax({
			url:'<?php echo site_url('stockDelete');?>',
			method: 'post',
			data: 'stock_id=' + stock_id,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-danger" role="alert">Successfully Delete.</div>';
					$("#mass").html(htm);
					
					setTimeout(function(){
						$("#myModal .close").click();						
						$("#mess").html('');
						window.location.replace(base_url);
					}, 3000);		
					
				}
			}
		});
	}
}
</script>