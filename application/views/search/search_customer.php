<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th width="20">Company&nbsp;Name</th>
		  <th width="20">Contact&nbsp;Person</th>
		  <th>Email</th>
		  <th>Mobile</th>
		  <th>Phone</th>
		  <th>Country</th>
		  <th>State</th>
		  <th>District</th>
		  <th>City</th>
		  <th>Pin</th>		  
		  <th width='10%'>Action</th>
		</tr>
	  </thead>
	  <tbody>		 
		<?php if($customers){ ?>
			<?php foreach($customers as $customer){ ?>
			
				  <tr>
					<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $customer['customer_id']; ?>"><?php echo $customer['company_name']; ?></a></td>
					<td><?php echo $customer['person_title']." ".$customer['contact_person']; ?></td>
					<td><?php echo $customer['email']; ?></td>
					<td><?php echo $customer['mobile']; ?></td>
					<td><?php echo $customer['phone']; ?></td>
					<td><?php echo $customer['country_name']; ?></td>
					<td><?php echo $customer['state_name']; ?></td>
					<td><?php echo $customer['district']; ?></td>
					<td><?php echo $customer['city']; ?></td>
					<td><?php echo $customer['pin']; ?></td>					
					
					<td class="">
						<a class="tdBtn" target="_blank" href="<?php echo site_url('customerView'); ?>/<?php echo $customer['customer_id']; ?>"  title="View" ><i class="fas fa-eye"></i></a>
						<a class="tdBtn" target="_blank" href="<?php echo site_url('editCustomer'); ?>/<?php echo $customer['customer_id']; ?>"  title="Edit"><i class="far fa-edit"></i></a>
						<a class="tdBtn" target="_blank" href="<?php echo site_url('notes'); ?>/<?php echo $customer['customer_id']; ?>"  title="Notes"><i class="far fa-sticky-note"></i></a>
						<a class="tdBtn" target="_blank" href="<?php echo site_url('priceList'); ?>/<?php echo $customer['customer_id']; ?>"  title="Price List"><i class="fas fa-list"></i></a>
						<a class="tdBtn" target="_blank" href="<?php echo site_url('customerHistory'); ?>/<?php echo $customer['customer_id']; ?>"  title="Customer History"><i class="fas fa-history"></i></a>
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