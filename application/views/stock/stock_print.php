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
	<div style="text-align:center;"><input type="button" onclick="printDiv('printableArea')" value="print" /></div>
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
		<div class="card-body">
			<div class="row quote_view borderbox" style="border: 2px solid gray;">				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;">
					<p>Store</p>		
				</div>				
				<div class="col-sm-8 ">
					<p><b><?php echo $stock->store_name; ?></b></p>					
				</div>

				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Product Name</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">
					<p><b><?php echo $stock->product_name; ?></b></p>					
				</div>

				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Model</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">
					<p><b><?php echo $stock->model; ?></b></p>					
				</div>

				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Quantity</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">
					<p><b><?php echo ($stock->qty - $stock->challan_qty) + $stock->return_qty; ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Batch No</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">
					<p><b><?php echo $stock->batch_no; ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Mfg. Date</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php echo dateFormat('m/Y', $stock->s_mfg_date); ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Expiry Date</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php echo dateFormat('m/Y', $stock->s_exp_date); ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>IQC</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php echo $stock->iqc; ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>CE/Non CE</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php if($stock->ce == '1'){ echo 'CE'; } else { echo 'Non CE'; } ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Mfg./Neutral Code</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php echo $stock->mfg_neutral_code; ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Good Received on</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php echo dateFormat('d-m-Y', $stock->good_recive_on); ?></b></p>					
				</div>
				
				<div class="col-sm-4  border_right" style="border-right:2px solid gray;border-top:2px solid gray;">
					<p>Sterlization</p>		
				</div>				
				<div class="col-sm-8 " style="border-top:2px solid gray;">					
					<p><b><?php if($stock->sterlization == '1'){ echo 'Yes'; } else { echo 'No'; } ?></b></p>					
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