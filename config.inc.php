<?php

// Change These
$_CONFIG["username"] = "Chuck<strong>TSI</strong>";
$_CONFIG["path"] = '/var/www/html/btnwi';

// Change these at your own peril.

// Files
$_CONFIG['files']['maxspeed'] = $_CONFIG["path"].'/data/ser/maxspeeds.ser'; // Serialized array of max speeds up and down.
$_CONFIG['files']['dishy'] = $_CONFIG["path"].'/data/json/dishy.json'; // Serialized array of max speeds up and down.

$_CONFIG['results']['speed_test'] = 'data/txt/speedtest.result'; // Plain text file

// Urls
$_CONFIG['ajax']['speed_test'] = 'ajax/json/speedtest.php';
$_CONFIG['ajax']['dishy'] = 'ajax/json/dishy.php';

// Dishy McFlatface
// The json response from dishy must be saved to $_CONFIG['files']['dishy']
$_CONFIG["dishy"]['update_method'] = 'CLI'; // options are: CLI (up to you to setup). OR BROWSER which could cause issues with the app if multiple browsers hitting it)
$_CONFIG["dishy"]['address'] = '192.168.100.1:9200';
$_CONFIG["dishy"]['get_status'] = "grpcurl -plaintext -d '{\"get_status\":{}}' ".$_CONFIG["dishy"]['address']." SpaceX.API.Device.Device/Handle";

## This result is LARGE. Still not sure how to use it.##
$_CONFIG["dishy"]['get_history'] = "grpcurl -plaintext -d '{\"get_history\":{}}' ".$_CONFIG["dishy"]['address']." SpaceX.API.Device.Device/Handle";

// Useless stuff
$_CONFIG['styles']['bg_bars'] = 'bg-light'; // https://getbootstrap.com/docs/4.0/utilities/colors/