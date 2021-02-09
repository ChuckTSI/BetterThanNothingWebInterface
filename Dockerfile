FROM php:7.2.1-apache

# install grpcurl
WORKDIR /usr/local/bin
RUN cd /usr/local/bin && curl -L https://github.com/fullstorydev/grpcurl/releases/download/v1.8.0/grpcurl_1.8.0_linux_x86_64.tar.gz | tar xzv

# install git, speedtest
RUN apt-get update -y && apt-get install -y speedtest-cli cron

# clone repo
WORKDIR /var/www/html
COPY . /var/www/html/BetterThanNothingWebInterface
# ...also put here, because that's where scripts are expected
RUN ln -s /var/www/html/BetterThanNothingWebInterface /var/www/html/btnwi

# Snag favicon from Starlink
RUN curl https://www.starlink.com/assets/favicon.ico > favicon.ico

# schedule speedtest
RUN echo "*/15 * * * * /usr/local/bin/php /var/www/html/BetterThanNothingWebInterface/scripts/cron/php/speedtest.cron.php" >> /var/spool/cron/crontabs/root
RUN chmod 600 /var/spool/cron/crontabs/root
RUN chown root.crontab /var/spool/cron/crontabs/root

# start apache and run update scripts
CMD /etc/init.d/apache2 start && cron && /var/www/html/BetterThanNothingWebInterface/scripts/binbash/starlink.history.update.sh & /var/www/html/BetterThanNothingWebInterface/scripts/binbash/starlink.update.sh
