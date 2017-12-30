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
    $currentIp = '127.0.0.1';
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
    'Github' => [],
    'Govt' => [],
    'Ieee' => [],
    'Jobinventory' => [],
    'Monster' => [],
    'Stackoverflow' => [],
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
 * Careerjet
 * http://www.careerjet.com/partners/
 */
if (env("CAREERJET_KEY")) {
    $jobboards['Careerjet'] = [
        'affid' => env("CAREERJET_KEY"),
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
/**
 * Juju
 * http://www.juju.com/publisher/spec/
 */
if (env("JUJU_KEY")) {
    $jobboards['Juju'] = [
        'partnerid' => env("JUJU_KEY"),
        'ipaddress' => $currentIp,
        'useragent' => $userAgent,
        'highlight' => '0',
    ];
}
/**
 * Ziprecruiter
 * https://www.ziprecruiter.com/publishers
 */
if (env("ZIPRECRUITER_KEY")) {
    $jobboards['Ziprecruiter'] = [
        'api_key' => env("ZIPRECRUITER_KEY"),
    ];
}
/**
 * Jobs2Careers
 * https://www2.jobs2careers.com/advertiser.php
 */
if (env("J2C_ID") && env("J2C_PASS")) {
    $jobboards['J2c'] = [
        'id' => env("J2C_ID"),
        'pass' => env("J2C_PASS"),
    ];
}

return $jobboards;
