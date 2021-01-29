<?php

## apt-get install speedtest-cli
require(dirname(__FILE__).'/../../../config.inc.php');
shell_exec('speedtest-cli > '.$_CONFIG["data_path"].'/speedtest.tmp');
rename($_CONFIG["data_path"].'/speedtest.tmp',$_CONFIG['results']['speed_test']);
