<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="float:left;width:100%;border: 2px solid black;margin:0px;padding:0px;">	
	<div style="text-align:center;background-color:#9a9a9a;font-size:12px;"><b >SHIPPER'S LETTER OF INSTRUCTIONS</b></div>
	
	<div style="float:left;border-top:2px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 7px;width:75px;"><b>Date: </b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 7px;width:75px;"><b>FedEx A/c No.</b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;">520855343</div>		
		<div style="float:left;width:150px;border-right:1px solid black;padding-top: 7px;"><b>Invoice No.</b></div>		
		<div style="float:left;width:75px;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;"><?php if($challanInfo->invoice_no){ echo $challanInfo->invoice_no; } else { echo "&nbsp;"; } ?></div>	
		<div style="margin-left:146px;border-left:1px solid black;float:left;width:110px;border-right:1px solid black;padding-top: 7px;"><b>IEC No.</b></div>		
		<div style="float:left;border-right:0px solid black;padding-top: 7px;background-color:#b3b3b3;">0689008139</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;height:0px;">
		<div style="float:left;padding-top: 7px;width:75px;">&nbsp;</div>
		<div style="float:left;width:70px;border-right:1px solid black;padding-top: 7px;">&nbsp;</div>
		<div style="float:left;width:100px;border-right:1px solid black;padding-top: 7px;"><b>Date</b></div>
			<?php
				if($challanInfo->invoice_date != '0000-00-00 00:00:00'){
					$invoice_date = new DateTime($challanInfo->invoice_date);
					$invoice_date = $invoice_date->format('d-m-Y');
				} else {
					$invoice_date = '&bnsp;';
				}
			?>
		
		<div style="margin-left:50px;float:left;width:75px;border-left:1px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;"><?php echo $invoice_date; ?></div>
		<div style="margin-left:146px;border-left:1px solid black;float:left;width:110px;border-right:1px solid black;padding-top: 7px;"><b>IEC Branch Serial No.</b></div>		
		<div style="float:left;padding-top: 7px;background-color:#b3b3b3;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 7px;width:80px;"><b>FedEx AWB No.</b></div>
		<div style="float:left;width:64px;border-left:1px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;"><?php if($challanInfo->docket_no){ echo $challanInfo->docket_no; } else { echo "&nbsp;"; } ?></div>		
		<div style="float:left;width:100px;border-right:0px solid black;padding-top: 7px;"><b>EIN No.</b></div>		
		<div style="float:left;width:51px;border-right:1px solid black;padding-top: 7px;">&nbsp;</div>	
		<div style="margin-left:222px;border-left:1px solid black;float:left;width:110px;border-right:1px solid black;padding-top: 7px;"><b>AD Code No.</b></div>		
		<div style="float:left;padding-top: 7px;background-color:#b3b3b3;"><?php echo $bankInfo->bank_ad_code;  ?></div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 10px;width:80px;"><b>Shipper</b></div>
		<div style="float:left;width:64px;border-left:1px solid black;border-right:1px solid black;padding-top: 10px;">&nbsp;</div>		
		<div style="float:left;width:150px;border-right:1px solid black;padding-top: 10px;"><b>Contract Type (tick one)</b></div>		
		<!-- <div style="float:left;width:0px;border-right:0px solid black;padding-top: 10px;">&nbsp;</div> -->	
		<div style="margin-left:223px;border-left:1px solid black;float:left;width:110px;border-right:1px solid black;padding-top: 10px;"><b>PAN No.</b></div>		
		<div style="float:left;padding-top: 10px;background-color:#b3b3b3;">ACBPJ0823B</div>	
	</div>
	
	<?php
		$freight_charges	= '&nbsp;';
		$cost				= '&nbsp;';
		if($sliDetailInfo->incoterms == 'C & F'){
			$freight_charges = $challan_total->freight_charges;
			$cost = $challan_total->net_total;						
		}					
	?>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;height:103px;border-right:1px solid black;"><?php echo $challanInfo->store_address; ?></div>
		<div style="float:left;width:150px;">
			<div style="">
				<div style="float:left;width:100px;border-right:1px solid black;border-bottom:1px solid black;padding-top:15px;text-align:center;height:20px;"><b>FOB</b></div>
				<div style="float:left;width:48px;border-right:1px solid black;background-color:#b3b3b3;border-bottom:1px solid black;padding-top:15px;height:20px;"><?php if($sliDetailInfo->incoterms == 'FOB') { echo $challan_total->net_total; } ?></div>
			</div>
			<div style="">
				<div style="float:left;width:100px;border-right:1px solid black;border-bottom:1px solid black;padding-top:15px;text-align:center;height:20px;"><b>Ex-work</b></div>
				<div style="float:left;width:48px;border-right:1px solid black;background-color:#b3b3b3;border-bottom:1px solid black;padding-top:15px;height:20px;">&nbsp;</div>
			</div>
			<div style="">
				<div style="float:left;width:148px;border-right:1px solid black;border-top:1px solid black;padding-top:15px;text-align:center;margin-top:6px;"><b>Currency Code </b></div>
			</div>
		</div>
		<div style="float:left;width:75px;border-right:1px solid black;">
			<div style="padding-top: 10px;">&nbsp;</div>
			<div style="text-align:right;padding-top: 0px;"><b>Cost</b></div>
			<div style="text-align:right;padding-top: 10px;"><b>Freight</b></div>
			<div style="text-align:right;padding-top: 4px;">&nbsp;</div>
			<div style="text-align:right;padding-top: 0px;">&nbsp;</div>
			<div style="text-align:right;padding-top: 15px;background-color:#b3b3b3;margin-top: 0px;border-top:1px solid black;"><?php echo $ordersInfo->currency; ?></div>
		</div>
		
		<div style="float:left;width:118px;border-right:1px solid black;">
			<div style="border-bottom:1px solid black;">C & F (breakup)</div>
			<div style="background-color:#b3b3b3;width:56px;float:left;padding-top:10px;border-right:1px solid black;border-bottom:1px solid black;"><?php echo $cost; ?></div>
			<div style="width:60px;float:left;text-align:right;padding-top:10px;"><b>Cost</b></div>
			<div style="background-color:#b3b3b3;width:56px;float:left;padding-top:10px;border-right:1px solid black;border-bottom:1px solid black;"><?php echo $freight_charges; ?></div>		
			<div style="width:60px;float:left;text-align:right;padding-top:10px;"><b>Insurance</b></div>			
			<div style="width:56px;float:left;padding-top:10px;">&nbsp;</div>	
			<div style="width:60px;float:left;text-align:right;padding-top:10px;"><b>Freight</b></div>			
		</div>
		
		<div style="float:left;width:100px;border-right:0px solid black;">
			<div style="border-bottom:1px solid black;text-align:center;">CIF (breakup)</div>
			<div style="background-color:#b3b3b3;width:56px;float:left;padding-top:10px;border-right:1px solid black;border-bottom:1px solid black;"><?php if($sliDetailInfo->incoterms == 'CIF') { echo $challan_total->net_total; }else{ echo "&nbsp;"; } ?></div>		
			<div style="background-color:#b3b3b3;width:56px;float:left;padding-top:10px;border-right:1px solid black;border-bottom:1px solid black;">&nbsp;</div>		
			<div style="background-color:#b3b3b3;width:56px;float:left;padding-top:10px;border-right:1px solid black;border-bottom:1px solid black;"><?php if($sliDetailInfo->incoterms == 'CIF') { echo $challan_total->freight_charges; }else{ echo "&nbsp;"; } ?></div>		
		</div>
		
		<div style="float:left;width:60px;border-right:1px solid black;">
			<div style="border-left:1px solid black;border-bottom:1px solid black;">C& I-</div>
		</div>		
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 6px;width:75px;"><b>Tel No.</b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;">+91-8176080204</div>		
		<div style="float:left;padding-top: 6px;"><b>Type of Shipping Bill (whatever appilicable)</b></div>		
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 6px;width:75px;"><b>Email Address</b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 6px;"><b>Duty Drawback </b></div>
		<div style="float:left;width:50px;border-left:1px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;text-align:center;"><?php if($sliDetailInfo->ship_bill_tick == '1') { echo $tick_img; } else { echo "&nbsp;"; } ?></div>
		<div style="float:left;width:63px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;">&nbsp;</div>
		<div style="float:left;width:65px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;"><b>NFEI</b></div>
		<div style="float:left;width:50px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;text-align:center;"><?php if($sliDetailInfo->ship_bill_tick == '7') { echo $tick_img; } else { echo "&nbsp;"; } ?></div>
		<div style="float:left;width:50px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;">&nbsp;</div>
		<div style="float:left;width:60px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;">&nbsp;</div>
		<div style="float:left;width:50px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;">&nbsp;</div>
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 6px;width:75px;"><b>Fax No.</b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 6px;content: \2713;"><b>Non Drawback</b></div>
		<div style="float:left;width:50px;border-left:1px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;text-align:center;"><?php if($sliDetailInfo->ship_bill_tick == '2') { echo $tick_img; } else { echo "&nbsp;"; } ?></div>
		<div style="float:left;width:63px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;">&nbsp;</div>
		<div style="float:left;width:65px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;"><b>Jobbing</b></div>
		<div style="float:left;width:50px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;text-align:center;"><?php if($sliDetailInfo->ship_bill_tick == '9') { echo $tick_img; } else { echo "&nbsp;"; } ?></div>
		<div style="float:left;width:50px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;">&nbsp;</div>
		<div style="float:left;width:60px;border-left:0px solid black;border-right:1px solid black;font-size:7px;padding-top: 7px;"><b>Repair & Return</b></div>
		<div style="float:left;width:50px;border-left:0px solid black;border-right:1px solid black;padding-top: 6px;background-color:#b3b3b3;text-align:center;"><?php if($sliDetailInfo->ship_bill_tick == '10') { echo $tick_img; } else { echo "&nbsp;"; } ?></div>
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
	
		<div style="float:left;height:0px;width:145px;border-right:1px solid black;border-top:0px solid black;height:118px;">
			<div style="float:left;"><b>Consignee</b> <br> <?php echo nl2br($challanInfo->shipping_details); ?></div>
		</div>
		
		<div style="float:left;border-top:0px solid black;height:118px;">
			<div style="float:left;width:90px;padding-top: 20px;font-size:8px;text-align:center;border-right:1px solid black;height:80px;">Advance Authorization (AA)</div>
			<div style="float:left;width:50px;padding-top: 20px;font-size:8px;text-align:center;border-right:1px solid black;height:80px;background-color:#b3b3b3;">&nbsp;</div>
			<div style="float:left;width:63px;border-left:0px solid black;border-right:1px solid black;padding-top: 20px;height:80px;">&nbsp;</div>
			<div style="float:left;width:65px;border-left:0px solid black;border-right:1px solid black;padding-top: 20px;height:80px;">Re-Export</div>
			<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 20px;height:80px;background-color:#b3b3b3;">&nbsp;</div>
			<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 20px;height:80px;">&nbsp;</div>
			<div style="float:left;width:59px;border-left:0px solid black;border-right:1px solid black;padding-top: 20px;height:80px;">MEIS (REWARD)</div>
			<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 20px;height:80px;background-color:#b3b3b3;">&nbsp;</div>
			<div style="float:left;border-left:0px solid black;border-right:0px solid black;padding-top: 0px;height:80px;font-size:8px;"><b>If MEIS box is ticked in type of shippping bill please mention on the Shipping Bill as under: "We intend to claim rewards under Merchandise Export From India Scheme (MEIS)"</b></div>

			<div style="float:left;width:90px;padding-top: 7px;font-size:8px;text-align:center;border-right:1px solid black;border-top:1px solid black;font-size:7px;">(Drawback / ROSCTL)</div>
			<div style="float:left;width:50px;padding-top: 7px;font-size:8px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
			<div style="float:left;width:63px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;">&nbsp;</div>
			<div style="float:left;width:65px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;border-top:1px solid black;font-size:7px;">Drawback+EPCG)</div>
			<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
			<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;">&nbsp;</div>
			<div style="float:left;width:59px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;border-top:1px solid black;">Any Other</div>
			<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
			<div style="float:left;border-left:0px solid black;border-right:0px solid black;padding-top: 0px;font-size:8px;border-top:1px solid black;">&nbsp;</div>			
		</div>
		
	</div>
	
	<!-- <div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-right:1px solid black;height: 18px;"></div>
		<div style="float:left;width:90px;padding-top: 7px;font-size:8px;text-align:center;border-right:1px solid black;border-top:1px solid black;font-size:7px;">(Drawback / ROSCTL)</div>
		<div style="float:left;width:50px;padding-top: 7px;font-size:8px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
		<div style="float:left;width:63px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;">&nbsp;</div>
		<div style="float:left;width:65px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;border-top:1px solid black;font-size:7px;">Drawback+EPCG)</div>
		<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
		<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;">&nbsp;</div>
		<div style="float:left;width:59px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;border-top:1px solid black;">Any Other</div>
		<div style="float:left;width:51px;border-left:0px solid black;border-right:1px solid black;padding-top: 7px;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
		<div style="float:left;border-left:0px solid black;border-right:0px solid black;padding-top: 0px;font-size:8px;border-top:1px solid black;">&nbsp;</div>		
	</div> -->
	
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:74px;">
			<div style="">Tel No.</div>
			<div style="padding-top: 20px;">Email ID -</div>
		</div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 40px;">&nbsp;</div>		
		<div style="float:left;width:90px;border-right:1px solid black;padding-top:10px;height:41px;">EPCG(Concesnal or Zero duty)</div>
		<div style="float:left;width:50px;border-right:1px solid black;padding-top:10px;height:41px;background-color:#b3b3b3;">&nbsp;</div>
		<div style="float:left;width:63px;border-right:1px solid black;padding-top:10px;height:41px;">&nbsp;</div>
		<div style="float:left;width:65px;border-right:1px solid black;padding-top:10px;height:41px;">EOU</div>
		<div style="float:left;width:51px;border-right:1px solid black;padding-top:10px;height:41px;background-color:#b3b3b3;">&nbsp;</div>
		<div style="float:left;width:51px;border-right:1px solid black;padding-top:10px;height:41px;">&nbsp;</div>
		<div style="float:left;width:59px;border-right:1px solid black;padding-top:0px;height:51px;"><b>Commercial Export - CSB V courier-Value=</b></div>
		<div style="float:left;width:51px;border-right:1px solid black;padding-top:10px;height:41px;background-color:#b3b3b3;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;"><b>Buyer (If other than Consignee)</b></div>		
		<div style="float:left;width:90px;padding-top: 4px;">Duty Drawback Details:</div>		
		<div style="float:left;padding-top: 4px;background-color:#b3b3b3;"><?php if($sliDetailInfo->ship_bill_tick == '1') { echo "Duty Drawback"; } elseif($sliDetailInfo->ship_bill_tick == '2'){ echo "Non-Drawback"; } ?></div>		
	</div>
	
	
	
	
	
	
	
	<!-- <div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;"><?php echo nl2br($challanInfo->billing_details); ?></div>		
		<div style="float:left;width:90px;padding-top: 4px;">Bank Detail</div>		
		<div style="float:left;padding-top: 4px;background-color:#b3b3b3;"><?php echo $bankInfo->bank_name;  ?></div>		
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
	</div>
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">Current A/c No.</div>		
		<div style="float:left;padding-top: 4px;background-color:#b3b3b3;border-top:1px solid black;width:200px;"><?php echo $bankInfo->account_number;  ?></div>		
		<div style="float:left;padding-top: 4px;border-top:1px solid black;width:175px;text-align:center;">IFSC Code</div>
		<div style="float:left;padding-top: 4px;background-color:#b3b3b3;border-top:1px solid black;">&nbsp;</div>
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;width:210px;padding-top: 4px;border-top:1px solid black;">Description Of Goods </div>		
		<div style="float:left;padding-top: 4px;background-color:#b3b3b3;border-top:1px solid black;"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } else { echo "&nbsp;"; } ?></div>		
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;border-top:1px solid black;background-color:#b3b3b3;">Any Additional Instruction -</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:145px;border-right:1px solid black;">&nbsp;</div>		
		<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
	</div> -->
	
	
	<div style="float:left;border-right:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;height:0px;width:145px;border-right:1px solid black;border-top:1px solid black;height:125px;">
			<div style="float:left;padding-top: 4px;width:145px;"><?php echo nl2br($challanInfo->billing_details); ?></div>
		</div>
		<div style="float:left;border-top:1px solid black;">
			<div style="float:left;width:90px;padding-top: 4px;">Bank Detail</div>		
			<div style="float:left;padding-top: 4px;background-color:#b3b3b3;"><?php echo $bankInfo->bank_name;  ?></div>
			<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>
			<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>
			<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">Current A/c No.</div>		
			<div style="float:left;padding-top: 4px;background-color:#b3b3b3;border-top:1px solid black;width:200px;"><?php echo $bankInfo->account_number;  ?></div>		
			<div style="float:left;padding-top: 4px;border-top:1px solid black;width:175px;text-align:center;">IFSC Code</div>
			<div style="float:left;padding-top: 4px;background-color:#b3b3b3;border-top:1px solid black;"><?php echo $bankInfo->ifsc_code;  ?>&nbsp;</div>
			<div style="float:left;width:210px;padding-top: 4px;border-top:1px solid black;">Description Of Goods </div>		
			<div style="float:left;padding-top: 4px;background-color:#b3b3b3;border-top:1px solid black;"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } else { echo "&nbsp;"; } ?></div>
			<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
			<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>
			<div style="float:left;padding-top: 4px;border-top:1px solid black;background-color:#b3b3b3;">Any Additional Instruction -</div>
			<div style="float:left;width:90px;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>		
			<div style="float:left;padding-top: 4px;border-top:1px solid black;">&nbsp;</div>
		</div>
	</div>
	
	
	
	
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:75px;"><b>Tel No.</b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 4px;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;width:210px;text-align:center;border-right:1px solid black;"><b>GSTN NO-</b></div>		
		<div style="float:left;padding-top: 4px;width:110px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;width:160px;text-align:center;border-right:1px solid black;text-align:right;">End use Code</div>
		<div style="float:left;padding-top: 4px;text-align:center;background-color:#b3b3b3;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:75px;"><b>Email ID- </b></div>
		<div style="float:left;width:70px;border-left:1px solid black;border-right:1px solid black;padding-top: 4px;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;width:210px;text-align:center;border-right:1px solid black;"><b>GSTIN State Code -</b></div>		
		<div style="float:left;padding-top: 4px;width:110px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;width:160px;text-align:center;border-right:1px solid black;text-align:right;">&nbsp;</div>
		<div style="float:left;padding-top: 4px;text-align:center;background-color:#b3b3b3;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;padding-top: 4px;width:80px;"><b>Destination</b></div>
		<div style="float:left;width:65px;border-left:1px solid black;border-right:1px solid black;padding-top: 4px;">No. of Packages</div>		
		<div style="float:left;padding-top: 4px;width:210px;text-align:center;border-right:1px solid black;"><b>Payment Type -</b></div>		
		<div style="float:left;padding-top: 4px;width:55px;text-align:center;border-right:1px solid black;">LUT</div>		
		<div style="float:left;padding-top: 4px;width:55px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;">&nbsp;</div>		
		<div style="float:left;padding-top: 4px;width:160px;text-align:center;border-right:1px solid black;text-align:right;">Under IGST Paid</div>
		<div style="float:left;padding-top: 4px;text-align:center;background-color:#b3b3b3;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;background-color:#b3b3b3;">
		<div style="float:left;width:80px;height:45px;"><?php if($sliDetailInfo->country_name) { echo $sliDetailInfo->country_name; } else { echo "&nbsp;"; } ?>&nbsp;</div>
		<div style="float:left;width:65px;border-left:1px solid black;border-right:1px solid black;height:45px;"><?php if($sliDetailInfo->no_of_pkgs) { echo $sliDetailInfo->no_of_pkgs; } else { echo "&nbsp;"; } ?></div>		
		<div style="float:left;width:210px;text-align:center;border-right:1px solid black;height:45px;">Detail  of Preferential Agreements under which the goods are being exported wherever applicable (If the agreement applies to all the items in the invoice. Else attach the Item details in sheet Details Itemwise.)</div>		
		<div style="float:left;width:55px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;height:45px;">&nbsp;</div>		
		<div style="float:left;width:215px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;height:45px;">Standard Unit Quantity Code (SQC) for that CTH as per the first schedule for the customs Tariff Act 1975. (If the SQC applies to all the items in the invoice. Else attach the Item details in sheet Details Itemwise.)</div>
		<div style="float:left;text-align:center;background-color:#b3b3b3;height:45px;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:80px;"><b>Net Weight</b></div>
		<div style="float:left;width:65px;border-left:1px solid black;border-right:1px solid black;"><b>Gross Weight</b></div>		
		<div style="float:left;text-align:center;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:8px;background-color:#b3b3b3;">
		<div style="float:left;width:80px;height:43px;"><?php if($sliDetailInfo->net_wt) { echo $sliDetailInfo->net_wt; } else { echo "&nbsp;"; } ?></div>
		<div style="float:left;width:65px;border-left:1px solid black;border-right:1px solid black;height:43px;"><?php if($sliDetailInfo->gross_wt) { echo $sliDetailInfo->gross_wt; } else { echo "&nbsp;"; } ?></div>		
		<div style="float:left;width:165px;text-align:center;border-right:1px solid black;height:43px;">State of Origin of Goods . (If the State of origin  applies to all the items in the invoice. Else attach the Item details in sheet Details Itemwise.)</div>		
		<div style="float:left;width:55px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;height:43px;">&nbsp;</div>		
		<div style="float:left;width:55px;text-align:center;border-right:1px solid black;height:42px;">&nbsp;</div>		
		<div style="float:left;width:215px;text-align:center;border-right:1px solid black;background-color:#b3b3b3;height:43px;">District or Origin of goods  (If the District  of origin applies to all the items in the invoice. Else attach the Item details in sheet Details Itemwise.)</div>
		<div style="float:left;text-align:center;background-color:#b3b3b3;height:43px;">&nbsp;</div>	
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;width:312px;">Documents Enclosed (tick where applicable)</div>
		<div style="float:left;border-left:1px solid black;">Mandatory if PSD / EP copy delivery address other than IEC Add.</div>		
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;width:312px;">&nbsp;</div>
		<div style="float:left;border-left:1px solid black;border-right:1px solid black;width:250px;">Post shipment document / EP  delivery instructions</div>		
		<div style="float:left;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:9px;">
		<div style="float:left;width:312px;border-top:0px solid black;">&nbsp;</div>
		<div style="float:left;border-left:1px solid black;border-top:1px solid black;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-right:0px solid black;width: 100%;font-size:8px;">
		
		<div style="float:left;height:0px;width:312px;border-right:1px solid black;">
			<?php  for($i=0; $i<=8; $i++){ ?>
				<div style="float:left;width:160px;border-top:0px solid black;"><?php echo $sliDocLabel[$i]['doc_label']; ?></div>
				<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;text-align:center;"><?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo $tick_img; } else { echo "&nbsp;"; } ?></div>
			<?php } ?>
			<div style="float:left;width:160px;border-top:0px solid black;">&nbsp; </div>
			<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
		</div>
		<div style="float:left;">
			<div style="float:left;width:110px;border-right:0px solid black;">Contact person</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">Telephone / Mobile</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">Street Address 1</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">&nbsp;</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">Street Address 2</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">&nbsp;</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">City</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;width:110px;border-right:0px solid black;">PIN number</div>				
			<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>
			
			<div style="float:left;border:0px solid black;">&nbsp;</div>
			
			<div style="float:left;border:0px solid black;">Any other instructions on Post shipment docs / EP delivery</div>
		</div>
	</div>
	
	<!-- <div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">FedEx AWB (duly complete)</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">Contact person</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">Invoice (5 copies)</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">Telephone / Mobile</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">Packing List (5 copies)</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">Street Address 1</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">GSP/Certificate of Origin Form</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">&nbsp;</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">Original, Duplicate Visa (with 2 copies)</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">Street Address 2</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">Bank Certificate ( GR Waiver)</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">&nbsp;</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">EVD (Export Value Declaration)</div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">City</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">SDF / FEMA declaration </div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>				
		<div style="float:left;width:110px;border-right:0px solid black;">PIN number</div>				
		<div style="float:left;border-left:1px solid black;border-right:0px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">Annexure C1 (For 100% EOU shipments) </div>
		<div style="float:left;width:110px;border:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>								
		<div style="float:left;border:0px solid black;">&nbsp;</div>				
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:8px;">
		<div style="float:left;width:145px;border-top:0px solid black;">&nbsp; </div>
		<div style="float:left;width:110px;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;background-color:#b3b3b3;">&nbsp;</div>				
		<div style="float:left;width:55px;border-right:1px solid black;">&nbsp;</div>								
		<div style="float:left;border:0px solid black;">Any other instructions on Post shipment docs / EP delivery</div>				
	</div> -->
	
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;width:312px;padding-top:8px;">&nbsp;</div>
		<div style="float:left;border-left:1px solid black;width:200px;padding-top:8px;">&nbsp;</div>		
		<div style="float:left;border-left:1px solid black;padding-top:8px;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;">Advance Authorisation / EPCG Details</div>			
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:9px;">				
		<div style="float:left;width:100px;">Inv Item No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REG No</div>			
		<div style="float:left;width:30px;border:1px solid black;">&nbsp;</div>			
		<div style="float:left;width:150px;">&nbsp;</div>
		<div style="float:left;width:30px;">Date</div>
		<div style="float:left;width:50px;border:1px solid black;">&nbsp;</div>	
		<div style="float:left;width:235px;border-right:0px solid black;">Advance Authorisation / EPCG  FILE NO, LIC No & Date:</div>
		<div style="float:left;border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;background-color:#b3b3b3;">&nbsp;</div>		
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:9px;">
		<div style="float:left;margin-left:75px;">(If LIC prior to 2009)</div>			
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;">Other Handling Information</div>			
	</div>
	
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:9px;">
		<div style="float:left;"><b>Certificate of Origin?</b>If YES - (It will be prepared by Jeena & Co.) GSP Type:  Normal / Tatkal (Same Day) (Please tick any one)</div>			
	</div>
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:9px;">
		<div style="margin-left:85px;float:left;border:1px solid black;width:70px;padding-top:4px;">&nbsp;</div>			
	</div>
	<div style="float:left;border-top:0px solid black;width: 100%;font-size:9px;">
		<div style="float:left;">If NO - Please provide the GSP (if applicable).</div>			
	</div>
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:7px;">
		<div style="float:left;">We hereby appoint <b>M/s Jeena & Company / JFS Freight Services Pvt. Ltd/ Fedex Express Transportation Supply Chain Services (India) Pvt.Ltd / Sun Impex Clearing & Shipping Agency Pvt Ltd</b> as our authorized Customs Broker to prepare documents on our behalf and getting our cargo cleared as per the documents and information provided to them by us. We hereby also declare that the information in the subject invoice is as per our knowledge, true and correct and if during custom examination anything found contradictory, objectionable in the shipment, neither Customs Broker nor the carrier would be held responsible.</div>			
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:7px;">
		<div style="float:left;">I/ We declare that the particulars given herein are true, correct and complete<br>
“I/We undertake to abide by provisions of Foreign Exchange Management Act, 1999, as amended from time to time, including realization / repatriation of foreign exchange to / from India.</div>			
	</div>
	
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;padding-top:15px;">Shipper Signature and Stamp</div>			
	</div>
	<div style="float:left;border-top:1px solid black;width: 100%;font-size:9px;">
		<div style="float:left;width:200px;">Shipper Name & Designation</div>			
		<div style="float:left;width:200px;background-color:#b3b3b3;border-left:1px solid black;border-right:1px solid black;">&nbsp;</div>			
		<div style="float:left;width:200px;">Contact Details:</div>
		<div style="float:left;background-color:#b3b3b3;border-left:1px solid black;">&nbsp;</div>		
	</div>
	
</div>