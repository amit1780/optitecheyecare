<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model {

	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('user');
		$this->db->where('username', $username);
		#$this->db->where("(user.email = '$username' OR user.username = '$username')");		
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
		
	}
	

	public function get_user_id_from_username($username) {
		
		$this->db->select('user_id');
		$this->db->from('user');
		//$this->db->where('username', $username);
		$this->db->where("(user.email = '$username' OR user.username = '$username')");

		return $this->db->get()->row('user_id');
		
	}
	

	public function get_user($user_id) {
		
		$this->db->select('*,user.status as user_status');
		$this->db->from('user');
		$this->db->join('usergroup', 'usergroup.id = user.group_id', 'left');
		$this->db->where('user_id', $user_id);
		return $this->db->get()->row();
		
	}
	
	
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
	public function changePassword($data){
		
		$cate_data = array(
			'password'   	=> $this->hash_password($data['new_pass'])
		);
		
		$this->db->where('user_id', $_SESSION['user_id']);
		$this->db->update('user', $cate_data);
		return true;
	}
	
	public function getUserList() {
		
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('usergroup', 'usergroup.id = user.group_id', 'left');
		$this->db->join('store', 'store.store_id = user.store_id', 'left');
		$this->db->order_by("firstname ASC, username ASC");	
		$query = $this->db->get();		
		return $query->result_array();
		
	}
	
	public function getuserGroups(){
		$this->db->select('*');
		$this->db->from('usergroup');
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	public function getStores(){
		$this->db->select('*');
		$this->db->from('store');
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	
	public function addUser($data){
		
		$user_data = array(			
			'firstname'   			=> trim($data['firstname']),
			'lastname'				=> trim($data['lastname']),			
			'email'   				=> trim($data['email']),
			'username'				=> trim($data['username']),
			'mobile'				=> trim($data['mobile']),
			'password'				=> trim($this->hash_password($data['new_pass'])),
			'group_id'				=> $data['group_id'],
			'store_id'   			=> $data['store_id'],			
			'status'   				=> $data['status'],			
			'date_added' 			=> date('Y-m-j H:i:s')
		);
		
		$this->db->insert('user', $user_data);
		$user_id = $this->db->insert_id();						
		return true;	
	}
	
	public function editUser($data,$user_id){
		
		$user_data = array(			
			'firstname'   			=> trim($data['firstname']),
			'lastname'				=> trim($data['lastname']),			
			'email'   				=> trim($data['email']),
			'username'				=> trim($data['username']),
			'mobile'				=> trim($data['mobile']),
			'group_id'				=> $data['group_id'],
			'store_id'   			=> $data['store_id'],
			'status'   				=> $data['status'],
			'date_added' 			=> date('Y-m-j H:i:s')
		);
		
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $user_data);
		
		if($data['new_pass']){
			$pass_data = array('password' => $this->hash_password($data['new_pass']));			
			$this->db->where('user_id', $user_id);
			$this->db->update('user', $pass_data);			
		}
		
		return true;	
	}
	
	public function getUserById($user_id){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();		
		return $query->row();
	}
	
}
