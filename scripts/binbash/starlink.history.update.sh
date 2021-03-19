#/bin/bash

require(dirname(__FILE__).'/../../../config.inc.php');

while true ; do php $_CONFIG["path"]/scripts/cron/php/dishy.history.cron.php & printf . & sleep 5; done
