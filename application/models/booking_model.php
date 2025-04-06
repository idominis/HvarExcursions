<?php

// NOTE: This is for Vis+Caves booking
class Booking_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Configuration
     * Use $this->model_name->config('DEFAULT_OPTION') instead of ModelName_model::DEFAULT_OPTION
     */
    public function config($itemKey)
    {
        return self::CONFIG[$itemKey];
    }
    private const CONFIG = array(
        
    );
    

    /**
     * Rates
     */
	private const RATES = array(
		'paxOptions' => array(
			//array('pax_up_to' => 1,		'price' => 80,		'paxString' => '1'),
			array('pax_up_to' => 2,		'price' => 159,		'paxString' => '2'),
			array('pax_up_to' => 3,		'price' => 239,		'paxString' => '3'),
			array('pax_up_to' => 4,		'price' => 311,		'paxString' => '4'),
			array('pax_up_to' => 5,		'price' => 389,		'paxString' => '5'),
			array('pax_up_to' => 6,		'price' => 455,		'paxString' => '6'),
			// Dalje možemo praviti private excursion...
			array('pax_up_to' => 8,		'price' => 480,		'paxString' => '7-8'),
			array('pax_up_to' => 12,	'price' => 610,		'paxString' => '9-12'),
			array('pax_up_to' => 20,	'price' => 1000,	'paxString' => '13-20'),
			array('pax_up_to' => 30,	'price' => 1450,	'paxString' => '21-30'),
			array('pax_up_to' => 40,	'price' => 1940,	'paxString' => '31-40'),
			array('pax_up_to' => 50,	'price' => 2400,	'paxString' => '41-50'),
			array('pax_up_to' => 60,	'price' => 2850,	'paxString' => '51-60'),
			array('pax_up_to' => 70,	'price' => 3200,	'paxString' => '61-70'),
			array('pax_up_to' => 80,	'price' => 3500,	'paxString' => '71-80'),
		),
	);
	
    /**
     * HTML output of pax options as HTML <option> elements
     */
    public function getPaxOptionsHtml($optionText)
    {
        $htmlOutput = '';
        foreach (self::RATES['paxOptions'] as $paxOption) {
			$htmlOutput .= '<option value="' . $paxOption['pax_up_to'] . '" data-price="' . $paxOption['price'] . '">'
				. sprintf($optionText, $paxOption['paxString'])
				. '</option>';
        }

        return $htmlOutput;
    }

    /**
     * HTML output of pick-up dates as HTML <option> elements
     */
    public function getPickUpDateOptionsHtml($optionText)
    {
        $htmlOutput = '';

        $this->load->model('subjects/Pricelist_model', 'pricelist');
        $periodObj = $this->pricelist->getBookableDatePeriod();

        foreach ($periodObj as $dateTimeObj) {
            $htmlOutput .= '<option>'. $dateTimeObj->format($optionText) .'</option>';
        }

        return $htmlOutput;
    }

}