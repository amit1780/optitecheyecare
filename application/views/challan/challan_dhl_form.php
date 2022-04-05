<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="padding-right: 100px;padding-left: 100px;padding-top: 30px;margin-right: auto;margin-left: auto; font-size:12px;">

	
	<div style="border: 2px solid black;display:flex;flex-wrap: wrap;">

			<div style="border-bottom:2px solid black;width: 100%;padding:3px;text-align:center;">
				<b>SHIPPER'S LETTER OF INSTRUCTIONS</b>
			</div>	
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:15%;float:left;border-right:2px solid black;padding-left:2px;">Sipper Name:</div>
				<div style="width:35%;float:left;border-right:2px solid black;text-align:center;">Tarun Enterprises</div>
				<div style="width:15%;float:left;border-right:2px solid black;padding-left:2px;">Invoice NO.</div>
				<div style="width:35%;float:left;text-align:center;"><?php echo $challanInfo->invoice_no; ?></div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:15%;float:left;border-right:2px solid black;padding-left:2px;">Consignee Name:</div>
				<div style="width:35%;float:left;border-right:2px solid black;text-align:center;"><?php echo $ordersInfo->customer_name; ?></div>
				<div style="width:15%;float:left;border-right:2px solid black;padding-left:2px;">Invoice Date.</div>
				<div style="width:35%;float:left;text-align:center;"><?php if($challanInfo->invoice_date != '0000-00-00 00:00:00'){ echo date('d-m-Y', strtotime($challanInfo->invoice_date)); } ?></div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				&nbsp;
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">DHL AIRWAY BILL(AWB):</div>
				<div style="width:60%;float:left;text-align:center;"><?php echo $challanInfo->docket_no; ?></div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">IE CODE NO(10 DIGIT):</div>
				<div style="width:60%;float:left;text-align:center;">689008139</div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">IE BRANCH CODE:</div>
				<div style="width:60%;float:left;text-align:center;">&nbsp;</div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">PAN NUMBER:</div>
				<div style="width:60%;float:left;text-align:center;">ACBPJ0823B</div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">GSTIN NUMBER:</div>
				<div style="width:60%;float:left;text-align:center;">09ACBJ0823B1ZA</div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%;text-align:center;">
				IGST Payment Status (Mandatory to TICK MARK from below option (A,B or C) in front of column provided :
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;padding-top:7px;padding-bottom:7px;">A) NOT APPLICABLE(Valid Reason to be provided)</div>
				<div style="width:60%;float:left;text-align:center;padding-top:7px;padding-bottom:7px;"></div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;padding-top:7px;padding-bottom:7px;">B) LUT-Export Under Bond. (Copy of valid LUT Required)</div>
				<div style="width:60%;float:left;text-align:center;padding-top:7px;padding-bottom:7px;"></div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;padding-top:7px;padding-bottom:7px;">C) Export Against Payment - IGST Rate, IGST amount and Taxable amount item wise required in INR on export invoice.</div>
				<div style="width:60%;float:left;text-align:center;padding-top:7px;padding-bottom:7px;"></div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">
					<div style="width:30%;float:left;border-right:2px solid black;">End use code</div>
					<div style="width:70%;float:left;">&nbsp;</div>
				</div>
				<div style="width:60%;float:left;text-align:center;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;padding-top:7px;padding-bottom:7px;">MEIS Benefit (Shipper need to mention complete MEIS description on SLI and on export invoice).</div>
				<div style="width:60%;float:left;text-align:center;padding-top:7px;padding-bottom:7px;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">BANK AD CODE #(PART i & ii)</div>
				<div style="width:60%;float:left;text-align:center;"><?php echo $bankInfo->bank_ad_code;  ?></div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">CURRENCY OF INVOICE</div>
				<div style="width:60%;float:left;text-align:center;"><?php echo $ordersInfo->currency; ?>&nbsp;<?php echo $grand_total; ?></div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">INCOTERMS : F O B/C & F / C & l / C I F :</div>
				<div style="width:60%;float:left;text-align:center;">Ex-works</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">NATURE OF PAYMENT D P / D A / A P OTHERS :</div>
				<div style="width:60%;float:left;text-align:center;">NON-DUTY DRAWBACK, 100% ADVANCE PAYMENT</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				Details to be declared for preparation of shipping Bill
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">FOB VALUE : </div>
				<div style="width:60%;float:left;text-align:center;">&nbsp;</div>
			</div>
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">FREIGHT(IF ANY) : </div>
				<div style="width:60%;float:left;text-align:center;"><?php echo $ordersInfo->freight_charge; ?></div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">INSURANCE(IF ANY) : </div>
				<div style="width:60%;float:left;text-align:center;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">COMMISSION(IF ANY) : </div>
				<div style="width:60%;float:left;text-align:center;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:40%;float:left;border-right:2px solid black;padding-left:2px;">DISCOUNT(IF ANY) : </div>
				<div style="width:60%;float:left;text-align:center;">&nbsp;</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%; ">
				<div style="width:70%;float:left;border-right:2px solid black;">
					<div style="width:100%;float:left; padding-left:2px;">Description of goods to be declared on Shipping Bill </div>
					<div style="width:100%;float:left;border-top:2px solid black;height:72px;">Opthatmic Goods </div>
					<div style="width:100%;float:left; padding-left:2px;border-top:2px solid black;">Description of goods to be declared on AWB </div>
					<div style="width:100%;float:left;border-top:2px solid black;height:72px;">Opthatmic Goods </div>
				</div>
				<div style="width:30%;float:left;">
					<div style="width:50%;float:left;border-right:2px solid black;height:30px;">NO OF PKGS</div>
					<div style="width:50%;float:left;text-align:center;height:30px;"> &nbsp; </div>
					
					<div style="width:50%;float:left;border-right:2px solid black;border-top:2px solid black;height:30px;">NET WT</div>
					<div style="width:50%;float:left;text-align:center;border-top:2px solid black;height:30px;"> &nbsp; </div>
					
					<div style="width:50%;float:left;border-right:2px solid black;border-top:2px solid black;height:30px;">GROSS WT</div>
					<div style="width:50%;float:left;text-align:center;border-top:2px solid black;height:30px;"> &nbsp; </div>
					
					<div style="width:50%;float:left;border-right:2px solid black;border-top:2px solid black;border-bottom:2px solid black;">VOLUME WT</div>
					<div style="width:50%;float:left;text-align:center;border-top:2px solid black;border-bottom:2px solid black;"> &nbsp; </div>
					
					<div style="width:100%;float:left;text-align:center;border-bottom:2px solid black;"> DIMENSION(IN CMS) Of each pkg. </div>
					<div style="width:100%;float:left;text-align:center;padding-top:14px;">
						 CMS<br> L * B * H
					</div>
				</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				Special Instruction, If any
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;height:72px;">
				&nbsp;
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:40%;float:left;border-right:2px solid black;">TYPE OF SHIPPING BILL(TICK MARK)</div>
				<div style="width:60%;float:left;padding-left:2px;"> BELOW DOCUMENTS REQUIRED WITH SHIPMENT </div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">A) FREE TRADE SAMPLE (NON-COMM)</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> FREE TRADE SAMPLE . VALUE FOR CUSTOMS.NOT FOR SALE</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">B) FREE COMMERCIAL</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> NOTHING SPECIFIC</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">C) EOU SHIPPING BILL</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> ANNEX C1 & ARE-1 & SDF FORM</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">D) DUTY DRAWBACK</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> DBK SL NO, ANNEX i, ii, iii, SDF FORM,(LEATHER DECLARATION)</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">E) EPCG SHIPPING BILL</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> REGN NO & DT OF EPCG LIC, COPY OF EPCG LIC/REGN COPY,SDF FORM</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">F) ADVANCE LICENCE SHIPPING BILL</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> REGN NO & DT OF ADV LIC, COPY OF LIC/REGN COPY, CONSUMPTION SHEET/SDF FORM</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">G) ROSL(Rebate of State Levies)</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> NO ADDITIONAL DOCUMENTS REQUIRED</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:35%;float:left;border-right:2px solid black;">H) REPAIR & RETURN</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:60%;float:left;padding-left:2px;"> ORGINAL B/E. IMP INV/PKG LIST/GR WAIVER ON GR FORM CHARTERED ENGG CERTIFICATE, EXPORT INVOICE/PKG LIST</div>
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				Please TICK & LIST the documents provided to DHL with the shipment:
			</div>
			
			<div style="width: 100%;padding-left:2px;">
				<div style="width:25%;float:left;border-right:2px solid black;">1 INVOICE (4 COPIES)</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">7 ARE-1 FORM IN DUPLICATE</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">13 APPENDIX III</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;">
				<div style="width:25%;float:left;border-right:2px solid black;">2 PACKING LIST (4 COPIES)</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">8 VISA/AEPC ENDORSEMENT</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">14 ANNEXURE 1</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;">
				<div style="width:25%;float:left;border-right:2px solid black;">3 SDF FORM IN DUPLICATE</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">9 LAB ANALYSIS REPORT</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">15 LETTER TO DC</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;">
				<div style="width:25%;float:left;border-right:2px solid black;">4 NON DG DECLARATION</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">10 MSDS</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">16 PAYMENT ADVANCE</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>				
			</div>
			
			<div style="width: 100%;padding-left:2px;">
				<div style="width:25%;float:left;border-right:2px solid black;">5 PURCHASE ORDER COPY</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">11 PHYTOSANITARY CERT</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">17 ---------</div>
				<div style="width:5%;float:left;border-right:2px solid black;border-bottom:2px solid black;">&nbsp;</div>				
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				<div style="width:25%;float:left;border-right:2px solid black;">6 GR FORM/GR WAIVER</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">12 GSP CERTIFICATE</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>
				<div style="width:25%;float:left;padding-left:2px;border-right:2px solid black;">18 ---------</div>
				<div style="width:5%;float:left;border-right:2px solid black;">&nbsp;</div>				
			</div>
			
			<div style="border-bottom:2px solid black;width: 100%;padding-left:2px;">
				In forwarding this document, I/We authorize DHL Express (India) Pvt. Ltd. (DHL). Its group companies and their agenis, to act as our agent to clear this Shipment from Customs and also give our consent to sign, submit and file in physical or digitally, the e-way bill / shipping bill and other forms, as and when required, under various statutes to authorites for undertaking the Shipment on behalf.
			</div>
			<div style="width: 100%;padding-left:2px;">
				<div style="width:100%;float:left;">Please indicate API(As per Invoice) if any details is mentioned in the invoice<br>We hered by confirm that the above details declared are true and correct.</div>
				<div style="width:60%;float:left;border-right:2px solid black;">We confirm that our company's IEC & Bank AD Code Details<br>are registered with EDI System of  Air  Cargo where the clearance is being done<br>* <b>LC(Letter of Credit) Shipments are not handled by DHL</b></div>
				<div style="width:40%;float:left;border-top:2px solid black;">
					<div style="width:100%;float:left;border-bottom:2px solid black;">&nbsp;</div>
					<div style="width:100%;float:left;text-align:center;">SIGNATURE OF EXPORTER/STAMP</div>
				</div>
			</div>
	</div>	
</div>