<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">	
	
	<div class="page_heading">
		<div class="row">
			<div class="col-sm-6">
				<h1 style="float: left;">View Complaint</h1> <?php echo $this->breadcrumbs->show(); ?>			
			</div>
			 <div class="col-sm-6">
				<div class="float-right">
					<?php if($compaint->status == 'Resolved'){ ?>
						<a href="<?php echo site_url('complaintDownload'); ?>/<?php echo $compaint->complaint_id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> &nbsp; 
					<?php } ?>					
				</div>
			</div> 	
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 conpalintInfoleft" style=''>	
			<div class="page_heading">
				<?php
					if($compaint->status == 'Unresolved'){
						$color = 'red';
					} else {
						$color = 'green';
					}
				?>		
				<h5>Complaint Information &nbsp;&nbsp; <span style="color:<?php echo $color; ?>;font-size:17px;" ><?php echo $compaint->status; ?></span></h5>
			</div>
			<div class="conpalintInfo">
				<div class="row cininfotext">
					<div class="col-sm-12">
						<label class='float-left'>Username:</label>
					</div>
					<div class="col-sm-12">
						<label class='float-left'><b><?php echo $compaint->username; ?></b></label>
					</div>
				</div>
			
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Company Name:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $compaint->company_name; ?></b></label>
					</div>
				</div>
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Category of Complaint:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $compaint->complaint_category_name; ?></b></label>
					</div>
				</div>
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Sub-Category of Complaint:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $compaint->product_category; ?></b></label>
					</div>
				</div>
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Mode of Complaint:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $compaint->complaint_mode_name; ?></b></label>
					</div>
				</div>
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Concern Department for Action:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo $compaint->concern_dept_name; ?></b></label>
					</div>
				</div>
			
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Date of Customer Intimation:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>						
						<label class='float-left'><b><?php echo dateFormat('d-m-Y',$compaint->date_of_customer_info); ?></b></label>
					</div>
				</div>
			
				<div class="row cininfotext">
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'>Date of Complaint:</label>
					</div>
					<div class="col-sm-12" style='border:0px solid red;'>
						<label class='float-left'><b><?php echo dateFormat('d-m-Y',$compaint->date_added); ?></b></label>
					</div>
				</div>
				
				<div class="row cininfotext">
					<?php if (validation_errors()) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							<?php echo validation_errors(); ?>
						</div>
					</div>
					<?php elseif (!empty($errorMsg)) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
								<?php echo $errorMsg; ?>
						</div>
					</div>
					<?php endif; ?>
					
					<?php if(isset($success)){ ?>
					<div class="alert alert-success">
					  <?php echo $success; ?>
					</div>
					<?php } ?>
				
					<div class="page_heading" style="width:100%;"><h6>Update Complaint</h6></div>
					<form  id="customerForm"  method="post" action="<?php echo site_url($form_action);?>" style="width:100%;">
						<input type="hidden" name="complaint_id" value="<?php echo $compaint->complaint_id; ?>">
						<div class="col-sm-12">						
						  <div class="form-group">
							<div class="control-label" >Date of Customer Intimation</div> 
							<input type="text" name="date_of_customer_info" value="" id="date_of_customer_info" class="form-control date" autocomplete="off" required>
							
						  </div>
						</div>	
						<div class="col-sm-12">
						  <div class="form-group">
							<!-- <div class="control-label" >Status</div> 
							 <select name="status" id="status" class="form-control" required>
								<option value="">-- Seclect --</option>
								<option value="Unresolved">Unresolved</option>
								<option value="Resolved">Resolved</option>							
							</select> -->
							<?php if($compaint->status == 'Resolved'){ ?>
								<input type="checkbox" name="status" id="status" value="Resolved" <?php if($compaint->status == 'Resolved'){ echo "disabled"; } ?> checked>
							<?php } else { ?>
								<input type="checkbox" name="status" id="status" value="Resolved" <?php if($compaint->status == 'Resolved'){ echo "disabled"; } ?>>
							<?php }	?>		
							
							<label for="defaultCheck">Is complaint Resolved ?</label>
						  </div>
						</div>
						
						<div class="col-sm-12">
							<button type="submit" id="submit" class="btn btn-primary float-right" <?php if($compaint->status == 'Resolved'){ echo "disabled"; } ?>> Update</button>	
						</div>
						
					</form>
					
				</div>
				
			</div>
		</div>
			
			<div class="col-sm-9 conpalintInforight" >
				<div class="Complaintdetals">
					<div class="page_heading">
						<h5 class="text-left">Details of Complaint</h5>
					</div>
					<div class="messaging">
					  <div class="inbox_msg">	
						<div class="mesgs">
						  <div class="msg_history">
							<?php if($compaintDetails){ $i=1;  $count = count($compaintDetails); ?>
								<?php foreach($compaintDetails as $compaintDetail){ ?>				
									
										<div class="received_withd_msg <?php if($i > 1){ echo "receive_complaint"; } ?>">
											
										  <div class="title"><h6><?php echo $compaintDetail['username']; ?> <span class="dat_time"><?php echo dateFormat('h:i a',$compaintDetail['date_added']); ?>    |    <?php echo dateFormat('d F Y',$compaintDetail['date_added']); ?></span></h6>  </div>
														  
										  <p><span class="message_text"><?php echo nl2br($compaintDetail['message']); ?></span></p>
										  <?php if(!empty($compaintDetail['file'])){ ?>
										  <p style="margin-left:96%;margin-bottom: 0px;"><a href="<?php echo base_url().$compaintDetail['file']; ?>" target="_blank"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 17px;"></i></a></p>
										  <?php } ?>
										  <?php if($i==1 && $count > 1){ ?>
											<span class="readmore"><a id="complaintredas" >View more...</a></span>
										  <?php } ?> 
										  
										  <?php if($i==$count && $count > 1){ ?>
											<span class="readmore"><a id="complainthide" >Hide...</a></span>
										  <?php } ?>
										</div>
											
								<?php $i++; } ?>
							<?php } ?>							
						  </div>
						  <div class="type_msg">
							<div class="input_msg_write">
							  <div class="row">
									<form id="complaintDetailForm" style="width:100%;" enctype="multipart/form-data">
										<div class="col-sm-12">
										   <div class="form-group">
											<textarea name="complaint"  class="form-control complaint" rows="2"  required></textarea>
											<span style="color:gray;font-size:11px;">(Please summarise the complaint within 500 words.)</span>
											<label id="error_complaint" class="error" for="details_of_complaint"></label>
											<input type="hidden" name="mess_type" value="complaint">
											<input type="hidden" name="complaint_id" value="<?php echo $compaint->complaint_id; ?>">
										  </div>
											<div class="row">
												<div class="col-sm-3">  <input type="file"  name="complaint_file"  /> </div><div class="col-sm-9"> <input type="submit" name="submit" class="btn btn-primary float-right complaintBtn" value="Save"/></div>
											</div>				
										</div>
									</form>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				
				<div class="Correctivedetals">
					<div class="page_heading">
						<h5 class="text-left">Brief of Corrective Action Taken</h5>
					</div>
					<div class="messaging">
					  <div class="inbox_msg">	
						<div class="mesgs">
						  <div class="msg_history">
							<?php if($compaintCorrectives){  $j=1;  $count = count($compaintCorrectives); ?>
								<?php foreach($compaintCorrectives as $compaintCorrective){ ?>				
									
										<div class="received_withd_msg <?php if($j > 1){ echo "receive_Corrective"; } ?>">
											
										  <div class="title"><h6><?php echo $compaintCorrective['username']; ?> <span class="dat_time"><?php echo dateFormat('h:i a',$compaintCorrective['date_added']); ?>    |    <?php echo dateFormat('d F Y',$compaintCorrective['date_added']); ?></span></h6>  </div>
														  
										  <p><span class="message_text"><?php echo nl2br($compaintCorrective['message']); ?></span>	</p>								  
										  <?php if(!empty($compaintCorrective['file'])){ ?>
										  <p style="margin-left:96%;margin-bottom: 0px;"><a href="<?php echo base_url().$compaintCorrective['file']; ?>" target="_blank"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 17px;"></i></a></p>
										  <?php } ?>
										  <?php if($j==1 && $count > 1){ ?>
											<span class="readmore"><a id="correctiveredas" >View more...</a></span>
										  <?php } ?> 
										  
										  <?php if($j==$count && $count > 1){ ?>
											<span class="readmore"><a id="correctivehide" >Hide...</a></span>
										  <?php } ?>
										</div>
											
								<?php $j++; } ?>
							<?php } ?>
						  </div>
						  <div class="type_msg">
							<div class="input_msg_write">
								<div class="row">
									<form id="correctiveForm" style="width:100%;" enctype="multipart/form-data">
										<div class="col-sm-12">
										   <div class="form-group">
											<textarea name="complaint"  class="form-control complaint" rows="2" required></textarea>
											<span style="color:gray;font-size:11px;">(Please summarise the complaint within 500 words.)</span>
											<label id="error_corrective" class="error" for="details_of_complaint"></label>											
											<input type="hidden" name="mess_type" value="corrective">
											<input type="hidden" name="complaint_id" value="<?php echo $compaint->complaint_id; ?>">
										  </div>
											<div class="row">
												<div class="col-sm-3">  <input type="file"  name="complaint_file"  /> </div><div class="col-sm-9"> <input type="submit" name="submit" class="btn btn-primary float-right correctiveBtn" value="Save"/></div>
											</div>				
										</div>
									</form>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				
				<div class="Preventivedetals">
					<div class="page_heading">
						<h5 class="text-left">Brief of Preventive Action Taken</h5>
					</div>
					<div class="messaging">
					  <div class="inbox_msg">	
						<div class="mesgs">
						  <div class="msg_history">
							<?php if($compaintPreventives){ $k=1;  $count = count($compaintPreventives); ?>
								<?php foreach($compaintPreventives as $compaintPreventive){ ?>				
									
										<div class="received_withd_msg <?php if($k > 1){ echo "receive_preventive"; } ?>">
											
										  <div class="title"><h6><?php echo $compaintPreventive['username']; ?> <span class="dat_time"><?php echo dateFormat('h:i a',$compaintPreventive['date_added']); ?>    |    <?php echo dateFormat('d F Y',$compaintPreventive['date_added']); ?></span></h6>  </div>
														  
										  <p><span class="message_text"><?php echo nl2br($compaintPreventive['message']); ?></span></p>
										  <?php if(!empty($compaintPreventive['file'])){ ?>
										  <p style="margin-left:96%;margin-bottom: 0px;"><a href="<?php echo base_url().$compaintPreventive['file']; ?>" target="_blank"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 17px;"></i></a></p>
										  <?php } ?>
										   <?php if($k==1 && $count > 1){ ?>
											<span class="readmore"><a id="preventiveredas" >View more...</a></span>
										  <?php } ?> 
										  
										  <?php if($k==$count && $count > 1){ ?>
											<span class="readmore"><a id="preventivehide" >Hide...</a></span>
										  <?php } ?>
										</div>
											
								<?php $k++; } ?>
							<?php } ?>
						  </div>
						  <div class="type_msg">
							<div class="input_msg_write">
							  <div class="row">
									<form id="preventiveForm" style="width:100%;" enctype="multipart/form-data">
										<div class="col-sm-12">
										   <div class="form-group">
											<textarea name="complaint"  class="form-control complaint" rows="2" required></textarea>
											<span style="color:gray;font-size:11px;">(Please summarise the complaint within 500 words.)</span>
											<label id="error_preventive" class="error" for="details_of_complaint"></label>	
											<input type="hidden" name="mess_type" value="preventive">
											<input type="hidden" name="complaint_id" value="<?php echo $compaint->complaint_id; ?>">
										  </div>
											<div class="row">
												<div class="col-sm-3">  <input type="file"  name="complaint_file"  /> </div><div class="col-sm-9"> <input type="submit" name="submit" class="btn btn-primary float-right preventiveBtn" value="Save"/></div>
											</div>				
										</div>
									</form>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
			</div>							
		</div>
	</div>

</div>
<script>	
	$(document).ready(function () {	
		var date2 = new Date();	
		date2.setDate(date2.getDate()-15);
		
		var date_input=$('.date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			dateFormat: 'yy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
			startDate: date2,
		});
		
		//complaint
		$("#error_complaint").html('');
		$("#error_corrective").html('');
		$("#error_preventive").html('');		
		$("#complaintDetailForm").on('submit', function(e){
			 e.preventDefault();
			$("#error_complaint").html('');
			var vlue = $("#complaintDetailForm .complaint").val();
			if(vlue == ''){
				alert("Please enter message");
				return false;
			}			
			$.ajax({
				type: 'POST',
				url:'<?php echo site_url('addComplaintMessage');?>',				
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					$('.complaintBtn').attr("disabled","disabled");
					$('#complaintDetailForm').css("opacity",".5");
				},
				success: function(response){
					if(response.success == true){
						$("#error_complaint").html('');
						location.reload();							
					}  else if(response.complaint != '') {
						$("#error_complaint").html(response.complaint);
					}
					
					$('#complaintDetailForm').css("opacity","");
					$(".complaintBtn").removeAttr("disabled");
				}
			});				
		});	

		//Corrective		
		$("#correctiveForm").on('submit', function(e){
			 e.preventDefault();
			$("#error_complaint").html('');
			$("#error_corrective").html('');
			$("#error_preventive").html('');
		
			var vlue = $("#correctiveForm .complaint").val();
			if(vlue == ''){
				alert("Please enter message");
				return false;
			}
			var data_form = $('#correctiveForm').serialize();						
			$.ajax({
				type: 'POST',
				url:'<?php echo site_url('addComplaintMessage');?>',				
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					$('.correctiveBtn').attr("disabled","disabled");
					$('#correctiveForm').css("opacity",".5");
				},
				success: function(response){					
					if(response.success == true){
						$("#error_corrective").html('');
						location.reload();							
					}  else if(response.corrective != '') {
						$("#error_corrective").html(response.corrective);
					}
					$('#correctiveForm').css("opacity","");
					$(".correctiveBtn").removeAttr("disabled");
				}
			});				
		});	
		
		//preventive		
		$("#preventiveForm").on('submit', function(e){
			 e.preventDefault();
			$("#error_complaint").html('');
			$("#error_corrective").html('');
			$("#error_preventive").html('');
			var vlue = $("#preventiveForm .complaint").val();
			if(vlue == ''){
				alert("Please enter message");
				return false;
			}
			var data_form = $('#preventiveForm').serialize();						
			$.ajax({
				type: 'POST',
				url:'<?php echo site_url('addComplaintMessage');?>',				
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					$('.preventiveBtn').attr("disabled","disabled");
					$('#preventiveForm').css("opacity",".5");
				},
				success: function(response){
					
					if(response.success == true){
						$("#error_preventive").html('');
						location.reload();							
					}  else if(response.preventive != '') {
						$("#error_preventive").html(response.preventive);
					}
					
					$('#preventiveForm').css("opacity","");
					$(".preventiveBtn").removeAttr("disabled");
				}
			});				
		});	
		
		//complaint
		$('.receive_complaint').hide();		
		$('#complaintredas').on('click',function(){
			$(".receive_complaint").slideToggle( "slow" );
		  $('.receive_complaint').show();
		  $('#complaintredas').hide();
		  $('#complainthide').show();
		});
		
		$('#complainthide').on('click',function(){
			$(".receive_complaint").slideToggle( "slow" );
		  $('.receive_complaint').hide();
		  $('#complainthide').hide();
		  $('#complaintredas').show();
		});
		
		
		//Corrective
		$('.receive_Corrective').hide();		
		$('#correctiveredas').on('click',function(){
			$(".receive_Corrective").slideToggle( "slow" );
		  $('.receive_mess_hide').show();
		  $('#correctiveredas').hide();
		  $('#correctivehide').show();
		});
		
		$('#correctivehide').on('click',function(){
			$(".receive_Corrective").slideToggle( "slow" );
		  $('.receive_Corrective').hide();
		  $('#correctivehide').hide();
		  $('#correctiveredas').show();
		});
		
		
		//preventive
		$('.receive_preventive').hide();		
		$('#preventiveredas').on('click',function(){
			$(".receive_preventive").slideToggle( "slow" );
		  $('.receive_preventive').show();
		  $('#preventiveredas').hide();
		  $('#preventivehide').show();
		});
		
		$('#preventivehide').on('click',function(){
			$(".receive_preventive").slideToggle( "slow" );
		  $('.receive_preventive').hide();
		  $('#preventivehide').hide();
		  $('#preventiveredas').show();
		});
		
		
		$('#status').on('click',function(){
			var checkstr =  confirm('You have chosen complaint status as resolved. It can t be revert as unresolved further.');
			if(checkstr == true){
				return true;
			} else {
				return false;
			}			
		});
		
	});	
</script>