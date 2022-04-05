<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	.tile{margin-bottom: 15px;
		border-radius: 3px;
		background-color: #279FE0;
		color: #FFFFFF;
		transition: all 1s;
		}
	.tile-heading {
		padding: 5px 8px;
		text-transform: uppercase;
		background-color: #1E91CF;
		color: #FFF;
		}
	.tile-body {
		padding: 15px;
		color: #FFFFFF;
		line-height: 48px;
	}
	.tile-footer {
		padding: 5px 8px;
		background-color: #3DA9E3;
	}
	.tile a {
		color: #FFFFFF;
	}
	.tile .tile-body i {
		font-size: 50px;
		opacity: 0.3;
		transition: all 1s;
	}
	.tile .tile-body h2 {
		font-size: 42px;
	}
	.pull-right {
		float: right !important;
	}
</style>
<div class="container-fluid">
	<?php //echo $this->breadcrumbs->show(); ?>	
	<div class="page_heading">		
		<h1 style="float: left;"><?php //echo $page_heading; ?> <?php echo $customer->company_name; ?></h1> <?php echo $this->breadcrumbs->show(); ?>		
	</div>
	
    <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	 <!-- DataTables Example -->
  <div class="mb-3">  
		<!-- Tabs Section -->
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#dashboard">Dashboard</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#quotation">Quotation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#order">Order</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#challan">Challan</a>
			</li>			
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#return">Return</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#payment">Payment</a>
			</li>
		</ul>
		<!-- Tabs Section -->
		
		<div class="tab-content">
			<!-- Dashboard -->
			
			<div id="dashboard" class="tab-pane active"><br>
				<h3></h3>
				<div class="row">
					<div class="col-sm-3">
						<div class="tile">
						  <div class="tile-heading">Total Quotation </div>
						  <div class="tile-body"><i class="fas fa-quote-left"></i>
							<h2 class="pull-right"><?php echo count($quotations); ?></h2>
						  </div>
						  <!-- <div class="tile-footer"><a class="nav-link" data-toggle="tab" href="#quotation">View more...</a></div> -->
						</div> 
					</div>
					<div class="col-sm-3">
						<div class="tile">
						  <div class="tile-heading">Total Orders </div>
						  <div class="tile-body"><i class="fa fa-shopping-cart"></i>
							<h2 class="pull-right"><?php echo count($orders); ?></h2>
						  </div>
						  <!-- <div class="tile-footer"><a href="#order">View more...</a></div> -->
						</div>  
					</div>
					<div class="col-sm-3">
						<div class="tile">
						  <div class="tile-heading">Total Challans</div>
						  <div class="tile-body"><i class="fas fa-file-invoice"></i>
							<h2 class="pull-right"><?php echo count($challanInfo); ?></h2>
						  </div>
						  <!-- <div class="tile-footer"><a href="#challan">View more...</a></div> -->
						</div>  
					</div>
					<div class="col-sm-3">
						<div class="tile">
						  <div class="tile-heading">Total Returns (Qty of Products)</div>
						  <div class="tile-body"><i class="fas fa-exchange-alt"></i>
							<h2 class="pull-right"><?php echo $returnQty; ?></h2>
						  </div>
						  <!-- <div class="tile-footer"><a href="#return">View more...</a></div> -->
						</div>  
					</div>
					<div class="col-sm-3">
						<div class="tile">
						  <div class="tile-heading">Total Payments </div>
						  <div class="tile-body">
							<div class="row">
								<div class="col-sm-6">
									<i class="fa fa-credit-card"></i>
								</div>
								<div class="col-sm-6">
									<?php if($inr){ ?>
									<h6 class="pull-right" style="width:100%;"><li class="fas fa-rupee-sign"></li> <?php echo $inr; ?></h6>
									<?php } ?>
									<?php if($usd){ ?>
									<h6 class="pull-right" style="width:100%;"><li class="fas fa-dollar-sign"></li> <?php echo $usd; ?></h6>
									<?php } ?>
									<?php if($eur){ ?>
									<h6 class="pull-right" style="width:100%;"><li class="fas fa-euro-sign"></li> <?php echo $eur; ?></h6>
									<?php } ?>
									<?php if($gbp){ ?>
									<h6 class="pull-right" style="width:100%;"><li class="fas fa-pound-sign"></li> <?php echo $gbp; ?></h6>
									<?php } ?>
																	
								</div>
							</div>
						  </div>
						  <!-- <div class="tile-footer"><a href="#payment">View more...</a></div> -->
						</div>  
					</div>
					
				</div>
			</div>						
			<!-- End Dashboard -->
			
			
			<!-- Quotation -->
			<div id="quotation" class="tab-pane fade"><br>
				<h3>Quotation</h3>
				<div class="table-responsive">
					<table class="table-sm table-bordered display" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>Quotation Date</th>
							  <th>Quotation No</th>
							  <th>Order No</th>							  
							  <th>Grand Total</th>
							  <th>Customer Name</th>
							  <th>Customer ID</th>
							  <th>Contact No</th>
							  <th>Action</th>
							 </tr>
						  </thead>
						  <tbody>
							<?php if(isset($quotations)){ ?>
								<?php foreach($quotations as $quotation){ ?>														
									<tr>
										<td><?php echo dateFormat('d-m-Y',$quotation['created_time']); ?></td>
										<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['quote_id']; ?>" title="View" ><?php echo getQuotationNo($quotation['quote_id']); ?></a></td>
										<td>
											<a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $quotation['order_id']; ?>" title="Order View" >
											<?php if($quotation['order_id']){ echo getOrderNo($quotation['order_id']); } ?>
											</a>
										</td>									
										<td><li class="<?php echo $quotation['currency_faclass']; ?>"></li> <?php echo $quotation['grand_total']; ?></td>
										<td><?php echo $quotation['customer_name']; ?></td>
										<td><?php echo $quotation['customer_id']; ?></td>
										<td><?php echo $quotation['contact_phone']; ?></td>
										<td class="">
											&nbsp;&nbsp;<a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $quotation['quote_id']; ?>" title="View" ><i class="fas fa-eye"></i></a>										
										</td>
									</tr>
								<?php } ?>  
							<?php } ?>  
						  </tbody>
					</table>
				</div>
			</div>
			<!-- End Quotation -->	
			
			<!-- Order -->			
			<div id="order" class="tab-pane fade"><br>
				<h3>Order</h3>
				<div class="table-responsive">
					<table class="table-sm table-bordered display" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>Order Date</th>
							  <th>Order No</th>
							  <th>Quotation No</th>
							  <th>Customer Name</th>
							 
							  <th>Order Total</th>
							  <th>Payment Receive</th>							  
							  <th>Action</th>
							 </tr>
						  </thead>
					  <tbody>
					 
						<?php if(isset($orders)){ ?>				
							<?php foreach($orders as $order){ ?>				
								<tr class="<?php if($order['totalOrderProduct'] > 0){ echo "alert-danger";} ?>">									
									<td><?php echo dateFormat('d-m-Y',$order['order_date']); ?></td>
									<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>" title="Order View" ><?php echo getOrderNo($order['order_id']); ?></a></td>
									<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $order['quotation_id']; ?>" title="View" ><?php echo getQuotationNo($order['quotation_id']); ?></a></td>
									<td><?php echo $order['customer_name']; ?></td>
									
									<td><li class="<?php echo $order['currency_faclass']; ?>"></li> <?php echo $order['order_total']; ?></td>
									<td><?php echo $order['advice_total']; ?></td>															
									<td class="">
										&nbsp;&nbsp;<a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $order['order_id']; ?>" title="Order View" ><i class="fas fa-eye"></i></a>										
									</td>
								</tr>
							<?php } ?>  
						<?php } ?>  
					  </tbody>
					</table>
				</div>
			</div>
			<!-- End Order -->
			
			<!-- Challan -->		
			<div id="challan" class="tab-pane fade"><br>
				<h3>Challan</h3>
				<div class="table-responsive">
					<table class="table-sm table-bordered display" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>Challan Date</th>
							  <th>Challan No</th>
							  <th>Order No</th>
							  <th>Quotation No</th>
							  <th>Customer Name</th>
							  <th>Grand Total</th>
							  <th>Challan type</th>
							  <th>Invoice No</th>
							  <!-- <th>Challan Date</th> -->
							  <th>Action</th>
							 </tr>
						  </thead>
					  <tbody>
						<?php if(isset($challanInfo)){ ?>
							<?php foreach($challanInfo as $challan){ ?>				
								<tr>
									<?php
										/* if($challan['date_added'] != '0000-00-00 00:00:00'){
											$date_added = new DateTime($challan['date_added']);
											$date_added = $date_added->format('d-m-Y');
										} else {
											$date_added = '';
										} */										
										
									?>
									<td><?php echo dateFormat('d-m-Y',$challan['challan_date']); ?></td>
									<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challan['challan_id']; ?>" title="Challan View" ><?php echo getChallanNo($challan['challan_id']); ?></a></td>
									<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challan['order_id']; ?>" title="Order View" ><?php echo getOrderNo($challan['order_id']); ?></a></td>
									<td><a target="_blank" href="<?php echo site_url('quotationView'); ?>/<?php echo $order['quotation_id']; ?>" title="View" ><?php echo getQuotationNo($challan['quotation_id']); ?></a></td>
									<td><?php echo $challan['company_name']; ?></td>
									<td><li class="<?php echo $challan['currency_faclass']; ?>"></li> <?php echo $challan['grand_total']; ?></td>
									<td><?php echo $challan['challan_type']; ?></td>
									<td><?php echo $challan['invoice_no']; ?></td>						
									<!-- <td><?php echo $challan_date; ?></td> -->						
									<td class="text-center">
										<a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $challan['challan_id']; ?>" title="Challan View" ><i class="fas fa-eye"></i></a> &nbsp;
										
									</td>
								</tr>
							<?php } ?>  
						<?php } ?>  
					  </tbody>
					</table>
				</div>
			</div>
			<!-- End Challan -->	
			
			<!-- Challan -->
			<div id="payment" class="tab-pane fade"><br>
				<h3>Payment</h3>
				<div class="table-responsive">
					<table class="table-sm table-bordered display" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Date</th>					
								<th>Order No</th>					
								<th>Bank Name</th>					
								<th>Bank Ref. No</th>
								<!-- <th>Currency</th> -->
								<th>Amount</th>
								<th>Bank File</th>								
								<!-- <th>Action</th> -->
							</tr>
						</thead>
						<tbody>
						<?php if($advices){ ?>
							<?php foreach($advices as $advice){ ?>								
								<tr>	
									<td><?php echo dateFormat('d-m-Y',$advice['date_added']); ?></td>
									<td><?php echo getOrderNo($advice['order_id']); ?></td>
									<td><?php echo $advice['bank_name']; ?></td>
									<td><?php echo $advice['bank_ref_no']; ?></td>
									<!-- <td><?php //echo $advice['currency']; ?></td> -->
									<td><li class="<?php echo $advice['currency_faclass']; ?>"></li> <?php echo $advice['amount']; ?></td>
									<td><a href="<?php echo base_url().'uploads/bank/'.$advice['bank_file']; ?>" target="_blank"><?php echo $advice['bank_file']; ?></a></td>
									
									<!-- <td align="center">									
									</td> -->
								</tr>
							<?php } ?>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- End Challan -->
			
			<!-- Return -->
			<div id="return" class="tab-pane fade"><br>
				<h3>Return</h3>
				<div class="table-responsive">
					<table class="table-sm table-bordered display" width="100%" cellspacing="0">
						<thead>
							<tr>
							  <th>Return Date</th>
							  <th>Order No</th>
							  <th>Challan No</th>
							  <th>Product Description</th>
							  <th>Batch No.</th>
							  <th>Exp. Date</th>
							  <th>Qty Sold</th>
							  <th>Qty Returns</th>							  
							  <th>Action</th>
							 </tr>
						  </thead>
						<tbody>
						<?php if(isset($returnInfo)){ $returnQty = ''; ?>
							<?php foreach($returnInfo as $returnPro){ ?>
								<?php
									if($returnPro['return_qty'] == 0){
										continue;
									} 
									$expDate = new DateTime($stock['batch_exp_date']);									
									$returnQty = $returnQty + $returnPro['qty'];
								?>
								  <tr>
									<td><?php echo dateFormat('d-m-Y',$returnPro['return_datetime']); ?></td>
									<td><a target="_blank" href="<?php echo site_url('orderView'); ?>/<?php echo $challan['order_id']; ?>" title="Order View" ><?php echo getOrderNo($returnPro['order_id']); ?></a></td>
									<td><a target="_blank" href="<?php echo site_url('challanView'); ?>/<?php echo $returnPro['challan_id']; ?>" title="Challan View" ><?php echo getChallanNo($returnPro['challan_id']); ?></a></td>
									<td><?php echo $returnPro['pro_description']; ?></td>
									<td><?php echo $returnPro['batch_no']; ?></td>
									<td><?php echo dateFormat('m/Y',$returnPro['batch_exp_date']); ?></td>
									<td><?php echo $returnPro['qty']; ?></td>
									<td><?php echo $returnPro['return_qty']; ?></td>
									<td class="text-center"> <a target="_blank" href="<?php echo site_url('addReturns'); ?>?challan_no=<?php echo $returnPro['challan_id']; ?>&id=<?php echo $returnPro['challan_pro_id']; ?>" title="Edit"><i class="far fa-edit"></i></a></td>
								  </tr>
							<?php } ?>  
						<?php $gobl = $returnQty ;  } ?>  
						</tbody>
					</table>
				</div>
			</div>
			<!-- End Return -->
			
		</div>	
  </div>
</div>

<script>
$(document).ready(function() {
	$('table.display').DataTable();
} );
</script>
