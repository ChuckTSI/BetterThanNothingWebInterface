# BetterThanNothingWebInterface
A Web Interface for Seeing Data from Dishy in the Better Than Nothing Beta by Starlink

This will show you most basic stats but will give you a visual chart/compass showing obstructions.

Some notes:

<ul>
  <li> This is a hot mess and developed on Ubuntu Machine w/ LAMP, GRPCurl and speedtest-cli
  <li> I used CDNs for JQuery,Bootstrap, etc. May break at any time.
  <li> Take a look at the config.inc.php file in the root folder.
  <li> Make sure your web server is on the network that dishy is connected to
</ul>

The are almost no comments and bad coding practices.
Good luck!

Future Vision:
Downtime History (using MySQL) 
Using RAM Disk to avoid excessive writes to SSDs

Hoping they give us a little more data like Satellite name(s) connected, (lat,long of Sat OR which wedge it's in) and Est distance to work with. 
Would like to do flyover tracing.
Just saying Mr Dishy Developers :)

