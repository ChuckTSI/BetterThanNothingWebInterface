<?php

## apt-get install speedtest-cli
require(dirname(__FILE__).'/../../../config.inc.php');
shell_exec('speedtest-cli > '.$_CONFIG['results']['speed_test']);