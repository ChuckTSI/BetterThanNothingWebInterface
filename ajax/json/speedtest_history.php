<?php
require('../../config.inc.php');

$csv = array_map('str_getcsv', file($_CONFIG['results']['speed_test_history']));

echo json_encode($csv,JSON_PRETTY_PRINT);
