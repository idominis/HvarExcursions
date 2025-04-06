<?php

class Transfers_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Configuration
     * Use $this->transfers->config('DEFAULT_OPTION') instead of Transfers_model::DEFAULT_OPTION
     */
    public function config($itemKey)
    {
        return self::CONFIG[$itemKey];
    }
    private const CONFIG = array(
        'DEFAULT_OPTION' => 'Hvar Town (Any location)',
        'DEFAULT_SECONDARY_OPTION' => 'Airport Split (Divulje)',
        'PAX_OPTIONS' => array(2, 3, 4, 5, 6, 8, 10, 12, 14, 16, 18, 24, 32, 40, 48, 56),
        'OFFTIME_MIN_AM' => 6,   // from 06:00h
        'OFFTIME_MAX_AM' => 8,   // up to 08:59h
        'OFFTIME_MIN_PM' => 18,  // from 18:00h
        'OFFTIME_MAX_PM' => 20,  // up to 20:59h
    );
    
    /**
     * Javascript hooks
     */
    private const JS_CONFIG = array(
        'DEFAULT_PRICE_GROUP_KEY' => self::PRICE_GROUP['PRICE_GROUP_0'],
        'OPTION_INDICATOR_DEFAULT' => 'data-js-option-default',
        'OPTION_INDICATOR_OFFTIME' => 'data-js-option-modifier-offtime',
        'OPTION_INDICATOR_NIGHT' => 'data-js-option-modifier-night',
    );
    
    /**
     * Transfer price groups
     */
    private const PRICE_GROUP = array( // PHP key value => JS key value
        'PRICE_GROUP_0' => 'price_group_0',
        'PRICE_GROUP_1' => 'price_group_1',
        'PRICE_GROUP_2' => 'price_group_2',
        'PRICE_GROUP_3' => 'price_group_3',
        'PRICE_GROUP_4' => 'price_group_4',
        'PRICE_GROUP_5' => 'price_group_5',
        'PRICE_GROUP_6' => 'price_group_6',
    );

    /**
     * Transfer destinations organized into price groups
     */
    private const DESTINATIONS = array(
		self::PRICE_GROUP['PRICE_GROUP_0'] => array(
			self::CONFIG['DEFAULT_OPTION'], // Hvar Town (Any location)
			'Falco beach bar',
			'Hula Hula beach bar',
			'Hvar Town (Gas station)',
			'Hvar Town Harbor',
			'Hotel Amfora (Hvar Town)',
		),
		self::PRICE_GROUP['PRICE_GROUP_1'] => array(
			'Carpe Diem Beach (Pakleni Islands)',
			'Hvar Marine (St. Kement, Pakleni Islands)',
			'Mlini Beach (Pakleni Islands)',
			'Jerolim (Pakleni Islands)',
			'Palmizana (Pakleni Islands)',
			'Pakleni Islands',
			'Vela Garška',
			'Ždrilca (Pakleni Islands)',
		),
		self::PRICE_GROUP['PRICE_GROUP_2'] => array(
			'Milna (Hvar Island)',
		),
		self::PRICE_GROUP['PRICE_GROUP_3'] => array(
			'Milna (Brač Island)',
			'Vis Town (Vis Island)',
			'Šćedro Island',
			'Stari Grad (Hvar Island)',
		),
		self::PRICE_GROUP['PRICE_GROUP_4'] => array(
			'Bol (Brač Island)',
			'Split Harbor',
			'Split Airport (Divulje)',
			'Split Area',
			self::CONFIG['DEFAULT_SECONDARY_OPTION'],  // Airport Split (Divulje)
			'Komiža (Vis Island)',
			'Trogir',
			'Vela Luka (Korčula Island)',
		),
		self::PRICE_GROUP['PRICE_GROUP_5'] => array(
			'Korčula (Korčula Island)',
			'Makarska',
			'Primošten',
		),
		self::PRICE_GROUP['PRICE_GROUP_6'] => array(
			'Dubrovnik',
			'Tisno',
			'Zadar',
		),
	);

    /**
     * Transfer rates organized into price groups
     */
	private const TRANSFER_RATES = array(
		self::PRICE_GROUP['PRICE_GROUP_0'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0.5,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 4,		'price' => 40),
				array('pax_up_to' => 5,		'price' => 50),
				array('pax_up_to' => 6,		'price' => 60),
				array('pax_up_to' => 8,		'price' => 80),
				array('pax_up_to' => 10,	'price' => 100),
				array('pax_up_to' => 12,	'price' => 120),
				array('pax_up_to' => 20,	'price' => 190),
				array('pax_up_to' => 30,	'price' => 280),
				array('pax_up_to' => 40,	'price' => 370),
				array('pax_up_to' => 50,	'price' => 460),
				array('pax_up_to' => 60,	'price' => 550),
			),
		),
		self::PRICE_GROUP['PRICE_GROUP_1'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0.5,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 5,		'price' => 70),
				array('pax_up_to' => 6,		'price' => 84),
				array('pax_up_to' => 8,		'price' => 112),
				array('pax_up_to' => 10,	'price' => 140),
				array('pax_up_to' => 12,	'price' => 168),
				array('pax_up_to' => 20,	'price' => 266),
				array('pax_up_to' => 30,	'price' => 392),
				array('pax_up_to' => 40,	'price' => 518),
				array('pax_up_to' => 50,	'price' => 644),
				array('pax_up_to' => 60,	'price' => 770),
			),
		),
		self::PRICE_GROUP['PRICE_GROUP_2'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0.5,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 4,		'price' => 80),
				array('pax_up_to' => 5,		'price' => 100),
				array('pax_up_to' => 6,		'price' => 120),
				array('pax_up_to' => 8,		'price' => 160),
				array('pax_up_to' => 10,	'price' => 200),
				array('pax_up_to' => 12,	'price' => 240),
				array('pax_up_to' => 20,	'price' => 380),
				array('pax_up_to' => 30,	'price' => 560),
				array('pax_up_to' => 40,	'price' => 740),
				array('pax_up_to' => 50,	'price' => 920),
				array('pax_up_to' => 60,	'price' => 1100),
			),
		),
		self::PRICE_GROUP['PRICE_GROUP_3'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0.3,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 4,		'price' => 240),
				array('pax_up_to' => 5,		'price' => 265),
				array('pax_up_to' => 6,		'price' => 270),
				array('pax_up_to' => 8,		'price' => 290),
				array('pax_up_to' => 10,	'price' => 300),
				array('pax_up_to' => 12,	'price' => 320),
				array('pax_up_to' => 20,	'price' => 585),
				array('pax_up_to' => 30,	'price' => 870),
				array('pax_up_to' => 40,	'price' => 1155),
				array('pax_up_to' => 50,	'price' => 1440),
				array('pax_up_to' => 60,	'price' => 1725),
			),
		),
		self::PRICE_GROUP['PRICE_GROUP_4'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0.3,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 6,		'price' => 450),
				array('pax_up_to' => 8,		'price' => 500),
				array('pax_up_to' => 10,	'price' => 520),
				array('pax_up_to' => 12,	'price' => 550),
				array('pax_up_to' => 20,	'price' => 1100),
				array('pax_up_to' => 30,	'price' => 1500),
				array('pax_up_to' => 40,	'price' => 2000),
				array('pax_up_to' => 50,	'price' => 2500),
				array('pax_up_to' => 60,	'price' => 3000),
			),
		),
		self::PRICE_GROUP['PRICE_GROUP_5'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 6,		'price' => 500),
				array('pax_up_to' => 8,		'price' => 600),
				array('pax_up_to' => 10,	'price' => 700),
				array('pax_up_to' => 12,	'price' => 800),
				array('pax_up_to' => 20,	'price' => 1351),
				array('pax_up_to' => 30,	'price' => 2002),
				array('pax_up_to' => 40,	'price' => 2653),
				array('pax_up_to' => 50,	'price' => 3304),
				array('pax_up_to' => 60,	'price' => 3955),
			),
		),
		self::PRICE_GROUP['PRICE_GROUP_6'] => array(
			'modifiers' => array(
				'night_fee_perc' => 0,
				'offtime_discount_perc' => 0,
			),
			'pax_rates' => array(
				array('pax_up_to' => 6,		'price' => 1250),
				array('pax_up_to' => 8,		'price' => 1350),
				array('pax_up_to' => 10,	'price' => 1500),
				array('pax_up_to' => 12,	'price' => 1700),
				array('pax_up_to' => 20,	'price' => 3000),
				array('pax_up_to' => 30,	'price' => 4000),
				array('pax_up_to' => 40,	'price' => 5000),
				array('pax_up_to' => 50,	'price' => 6000),
				array('pax_up_to' => 60,	'price' => 7000),
			),
		),
    );

    /**
     * Transfer destinations sorted by alphabet
     */
    private $_sortedDestinations;
    private function _getSortedDestinations() {
        if (empty($this->_sortedDestinations)) {
            $this->_setSortedDestinations();
        }
        return $this->_sortedDestinations;
    }
    private function _setSortedDestinations() {
        $sortedDestinations = array();
        foreach (self::DESTINATIONS as $pricegroup => $destinationList) {
            foreach ($destinationList as $destination) {
                $sortedDestinations[$destination] = $pricegroup;
            }
        }
        ksort($sortedDestinations);
        $this->_sortedDestinations = $sortedDestinations;
    }

    /**
     * HTML output of transfer destinations as HTML <option> elements
     */
    public function getDestinationOptionsHtml($selectedOption = self::CONFIG['DEFAULT_OPTION'])
    {
        $htmlOutput = '';
        
        foreach ($this->_getSortedDestinations() as $destination => $pricegroup) {
            $selected = '';
            if ($destination === $selectedOption) {
                $selected = 'selected';
            }
            $default = '';
            if ($destination === self::CONFIG['DEFAULT_OPTION']) {
                $default = self::JS_CONFIG['OPTION_INDICATOR_DEFAULT']; // Must be Hvar always
            }

            $htmlOutput .= '<option ' . $selected . ' ' . $default . ' value="' . $pricegroup . '">' . $destination . '</option>';
        }

        return $htmlOutput;
    }

    /**
     * HTML output of pax options as HTML <option> elements
     */
    public function getPaxOptionsHtml($optionText)
    {
        $htmlOutput = '';
        
        foreach (self::CONFIG['PAX_OPTIONS'] as $paxCount) {
            $htmlOutput .= '<option value="' . $paxCount . '">' . sprintf($optionText, $paxCount) . '</option>';
        }

        return $htmlOutput;
    }

    /**
     * HTML output of pick-up times as HTML <option> elements
     */
    public function getPickUpTimeOptionsHtml($optionText)
    {
        $htmlOutput = '';

        $defaultHour = 8;
        $defaultMin = 30; // must be within $minutesStep

        $minOfftimeAm = self::CONFIG['OFFTIME_MIN_AM'];
        $maxOfftimeAm = self::CONFIG['OFFTIME_MAX_AM'];
        $minOfftimePm = self::CONFIG['OFFTIME_MIN_PM'];
        $maxOfftimePm = self::CONFIG['OFFTIME_MAX_PM'];
        $minNightPm = $maxOfftimePm + 1;
        $maxNightAm = $minOfftimeAm - 1;

        for ($hour = 0; $hour < 24; $hour++) {
            // Price modifier (offtime, night)
            $jsModifierValue = '';
            if (($hour >= $minOfftimeAm && $hour <= $maxOfftimeAm) || ($hour >= $minOfftimePm && $hour <= $maxOfftimePm)) {
                $jsModifierValue = self::JS_CONFIG['OPTION_INDICATOR_OFFTIME'];
            } else if ($hour <= $maxNightAm || $hour >= $minNightPm) {
                $jsModifierValue = self::JS_CONFIG['OPTION_INDICATOR_NIGHT'];
            }
            
            // Generate the time options
            $minutesStep = 15;
            for ($minute = 0; $minute < 60; $minute = $minute + $minutesStep) {
                // US Time
                $timeAddon = 'am';
                $hourUS = $hour;
                if ($hour >= 12) {
                    $timeAddon = 'pm';
                    $hourUS = ($hour === 12)? 12 : $hour - 12;
                }

                // Pre-selected option
                $selected = '';
                if ($hour === $defaultHour && $minute === $defaultMin) {
                    $selected = 'selected';
                }

                $htmlOutput .= '<option ' . $selected . ' value="' . $jsModifierValue . '">'
                    . sprintf($optionText, $hourUS, $minute, $timeAddon, $hour, $minute)
                    . '</option>';
            }

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

    /**
     * HTML output of transfer rates as JSON
     */
    public function getTransferRatesJson()
    {
        return htmlentities(json_encode(self::TRANSFER_RATES));
    }

    /**
     * HTML output of js config as JSON
     */
    public function getJsTransfersConfigJson()
    {
        return htmlentities(json_encode(self::JS_CONFIG));
    }

}