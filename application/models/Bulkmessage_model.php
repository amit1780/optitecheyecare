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

	public function getEmailMsgList(){
		$currentDate=date('Y-m-d');
		
		$this->db->select('es.*,wm.*')
            ->from('email_schedule es');
		$this->db->join('wa_messages wm', 'wm.msg_id = es.msg_id', 'left');
		$this->db->where('es.scheduled_date<="'.$currentDate.'"');
		$this->db->where('es.status','P');

		$this->db->limit( 30, 0 );	
			$query = $this->db->get();
			
		return $query->result_array();
	}	

	public function getTotalEmailsSentToday(){
		$currentDate=date('Y-m-d');
		
		$this->db->select('count(*) as totalSent')
            ->from('email_schedule es');
		$this->db->where('YEAR(es.send_date)="'.date('Y').'"');
		$this->db->where('MONTH(es.send_date)="'.date('m').'"');
		$this->db->where('DAY(es.send_date)="'.date('d').'"');
		

		$query = $this->db->get();
		#echo $this->db->last_query();exit;
			
		return $query->row();
	}	
}