<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excursions extends MY_Controller { 
	function __construct(){ parent::__construct(); }


	public function index(){ 
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(2) == 'excursions'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('excursions','perfect-holidays-in-hvar',$uri);
			redirect($new_uri, 'location', 301);
		}
		$this->wrapped_view('excursions');
	}

	public function tour_vis(){
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(2) == 'excursions'  && $this->uri->segment(3) == 'tour_vis'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('/tour_vis','/hvar-vis-tour-green-cave-blue-cave',$uri);
			redirect($new_uri, 'location', 301);
		}

		$this->load->model('Booking_model', 'booking'); // model will be available in the view
		$this->wrapped_view('tour_vis');
	}
}

  /*/ 
 /*/