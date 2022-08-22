<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 10px;padding-left: 10px;margin-right: auto;margin-left: auto; font-size:12px;">		
	<div style="display: flex;flex-wrap: wrap;">
		<table style="font-size:12px;border-collapse: collapse;margin-bottom:20px;">
		  	<thead>
				<tr>
					<th style="text-align:left;margin-left:15px;">Country:&nbsp;&nbsp;<?php echo $country_name; ?></th>
					<th style="text-align:left;margin-left:30px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State:&nbsp;&nbsp;<?php echo $state_name; ?></th>
					<th style="text-align:left;margin-left:30px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City:&nbsp;&nbsp;<?php echo $city; ?></th>
				</tr>
		  	</thead>		 
		</table>

		<table style="font-size:12px;border-collapse: collapse;">
		  <thead>
			<tr>
			  <th style="border-bottom: 1px solid black;border-left: 1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:left;">Customer ID</th>
			  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Company Name</th>
			  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Contact Person</th>
			  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Email</th>
			  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Mobile</th>
			  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Address</th>
			  <th style="border-bottom: 1px solid black;border-right:1px solid black;border-top:1px solid black;">Pin</th>
			</tr>
		  </thead>		 
		  <tbody>
			<?php if(isset($customers)){ ?>
				<?php foreach($customers as $customer){  ?>						
						
					  <tr>
						<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right:1px solid black;text-align:left;"><?php echo $customer['customer_id']; ?></td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;"><?php echo $customer['company_name']; ?></td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;"><?php echo $customer['person_title']." ".$customer['contact_person']; ?></td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;"><?php echo $customer['email']; ?></td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;"><?php echo $customer['mobile']; ?></td>
						<td style="border-bottom: 1px solid black;border-right:1px solid black;"><?php echo $customer['address_1']." ".$customer['address_2']; ?></td>						
						<td style="border-bottom: 1px solid black;border-right:1px solid black;"><?php echo $customer['pin']; ?></td>
					  </tr>
				<?php } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	</div>
</div>