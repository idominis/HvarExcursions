<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are a two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = config_item('default_controller');
$route['404_override'] = '';

$route['(../)?our-services'] = "homepage";
$route['(../)?best-rental-deals-in-hvar'] = "rentals";
$route['(../)?perfect-holidays-in-hvar'] = "excursions";
$route['(../)?excursions/hvar-vis-tour-green-cave-blue-cave'] = "excursions/tour_vis";
$route['(../)?we-plan-holidays-for-you'] = "homepage/holidays";
$route['(../)?taxi-and-speedboat-transfers'] = "homepage/transfers";

// historically indexed by google
$route['(../)?holidays'] = "homepage/holidays";
$route['(../)?taxi'] = "homepage/transfers";



// moraju biti ovako duple rute jer ne postoji controller koji se zove cultural-heritage, da je normalan item, nebi trebale dvije linije
//$route['../cultural-heritage'] = "heritage";					// replace controller name
//$route['cultural-heritage'] = $route['../cultural-heritage'];	// to secure if someone write URL without lang en/,...
/*
	if using this route, redirect in controller as:
	// SEO canonization, always replace "heritage/" from URL by "cultural-heritage/"
	if($this->uri->segment(2) == 'heritage'){
		$uri = $this->uri->uri_string();
		$new_uri = str_ireplace('heritage','cultural-heritage',$uri);
		redirect($new_uri, 'location', 301);
	}
*/

/*

$route[config_item('url_lang_regex').'/audio/(:any)'] = "audio/index/$1";
$route[config_item('url_lang_regex').'/map/(:any)'] = "map/item/$1";

*/

/*
	Routes will run in the order they are defined. Higher routes will always take precedence over lower ones.
	The reserved routes must come before any wildcard or regular expression routes. (for empty URI)
	Do not use leading/trailing slashes.
	- (:num) will match a segment containing only numbers.
	- (:any) will match a segment containing any character.
	Examples:
	- $route['(:num)'] = 'editor/index/$1'; // bilo koji uri koji počinje brojem na prvom segmentu
	- $route['journals'] = "blogs"; // A URI containing the word "journals" in the first segment will be remapped to the "blogs" class.
	- $route['blog/joe'] = "blogs/users/34"; // A URI containing the segments blog/joe will be remapped to the "blogs" class and the "users" method. The ID will be set to "34".
	- $route['product/(:any)'] = "catalog/product_lookup"; // A URI with "product" as the first segment, and anything in the second will be remapped to the "catalog" class and the "product_lookup" method.
	- $route['product/(:num)'] = "catalog/product_lookup_by_id/$1"; // A URI with "product" as the first segment, and a number in the second will be remapped to the "catalog" class and the "product_lookup_by_id" method passing in the match as a variable to the function.
	- $route['products/([a-z]+)/(\d+)'] = "$1/id_$2"; // RegEx - URI similar to products/shirts/123 would instead call the shirts controller class and the id_123 function.


	NOTE: These are only internal routes, no URL will change (the same like with .htaccess)! This is used to change class/method/arg functionality

	Redirect routes includes lang/something you have to put before language ones

*/ 


// for multilingual websites - where en|hr... are the same languages as in your "MY_Lang"'s "$languages" array.
$route['^('.config_item('url_lang_codes').')/(.+)$'] = '$2'; // URI like '/en/about' -> use controller 'about'
$route['^('.config_item('url_lang_codes').')$'] = $route['default_controller']; // '/en' -> use default controller
// TODO (Home router setup) $route['^('.config_item('url_lang_codes').')$'] = "homepage"; // '/en' -> use default controller




$route['tools/sitemap\.xml'] = "tools/sitemap"; // route to XML file

/* End of file routes.php */
/* Location: ./application/config/routes.php */