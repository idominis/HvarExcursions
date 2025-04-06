<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 01. include production configuration
require_once(APPPATH . 'config/config.php');
$config['compress_output'] = FALSE; // gzip, so we can catch pre-output errors

// 02. override by development configuration
$config['base_url'] = 'http://localhost:4200/'; 
//$config['base_url'] = 'https://www.hvarexcursions.uxcessible.com/'; 
//$config['base_url'] = 'http://192.168.178.47:4200/'; // Not needed
//$config['base_url'] = 'http://2.200.69.69:4200/'; // Also change settings.json (There goes Local and here Public IP. Also I do need Firewall inbound rule "Hrvoje" for TCP local port 4200 and remote port ANY. But no other network configuration. Also Router configuration: Internet / Freigaben / Port-Freigaben / HTTP-Server TCP from 4200 to 4200). In addition something was also wrong in routes.php, it's commented there.

// 03. set global site defaults (it's used by MY_Controller, it can be overriden there)
// ! Make sure to have those in production config.php file as well
$config['global_cache_enabled'] = FALSE;		// enable caching
$config['global_profiler_enabled'] = FALSE;		// enable profiling
$config['global_login_required'] = FALSE;		// login required on each site
