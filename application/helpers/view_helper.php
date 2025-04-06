<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Returns active class only if provided segments are matching
 * Otherwise returns an empty string
 */
function setActiveNavbarNavItem($activeClass, $urlSegment1, $urlSegment2 = '')
{	
    $CI = get_instance();

    if (
        ($urlSegment1 === $CI->uri->rsegment(1)) &&
        (empty($urlSegment2) || $urlSegment2 === $CI->uri->rsegment(2))
    ) {
        return $activeClass;
    }
    return '';
}