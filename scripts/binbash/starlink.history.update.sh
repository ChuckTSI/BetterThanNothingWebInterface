#/bin/bash

while true ; do php /var/www/html/scripts/cron/php/dishy.history.cron.php & printf . & sleep 5; done
