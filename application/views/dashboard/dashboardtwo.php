<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">

	<!--<div class="page_heading">
		<h1 ><?php echo $page_heading; ?></h1> ?>
	</div>-->
	
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
								
			<!-- End Dashboard -->
		<div class="row">
			<div class="col-sm-12">
				<div class="card mb-3">
					<div class="card-header">
					 
					  <b>Welcome <?php echo $this->session->userdata['firstname']; ?>!! </b>
					  </div>				
					  <div class="panel-body">
						<div id="vmap" style="width: 100%; height: 260px;"></div>
					  </div>			
				</div>
			</div>
		</div>
	
	 
</div>