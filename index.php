<?php
require('config.inc.php');
require('boot.inc.php');
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
		const sparklineconfig = {
		  type: 'bar',
		  height: '50',
		  barWidth: '3',
		  disableInteraction: true,
		  resize: false,
		  barSpacing: '0',
          chartRangeMax:300,
		  colorMap: ping_range_map,
		  barColor: '#7ace4c'
		}

		

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
		</script>

	</head>

	<body>

	<div class="container" id="main_container">

		<?php
		if(is_array(@$errors)){
			foreach($errors AS $error){
				echo '<div class="alert alert-danger"><div style="font-size: 14px;">'.$error.'</div></div>';
			}
			echo '<a href="?"><button class="btn btn-primary">I FIXED IT. TRY AGAIN</button></a>';
			die();
		}		
		
		include('header.html.php');
		
		?>

		

		

		<!-- INFO -->
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
				<div style="white-space: nowrap;" class="section_title">
					<i class="fa fa-arrow-alt-circle-right"></i> <strong>INFO</strong>
					<div id="sw_rev" class="float-right" style="font-size: 10px; color: #b5b5b5"></div>
				</div> 
				
			</div>
		</div>

		<div class="row ">

			<div class="col-3 text-right"><strong>UPTIME</strong></div>
			<div class="col-3 text-left"><span id="uptimeS" class="moreinfo" moreinfo="help-method.html" style=""></span></a></div>
			<div class="col-3 text-right"><strong>SNR</strong> </div>
			<div class="col-3 text-left"><span id="snr" style=""></span>/9</div>		
			<div class="col-3 text-right"><strong>METHOD</strong></div>
			<div class="col-3 text-left"><span id="gmethod" style=""></span> <a href="javascript://"  onClick="openmodal('html','help-method.html');"><sup><i class="fa fa-info-circle text-muted"></i></sup></a></div>
			<div class="col-3 text-right"><strong></strong> </div>
			<div class="col-3 text-left"><span id="" style=""></span></div>		
			
		</div>	
		
		<!-- THROUGHPUT -->
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
				<div style="white-space: nowrap;" class="section_title">
					<i class="fa fa-file-import"></i> <strong>THROUGHPUT</strong>  
					<a href="javascript://" onClick="resetajax('peak');"><sup style="float: right; margin-top: 5px;" class="badge badge-pill badge-warning">RESET PEAK</sup></a>
				</div> 
			</div>
		</div>

		<div class="row border-bottom">
			<div class="col-3 text-right"><strong style="color: #7a6fbb">DOWN</strong></div>
			<div class="col-4 text-left"><span id="downloadlinkthru" style=""></span></div>
			<div class="col-1 text-right"><strong>PK</strong> </div>
			<div class="col-4 text-left"><span id="maxthroughputdown" style=""></span></div>			
		</div>		
		<div class="row border-bottom">
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
		<!-- LATENCY -->
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
				<div style="white-space: nowrap;" class="section_title">
					<i class="fa fa-arrows-alt-h"></i> <strong>LATENCY</strong>  
					<a href="javascript://" onClick="resetvar('peakPingTracker');"><sup style="float: right; margin-top: 5px;" class="badge badge-pill badge-warning">RESET PEAK: <span id="jspingpeak"></span></sup></a>
				</div> 
			</div>
		</div>

		<div class="row border-bottom">
			<div class="col-3 text-right"><strong>NOW:</strong> </div>
			<div class="col-3 text-left"><div id="latency">--- ms</div></div>
			<div class="col-3 text-right"><strong>3 MIN AVG:</strong> </div>
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
		<div class="row" style="margin-top: 20px;">
			<div class="col-12 <?php echo $_CONFIG['styles']['bg_bars']; ?>">
				<div style="white-space: nowrap;" class="section_title">
					<i class="fa fa-running"></i><strong>&nbsp;SPEED TEST RESULTS:</strong>
				</div> 
			</div>
			<div class="col-3 text-right"><div style="white-space: nowrap;"><strong>&nbsp;DOWN</strong></div> </div>
			<div class="col-4 text-left"><span id="downloadtest" style=""></span></div>
			<div class="col-1 text-right"><div style="white-space: nowrap;"><strong>UP:</strong></div> </div>
			<div class="col-4 text-left"><span id="uploadtest"></span></div>
			<div class="col-12 col-lg-12">
				<small><span style="white-space: nowrap;" id="speedtest" style=""></span></small> 
				<small class="text-muted"> | Runs every 15 mins</small>
			</div>
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
			<div class="col-2 text-left"><span id="fractionObstructed" style=""></span></div>
			<div class="col-7" style="white-space: nowrap;"><strong>&nbsp;DOWNTIME:</strong> <span id="last24hObstructedS" style=""></span><br>
			<div style="margin-top: -5px; font-size: 10px;">&nbsp;&nbsp;&nbsp;due to obstructions in the last 24 hours</div></div>		
			
		</div>

		<div class="row" style="margin-top: 20px; margin-left: -100px;">
			<div class="col-12">
				<div id="canvas-holder" style="width:75vh">
					<canvas id="chart-area"></canvas>
				</div> 
			</div>
		</div>

<!-- Modal -->
<div class="modal fade" id="onlyModal" tabindex="-1" aria-labelledby="onlyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="modal-content">
      
    </div>
  </div>
</div>

	</div>

	
	<script>

	var ajax_speedtest_url = "<?php echo $_CONFIG['ajax']['speed_test']; ?>";
	var ajax_dishy_url = "<?php echo $_CONFIG['ajax']['dishy']; ?>";

	</script>

	<script src="js/site.js"></script>