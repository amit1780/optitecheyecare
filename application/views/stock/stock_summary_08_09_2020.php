<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Bootstrap core CSS-->
<link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Page level plugin CSS-->
<link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

 <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>


<!-- Custom styles for this template-->
<link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css" rel="stylesheet"> 
<script src="<?php echo base_url(); ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/common.js"></script>
<div class="container-fluid">	
	<div style="text-align:center;"><input type="button" onclick="printDiv('printableArea')" value="Print" /></div>
	<style>
		.quote_view p{margin-bottom:0px;}
		
		.borderbox{border:2px solid gray;}
		.quote_view .border_left{border-left:2px solid gray;}
		.quote_view .border_right{border-right:2px solid gray;}
		.quote_view .border_bottom{border-bottom:2px solid gray;}
		.quote_view .border_top{border-top:2px solid gray;}
		
		table {
			table-layout:fixed;
		}
		
		.table-bordered td{
			border: 0px solid gray;			
		}
		
		.space_bottom{margin-bottom:15px;}
		.card{border:0px solid rgba(0,0,0,.125) !important;}
		
	</style>
	<div class="card mb-3" id="printableArea">		
		<div class="card-body" style="font-size:18px;">
			<span><b>Store Name : </b> <?php echo $stockDetails->store_name; ?></span>&nbsp;&nbsp; | &nbsp;&nbsp;
			<span><b>Product Name : </b> <?php echo $stockDetails->product_name; ?></span>&nbsp;&nbsp; | &nbsp;&nbsp;
			<span><b>Model : </b> <?php echo $stockDetails->model; ?></span>&nbsp;&nbsp; | &nbsp;&nbsp;
			<span><b>Batch No : </b> <?php echo $stockDetails->batch_no; ?></span> <br>
			 <?php
				$mfgDate = new DateTime($stockDetails->mfg_date);
				$expDate = new DateTime($stockDetails->exp_date);				
			?>			
			<span><b>Mfg Date : </b> <?php echo dateFormat('m/Y', $stockDetails->mfg_date); ?></span>&nbsp;&nbsp; | &nbsp;&nbsp;
			<span><b>Exp Date : </b> <?php echo dateFormat('m/Y', $stockDetails->exp_date); ?></span>
			<div class="row quote_view borderbox" style="border: 2px solid gray;margin-top:10px;">				
				<div class="table-responsive">
					<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0" style="font-size:18px;border: 2px solid gray;">
					  <thead>
						<tr>
						  <th>Date</th>
						  <th>Challan No </th>
						  <th style="width:30%;">Customer Name</th>
						  <th style="text-align:center;">Quantity In</th>
						  <th style="text-align:center;">Quantity Out</th>
						  <th style="text-align:right;">Balance</th>
						</tr>
					  </thead>		 
					  <tbody>
						<?php if($stocks){ ?>
							<?php
								$in = 0;
								$out = 0;
								$avil = 0;
							?>
							<?php foreach($stocks as $stock){ ?>
								<?php
									if($stock['qty_in']){
										$in = $in + $stock['qty_in'];
									}									
									if($stock['qty_out']){
										$out = $out + $stock['qty_out'];										
									}
									$avil = $in - $out;
								?>
													
								<tr>
									<td><?php  echo dateFormat('d-m-Y', $stock['date_time']); ?></td>
									<td ><?php  echo $stock['challan_id']; ?></td>
									<td><?php  echo $stock['company_name']; ?></td>
									<td align="center"><?php  echo $stock['qty_in']; ?></td>
									<td align="center"><?php  echo $stock['qty_out']; ?></td>
									<td align="right"><?php  echo $avil; ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
						<tr>
							<td></td>
							<td ></td>
							<td ></td>
							<td align="center"><b><?php  echo $in; ?></b></td>
							<td align="center"><b><?php  echo $out; ?></b></td>
							<td align="right"><b><?php  echo $avil; ?></b></td>
						</tr>
					  </tbody>
					</table>
				</div>
			</div>			
		</div>		
	</div>	
</div>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>