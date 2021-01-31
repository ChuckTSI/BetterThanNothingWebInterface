<?php

## apt-get install speedtest-cli
require(dirname(__FILE__).'/../../../config.inc.php');
shell_exec('speedtest-cli > '.$_CONFIG["data_path"].'/speedtest.tmp');

if($_CONFIG["history"]['speedstests'] == true){
	
	$contents = file_get_contents($_CONFIG["data_path"].'/speedtest.tmp');

	$array = explode("\n",$contents);

	preg_match_all("~Hosted by (.*?)\((.*?)\)\ \[(.*?) km\]\:\s(.*?)ms~",$array[4],$hosted);

	$farray['mtime'] = date("Y-m-d H:i:s",time());
	$farray['down'] = '"'.str_replace('Mbit/s','Mbps',str_replace('Download: ','',$array[6])).'"';
	$farray['up'] = '"'.str_replace('Mbit/s','Mbps',str_replace('Upload: ','',$array[8])).'"';
	$farray['by'] = '"'.$hosted[1][0].'"';
	$farray['city'] = '"'.$hosted[2][0].'"';
	$farray['distance'] = '"'.$hosted[3][0].'"';
	$farray['ping'] = '"'.$hosted[4][0].'"';

	file_put_contents($_CONFIG['results']['speed_test_history'], implode(",",$farray)."\n", FILE_APPEND | LOCK_EX);


}


rename($_CONFIG["data_path"].'/speedtest.tmp',$_CONFIG['results']['speed_test']);
