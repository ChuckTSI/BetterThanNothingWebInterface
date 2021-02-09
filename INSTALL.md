<h1>Install Guide</h1> (written using Ubuntu as dev server)

<strong>Requirements:</strong> PHP,MySQL,Git,Screen,grpcurl

1. Setup an Ubuntu Server (If you use other flavors/OSs, you are on your own)<br>
2. Ensure there is a LAMP stack on your server and you can access it<br>
   Let's assume your server ip is 192.168.0.1;<br>
   http://192.168.0.1

3a. Install git (sudo apt-get install git)<br>
3b. Install screen (sudo apt-get install screen)<br>

4. cd to your apache web root folder. (ex: cd /var/www/html)

5. Run the following command:   git clone https://github.com/ChuckTSI/BetterThanNothingWebInterface.git<br>
   Let's assume your install path is /var/www/html/BetterThanNothingWebInterface

6. Modify the config.inc.php file and update the path to where the repo was installed. <br>
   $_CONFIG["path"] = '/var/www/html/BetterThanNothingWebInterface';

7. Run the following command: sudo chmod 777 /var/www/html/BetterThanNothingWebInterface/data
   
   ** if you want to reduce writes to your drive, set up a ramdrive.<br>
   7a (Optional) Create a ramdisk folder in the install folder.  mount -t tmpfs -o size=64m tmpfs /var/www/html/BetterThanNothingWebInterface/ramdisk<br>
   7b Run:  mount -t tmpfs -o size=64m tmpfs /var/www/html/BetterThanNothingWebInterface/ramdisk

8. run: sudo crontab -e<br>
   insert the following line:

   */5 * * * * php /var/www/html/BetterThanNothingWebInterface/scripts/cron/php/speedtest.cron.php


You should then be able to access this tool via your browser: http://192.168.0.1/BetterThanNothingWebInterface

Good luck!

## Docker
If you don't want to figure that stuff out and are comfortable with docker, you can just run the following:
```
docker-compose build && docker-compose up -d
```

Once built and running, you can view the status page at [http://localhost/BetterThanNothingWebInterface](http://localhost/BetterThanNothingWebInterface)
