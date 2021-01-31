<?php

require('../../config.inc.php');

$t = explode("\n",file_get_contents($_CONFIG['results']['obstruction_log']));

$all_items = [];

foreach($t AS $s){

	$temp = explode(",",$s);	
	unset($temp[0]);
	unset($temp[1]);
	$all_items = array_merge($all_items,$temp);

}


$data['min'] = min($all_items);
$data['max'] = max($all_items);
$data['obs'] = $t;



//$data['min'] = 
echo json_encode($data,JSON_PRETTY_PRINT); //,
