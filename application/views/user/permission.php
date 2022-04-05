<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">
		<h1 ><?php echo $page_heading; ?></h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
	 <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>

	<?php if (isset($error)) : ?>
		<div class="col-md-12">
			<p class="alert-danger" role="alert" style="padding: 12px;border-radius: 5px;">
				<?php echo $error; ?>
			</p>
		</div>
	<?php endif; ?> 
</div>