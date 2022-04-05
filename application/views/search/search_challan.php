<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
<thead>
	<tr>
	  <th>Challan&nbsp;No</th>
	  <th>Order&nbsp;No</th>
	  <th>Customer&nbsp;Name</th>
	  <th>Challan&nbsp;Type</th>
	  <th>Docket&nbsp;No</th>
	  <th>Invoice&nbsp;No</th>	  
	  <th>Contact&nbsp;No</th>
	  <th>Country</th>
	  <th>State</th>
	  <th width="8%">Challan&nbsp;Total</th>
	  <th>Challan&nbsp;Date</th>
	  <th style="width:10%;">Action</th>
	 </tr>
  </thead>
<tbody>
<?php if(($challanInfo)){ ?>
	<?php foreach($challanInfo as $challan){ ?>				
		<tr>
			<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challan['challan_id']; ?>" ><?php echo getChallanNo($challan['challan_id']); ?></a></td>
			<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challan['order_id']; ?>" ><?php echo getOrderNo($challan['order_id']); ?></a></td>
			<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $challan['customer_id']; ?>"><?php echo $challan['company_name']; ?></a></td>
			<td><?php echo $challan['challan_type']; ?></td>
			<td><?php echo $challan['docket_no']; ?></td>
			<td><?php echo $challan['invoice_no']; ?></td>			
			<td><?php echo $challan['contact_phone']; ?></td>
			<td><?php echo $challan['country_name']; ?></td>
			<td><?php echo $challan['state_name']; ?></td>
			<td><i class="<?php echo $challan['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo number_format((float)($challan['net_total']), 2, '.', ''); ?></td>
			<td><?php echo dateFormat('d-m-Y',$challan['challan_date']); ?></td>						
			<td class="">
				<a style="padding-left:7px;" href="<?php echo site_url('challanView'); ?>/<?php echo $challan['challan_id']; ?>" title="Challan View" ><i class="fas fa-eye"></i></a> 
				<a style="padding-left:7px;" href="<?php echo site_url('dispatchNote'); ?>/<?php echo $challan['challan_id']; ?>" title="Dispatch Note"> <i class="far fa-sticky-note"></i></a>  
				<a style="padding-left:7px;" href="<?php echo site_url('createSli'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Create SLI"> <i class="fas fa-plus"></i></a>
				<a style="padding-left:7px;" href="<?php echo site_url('challanPrint'); ?>/<?php echo $challan['challan_id']; ?>" title="Challan Print" target="_blank"> <i class="fas fa-print"></i></a>					
				<a style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $challan['challan_id']; ?>" title="Email"><i class="fas fa-envelope"></i></a>
				<a style="padding-left:7px;" href="<?php echo site_url('challan/downloadPdf'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Download"><i class="fas fa-download"></i></a>
				<a style="padding-left:7px;" href="<?php echo site_url('addressslip'); ?>?challan_id=<?php echo $challan['challan_id']; ?>" title="Address Slip"><i class="fa fa-truck" aria-hidden="true"></i></a>
			</td>
		</tr>
	<?php } ?>  
<?php } else { ?>
	<tr>
		<td class="text-center" colspan="13">No results!</td>
	</tr>
<?php } ?>    
</tbody>
</table>
<div id="pagination">
	<?php echo $pagination; ?>
</div>
<script>
	$('#pagination a').on('click',function(e){
		e.preventDefault(); 		
		var pageNum = $(this).attr('data-ci-pagination-page');		
		$("#searchResponce").html('');
		var form = $("#advanceSearchForm");
		var urlAction = form.attr('action')+'?per_page='+pageNum;
		var formData = $('#advanceSearchForm').serialize();	
		formData = formData + '&per_page='+pageNum;
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
			}
		});
	});
</script>