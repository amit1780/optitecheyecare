<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
		
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">
				
				<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
				
			</div>
			 <div class="col-sm-6">
				<div class="float-right">
					<a href="<?php echo site_url('packer'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Packer"> <i class="fas fa-plus"></i></a>
				</div>
			</div> 	
		</div>		
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->
	<style>
		.auto ul{width:100%;padding-left:6px;}
		.auto ul{max-height: 200px;overflow-y: scroll};
	</style>
  <div class="card mb-3">	
	<div class="card-body">		
		<!-- <form role="form" class="needs-validation" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data" novalidate>
			<div class="row">														
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label" >Country</div> 
					<?php $country_id = $this->input->get('country_id'); ?>
					<select name="country_id" id="country_id" class="form-control" onChange="getState(this.value)" required>
						<option value="">-- Seclect --</option>
						<?php foreach($countries as $country){ ?>
							<option value="<?php echo $country['country_id']; ?>" <?php if (isset($country_id) && $country_id == $country['country_id']) { echo ' selected="selected"'; } ?> ><?php echo $country['name']; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Required
					</div>
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">State</div> 
						<select name="state_id" id="state_id" class="form-control" required>
							
						</select>
					<div class="invalid-feedback">
						Required
					</div>
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">City</div> 
					<input type="text" name="city" value="<?php if(!empty($this->input->get('city'))){ echo $this->input->get('city'); } ?>" id="city" class="form-control" required>
					<div class="invalid-feedback">
						Required
					</div>
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group auto">
					<div class="control-label">Company name</div> 
					<input type="text" name="company_name" value="<?php if(!empty($this->input->get('company_name'))){ echo $this->input->get('company_name'); } ?>" id="company_name" class="form-control" required>
					<div class="invalid-feedback">
						Required
					</div>
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Email</div> 
					<input type="text" name="email" value="<?php if(!empty($this->input->get('email'))){ echo $this->input->get('email'); } ?>" id="email" class="form-control" required>
					<div class="invalid-feedback">
						Required
					</div>
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Contact Person</div> 
					<input type="text" name="contact_person" value="<?php if(!empty($this->input->get('contact_person'))){ echo $this->input->get('contact_person'); } ?>" id="contact_person" class="form-control" required>
					<div class="invalid-feedback">
						Required
					</div>
				  </div>
				</div>
				
				
				
				<div class="col-sm-6">
					<div class="form-group"><br>
						<button type="submit" id="submit" class="btn btn-primary float-right">Search</button>
					</div>
				</div>
				
			</div>	
		</form> -->
	  <div class="table-responsive">
		<table class="table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Full Name</th>				  
				  <th>Email</th>
				  <th>Mobile</th>				 
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			  </thead>
		  <tbody>
			<?php if(isset($packers)){ ?>
				<?php foreach($packers as $packer){ ?>
				
					  <tr>
						<td><?php echo $packer['packer_full_name']; ?></td>						
						<td><?php echo $packer['packer_email']; ?></td>
						<td><?php echo $packer['packer_mobile']; ?></td>						
						<td><?php if($packer['packer_status'] == '1'){ echo "Enable"; } else { echo "Disable"; } ?></td>
						<td class="text-center">
						    <a href="<?php echo site_url('editPacker'); ?>/<?php echo $packer['packer_id']; ?>"  title="Edit Packer" ><i class="fas fa-edit"></i></a>
						</td>
					  </tr>
				<?php } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	</div>
	<?php echo $pagination; ?>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
</div>