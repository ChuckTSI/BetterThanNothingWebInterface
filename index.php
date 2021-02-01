<?php
require('config.inc.php');
require('boot.inc.php');
?>

<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

		<!-- Sparklines -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>

		<!-- Custom styles for this template -->
		<link  rel="stylesheet" href="css/site.css"></link>	

		<script>
		
		var maxGraphS = <?php echo $_CONFIG["max_graph_seconds"]; ?>;
			
		var ping_range_map = $.range_map({
			'1:59': '#28a745',
			'60:149': '#ffc107',
			'150:1000': 'red'
		})

		var ping_range_map2 = $.range_map({
			'1:59': 'red'
		})


		var speedtesthistory_range_map = ['#ec77f9','#7a6fbb'];

		// PING
		const sparklineconfig = {
		  type: 'bar',
		  height: '50',
		  barWidth: '3',
		  disableInteraction: false,
		  resize: false,
		  barSpacing: '0',
          chartRangeMax:300,
		  colorMap: ping_range_map,
		  barColor: '#7ace4c'
		}

		
		// DOWN
		const sparklineconfig2 = {
		  type: 'line',
		  height: '50',
		  barWidth: '1',
		  disableInteraction: true,
		  resize: false,
		  fillColor: 'transparent',
		  barSpacing: '0',
		  chartRangeMax: 150,
		  lineColor: '#ec77f9',
			  spotColor: false,
			  spotRadius: 0
		}

		// UP
		const sparklineconfig3 = {
		  type: 'line',
		  height: '50',
		  barWidth: '1',
		  disableInteraction: true,
		  resize: false,
		  fillColor: 'transparent',
		  barSpacing: '0',
		  chartRangeMax: 150,
		  lineColor: '#7a6fbb',
			  spotColor: false,
			  spotRadius: 0
		}


		 // SPEEDTEST HISTORY
		const sparklineconfig4 = {
		  type: 'bar',
		  height: '50',
		  barWidth: '4',
		  disableInteraction: false,
		  resize: false,
		  barSpacing: '0',
          chartRangeMax:150,
		  stackedBarColor: speedtesthistory_range_map
		}
		</script>

	</head>

	<body>

		<div class="container" id="main_container">

			<!-- HEADER -->
			<div class="row">	
				
			
				<div class="col col-4">					
					<span class="fa-stack float-right" style="position: absolute; top: 15px; left: 120px; font-size: 18px;">
					  <i class="fas fa-satellite fa-stack-1x"></i>
					  <i class="fas fa-ban fa-stack-2x fade" style="color:Tomato" id="nosat"></i>
					</span>
					<div style="position: absolute; top: 50px; left: 110px;" class="" id="obstruction_icon">
						<i class="fas fa-tree" style="font-size: 28px;"></i>
					</div>
					<img src="img/sl.png" id="starlinklogo" style="margin-top: 0px;">
					<span class="badge badge-pill badge-success" id="state">CONNECTED</span>
				</div>

				<div class="col col-8">
					<div style="position: absolute; top: 10px; right: 10px;"><a href="javascript://" onClick="pause_it()" id="pause_button" class="nocolor"><i class="fa fa-pause"></i> </a></div>
					<span class="badge badge-pill badge-primary"  style="position: absolute; bottom: 50px; right: 10px;" onClick="location='?<?php echo time(); ?>'">BETA</span>
					<h1 id="username2" style="position: absolute; bottom: -5px; right: 10px;">CHUCK<strong>TSI</strong></h1>
					<div style="position: absolute; bottom: 45px; right: 70px;"><small style="width: 100%;"><em>"Better Than Nothing"</em></small></div>
				</div>
			
			</div>
			
			
			<!-- THROUGHPUT -->
			<div class="row  border-top" style="margin-top: 10px;" id="throughput">

				<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
					<div style="white-space: nowrap;" class="section_title">
						<i class="fa fa-info-circle"></i> <strong>INFO</strong>
						<div id="sw_rev" class="float-right" style="font-size: 10px; color: #b5b5b5"></div>
					</div> 					
				</div>
			</div>
			<div class="row" style="font-size: 90%; margin-top: 10px;">
				<div class="col-3 text-right"><strong>UPTIME</strong></div>
				<div class="col-3 text-left"><span id="uptimeS" class="moreinfo" moreinfo="help-method.html" style=""></span></a></div>
				<div class="col-3 text-right"><strong>SNR</strong> </div>
				<div class="col-3 text-left"><span id="snr" style=""></span>/9</div>		
				<div class="col-3 text-right"><strong>METHOD</strong></div>
				<div class="col-3 text-left"><span id="gmethod" style=""></span> <a href="javascript://"  onClick="openmodal('html','help-method.html');"><sup>?</sup></a></div>
				<div class="col-3 text-right"><strong></strong> </div>
				<div class="col-3 text-left"><span id="" style=""></span></div>	

			</div>

			

			
			<!-- LATENCY -->
			<div class="row  border-top" style="margin-top: 20px;">
				<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
					<div style="white-space: nowrap;" class="section_title">
						<i class="fa fa-arrows-alt-h"></i> <strong>LATENCY</strong>  
						<small><a href="javascript://" onClick="resetvar('peakPingTracker');" style="float: right; margin-top: 2px;" >RESET PEAK: <span id="jspingpeak"></span></a></small>
					</div> 
				</div>
			</div>

			<div class="row border-bottom"  style="font-size: 90%; margin-top: 10px;">
				<div class="col-3 text-right"><strong>NOW</strong> </div>
				<div class="col-3 text-left"><div id="latency">--- ms</div></div>
				<div class="col-3 text-right"><strong>3 MIN AVG</strong> </div>
				<div class="col-3 text-left"><div id="avglatency">--- ms</div></div>
				<div class="col-12 text-left">
					<div style="height: 50px; position: relative;">
						<div id="sparklinedash" style="opacity: 0.5; position: absolute; z-index: 1; height: 50px;">
							<span class="bar"></span>
						</div>	
					</div>
				</div>
			</div>

			<!-- THROUGHPUT -->
			<div class="row  border-top" style="margin-top: 20px;">
				<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
					<div style="white-space: nowrap;" class="section_title">
						<i class="fa fa-file-import"></i> <strong>THROUGHPUT</strong>  
						<small><a href="javascript://" onClick="resetajax('peak');" style="float: right; margin-top: 2px;" >RESET PEAK: <span id="jspingpeak"></span></a></small>
					</div> 
				</div>
			</div>

			<div class="row border-bottom"  style="font-size: 90%; margin-top: 10px;">
				<div class="col-3 text-right"><strong style="color: #7a6fbb">DOWN</strong></div>
				<div class="col-4 text-left"><span id="downloadlinkthru" style=""></span></div>
				<div class="col-1 text-right"><strong>PK</strong> </div>
				<div class="col-4 text-left"><span id="maxthroughputdown" style=""></span></div>			
			</div>		
			<div class="row border-bottom"  style="font-size: 90%;">
				<div class="col-3 text-right"><strong style="color: #ec77f9;">UP</strong></div>			
				<div class="col-4 text-left"><span id="uploadlinkthru"></span></div>			
				<div class="col-1 text-right"><strong>PK</strong> </div>
				<div class="col-4 text-left"><span id="maxthroughputup"></span></div>
			</div>
			<div class="row border-bottom">
			<div class="col-12 text-left">
					<div style="height: 50px; position: relative;">
						<div id="sparklinedash2" style="position: absolute; z-index: 2; height: 50px;">
							<span class="line"></span>
						</div>

						<div id="sparklinedash3" style="position: absolute; z-index: 2; height: 50px;">
							<span class="line"></span>			
						</div>
					</div>
				</div>
			</div>

			

			<!-- SPEEDTEST -->
			<div class="row  border-top" style="margin-top: 20px;">
				<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
					<div style="white-space: nowrap;" class="section_title">
						<i class="fa fa-running"></i><strong>&nbsp;SPEED TEST RESULTS:</strong>
					</div> 
				</div>
			</div>
			
			<div class="row"  style="font-size: 90%; margin-top: 10px;">
				<div class="col-3 text-right"><div style="white-space: nowrap;"><strong style="color: #7a6fbb">DOWN</strong></div> </div>
				<div class="col-4 text-left"><span id="downloadtest" style=""></span></div>
				<div class="col-1 text-right"><div style="white-space: nowrap;"><strong style="color: #ec77f9;">UP</strong></div> </div>
				<div class="col-4 text-left"><span id="uploadtest"></span></div>
				<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;AVG</strong></div> </div>
				<div class="col-4 text-left"><span id="downloadtestavg" style=""></span></div>
				<div class="col-1 text-right"><div style="white-space: nowrap;"><strong>AVG:</strong></div> </div>
				<div class="col-4 text-left"><span id="uploadtestavg"></span></div>
				
			</div>
			<div class="row "  style="font-size: 90%;">
				<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;LASTRUN</strong></div> </div>
				<div class="col-9 text-left"><small><span style="white-space: nowrap;" id="speedtest" style=""></span> | Runs every 15 mins  |  .:| Total Tests: <strong><span id="total_speed_tests"></span></strong>|:.  </small> </div>
				<div class="col-3 text-right">&nbsp;</div>
				<div class="col-9">					
					<small class="text-muted">
					HISTORY 
					(<a href="<?php echo $_CONFIG["web_data_path"].'/'.$_CONFIG['results']['speed_test_history_basename']; ?>">DOWNLOAD CSV</a>)
					(<a href="javascript://" onClick="$('#history_speed_test_graph_container').toggle();">TOGGLE GRAPH</a>)
					</small> 
				</div>
				<!--<div class="col-12 col-lg-12"><small><i class="fa fa-clock"></i> <span style="white-space: nowrap;" id="nextspeedtest" style=""></span></small></div>-->
			</div>
			<div class="row" style="margin-top: 20px;" id="history_speed_test_graph_container">
				<div class="col-12 text-left">		
					<div style="height: 50px; position: relative; opacity: 0.9;">
					<div id="sparklinedash4" style="position: absolute; z-index: 2; height: 50px;">
						<span class="line"></span>			
					</div>					
					</div>
				</div>
				<div class="col-2 border-top border-right border-left text-left"><small><?php echo date("gA",strtotime('-24 hours')); ?></small></div>
				<div class="col-2 border-top border-right text-center"><small><?php echo date("gA",strtotime('-19 hours')); ?></small></div>
				<div class="col-2 border-top border-right text-center"><small><?php echo date("gA",strtotime('-14 hours')); ?></small></div>
				<div class="col-2 border-top border-right text-center"><small><?php echo date("gA",strtotime('-9 hours')); ?></small></div>
				<div class="col-2 border-top border-right text-center"><small><?php echo date("gA",strtotime('-4 hours')); ?></small></div>
				<div class="col-2 border-top text-right border-right"><small>NOW</small></div>

			</div>
			
			<!-- OBSTRUCTIONS -->
			<div class="row border-top" style="margin-top: 20px;">
			
				<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
					<div style="white-space: nowrap;" class="section_title">
						<i class="fa fa-tree"></i><strong>&nbsp;OBSTRUCTIONS</strong>
						<small><a href="javascript://" onClick="resetajax('obs');" style="float: right; margin-top: 2px;" >RESET CHANGES</a></small>
					</div> 
				</div>
			</div>
			
			<div class="row border-bottom"  style="font-size: 90%; margin-top: 10px;">
				<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;FRACTION</strong></div> </div>
				<div class="col-2 text-left"><span id="fractionObstructed" style=""></span></div>
				<div class="col-7" style="white-space: nowrap;"><strong>&nbsp;DOWNTIME:</strong> <span id="last24hObstructedS" style=""></span></div>
				<!--<br><div style="margin-top: -5px; font-size: 10px;">&nbsp;&nbsp;&nbsp;due to obstructions in the last 24 hours</div>-->
				<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;CHANGES</strong></div></div>
				<div class="col-7 text-left"><span id="fractionObstructedCount" style=""></span> 
					<a href="javascript://" onClick="play_obstructions()" id="pause_obs_playback_button" title="Playback changes" class="badge badge-pill badge-info"><i class="fa fa-play" style="font-size: 10px;"></i> </a> 
					<a href="<?php echo $_CONFIG["web_data_path"].'/'.$_CONFIG['results']['obstruction_log_basename']; ?>" title="Download CSV" class="badge badge-pill badge-info"><i class="fa fa-download" style="font-size: 10px;"></i> </a> 
					<a href="javascript://" onClick="live_obstructions()" id="live_obs_button" class="badge badge-pill badge-success fade">RETURN TO LIVE VIEW</a>
				</div>	
				
			</div>


			

			<div class="progress fade" style="margin-top: 10px;" id="playback_obs_perc_container">
			  <div  id="playback_obs_perc" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<div style="position: absolute; font-size: 14px !important;" id="obsdatetime" style=""></div>
		
			<div class="row" style="margin-top: 20px;">
				<div class="col-12">
					<div id="canvas-holder" style="width: 800px; margin-left: -150px;">
						<canvas id="chart-area"></canvas>
					</div> 
				</div>
				</div>
			</div>

			<!-- Modal Used For Info -->
		<div class="row">
			<div class="modal fade" id="onlyModal" tabindex="-1" aria-labelledby="onlyModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content" id="modal-content">
				  
				</div>
			  </div>
			</div>
		</div>


		</div>


		


	</body>

	<script>

	var ajax_speedtest_url = "<?php echo $_CONFIG['ajax']['speed_test']; ?>";
	var ajax_speedtest_history_url = "<?php echo $_CONFIG['ajax']['speed_test_history']; ?>";
	var ajax_dishy_url = "<?php echo $_CONFIG['ajax']['dishy']; ?>";

	</script>

	<script src="js/site.js"></script>
</html>