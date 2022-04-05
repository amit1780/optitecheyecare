<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct() {		
		parent::__construct();
		$this->load->library(array('session'));
		
		$this->load->library('permission');
		$this->permission->getNotPermission();
		
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		$this->load->library('breadcrumbs');		
	}
	
	public function index()
	{		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('user/login');		
	}
	
	public function userList()
	{	
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('User List', '/userList');
	
		$data['page_heading'] = 'User List';
		
		$data['success'] = $_SESSION['success'];
		
		$data['users'] = $this->user_model->getUserList();
			
		$this->load->view('common/header');
		$this->load->view('user/user_list', $data);
		$this->load->view('common/footer');
		unset($_SESSION['success']);
	}
	
	public function addUser() {	
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
	
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Add User', '/addUser');
	
		$data['page_heading'] = 'Add User';		
		$data['form_action']= 'addUser';
		
		$data['userGroups'] = $this->user_model->getuserGroups();
		$data['stores'] = $this->user_model->getStores();
        
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required');		
		#$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		#$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
		$this->form_validation->set_rules(
        'username', 'Username',
        'required|min_length[4]|is_unique[user.username]',
				array(
						'required'      => 'You have not provided %s.',
						'is_unique'     => 'This %s already exists.'
				)
		);
			
		if ($this->form_validation->run() == false) {			
			
			$this->load->view('common/header');
			$this->load->view('user/user_form', $data);
			$this->load->view('common/footer');
			
		} else {
						
			$this->user_model->addUser($this->input->post());			
			$_SESSION['success']      = "Success: You have Added New Customer";
			redirect('/userList');
		}			
	}
	
	public function editUser($user_id) {
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('User List', '/userList');
		
		$data['page_heading'] = 'Edit User';		
		$data['form_action']= 'editUser/'.$user_id;
		
		$data['userGroups'] = $this->user_model->getuserGroups();
		$data['stores'] = $this->user_model->getStores();
		$data['user_id'] = $user_id;
		$data['userInfo'] = $this->user_model->getUserById($user_id); 
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required');		
		#$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		#$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
		#$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
		
		if($this->input->post('username') != $data['userInfo']->username) {			
		   $is_unique =  '|is_unique[user.username]';
		} else {
		   $is_unique =  '';
		}		
		$this->form_validation->set_rules('username', 'User Name', 'required|min_length[4]'.$is_unique);
		
			
		if ($this->form_validation->run() == false) {			
			
			$this->load->view('common/header');
			$this->load->view('user/user_form', $data);
			$this->load->view('common/footer');
			
		} else {						
			$this->user_model->editUser($this->input->post(),$user_id);			
			$_SESSION['success']      = "Success: You have Update Customer";
			redirect('/userList');
		}			
	}
	
	public function login() {	
				
		$data = new stdClass();		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('user/login');			
		} else {
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				
				
				$user    = $this->user_model->get_user($user_id);
				
				if($user->user_status == 1){
					
				
					$_SESSION['user_id']      = (int)$user->user_id;
					$_SESSION['username']     = (string)$user->username;
					$_SESSION['email']     	  = (string)$user->email;
					$_SESSION['logged_in']    = (bool)true;

					$sessionData = array(
						'user_id'  => (int)$user->user_id,
						'username'     => (string)$user->username,
						'firstname'     => (string)$user->firstname,
						'lastname'     => (string)$user->lastname,
						'email'         => (string)$user->email,
						'group_id'     => (int)$user->group_id,
						'store_id'     => (int)$user->store_id,
						'group_name'     => (string)$user->group_name,
						'group_type'     => (string)$user->group_type,
						'logged_in' => (bool)true
					);
					$this->session->set_userdata($sessionData);
					
					if($this->session->userdata('group_type') != 'EMP'){
						redirect('/dashboardtwo');
						exit;
					} else {
						redirect('/records');
						exit;
					}
				} else {
					$data->error = 'Wrong username or password.';				
					$this->load->view('user/login', $data);					
				}
				
			} else {
				
				$data->error = 'Wrong username or password.';
				
				
				$this->load->view('user/login', $data);
				
				
			}
			
		}
		
	}
	
	public function changePassword(){
		if(empty($this->session->userdata('user_id'))){
			redirect('/');
		}
		
		$this->breadcrumbs->push('Dashboard', '/dashboard');
		$this->breadcrumbs->push('Change Password', '/changePassword');
		$data['page_heading'] = "Change Password";
		$data['success'] = $this->session->success;
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		$this->form_validation->set_rules('new_pass', 'New Password', 'required');
		$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required');
		
		if ($this->form_validation->run() == false) {			
			$this->load->view('common/header');
			$this->load->view('user/change_password', $data);
			$this->load->view('common/footer');		
		} else {
			$this->user_model->changePassword($this->input->post());
			$_SESSION['success']      = "Success: You have Change Password";
			redirect('/changePassword');
		}
		unset($_SESSION['success']);
	}
	
	public function logout() {
		
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			redirect('/');
						
		} 
	}
	
}
