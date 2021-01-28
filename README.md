# BetterThanNothingWebInterface
A Web Interface for Seeing Data from Dishy in the Better Than Nothing Beta by Starlink

A big thank you to https://raw.githubusercontent.com/sparky8512/starlink-grpc-tools for his work to explain the data.

This will show you most basic stats but will give you a visual chart/compass showing obstructions.

Some notes:

<ul>
  <li> This is a hot mess and developed on Ubuntu Machine w/ LAMP, GRPCurl and speedtest-cli
  <li> I used CDNs for JQuery,Bootstrap, etc. May break at any time.
  <li> For speedtest, you will need to create a cron to run every 15 mins (or sooner) check scripts/cron/php/speedtest.php
  <li> Take a look at the config.inc.php file in the root folder.
  <li> Make sure your web server is on the network that dishy is connected to
</ul>

The are almost no comments and bad coding practices.<br>
Good luck!

<strong>Future Vision:</strong><br>
History (using MySQL or other lightweight SQL for Storage)<br>
Using RAM Disk to avoid excessive writes to SSDs<br>

<strong>Wish List:</strong><br>
Speedtest directly from Satellite (Crazy. I know).<br?
Hoping they give us a little more data like Satellite name(s) connected, (lat,long of Sat OR which wedge it's in) and Est distance to work with. <br>
Would like to do flyover tracing.<br>
Just saying Mr Dishy Developers :)

Any other ideas, bring it.

<img src="https://repository-images.githubusercontent.com/333752169/e56c2780-613a-11eb-8f00-835103e5ab61">

