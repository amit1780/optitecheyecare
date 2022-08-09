<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bulkmessage_model extends CI_Model {

	
	public function __construct() {		
		parent::__construct();
		$this->load->database();		
	}
	
	
	
	public function getWaMsgList() {
		$currentDate=date('Y-m-d');
		
		$this->db->select('ws.*,wm.*')
            ->from('whatsapp_schedule ws');
		$this->db->join('wa_messages wm', 'wm.msg_id = ws.msg_id', 'left');
		$this->db->where('ws.scheduled_date<="'.$currentDate.'"');
		$this->db->where('ws.status','P');

		$this->db->limit( 50, 0 );	
			$query = $this->db->get();
			
		return $query->result_array();
	}
	
	
	
}