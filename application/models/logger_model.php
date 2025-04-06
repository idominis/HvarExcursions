<?php

class Logger_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function error_log($errMsg)
    {
        error_log('🌟🌟🌟🌟🌟 INFO: ' . $errMsg);
    }
}