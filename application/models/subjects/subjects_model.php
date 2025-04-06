<?php

class Subjects_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    private $_flPriceHintsWritten = false;

    private const CATEGORY = [ // category key => lang sting key; Order is important
        'SPEEDBOAT' => 'speedboats',
        'BOAT' => 'boats',
        'YACHT' => 'yachts',
        'CAR' => 'cars',
        'SCOOTER' => 'scooters',
        //'BIKE' => 'bikes',
    ];

    /*
     * Kako dodati novi subject?
     * * Dodaj ovdje u listu sa definiranim ključem npr. 'zodiac2021'
     * * Dodaj u Pricelist za taj ključ (pricelist_model.php)
     * * Dodaj u lang file tekstove za taj ključ (rentals_lang.php)
     * * Dodaj slike i glavnu sliku (thumb) - Folder name se mora isto se zvati kao i ključ
     * * Dodaj u Booking Tablicu i Booking Formu sa definiranim 'spreadsheetSubjectName'
     * 
     * Hints
     * * Order is important. It's how it will be displayed on the website
     * * Option 'priceHint' leave empty. It will be auto-generated from pricelist (unless entered manually e.g. bike)
     * * Option 'isBookable' e.g. bike is not bookable
     * 
     * Slike?
     * * Thumb image width 767px! Thumb ratio: 40:25 (768x480 - Minimum!)
     * * Filename od thumb slike moraš tu specificirati dolje, a imena ostalih slika nisu bitne
     * * Make sure to have both thumb image in thumb folder ans same image in regular folder to be displayed when clicked
     * * Sve brode slikaj u desnu stranu tako da svi budu isto okrenuti (?)
     * * Probati i da budu svi jednako fokusirani da bude jednaka margina oko svih npr 1cm od desnog ruba itd...
     * * Slikati otvorenu/zatvorenu tendu, sjedala, opremu
     * * Keep in mind that linux sorts images like image_1 image_11 image_2...
     */
    private $_subjects = [
        'solemar150hp' => [
            'spreadsheetSubjectName' => 'Solemar 150hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'solemar_150hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'nuova-jolly' => [
            'spreadsheetSubjectName' => 'Nuova Jolly 250hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'nuova_jolly_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'joker300hp' => [
            'spreadsheetSubjectName' => 'Joker Clubman 300hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'joker_jc_clubman_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        /*'solemar-oasi' => [
            'spreadsheetSubjectName' => 'Solemar Oasi 32 600hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'solemar_oasi_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],*/
        'marinerShogun' => [
            'spreadsheetSubjectName' => 'Mariner Shogun 150hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'mariner_150hp_hvar_excursions_boat_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        /*'mariner150hp' => [
            'spreadsheetSubjectName' => 'Mariner 150hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'mariner_150hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],*/
        'maestral150hp' => [
            'spreadsheetSubjectName' => 'Maestral 150hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'maestral_650_150hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'marinelo60hp' => [
            'spreadsheetSubjectName' => 'Marinelo 60hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint' => '',
            'thumbImage' => 'marinelo_60hp_hvar_excursions_rentals.jpg?v=1',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'zodiac60hp' => [
            'spreadsheetSubjectName' => 'Zodiac 60hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'zodiac_medline_60hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'zodiac50hp' => [
            'spreadsheetSubjectName' => 'Zodiac 50hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint' => '',
            'thumbImage' => 'zodiac_medline_50hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true,
        ],

        'searay-sundancer-320' => [
            'spreadsheetSubjectName' => 'Searay Sundancer 320',
            'category' => self::CATEGORY['YACHT'],
            'priceHint'=> 'Price 1050€ to 1400€ (fuel incl.)',
            'thumbImage' => 'searay-sundancer-320-hvar-excursions-rentals.jpeg',
            'isFuelIncluded' => true,
            'isBookable' => false
        ],

        
        'adria-2020' => [
            'spreadsheetSubjectName' => 'Adria 20hp',
            'category' => self::CATEGORY['BOAT'],
            'priceHint'=> '',
            'thumbImage' => 'boat_adria-2020_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => true,
            'isBookable' => true
        ],
        'boat15hp' => [
            'spreadsheetSubjectName' => 'Pasara Val 15hp',
            'category' => self::CATEGORY['BOAT'],
            'priceHint'=> '',
            'thumbImage' => 'boat_pasara_15hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => true,
            'isBookable' => true
        ],

        'x-enter' => [
            'spreadsheetSubjectName' => 'Yamaha X-Enter 150ccm',
            'category' => self::CATEGORY['SCOOTER'],
            'priceHint'=> '',
            'thumbImage' => 'yamaha_x-enter_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'honda-vision' => [
            'spreadsheetSubjectName' => 'Honda Vision 110ccm',
            'category' => self::CATEGORY['SCOOTER'],
            'priceHint'=> '',
            'thumbImage' => 'honda_vision_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'yamaha-why' => [
            'spreadsheetSubjectName' => 'Yamaha Why 50ccm',
            'category' => self::CATEGORY['SCOOTER'],
            'priceHint'=> '',
            'thumbImage' => 'yamaha_why_50ccm_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'piaggio-liberty' => [
            'spreadsheetSubjectName' => 'Piaggio Liberty 50ccm',
            'category' => self::CATEGORY['SCOOTER'],
            'priceHint'=> '',
            'thumbImage' => 'piaggio_liberty_50ccm_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],

        'vw-polo' => [
            'spreadsheetSubjectName' => 'Volkswagen Polo',
            'category' => self::CATEGORY['CAR'],
            'priceHint'=> '',
            'thumbImage' => 'volkswagen_polo_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'peugot107' => [
            'spreadsheetSubjectName' => 'Peugeot 107',
            'category' => self::CATEGORY['CAR'],
            'priceHint'=> '',
            'thumbImage' => 'peugot107_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],

        
        /*

        'betina' => [
            'spreadsheetSubjectName' => 'Betina 30hp',
            'category' => self::CATEGORY['BOAT'],
            'priceHint'=> '',
            'thumbImage' => 'boat_betina_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => true,
            'isBookable' => true
        ],
        
        'bike' => [
            'spreadsheetSubjectName' => '',
            'category' => self::CATEGORY['BIKE'],
            'priceHint'=>'28&euro; / day',
            'thumbImage' => 'bike_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => '',
            'isBookable' => false
        ],
        'smart' => [
            'price'=> '',
            'thumbImage' => 'smart_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'jeep' => [
            'price'=>'From 70€ to 120€ + isFuelIncluded',		// 600 (80€) - 800 (106€)
            'thumbImage' => 'jeep_nissan_terrano_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => false

            // Za wine tour:
            // - 1000kn za 2 ljudi
            // - 1500kn do 4 ljudi
            // - 2000kn full
        ],
        'joker150hp' => [
            'price'=> '',
            'thumbImage' => 'joker_wide_150hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'zodiac250hp' => [
            'spreadsheetSubjectName' => 'Zodiac Medline 250hp',
            'category' => self::CATEGORY['SPEEDBOAT'],
            'priceHint'=> '',
            'thumbImage' => 'zodiac_medline_250hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'boat5hp' => [
            'price'=> '',
            'thumbImage' => 'boat_pasara_5hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => true,
            'isBookable' => true
        ],
        'legar600' => [
            'price'=> '',
            'thumbImage' => 'legar-600_150hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        'zar140hp' => [
            'price'=> '',
            'thumbImage' => 'zar_140hp_hvar_excursions_rentals.jpg',
            'isFuelIncluded' => false,
            'isBookable' => true
        ],
        */
    ];

    /**
     * Write price hints e.g. 'From 50€ to 85€ + Fuel' for subject items
     */
    private function _setPriceHints() {
        if (!$this->_flPriceHintsWritten) {
            $this->load->model('subjects/Pricelist_model', 'pricelist');
            foreach ($this->_subjects as $subjectKey => $subjectData) {
                if (empty($subjectData['priceHint'])) {
                    $priceHint = $this->pricelist->getPriceRangeString($subjectKey, $subjectData['isFuelIncluded']);
                    $this->_subjects[$subjectKey]['priceHint'] = $priceHint;
                }
            }
            $this->_flPriceHintsWritten = true;
        }
    }

    /**
     * Returns a list of all subject items keys
     */
    function getSubjects()
	{
		return array_keys($this->_subjects);
	}

    /**
     * Returns a list of bookable subject items keys (e.g. not bike)
     */
    function getBookableSubjects()
	{
        $bookableSubjects = [];
        foreach ($this->_subjects as $subjectKey => $subjectData) {
            if (true === $subjectData['isBookable']) {
                $bookableSubjects[] = $subjectKey;
            }
        }
		return $bookableSubjects;
	}

    /**
     * Returns a full list of current of subjects organized into categoris along with all required data
     */
    function getSubjectsData($category = '')
    {
        $this->_setPriceHints();

        if (!empty($category)) {
            $categorizedSubjects = [];
            foreach ($this->_subjects as $subjectKey => $subjectData) {
                if ($category === $subjectData['category']) {
                    $categorizedSubjects[$subjectKey] = $subjectData;
                }
            }
            return $categorizedSubjects;
        }
        return $this->_subjects;
    }
    
    /**
     * Returns a full list of current state of subjects without processing e.g. writing price hints
     * or organizing into categories
     */
    function getSubjectsDataWithoutProcessing()
	{
        return $this->_subjects;
    }
    
    /**
     * Returns a list of subjects and an array of associated images for each
     */
    function getSubjectsImages() {
        $subjectsImages = [];

        foreach ($this->_subjects as $subjectKey => $subjectData) {
            $imgDirectory = 'img/rentals/photos/' . $subjectKey . '/';
            // TODO - Better RegExp: $images = glob($imgDirectory . '*.[jJ][pP][eE]?[gG]'); // .jpg
            $images = glob($imgDirectory . '*.[jJ][pP]*[gG]'); // .jpg
            $thumbnail = base_url() . $imgDirectory . 'thumb/' . $subjectData['thumbImage'];          
            $subjectsItemImages = [];
            
            foreach ($images as $imageIndex => $imagePath) {
                // TODO - do we need this? list($imageWidth, $imageHeight, $imageType, $imageAttr) = getimagesize($imagePath);
                $imagePathAbsolute = base_url() . $imagePath;
                $subjectsItemImages[] = [
                    'src' => $imagePathAbsolute
                ];
            }

            $subjectsImages[$subjectKey] = [
                'images' => $subjectsItemImages,
                'thumbnail' => $thumbnail,
            ];
        }
        return $subjectsImages;
    }

}
