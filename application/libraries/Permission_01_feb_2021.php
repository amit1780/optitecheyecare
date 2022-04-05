<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permission {

    // init vars
    var $CI;                        // CI instance
    var $where = array();
    var $set = array();
    var $required = array();

    function Permission()
    {
        $this->CI = & get_instance();        
        $this->groupID = ($this->CI->session->userdata('group_id')) ? $this->CI->session->userdata('group_id') : 0;		
        $this->groupType = ($this->CI->session->userdata('group_type')) ? $this->CI->session->userdata('group_type') : '';
    }

	function getNotPermission(){
		
		$allRoutes = $this->CI->router->routes;		
		$currentRoute  = $this->getCurrentRoute();
		
		$currentControllerName 	 = $this->CI->router->fetch_class();
		$currentControllerMethod = $this->CI->router->fetch_method();
		
		$admin = array();
		$store = array('bank','editUser','addUser','userList','editBatch');			
		$production = array('bank','editUser','addUser','userList','addStockApprove','stockReject','deleteChallan');		
		#$sales = array('bank','editUser','addUser','userList','product','certificate','addStock','addStockApprove','editBatch');
		$sales = array('bank','editUser','addUser','userList','addProduct','addCategory','editCategory','certificate','addStockApprove','editBatch','deleteChallan');
		
		if($this->groupType == 'STORE'){
			if (in_array($currentControllerName, $store)) {
				redirect('/permission');
				exit;
			}
			
			if (in_array($currentControllerMethod, $store)) {
				redirect('/permission');
				exit;
			}
		}
		if($this->groupType == 'PRODUCTION'){
			if (in_array($currentControllerName, $production)) {
				redirect('/permission');
				exit;
			}
			
			if (in_array($currentControllerMethod, $production)) {
				redirect('/permission');
				exit;
			}
		}if($this->groupType == 'SALES'){
			if (in_array($currentControllerName, $sales)) {
				redirect('/permission');
				exit;
			}
			
			if (in_array($currentControllerMethod, $sales)) {
				redirect('/permission');
				exit;
			}
		}		
		return true;
	}	

	function getCurrentRoute(){
		
		$routes = array_reverse($this->CI->router->routes);
		foreach ($routes as $key => $val) {
			$route = $key; 			
			$key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);			
			if (preg_match('#^'.$key.'$#', $this->CI->uri->uri_string(), $matches)) break;
		}

		if ( ! $route) $route = $routes['default_route'];
		
		return $route;		
	}    
}