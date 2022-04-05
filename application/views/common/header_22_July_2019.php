<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Optitech Eye Care</title>

    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
	
	 <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	 <script src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>
	
	
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
	
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
	<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css" rel="stylesheet"> 
    <script src="<?php echo base_url(); ?>/assets/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/common.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/print.js"></script>
	
	<script>  
		  $(document).ready(function() {
			$(".btnPrint").printPage();
		  });
	</script>
  </head>
    <style>
      .loading-image {
    	  position: absolute;
    	  top: 50%;
    	  left: 50%;
    	  z-index: 10;
    	}
    	.loader
    	{
    		display: none;
    		width:200px;
    		height: 200px;
    		position: fixed;
    		top: 50%;
    		left: 50%;
    		text-align:center;
    		margin-left: -50px;
    		margin-top: -100px;
    		z-index:2;
    		overflow: auto;
    	}
    	nav .pagination .page-link{padding:0px;line-height: 2;}
    	nav .pagination .page-link a{padding:.75rem .75rem;}
	    nav .pagination .page-item.active .page-link{padding-left:12px;padding-right:12px;}
    	
    </style>
  <body id="page-top">
      
    <div class="loader">
	   <center>
		   <img class="loading-image" src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading..">
	   </center>
	</div>

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
	 <?php if($this->session->userdata('group_type') != 'EMP'){ ?>
      <a class="navbar-brand mr-1" href="<?php echo site_url('dashboard'); ?>">Optitech Eye Care</a>
	 <?php } else { ?>
      <a class="navbar-brand mr-1" href="">Optitech Eye Care</a>
	<?php } ?>
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <!-- <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"> -->
          <div class="input-group-append">
            <!-- <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button> -->
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
       
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $this->session->userdata['firstname'].' '.$this->session->userdata['lastname']; ?> <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <!-- <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="<?php echo site_url('changePassword');?>" >Change Password</a>
            <a class="dropdown-item" href="<?php echo site_url('logout');?>" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>
	
	 <div id="wrapper">
	
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
		<?php if($this->session->userdata('group_type') != 'EMP'){ ?>
	  
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
       
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Product</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">				
				<a class="dropdown-item" href="<?php echo site_url('product');?>">Product List</a>
				<a class="dropdown-item" href="<?php echo site_url('addProduct');?>">Add product</a>
				<a class="dropdown-item" href="<?php echo site_url('categoryList');?>">Category List</a>
			</div>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Certificate</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">				
				<a class="dropdown-item" href="<?php echo site_url('certificate');?>">Certificate List</a>
				<a class="dropdown-item" href="<?php echo site_url('addCertificate');?>">Add Certificate</a>
			</div>
        </li>

		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Stock</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">	
				<a class="dropdown-item" href="<?php echo site_url('dashboard');?>">Pending Stock</a>
				<a class="dropdown-item" href="<?php echo site_url('stock');?>">Stock List</a>
				<?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='ADMIN'){ ?>
				<a class="dropdown-item" href="<?php echo site_url('addStock');?>">Add Stock</a>
				<?php } ?>
				<a class="dropdown-item" href="<?php echo site_url('batch');?>">Batch List</a>
				<!-- <?php if($this->session->userdata('group_type')=='SADMIN' || $this->session->userdata('group_type')=='ADMIN'){ ?>
				<a class="dropdown-item" href="<?php echo site_url('addBatch');?>">Add Batch</a>				
				<?php } ?> -->
			</div>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Customer</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">				
				<a class="dropdown-item" href="<?php echo site_url('customer');?>">Customer List</a>
				<a class="dropdown-item" href="<?php echo site_url('addCustomer');?>">Add Customer</a>
			</div>
        </li>
		<!-- AMIT-->
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Orders</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">	
			    <a class="dropdown-item" href="<?php echo site_url('quotation');?>">Quoation List</a>
			    <a class="dropdown-item" href="<?php echo site_url('quoteComplete');?>">Quoation History</a>
				<a class="dropdown-item" href="<?php echo site_url('addQuote');?>">Generate Quoation</a>
				<a class="dropdown-item" href="<?php echo site_url('orderList');?>">Order List</a>
				<a class="dropdown-item" href="<?php echo site_url('challanList');?>">Challan List</a>
			</div>
        </li>
		<!--Amit-->
		
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Returns</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">	
			    <a class="dropdown-item" href="<?php echo site_url('returns');?>">Returns List</a>
				<a class="dropdown-item" href="<?php echo site_url('addReturns');?>">Add Returns</a>
			</div>
        </li>
		
		<?php if($this->session->userdata('group_type')=='SADMIN' ){ ?>
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Banks</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">	
				<a class="dropdown-item" href="<?php echo site_url('bank');?>">Bank List</a>		
				<a class="dropdown-item" href="<?php echo site_url('addBank');?>">Add Bank</a>			
			</div>
        </li>
		<?php } ?>
		
		<?php } else { ?>
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Manage Records</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">	
				<a class="dropdown-item" href="<?php echo site_url('records');?>">Record-2018</a>					
				<a class="dropdown-item" href="<?php echo site_url('addRecord');?>">Add Record-2018</a>					
			</div>
        </li>
		<?php } ?>
		
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Reports</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">				
				<a class="dropdown-item" href="<?php echo site_url('orderPendingProduct');?>" >Pending Order <br>By Products</a>
				<a class="dropdown-item" href="<?php echo site_url('orderPendingCustomer');?>" >Pending Order <br> By Customers</a>			
			</div>
        </li>
		
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>My Account</span></a>			
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">
				<a class="dropdown-item" href="<?php echo site_url('changePassword');?>" >Change Password</a>
				<a class="dropdown-item" href="<?php echo site_url('logout');?>">Logout</a>
			</div>
        </li>
		
      </ul>
	  
	<script>
		$(document).ready(function(){
		  $(".dropdown-item").click(function(){
			 // alert("hiiiiiiiiiiiii");
			   //$(this).parent().addClass('show');
		  });
		});
	</script>
	
	  <div id="content-wrapper">
	
