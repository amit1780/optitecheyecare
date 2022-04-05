<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="text-align:center;"><input type="button" onclick="printDiv('printableArea')" value="print" /></div>
<div id="printableArea" style="padding-right: 75px;padding-left: 75px;padding-top: 30px;margin-right: auto;margin-left: auto; font-size:14px;">	
	<div style="border: 1px solid black;display:flex;flex-wrap: wrap;">

			<div style="border-bottom:1px solid black;width: 100%;padding:3px;text-align:center;">
				<b>SHIPPER'S LETTER OF INSTRUCTIONS</b>
			</div>	
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:16%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>Sipper Name:</b></div>
				<div style="width:34%;float:left;border-right:1px solid black;text-align:center;height: 14px;">Tarun Enterprises</div>
				<div style="width:14%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>Date.</b></div>
				<div style="width:34%;float:left;text-align:center;height: 14px;"><?php if($challanInfo->invoice_date != '0000-00-00 00:00:00'){ echo date('d-m-Y', strtotime($challanInfo->invoice_date)); } ?></div>
			</div>
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:16%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>Consignee Name:</b></div>
				<div style="width:34%;float:left;border-right:1px solid black;text-align:center;height: 14px;"><?php echo $ordersInfo->customer_name; ?></div>
				<div style="width:14%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>Invoice NO.</b></div>
				<div style="width:34%;float:left;text-align:center;height: 14px;"><?php echo $challanInfo->invoice_no; ?></div>
			</div>
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				&nbsp;
			</div>			
			
			<!-- <div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">DHL AIRWAY BILL(AWB):</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php echo $challanInfo->docket_no; ?></div>
			</div> -->
			
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>IE CODE NO(10 DIGIT):</b></div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">689008139</div>
			</div>
			
			<!-- <div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">IE BRANCH CODE:</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">&nbsp;</div>
			</div> -->
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>PAN NUMBER:</b></div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">ACBPJ0823B</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;"><b>GSTIN NUMBER:</b></div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">09ACBPJ0823B1ZA</div>
			</div>
			
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">				
					<div style="width:50%;float:left;border-right:1px solid black;height: 14px;"><b>IGST Payment Status:</b></div>
					<div style="float:left;margin-left:10%;height: 14px;">A) Not Applicable</div>
				</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;"><?php if($sliDetailInfo->igstin_pay_status == 'A') { echo "&#10004"; } ?></div>
					<div style="width:35%;float:left;border-right:1px solid black;height: 14px;">B) LUT-Export under Bond.</div>
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;"><?php if($sliDetailInfo->igstin_pay_status == 'B') { echo "&#10004"; } ?></div>
					<div style="width:35%;float:left;border-right:1px solid black;height: 14px;">C) Export Against Payment</div>
					<div style="float:left;height: 14px;"><?php if($sliDetailInfo->igstin_pay_status == 'C') { echo "&#10004"; } ?></div>
				</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">				
					<div style="width:75%;float:left;border-right:1px solid black;height: 14px;"><b>If B, Undertaking of Bond provided ?</b></div>
					<div style="width:5%;float:left;border-right:1px solid black;height: 14px;text-align:center;"><b>:</b></div>
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;text-align:center;"><b>Yes</b></div>
					<div style="float:left;height: 14px;"><?php if($sliDetailInfo->if_b == 'Yes') { echo "&#10004"; } ?></div>
				</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;text-align:center;"><b>No</b></div>
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;text-align:center;"><?php if($sliDetailInfo->if_b == 'No') { echo "&#10004"; } ?></div>
					<div style="width:50%;float:left;border-right:1px solid black;height: 14px;"><b>If C, mention the taxable & IGST Amount :</b></div>
					<div style="float:left;height: 14px;text-align:center;"><?php if($sliDetailInfo->igst_amount) { echo $sliDetailInfo->igst_amount; } ?></div>
				</div>
			</div>
			
			
			<!-- <div style="border-bottom:1px solid black;width: 100%;text-align:center;height: 14px;font-size: 9px;">
				IGST Payment Status (Mandatory to TICK MARK from below option (A,B or C) in front of column provided :
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;padding-top:5px;padding-bottom:5px;">A) NOT APPLICABLE(Valid Reason to be provided)</div>
				<div style="width:57%;float:left;text-align:center;padding-top:5px;padding-bottom:5px;"></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;padding-top:5px;padding-bottom:5px;">B) LUT-Export Under Bond. (Copy of valid LUT Required)</div>
				<div style="width:57%;float:left;text-align:center;padding-top:5px;padding-bottom:5px;"></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;padding-top:5px;padding-bottom:5px;">C) Export Against Payment - IGST Rate, IGST amount and Taxable amount item wise required in INR on export invoice.</div>
				<div style="width:57%;float:left;text-align:center;padding-top:5px;padding-bottom:5px;"></div>
			</div> -->
			
			<div style="border-bottom:1px solid black;width: 100%; font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;">
					<div style="width:30%;float:left;border-right:1px solid black;"><b>End use code</b></div>
					<div style="width:68%;float:left;">&nbsp;</div>
				</div>
				<div style="width:57%;float:left;text-align:center;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 9px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">				
					<div style="width:50%;float:left;border-right:1px solid black;height: 14px;"><b>DBK Serial Number</b></div>
					<div style="float:left;margin-left:10%;height: 14px;"><b>Refer Enclosed Annexure</b></div>
				</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">
					<div style="width:25%;float:left;border-right:1px solid black;height: 14px;"><b>MEIS</b></div>
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;"><b>Yes</b></div>
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;">&nbsp;</div>
					<div style="width:10%;float:left;border-right:1px solid black;height: 14px;"><b>No</b></div>
					<div style="float:left;height: 14px;">&nbsp;</div>
				</div>
			</div>
			
			<!-- <div style="border-bottom:1px solid black;width: 100%;font-size: 10px; ">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;padding-top:5px;padding-bottom:5px;">MEIS Benefit (Shipper need to mention complete MEIS description on SLI and on export invoice).</div>
				<div style="width:57%;float:left;text-align:center;padding-top:5px;padding-bottom:5px;">&nbsp;</div>
			</div> -->
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">BANK AD CODE #(PART i & ii)</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php echo $bankInfo->bank_ad_code;  ?></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">CURRENCY OF INVOICE</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php echo $ordersInfo->currency; ?>&nbsp;<?php //echo $grand_total; ?></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">INCOTERMS : F O B/C & F / C & l / C I F :</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php if($sliDetailInfo->incoterms) { echo $sliDetailInfo->incoterms; } ?></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">NATURE OF PAYMENT D P / D A / A P OTHERS</div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php if($sliDetailInfo->nature_of_payment) { echo $sliDetailInfo->nature_of_payment; } ?></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height: 14px;font-size: 10px;">
				<b>Details to be declared for preparation of shipping Bill</b>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">FOB VALUE : </div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php if($sliDetailInfo->fob_value) { echo $sliDetailInfo->fob_value; } ?></div>
			</div>
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 10px; ">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">FREIGHT(IF ANY) : </div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php echo $ordersInfo->freight_charge; ?></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">INSURANCE(IF ANY) : </div>
				<div style="width:57%;float:left;text-align:center;height: 14px;"><?php echo $ordersInfo->insurance; ?></div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;height: 14px;font-size: 10px; ">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">COMMISSION(IF ANY) : </div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; height: 14px;font-size: 10px;">
				<div style="width:42%;float:left;border-right:1px solid black;padding-left:2px;height: 14px;">DISCOUNT(IF ANY) : </div>
				<div style="width:57%;float:left;text-align:center;height: 14px;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%; ">
				<div style="width:68.2%;float:left;border-right:1px solid black;">
					<div style="width:100%;float:left; padding-left:2px;height: 14px;font-size: 10px;"><b>Description of goods to be declared on Shipping Bill</b> </div>
					<div style="width:100%;float:left;border-top:1px solid black;height:60px;"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } ?> </div>
					<div style="width:100%;float:left; padding-left:2px;border-top:1px solid black;height: 14px;font-size: 10px;">Description of goods to be declared on AWB </div>
					<div style="width:100%;float:left;border-top:1px solid black;height:60px;"><?php if($sliDetailInfo->description_good) { echo $sliDetailInfo->description_good; } ?> </div>
				</div>
				<div style="width:31.6%;float:right;">
					<div style="width:50%;float:left;border-right:1px solid black;height:20px;font-size: 10px;">NO OF PKGS</div>
					<div style="float:right;text-align:center;height:20px;font-size: 10px;width: 49.5%;"> <?php if($sliDetailInfo->no_of_pkgs) { echo $sliDetailInfo->no_of_pkgs; } ?> </div>
					
					<div style="width:50%;float:left;border-right:1px solid black;border-top:1px solid black;height:20px;font-size: 10px;">NET WT</div>
					<div style="float:right;text-align:center;border-top:1px solid black;height:20px;font-size: 10px;width: 49.5%;"> <?php if($sliDetailInfo->net_wt) { echo $sliDetailInfo->net_wt; } ?> </div>
					
					<div style="width:50%;float:left;border-right:1px solid black;border-top:1px solid black;height:20px;font-size: 10px;">GROSS WT</div>
					<div style="float:right;text-align:center;border-top:1px solid black;height:20px;font-size: 10px;width: 49.5%;"> <?php if($sliDetailInfo->gross_wt) { echo $sliDetailInfo->gross_wt; } ?>  </div>
					
					<div style="width:50%;float:left;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;font-size: 10px;height: 12px;">VOLUME WT</div>
					<div style="float:right;text-align:center;border-top:1px solid black;border-bottom:1px solid black;font-size: 10px;width: 49.5%;height: 12px;"> <?php if($sliDetailInfo->volume_wt) { echo $sliDetailInfo->volume_wt; } ?> </div>
					
					<div style="width:100%;float:left;text-align:center;border-bottom:1px solid black;font-size: 10px;height: 14px;"> <b>DIMENSION(IN CMS) Of each pkg.</b> </div>
					<div style="text-align:center;font-size: 10px;"> <?php if($sliDetailInfo->lbh) { echo nl2br($sliDetailInfo->lbh); } ?> <br/><br/><br/><span>L x B x H</span></div>
				</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height: 14px;font-size: 10px;">
				<b>Special Instruction, if any</b>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:60px;font-size: 10px;">
				<?php echo $challanInfo->special_instruction; ?>&nbsp;
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height: 14px;font-size: 10px;">
				<div style="width:42.3%;float:left;border-right:1px solid black;height: 14px;"><b>TYPE OF SHIPPING BILL(CIRCLE YES or NO)</b></div>
				<div style="width:57%;float:left;padding-left:2px;height: 14px;"> <b>BELOW DOCUMENTS REQUIRED WITH SHIPMENT</b> </div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">a) FREE TRADE SAMPLE (NON-COMM)</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> FREE TRADE SAMPLE . VALUE FOR CUSTOMS.NOT FOR SALE</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">b) NON DUTY DRAWBACK</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;"><?php if($sliDetailInfo->nob_duty_drawback == 1) { echo 'YES'; } else { echo 'NO'; } ?> </div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> NOTHING SPECIFIC</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">c) EOU SHIPPING BILL</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> ANNEX C1 & ARE-1 & SDF FORM</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">d) DUTY DRAWBACK</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> DBK SL NO, ANNEX i, ii, iii, SDF FORM,(LEATHER DECLARATION)</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">e) DUTIABLE SHIPPING BILL</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> RATE OF CESS/DUTY TO BE PAID AT CUSTOMS</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">f) DEPB SHIPPING BILL</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> DEPB GROUP CODE/SL NO., SDF FORM, DEPB DECL</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">g) DFIA</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> DFIA LIC/RECEIPT NO., FORM SDF, CONSUMPTION SHEET, SION NO.</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">h) EPCG SHIPPING BILL </div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> REGN NO. & DT OF EPCG LIC, COPY OF EPCG LIC/REGN COPY, SDF FORM</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">i) ADVANCE LICENCE SHIPPING BILL </div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> REGN NO. & DT OF ADV LIC, COPY OF LIC/REGN COPY, CONSUMPTION SHEET/SDF FORM</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">j) REPAIR & RETURN </div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> ORINAL B/E, IMP INV/PKG LIST/GR WAIVER ON GR FORM,CHARTERED ENGG CERTIFICATE,EXPORT</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height:12px;font-size:8px;">
				<div style="width:37%;float:left;border-right:1px solid black;height:12px;">k) DUTY DRAWBACK (SECTION 74) </div>
				<div style="width:5%;float:left;border-right:1px solid black;height:12px;text-align:center;">YES/NO</div>
				<div style="width:57%;float:left;padding-left:2px;height:12px;"> ORINAL B/E, IMP INV/PKG LIST/GR WAIVER, EXPORT INV/PKG LIST AUTHORITY LETTER</div>
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;height: 14px;font-size: 10px;">
				<b>6</b>
			</div>
			
			
			<div style="width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:30%;float:left;">				
					<?php  for($i=0; $i<=5; $i++){ ?>									
						<div style="width:87%;float:left;border-right:1px solid black;height:15px;"> <?php echo $sliDocLabel[$i]['doc_label']; ?></div> 
						<div style="width:10%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;text-align:center;"><?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "&#10004"; } ?></div>
					<?php } ?>					
				</div>
				<div style="width:30%;float:left;">
					<?php  for($i=6; $i<=11; $i++){ ?>									
						<div style="width:87%;float:left;border-right:1px solid black;height:15px;"> <?php echo $sliDocLabel[$i]['doc_label']; ?></div> 
						<div style="width:10%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;text-align:center;"><?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "&#10004"; } ?></div>
					<?php } ?>
				</div>
				<div style="width:30%;float:left;">
					<?php  for($i=12; $i<=17; $i++){ ?>									
						<div style="width:87%;float:left;border-right:1px solid black;height:15px;"> <?php echo $sliDocLabel[$i]['doc_label']; ?></div> 
						<div style="width:10%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;text-align:center;"><?php if (array_search($sliDocLabel[$i]['label_id'], array_column($sliDocInfo, 'doc')) !== FALSE){ echo "&#10004"; } ?></div>
					<?php } ?>
				</div>
			</div>
			
			<!-- <div style="width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:25%;float:left;border-right:1px solid black;height:15px;">1 INVOICE (4 COPIES)</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">7 ARE-1 FORM IN DUPLICATE</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">13 APPENDIX III</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
			</div>
			
			<div style="width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:25%;float:left;border-right:1px solid black;height:15px;">2 PACKING LIST (4 COPIES)</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">8 VISA/AEPC ENDORSEMENT</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">14 ANNEXURE 1</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:25%;float:left;border-right:1px solid black;height:15px;">3 SDF FORM IN DUPLICATE</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">9 LAB ANALYSIS REPORT</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">15 LETTER TO DC</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:25%;float:left;border-right:1px solid black;height:15px;">4 NON DG DECLARATION</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">10 MSDS</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">16 PAYMENT ADVANCE</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:25%;float:left;border-right:1px solid black;height:15px;">5 PURCHASE ORDER COPY</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">11 PHYTOSANITARY CERT</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">17 ---------</div>
				<div style="width:5%;float:left;border-right:1px solid black;border-bottom:1px solid black;height:15px;">&nbsp;</div>				
			</div>
			
			<div style="border-bottom:1px solid black;width: 100%;padding-left:2px;font-size:10px;">
				<div style="width:25%;float:left;border-right:1px solid black;height:15px;">6 GR FORM/GR WAIVER</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">12 GSP CERTIFICATE</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:15px;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:1px solid black;height:15px;">18 ---------</div>
				<div style="width:5%;float:left;border-right:1px solid black;height:15px;">&nbsp;</div>				
			</div> -->
			
			<div style="border-bottom:1px solid black;border-top:1px solid black;width: 100%;padding-left:2px;font-size:8px;">
				In forwarding this document, I/We authorize DHL Express (India) Pvt. Ltd. (DHL). Its group companies and their agenis, to act as our agent to clear this Shipment from Customs and also give our consent to sign, submit and file in physical or digitally, the e-way bill / shipping bill and other forms, as and when required, under various statutes to authorites for undertaking the Shipment on our behalf.
			</div>
			<div style="width: 100%;padding-left:2px;">
				<div style="width:100%;float:left;font-size:10px;">Please indicate API(As per Invoice) if any details is mentioned in the invoice<br>We hered by confirm that the above details declared are true and correct.</div>
				<div style="width:57%;float:left;border-right:0px solid black;font-size:10px;">We confirm that our company's IEC & Bank AD Code Details<br>are registered with EDI System of  Air  Cargo where the clearance is being done<br>* <b>LC(Letter of Credit) Shipments are not handled by DHL</b></div>
				<div style="width:42.8%;float:right;border-top:1px solid black;">
					<div style="width:100%;float:left;border-bottom:1px solid black;border-left:1px solid black;">&nbsp;</div>
					<div style="width:100%;float:left;text-align:center;border-left:1px solid black;">SIGNATURE OF EXPORTER/STAMP</div>
				</div>
			</div>
	</div>	
</div>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>