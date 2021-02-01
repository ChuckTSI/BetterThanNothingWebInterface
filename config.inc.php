<?php

// Change These
$_CONFIG["username"] = "Chuck<strong>TSI</strong>";
$_CONFIG["path"] = '/var/www/html';
$_CONFIG["max_graph_seconds"] = '170'; // Seconds

$_CONFIG["obstruction_change_threshold"] = '0.001'; // Anything less than 1% may record too often. Need to find the sweet spot.

$_CONFIG["record"]['obstructions'] = true; // false or true. Only records changes in obtructions!
$_CONFIG['results']['obstruction_log_basename'] = 'obstructions_log.csv'; // csv file

$_CONFIG["history"]['speedstests'] = true;
$_CONFIG['results']['speed_test_history_basename'] = 'speedtest_history.csv'; // csv file

// Change these at your own peril.


// FutureDBItems (Do not set to to true yet)
$_CONFIG["db"] = false;
$_CONFIG["db_type"] = 'mysql';
$_CONFIG["db_user"] = 'root';
$_CONFIG["db_pass"] = '';


if(is_dir($_CONFIG["path"].'/ramdisk')){
	$datadir = 'ramdisk';
} else {
	$datadir = 'data';
}
$_CONFIG["data_path"] = '/var/www/html/'.$datadir;
$_CONFIG["web_data_path"] = $datadir;

// Files
$_CONFIG['files']['maxspeed'] = $_CONFIG["path"].'/'.$datadir.'/maxspeeds.ser'; // Serialized array of max speeds up and down.
$_CONFIG['files']['dishy'] = $_CONFIG["path"].'/'.$datadir.'/dishy.json'; // Serialized array of max speeds up and down.
$_CONFIG['files']['dishy_history_12'] = $_CONFIG["path"].'/'.$datadir.'/history_12.json'; // Last 12 Hours
$_CONFIG['files']['speedtest_history'] = $_CONFIG["path"].'/'.$datadir.'/speedtest_history.json'; // Last 12 Hours
$_CONFIG['files']['uptime_history'] = $_CONFIG["path"].'/'.$datadir.'/uptime_history.csv'; // Last 12 Hours
$_CONFIG['results']['speed_test'] = $_CONFIG["path"].'/'.$datadir.'/speedtest.txt'; // Plain text file

$_CONFIG['results']['speed_test_history'] = $_CONFIG["path"].'/'.$datadir.'/'.$_CONFIG['results']['speed_test_history_basename']; 
$_CONFIG['results']['obstruction_log'] = $_CONFIG["path"].'/'.$datadir.'/'.$_CONFIG['results']['obstruction_log_basename']; 

// Urls
$_CONFIG['ajax']['speed_test'] = 'ajax/json/speedtest.php';
$_CONFIG['ajax']['speed_test_history'] = 'ajax/json/speedtest_history.php';
$_CONFIG['ajax']['dishy'] = 'ajax/json/dishy.php';

// Dishy McFlatface
// The json response from dishy must be saved to $_CONFIG['files']['dishy']
$_CONFIG["dishy"]['update_method'] = 'CLI'; // options are: CLI (up to you to setup). OR BROWSER which could cause issues with the app if multiple browsers hitting it)
$_CONFIG["dishy"]['address'] = '192.168.100.1:9200';
$_CONFIG["dishy"]['get_status'] = "grpcurl -plaintext -d '{\"get_status\":{}}' ".$_CONFIG["dishy"]['address']." SpaceX.API.Device.Device/Handle";
$_CONFIG["dishy"]['get_history'] = "grpcurl -plaintext -d '{\"get_history\":{}}' ".$_CONFIG["dishy"]['address']." SpaceX.API.Device.Device/Handle";
$_CONFIG["max_history"] = 43199; // This is max vals in gprcurl get_history().

// Useless stuff
$_CONFIG['styles']['bg_bars'] = 'bg-light'; // https://getbootstrap.com/docs/4.0/utilities/colors/
$_CONFIG["speedtest_frequency"] = '5'; // Minutes (Not used right now)

error_reporting('E_FATAL');