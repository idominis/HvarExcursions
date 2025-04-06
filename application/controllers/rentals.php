<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rentals extends MY_Controller {
	function __construct(){ parent::__construct(); }

	public function index(){
		// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
		if($this->uri->segment(2) == 'rentals'){
			$uri = $this->uri->uri_string();
			$new_uri = str_ireplace('rentals','best-rental-deals-in-hvar',$uri);
			redirect($new_uri, 'location', 301);
		}

		// ne radi obavijest o uspjesnoj uplati
		//if(ENVIRONMENT == 'production') $this->config->set_item('global_cache_enabled', TRUE);

		// Check if there was transaction processed?
		//$data['transaction_callback'] = true;
		$data['transaction_callback'] = $this->_transaction_callback();
		
		$this->load->model('subjects/Subjects_model', 'subjects');
		$data['items'] = array(
			'speedboats' => $this->subjects->getSubjectsData('speedboats'), 
			'yachts' => $this->subjects->getSubjectsData('yachts'), 
			'boats' => $this->subjects->getSubjectsData('boats'),
			'scooters' => $this->subjects->getSubjectsData('scooters'),
			'cars' => $this->subjects->getSubjectsData('cars'),
			// 'bikes' => $this->subjects->getSubjectsData('bikes'), // TODO: Move this to subjects model?
		);

		$data['itemsImages'] = $this->subjects->getSubjectsImages();

		$this->load->model('subjects/Pricelist_model', 'pricelist'); // for footer js
		$this->wrapped_view('rentals', $data);
	}


	/* =======================================================================
		AJAX
	======================================================================= */
	public function ajax_get_range_rates()
	{
		/*
		EXAMPLE
			'boat' => array (
				5 => array (1),
				6 => array (2,3,4,7,8),
				7 => array (30),
				8 => array (30,31),
				9 => array (),
				10 => array (2),
			),
		*/
		$availabilityExport = file_get_contents(APPPATH . 'models/data_availability_import.json');
		$unavailable_dates = json_decode($availabilityExport, true);
		// TODO: Idea: Limit availability by the year, so that the old dates do not block the new season year

		if ($this->input->is_ajax_request()) {
			$this->load->model('subjects/Pricelist_model', 'pricelist');

			$from_range = $this->input->post('fromDate', true);
			$to_range = $this->input->post('toDate', true);

			$from_arr = explode("-", $from_range);
			$from_range_day = (int) $from_arr[2];
			$from_range_month = (int) $from_arr[1];
			$from_range_year = (int) $from_arr[0];

			$to_arr = explode("-", $to_range);
			$to_range_day = (int) $to_arr[2];
			$to_range_month = (int) $to_arr[1];
			$to_range_year = (int) $to_arr[0];

			$seasonYear = $this->pricelist->getConfigItem('SEASON_YEAR');
			$seasonStartDay = $this->pricelist->getConfigItem('SEASON_START_DAY');
			$seasonStartMonth = $this->pricelist->getConfigItem('SEASON_START_MONTH');
			$seasonEndDay = $this->pricelist->getConfigItem('SEASON_END_DAY');
			$seasonEndMonth = $this->pricelist->getConfigItem('SEASON_END_MONTH');

			if (	($from_range_year !== $seasonYear)
				|| 	($to_range_year !== $seasonYear)
				|| 	($from_range_month < $seasonStartMonth)
				|| 	($to_range_month > $seasonEndMonth)
				|| 	($from_range_month > $to_range_month)
				|| 	(($from_range_month === $seasonStartMonth) && ($from_range_day < $seasonStartDay))
				|| 	(($to_range_month === $seasonEndMonth) && ($to_range_day > $seasonEndDay))
				|| 	(($from_range_month === $to_range_month) && ($from_range_day > $to_range_day))
			) show_error('Incorrect Dates');

			$this->load->model('subjects/Subjects_model', 'subjects');
			$available_items = $this->subjects->getBookableSubjects();
			$prices = $this->pricelist->getPricelistByDate();

			// $return value. Initialize price for all items
			$total_prices = array();
			$availability = array();
			$total_days = 0;
			foreach ($available_items as $subjectKey) {
				// Initialize prices and availability
				$total_prices[$subjectKey] = 0;
				$availability[$subjectKey] = true;
			}

			for($month_index = $from_range_month; $month_index <= $to_range_month; $month_index++){
				$day_index = 0; // $day_index++ will be 01. of the month

				// Start this month from day=1 or from $from_range_day?
				if($month_index === $from_range_month) $day_index = $from_range_day -1; // -1 because of $day_index++

				// loop through all days of the month
				while(isset($prices[$month_index][++$day_index])){

					// add to the price for each item
					foreach ($total_prices as $key => $value) {
						if (empty($prices[$month_index][$day_index][$key])) {
							continue;
						}
						$total_prices[$key] += ceil($prices[$month_index][$day_index][$key] / (1 - $this->pricelist->getConfigItem('PRICE_INCREASE_PERCENTAGE'))); // each price will be raised a little so we can later give discount !

						// Is the boat available?
						if (!empty($unavailable_dates[$key][$month_index]) && in_array($day_index, $unavailable_dates[$key][$month_index])) {
							$availability[$key] = false;
						}
					}
					$total_days++;

					// Iterate days of this month until the end or to $to_range_day?
					if(($month_index === $to_range_month) && ($day_index === $to_range_day)) break;
				}

			}

			// determine additional discount if applicable (Ask Filip if needed even more!)
			$discount_back_to_original = $this->pricelist->getConfigItem('PRICE_INCREASE_PERCENTAGE');
			$discounts = array(
				// days => %
				1 => $discount_back_to_original,
				2 => $discount_back_to_original,
				3 => $discount_back_to_original + 0.01,
				7 => $discount_back_to_original + 0.02,
				10 => $discount_back_to_original + 0.03,
				14 => $discount_back_to_original + 0.035,
				21 => $discount_back_to_original + 0.045,
				28 => $discount_back_to_original + 0.05,
				45 => $discount_back_to_original + 0.06,
			);

			$additional_discount = 0;
			foreach ($discounts as $days => $percentage) {
				if($total_days < $days) break;
				$additional_discount = $percentage;
			}

			// get standard rounded prices and discounted as well
			foreach ($total_prices as $key => $value) {
				$total_prices[$key] = array(
					round($value), // round the rates to nearest integer
					round($value * (1 - $additional_discount)) // calculate and round discounted rates
				);
			}

			$response = array(
				'total_days' => $total_days,
				'period' => $arrayName = array('from' => $from_range, 'to' => $to_range),
				'additional_discount' => round($additional_discount*100),
				'rates' => $total_prices,
				'availability' => $availability
			);

			//header('Content-Type: application/json');
			//echo json_encode($response);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		}
	}

	/* =======================================================================
		PRIVATE FUNCTIONS
	======================================================================= */
	private function _transaction_callback() { // Check if there was payment previously processed?
		// Make sure to modify these settings in the profile:
		//	- Profile -> My selling tools -> Payment Receiving Preferences
		//	- Profile -> My selling tools -> Website preferences
		//	- Profile -> My selling tools -> Instant payment notifications

		if($this->input->get('tx')) { // transaction id
			// Transaction completed

			/*
				// TO-DO: Now you need to check the token with Paypal to verify the data
				["tx"]=> string(17) "83627303M1327021K"
				["st"]=> string(7) "Pending"
				["amt"]=> string(5) "10.00"
				["cc"]=> string(3) "EUR"
				["cm"]=> string(0) ""
				["item_number"]=> string(0) ""
			*/

			$payment_status = $this->input->get('st');
			if(strcmp($payment_status, "Pending") == 0 || strcmp($payment_status, "Completed") == 0) {
				// Transaction successful

				// TO-DO: posalji email kupcu? Ili to na verify? Ili ne uopce jer ce imati poruku na vrhu stranice?
				return true;
			}
			else {
				// Transaction not successful
				return false;
			}
		}
		else return null;
	}	
}

  /*/
 /*/
