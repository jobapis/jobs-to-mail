<?php

/**
 * Makes a best guess at the server's IP defaulting to localhost.
 */
if (isset($_SERVER['REMOTE_ADDR'])) {
    $currentIp = $_SERVER['REMOTE_ADDR'];
} elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $ipAddresses = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $currentIp = trim(end($ipAddresses));
} else {
    $currentIp = 'localhost';
}

/**
 * Makes a best guess at the user agent making this request
 */
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :
    'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36';

/**
 * Default job boards that require no API key permissions
 */
$jobboards = [
    'Careercast' => [],
    'Dice' => [],
    'Github' => [],
    'Govt' => [],
];

/**
 * Careerbuilder
 * http://developer.careerbuilder.com/
 */
if (env("CAREERBUILDER_KEY")) {
    $jobboards['Careerbuilder'] = [
        'DeveloperKey' => env("CAREERBUILDER_KEY"),
    ];
}
/**
 * Indeed
 * http://www.indeed.com/publisher
 */
if (env("INDEED_KEY")) {
    $jobboards['Indeed'] = [
        'publisher' => env("INDEED_KEY"),
        'userip' => $currentIp,
        'useragent' => $userAgent,
    ];
}
/**
 * USAJOBS
 * https://developer.usajobs.gov/Search-API/Overview
 */
if (env("USAJOBS_KEY")) {
    $jobboards['Usajobs'] = [
        'AuthorizationKey' => env("USAJOBS_KEY"),
    ];
}

return $jobboards;
