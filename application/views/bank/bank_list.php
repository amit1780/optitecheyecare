<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">		
	<div class="page_heading">
		<h1 style="float: left;"><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
		 
  <div class="card mb-3">
	
	<div class="card-body">
	  <div class="table-responsive">
		<table class="table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  
			  <th>Bank Name</th>
			  <th>Beneficiary Name</th>
			  <th>Account No</th>
			  <th>Action</th>

			</tr>
		  </thead>
		 
		  <tbody>
			<?php if(isset($banks)){ ?>
				<?php foreach($banks as $bank){ ?>
				        
					  <tr>
						<td><?php echo $bank['bank_name']; ?></td>
						<td><?php echo $bank['beneficiary_name']; ?></td>
						<td><?php echo $bank['account_number']; ?></td>						
						<td>
							<a href="<?php echo site_url('bankView'); ?>/<?php echo $bank['id']; ?>" title="View" ><i class="fas fa-eye"></i></a>
						    &nbsp;&nbsp; 
							<a href="<?php echo site_url('editBank'); ?>/<?php echo $bank['id']; ?>"  title="Edit"><i class="far fa-edit"></i></a>
						</td>						
					  </tr>
				<?php } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
 
</div>