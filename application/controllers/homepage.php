<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends MY_Controller { 
	function __construct(){ parent::__construct(); }


	public function index(){ 
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(2) == 'homepage'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('homepage','our-services',$uri);
			redirect($new_uri, 'location', 301);
		}
		$this->wrapped_view('homepage');
	}

	public function holidays(){ 
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		/*if($this->uri->segment(3) == 'holidays'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('homepage/holidays','we-plan-holidays-for-you',$uri);
			redirect($new_uri, 'location', 301);
		}

		$this->wrapped_view('holidays');*/

		// Temporary redirect - 302
		redirect(base_url(), 'location', 302);
	}

	// for historical reasons when it was homepage/rentals
	public function rentals(){ 
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(3) == 'rentals'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('homepage/rentals','best-rental-deals-in-hvar',$uri);
			redirect($new_uri, 'location', 301);
		}
	}
	// for historical reasons when it was homepage/excursions
	public function excursions(){ 
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(3) == 'excursions'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('homepage/excursions','perfect-holidays-in-hvar',$uri);
			redirect($new_uri, 'location', 301);
		}
	}

	public function transfers(){ 
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(3) == 'transfers'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('homepage/transfers','taxi-and-speedboat-transfers',$uri);
			redirect($new_uri, 'location', 301);
		}

		$this->load->model('Transfers_model', 'transfers'); // model will be available in the view
		$this->wrapped_view('transfers');
	}

	public function ajax_contact_form_submit(){
		if(!empty($_POST)){
			//$this->load->helper(array('form', 'url'));




			$this->load->library('form_validation');

			//$this->form_validation->set_rules('fld_name', 'Name', 'trim|required|max_length[60]|xss_clean');
			$this->form_validation->set_rules('fld_email', 'Email', 'trim|required|valid_email|max_length[60]|xss_clean');
			$this->form_validation->set_rules('fld_phone', 'Phone', 'trim|max_length[60]|xss_clean');
			$this->form_validation->set_rules('fld_subject', 'Subject', 'trim|max_length[60]|xss_clean');
			$this->form_validation->set_rules('fld_message', 'Message', 'trim|required|max_length[6000]|xss_clean');
			
			// reCaptcha
			// TODO - Lang string
			$this->form_validation->set_rules('g-recaptcha-response', 'Spam protection (I\'m not a robot)', 'required|callback_ishuman');

			if ($this->form_validation->run() == FALSE)
			{
				// TODO - Lang string
				show_error('The following error(s) have occured:<br>'. validation_errors('<div class="he-contact-form__server-error">', '</div>'), 400);			
			}
			else
			{
				$dates = $this->input->post('fld_date');
				//$name = $this->input->post('fld_name');
				$email = $this->input->post('fld_email');
				$subject = $this->input->post('fld_subject');
				$phone = $this->input->post('fld_phone');

				$message = 
'Online Form at HvarExcursions.com
'.'==============================
'.'Contact: '. $phone .'
'.'Email: '. $email .'
'.'Date: '. $dates .'
'.'==============================
'.'Subject: '. $subject .'
'.'---
'. $this->input->post('fld_message');

				//echo $message;
				// TODO - Lang string
				if($this->_send_email($email, '', $subject, $message))$this->output->set_output('OK');
				else show_error('Server error: The message could not be sent.', 400);
				//else show_error($this->email->print_debugger(), 400);
			}
			
			
		}
		// TODO - Lang string
		else show_error('Server error: Wrong parameters.', 400);

			
	}

	private function _send_email($from, $name, $subject, $message){
		/* OLD (up to 11.2021., working with Linode + SSL ZOHO)
		// Hint: Na ZOHO uključiti IMAP access i po želji "Save Sent Mail Copy". https://www.zoho.com/mail/help/zoho-smtp.html
		$config['useragent']        = 'CodeIgniter';        
		$config['mailpath']         = '/usr/sbin/sendmail';
		$config['protocol']         = 'smtp'; 
		$config['smtp_auth']        = TRUE;
		//$config['smtp_host']        = "localhost";
		//$config['smtp_port']        = "25"; // this without "" was showing error on linode, but was working fine on zoho
		$config['smtp_host']		= 'ssl://smtp.zoho.com'; // zoho cannot change 'from' field - 553 Relaying disallowed if you use different 'from' address than it should be      
		$config['smtp_user']        = 'no-reply@hvarexcursions.com'; // Make sure it's not the ZOHO Admin account!
		$config['smtp_pass']        = '*54&*7f2&3j|g+H';
		$config['smtp_port']        = 465;
		//$config['smtp_crypto']      = 'ssl'; // alternatively add the prefix to smtp_host (but not both)
		$config['crlf']             = "\r\n";
		$config['newline']          = "\r\n";

		$this->load->library('email');
		$this->email->initialize($config);

		$this->email->from('no-reply@hvarexcursions.com', 'HvarExcursions.com');
		$this->email->to('info@hvarexcursions.com'); 
		//$this->email->cc('hrvojegolcic@gmail.com'); // testiranje
		$this->email->reply_to($from);

		$this->email->subject('Online inquiry // '.$subject);
		$this->email->message($message);	

		if ($this->email->send()) return TRUE;
		else return FALSE;
		
		//$this->email->send();
		//echo $this->email->print_debugger();
		*/



		/* PHP METHOD (test)
		// From: https://www.php.net/manual/en/function.mail.php
		// This works on Hostens but ZOHO will refuse to receive emails sent like that
		$to      = 'hrvojegolcic@gmail.com';
		$subject = 'Online inquiry // '.$subject;
		$message = $message;
		$headers = array(
			'From' => 'no-reply@hvarexcursions.com',
			'Reply-To' => 'info@hvarexcursions.com',
			'X-Mailer' => 'PHP/' . phpversion()
		);

		if (mail($to, $subject, $message, $headers)) return TRUE;
		else return FALSE;
		*/



		// NEW (from 11.2021.)
		// Hostens: Not possible to use 'ssl://smtp.zoho.com:465', hence 'localhost' is used
		// But therefore ZOHO won't authenticate the sender, and even reject the email when sent to ZOHO (if same 'from' and 'to' domains - Was OK if e.g. 'from' was 'no-reply@uxcessible.com')
		// Rejection of the email was solved by adding Hostens IP as `v=spf1 include:zoho.com ip4:62.77.153.100 ~all` (DKIM is irrelevant...)
		// Obviously "Save Sent Mail Copy" in ZOHO will not work when sent from 'localhost' (not sent from ZOHO)
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'localhost';
		
		$this->load->library('email');
		$this->email->initialize($config);

		$this->email->from('no-reply@hvarexcursions.com', 'HvarExcursions.com');
		$this->email->to('info@hvarexcursions.com'); 
		$this->email->reply_to($from);

		$this->email->subject('Online inquiry // '.$subject);
		$this->email->message($message);	

		if ($this->email->send()) return TRUE;
		else return FALSE;
	}


	public function ishuman($response)
	{
		// TODO - Lang string
		$this->form_validation->set_message('ishuman', "The %s field could not properly validate.");

		// Register API keys at https://www.google.com/recaptcha/admin
		$siteKey = "xxx";
		$secret = "xxx";

		// check reCaptcha
		require_once(APPPATH."controllers/reCaptcha/recaptchalib.php");
		

		$reCaptcha = new ReCaptcha($secret);

		// Was there a reCAPTCHA response?
		if ($_POST["g-recaptcha-response"]) $resp = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);

		// Validate
		if ($resp != null && $resp->success) return TRUE;
		else return FALSE;

		
	}



}

  /*/ 
 /*/