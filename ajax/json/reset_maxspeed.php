<?php
require('../../config.inc.php');

$max['down'] = 0;
$max['up'] = 0;

file_put_contents($_CONFIG['files']['maxspeed'],serialize($max));

echo json_encode(true);