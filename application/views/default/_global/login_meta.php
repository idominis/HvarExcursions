<?php

	/*
	META OVERRIDE (include  default + additional rules)

	Crawl prioritization: Search engine robots can't sign in or register as a member on your forum, so there's no reason to invite Googlebot to follow "register here" or "sign in" links. Using nofollow on these links enables Googlebot to crawl other pages you'd prefer to see in Google's index. However, a solid information architecture — intuitive navigation, user- and search-engine-friendly URLs, and so on — is likely to be a far more productive use of resources than focusing on crawl prioritization via nofollowed links.

	  -- https://support.google.com/webmasters/answer/96569?hl=en&ref_topic=2371375


	*/
	include_once(APPPATH . 'views/'.$dir.'_global/include/default_meta.php');

	// leave two SPACE and and one TAB after ? >

?>

	<meta name="robots" content="nofollow" />

	