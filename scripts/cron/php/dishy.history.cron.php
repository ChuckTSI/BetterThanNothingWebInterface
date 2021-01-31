<?php

/*
##### Created a shell script names starlink.history.update. make sure to change the path to your install
#### I then run this in screen in the background.  Seeing this file can reach 7MB... I run it sparingly to reduce load on the dish and disks.

#/bin/bash
while true ; do php /var/www/html/btnwi/scripts/cron/php/dishy.history.cron.php & printf . & sleep 5; done

*/

require(dirname(__FILE__).'/../../../config.inc.php');

if(strtoupper($_CONFIG["dishy"]['update_method']) == "CLI"){

        $t = shell_exec($_CONFIG['dishy']['get_history']);
        file_put_contents($_CONFIG['files']['dishy_history_12'],$t);

}
