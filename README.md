# BetterThanNothingWebInterface
A Web Interface for Seeing Data from Dishy in the Better Than Nothing Beta by Starlink

#################################################################################################

** <b>IMPORTANT</b>: This needs your server to be using the Starlink router OR you being able to ensure that your server can see the 192.168.100.1 address using routing. *** 

This will show you most basic stats but will give you a visual chart/compass showing obstructions.

Some notes:

<ul>
  <li> This is a hot mess and developed on Ubuntu Machine w/ LAMP, GRPCurl and speedtest-cli
  <li> To use a ramdisk, simply mount a ramdisk called 'ramdisk' in the root of the project.
  <li> I used CDNs for JQuery,Bootstrap, etc. May break at any time.
  <li> For speedtest, you will need to create a cron to run every 15 mins (or sooner) check scripts/cron/php/speedtest.php
  <li> Take a look at the config.inc.php file in the root folder.
  <li> Make sure your web server is on the network that dishy is connected to
</ul>

The are almost no comments and bad coding practices.<br>
Good luck!

<strong>Future Vision:</strong><br>
History (using MySQL or other lightweight SQL for Storage)<br>

<strong>Wish List:</strong><br>
Speedtest directly from Satellite (Crazy. I know).<br>
Hoping they give us a little more data like Satellite name(s) connected, (lat,long of Sat OR which wedge it's in) and Est distance to work with. <br>
Would like to do flyover tracing.<br>
Just saying Mr Dishy Developers :)

Any other ideas, bring it.

<img src="https://repository-images.githubusercontent.com/333752169/7e27c080-6350-11eb-9079-a190f3f349b7">

