#/bin/bash
# CHANGE THE PATH!

while true ; do php /var/www/html/scripts/cron/php/dishy.cron.php & printf . & sleep 1; done
