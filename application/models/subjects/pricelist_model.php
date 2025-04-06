<?php

class Pricelist_model extends CI_Model {
    function __construct()
    {
        parent::__construct();

        // Init
        $this->load->model('Logger_model', 'logger');
        $this->_setPricelistBySubject();
    }

    const SEASON = [
        'SEASON_YEAR' => 2025, // TODO: Make the year dynamic
        'SEASON_START_DAY' => 1, // make sure to have prices defined for entire specified period
        'SEASON_START_MONTH' => 5,
        'SEASON_END_DAY' => 30,
        'SEASON_END_MONTH' => 10,
        'PRICE_INCREASE_PERCENTAGE' =>  0.1, // online + early bird 5% + 5%
        'BOOKING_ADVANCE_DAYS_OFFSET' => '+2 day', // can be 'now' too
    ];

    function getConfigItem($itemKey) {
        return self::SEASON[$itemKey];
    }

    /**
     * Generates price range string e.g. "From 50€ to 85€ + Fuel".
     * Those are increased prices "without discount" so that user still feels he gets the discount.
     * * Meaning that total price will be even lower then min price in the range. 
     * * This is also good so that min. price is not "too low" making the impression other prices are too high.
     */
    function getPriceRangeString($subjectKey, $isFuelIncluded = false)
    {
        $prices = $this->_getLowAndHighPricesBySubject();
        $increasePriceFactor = (1 / (1 - self::SEASON['PRICE_INCREASE_PERCENTAGE']));

		$fromRangePrice = $prices[$subjectKey]['low']; // original price
		$toRangePrice = $prices[$subjectKey]['high'];
		$increasedFromPrice = ceil($fromRangePrice * $increasePriceFactor); // ceil, as used in a real price calculation as well
		$increasedToPrice = ceil($toRangePrice * $increasePriceFactor);
		$roundedIncreasedFromPrice = round($increasedFromPrice, -1); // ceil, as used in a real price calculation
		$roundedIncreasedToPrice = round($increasedToPrice, -1);

        $this->lang->load('default/rentals');
        $priceRangeFuelSufix = ($isFuelIncluded === true)?
            lang('subject-price-hint-fuel-incl') : lang('subject-price-hint-fuel-extra');
        $priceRangeString = lang(
            'subject-price-hint',
            [$roundedIncreasedFromPrice, $roundedIncreasedToPrice, $priceRangeFuelSufix]
        );

		return $priceRangeString;
    }

    /**
     * Helper - get the number of max days for each month
     */
    private $_maxDaysInMonth = [];
    private function _getMaxDaysInMonth()
    {
        $this->_setMaxDaysInMonth();
        return $this->_maxDaysInMonth;
    }
    private function _setMaxDaysInMonth()
    {
        if (!empty($this->_setMaxDaysInMonth)) {
            return;
        }

        $this->_maxDaysInMonth = [
            1 => cal_days_in_month(CAL_GREGORIAN, 1, self::SEASON['SEASON_YEAR']),
            2 => cal_days_in_month(CAL_GREGORIAN, 2, self::SEASON['SEASON_YEAR']),
            3 => cal_days_in_month(CAL_GREGORIAN, 3, self::SEASON['SEASON_YEAR']),
            4 => cal_days_in_month(CAL_GREGORIAN, 4, self::SEASON['SEASON_YEAR']),
            5 => cal_days_in_month(CAL_GREGORIAN, 5, self::SEASON['SEASON_YEAR']),
            6 => cal_days_in_month(CAL_GREGORIAN, 6, self::SEASON['SEASON_YEAR']),
            7 => cal_days_in_month(CAL_GREGORIAN, 7, self::SEASON['SEASON_YEAR']),
            8 => cal_days_in_month(CAL_GREGORIAN, 8, self::SEASON['SEASON_YEAR']),
            9 => cal_days_in_month(CAL_GREGORIAN, 9, self::SEASON['SEASON_YEAR']),
            10 => cal_days_in_month(CAL_GREGORIAN, 10, self::SEASON['SEASON_YEAR']),
            11 => cal_days_in_month(CAL_GREGORIAN, 11, self::SEASON['SEASON_YEAR']),
            12 => cal_days_in_month(CAL_GREGORIAN, 12, self::SEASON['SEASON_YEAR']),
        ];
    }

    /**
     * Low and high price for each subject
     */
    private $_lowAndHighPricesBySubject = [];
    private function _getLowAndHighPricesBySubject()
    {
        if (empty($this->_lowAndHighPricesBySubject)) {
            $this->_setPricelistByDate();
        }
        return $this->_lowAndHighPricesBySubject;
    }
    
    /**
     * Returns a list of all dates and prices for each subject on given date.
     * Useful to calculate prices for all subjects on a given date range.
     * Also sets low and high prices for each subject in the same loop.
     */
    function getPricelistByDate()
    {
        $this->_setPricelistByDate();
        return $this->_pricelistByDate;
    }

    /**
     * Convert pricelist by subject to pricelist by dates
     */
    private $_pricelistByDate = [];
    private function _setPricelistByDate()
    {
        if (!empty($this->_pricelistByDate)) {
            return;
        }

        $maxDaysInMonth = $this->_getMaxDaysInMonth();
        foreach ($this->_pricelistBySubject as $subjectKey => $datePeriods) {
            $lowestPriceForSubject = -1;
            $highestPriceForSubject = -1;

            foreach ($datePeriods as $datePeriod) {
                $price = $datePeriod['price'];
                $monthFrom = $datePeriod['monthFrom'];
                $monthTo = $datePeriod['monthTo'];
                $dateFrom = $datePeriod['dateFrom'];
                $dateTo = $datePeriod['dateTo'];

                // Only accountable for a single year, not possible to have dates in another year
                // TODO: Check month 1-12
                // TODO: Check monthfrom <= monthto
                // TODO: Check days... (also if days correspond to month)
                for ($month = $monthFrom; $month <= $monthTo; $month++) {
                    $monthDateFrom = 1;
                    if ($month === $monthFrom) {
                        $monthDateFrom = $dateFrom;
                    } 
                    $monthDateTo = $maxDaysInMonth[$month];
                    if ($month === $monthTo) {
                        $monthDateTo = $dateTo;
                    }
                    
                    for ($day = $monthDateFrom; $day <= $monthDateTo; $day++) {
                        $this->_pricelistByDate[$month][$day][$subjectKey] = $price;

                        // Set lowest and highest prices
                        if ($highestPriceForSubject < $price) {
                            $highestPriceForSubject = $price;
                        } elseif (($lowestPriceForSubject > $price) || (-1 === $lowestPriceForSubject)) {
                            $lowestPriceForSubject = $price;
                        } 
                    }
                }

                // TODO: Verify if we have a price for each day from the range
                //$now = time(); // or your date as well
                //$your_date = strtotime("2010-01-31");
                //$datediff = $now - $your_date;
                //echo round($datediff / (60 * 60 * 24));

                // Filter...
                // TODO: Output a warning if some date ranges are missing
                // TODO: Verify the dates (are there missing periods, or extra periods?)

            }

            $this->_lowAndHighPricesBySubject[$subjectKey] = [
                'high' => $highestPriceForSubject,
                'low' => $lowestPriceForSubject,
            ];
        }
    }

    
    /**
     * Returns the period of remaining bookable days in the season beginning from the first possible bookable day
     */
    public function getBookableDatePeriod($interval = '1 day')
    {
        // TODO: Npr. getSeasonYear odmah vraca iducu godinu ako je ova prosla

        $timeZone = new DateTimeZone('Europe/Zagreb');
        $seasonBeginObj = new DateTime('now', $timeZone);
		$seasonBeginObj->setDate(self::SEASON['SEASON_YEAR'], self::SEASON['SEASON_START_MONTH'], self::SEASON['SEASON_START_DAY']);
		$seasonEndObj = new DateTime('now', $timeZone);
        $seasonEndObj->setDate(self::SEASON['SEASON_YEAR'], self::SEASON['SEASON_END_MONTH'], self::SEASON['SEASON_END_DAY']);
        $seasonEndObj->modify('+1 day'); // +1 to include the last day into period
        
        // Begin date will be either the current date (+ offset) or the season starting date
        $beginFromTodayObj = new DateTime(self::SEASON['BOOKING_ADVANCE_DAYS_OFFSET'], $timeZone);
		if ($beginFromTodayObj >= $seasonBeginObj) {
            $seasonBeginObj = $beginFromTodayObj;
        }

        $intervalObj = DateInterval::createFromDateString($interval);
        $periodObj = new DatePeriod($seasonBeginObj, $intervalObj, $seasonEndObj);

        return $periodObj;
    }

    /**
     * Returns the string of the first possible bookable day
     */
    public function getBookableDatePeriodString($stringFormat = 'Y-m-d')
    {
        $periodObj = $this->getBookableDatePeriod();
        $periodStartString = $periodObj->getStartDate()->format($stringFormat);
        $periodEndString = $periodObj->getEndDate()->modify('-1 day')->format($stringFormat); // -1 day ??
        
        $timeZone = new DateTimeZone('Europe/Zagreb');
        $seasonBeginObj = new DateTime('now', $timeZone);
		$seasonBeginObj->setDate(self::SEASON['SEASON_YEAR'], self::SEASON['SEASON_START_MONTH'], self::SEASON['SEASON_START_DAY']);
        $seasonBeginString = $seasonBeginObj->format($stringFormat);

        $return = [
            'seasonBeginDate' => $seasonBeginString,
            'startDate' => $periodStartString, // from now (+ advance period)
            'endDate' => $periodEndString,
        ];

        return $return;
    }

    /**
     * Parse initial pricelist data, assign min/max month days.
     * Filter only bookable items (in case we have extra subjcts inside)
     */
    private $_pricelistBySubject = [];
    private function _setPricelistBySubject()
    {
        if (!empty($this->_pricelistBySubject)) {
            return;
        }

        $this->_pricelistBySubject = [
            /* ============================================ */
            'boat15hp' => [
            /* ============================================ */
                [
                    'price' => 99,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 110,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 120,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 120,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 100,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'betina' => [
            /* ============================================ */
                [
                    'price' => 94,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 120,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 132,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 150,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 134,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 120,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 94,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'adria-2020' => [
            /* ============================================ */
                [
                    'price' => 120,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 150,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 160,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 180,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 180,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 150,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 140,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'zodiac50hp' => [
            /* ============================================ */
                [
                    'price' => 155,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 170,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 200,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 200,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 31,
                    'monthTo' => 8,
                ],
                [
                    'price' => 200,
                    'dateFrom' => 1,
                    'monthFrom' => 9,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 170,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 170,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'zodiac60hp' => [
            /* ============================================ */
                [
                    'price' => 160,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 180,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 205,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 205,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 31,
                    'monthTo' => 8,
                ],
                [
                    'price' => 205,
                    'dateFrom' => 1,
                    'monthFrom' => 9,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 170,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 170,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'marinelo60hp' => [
            /* ============================================ */
                [
                    'price' => 170,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 190,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 215,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 215,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 31,
                    'monthTo' => 8,
                ],
                [
                    'price' => 210,
                    'dateFrom' => 1,
                    'monthFrom' => 9,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 185,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 170,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'mariner150hp' => [
            /* ============================================ */
                [
                    'price' => 260,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 285,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 315,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 350,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 350,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'maestral150hp' => [
            /* ============================================ */
                [
                    'price' => 250,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 299,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 330,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 330,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'solemar150hp' => [
            /* ============================================ */
                [
                    'price' => 300,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 315,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 378,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 400,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 400,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 349,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 309,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'marinerShogun' => [
            /* ============================================ */
                [
                    'price' => 260,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 285,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 315,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 350,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 350,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 270,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],


            /* ============================================ */
            'nuova-jolly' => [
            /* ============================================ */
                [
                    'price' => 305,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 310,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 375,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 405,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 405,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 350,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 350,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'joker300hp' => [
            /* ============================================ */
                [
                    'price' => 324,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 20,
                    'monthTo' => 5,
                ],
                [
                    'price' => 389,
                    'dateFrom' => 21,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 429,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 10,
                    'monthTo' => 7,
                ],
                [
                    'price' => 449,
                    'dateFrom' => 11,
                    'monthFrom' => 7,
                    'dateTo' => 20,
                    'monthTo' => 8,
                ],
                [
                    'price' => 449,
                    'dateFrom' => 21,
                    'monthFrom' => 8,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 399,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => 30,
                    'monthTo' => 9,
                ],
                [
                    'price' => 399,
                    'dateFrom' => 1,
                    'monthFrom' => 10,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'solemar-oasi' => [
            /* ============================================ */
            [
                    'price' => 670, /* izmislio bezveze za price hint "From €..." */
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 1,
                    'monthTo' => 5,
                ],
                [
                    'price' => 700,
                    'dateFrom' => 2,
                    'monthFrom' => 5,
                    'dateTo' => 31,
                    'monthTo' => 8,
                ],
                [
                    'price' => 730,
                    'dateFrom' => 1,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],


            /* ============================================ */
            'searay-sundancer-320' => [
            /* ============================================ */
                [
                    'price' => 945, /* izmislio bezveze za price hint "From €..." */
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 1,
                    'monthTo' => 5,
                ],
                [
                    'price' => 1170,
                    'dateFrom' => 2,
                    'monthFrom' => 5,
                    'dateTo' => 19,
                    'monthTo' => 6,
                ],
                [
                    'price' => 1270,
                    'dateFrom' => 20,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 1170,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'piaggio-liberty' => [
            /* ============================================ */
                [
                    'price' => 45,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 9,
                    'monthTo' => 6,
                ],
                [
                    'price' => 50,
                    'dateFrom' => 10,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 45,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'yamaha-why' => [
            /* ============================================ */
                [
                    'price' => 45,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 9,
                    'monthTo' => 6,
                ],
                [
                    'price' => 50,
                    'dateFrom' => 10,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 45,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'honda-vision' => [
            /* ============================================ */
                [
                    'price' => 50,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 9,
                    'monthTo' => 6,
                ],
                [
                    'price' => 55,
                    'dateFrom' => 10,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 50,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'x-enter' => [
            /* ============================================ */
                [
                    'price' => 55,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 9,
                    'monthTo' => 6,
                ],
                [
                    'price' => 60,
                    'dateFrom' => 10,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 55,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'vw-polo' => [
            /* ============================================ */
                [
                    'price' => 60,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 9,
                    'monthTo' => 6,
                ],
                [
                    'price' => 70,
                    'dateFrom' => 10,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 60,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],

            /* ============================================ */
            'peugot107' => [
            /* ============================================ */
                [
                    'price' => 60,
                    'dateFrom' => self::SEASON['SEASON_START_DAY'],
                    'monthFrom' => self::SEASON['SEASON_START_MONTH'],
                    'dateTo' => 9,
                    'monthTo' => 6,
                ],
                [
                    'price' => 70,
                    'dateFrom' => 10,
                    'monthFrom' => 6,
                    'dateTo' => 15,
                    'monthTo' => 9,
                ],
                [
                    'price' => 60,
                    'dateFrom' => 16,
                    'monthFrom' => 9,
                    'dateTo' => self::SEASON['SEASON_END_DAY'],
                    'monthTo' => self::SEASON['SEASON_END_MONTH'],
                ],
            ],
        ];

        // Filter pricelist only to bookable items
        $this->load->model('subjects/Subjects_model', 'subjects');
        $bookableSubjects = $this->subjects->getBookableSubjects();
        foreach ($this->_pricelistBySubject as $subjectKey => $datePeriods) {
            if (!in_array($subjectKey, $bookableSubjects)) {
                unset($this->_pricelistBySubject[$subjectKey]);
                $this->logger->error_log('Unused subject in pricelist: ' . $subjectKey);
            }
        }

        // Do we miss anything?
        $subjectsDiff = array_diff($bookableSubjects, array_keys($this->_pricelistBySubject));
        if (0 < count($subjectsDiff)) {
            $missingItemsString = json_encode(array_values($subjectsDiff), true);
            $this->logger->error_log('Following subjects are missing in the pricelist: ' . $missingItemsString);
        }
    }
}