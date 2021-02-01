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
	
	###########################################################################################
	## UPTIME HISTORY

	if(!is_file($_CONFIG['files']['uptime_history'])){
		
		$started = date("Y-m-d H:i:s",time()-$status["dishGetStatus"]["deviceState"]["uptimeS"]);
		file_put_contents($_CONFIG['files']['uptime_history'],$started.',-');

	} else{
		
		//echo time();
		
		$file = escapeshellarg($_CONFIG['files']['uptime_history']); // for the security concious (should be everyone!)
		$line = shell_exec('tail -n 1 '.$file);
		$t = explode(",",$line);

		$how_long_since_last_start = time() - strtotime($t[0]);

		//echo "\n".$how_long_since_last_start .' > '. $status["dishGetStatus"]["deviceState"]["uptimeS"]."\n";
		if($how_long_since_last_start > $status["dishGetStatus"]["deviceState"]["uptimeS"]){		
			
			echo "\nService got cut and we need to start a new line.\n";
			$uth = file($_CONFIG['files']['uptime_history']);
			$lkey = array_key_last($uth);
			$temp = explode(",",$uth[$lkey]);
			$temp[1] = date("Y-m-d H:i:s",time());
			$uth[$lkey] = implode(",",$temp);
			$uth[] = date("Y-m-d H:i:s",time()).',-';
			file_put_contents($_CONFIG['files']['uptime_history'],implode("\n",$uth));
		
		}

		unset($file,$line);
	}


	###########################################################################################
	## OBSTRUCTIONS

	if($_CONFIG["record"]['obstructions']){
		
		
		$file = escapeshellarg($_CONFIG['results']['obstruction_log']); // for the security concious (should be everyone!)
		$line = shell_exec('tail -n 1 '.$file);
		$line = str_replace(PHP_EOL,"",$line);
		$lineexp = explode(",",$line);
		unset($lineexp[0]);
		unset($lineexp[1]);
		$lineimp = str_replace(PHP_EOL,"",implode(",",$lineexp));
		$wedge = str_replace(PHP_EOL,"",implode(",",str_replace("\n","",$status['dishGetStatus']['obstructionStats']['wedgeFractionObstructed'])));

		$key = 0;
		$threshold_met = false;

		// In case the file is reset.
		if(count($lineexp) < 1){
			$threshold_met = true;
		}
		
		//echo '------------------------------------------'."\n";
		foreach($lineexp AS $historical){

			//	echo '('.abs($status['dishGetStatus']['obstructionStats']['wedgeFractionObstructed'][$key]-$historical).') '.$historical .' vs '.$status['dishGetStatus']['obstructionStats']['wedgeFractionObstructed'][$key] ."\n"; 
			if(abs($status['dishGetStatus']['obstructionStats']['wedgeFractionObstructed'][$key]-$historical) >= $_CONFIG["obstruction_change_threshold"]){
				$threshold_met = true;
			}
			$key++;
		}

		if($threshold_met == true ){
			echo "\n Obstruction Change Recorded (Threshold ".$_CONFIG["obstruction_change_threshold"]." Met) \n";
			$entry = time().','.$status['dishGetStatus']['obstructionStats']['fractionObstructed'].','.$wedge."\n";
			file_put_contents($_CONFIG['results']['obstruction_log'], $entry, FILE_APPEND | LOCK_EX);
		}


	}



}
