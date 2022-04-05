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
			  <th>S.N.</th>
			  <th>Carrier Name</th>
			  <th>Account No</th>
			  <th>Action</th>
			</tr>
		  </thead>
		 
		  <tbody>
			<?php if(isset($carriers)){ ?>
				<?php $i=1; foreach($carriers as $carrier){ ?>
				        
					  <tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $carrier['sli_name']; ?></td>
						<td><?php echo $carrier['sli_account_number']; ?></td>						
						<td>							
							<a href="<?php echo site_url('sli/editCarrier'); ?>?sli_id=<?php echo $carrier['sli_id']; ?>"  title="Edit"><i class="far fa-edit"></i></a>
						</td>						
					  </tr>
				<?php $i++; } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	</div>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
 
</div>