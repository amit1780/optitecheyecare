<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
  <?php //echo $this->breadcrumbs->show(); ?>	
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
	
   
  <!-- Pandeing Payment Receive Advice List --> 
  <div id="mass3"></div>
  <div class="card mb-3">
	<div class="card-header">
	  <i class="fas fa-table"></i>
	  Payment Received Advice Pending</div>
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped display" id="" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Bank Name</th>					
					<th>Bank Ref. No</th>
					<!-- <th>Currency</th> -->
					<th>Amount</th>
					<th>Bank File</th>
					<th>Date Of Payment</th>
					<th style="width:25%;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($advices as $advice){ ?>
					<?php $date_added = new DateTime($advice['date_added']); ?>
					<tr>	
						<td><?php echo $advice['bank_name']; ?></td>
						<td><?php echo $advice['bank_ref_no']; ?></td>
						<!-- <td><?php echo $advice['currency']; ?></td> -->
						<td><?php echo $advice['amount']; ?></td>
						<td><a href="<?php echo base_url().'uploads/bank/'.$advice['bank_file']; ?>"><?php echo $advice['bank_file']; ?></a></td>
						<td><?php echo $date_added->format('d-m-Y'); ?></td>
						<td class="text-center">
							<?php if($this->session->userdata('group_type')=='SADMIN'){ ?>
								<a class="advice_reject btn btn-primary" id="advicereject_<?php echo $advice['payment_advice_id']; ?>">Reject</a> &nbsp;&nbsp;							
								<a class="advice_approved btn btn-primary" id="adviceapprove_<?php echo $advice['payment_advice_id']; ?>" target="_blank">Approve</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
	
</div>
<script>
$(document).ready(function(){
	$(document).ready(function() {
		$('table.display').DataTable();
	} );	
	
	//Advice Approve
	$(".advice_approved").click(function(){
		var advice = (this.id).split('_');
		var advice_id = advice[1];
		var base_url = '<?php echo site_url('advicePending'); ?>';
		
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
	
	$('.advice_reject').click(function() {
		if (confirm('Are you sure?')) {
			var advice = (this.id).split('_');
			var advice_id = advice[1];
			var base_url = '<?php echo site_url('advicePending'); ?>';
			$.ajax({
				url:'<?php echo site_url('adviceReject');?>',
				method: 'post',
				data: 'advice_id=' + advice_id,
				dataType: 'json',
				success: function(response){
					if(response){
						var htm = '<div class="alert alert-success" role="alert">Successfully Reject.</div>';
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

function delAdvice(advice_id){
	var base_url = '<?php echo site_url('dashboard'); ?>';
	var checkstr =  confirm('Are you sure you want to delete advice?');
	if(checkstr == true){
		$.ajax({
			url:'<?php echo site_url('adviceDelete');?>',
			method: 'post',
			data: 'advice_id=' + advice_id,
			dataType: 'json',
			success: function(response){
				if(response){
					var htm = '<div class="alert alert-danger" role="alert">Successfully Delete.</div>';
					$("#mass").html(htm);
					
					setTimeout(function(){
						$("#myModal .close").click();						
						$("#mass").html('');
						window.location.replace(base_url);
					}, 3000);		
					
				}
			}
		});
	}
}
</script>