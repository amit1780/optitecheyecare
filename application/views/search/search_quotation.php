<?php if($based_on == 'Pending'){  ?>
<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>Store</th>
		  <th>Quotation&nbsp;No</th>
		  <th>Customer&nbsp;Name</th>
		  <th>Customer&nbsp;ID</th>
		  <th>Contact&nbsp;No</th>
		  <th>Country</th>
		  <th>State</th>
		  <th>Total&nbsp;Amount</th>
		  <th>Created&nbsp;Date</th>
		  <th width="10%">Action</th>
		 </tr>
	  </thead>
  <tbody>
	<?php if(($quotations)){ ?>
		<?php foreach($quotations as $quotation){ ?>				
			<tr>
				<td><?php echo $quotation['store_name']; ?></td>
				<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['id']; ?>"><?php echo getQuotationNo($quotation['id']); ?></a></td>				
				<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $quotation['customer_id']; ?>"><?php echo $quotation['customer_name']; ?></a></td>
				<td><?php echo $quotation['customer_id']; ?></td>
				<td><?php echo $quotation['contact_phone']; ?></td>
				<td><?php echo $quotation['country_name']; ?></td>
				<td><?php echo $quotation['state_name']; ?></td>
				<td><i class="<?php echo $quotation['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo number_format((float)$quotation['net_amount'], 2, '.', ''); ?> </td>				
				<td> <?php echo dateFormat('d-m-Y',$quotation['created_time']); ?> </td>
				<td class="">
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['id']; ?>" title="View" ><i class="fas fa-eye"></i></a>
					<?php if(empty($quotation['order_id'])) { ?>
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('editQuotation'); ?>/<?php echo $quotation['id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('order'); ?>?quotation_id=<?php echo $quotation['id']; ?>"  title="Generate Order"> <i class="fas fa-plus"></i></a>
					<?php } ?>
					<!-- <a target="_blank" style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $quotation['id']; ?>" title="Email"><i class="fas fa-envelope"></i></a> -->
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('quotation/downloadPdf'); ?>?quotation_id=<?php echo $quotation['id']; ?>" title="Download"> <i class="fas fa-download"></i></a>
				</td>
			</tr>
		<?php } ?>  
	<?php } else { ?>
			<tr>
				<td class="text-center" colspan="10">No results!</td>
			</tr>
	<?php } ?>    
  </tbody>
</table>
<div id="pagination">
	<?php echo $pagination; ?>
</div>
<?php } else { ?>

<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>Store</th>
		  <th >Quotation&nbsp;No</th>
		  <th >Order&nbsp;No</th>
		  <th>Customer&nbsp;Name</th>
		  <th>Customer&nbsp;Id</th>
		  <th>Contact&nbsp;No</th>
		  <th>Country</th>
		  <th>State</th>
		  <th>Total&nbsp;Amount</th>
		  <th>Created&nbsp;Date</th>
		  <th width="10%">Action</th>
		 </tr>
	  </thead>
  <tbody>
	<?php if(($quotations)){ ?>
		<?php foreach($quotations as $quotation){ ?>				
			<tr>
				<td><?php echo $quotation['store_name']; ?></td>
				<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['id']; ?>"><?php echo getQuotationNo($quotation['id']); ?></a></td>
				
				<td>
					<?php if($quotation['order_id']){ ?>
					<a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $quotation['order_id']; ?>"><?php echo getOrderNo($quotation['order_id']); ?></a>
					<?php } ?>
				</td>
				<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $quotation['customer_id']; ?>"><?php echo $quotation['customer_name']; ?></a></td>
				<td><?php echo $quotation['customer_id']; ?></td>
				<td><?php echo $quotation['contact_phone']; ?></td>
				<td><?php echo $quotation['country_name']; ?></td>
				<td><?php echo $quotation['state_name']; ?></td>
				<td><i class="<?php echo $quotation['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo number_format((float)$quotation['net_amount'], 2, '.', ''); ?> </td>				
				<td> <?php echo dateFormat('d-m-Y',$quotation['created_time']); ?> </td>
				<td class="">
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['id']; ?>" title="View" ><i class="fas fa-eye"></i></a>
					<?php if(empty($quotation['order_id'])) { ?>
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('editQuotation'); ?>/<?php echo $quotation['id']; ?>" title="Edit"><i class="far fa-edit"></i></a>
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('order'); ?>?quotation_id=<?php echo $quotation['id']; ?>"  title="Generate Order"> <i class="fas fa-plus"></i></a>
					<!-- <a style="padding-left:7px;" href="#" class="mailbox" id="<?php echo $quotation['id']; ?>" title="Email"><i class="fas fa-envelope"></i></a> -->
					<?php } ?> 
					
					<a target="_blank" style="padding-left:7px;" href="<?php echo site_url('quotation/downloadPdf'); ?>?quotation_id=<?php echo $quotation['id']; ?>" title="Download"> <i class="fas fa-download"></i></a>
				</td>
			</tr>
		<?php } ?>  
	<?php } else { ?>
			<tr>
				<td class="text-center" colspan="11">No results!</td>
			</tr>
	<?php } ?>   
  </tbody>
</table>
<div id="pagination">
	<?php echo $pagination; ?>
</div>
<?php } ?>

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