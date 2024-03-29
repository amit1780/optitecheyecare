<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sli_model extends CI_Model {

	
	public function __construct() {		
	
		parent::__construct();
		$this->load->database();		
		
	}
	
	public function addSliDetails($data){
		
		if($data['sli_id'] == 1){
			$data['country_id'] = 0;	
		}
		
		if($data['rodtep'] == '1'){
		    $rodtep = 1;
		}else{
		    $rodtep = 0;
		}
		
		$sli_data=array(
			'challan_id' 					=> $data['challan_id'],
			'sli_id' 						=> $data['sli_id'],
			'igstin_pay_status' 			=> $data['igstin_pay_status'],
			'if_b' 							=> $data['if_b'],
			'igst_amount' 					=> $data['igst_amount'],
			'incoterms' 					=> $data['incoterms'],
			'nob_duty_drawback' 			=> $data['nob_duty_drawback'],
			'ein_no' 						=> $data['ein_no'],
			'nature_of_payment' 			=> $data['nature_of_payment'],
			'fob_value' 					=> $data['fob_value'],
			'no_of_pkgs' 					=> $data['no_of_pkgs'],
			'net_wt' 						=> $data['net_wt'],
			'gross_wt' 						=> $data['gross_wt'],
			'volume_wt' 					=> $data['volume_wt'],
			'lbh' 							=> $data['lbh'],		
			'marks_and_number' 				=> $data['marks_and_number'],			
			'ship_bill_tick' 				=> $data['ship_bill_tick'],			
			'description_good' 				=> $data['description_good'],			
			'destination_country' 			=> $data['country_id'],			
			'tel_number' 					=> $data['tel_number'],			
			'email_id' 						=> $data['email_id'],			
			'post_contact_person' 			=> $data['post_contact_person'],			
			'post_mobile' 					=> $data['post_mobile'],			
			'lut' 							=> $data['lut'],			
			'exporter_type' 				=> $data['exporter_type'],
			'rodtep' 				        => $rodtep,
			'document_delivery_email' 		=> $data['document_delivery_email'],			
			'customs_broker' 				=> $data['customs_broker'],			
			'date_added'					=> date('Y-m-d H:i:s')
		);
		
				
		if($data['sli_detail_id']){			
		
			$this->db->where('sli_detail_id', $data['sli_detail_id']);
			$this->db->update('sli_details', $sli_data);				
		} else {
			$this->db->insert('sli_details',$sli_data);
			$id = $this->db->insert_id() ;
		}
		
		if($data['special_instruction']){
			$special_data=array(
				'special_instruction' 	=> $data['special_instruction']
			);
			$this->db->where('challan_id', $data['challan_id']);
			$this->db->update('challan', $special_data);
		}

		if(empty($data['dhl_doc']) && ($data['sli_id'] == 1)){
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
		}	
		
		if($data['dhl_doc'] && ($data['sli_id'] == 1)){
			
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
			
			foreach($data['dhl_doc'] as $doc){
				/* if($doc == 17){
					$doc_label = $data['dhl_doc_17_text'];
				} else if($doc == 18){
					$doc_label = $data['dhl_doc_18_text'];
				} else {
					$doc_label = '';
				} */
				
				$sli_data=array(
					'sli_detail_id' 		=> $id,
					'sli_id' 				=> $data['sli_id'],
					'doc' 					=> $doc,			
					//'doc_label' 			=> $doc_label,			
					'date_added'			=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('sli_doc',$sli_data);				
			}
		}
		
		if(empty($data['fedex_doc']) && (($data['sli_id'] == 2) || ($data['sli_id'] == 3))){
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
		}
		
		if($data['fedex_doc'] && ($data['sli_id'] == 2 || ($data['sli_id'] == 3))){
			
			if($data['sli_detail_id']){				
				$id = $data['sli_detail_id'];				
				$this->db->where('sli_id', $data['sli_id']);
				$this->db->where('sli_detail_id', $data['sli_detail_id']);
				$this->db->delete('sli_doc');	
			}
			
			foreach($data['fedex_doc'] as $doc){
				/* if($doc == 17){
					$doc_label = $data['dhl_doc_17_text'];
				} else if($doc == 18){
					$doc_label = $data['dhl_doc_18_text'];
				} else {
					$doc_label = '';
				} */
				$doc_label = '';
				
				$sli_data=array(
					'sli_detail_id' 		=> $id,
					'sli_id' 				=> $data['sli_id'],
					'doc' 					=> $doc,			
					'doc_label' 			=> $doc_label,			
					'date_added'			=> date('Y-m-d H:i:s')
				);
				
				$this->db->insert('sli_doc',$sli_data);				
			}
		}
		
		$sli_status=array(
			'sli_status' 	=> 'Y'
		);
		
		$this->db->where('challan_id', $data['challan_id']);
		$this->db->update('challan', $sli_status);
		return true;
	}
	
	public function getSli() {
		$this->db->select('*')
            ->from('sli');        
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getSliDocLabel($sli_id) {
		$this->db->select('*')
            ->from('sli_doc_label');
		$array = array('sli_id' => $sli_id,'status' => 'Y');
		$this->db->where($array);
		$query = $this->db->get();	
		return $query->result_array();
	}	

	public function getSliById($sli_id) {
		$this->db->select('*')
            ->from('sli');
		$array = array('sli_id' => $sli_id);
		$this->db->where($array);
		$query = $this->db->get();	
		return $query->row();
	}	

	public function editSli($data) {
		$sli_data = array(
			'sli_id'   					=> $data['sli_id'],
			'sli_name'   				=> trim($data['sli_name']),
			'sli_account_number'   		=> $data['sli_account_number']
		);		
		$this->db->where('sli_id', $data['sli_id']);
		$this->db->update('sli', $sli_data);
		return true;
	}	
	
	public function getSliDetailsByID($sli_id,$challan_id){
		$this->db->select('*,(SELECT name FROM svi_country WHERE country_id = svi_sli_details.destination_country) as country_name,(SELECT sli_account_number FROM svi_sli WHERE sli_id = svi_sli_details.sli_id) as sli_account_number')
            ->from('sli_details');
		$array = array('sli_id' => $sli_id, 'challan_id' => $challan_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->row();
	}
	
	public function getSliDocByID($sli_id,$sli_detail_id){
		$this->db->select('*')
            ->from('sli_doc');
		$array = array('sli_id' => $sli_id, 'sli_detail_id' => $sli_detail_id);
		$this->db->where($array);
		$query = $this->db->get();		
		return $query->result_array();
	}
}