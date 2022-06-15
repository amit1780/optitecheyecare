<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<?php echo $this->breadcrumbs->show(); ?>

<style>
input{border: 1px solid gray;}	
textarea{border: 1px solid gray;}	
</style>	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">				
				<h1 >Create Sli</h1> <?php echo $this->breadcrumbs->show(); ?>	
			</div>
			<div class="col-sm-6">
				<div class="float-right">
					<a href="#" class="btn btn-primary" id="mailbox" data-toggle="tooltip" data-placement="top" title="Email"><i class="fas fa-envelope"></i></a>					
				</div>
			</div>			
		</div>
	</div>
	
	<?php if(isset($success)){ ?>
		<div class="alert alert-success">
		  <?php echo $success; ?>
		</div>
	<?php } ?>
	
	<?php if(isset($error)){ ?>
		<div class="alert alert-danger">
		  <?php echo $error; ?>
		</div>
	<?php } ?>
	
	<?php if(empty($challan_sli_id)){ ?>
		<form role="form" class="needs-validation"  method="get" action="<?php echo site_url('sli/createSli');?>" >
			<input type="hidden" name="challan_id" value="<?php echo $challan_id; ?>">
			<div class="row">
				<div class="col-sm-12">			
					<div class="row" >				
						<div class="col-sm-3">						  
						  <div class="form-group">
							<div class="control-label" >Select SLI</div> 
							<select name="sli_id" id="sli_id" class="form-control">
								<option value="0">--Select--</option>
								<?php foreach($sli as $sl){ ?>
									<option value="<?php echo $sl['sli_id'] ?>" <?php if (isset($sl['sli_id']) && $sl['sli_id'] == $sli_id) { echo ' selected="selected"'; } ?>><?php echo $sl['sli_name'] ?></option>
								<?php } ?>
							</select>
						  </div>
						</div>										
					</div>			
				</div>
			</div>			
		</form>
	<?php } ?>
	
	<?php if(!empty($sli_id)){ ?>
	
	<span>Consignee Name: <b><?php echo $ordersInfo->customer_name; ?></b></span> &nbsp;&nbsp;|&nbsp;&nbsp; <span>Invoice No.: <b><?php echo $challanInfo->invoice_no; ?></b></span> &nbsp;&nbsp;|&nbsp;&nbsp; <span>Sli : <b><?php echo $challanInfo->sli_name; ?></b></span>
	<div style="border:1px solid gray;padding:10px;">
		<form role="form" class="needs-validation"  method="post" action="<?php echo site_url('sli/createSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" >
			<input type="hidden" name="challan_id" value="<?php echo $challan_id; ?>">
			<input type="hidden" name="sli_id" value="<?php echo $sli_id; ?>">
			<?php if($sliDetailInfo->sli_detail_id) { ?>
				<input type="hidden" name="sli_detail_id" value="<?php if($sliDetailInfo->sli_detail_id) { echo $sliDetailInfo->sli_detail_id; } ?>">
			<?php } ?>
			
			<?php if($sli_id == 1){ ?>
				<?php echo $this->load->view('sli/dhl_form', $data,true); ?>
				
				<div class="row">
					<div class="col-sm-12">	
						<a target="_blank" href="<?php echo site_url('sli/printSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" class="btn btn-primary float-right" style="margin-left:10px;">Print Sli</a>
						<?php if($challanInfo->sli_status == 'N'){ ?>
							<button type="submit" class="btn btn-primary float-right" style="margin-left:10px;">Save</button>
						<?php } ?>																	  
					</div>	
				</div>
				
			<?php }else if($sli_id == 2){ ?>
				<?php echo $this->load->view('sli/fedex_form', $data,true); ?>
				
				<div class="row">
					<div class="col-sm-12">	
						<a target="_blank" href="<?php echo site_url('sli/printSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" class="btn btn-primary float-right" style="margin-left:10px;">Print Sli</a>
						<?php if($challanInfo->sli_status == 'N'){ ?>
							<button type="submit" class="btn btn-primary float-right" style="margin-left:10px;">Save</button>
						<?php } ?>																	  
					</div>	
				</div>
				
			<?php }else if($sli_id == 3){ ?>
				<?php echo  $this->load->view('sli/tnt_form', $data,true); ?>
				
				<div class="row">
					<div class="col-sm-12">	
						<a target="_blank" href="<?php echo site_url('sli/printSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" class="btn btn-primary float-right" style="margin-left:10px;">Print Sli</a>
						<?php if($challanInfo->sli_status == 'N'){ ?>
							<button type="submit" class="btn btn-primary float-right" style="margin-left:10px;">Save</button>
						<?php } ?>																	  
					</div>	
				</div>
				
			<?php }else if($sli_id == 9){ ?>
				<?php echo  $this->load->view('sli/ups_form', $data,true); ?>
				
				<div class="row">
					<div class="col-sm-12">	
						<a target="_blank" href="<?php echo site_url('sli/printSli');?>?challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>" class="btn btn-primary float-right" style="margin-left:10px;">Print Sli</a>
						<?php if($challanInfo->sli_status == 'N'){ ?>
							<button type="submit" class="btn btn-primary float-right" style="margin-left:10px;">Save</button>
						<?php } ?>																	  
					</div>	
				</div>
				
			<?php } else { ?>
				<p style="margin:0px;font-weight:550;"> Sli not implemented <?php echo $challanInfo->sli_name; ?>. </p>
			<?php } ?>
			
				
				
		</form>
	</div>
	<?php } ?>	
</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" >				
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Send Mail</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>			  
			</div>
			<div id="alert-danger"></div>
			<div class="modal-body">
				<form method="post" action="" id="challanMailForm" enctype="multipart/form-data" >					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">To :</div>															
							<div class="col-sm-10"> <input type="text" name="email_to" value="<?php echo $ordersInfo->contact_email; ?>" autocomplete='off'  id="email_to" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">CC :</div>															
							<div class="col-sm-10"> <input type="text" name="email_cc" value=""  id="email_cc" autocomplete='off' class="form-control"></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Subject:</div>															
							<div class="col-sm-10"> <input type="text" name="email_subject" autocomplete='off' value="Challan / Performa Invoice - <?php echo getChallanNo($challan_id); ?>"  id="email_subject" class="form-control" required></div>
						</div>						
					</div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">Massage:</div>															
							<div class="col-sm-10">
							<textarea class="form-control" rows="7" name="email_massage" id="email_massage">Dear <?php echo $customerInfo->person_title; ?> <?php echo $ordersInfo->contact_person; ?>,

Please find the Order as attached in email bellow.

Thank you,
Optitech Eye Care</textarea>
							</div>
						</div>						
					</div>
					
					<div id="challanfiletextbox"> </div>
					
					<div class="form-group">
						<div class="row">						
							<div class="col-sm-2">File:</div>															
							<div class="col-sm-10">
								<div id="challanfile"></div>
							</div>
						</div>						
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">									
								<button type="button" id="sendMail" class="btn btn-primary float-right"> Send Mail</button>	
							</div>
						</div>						
					</div>					
				</form>
			</div>
		</div>				  
	</div>
</div>

<script>
$(document).ready(function() {
	/* var challan_sli_id = '<?php echo $challan_sli_id; ?>';
	var sli_id = '<?php echo $sli_id; ?>';
	
	if(challan_sli_id){
		location.href = 
	} */
	 
	$('#sli_id').change(function() {
        this.form.submit();
    });

	$("#mailbox").click(function(){			
		$.ajax({
			url:'<?php echo site_url('sli/sliSavePdf'); ?>',
			method: 'post',
			data: 'challan_id=<?php echo $challan_id; ?>&sli_id=<?php echo $sli_id; ?>', 
			dataType: 'json',
			beforeSend: function(){
				   $('.loader').show();
			   },
			complete: function(){
				   $('.loader').hide();
			},
			success: function(response){
				if(response){						
					var htm = '';
					var hiddentext = '';						
					$.each(response, function(i,res) {
						
						htm += '<a href="<?php echo base_url(); ?>'+ res.challan_file +'" target="_blank" > '+ res.challan_file_name +' </a> &nbsp;';
						
						hiddentext += '<input type="hidden" name="challan_file" value="'+res.challan_file+'">';							
					});						
					$("#challanfile").html(htm);
					
					$("#challanfiletextbox").html(hiddentext); 
				}
				$("#myModal").modal();		
			}
		});				
	});
	
	$("#sendMail").click(function(){		
		var data_form = $('#challanMailForm').serialize();
		$.ajax({
			url:'<?php echo site_url('sli/SendMail'); ?>',
			method: 'post',
			data: data_form,
			dataType: 'json',
			success: function(response){
				$("#alert-danger").html('');
				var htm = '<div class="alert alert-success" role="alert">Successfully Mail Send.</div>';
				$("#alert-danger").html(htm);
				setTimeout(function(){
					$("#myModal .close").click();
					$("#alert-danger").html('');
				}, 3000);
			}
		});				
	});	
});
</script>