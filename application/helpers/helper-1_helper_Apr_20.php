<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function getQuotationNo($quotation_id)
{
    return str_pad($quotation_id, 7, "Q-00000", STR_PAD_LEFT);
}

function getOrderNo($order_id)
{
    return str_pad($order_id, 7, "O-00000", STR_PAD_LEFT);
}

function getChallanNo($challan_id)
{
    return str_pad($challan_id, 7, "C-00000", STR_PAD_LEFT);
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
?>
