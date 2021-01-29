<?php

// Change These
$_CONFIG["username"] = "Chuck<strong>TSI</strong>";
$_CONFIG["path"] = '/var/www/html';

// Change these at your own peril.

if(is_dir($_CONFIG["path"].'/ramdisk')){
	$datadir = 'ramdisk';
} else {
	$datadir = 'data';
}


// Files
$_CONFIG['files']['maxspeed'] = $_CONFIG["path"].'/'.$datadir.'/maxspeeds.ser'; // Serialized array of max speeds up and down.
$_CONFIG['files']['dishy'] = $_CONFIG["path"].'/'.$datadir.'/dishy.json'; // Serialized array of max speeds up and down.
$_CONFIG['files']['dishy_history_12'] = $_CONFIG["path"].'/'.$datadir.'/history_12.json'; // Last 12 Hours
$_CONFIG['results']['speed_test'] = $_CONFIG["path"].'/'.$datadir.'/speedtest.txt'; // Plain text file

// Urls
$_CONFIG['ajax']['speed_test'] = 'ajax/json/speedtest.php';
$_CONFIG['ajax']['dishy'] = 'ajax/json/dishy.php';

// Dishy McFlatface
// The json response from dishy must be saved to $_CONFIG['files']['dishy']
$_CONFIG["dishy"]['update_method'] = 'BROWSER'; // options are: CLI (up to you to setup). OR BROWSER which could cause issues with the app if multiple browsers hitting it)
$_CONFIG["dishy"]['address'] = '192.168.100.1:9200';
$_CONFIG["dishy"]['get_status'] = "grpcurl -plaintext -d '{\"get_status\":{}}' ".$_CONFIG["dishy"]['address']." SpaceX.API.Device.Device/Handle";
$_CONFIG["dishy"]['get_history'] = "grpcurl -plaintext -d '{\"get_history\":{}}' ".$_CONFIG["dishy"]['address']." SpaceX.API.Device.Device/Handle";
$_CONFIG["max_history"] = 43199;

// Useless stuff
$_CONFIG['styles']['bg_bars'] = 'bg-light'; // https://getbootstrap.com/docs/4.0/utilities/colors/