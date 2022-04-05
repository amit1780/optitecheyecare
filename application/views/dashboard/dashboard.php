<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
  <?php //echo $this->breadcrumbs->show(); ?>	
	<div class="page_heading">
		<h1 ><?php echo $page_heading; ?></h1> <?php //echo $this->breadcrumbs->show(); ?>
	</div>
	
	 <?php if(isset($success)){ ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
	<?php } ?>
	<div id="mass"></div>
	<style>
		.reject{color:white !important;}
		.btn{color:white !important;}
		.tile{margin-bottom: 15px;
		border-radius: 3px;
		/* background-color: #279FE0; */
		color: #FFFFFF;
		transition: all 1s;
		}
		.tile{height:140px;}
		.tile-heading {
			padding: 5px 8px;
			text-transform: uppercase;
			/* background-color: #1E91CF; */
			color: #FFF;
			font-weight:bold;
		}
		.tile-body {
			padding: 15px;
			color: #FFFFFF;
			line-height:40px;
		}
		.price{width:100%;float:left;font-size:12px;}
		@media only screen and (max-width: 1300px) {
		  .price{font-size:11px;}
		}
		.tile-footer {
			padding: 0px;
			background-color: #3DA9E3;
		}
		.tile a {
			color: #FFFFFF;
			text-decoration: none;
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
		.orange{background-color: #e9967a;}
		.blue{background-color: #1E90FF;}
		.green{background-color: #00C292;}
		.perpal{background-color: #9675CE;min-height: 125px;}
		.rowp{margin:0px !important;}
		.colleft{padding-left:0px !important;}
		.colright{padding-left:0px !important;} 
	</style>
	
	
	
	<div id="dashboard" class="tab-pane active">				
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile orange">
					<a target="_blank" href="<?php echo site_url('quotation'); ?>">
					  <div class="tile-heading">Pending Quotation <span class="pull-right" style="font-weight: bold;font-size: 16px;"><?php echo count($quotations); ?></span></div>
						<div class="tile-body">
							<div class="row rowp">								
								<div class="col col-sm-6 colleft">
									
										<span class="price"><i class="fas fa-rupee-sign" style="font-size:15px;"></i>&nbsp;<?php if($quotation_inr > 0){ echo number_format((float)$quotation_inr, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-dollar-sign" style="font-size:15px;"></i>&nbsp;<?php if($quotation_usd > 0){ echo number_format((float)$quotation_usd, 2, '.', ''); } else { echo '0.00'; } ?></span>								
									
								</div>
								<div class="col col-sm-6 colright">
									
										<span class="price"><i class="fas fa-euro-sign" style="font-size:15px;"></i>&nbsp;<?php if($quotation_gbp > 0){ echo number_format((float)$quotation_gbp, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-pound-sign" style="font-size:15px;"></i>&nbsp;<?php if($quotation_eur > 0){ echo number_format((float)$quotation_eur, 2, '.', ''); } else { echo '0.00'; } ?></span>								  
									
								</div>
							</div>	
						</div>
					</a>
					  <!-- <div class="tile-footer"><a target="_blank" class="nav-link"  href="<?php echo site_url('quotation'); ?>">View more...</a></div> -->
					</div> 
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile blue">
					<a target="_blank" href="<?php echo site_url('orderList'); ?>">
						<div class="tile-heading">Pending Orders <span class="pull-right" style="font-weight: bold;font-size: 16px;"><?php echo count($pendingOrders); ?></span></div>  
						<div class="tile-body">					  
							<div class="row rowp">
								<div class="col col-sm-6 colleft">
									
										<span class="price"><i class="fas fa-rupee-sign" style="font-size:15px;"></i>&nbsp;<?php if($pendingorder_inr > 0){ echo number_format((float)$pendingorder_inr, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-dollar-sign" style="font-size:15px;"></i>&nbsp;<?php if($pendingorder_usd > 0){ echo number_format((float)$pendingorder_usd, 2, '.', ''); } else { echo '0.00'; } ?></span>
									
								</div>
								<div class="col col-sm-6 colright">
									 
										<span class="price"><i class="fas fa-euro-sign" style="font-size:15px;"></i>&nbsp;<?php if($pendingorder_gbp > 0){ echo number_format((float)$pendingorder_gbp, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-pound-sign" style="font-size:15px;"></i>&nbsp;<?php if($pendingorder_eur > 0){ echo number_format((float)$pendingorder_eur, 2, '.', ''); } else { echo '0.00'; } ?></span>
									
								</div>
							</div>					  
						</div>					  
					 </a>
					  <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('orderList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile green">
					<a target="_blank" href="<?php echo site_url('stockPending'); ?>">
					  <div class="tile-heading">Pending Stock</div>
					  <div class="tile-body"><i class="fas fa-file-invoice"></i>
						<h2 class="pull-right"><?php echo count($pending_stocks); ?></h2>
					  </div>
					 </a>
					<!--  <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div>  -->
					</div>  
				</div>
				<!-- <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
					<div class="tile perpal">
					<!-- <a target="_blank" href="<?php echo site_url('advicePending'); ?>"> 
					<a href="#">
					  <div class="tile-heading">Pending Payment Received Advice </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php echo count($advices); ?></h2>
					  </div>
					</a>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> 
					</div>  
				</div> -->
				
				<!--   Totals  -->					
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile blue">
					<a target="_blank" href="<?php echo site_url('challanList'); ?>">
						<div class="tile-heading">Totals Challans <span class="pull-right" style="font-weight: bold;font-size: 16px;" id="totChallan"><?php echo count($totalChallan); ?></span></div>
						<div class="tile-body">	
							<!-- <img id="totCloader" src="<?php echo base_url().'assets/img/loader.gif'; ?>" style="position: fixed;z-index: 1;"></span> -->
							<div class="row rowp">
								
								<div class="col col-sm-6 colleft">
																	
										<span class="price"><i class="fas fa-rupee-sign" style="font-size:15px;"></i>&nbsp; <span id="totChallanInr"></span><?php if($challan_inr > 0){ echo number_format((float)$challan_inr, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-dollar-sign" style="font-size:15px;"></i>&nbsp; <span id="totChallanUsd"></span><?php if($challan_usd > 0){ echo number_format((float)$challan_usd, 2, '.', ''); } else { echo '0.00'; } ?></span>
									
								</div>
								<div class="col col-sm-6 colright">
																  
										<span class="price"><i class="fas fa-euro-sign" style="font-size:15px;"></i>&nbsp; <span id="totChallanGbp"></span><?php if($challan_gbp > 0){ echo number_format((float)$challan_gbp, 2, '.', ''); } else { echo '0.00'; } ?></span>								  
										<span class="price"><i class="fas fa-pound-sign" style="font-size:15px;"></i>&nbsp; <span id="totChallanEur"></span><?php if($challan_eur > 0){ echo number_format((float)$challan_eur, 2, '.', ''); }  else { echo '0.00'; } ?></span>
									  
								</div>
							</div>			
						</div>			
					</a>  
					
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				
				<!-- <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
					<div class="tile orange">
					<a target="_blank" href="<?php echo site_url('customer'); ?>">
					  <div class="tile-heading">Totals Customers </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php echo count($totalCustomers); ?></h2>
					  </div>
					</a>
					  <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> 
					</div>  
				</div> -->
				
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile perpal">
					<a target="_blank" href="<?php echo site_url('stockRejected'); ?>">
					  <div class="tile-heading">Stock Rejected </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php echo count($reject_stocks); ?></h2>
					  </div>
					 </a>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> -->
					</div>  
				</div>	
				
				<!-- <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
					<div class="tile green">
					<!-- <a target="_blank" href="<?php echo site_url('adviceRejected'); ?>"> 
					<a href="#">
					  <div class="tile-heading">Payment Received Advice Rejected </div>
					  <div class="tile-body"><i class="fa fa-user"></i>
						<h2 class="pull-right"><?php echo count($advicesRejects); ?></h2>
					  </div>
					 </a>
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php echo site_url('customer'); ?>">View more...</a></div> 
					</div>  
				</div> -->
				
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile green">
					<a target="_blank" href="<?php echo site_url('orderList'); ?>">
						<div class="tile-heading">Totals Orders <span class="pull-right" style="font-weight: bold;font-size: 16px;"><?php echo count($totalOrders); ?></span></div>
						<div class="tile-body">					 
							<div class="row rowp">
								<div class="col col-sm-6 colleft">
																 
										<span class="price">
											<i class="fas fa-rupee-sign" style="font-size:15px;"></i>&nbsp;<?php if($order_inr > 0){ echo number_format((float)$order_inr, 2, '.', ''); } else { echo '0.00'; } ?></span>								  
										<span class="price"><i class="fas fa-dollar-sign" style="font-size:15px;"></i>&nbsp;<?php if($order_usd > 0){ echo number_format((float)$order_usd, 2, '.', ''); } else { echo '0.00'; }  ?></span>								 
									
								</div>
								<div class="col col-sm-6 colright">
									 							  
										<span class="price"><i class="fas fa-euro-sign" style="font-size:15px;"></i>&nbsp;<?php if($order_gbp > 0){ echo number_format((float)$order_gbp, 2, '.', ''); } else { echo '0.00'; } ?></span>								   
										<span class="price"><i class="fas fa-pound-sign" style="font-size:15px;"></i>&nbsp;<?php if($order_eur > 0){ echo number_format((float)$order_eur, 2, '.', ''); } else { echo '0.00'; } ?></span>
									 
								</div>
							</div>					  
						</div>					  
					</a> 					
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile perpal">
					<a target="_blank" href="<?php echo site_url('returns'); ?>">
						<div class="tile-heading">Goods Returns</div>
						<div class="tile-body">
							<div class="row rowp">
								<div class="col col-sm-6 colleft">
									
										<span class="price"><i class="fas fa-rupee-sign" style="font-size:15px;"></i>&nbsp;<?php if($return_inr > 0){ echo number_format((float)$return_inr, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-dollar-sign" style="font-size:15px;"></i>&nbsp;<?php if($return_usd > 0){ echo number_format((float)$return_usd, 2, '.', ''); } else { echo '0.00'; } ?></span>
									
								</div>
								<div class="col col-sm-6 colright">
									
										<span class="price"><i class="fas fa-euro-sign" style="font-size:15px;"></i>&nbsp;<?php if($return_gbp > 0){ echo number_format((float)$return_gbp, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-pound-sign" style="font-size:15px;"></i>&nbsp;<?php if($return_eur > 0){ echo number_format((float)$return_eur, 2, '.', ''); } else { echo '0.00'; } ?></span>
									 
								</div>
							</div>				 
						</div>				 
					</a> 					
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile orange">
					<a target="_blank" href="<?php echo site_url('customer'); ?>">
						<div class="tile-heading">Payment Dues</div>
						<div class="tile-body">
							<div class="row rowp">
								<div class="col col-sm-6 colleft">
									
										<span class="price"><i class="fas fa-rupee-sign" style="font-size:15px;"></i>&nbsp;<?php if($pdue_inr > 0){ echo number_format((float)$pdue_inr, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-dollar-sign" style="font-size:15px;"></i>&nbsp;<?php if($pdue_usd > 0){ echo number_format((float)$pdue_usd, 2, '.', ''); } else { echo '0.00'; } ?></span>
									
								</div>
								<div class="col col-sm-6 colright">
									
										<span class="price"><i class="fas fa-euro-sign" style="font-size:15px;"></i>&nbsp;<?php if($pdue_gbp > 0){ echo number_format((float)$pdue_gbp, 2, '.', ''); } else { echo '0.00'; } ?></span>
										<span class="price"><i class="fas fa-pound-sign" style="font-size:15px;"></i>&nbsp;<?php  if($pdue_eur > 0){ echo number_format((float)$pdue_eur, 2, '.', ''); } else { echo '0.00'; } ?></span>
									 
								</div>
							</div>				 
						</div>				 
					</a> 					
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				
				<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
					<div class="tile blue">
					<a target="_blank" href="<?php echo base_url().'index.php/orderList?incomplete_order=incomplete'; ?>">
					  <div class="tile-heading">Incomplete Orders</div>
					  <div class="tile-body"><i class="fas fa-file-invoice"></i>
						<h2 class="pull-right"><?php echo count($incompleteOrder); ?></h2>
					  </div>
					</a> 					
					 <!-- <div class="tile-footer"><a target="_blank" class="nav-link" href="<?php //echo site_url('challanList'); ?>">View more...</a></div> -->
					</div>  
				</div>
				
			</div>
		</div>						
			<!-- End Dashboard -->
		<div class="row">
			<div class="col-sm-12">
				<div class="card mb-3">
					<div class="card-header">
					  <i class="fa fa-globe"></i>
					  Worldwide Business</div>				
					  <div class="panel-body">
						<div id="vmap" style="width: 100%; height: 260px;"></div>
					  </div>			
				</div>
			</div>
		</div>
	
	<link type="text/css" href="<?php echo base_url(); ?>assets/js/jqvmap/jqvmap.css" rel="stylesheet" media="screen" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqvmap/jquery.vmap.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqvmap/maps/jquery.vmap.world.js"></script> 
	
	<script type="text/javascript">
		$(document).ready(function() {
			//MapDetails
			$.ajax({
				url:'<?php echo site_url('getMapDetails'); ?>',
				dataType: 'json',
				success: function(json) {
					data = [];
								
					for (i in json) {
						data[i] = json[i]['total'];
					}
					
					$('#vmap').vectorMap({
						map: 'world_en',
						backgroundColor: '#FFFFFF',
						borderColor: '#FFFFFF',
						color: '#9FD5F1',
						hoverOpacity: 0.7,
						selectedColor: '#666666',
						enableZoom: true,
						showTooltip: true,
						values: data,
						normalizeFunction: 'polynomial',
						onLabelShow: function(event, label, code) {							
							if (json[code]) {
								label.html('<strong>' + label.text() + '</strong><br />' + 'Customers - ' + json[code]['total'] + '<br />'+'Pending Quotation - ' + json[code]['pending_quotation'] + '<br />' + 'Pending Orders - ' + json[code]['pending_order']);
							} 
						}
					});			
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
			
			//Get Total Challans
			$("#totCloader").hide();
			/* $.ajax({
                url:'<?php echo site_url(); ?>'+'/dashboard/getTotalChallan',
                dataType: 'json',
                beforeSend:function(){
                    $("#totCloader").show();
                },
                success: function(response){
					$("#totCloader").hide();
					$("#totChallan").html(response.totalChallan);
					$("#totChallanInr").html(response.challan_inr);
					$("#totChallanUsd").html(response.challan_usd);
					$("#totChallanEur").html(response.challan_eur);
					$("#totChallanGbp").html(response.challan_gbp);
                }
            });		 */	
			
		});
		
	</script> 
</div>