<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	This is maintenance site
 	This site does not need lang prefix in url
 	You should request server authentification for this

 */

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

define('SITEMAP_VIEW_PATH', 'default/_global/sitemap_view');
class Tools extends CI_Controller {
	function __construct()
	{
		exit("Not supported anymore.");
		parent::__construct();
		$this->config->set_item('compress_output', FALSE); // Does not work if echo is used before output class
	}
	
	public function index()
	{
		echo '<h1>Site tools</h1>';
		echo '<p><a href="' . site_url('/') . '">&laquo; Return to homepage</a><br/></p>';
		echo '
		<a href="' . site_url('tools/clear_cache') . '">Clear cache</a><br/>
		<a href="' . site_url('tools/Sitemap') . '">Generate sitemap</a><br/>
		<a href="' . site_url('tools/db_backup') . '">Backup database</a><br/>
		<a href="' . site_url('tools/update_availability') . '">Update availability</a><br/>'; 
	}

	public function clear_cache()
	{
		$files = glob(APPPATH . 'cache/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}
		echo 'OK';
	}

	public function Sitemap() // use capital 'S' for sitemaps
    {
        $data['urlset'] = array(
        	'en/our-services',
        	'en/perfect-holidays-in-hvar',
        	'en/excursions/hvar-vis-tour-green-cave-blue-cave',
        	//'we-plan-holidays-for-you',
        	'en/best-rental-deals-in-hvar',
			'en/taxi-and-speedboat-transfers'
		);
        header("Content-Type: text/xml;charset=UTF-8");
        $this->load->view(SITEMAP_VIEW_PATH, $data);
    }

    // !!! Codeigniter has Database Utility Class to do that!!
    // beware this will not export stored procedures or so...
	public function db_backup()
	{
		//backup_tables('localhost','username','password','blog');
	}

	/**
	 * Imports unavailable dates from Google Sheet
	 * 
	 * TODO: Backup imported file kad se nesto zezne?
	 * TODO: Check PHP errors and warnings (in general)
	 * 
	 */
	public function update_availability()
	{
		$appName = 'HE - Update Availability';
		$documentName = 'Rezervacije po datumima';
		$sheetName = '01. All Future Dates';

		$this->load->model('subjects/Subjects_model', 'subjects');
		$subjects = $this->subjects->getSubjectsDataWithoutProcessing();
		
		$whitelist = [];
		foreach($subjects as $subjectKey => $subjectData) {
			if (!empty($subjectData['spreadsheetSubjectName'])) {
				$whitelist[$subjectData['spreadsheetSubjectName']] = $subjectKey;
			}
		}



		echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title></title></head><body>';
		echo 'START - '. $documentName . ' / ' . $sheetName . '<br><br>';

		try {
			require APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';		
			putenv('GOOGLE_APPLICATION_CREDENTIALS=' . APPPATH . 'models' . DIRECTORY_SEPARATOR . 'data_google_sheets_client_secret.json');
			$client = new Google_Client;
			$client->useApplicationDefaultCredentials();
			$client->setApplicationName($appName);
			$client->setScopes(
				[
					'https://www.googleapis.com/auth/drive',
					'https://spreadsheets.google.com/feeds'
				]
			);

			if ($client->isAccessTokenExpired()) {
				$client->refreshTokenWithAssertion();
			}

			$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
			ServiceRequestFactory::setInstance(
				new DefaultServiceRequest($accessToken)
			);

			// Get the  spreadsheet
			$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
			$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
			$spreadsheet = $spreadsheetFeed->getByTitle($documentName);

			$worksheetFeed = $spreadsheet->getWorksheets();
			$worksheet = $worksheetFeed->getByTitle($sheetName);

			// https://github.com/asimlqt/php-google-spreadsheet-client/blob/master/src/Google/Spreadsheet/CellFeed.php
			$cellFeed = $worksheet->getCellFeed();
			//$listFeed = $worksheet->getListFeed(); $listFeed->getEntries(); $entry->getValues()
			//$cellFeed = $worksheet->getCellFeed(); $rows = $cellFeed->toArray());
			//$topLeftCornerCell = $cellFeed->getCell(1, 1); echo $topLeftCornerCell->content; // "last_name"
			//$csv = $worksheet->getCsv();





			$allColumns = $cellFeed->toArray();
			$columnWithDates = array_shift($allColumns);
			$unavailableDates = array();
			$countImportedDates = 0;
			$logWarnings = array();
			$logSuccess = array();

			foreach ($allColumns as $column) {
				if (!isset($whitelist[$column[1]])) {
					$logWarnings[] = 'Warning: Skipped dates import for: <strong>' . url_title($column[1]) . '</strong> - mapping not found (možda postoji u tablici ali ne na stranici)';
					continue;
				} 

				// each column is one subject where top cell is subject name and other rows correspond to dates
				if (1 < count($column)) {
					$unavailableColumnDates = array(); // column title
					$countColumnImportedDates = 0;

					foreach ($column as $columnRow => $rowValue) {
						if ($columnRow === 1) {
							continue; // this is a column title
						}

						// determine month and day of this unavailability entry
						$unavailableDateStr = $columnWithDates[$columnRow];
						$dateSegmented = explode('.', $unavailableDateStr);
						$month = (int) $dateSegmented[1];
						$day =  (int) $dateSegmented[0];
	
						if (!isset($unavailableColumnDates[$month])) {
							$unavailableColumnDates[$month] = array();
						}

						$unavailableColumnDates[$month][] = $day;
						$countImportedDates++;
						$countColumnImportedDates++;

					}

					$unavailableDates[$whitelist[$column[1]]] = $unavailableColumnDates;
					$logSuccess[] = '<strong>' . url_title($column[1]) . '</strong> mapped to "' . $whitelist[$column[1]] . '" - imported: <b>' . $countColumnImportedDates . '</b> date/s';
				}
			}

			$availabilityExport = json_encode($unavailableDates);

			file_put_contents(APPPATH . 'models/data_availability_import.json', $availabilityExport);
			echo '<code>' . $availabilityExport . '</code>';
			echo '<br><br>END - Unavailable <b>' . $countImportedDates . '</b> future dates<br><br>';
			echo implode('<br>', $logSuccess);
			echo '<br><span style="color:red">';
			echo implode('<br>', $logWarnings);
			echo '</span>';

		} catch (Exception $e) {
			echo '<b style="color:red">ERROR: Dates were not imported.</b> '. $e->getMessage();
		}

		echo '</body></html>';
	}






    // PRIVATE FUNCTIONS
    // ===============================================================================
    /* backup the db OR just a table */
	function backup_tables($host,$user,$pass,$name,$tables = '*')
	{
		//mysql_query('SET NAMES utf8');
        //mysql_query('SET CHARACTER SET utf8');
		exit;
		/*$link = mysql_connect($host,$user,$pass);
		mysql_select_db($name,$link);
		
		//get all of the tables
		if($tables == '*')
		{
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//cycle through
		foreach($tables as $table)
		{
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) 
			{
				while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		
		//save file
		$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
		fwrite($handle,$return);
		fclose($handle);
		*/
	}





}

 /*/
/*/