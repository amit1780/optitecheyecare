<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-8">
				<h1 style="float: left;"><?php echo $customer->company_name; ?></h1> <?php echo $this->breadcrumbs->show(); ?>			
			</div>
			<div class="col-sm-4">
				<div class="float-right">
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('editCustomer'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top"  title="Edit"><i class="far fa-edit"></i></a>&nbsp;
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('notes'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top" title="Notes"><i class="far fa-sticky-note"></i></a>&nbsp;
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('priceList'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top" title="Price List"><i class="fas fa-list"></i></a>&nbsp;
					<a class="btn btn-primary" target="_blank" href="<?php echo site_url('customerHistory'); ?>/<?php echo $customer->customer_id; ?>" data-toggle="tooltip" data-placement="top" title="Customer History"><i class="fas fa-history"></i></a>
				</div>
			</div>
		</div>
	</div>
	
	
<fieldset class="proinfo">
	<legend>Company Information</legend>
	<div class="row" style='border:1px solid gray;'>
								
		<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2">
						<label class='float-left'>Company Name:</label>
					</div>
					<div class="col-sm-10">
						<label class='float-left'><b><?php echo $customer->company_name; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Contact Person:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customer->contact_person; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-12" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-2" style='border:0px solid red;'>
						<label class='float-left'>Email:</label>
					</div>
					<div class="col-sm-10" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customer->email; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-6" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3">
						<label class='float-left'>Mobile:</label>
					</div>
					<div class="col-sm-9">
						<label class='float-left'><b><?php echo $customer->mobile; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-3" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>Phone:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customer->phone; ?></b></label>
					</div>
				</div>
			</div>
			<div class="col-sm-3" style='border:1px solid gray;'>
				<div class="row">
					<div class="col-sm-3" style='border:0px solid red;'>
						<label class='float-left'>Fax:</label>
					</div>
					<div class="col-sm-9" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $customer->fax; ?></b></label>
					</div>
				</div>
			</div>

		
</fieldset>
</br>
<fieldset class="proinfo">
	<legend>Address Information</legend>
	<div class="row" style='border:1px solid gray;'>
		<div class="col-sm-12" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>Address 1:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->address_1; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-12" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>Address 2:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->address_2; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>Country:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->country; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>State:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->state; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>City:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->city; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-3" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>District:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->district; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-12" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>PIN:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->pin; ?></b></label>
				</div>
			</div>
		</div>

	</div>

</fieldset>
</br>

<fieldset class="proinfo">
	<legend>Identification</legend>
	<div class="row" style='border:1px solid gray;'>
		<div class="col-sm-6" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>Company Registration No:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->driving_licence; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-6" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>GST:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->gst; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-6" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>PAN:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->pan; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-6" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>I/E Code:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->ie_code; ?></b></label>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-2" style='border:0px solid red;'>
					<label class='float-left'>Drug licence No.:</label>
				</div>
				<div class="col-sm-10" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->drug_licence_no; ?></b></label>
				</div>
			</div>
		</div>
		
		<div class="col-sm-6" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>Carrier:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->sli_name; ?></b></label>
				</div>
			</div>
		</div>
		<div class="col-sm-6" style='border:1px solid gray;'>
			<div class="row">
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'>Account Number:</label>
				</div>
				<div class="col-sm-6" style='border:0px solid red;'>
					<label class='float-left'><b><?php echo $customer->account_number; ?></b></label>
				</div>
			</div>
		</div>
		
	</div>

</fieldset>
</br>	

	<div class="col-sm-12 mt-5"> </div>

<div></br>