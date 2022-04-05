<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	<div class="page_heading">		
		<h1 style="float: left;"><?php echo $page_heading; ?> (<?php echo $customer->company_name; ?>)</h1> <?php echo $this->breadcrumbs->show(); ?>	
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->
  <div class="card mb-3">
	
	<div class="card-body">
	
	  <div class="table-responsive">
		<table class="table-sm table-bordered" id="" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Quotation&nbsp;No</th>
				  <th>Product Name</th>
				  <th>Model</th>
				  <th>Price</th>				  
				  <th>Date</th>				  
				</tr>
			  </thead>
		  <tbody>
			<?php if(($priceLists)){ ?>
				<?php foreach($priceLists as $priceList){ ?>						
					  <tr>
						<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $priceList['quotation_id']; ?>"><?php echo getQuotationNo($priceList['quotation_id']); ?></a></td>
						<td><a target="_blank" href="<?php echo site_url('productView'); ?>/<?php echo $priceList['prod_id']; ?>"><?php echo $priceList['product_name']; ?></a></td>
						<td><?php echo $priceList['model_name']; ?></td>
						<td><i class="<?php echo $priceList['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo ($priceList['ltp']); ?></td>
						<td><?php echo dateFormat('d-m-Y',$priceList['op_dateadded']); ?></td>
					  </tr>
				<?php } ?>  
			<?php } else { ?>
					<tr>
						<td class="text-center" colspan="5">No results!</td>
					</tr>
			<?php } ?>   
		  </tbody>
		</table>
	  </div>
	</div>
	<?php echo $pagination; ?>
	<!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
  </div>
</div>