<?php

/*
##### Created a shell script names starlink.update. make sure to change the path to your install
#### I then run this in screen in the background.

#/bin/bash
while true ; do php /var/www/html/btnwi/scripts/cron/php/dishy.cron.php & printf . & sleep 1; done

*/
error_reporting('E_FATAL');
require(dirname(__FILE__).'/../../../config.inc.php');
if(strtoupper($_CONFIG["dishy"]['update_method']) == "CLI"){
	
	$t = shell_exec($_CONFIG['dishy']['get_status']);
	// This appends maxspeeds (peak) to the dishy json result along with method used
	
	$maxspeedfile = $_CONFIG['files']['maxspeed'];
	$maxspeeds = unserialize(file_get_contents($maxspeedfile));
	$status = json_decode($t,true);

	$max["down"] = $status["dishGetStatus"]["downlinkThroughputBps"];
	$max["up"] = $status["dishGetStatus"]["uplinkThroughputBps"];

	if($maxspeeds){		
		if($maxspeeds['down'] < $max["down"]){
			$maxspeeds['down'] = $max['down'];
			$maxspeeds['down_time'] = date("Y-m-d H:i:s",time());
		}
		if($maxspeeds['up'] < $max["up"]){
			$maxspeeds['up'] = $max['up'];
			$maxspeeds['up_time'] = date("Y-m-d H:i:s",time());
		}
		file_put_contents($maxspeedfile,serialize($maxspeeds));
	} else {
		file_put_contents($maxspeedfile,serialize($max));
	}

	$status['dishGetStatus']['deviceInfo']['id'] = 'private';
	file_put_contents($_CONFIG['files']['dishy'],json_encode($status, JSON_PRETTY_PRINT));
	
	if($_CONFIG["record"]['obstructions']){		
		$file = escapeshellarg($_CONFIG['results']['obstruction_log']); // for the security concious (should be everyone!)
		$line = shell_exec('tail -n 1 '.$file);
		$lineexp = explode(",",$line);
		unset($lineexp[0]);
		unset($lineexp[1]);
		$lineimp = str_replace(PHP_EOL,"",implode(",",$lineexp));
		$wedge = str_replace(PHP_EOL,"",implode(",",str_replace("\n","",$status['dishGetStatus']['obstructionStats']['wedgeFractionObstructed'])));
		if($wedge != $lineimp){
			echo "\n Obstruction Change Recorded\n";
			$entry = time().','.$status['dishGetStatus']['obstructionStats']['fractionObstructed'].','.$wedge."\n";
			file_put_contents($_CONFIG['results']['obstruction_log'], $entry, FILE_APPEND | LOCK_EX);
		} 		
	}



}
