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
		.borderbox{border:2px solid black;}
		.quote_view .border_left{border-left:2px solid black;}
		.quote_view .border_right{border-right:2px solid black;}
		.quote_view .border_bottom{border-bottom:2px solid black;}
		.quote_view .border_top{border-top:2px solid black;}
		
		table {
			table-layout:fixed;
		}
		
		.table-bordered td{
			border: 0px solid black;			
		}
		
		.space_bottom{margin-bottom:15px;}
		.card{border: 0px solid rgba(0,0,0,.125) !important; }
		
	</style>
	
	<div class="card mb-3" id="printableArea">
		<div style="width:100%;padding-top:30px;padding-bottom:50px;">
			<div style="width:100%;text-align:center;"><img src="<?php echo base_url().$challanInfo->store_logo; ?>"></div>	
		</div>
		
		<div class="card-body">
			 <h3 style="text-align:center;">Goods Return (Store - <b><?php echo $challanInfo->store_name; ?></b> )</h3>
			<div class="row quote_view borderbox" style="border: 2px solid black;font-size: 21px;">			
				
				<?php $order_date = new DateTime($orderInfo->order_date); ?>
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Order No: <?php echo getOrderNo($challanInfo->order_id); ?></b> &nbsp;&nbsp;&nbsp; <b>Order date :</b> <?php echo dateFormat('d-m-Y', $orderInfo->order_date); ?></p>					
				</div>
				
				<div class="col-sm-6  border_bottom" style="border-bottom:2px solid black;">
					<p style="margin-bottom:0px;"><b>Invoice No:</b> <?php echo $challanInfo->invoice_no; ?> &nbsp;&nbsp;&nbsp; <b>Dt:</b> <?php echo dateFormat('F, d, Y', $challanInfo->invoice_date);  ?> </p>
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:2px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Customer Id:</b> <?php echo $challanInfo->customer_id; ?></p>					
				</div>
				
				<div class="col-sm-6  border_right border_bottom" style="border-right:0px solid black;border-bottom:2px solid black;">					
					<p style="margin-bottom:0px;"><b>Customer Name:</b> <?php echo $customerInfo->company_name; ?></p>					
				</div>
				
				<table class="" id="protable" width="100%" cellspacing="0" style="font-size: 21px;">
					<tr>
						<th  style="width:4%;border-right:2px solid black;">S.N.</th>
						<th  style="border-right:2px solid black;">Challan No</th>
						<th  style="width:25%;border-right:2px solid black;">Product Description</th>
						<th  style="border-right:2px solid black;text-align:center;">Batch No.</th>
						<th  style="border-right:2px solid black;text-align:center;">Exp. Date</th>
						<th  style="border-right:2px solid black;text-align:center;">Qty Sold</th>
						<th  style="border-right:2px solid black;text-align:center;">Qty Returns</th>									
						<th  style="width:12%;border-right:2px solid black;text-align:center;">Return Date</th>
					</tr>
					
					<?php $i=1; foreach($challanProInfo as $challanPro){ ?>
					<?php //$expDate = new DateTime($challanIn['batch_exp_date']);
					      $expDate = date('m/Y',strtotime($challanPro['batch_exp_date']));
					?>				
						
						<tr class="prtr">
							<td  style="border-right:2px solid black;border-top:2px solid black;" ><?php echo $i; ?></td>
							<td  style="border-right:2px solid black;border-top:2px solid black;"><?php echo getChallanNo($challanPro['challan_id']); ?></td>
							<td  style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanPro['pro_description']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanPro['batch_no']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $expDate; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo $challanPro['qty']; ?></td>
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php if($challanPro['return_qty']){ echo $challanPro['return_qty'];} else { echo "0"; } ?></td>
							
							<td align="center" style="border-right:2px solid black;border-top:2px solid black;"><?php echo dateFormat('d-m-Y', $challanPro['return_datetime']); ?></td>											
						</tr>
					
					<?php $i++; } ?>					
					
				</table>
			</div>
			<div class="row" style="font-size:21px;margin-top:20px;">
				<div class="col-sm-12" style="padding-left: 0px;">
					<p style="margin: 0px;"><b>Return Note</b></p> 
					<?php if($returnNotes->return_note){ echo $returnNotes->return_note;}	?>
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
<?php 
function after ($inthis, $inthat)
{
if (!is_bool(strpos($inthat, $inthis)))
return substr($inthat, strpos($inthat,$inthis)+strlen($inthis));
}
?>