<?php
require('../../config.inc.php');

$contents = file_get_contents($_CONFIG['results']['speed_test']);

$array = explode("\n",$contents);

preg_match_all("~Hosted by (.*?)\((.*?)\)\ \[(.*?) km\]\:\s(.*?)ms~",$array[4],$hosted);

$farray['hosted']['by'] = $hosted[1][0];
$farray['hosted']['city'] = $hosted[2][0];
$farray['hosted']['distance'] = $hosted[3][0];
$farray['hosted']['ping'] = $hosted[4][0];
$farray['speeds']['down'] = str_replace('Mbit/s','Mbps',str_replace('Download: ','',$array[6]));
$farray['speeds']['up'] = str_replace('Mbit/s','Mbps',str_replace('Upload: ','',$array[8]));
$farray['speeds']['mtime'] = date('F j, Y, g:i a',filemtime($_CONFIG['results']['speed_test']));
$farray['speeds']['next'] = date('F j, Y, g:i a',filemtime($_CONFIG['results']['speed_test'])+300);

$downtotal = 0;
$uptotal = 0;
$count = 0;

if (($handle = fopen($_CONFIG['results']['speed_test_history'], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {       
	
		$downtotal += str_replace(" Mbps","",$data[1]);
		$uptotal += str_replace(" Mbps","",$data[2]);
		$count++;

			
		

    }
    fclose($handle);

}

$farray['speeds']['avg_down'] = round($downtotal / $count,2);
$farray['speeds']['avg_up'] = round($uptotal / $count,2);
$farray['speeds']['total_tests'] = $count;



echo json_encode($farray,JSON_PRETTY_PRINT);

/*
"Testing download speed................................................................................",
    "Download: 70.78 Mbit\/s",
    "Testing upload speed......................................................................................................",
    "Upload: 27.22 Mbit\/s",
	*/