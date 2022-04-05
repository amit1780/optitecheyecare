<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>Store</th>
		  <th>Order&nbsp;No</th>
		  <th>Quotation&nbsp;No</th>
		  <th>Customer&nbsp;Name</th>
		  <th>Customer&nbsp;Id</th>
		  <th>Contact&nbsp;No</th>
		  <th>Country</th>
		  <th>State</th>
		 
		  <th>Order&nbsp;Total</th>
		  <th>Payment&nbsp;Receive</th>
		  <th>Order&nbsp;Date</th>
		  <th>Action</th>
		 </tr>
	  </thead>
  <tbody>
	<?php if($orders){ ?>				
		<?php foreach($orders as $order){ ?>				
			<tr class="<?php if($order['totalOrderProduct'] > 0){ echo "alert-danger";} ?>">
				<td><?php echo $order['store_name']; ?></td>
				<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>"> <?php echo getOrderNo($order['order_id']); ?></a></td>
				<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $order['quotation_id']; ?>"><?php echo getQuotationNo($order['quotation_id']); ?></a></td>
				<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $order['customer_id']; ?>"><?php echo $order['customer_name']; ?></a></td>
				<td><?php echo $order['customer_id']; ?></td>
				<td><?php echo $order['contact_phone']; ?></td>
				<td><?php echo $order['country_name']; ?></td>
				<td><?php echo $order['state_name']; ?></td>
				
				<td><i class="<?php echo $order['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo $order['order_total']; ?></td>
				<td><?php echo $order['advice_total']; ?></td>
				<td><?php echo dateFormat('d-m-Y',$order['order_date']); ?></td>						
				<td class="">
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>" title="Order View" ><i class="fas fa-eye"></i></a>
					<?php  if($order['totalOrderProduct'] > 0){  ?>
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('challan'); ?>?order_id=<?php echo $order['order_id']; ?>" title="Create Challan"><i class="fas fa-plus"></i></a>
					<?php } ?>								
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('editOrder'); ?>/<?php echo $order['order_id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
					<a style="padding-left:7px;" href="<?php echo site_url('orderPrint'); ?>/<?php echo $order['order_id']; ?>" target="_blank" title="Print order"><i class="fas fa-print"></i></a>
					<!-- <a target="_blank" style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $order['order_id']; ?>" title="Email"><i class="fas fa-envelope"></i></a> -->
					<a style="padding-left:7px;" href="<?php echo site_url('order/downloadPdf'); ?>?order_id=<?php echo $order['order_id']; ?>" title="Download"> <i class="fas fa-download"></i></a>
					<?php if($order['totalOrderProduct'] > 0){ ?>
					<!-- <a target="_blank" style="padding-left:7px;" href="#" class="delOrderPro" onClick="getDelProList(<?php echo $order['order_id']; ?>);" title="Delete Order Product"><i class="fa fa-trash"></i></a> -->
					<?php } ?>								
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('paymentAdvice'); ?>/<?php echo $order['order_id']; ?>" title="Payment Recive Advice"><i class="fa fa-file-alt"></i></a>																
				</td>
			</tr>
		<?php } ?>  
	<?php } else { ?>
			<tr>
				<td class="text-center" colspan="12">No results!</td>
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