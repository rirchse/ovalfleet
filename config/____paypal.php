<?php

return array(
/** set your paypal credential **/
'client_id' =>'AXmskNmp3WdzpHq5nVy3IdtD-g9VXb3XSfStBwikVRPLJmwcnsFEXUmcVPpB15K2Rw40XeukYINda7JA',
'secret' => 'EMtnCKAAc3r05IXgOf4TW7i2_bgJpFaD8z7-l1P1crzaHsl9l75GciH0G5N3DQ7gBzRQ9su0K-tH_Ef-',
/**
* SDK configuration 
*/
'settings' => array(
    /**
    * Available option 'sandbox' or 'live'
    */
    'mode' => 'live',
    /**
    * Specify the max request time in seconds
    */
    'http.ConnectionTimeOut' => 1000,
    /**
    * Whether want to log to a file
    */
    'log.LogEnabled' => true,
    /**
    * Specify the file that want to write on
    */
    'log.FileName' => storage_path() . '/logs/paypal.log',
    /**
    * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
    *
    * Logging is most verbose in the 'FINE' level and decreases as you
    * proceed towards ERROR
    */
    'log.LogLevel' => 'FINE'
    ),
);