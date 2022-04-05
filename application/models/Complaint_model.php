<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Complaint_model extends CI_Model {

	
	public function __construct() {		
		parent::__construct();
		$this->load->database();		
	}	
	
	public function addComplaint($data,$complaint_file) {				
		$complaint_data = array(
			'user_id'   					=> $data['user_id'],			
			'date_of_complaint'   			=> $data['date_of_complaint'],			
			'customer_id'   				=> $data['customer_id'],			
			'complaint_category_id'   		=> $data['complaint_category_id'],			
			'category_id'   				=> $data['category_id'],			
			'complaint_mode_id'   			=> $data['complaint_mode_id'],			
			'concern_dept_id'   			=> $data['concern_dept_id'],				
			'date_added'   					=> date('Y-m-j H:i:s')		
		);		
		$this->db->insert('complaint', $complaint_data);
		
		$complaint_id = $this->db->insert_id();
		$file='';
		foreach($data['message'] as $key => $value){
			if($key == 'complaint'){
				$file = $complaint_file;
			}				
			 $complaint_mass = array(
				'complaint_id'   				=> $complaint_id,			
				'user_id'   					=> $_SESSION['user_id'],			
				'mess_type '   					=> $key,			
				'message'   					=> $value,
				'file'							=> $file,
				'date_added'   					=> date('Y-m-j H:i:s')	
			);
						
			$this->db->insert('complaint_message', $complaint_mass);			
		}		
		return $complaint_id;
	}
	
	public function updateComplaint($data){
		$complaint_data = array(
			'date_of_customer_info'   			=> $data['date_of_customer_info'],			
			'status'   							=> $data['status']
		);
		
		$this->db->where('complaint_id', $data['complaint_id']);
		$this->db->update('complaint', $complaint_data);
		return true;
	}
	
	public function getProductCategory() {				
		$this->db->select('*')
            ->from('category');
		$this->db->order_by('name',"ASC");
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function getComplaintCategory() {				
		$this->db->select('*')
            ->from('complaint_category');
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function getComplaintConcernDept() {				
		$this->db->select('*')
            ->from('complaint_concern_dept');
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function getComplaintMode() {				
		$this->db->select('*')
            ->from('complaint_mode');
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function getComplaint($limit, $start,$data) {	
		$qryArr=Array();
		
		if(!empty($data['complaint_id'])){
			$qryArr['complaint_id'] = financialComplaintId($data['complaint_id'],$data['fcomyear']);
		}
		
		if(!empty($data['user_id'])){
			$qryArr['user_id']=$data['user_id'];
		}
		
		if(!empty($data['complaint_category_id'])){
			$qryArr['complaint_category_id']=$data['complaint_category_id'];
		}
		
		if(!empty($data['category_id'])){
			$qryArr['category_id']=$data['category_id'];
		}
		
		if(!empty($data['complaint_mode_id'])){
			$qryArr['complaint_mode_id']=$data['complaint_mode_id'];
		}
		
		if(!empty($data['status'])){
			$qryArr['status']=$data['status'];
		}
	
		$this->db->select('*, (SELECT username FROM svi_user WHERE user_id = svi_complaint.user_id) as username, (SELECT complaint_category_name FROM svi_complaint_category WHERE complaint_category_id = svi_complaint.complaint_category_id) as complaint_category_name, (SELECT name FROM svi_category WHERE category_id = svi_complaint.category_id) as product_category, (SELECT complaint_mode_name FROM svi_complaint_mode WHERE complaint_mode_id = svi_complaint.complaint_mode_id) as complaint_mode_name, (SELECT concern_dept_name FROM svi_complaint_concern_dept WHERE concern_dept_id = svi_complaint.concern_dept_id) as concern_dept_name')
            ->from('complaint');
			
		$this->db->join('customer', 'customer.customer_id = complaint.customer_id', 'left');
		$this->db->where($qryArr);
		
		if(!empty($data['company_name'])){
			$this->db->group_start();				
				$this->db->like('customer.company_name',trim($data['company_name']));
				$this->db->or_like('customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("complaint.date_of_complaint >=", $start_date);
				$this->db->where("complaint.date_of_complaint <=", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('complaint.date_of_complaint',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('complaint.date_of_complaint',$end_date);
			$this->db->group_end();
		}
		
		$this->db->limit( $limit, $start );	
		
		if($data['order'] && $data['sort']){
			$this->db->order_by($data['sort'], $data['order']);
		} else {
			$this->db->order_by('complaint.complaint_id',"DESC");			
		}
		
		$query = $this->db->get();
		
		return $query->result_array();	
	}
	
	public function getTotalComplaint($data) {	
		$qryArr=Array();
		
		if(!empty($data['complaint_id'])){
			$qryArr['complaint_id'] = financialComplaintId($data['complaint_id'],$data['fcomyear']);
		}
		
		if(!empty($data['user_id'])){
			$qryArr['user_id']=$data['user_id'];
		}
		
		if(!empty($data['complaint_category_id'])){
			$qryArr['complaint_category_id']=$data['complaint_category_id'];
		}
		
		if(!empty($data['category_id'])){
			$qryArr['category_id']=$data['category_id'];
		}
		
		if(!empty($data['complaint_mode_id'])){
			$qryArr['complaint_mode_id']=$data['complaint_mode_id'];
		}
		
		if(!empty($data['status'])){
			$qryArr['status']=$data['status'];
		}
	
		$this->db->select('*, (SELECT username FROM svi_user WHERE user_id = svi_complaint.user_id) as username, (SELECT complaint_category_name FROM svi_complaint_category WHERE complaint_category_id = svi_complaint.complaint_category_id) as complaint_category_name, (SELECT name FROM svi_category WHERE category_id = svi_complaint.category_id) as product_category, (SELECT complaint_mode_name FROM svi_complaint_mode WHERE complaint_mode_id = svi_complaint.complaint_mode_id) as complaint_mode_name, (SELECT concern_dept_name FROM svi_complaint_concern_dept WHERE concern_dept_id = svi_complaint.concern_dept_id) as concern_dept_name')
            ->from('complaint');
			
		$this->db->join('customer', 'customer.customer_id = complaint.customer_id', 'left');
		$this->db->where($qryArr);
		
		if(!empty($data['company_name'])){
			$this->db->group_start();				
				$this->db->like('customer.company_name',trim($data['company_name']));
				$this->db->or_like('customer.contact_person',trim($data['company_name']));
			$this->db->group_end();
		}
		
		if(!empty($data['start_date']) && !empty($data['end_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'].' 00:00:01';
				$end_date = $data['end_date'].' 23:59:59';
				
				$this->db->where("complaint.date_of_complaint >=", $start_date);
				$this->db->where("complaint.date_of_complaint <=", $end_date);
          
			$this->db->group_end();
		} else if(!empty($data['start_date'])){
			$this->db->group_start();
				$start_date = $data['start_date'];
				$this->db->like('complaint.date_of_complaint',$start_date);
			$this->db->group_end();
		}else if(!empty($data['end_date'])){
			$this->db->group_start();
				$end_date = $data['end_date'];
				$this->db->like('complaint.date_of_complaint',$end_date);
			$this->db->group_end();
		}
		
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getComplaintById($complaint_id) {				
		$this->db->select('*, (SELECT username FROM svi_user WHERE user_id = svi_complaint.user_id) as username, (SELECT company_name FROM svi_customer WHERE customer_id = svi_complaint.customer_id) as company_name, (SELECT complaint_category_name FROM svi_complaint_category WHERE complaint_category_id = svi_complaint.complaint_category_id) as complaint_category_name, (SELECT name FROM svi_category WHERE category_id = svi_complaint.category_id) as product_category, (SELECT complaint_mode_name FROM svi_complaint_mode WHERE complaint_mode_id = svi_complaint.complaint_mode_id) as complaint_mode_name, (SELECT concern_dept_name FROM svi_complaint_concern_dept WHERE concern_dept_id = svi_complaint.concern_dept_id) as concern_dept_name')
            ->from('complaint');
		$this->db->where('complaint_id', $complaint_id);
			$query = $this->db->get();
		return $query->row();	
	}
	
	public function getComplaintDetailById($complaint_id) {				
		$this->db->select('*, (SELECT username FROM svi_user WHERE user_id = svi_complaint_message.user_id) as username')
            ->from('complaint_message');
			$array = array('complaint_id' => $complaint_id, 'mess_type' => 'complaint');
			$this->db->where($array);
			$this->db->order_by('date_added',"DESC");
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function getComplaintCorrectiveById($complaint_id) {				
		$this->db->select('*, (SELECT username FROM svi_user WHERE user_id = svi_complaint_message.user_id) as username')
            ->from('complaint_message');
			$array = array('complaint_id' => $complaint_id, 'mess_type' => 'corrective');
			$this->db->where($array);
			$this->db->order_by('date_added',"DESC");
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function getComplaintPreventiveById($complaint_id) {				
		$this->db->select('*, (SELECT username FROM svi_user WHERE user_id = svi_complaint_message.user_id) as username')
            ->from('complaint_message');
			$array = array('complaint_id' => $complaint_id, 'mess_type' => 'preventive');
			$this->db->where($array);
			$this->db->order_by('date_added',"DESC");
			$query = $this->db->get();
		return $query->result_array();	
	}
	
	public function addComplaintMessage($data,$file) {				
		 $complaint_mass = array(
				'complaint_id'   				=> $data['complaint_id'],			
				'user_id'   					=> $_SESSION['user_id'],			
				'mess_type '   					=> $data['mess_type'],			
				'message'   					=> $data['complaint'],
				'file'							=> $file,
				'date_added'   					=> date('Y-m-j H:i:s')	
			);
						
			$this->db->insert('complaint_message', $complaint_mass);
		return true;
	}
	
	public function getUserInfoByDepartmentId($department_id) {				
		$this->db->select('*')
            ->from('user');
		$this->db->where('department_id', $department_id);
		$query = $this->db->get();
		return $query->row();
	} 
	
	public function getUserInfoByUserId($user_id) {				
		$this->db->select('*')
            ->from('user');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->row();
	} 
	
}
