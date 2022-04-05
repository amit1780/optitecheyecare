<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Setting_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function addSet($data){
		
				
		$key = array_search ($data['config_exp_before'], $data);
		
		$this->db->select('*')
            ->from('config');
		$this->db->where('key', $key);	
		$query = $this->db->get();
		$configData = $query->row();
		if($configData){
			$this->db->where('key', $key);
			$this->db->delete('config');
			
			$data = array(			
				'key'   			=> $key,
				'value'   			=> $data['config_exp_before']			
			);
			
			$this->db->insert('config', $data);					
			return true;
		} else {
			$data = array(			
				'key'   			=> $key,
				'value'   			=> $data['config_exp_before']			
			);
			
			$this->db->insert('config', $data);					
			return true;			
		}
		
			 
	}
	
	public function getConfigData(){
		$this->db->select('*')
            ->from('config');		
		$query = $this->db->get();
		return $query->row();		
	}
	
}