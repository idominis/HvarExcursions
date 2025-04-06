<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* =================================================================================================
	MY_Controller.php (APPPATH . 'core/MY_Controller.php)
	Author:		hrvojegolcic@gmail.com
	Date:		11.05.2014 [16.11.2013]
	------------------------------------------------------------------------------------------------
	- classes extending MY_Controller can override $config settings in their constructor. 
	- those classes needs to have parent::__construct(); as a first constructor line, otherwise $config doesnt work
	- global logic, constants, restrictions, privileges ect... should be found in logic_model.php or 
	  for smaller project it can be found here in define() and the rest in $this->config (define cannot be overriden)
	- svaka wrapped stranica ima svoj jedinstveni $requested_uri - path preko kojeg se učitava konfiguracija
	- improvements, maybe better to use include() instead of $this->load->view() ? faster but requires $output class
	------------------------------------------------------------------------------------------------
	
==================================================================================================== */

define('LOGIN_VIEW_PATH', '_global/login');  // admin dir prefix will be added in controller
define('TMP_DIR', ini_get('upload_tmp_dir')? ini_get('upload_tmp_dir').'/' : '/tmp/');
define('CACHE_TIME', 10000000);

define('GLOBAL_DIR', '_global/');
define('GLOBAL_LANG_FILE', GLOBAL_DIR.'default');


class MY_Controller extends CI_Controller {
	// global variables
	// ====================================================
	// ...

	public function __construct($REQUIRE_LOGIN=NULL){ 

		// 01. load codeigniter base, config, etc...
		// ====================================================
		parent::__construct(); 

		// 02. login required - override defaults
		// ====================================================
		// $REQUIRE_LOGIN can override global settings from config.php here. However it can also be overridden later by calling '$this->authenticate()' on top of $method function in the child controller
		if(isset($REQUIRE_LOGIN)) $this->config->set_item('global_login_required', $REQUIRE_LOGIN);

		// 03. break the execution if login is required and user is not logged in
		// ====================================================
		// There are four solutions to achieve this: 1. this one, set the output and call exit(); 2. set some variable that will be indicate whether to load view or not; 3. redirect() from here; 4. usage of _remap() method to intercept execution and make the right action
		if($this->config->item('global_login_required') === TRUE) $this->authenticate();  

		// 04. no matter it is called again wrapped_view(), not always we call this method
		// ====================================================
		// You can also set_profiler_sections(), / ! \ beware the caching might modify the result
		$this->output->enable_profiler($this->config->item('global_profiler_enabled')); 
		
		// load global models here (application logic, user permissions...), also use autoload.php
		// ====================================================
		// ...
	}



	// ----------------------------------------------------------------------------------------
	// VIEW LOADER METHODS
	
	/*
	 * loads doctype, <head>, css, main menu, footer (conf.),...and inserts requested view within
	 * $site_path is path of requested site local _view and overrides (specific css, js, lang, meta ...) 
	 * / ! \ make sure to disable cache for dynamic pages
	 * cache can be disabled right before this method is called overriding $config variable
	 *
	 * All the overrides from include/ should be found in site_path
	 *
	 */
	protected function wrapped_view($view_name, $data=NULL) 
	{
		// 01. figure out site paths (requested site, header, footer, css, languages,...)
		// ====================================================
		$layout_dir = config_item('global_layout_dir');
		$site_path = $layout_dir.$view_name; // this path will be used for lookup of language, css, js...
		$this->config->set_item('site_path', $site_path);

		// ovo testiraj
		// 02. activate caching and benchmark, make sure application/cache folder is writable.
		// ====================================================
		// use URL: '/tools/clear_cache' to clear the cache
		if(config_item('global_cache_enabled')) $this->output->cache(CACHE_TIME); 
		$this->output->enable_profiler(config_item('global_profiler_enabled'));

		// 03. load default global language (for menus, header, footer...), override it by specific one
		// ====================================================
		$this->lang->load($layout_dir.GLOBAL_LANG_FILE);
		$lookup_lang = APPPATH . 'language/english/'.$site_path.'_lang.php'; // en is default
		if(file_exists($lookup_lang)) $this->lang->load($site_path); // override

		// 04. render global layout
		// ====================================================
		// beware that this files will also load with login view, so hide non-public information
		$this->load->view($layout_dir.GLOBAL_DIR.'header_view.php'); // main layout
		$this->load->view($site_path.'_view',  $data); 
		$this->load->view($layout_dir.GLOBAL_DIR.'footer_view.php');
	}


	

	/*
	 * AUTHENTICATE
	 * if user is not logged in, it breaks the execution and displays login form
	 * since cookies are encrypted, it is OK to hold user data within cookie, so far...
	 * (!) make sure $config['sess_encrypt_cookie'] = TRUE; in config.php
	 *
	 */
	public function authenticate()
	{	
		$this->load->library('Authentication');
		
		// pass session and/or $_POST data to validate and log in the user
		$message = $this->authentication->validate_login();
		if($message !== TRUE)
		{
			$this->load->helper('form');						
			$this->wrapped_view(LOGIN_VIEW_PATH, $message);
			// break the execution - login form should be already displayed
	    	// this way, the URL will remain the same, so after login, user will reach desired page
	    	echo $this->output->get_output();
	    	exit;
		}
		else return TRUE;
	}

	/*
	 * _REMAP
	 * this is used instead of calling $this->authenticate() in top of every function
	 * this could not have been in costructor because there you cannot stop script by calling return;
	 *
	public function _remap($method, $params = array())
	{
	    if (method_exists($this, $method)){

	    	if($this->_auth_isRequired)	// authenticate
	    	{
	    		$this->_USERDATA = $this->authenticate();
	    		if(!$this->_USERDATA) return FALSE; 					// stop script
	    	} 	
	        return call_user_func_array(array($this, $method), $params);// continue executing
	    }
	    show_404();														// method does not exists
	}
	*/
	

	
	
}

 /*/
/*/