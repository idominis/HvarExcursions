<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {
	function __construct(){ 
		// Obviously we don't require login here, logout redirect should always be reachable
		parent::__construct(FALSE);
	}

	public function index()
	{
		$this->load->library('Authentication');
		$this->authentication->logout();
	}
}

  /*/ 
 /*/