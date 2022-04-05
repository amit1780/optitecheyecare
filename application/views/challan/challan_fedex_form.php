<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 100px;padding-left: 100px;padding-top: 30px;margin-right: auto;margin-left: auto; font-size:12px;">

	<div style="text-align:center;"><b >SHIPPER'S LETTER OF INSTRUCTIONS</b></div>
	<div style="border: 2px solid black;display:flex;flex-wrap: wrap;">			
		<div style="border-bottom:2px solid black;width: 100%;padding-left:25px;">
			<b>Date:</b>
		</div>	
		
		<div style="border-bottom:2px solid black;width: 100%;">
			<div style="width:48%;float:left;border-right:2px solid black;padding-top:8px;padding-bottom:8px;padding-left:25px;">
				<div style="width:100%;float:left;">FEDEX-AWB# &nbsp;&nbsp;<?php echo $challanInfo->docket_no; ?></div>
				<div style="width:100%;float:left;">FEDEX-NC#</div>
				<div style="width:100%;float:left;">FRT FORWARDER/CO-LOADER/COURIER</div>
			</div>
			<div style="width:50%;float:left;">
				<div style="width:50%;float:left;border-right:2px solid black;padding-left:2px;height:35px;padding-top:5px;">INV.NO. &nbsp;&nbsp;<?php echo $challanInfo->invoice_no; ?>,<?php echo date('d-m-Y', strtotime($challanInfo->invoice_date)); ?></div>
				<div style="width:50%;float:left;padding-left:2px;height:35px;padding-top:5px;">IEC NO. 689008139</div>
				<div style="width:50%;float:left;border-right:2px solid black;padding-left:2px;height:35px;padding-top:5px;">EIN NO.</div>
				<div style="width:50%;float:left;padding-left:2px;height:35px;padding-top:5px;">PAN NO. ACBPJ0823B</div>
			</div>			
		</div>
		
		<div style="border-bottom:2px solid black;width: 100%;">
			<div style="width:48%;float:left;border-right:2px solid black;padding-left:25px;">
				<div style="width:100%;float:left;height:150px;"><b>SHIPPER</b>&nbsp;&nbsp;&nbsp;&nbsp;TARUN ENTERPRISES</div>
				<div style="width:100%;float:left;height:30px;">CONTACT PERSON &nbsp;&nbsp;NIKITA JAGGI</div>
				<div style="width:100%;float:left;height:25px;">TEL NO &nbsp;&nbsp;8176-080204</div>
				<div style="width:100%;float:left;height:25px;">FAX NO &nbsp;</div>
			</div>
			<div style="width:50%;float:left;">
				<div style="width:100%;float:left;">
					<div style="width:100%;float:left;padding-left:25px;"><b>CONTRACT TYPE(tick one)</b></div>
					<div style="width:100%;float:left;padding-top:10px;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:25%;float:left;padding-left;2px;">FOB</div>
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
						<div style="width:25%;float:left;padding-left;2px;">C & F(breakup) COST FREIGHT</div>
						
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
						<div style="width:20%;float:left;padding-left;2px;">C I F (breakup) COST INSURANCE FREIGHT</div>
					</div>
					<div style="width:100%;float:left;padding-left:35px;">CURRENCY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; USD / INR /( other )</div>
				</div>	
				<div style="width:100%;float:left;border-top:2px solid black;">
					<div style="width:100%;float:left;padding-left:25px;padding-bottom:10px;"><b>CONTRACT TYPE(tick one)</b></div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:35%;float:left;padding-left;2px;">DRAWBACK</div>
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
						<div style="float:left;padding-left;2px;">DFRC</div>
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:35%;float:left;padding-left;2px;">NON-DRAWBACK</div>
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
						<div style="float:left;padding-left;2px;">NFEI</div>
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:35%;float:left;padding-left;2px;">DEPB</div>
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
						<div style="float:left;padding-left;2px;">RE-EXPORT</div>
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:35%;float:left;padding-left;2px;">DEEC</div>					
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:35%;float:left;padding-left;2px;">EPCG</div>					
					</div>
				</div>	
			</div>	
		</div>
		
		<div style="border-bottom:2px solid black;width: 100%;">
			<div style="width:48%;float:left;border-right:2px solid black;padding-left:25px;">
				<div style="width:100%;float:left;height:70px;"><b>CONSIGNEE</b> &nbsp;&nbsp;<?php echo $ordersInfo->customer_name; ?></div>
				<div style="width:100%;float:left;height:30px;">BUYER OTHER THAN CONSIGNEE</div>
				<div style="width:100%;float:left;height:25px;">EIN NO</div>				
			</div>
			<div style="width:50%;float:left;padding-left:35px;">
				<div style="width:100%;float:left;"><b>DUTY DRAWBACK DETAILS:</b></div>
				<div style="width:100%;float:left;"><b>DRAWBACK SERIAL NO</b></div>
				<div style="width:100%;float:left;height:60px;"><b>DRAWBACK BANK</b></div>				
				<div style="width:100%;float:left;height:25px;">DRAWBACK AC NO</div>	
			</div>	
		</div>

		<div style="border-bottom:2px solid black;width: 100%;">
			<div style="width:48%;float:left;border-right:2px solid black;">
				<div style="width:100%;float:left;padding-left:25px;">
					<div style="width:50%;float:left;height:70px;border-right:2px solid black;">
						<span style="width:100%;"><b>DESTINATION</b></span>
						<span style="width:100%;height:60px;">&nbsp;</span>
					</div>
					<div style="width:50%;float:left;height:70px;">
						<span style="width:100%;"><b>NO. OF PACKAGES</b></span>
						<span style="width:100%;height:60px;">&nbsp;</span>
					</div>
				</div>
				<div style="width:100%;float:left;border-top:2px solid black;padding-left:25px;">
					<div style="width:50%;float:left;height:70px;border-right:2px solid black;">
						<span style="width:100%;"><b>NET WEIGHT </b></span>
						<span style="width:100%;height:60px;">&nbsp;</span>
					</div>
					<div style="width:50%;float:left;height:70px;">
						<span style="width:100%;"><b>GROSS WEIGHT</b></span>
						<span style="width:100%;height:60px;">&nbsp;</span>
					</div>	
				</div>	
			</div>
			<div style="width:50%;float:left;padding-left:35px;">
				<div style="width:100%;float:left;"><b>GAURANTEED REMITTANCE</b></div>
				<div style="width:100%;float:left;height: 40px;">GR FORM NO</div>
				<div style="width:100%;float:left;height:40px;">GR BANK ADDRESS</div>				
				<div style="width:100%;float:left;">AD CODE &nbsp;&nbsp;&nbsp;<?php echo $bankInfo->bank_ad_code;  ?></div>
				<div style="width:100%;float:left;">CURRENT AC NO.</div>	
			</div>	
		</div>
		
		<div style="border-bottom:2px solid black;width: 100%;">		
			<div style="width:48%;float:left;height:70px;border-right:2px solid black;padding-left:25px;">
				<span style="width:100%;"><b>MARKS AND NUMBERS</b></span>
				<span style="width:100%;height:60px;">&nbsp;</span>
			</div>
			<div style="width:50%;float:left;height:70px;padding-left:35px;">
				<span style="width:100%;"><b>DESCRIPTION OF GOODS</b></span>
				<span style="width:100%;height:60px;">
					Opthatmic Goods
				</span>
			</div>					
		</div>
		
		<div style="width:100%;">
			<div style="width:100%;float:left;padding-left:25px;height: 30px;"><b>DOCUMENT ENCLOSED(tick where applicable)</b></div>
			<div style="width:100%;float:left;padding-bottom:10px;">
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:45%;float:left;padding-left;2px;">FEDEX AWB(DULY COMPLETE)</div>
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
				<div style="float:left;padding-left;2px;">ARE-1 FORM</div>
			</div>
			<div style="width:100%;float:left;padding-bottom:10px;">
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:45%;float:left;padding-left;2px;">INVOICE(8 COPIES)</div>
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
				<div style="float:left;padding-left;2px;">ANY EXPORT PROMOTION COUNCIL REGN. COPY</div>
			</div>
			<div style="width:100%;float:left;padding-bottom:10px;">
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:45%;float:left;padding-left;2px;">PACKING LIST(4 COPIES)</div>
				<div style="width:35px;height:20px;float:left;">&nbsp;</div>
				<div style="float:left;padding-left;2px;">FOR TEXTILE SHIPMENTS TO USA</div>
			</div>
			
			<div style="width:100%;float:left;">
				<div style="width:48%;float:left;padding-bottom:10px;">
					<div style="width:100%;float:left;padding-bottom:10px;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:45%;float:left;padding-left;2px;">BUYER ORDER</div>
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:45%;float:left;padding-left;2px;">GSP FORM </div>
					</div>	
				</div>
				
				<div style="width:50%;float:left;padding-bottom:10px;">
					<div style="width:100%;float:left;">
						<div style="width:35px;height:20px;float:left;border-left:2px solid black;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:90%;float:left;padding-left;25px;padding-left:20px;">a)SINGLE COUNTRY DECLARATION(3 COPIES)</div>
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:19px;float:left;border-left:2px solid black;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:90%;float:left;padding-left;25px;padding-left:20px;">b)QUOTA CHARGE STATEMENT(3 COPIES)</div>
					</div>
					<div style="width:100%;float:left;">
						<div style="width:35px;height:19px;float:left;border-left:2px solid black;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
						<div style="width:90%;float:left;padding-left;25px;padding-left:20px;">c)NEGATIVE DECLARATION(FOR SILK)-(3 COPIES)</div>
					</div>	
				</div>
				
			</div>
			
			<div style="width:100%;float:left;padding-bottom:10px;">
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:45%;float:left;padding-left;2px;">ORIGINAL DUPLICATE VISA(WITH 8 COPIES)</div>
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
				<div style="float:left;padding-left;2px;">SDF FORM</div>
			</div>
			
			<div style="width:100%;float:left;padding-bottom:10px;">
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:45%;float:left;padding-left;2px;">EXPORT CERTIFICATES(WITH 2 COPIES)</div>
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;border-left:2px solid black;">&nbsp;</div>
				<div style="float:left;padding-left;2px;">ADVANCE PAYMENT PROOF</div>
			</div>
			
			<div style="width:100%;float:left;">
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;">&nbsp;</div>
				<div style="width:45%;float:left;padding-left;2px;">PHOTOCOPY OF IEC WITH PAN NO.</div>
				<div style="width:35px;height:20px;float:left;border-right:2px solid black;border-top:2px solid black;border-left:2px solid black;">&nbsp;</div>
				<div style="float:left;padding-left;2px;">BANK CERTIFICATE</div>
			</div>
			
			<div style="width:100%;float:left;border-top:2px solid black;padding-left:35px;">
				<div style="padding-top:5px;padding-bottom:5px;"><u><b>Detaild of Duty Benefit Claimed</b></u></div>
				<div style="border-left:2px solid black;border-top:2px solid black;width:100%;float:left;">
					<div style="width:100%;float:left;"><u>Draback:</u></div>
					<div style="width:100%;float:left;"><span style="width:30%;float:left;">Inv Item No 1</span><span>SBI Apt ACC NO_______________DBK Sr No_______________DBK Rate_______________</span></div>
					<div style="width:100%;float:left;padding-bottom:15px;"><span style="width:30%;float:left;">Inv Item No 2</span><span>SBI Apt ACC NO_______________DBK Sr No_______________DBK Rate_______________</span></div>
				</div>
				<div style="border-left:2px solid black;border-top:2px solid black;width:100%;float:left;">
					<div style="width:100%;float:left;"><u>DEPB:</u></div>
					<div style="width:100%;float:left;"><span style="width:30%;float:left;">Inv Item No 1</span><span style="width:25%;float:left;">Grp&nbsp;&nbsp;&nbsp;&nbsp;_______________</span><span style="width:20%;float:left;">Sr No_______________</span><span style="float:left;">Rate________Sion_______</span></div>
					<div style="width:100%;float:left;padding-bottom:15px;"><span style="width:30%;float:left;">Inv Item No 2</span><span style="width:25%;float:left;">Grp&nbsp;&nbsp;&nbsp;&nbsp;_______________</span><span style="width:20%;float:left;">Sr No_______________</span><span style="float:left;">Rate________Sion_______</span></div>
					
				</div>
				<div style="border-left:2px solid black;border-top:2px solid black;border-bottom:2px solid black;width:100%;float:left;">
					<div style="width:100%;float:left;"><u>DEEC:</u></div>
					<div style="width:100%;float:left;padding-bottom:15px;"><span style="width:30%;float:left;">Inv Item No 1</span><span style="float:left;">REG NO__________Date__________Book No___________</span></div>					
				</div>
				
				<div style="float:left;padding-top:10px;padding-bottom:35px;"><b>ANY OTHER DOCUMENTS:</b></div>				
			</div>
			
			<div style="width:100%;float:left;border-top:2px solid black;padding-left:35px;height:60px;">
				<b>ANY OTHER HANDLING INFORMATION</b>
			</div>
			
			<div style="width:100%;float:left;border-top:2px solid black;padding-left:35px;height:60px;">
				<div style="width:100%;float:left;height:40px;"><b>WE AUTHORISE M/s JEENA & CO TO PREPARE GR FORM ON OUR BEHALF</b></div>
				<div style="width:100%;float:left;"> SHIPPER SIGNATURE AND STAMP WITH NAME & DESIGNATION </div>				
			</div>
			
			<div style="width:100%;float:left;border-top:2px solid black;padding-left:35px;">
				<div style="width:100%;float:left;padding-top: 10px;"> Preparation of GSP / SDF Segment etc. are not the part of services provided by Fedex, hence the same will be billed by<br>Jeena & Co. separately, as and when they are requested to prepare the same.</div>				
			</div>			
		</div>
			
	</div>	
</div>