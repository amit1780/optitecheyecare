<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> </h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>

	 <!-- Breadcrumbs-->
	<!-- <ol class="breadcrumb">
		<li class="breadcrumb-item">
		  <a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Tables</li>
	</ol> -->
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->	 
	 
  <div class="card mb-3">	
	<div class="card-body">
	
		<form role="form" class="needs-validation" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Customer name</div> 
					<input type="text" name="customer_name" value="<?php if(!empty($this->input->get('customer_name'))){ echo $this->input->get('customer_name'); } ?>" id="customer_name" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Customer Email</div> 
					<input type="text" name="contact_email" value="<?php if(!empty($this->input->get('contact_email'))){ echo $this->input->get('contact_email'); } ?>" id="contact_email" class="form-control">					
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Contact Phone</div> 
					<input type="text" name="contact_phone" value="<?php if(!empty($this->input->get('contact_phone'))){ echo $this->input->get('contact_phone'); } ?>" id="contact_phone" class="form-control">					
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Currency</div> 
						<select name="currency_id" class="form-control">
								<option value="">-- Select --</option>
							<?php foreach($currencies as $currency){ ?>
								<option value="<?php echo $currency['id']; ?>" <?php if ($currency['id'] == $this->input->get('currency_id')) echo ' selected="selected"'; ?> ><?php echo $currency['currency']; ?></option>
							<?php } ?>
						</select>
				  </div>
				</div>	
			</div>	
			<div class="row">	
				<div class="col-sm-12 float-right">
					<div class="form-group">
						<button type="submit" id="submit" class="btn btn-primary float-right">Search</button>
					</div>
					<br>
				</div>			
			</div> 	
		</form>
		
		<div class="table-responsive">
			<table class="table-sm table-bordered" width="100%" cellspacing="0">
				<thead>
					<tr>					  
						<th>Customer Name</th>					
						<th>Email</th>					
						<th>Mobile</th>					
						<th>Currency</th>					
											
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if($orders){ ?>
					<?php foreach($orders as $order){ ?>
						<tr>
							<td><a target="_blank" href="<?php echo site_url('customerView');?>/<?php echo $order['customer_id']; ?>"><?php echo $order['customer_name']; ?></a></td>
							<td><?php echo $order['contact_email']; ?></td>
							<td><?php echo $order['contact_phone']; ?></td>							
							<td><?php echo $order['currency']; ?></td>														
							<td><a style="padding-left:7px;" href="<?php echo site_url('orderPendingCustomerView'); ?>/<?php echo $order['customer_id']; ?>" title="" ><i class="fas fa-eye"></i></a></td>
						</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $pagination; ?>
  </div>
  
</div>