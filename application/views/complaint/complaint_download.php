<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 25px;padding-left: 25px;padding-top: 15px;margin-right: auto;margin-left: auto; font-size:12px;">	
		
		<div style="border-top:0px solid black;border-left:2px solid black;border-right:2px solid black;margin-top:-16px;">
								
				<div style="width:50%;float:left;border-top: 2px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">					
					<div style="float:left;">Username </div> 				
				</div>						
				<div style="float:left;border-top: 2px solid black;border-bottom: 2px solid black;padding-left:3px;">
					<div style="float:left;"><b ><?php echo $compaint->username; ?></b> </div> 
				</div>				
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Company Name </div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;"><b ><?php echo $compaint->company_name; ?></b> </div> 
				</div>
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Category of Complaint </div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;"><b ><?php echo $compaint->complaint_category_name; ?></b> </div> 
				</div>
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Sub-Category of Complaint </div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;"><b ><?php echo $compaint->product_category; ?></b> </div> 
				</div>
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Mode of Complaint </div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;"><b ><?php echo $compaint->complaint_mode_name; ?></b> </div> 
				</div>
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Concern Department for Action </div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;"><b ><?php echo $compaint->concern_dept_name; ?></b> </div> 
				</div>
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Date of Customer Intimation </div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">
									
					<div style="float:left;"><b ><?php echo dateFormat('d-m-Y',$compaint->date_of_customer_info); ?></b> </div>
					
				</div>
				
				<div style="width:50%;float:left;border-top: 0px solid black;border-right: 2px solid gray;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;">Date of Complaint</div> 
				</div>						
				<div style="float:left;border-top: 0px solid black;border-bottom: 2px solid black;padding-left:3px;">				
					<div style="float:left;"><b ><?php echo dateFormat('d-m-Y',$compaint->date_added); ?></b> </div> 
				</div>
				
		</div>
</div>
<?php 
function after ($inthis, $inthat)
{
if (!is_bool(strpos($inthat, $inthis)))
return substr($inthat, strpos($inthat,$inthis)+strlen($inthis));
}
?>