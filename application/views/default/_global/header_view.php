<!DOCTYPE html>
<html lang="<?=$this->lang->lang()?>">
<head>
	<title><?php if(lang('head_title')) echo lang('head_title').' - '; ?><?=lang('head_title_sufix')?></title>

	<link href="<?=base_url()?>favicon.ico" rel="shortcut icon" id="icon" />
	<link rel="alternate" hreflang="x-default" href="<?=base_url().$this->lang->trim_uri_lang()?>" />
	<link rel="alternate" hreflang="en" href="<?=base_url().$this->lang->switch_uri('en')?>" />
	<!--<link rel="alternate" hreflang="hr" href="<?php //echo base_url().$this->lang->switch_uri('hr')?>" />-->
	<?php

	/*	SEO Language tip:
		- Google uses only the visible content of your page to determine its language. No lang attributes! 
		- Make sure each language version is easily discoverable (consider cross-linking each language version of a page)
		- Keep the content for each language on separate URLs. Don’t use cookies

		Code Below (hard-coded above):
		- Indicate to Google about other-languages equivalents of the site (you can use sitemap or HTTP header also)
		- The rel="alternate" hreflang="x" annotations help Google serve the correct language or regional URL to searchers.
		- All the variants including the requested one has to be on the list
		- x-default could be something where you choose langugage, or where lang is choosen by default

		$languages = $this->lang->get_languages();
		foreach($languages as $langID => $langName){
			echo '<link rel="alternate" hreflang="'.$langID.'" href="'.base_url().$this->lang->switch_uri($langID).'" />
		';
		}
	*/
	

	








	$site_path = config_item('site_path'); // was set by rendering method argument
	$dir = config_item('global_layout_dir');

	// INCLUDES
	// -------------------------------------------------------------------
	// 26.10.2013.
	// These are the main commonalities/variabilities across every website's <head>
	// Files that override default ones can include defaults within their body
	// If there are more, this include items can also be generated in the loop a for(i=0;...)
	// Folder 'include' contain defaults of layout for better organization
	// if other views would use include folder, no view would be able to be called default
	//
	// all the overrides from include/ should be found in site_path
	// make sure to have default files at following path: '$dir/_global/include'
	// if you wish to override default includes, put them in the same path as original view ($site_path)

	// LOAD HEAD (META) 
	// ===================================================================
	$default_meta = APPPATH . 'views/'.$dir.'_global/include/default_meta.php';
	$lookup_meta = APPPATH . 'views/'.$site_path.'_meta.php';
	if(file_exists($lookup_meta)) include_once($lookup_meta); // it might include() default one
	else include_once($default_meta);

	// LOAD STYLES
	// ===================================================================
	$default_css = APPPATH . 'views/'.$dir.'_global/include/default_css.php';
	$lookup_css = APPPATH . 'views/'.$site_path.'_css.php';

	if(file_exists($lookup_css)) include_once($lookup_css); // it might include() default one
	else include_once($default_css);

	// LOAD SCRIPTS
	// ===================================================================
	$default_js = APPPATH . 'views/'.$dir.'_global/include/default_head.php';
	$lookup_js = APPPATH . 'views/'.$site_path.'_head.php';

	if(file_exists($lookup_js)) include_once($lookup_js); // it might include() default one
	else include_once($default_js);

	// LOAD SOCIAL...?
	// ===================================================================
	// ...
	// ...


	// NOTE: leave 3 spaces in the end of the file!
	// Somewhere in the main view, use id="content" and role="main" for "skip to main content" accessibility feature
?>	


</head>
<body class="<?=str_replace(['/', '_'], '-', $site_path)?>-view">
	<?php
		// LOAD COMMON HEADER, MENU...
		// ===================================================================
		$default_header = APPPATH . 'views/'.$dir.'_global/include/default_header.php';
		$lookup_header = APPPATH . 'views/'.$site_path.'_header.php';

		if(file_exists($lookup_header)) include_once($lookup_header); // it might include() default one
		else include_once($default_header);
	?>

	<main id="view-container">


	