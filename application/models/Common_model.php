<?php
class Common_model extends CI_Model {

    function getLastSendEmail($customerId){

        $this->db->select('e.*');
        $this->db->from('emailsend e');
		$this->db->where('e.customer_id', $customerId);
        $this->db->order_by('e.send_date','DESC');
		$this->db->limit( 1,0 );	
        $query = $this->db->get();
        return $query->row();
    }
	function searchCustomerByOrderID($data=Array()){
		$searchString=urldecode($searchString);
        $this->db->select('c.customer_id,c.first_name,c.last_name,c.company');
        $this->db->from('customers c');
		$this->db->like("CONCAT(c.first_name,' ',c.last_name )", $searchString);
		$this->db->or_like('c.company', $searchString);
        $this->db->order_by('c.first_name','ASC');
        $this->db->order_by('c.last_name','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  		
        return $query;
    }
	public function addEmail($data) {	
		$email_data = array(
			'customer_id'		=> $data['customer_id'],
			'email'   			=> $data['email'],
			'subject'   		=> $data['subject'],
			'send_date'   		=> date('Y-m-j H:i:s'),
			'sent_by'   		=> $_SESSION['user_id']
		);		
		$this->db->insert('emailsend', $email_data);
		//echo $this->db->last_query();
		return true;		
	}
	function getUserDetails($userId){

        $this->db->select('*');
        $this->db->from('user');
		$this->db->where('user_id', $userId);
        $query = $this->db->get();
		
        return $query->row();
    }
}