<?php

$contents = file_get_contents('/control/tmp/speedtest.status');

$array = explode("\n",$contents);

preg_match_all("~Hosted by (.*?)\((.*?)\)\ \[(.*?) km\]\:\s(.*?)ms~",$array[4],$hosted);

$farray['hosted']['by'] = $hosted[1][0];
$farray['hosted']['city'] = $hosted[2][0];
$farray['hosted']['distance'] = $hosted[3][0];
$farray['hosted']['ping'] = $hosted[4][0];
$farray['speeds']['down'] = str_replace('Download: ','',$array[6]);
$farray['speeds']['up'] = str_replace('Upload: ','',$array[8]);
$farray['speeds']['mtime'] = date('F j, Y, g:i a',filemtime('/control/tmp/speedtest.status'));
$farray['speeds']['next'] = date('F j, Y, g:i a',filemtime('/control/tmp/speedtest.status')+300);

echo json_encode($farray,JSON_PRETTY_PRINT);

/*
"Testing download speed................................................................................",
    "Download: 70.78 Mbit\/s",
    "Testing upload speed......................................................................................................",
    "Upload: 27.22 Mbit\/s",
	*/