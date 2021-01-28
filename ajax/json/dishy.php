<?php
require('../../config.inc.php');

$maxspeedfile = $_CONFIG['files']['maxspeed'];
$maxspeeds = unserialize(file_get_contents($maxspeedfile));

if(strtoupper($_CONFIG["dishy"]['update_method']) == "BROWSER"){

	$t = shell_exec($_CONFIG['dishy']['get_status']);
	$status = json_decode($t,true);
	$status['dishGetStatus']['deviceInfo']['id'] = 'private';
	file_put_contents($_CONFIG['files']['dishy'],json_encode($status, JSON_PRETTY_PRINT));

	$max["down"] = $status["dishGetStatus"]["downlinkThroughputBps"];
	$max["up"] = $status["dishGetStatus"]["uplinkThroughputBps"];

	if($maxspeeds){
		if($maxspeeds['down'] < $max["down"]){
			$maxspeeds['down'] = $max['down'];
		}
		if($maxspeeds['up'] < $max["up"]){
			$maxspeeds['up'] = $max['up'];
		}
		file_put_contents($maxspeedfile,serialize($maxspeeds));
	} else {
		file_put_contents($maxspeedfile,serialize($max));
	}

} else {
	$t = file_get_contents($_CONFIG['files']['dishy']);
	$status = json_decode($t,true);
}



// This appends maxspeeds (peak) to the dishy json result along with method used
$status["dishGetStatus"]["method"] = $_CONFIG["dishy"]['update_method'];
$status["dishGetStatus"]["maxspeeds"] = $maxspeeds;
echo json_encode($status,JSON_PRETTY_PRINT); //,



/*
if(isset($argv)){

	// Record Max Speed Seen if < than
	if($argv[1] == "maxspeeds"){
		
	}

}
*/