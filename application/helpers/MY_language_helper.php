<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * HRVOJE 19.05.2019. Fully refactored MY_language_helper.php.
 * One could now use vsprintf() as a second argument. Label generation is removed (when second argument is passed), it's useless
 */
function lang($line, $replacementStrings = [])
{
    $CI =& get_instance();
    $line = $CI->lang->line($line);

    if (!empty($replacementStrings)) {
        $line = vsprintf($line, $replacementStrings);
    }

    return $line;
}

function lang1($line, $replacementStrings)
{
    $CI =& get_instance();
    $line = $CI->lang->line($line);

    $replaceFrom = array_keys($replacementStrings);
    $replaceTo = array_values($replacementStrings);

    if (!empty($replacementStrings)) {
        $line = str_replace($replaceFrom, $replaceTo, $line);
    }

    return $line;
}

/* End of file MY_language_helper.php */
/* Location: ./application/helpers/MY_language_helper */