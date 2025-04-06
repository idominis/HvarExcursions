<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	11.05.2014. hrvojegolcic@gmail.com
	usage example:
	$params = array('type' => 'large', 'color' => 'red');
	$this->load->library('Authentication', $params);
	$this->authentication->some_function();  // Object instances will always be lower case

*/

class Authentication {

    public function __construct(/*$params*/)
    {
        // Do something with $params

        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    /**
	 * AUTHENTICATE
	 * if user is logged in, it returns TRUE, else it check $_POST parameters for login data and redirects page if data is valid
	 * if user is not logged, or not logged in successfuly it returns error message
	 * since cookies are encrypted, it is OK to hold user data within cookie, so far...
	 * (!) make sure $config['sess_encrypt_cookie'] = TRUE; in config.php
	 *
	 */
	public function validate_login()
	{	
		$user_data = $this->CI->session->all_userdata();		// load user data from cookie

		if(!isset($user_data['USR_ID']))						// if user is NOT logged in:
		{
			$data = array();	
			if(isset($_POST['usr'])) $data['log'] = $this->validate_login_data();	// check $_POST data, login and redirect
			

			return $data;										// display no views further
		}
		
		//$this->CI->config->set_item('username', $user_data['USR_Username']); // used for public views, model etc.
		return TRUE;										// user logged, continue rendering view
	}


	/**
	 * VALIDATE LOGIN
	 * validates if user exists and loads its user data into session cookie
	 *
	 */
	private function validate_login_data()
	{

		// set header to HTTP 401 (Not Authorized) header ??
		// maybe to use ocdeigniter form library?

		// consider $this->db->escape() or mysqli_real_escape_string() as well		
		$username =  htmlspecialchars($this->CI->input->post('usr', TRUE));		// XSS Cleaning and escaping
		$password =  htmlspecialchars(sha1($this->CI->input->post('pwd', TRUE)));	// XSS Cleaning	
		//log_message('info', 'USER_AUTH_ATTEMPT: Data received, usr='.$username);
		
		// load data from database and check if username and password matches?		
		// $this->load->model('users_model', 'users', TRUE);
		// if($userdata = &$this->users->get_user_data($username, $password))
		if($username == 'test' && $password == 'b444ac06613fc8d63795be9ad0beaf55011936ac') // test1
		{	// to grant access, put here TRUE

			//log_message('info', 'USER_AUTH_SUCCESSFUL: User '.$username.' logged in.');

			// set user session cookies
			$this->CI->session->set_userdata('USR_ID', $username);
			//$this->CI->session->set_userdata('USR_ID', $userdata['USR_ID']);
			//$this->CI->session->set_userdata('USR_Username', $userdata['USR_Username']);
			//$this->CI->session->set_userdata('USR_Role', $userdata['USR_Role']);
			//$this->CI->session->set_userdata('LNG_Restriction', $userdata['LNG_Restriction']);

			// it's obvious Google robot will never enter here
			redirect(uri_string()); // rewrite $_POST data due to following views
			exit('This should never occur');
		}
		
		// incorrect $_POST data, user NOT authenticated
		//log_message('info', 'USER_AUTH_FAILED: User '.$username.' not authenticated.');
		return 'login_failed'; // this is a key for language file
	}

	/*
	 * USER LOGOUT
	 * deauthenticates the user from this computer, I've also made a faster controller, check it out! 
	 * activate this function only for homepage
	 * also good idea is to make logout controller
	 *
	 */
	public function logout($redirect=NULL) // call as parent::logout();
	{		
		$this->CI->session->sess_destroy();
		//if(!isset($redirect)) $redirect = site_url();
		if(!isset($redirect)) $redirect = site_url('/'); // including language from URL
		redirect($redirect);
	}
}

?>