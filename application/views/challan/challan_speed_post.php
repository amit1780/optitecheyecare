<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="text-align:center;"><input type="button" onclick="printDiv('printableArea')" value="print" /></div></br>
<div id="printableArea" style="padding:0px;font-size:14px;">	
	<div style="text-align:center;"><b></b></div>
	<style>
		table {
		  border-spacing: 0;
		  font-size:11px;
		  border-collapse: collapse;
		  color:black;
		}
		
		table,td {
		  border: 1px solid gray;
		}
		th, td {
			padding: 0;
		}
	</style>
	<table>
		<tr>
			<td valign="top" width="5%" style="padding-left:10px;padding-right:5px;">Bill of Export No. and date.</td>
			<td valign="top" align="center">Foreign Post office code</td>
			<td valign="top" align="center">Name of Exporter</td>
			<td valign="top" align="center">Address of Exporte</td>
			<td valign="top" align="center">IEC </td>
			<td valign="top" align="center" width="5%">State<br/>code </td>
			<td valign="top" align="center">GSTIN or as applicable</td>
			<td colspan="2" valign="top" align="center">
				Details of Customs Broker					
				<div style="width:100%;border-top:1px solid gray;margin-top:12px;">
					<div style="width:50%;float:left;border-right:1px solid gray;padding-bottom: 12px;">License No.</div>
					<div style="width:45%;float:left;">Name and address</div>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" width="5%" style="padding-left:10px;padding-right:5px;"></td>
			<td valign="top" align="center"></td>
			<td valign="top" align="center"></td>
			<td valign="top" align="center"></td>
			<td valign="top" align="center"></td>
			<td valign="top" align="center" width="5%"> </td>
			<td valign="top" align="center"></td>
			<td colspan="2" valign="top" align="center">
				<div style="width:100%;border-top:0px solid gray;">
					<div style="width:50%;float:left;border-right:1px solid gray;padding-bottom: 12px;"></div>
					<div style="width:45%;float:left;"></div>
				</div>
			</td>
		</tr>
		
		<tr>
			<td colspan="7" align="center"><b>Declarations</b></td>
			<td align="center">Yes/No as applicable</td>
		</tr>
		
		<tr>
			<td valign="top" width="5%" style="padding-left:10px;padding-right:5px;">1.</td>
			<td colspan="6" valign="top" align="left" style="padding-left:10px;">We declare that we intend to claim rewards under Merchandise Exports from India Scheme (MEIS)(for export through Chennai / Mumbai / Delhi FPO only).</td>
			<td ></td>
		</tr>
		
		<tr>
			<td valign="top" width="5%" style="padding-left:10px;padding-right:5px;">2.</td>
			<td colspan="6" valign="top" align="left" style="padding-left:10px;">We declare that we intend to zero rate our exports under Section 16 of IGST Act.</td>
			<td ></td>
		</tr>
		
		<tr>
			<td valign="top" width="5%" style="padding-left:10px;padding-right:5px;">3.</td>
			<td colspan="6" valign="top" align="left" style="padding-left:10px;">We declare that the goods are exempted under CGST/SGST/UTGST/IGST Acts. </td>
			<td ></td>
		</tr>
		
		<tr>			
			<td colspan="9" valign="top" align="left" style="padding-left:10px;">
			We hereby declare that the contents of this postal bill of export are true and correct in every respect.
				<div style="margin-top:25px;margin-bottom:5px;">(Signature of the Exporter/ Authorised agent)</div>
			</td>			
		</tr>
		
		<tr>			
			<td colspan="9" valign="top" align="left" style="padding-left:10px;">
				Examination order and report
				<div style="margin-top:25px;margin-bottom:10px;float:right;margin-right:10px;">Let Export Order: Signature of officer of Customs along with stamp and date.</div>
			</td>			
		</tr>		
	</table>
	<br/>
	<table width="100%">
		<tr>
			<td colspan="14" align="center" ><b>Details of parcel</b></td>
		</tr>
		<tr>
			<td valign="top" width="5%" style="padding-left:10px;">Sl.<br/>No</td>
			<td colspan="2" valign="top" width="20%" align="center">Consignee details
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:50%;float:left;border-right:1px solid gray;height:70px;">Name and Address</div>
					<div style="width:45%;float:left;">Country of destination</div>
				</div>
			</td>
			<td colspan="4" valign="top" width="25%" align="center" >Product details
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:30%;float:left;border-right:1px solid gray;text-align:center;height:70px;">Description</div>
					<div style="width:20%;float:left;border-right:1px solid gray;text-align:center;height:70px;">CTH</div>
					<div style="width:42%;float:left;">Quantity
						<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
							<div style="width:50%;float:left;border-right:1px solid gray;height:54px;text-align:right;">Unit<br/>(pieces, litres, kgs.<br/>,meters)</div>
							<div style="width:45%;float:left;">number</div>
						</div>
					
					</div>
				</div>
			
			</td>
			<td colspan="3" valign="top" width="15%" align="center" >Details of Parcel
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:50%;float:left;border-right:1px solid gray;height:70px;">Invoice no. and date</div>
					<div style="width:45%;float:left;">Weight
						<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
							<div style="width:50%;float:left;border-right:1px solid gray;height:54px;">Gross</div>
							<div style="width:45%;float:left;">net</div>
						</div>
					</div>
				</div>			
			</td>
			<td colspan="4" valign="top" align="center" >E-commerce particulars
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:20%;float:left;border-right:1px solid gray;text-align:center;height:70px;">URL (Name) of<br/>website</div>
					<div style="width:20%;float:left;border-right:1px solid gray;text-align:center;height:70px;">Payment transaction<br/>ID</div>
					<div style="width:20%;float:left;border-right:1px solid gray;text-align:center;height:70px;">SKU<br/>No.</div>
					<div style="width:20%;float:left;text-align:center;">Postal tracking<br/>number</div>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">1</td>
			<td align="center">2</td>
			<td align="center">3</td>
			<td align="center">4</td>
			<td align="center">5</td>
			<td align="center">6</td>
			<td align="center">7</td>
			<td align="center">8</td>
			<td align="center">9</td>
			<td align="center">10</td>
			<td align="center">11</td>
			<td align="center">12</td>
			<td align="center">13</td>
			<td align="center">14</td>
		</tr>
	</table>
	
	<br/>
	
	<table width="100%">
		<tr>
			<td width="25%" colspan="4" valign="top" style="padding-left:10px;"><b>Assessable value under section 14 of the<br/>Customs Act</b></td>
			<td width="25%" colspan="4" valign="top" align="center"><b>Details of Tax invoice or commercial<br/>invoice ( whichever applicable)</b></td>
			<td width="40%" colspan="9" valign="top" align="center"><b>Details of duty/ tax</b></td>
			<td colspan="2" valign="top" align="center"><b>Total </b></td>
		</tr>
		<tr>
			<td valign="top" align="center">FOB</td>
			<td valign="top" align="center">Curren<br/>cy</td>
			<td valign="top" align="center">Exchange<br/>rate</td>
			<td valign="top" align="center">Amount<br/>in INR</td>
			<td valign="top" align="center">H.S<br/>code</td>
			<td colspan="2" valign="top" align="center">Invoice details
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:49.6%;float:left;border-right:1px solid gray;height:54px;">invoice no.<br/>and date</div>
					<div style="width:45%;float:left;">Sl. No.<br/>of item<br/>in<br/>invoice</div>
				</div>			
			</td>
			<td valign="top" align="center">value</td>
			<td colspan="4" valign="top" align="center">Customs duties
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:50%;float:left;border-right:1px solid gray;height:54px;">Export duty
						<div style="width:100%;border-top:1px solid gray;margin-top:14px;">
							<div style="width:50%;float:left;border-right:1px solid gray;height:28px;">rate</div>
							<div style="width:45%;float:left;">amount</div>
						</div>					
					</div>
					<div style="width:45%;float:left;">Cess
						<div style="width:100%;border-top:1px solid gray;margin-top:14px;">
							<div style="width:50%;float:left;border-right:1px solid gray;height:28px;">rate</div>
							<div style="width:45%;float:left;">amount</div>
						</div>
					</div>
				</div>	
			</td>
			<td colspan="5" valign="top" align="center">GST details
				<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
					<div style="width:30%;float:left;border-right:1px solid gray;height:54px;">IGST (if<br/>applicable)
						<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
							<div style="width:50%;float:left;border-right:1px solid gray;height:28px;">rate</div>
							<div style="width:45%;float:left;">amount</div>
						</div>
					</div>
					<div style="width:35%;float:left;border-right:1px solid gray;">Compensation cess<br/>(if applicable)
						<div style="width:100%;border-top:1px solid gray;margin-top:2px;">
							<div style="width:50%;float:left;border-right:1px solid gray;height:28px;">rate</div>
							<div style="width:45%;float:left;">amount</div>
						</div>
					</div>
					<div style="width:30%;float:left;">LUT/ bond<br/>details (if<br/>applicable)</div>
				</div>	
			</td>
			<td colspan="2" valign="top" align="center">
				<div style="width:100%;border-top:1px solid gray;margin-top:14px;">
					<div style="width:50%;float:left;border-right:1px solid gray;height:54px;">duties</div>
					<div style="width:45%;float:left;">cess</div>
				</div>	
			</td>
		</tr>
		<tr>
			<td valign="top" align="center">15</td>
			<td valign="top" align="center">16</td>
			<td valign="top" align="center">17</td>
			<td valign="top" align="center">18</td>
			<td valign="top" align="center">19</td>
			<td valign="top" align="center">20</td>
			<td valign="top" align="center">21</td>
			<td valign="top" align="center">22</td>
			<td valign="top" align="center">23</td>
			<td valign="top" align="center">24</td>
			<td valign="top" align="center">25</td>
			<td valign="top" align="center">26</td>
			<td valign="top" align="center">27</td>
			<td valign="top" align="center">28</td>
			<td valign="top" align="center">29</td>
			<td valign="top" align="center">30</td>
			<td valign="top" align="center">31</td>
			<td valign="top" align="center">32</td>
			<td valign="top" align="center">33</td>
		</tr>
	</table>
	
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