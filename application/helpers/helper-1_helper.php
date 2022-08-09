<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function getQuotationNo($quotation_id)
{	
    #return str_pad($quotation_id, 7, "Q-00000", STR_PAD_LEFT);
    return "Q".$quotation_id;
}

function getOrderNo($order_id)
{
    #return str_pad($order_id, 7, "O-00000", STR_PAD_LEFT);
    return "O".$order_id;
}

function getChallanNo($challan_id)
{
    #return str_pad($challan_id, 7, "C-00000", STR_PAD_LEFT);
    return "C".$challan_id;
}

function getComplaintId($complaint_id)
{
    return "SR".$complaint_id;
}

if(!function_exists('dateFormat'))
{
    function dateFormat($format,$givenDate=null)
    {	
		if($givenDate != '0000-00-00 00:00:00'){			
			return date($format, strtotime($givenDate));
		} else {
			return '';
		}		
    }
}

if(!function_exists('financialQuoteId'))
{
    function financialQuoteId($quote_id,$fyear)
    {
		$quote_id = (int)$quote_id;
		$quote_id = str_pad($quote_id, 4, "0000", STR_PAD_LEFT);
		$quote_id = $fyear.$quote_id;
		return $quote_id;
    }
}

if(!function_exists('financialOrderId'))
{
    function financialOrderId($order_id,$fyear)
    {
		$order_id = (int)$order_id;
		$order_id = str_pad($order_id, 4, "0000", STR_PAD_LEFT);
		$order_id = $fyear.$order_id;
		return $order_id;
    }
}

if(!function_exists('financialChallanId'))
{
    function financialChallanId($challan_id,$fyear)
    {
		$challan_id = (int)$challan_id;
		$challan_id = str_pad($challan_id, 4, "0000", STR_PAD_LEFT);
		$challan_id = $fyear.$challan_id;
		return $challan_id;
    }
}

if(!function_exists('financialComplaintId'))
{
    function financialComplaintId($complaint_id,$fyear)
    {
        $complaint_id = (int)$complaint_id;
		$complaint_id = str_pad($complaint_id, 4, "0000", STR_PAD_LEFT);
		$complaint_id = $fyear.$complaint_id;
		return $complaint_id;
    }
}

if(!function_exists('idFormat'))
{
    function idFormat($id)
    {
        $id = (int)$id;
		$id = str_pad($id, 4, "0000", STR_PAD_LEFT);
		if($id > 0){
			return $id;
		} else {
			return $id='';
		}
    }
}


if(!function_exists('financialList'))
{
    function financialList($dropdown,$type)
    {
        $strartYear = 2018;
		$prevYear = substr(($strartYear +1),2);
		$html = '';
		for($i=$strartYear; $i < date("Y"); $i++){
			$strartYear = $strartYear + 1;
			$prevYear = $prevYear + 1;
			$year = $strartYear . "" . $prevYear;
			$html .= '<a class="dropdown-item '.$dropdown.'" id='.$year.' href="#" >'.$type.''.$year.'</a>';
		}
		return $html;
    }
}

if(!function_exists('numberTowords'))
{
	function numberTowords($num)
	{
		$ones = array(
			0 =>"ZERO",
			1 => "ONE",
			2 => "TWO",
			3 => "THREE",
			4 => "FOUR",
			5 => "FIVE",
			6 => "SIX",
			7 => "SEVEN",
			8 => "EIGHT",
			9 => "NINE",
			10 => "TEN",
			11 => "ELEVEN",
			12 => "TWELVE",
			13 => "THIRTEEN",
			14 => "FOURTEEN",
			15 => "FIFTEEN",
			16 => "SIXTEEN",
			17 => "SEVENTEEN",
			18 => "EIGHTEEN",
			19 => "NINETEEN",
			"014" => "FOURTEEN"
		);
		$tens = array( 
			0 => "ZERO",
			1 => "TEN",
			2 => "TWENTY",
			3 => "THIRTY", 
			4 => "FORTY", 
			5 => "FIFTY", 
			6 => "SIXTY", 
			7 => "SEVENTY", 
			8 => "EIGHTY", 
			9 => "NINETY" 
		); 
		$hundreds = array( 
			"HUNDRED", 
			"THOUSAND", 
			"MILLION", 
			"BILLION", 
			"TRILLION", 
			"QUARDRILLION" 
		); /*limit t quadrillion */
		$num = number_format($num,2,".",","); 
		$num_arr = explode(".",$num); 
		$wholenum = $num_arr[0]; 
		$decnum = $num_arr[1]; 
		$whole_arr = array_reverse(explode(",",$wholenum)); 
		krsort($whole_arr,1); 
		$rettxt = ""; 
		foreach($whole_arr as $key => $i){		
			while(substr($i,0,1)=="0")
					$i=substr($i,1,5);
			if($i < 20){ 
				/* echo "getting:".$i; */
				$rettxt .= $ones[$i]; 
			}elseif($i < 100){ 
				if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
				if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
			}else{ 
				if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
				if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
				if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
			} 
			if($key > 0){ 
				$rettxt .= " ".$hundreds[$key]." "; 
			}
		}
		
		if($decnum > 0){
			$rettxt .= " and ";
			if($decnum < 20){
				$rettxt .= $ones[$decnum];
			}elseif($decnum < 100){
				$rettxt .= $tens[substr($decnum,0,1)];
				$rettxt .= " ".$ones[substr($decnum,1,1)];
			}
		}
		return $rettxt;
	}
	if(!function_exists('financial_year')){
	    function financial_year($startYear,$monthBreak,$default=''){   
			if(date('m')<=$monthBreak){
				$startYear=$startYear+1;
			}
			$dates = range(date('Y'),$startYear);
			if(!empty($default)){
				$financialYear[0]=$default;
			}
		
			foreach($dates as $date){

				if (date('m', strtotime($date)) <= $monthBreak) {//Upto August
					$year = ($date-1) . '-' . $date;
				} else {//After August
					$year = $date . '-' . ($date+1);
				}
				$financialYear[$year]=$year;
			}
			return $financialYear;			
	    }
	}
	if(!function_exists('getDates')){
		function getDates($finDates,$monBreak=''){
			
			$finDatesArray=Array();
			$ci=& get_instance();
			if($monBreak==''){
				$month= intval($ci->config->item('financialMonthBreak'));
			}else{
				$month=intval($monBreak);
			}
			$nextmonth = $month % 12 + 1; 
			$month = str_pad($month, 2, "0", STR_PAD_LEFT);
			$nextmonth = str_pad($nextmonth, 2, "0", STR_PAD_LEFT);
			$finDatesArray = preg_split("/-+/",$finDates);			
			$finDatesArray['startDt']=$finDatesArray['0'].'-'.$nextmonth.'-01';
			$lastdayofmonth=getlastDay(intval($month),$finDatesArray['1']);
			$finDatesArray['endDt']=$finDatesArray['1'].'-'.$month.'-'.$lastdayofmonth;			
			return $finDatesArray;
		}	
	}
	if(!function_exists('getlastDay')){
		function getlastDay($m,$y){
			
			$daysInMonth;
			if($m==4 || $m==6 || $m==9 || $m==11){
				$daysInMonth=30;
			}else{
				if($m==2){
					if($y % 4==0 ){
						$daysInMonth=29;
					}else{
						$daysInMonth=28;
					}				
				}else{
					$daysInMonth=31;
				}
				
			}
			return $daysInMonth;
			
		}
	}
}
if(!function_exists('SVI_Get_Query_string')){
	function SVI_Get_Query_string()
	{
		return $_SERVER['QUERY_STRING'];
		$CI =& get_instance();

		$url = $CI->config->site_url($CI->uri->uri_string());
		return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}
}

if(!function_exists('SVI_ucwords')){
	function SVI_ucwords($str)
	{
		$str=preg_replace('/(\W)/is',"$1 ",$str);
		$str=ucwords(strtolower(trim($str)));
		$str=preg_replace('/(\W)\s/is',"$1",$str);
		return $str;				
	}
}

?>
