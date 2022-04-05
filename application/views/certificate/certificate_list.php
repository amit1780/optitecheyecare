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
			  <th>Certificate Name</th>
			  <th>Expiry Date</th>
			  <th>File</th>
			  <th>Action</th>

			</tr>
		  </thead>
		 
		  <tbody>
			<?php if(isset($certificates)){ ?>
				<?php $counter=1; foreach($certificates as $certificate){ ?>					 
					  <tr>
						<td><?php echo $counter++;  ?></td>
						<td><?php echo $certificate['certificate_name']; ?></td>
						<td><?php echo dateFormat('d-m-Y',$certificate['expire_date_time']); ?></td>
						<td>
							<?php if(!empty($certificate['path'])){ ?>
							<a href="<?php echo base_url().$certificate['path']; ?>" target='_blank'>View</a>
							<?php } ?>
						</td>
						<td>
							<a href="<?php echo site_url('editCertificate'); ?>/<?php echo $certificate['certificate_id']; ?>"><i class="far fa-edit"></i></a>
						</td>						
					  </tr>
				<?php } ?>  
			<?php } ?>  
		  </tbody>
		</table>
	  </div>
	</div>
  </div>
</div>