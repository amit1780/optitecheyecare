<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dbvars {
    const TABLE = 'svi_config';    
    private $data;
    private $ci;
    private $q;
    
    function __construct()
    {
        $this->ci =& get_instance();
	
        $this->q = $this->ci->db->get(self::TABLE);
		
        foreach($this->q->result() as $row)
		{
			$this->data[$row->key] = $row->value;
		}			
    }
	
	function __get($key){
		
		return $this->data[$key];
    }
}
?>