<?php
require('config.inc.php');
?>

<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
		<meta name="description" content="Better Than Nothing Web Interface for Dishy">
		<meta name="author" content="Chuck Lavoie">

		<title>Better Than Nothing Web Interface</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
		<!-- Bootstrap core JavaScript -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		
		<!-- Google Fonts -->	
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

		<!-- Charts.js -->
		<script src="https://www.chartjs.org/dist/2.9.4/Chart.min.js"></script>
		<script src="https://www.chartjs.org/samples/latest/utils.js"></script>

		<!-- Custom styles for this template -->
		<link  rel="stylesheet" href="css/site.css"></link>

		

	</head>

	<body>

	<div class="container" id="main_container">

		<div class="row" style="margin-bottom: 10px; margin-left: 20px;">
			
			<div class="col col-12">
				<center>
					<span class="badge badge-pill badge-success float-left" id="state"></span>
					<img src="img/sl.png" id="starlinklogo">
					
					<div id="pill_beta">
						<span class="badge badge-pill badge-primary"  ;" onClick="location='/chuck.php'">BETA</span>
						<!--<span class="badge badge-pill badge-danger" style="margin-left: 0px; ;" onClick="location='/chuck.php'">LAT 44.8</span>-->
						
					</div>
					<div id="tagline">
						<small style="width: 100%;"><em>"Better Than Nothing Statistics"</em> &nbsp;&nbsp;&nbsp;<span class="text-muted"></span></small>
					</div>
					<div id="user">
						
						<h1 class=" float-right">
							<sup>
								<small>
									<small id="latency">--- ms</small>
								</small>
							</sup>
						</h1>

						<h1 id="username"><?php echo $_CONFIG["username"]; ?></h1>
						
					</div>
										
				</center>
			</div>
		
		</div>

		

		<!-- INFO -->
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
				<div style="white-space: nowrap;" class="section_title">
					<i class="fa fa-arrow-alt-circle-right"></i> <strong>INFO</strong>
				</div> 
			</div>
		</div>

		<div class="row ">
			<div class="col-3 text-right"><strong>UPTIME</strong></div>
			<div class="col-3 text-left"><span id="uptimeS" style=""></span></div>
			<div class="col-3 text-right"><strong>SNR</strong> </div>
			<div class="col-3 text-left"><span id="snr" style=""></span>/9</div>			
		</div>	
		
		<!-- THROUGHPUT -->
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>"><div style="white-space: nowrap;" class="section_title"><i class="fa fa-file-import"></i> <strong>THROUGHPUT</strong></div> </div>
		</div>
		<div class="row border-bottom">
			<div class="col-3 text-right"><strong>DOWN</strong></div>
			<div class="col-4 text-left"><span id="downloadlinkthru" style=""></span></div>
			<div class="col-1 text-right"><strong>PK</strong> </div>
			<div class="col-4 text-left"><span id="maxthroughputdown" style=""></span></div>			
		</div>		
		<div class="row border-bottom">
			<div class="col-3 text-right"><strong>UP</strong></div>			
			<div class="col-4 text-left"><span id="uploadlinkthru"></span></div>			
			<div class="col-1 text-right"><strong>PK</strong> </div>
			<div class="col-4 text-left"><span id="maxthroughputup"></span></div>
		</div>
		
		
		<!-- THROUGHPUT -->
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>"><div style="white-space: nowrap;" class="section_title"><i class="fa fa-running"></i><strong>&nbsp;SPEED TEST RESULTS:</strong></div> </div>
			<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;DOWN</strong></div> </div>
			<div class="col-4 text-left"><span id="downloadtest" style=""></span></div>
			<div class="col-1 text-right"><div style="white-space: nowrap;"><strong>UP:</strong></div> </div>
			<div class="col-4 text-left"><span id="uploadtest"></span></div>
			<div class="col-12 col-lg-12"><small><span style="white-space: nowrap;" id="speedtest" style=""></span></small> <small class="text-muted"> | Runs every 15 mins</small></div>
			<!--<div class="col-12 col-lg-12"><small><i class="fa fa-clock"></i> <span style="white-space: nowrap;" id="nextspeedtest" style=""></span></small></div>-->
		</div>


		<!-- WORKING ON THIS UPTIME
		<div class="row fade " style="margin-top: 20px; display: none;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>"><div style="white-space: nowrap;"><i class="fa fa-running"></i><strong>&nbsp;UPTIME (LAST 5 MINS)</strong></div> </div>
			<div class="col-12" style="overflow-wrap: break-word; font-size: 6px;">
			⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚪⚪⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫	⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚪⚪⚪⚪⚪⚪⚪⚪⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫⚫
			</div>
		</div>
		-->

		<!-- OBSTRUCTIONS -->
		<div class="row" style="margin-top: 20px;">
			
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
				<div style="white-space: nowrap;" class="section_title">
					<i class="fa fa-tree"></i><strong>&nbsp;OBSTRUCTIONS</strong>
				</div> 
			</div>

			<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;FRACTION</strong></div> </div>
			<div class="col-3 text-left"><span id="fractionObstructed" style=""></span></div>
			<div class="col-6" style="white-space: nowrap;"><strong>&nbsp;DOWNTIME:</strong> <span id="last24hObstructedS" style=""></span><br><div style="margin-top: -5px; font-size: 10px;">&nbsp;&nbsp;&nbsp;due to obstructions in the last 24 hours</div></div>		
		</div>

		<div class="row" style="margin-top: 20px; margin-left: -100px;">
			<div class="col-12">
				<div id="canvas-holder" style="width:75vh">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
		</div>


	</div>

	
	<script>

	var ajax_speedtest_url = "<?php echo $_CONFIG['ajax']['speed_test']; ?>";
	var ajax_dishy_url = "<?php echo $_CONFIG['ajax']['dishy']; ?>";

	</script>

	<script src="js/site.js"></script>