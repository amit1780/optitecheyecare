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
		<table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
		  <thead>
			<tr>			  
			  <th>S.N.</th>
			  <th>Category Name</th>
			  <th>Expiry Year</th>
			  <th>Action</th>
			</tr>
		  </thead>
		 
		  <tbody>
			<?php if(isset($categories)){ ?>
				<?php $counter=1; foreach($categories as $category){ ?>
					  
					  <tr>
						<td><?php echo $counter++;  ?></td>
						<td><?php echo $category['name']; ?></td>
						<td><?php echo $category['expiry_year']; ?></td>
						<td>
							&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('editCategory'); ?>/<?php echo $category['category_id']; ?>"><i class="far fa-edit"></i></a>
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