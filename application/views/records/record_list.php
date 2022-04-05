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
	 <!-- DataTables Example -->
  <div class="card mb-3">
	
	<div class="card-body">
		
		<form role="form" class="needs-validation" data-toggle="validator" method="get" action="<?php echo site_url($form_action);?>" enctype="multipart/form-data">
			<div class="row">				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Bill No</div> 
						<input type="text" name="bill_no" value="<?php if(!empty($this->input->get('bill_no'))){ echo $this->input->get('bill_no'); } ?>" id="bill_no" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Challan Id</div> 
						<input type="text" name="challan_id" value="<?php if(!empty($this->input->get('challan_id'))){ echo $this->input->get('challan_id'); } ?>" id="challan_id" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">Payment Ref. No</div> 
						<input type="text" name="payment_ref_no" value="<?php if(!empty($this->input->get('payment_ref_no'))){ echo $this->input->get('payment_ref_no'); } ?>" id="payment_ref_no" class="form-control" >					
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <div class="form-group">
					<div class="control-label">AWB</div> 
						<input type="text" name="awb" value="<?php if(!empty($this->input->get('awb'))){ echo $this->input->get('awb'); } ?>" id="awb" class="form-control" >					
				  </div>
				  
				  <div class="form-group">
						<button type="submit" id="submit" class="btn btn-primary float-right">Search</button>
					</div>
				</div>		
				
			</div>	
		</form>
		<br>
	  <div class="table-responsive">
		<table class="table-sm table-bordered table-striped" width="100%" cellspacing="0">
			  <thead>
				<tr>
				  <th>Customer Name</th>
				  <th>Bill No</th>
				  <th>Bill Amount</th>
				  <th>Challan Id</th>
				  <th>Payment Bank</th>
				  <th>Payment Ref. No</th>
				  <th>AWB</th>
				  <th width='15%'>Action</th>
				</tr>
			  </thead>
		  <tbody>
			<?php if(isset($records)){ ?>
				<?php foreach($records as $record){ ?>				
						<tr>
							<td><?php echo $record['company_name']; ?></td>
							<td><?php echo $record['bill_no']; ?></td>
							<td><i class="<?php echo $record['currency_faclass']; ?>" style="font-size:13px;"></i>&nbsp;<?php echo $record['bill_amount']; ?></td>
							<td><?php echo str_pad($record['challan_id'], 6, "C00000", STR_PAD_LEFT); ?></td>
							<td><?php echo $record['bank_name']; ?></td>
							<td><?php echo $record['payment_ref_no']; ?></td>
							<td><?php echo $record['awb']; ?></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;						    
								<a href="<?php echo site_url('editRecord'); ?>/<?php echo $record['record_id']; ?>"  title="Edit"><i class="far fa-edit"></i></a> &nbsp;&nbsp;	
								<a href="<?php echo site_url('viewRecord'); ?>/<?php echo $record['record_id']; ?>"  title="View"><i class="far fa-eye"></i></a> &nbsp;&nbsp;
								<?php if(($record['payment_bank'] == 1) || ($record['payment_bank'] == 5) || ($record['payment_bank'] == 6)){ ?>
								<a href="<?php echo site_url('printRecord'); ?>/<?php echo $record['record_id']; ?>" class="btnPrint"  title="View" target="_blank"><i class="fas fa-print"></i></a>
								<?php } ?>								
							</td>
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