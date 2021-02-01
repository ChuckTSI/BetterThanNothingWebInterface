var paused = false;
var obstructed = 1;
var uptimeTracker = 1;
var uptimeRepeatCounter = 0;
var peakPingTracker = 1;
const sparkpingline_data = []
const sparkuploadline_data = []
const sparkdownloadline_data = []
const sparkspeedtesthistoryline_data = []


// This updates the chart with Obstruction Data
var wedgeFractionObstructedDataSet = function(obj) {
	config.data.datasets[0].data = obj;	
};	

/*
backgroundColor: [
	color(chartColors.red).alpha(0.5).rgbString(),
	color(chartColors.orange).alpha(0.5).rgbString(),
	color(chartColors.yellow).alpha(0.5).rgbString(),
	color(chartColors.green).alpha(0.5).rgbString(),
	color(chartColors.blue).alpha(0.5).rgbString(),
],*/

var chartColors = window.chartColors;
var color = Chart.helpers.color;
var config = {
	data: {
		datasets: [{
			data: [
				0,0,0,0,0,0,0,0,0,0,0,0	
			],					
			label: 'Obstructions (1 = 100%)' // for legend
		}],
		labels: [
			'N-NNE',
			'NNE-NEE',
			'NEE-E',
			'E-ESE',
			'ESE-ESS',
			'ESS-S',
			'S-SWS',
			'SWS-SWW',
			'SWW-W',
			'W-WNW',
			'WNW-WNN',
			'WNN-N'
		]
	},
	options: {		
		tooltips: {
			enabled: false
		},
		startAngle: 30,
		responsive: true,
		legend: {
			display: false,
			position: 'right',
		},
		title: {
			display: true,
			text: 'Due North'
		},
		scale: {
			ticks: {
				beginAtZero: true
			},
			reverse: false
		},
		animation: {
			animateRotate: false,
			animateScale: true
		}
	}
};

window.onload = function() {
	var ctx = document.getElementById('chart-area');
	window.myPolarArea = Chart.PolarArea(ctx, config);

	$(".moreinfo").on('click', function(event){
		 event.stopPropagation();
		 event.stopImmediatePropagation();
		 var thisclicked = $(this).attr('moreinfo');
		 console.log(thisclicked);
		 openmodal('html',thisclicked)
	});

	

};




function bytes_to_megabits(bits){	
	var Mb = bits/1048576;
	return Mb.toFixed(2)+' Mbps';
}

function bytes_to_megabits(bits){	
	var Mb = bits/1048576;
	return Mb.toFixed(2)+' Mbps';
}

function formatBytes(bytes,decimals) {
   if(bytes == 0) return '0 Bytes';
   var k = 1024,
		 dm = decimals || 0,
	   sizes = ['Bytes', 'Kbps', 'Mbps', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
	   i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}


function format_sec(time) {   
	// Hours, minutes and seconds
	var hrs = ~~(time / 3600);
	var mins = ~~((time % 3600) / 60);
	var secs = ~~time % 60;

	// Output like "1:01" or "4:03:59" or "123:03:59"
	var ret = "";
	if (hrs > 0) {
		ret += "" + hrs + "h:" + (mins < 10 ? "0" : "");
	}
	ret += "" + mins + "m:" + (secs < 10 ? "0" : "");
	ret += "" + secs+'s';
	return ret;
}

var timer_get_dishy;

function get_dishy(){

	$.ajax({ 
		type: 'GET', 
		url: ajax_dishy_url, 
		dataType: 'json',
		success: function (data) { 
				
			if(data.dishGetStatus.hasOwnProperty('downlinkThroughputBps')){
				//data.dishGetStatus.state = "UNRESPONSIVE";
			} else {
				data.dishGetStatus.state = "DL UNRESPONSIVE";
			}

			if(data.dishGetStatus.hasOwnProperty('uplinkThroughputBps')){
				//data.dishGetStatus.state = "UNRESPONSIVE";
			} else {
				data.dishGetStatus.state = "UL UNRESPONSIVE";
			}

			$("#sw_rev").text(data.dishGetStatus.deviceInfo.softwareVersion)

			if(isNaN(data.dishGetStatus.downlinkThroughputBps)){
				var downspeed = "--";
			} else {
				var downspeed = bytes_to_megabits(data.dishGetStatus.downlinkThroughputBps);
			}

			if(isNaN(data.dishGetStatus.uplinkThroughputBps)){
				var upspeed = "--";
			} else {
				var upspeed = bytes_to_megabits(data.dishGetStatus.uplinkThroughputBps);
			}

		   //console.log('DS:'+downspeed+'   US:'+upspeed);

		   //#####################################################################
		   // HEADER
			if(data.dishGetStatus.state == "CONNECTED"){
			 $("#state").addClass('badge-success');
			 $("#state").removeClass('badge-danger'); 
			 $("#state").html('<i class="fas fa-satellite-dish"></i> '+data.dishGetStatus.state);
			  $("#nosat").addClass("fade");
		   } else {
			 $("#state").addClass('badge-danger');
			 $("#state").removeClass('badge-success');
			 $("#state").text(data.dishGetStatus.state);
			 $("#nosat").removeClass("fade");
		   }

		   if(data.dishGetStatus.popPingLatencyMs){
				
				/*
				For competitive online gaming
				Ookla says players should be in "winning" shape with latency or ping of 59ms or less, 
				and "in the game" with latency or ping of up to 129ms
				*/
				
				var latency = data.dishGetStatus.popPingLatencyMs.toFixed();

				if(latency < 60){
					$("#latency").css('color','green');
				} else if(latency < 130){
					$("#latency").css('color','orange');
				} else if(latency >= 130){
					$("#latency").css('color','red');
				}

				if(parseInt(latency) > parseInt(peakPingTracker)){	
					peakPingTracker = latency;						
				}

				$("#jspingpeak").text(peakPingTracker+'ms')
				sparklineconfig.chartRangeMax = peakPingTracker
				$("#latency").text(latency+' ms');

				if(sparkpingline_data.length > maxGraphS){
					sparkpingline_data.shift();
				}		
				var latency_sum = 0;
				for( var i = 0; i < sparkpingline_data.length; i++ ){
					latency_sum += parseInt( sparkpingline_data[i], 10 ); //don't forget to add the base
				}
				var latency_avg = (latency_sum/sparkpingline_data.length).toFixed();
				$("#avglatency").text(latency_avg+' ms');
				
				/*if(latency_avg < 60){
					sparklineconfig.barColor = 'green';
				} else if(latency_avg < 130){
					sparklineconfig.barColor = 'orange';
				} else if(latency_avg >= 130){
					sparklineconfig.barColor = 'red';
				}*/
				
				//console.log(`The sum is: ${latency_sum}. The average is: ${latency_avg}.`);
				sparkpingline_data.push(latency)
				$('#sparklinedash').sparkline(sparkpingline_data, sparklineconfig)

		   } else {
				$("#latency").text('--- ms');
		   }


			//#####################################################################
			// INFO
			if(data.dishGetStatus.method == "CLI"){
				if(uptimeTracker != data.dishGetStatus.deviceState.uptimeS){
					uptimeTracker = data.dishGetStatus.deviceState.uptimeS
					$("#updatenotrunning").remove();
					uptimeRepeatCounter = 0;
				} else {
					uptimeRepeatCounter++;
					if($("#updatenotrunning").length < 1 && uptimeRepeatCounter > 2){
						$("#main_container").prepend('<div class="alert alert-danger" id="updatenotrunning"><div style="font-size: 14px;">It seems as though your <i>starlink.update.sh</i> is not running. This message will go away once you fix the issue.</div></div>');
					}
				}
			}
			$("#uptimeS").text(format_sec(data.dishGetStatus.deviceState.uptimeS));
			$("#snr").text(data.dishGetStatus.snr);
			
			$("#gmethod").text(data.dishGetStatus.method);


			//#####################################################################
			// THROUGHPUT

			$("#downloadlinkthru").text(downspeed);				
			$("#uploadlinkthru").text(upspeed);	
			
			var maxthroughdown = bytes_to_megabits(data.dishGetStatus.maxspeeds.down);
			var maxthroughup = bytes_to_megabits(data.dishGetStatus.maxspeeds.up);


			if(downspeed == "--"){
				sparkline_downspeed = 0;
			} else {
				sparkline_downspeed = parseFloat(downspeed.match(/[\d\.]+/));
			}

			if(upspeed == "--"){
				sparkline_upspeed = 0;
			} else {
				sparkline_upspeed = parseFloat(upspeed.match(/[\d\.]+/));
			}
			
			// UPLOAD CHART
			
			// Set the max range of the chart of top recorded speed.
			sparklineconfig2.chartRangeMax = parseFloat(maxthroughup.match(/[\d\.]+/))

			//console.log("UP"+sparkline_upspeed+" "+sparkline_downspeed);
			sparkuploadline_data.push(sparkline_upspeed)		
			if(sparkuploadline_data.length > maxGraphS){
				sparkuploadline_data.shift();
			}					
			$('#sparklinedash2').sparkline(sparkuploadline_data, sparklineconfig2)			

			// DOWNLOAD CHART
			sparklineconfig3.chartRangeMax = parseFloat(maxthroughdown.match(/[\d\.]+/))
			sparkdownloadline_data.push(sparkline_downspeed)	

			if(sparkdownloadline_data.length >  maxGraphS){
				sparkdownloadline_data.shift();
			}					
			$('#sparklinedash3').sparkline(sparkdownloadline_data, sparklineconfig3)

			$("#maxthroughputdown").html('<div title="'+data.dishGetStatus.maxspeeds.down_time+'">'+maxthroughdown+'</div>');
			$("#maxthroughputup").html('<div title="'+data.dishGetStatus.maxspeeds.up_time+'">'+maxthroughup+'</div>');


			//#####################################################################
			// OBSTRUCTIONS
		   
			$("#fractionObstructed").text((data.dishGetStatus.obstructionStats.fractionObstructed*100).toFixed(2)+'%');
			if(obstructed != "" && obstructed != data.dishGetStatus.obstructionStats.last24hObstructedS){
				obstructed = data.dishGetStatus.obstructionStats.last24hObstructedS;
				$("#obstruction_icon").removeClass("fade");
			} 
			if(obstructed == data.dishGetStatus.obstructionStats.last24hObstructedS){
				$("#obstruction_icon").addClass("fade");
			}
			
			var twentyFourHoursS = 3600*24;
			if(data.dishGetStatus.deviceState.uptimeS < twentyFourHoursS){
				var obstructionUptime = data.dishGetStatus.deviceState.uptimeS
			} else {
				var obstructionUptime= twentyFourHoursS
			}
			
			var obstructionDowntime = data.dishGetStatus.obstructionStats.last24hObstructedS/obstructionUptime;
			$("#last24hObstructedS").text(format_sec(data.dishGetStatus.obstructionStats.last24hObstructedS)+ ' ('+obstructionDowntime.toFixed(3)+'%)');	
			if(obstruction_play_status == false){
				wedgeFractionObstructedDataSet(data.dishGetStatus.obstructionStats.wedgeFractionObstructed);
			}
			//console.log(config.data.datasets);

				
				
		}
	});	
	
	timer_get_dishy = setTimeout(get_dishy,1000);
}

function pause_it(){

	if(paused == false){
		paused = true;		
		clearTimeout(timer_get_dishy);
		clearTimeout(timer_get_speedtest);
		console.log('paused')
		$('#pause_button').html('<i class="fa fa-play"></i>');
	} else {
		paused = false;
		get_dishy();
		get_speedtest();
		console.log('unpaused')
		$('#pause_button').html('<i class="fa fa-pause"></i>');
	}

	
}



var timer_get_speedtest
function get_speedtest(){
	$.ajax({ 
		type: 'GET', 
		url: ajax_speedtest_url , 
		dataType: 'json',
		success: function (data) { 
				//console.log(data)
			   $("#downloadtest").html(data.speeds.down);
				$("#uploadtest").html(data.speeds.up);
				$("#downloadtestavg").html(data.speeds.avg_down);
				$("#uploadtestavg").html(data.speeds.avg_up);
				$("#total_speed_tests").html(data.speeds.total_tests);
				$("#speedtest").html(data.speeds.mtime);
				//$("#nextspeedtest").html('<strong>Next Run</strong>: '+data.speeds.next);			
		}
	});
	$.ajax({ 
		type: 'GET', 
		url: ajax_speedtest_history_url , 
		dataType: 'json',
		success: function (data) { 

			var speed_test_history_items = [];
			var speed_test_history_length = data.length;

			var max_speed_test_history_length;

			if(speed_test_history_length > 186){
				max_speed_test_history_length = 186;
			} else {
				max_speed_test_history_length = speed_test_history_length;
			}
			
			// 560 is pixels width of UI
			speed_test_history_bar_width = 560/speed_test_history_length;
			
			$.each(data,function(index, values){
				var stib  = []; // Temp Array to format UP/DOWN
				stib.push(Math.round(values[2].replace(" Mbps","")));
				stib.push(Math.round(values[1].replace(" Mbps","")));

				if(index > max_speed_test_history_length){
					speed_test_history_items.shift();
				} 

				speed_test_history_items.push(stib);

			})

			sparklineconfig4.barWidth = speed_test_history_bar_width;
			
			$('#sparklinedash4').sparkline(speed_test_history_items, sparklineconfig4)	
		}
	});

	timer_get_speedtest = setTimeout(get_speedtest,60000); // Every 15 Mins.
	
}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

var obstruction_obj;
var obstruction_play_key = 0;
var timer_play_obstructions;
var obstruction_play_status = false;
var perc_per_play_obstructions;

function play_obstructions(){

	var total_items = obstruction_obj.length;
	perc_per_play_obstructions = 100/total_items;

	if(total_items < obstruction_play_key){
		clearTimeout(timer_play_obstructions);
		obstruction_play_key = 0;
		obstruction_play_status = false;
		
	} else {
		$.each(obstruction_obj, function( index, values ) {

			 if(index == obstruction_play_key && values != ''){
				$("#pause_obs_playback_button").addClass('fade');
				$("#live_obs_button").removeClass('fade');
				$("#playback_obs_perc_container").removeClass('fade');
				obstruction_play_status = true;
				var t = values.split(",");
				s = t.slice(1);
				wedgeFractionObstructedDataSet(s);				  
				obstruction_play_key++;
				var newwidth = perc_per_play_obstructions*(index+2);
				$("#playback_obs_perc").css('width',newwidth+'%');
				var milliseconds = t[0] * 1000 
				var dateObject = new Date(milliseconds)
				var humanDateFormat = dateObject.toLocaleString();
				$("#obsdatetime").html('<div class="badge badge-pill badge-info">RECORDED</div> '+humanDateFormat)
				setTimeout(function(){window.myPolarArea.update()},100);
				timer_play_obstructions = setTimeout(play_obstructions,400);
				return false; 
			 }

			 if(values == ''){
				clearTimeout(timer_play_obstructions);
				obstruction_play_key = 0;
				obstruction_play_status = false;
				$("#pause_obs_playback_button").removeClass('fade');
			 }
		 });
	}	
}

function live_obstructions(){

	obstruction_play_status = false;
	obstruction_update();
	obstruction_play_key = 0;
	clearTimeout(timer_play_obstructions);
		
	$("#pause_obs_playback_button").removeClass('fade');
	$("#live_obs_button").addClass('fade');
	$("#playback_obs_perc_container").addClass('fade');
	$("#obsdatetime").html('<div class="badge badge-pill badge-success" style="position: absolute; font-size: 14px; top: -20px;">LIVE</div>');
}

function obstruction_update(){
	if(obstruction_play_status == false){
		window.myPolarArea.update();
		setTimeout(obstruction_update,1000);
		$("#obsdatetime").html('<div class="badge badge-pill badge-success" style="position: absolute; font-size: 14px; top: -20px;">LIVE</div>');
	}
}


var timer_get_obstructions_records
function obstructions_records(){
	if(obstruction_play_status == false){
		//if(console.log(obstruction_play_key)
		$.ajax({ 
			type: 'GET', 
			url: 'ajax/json/obstruction_playback.php' , 
			dataType: 'json',
			success: function (data) { 
				//console.log(data.length)
				obstruction_obj = data.obs;
				$("#fractionObstructedCount").text(data.obs.length);
			}
		});
	}

	

	timer_get_obstructions_records = setTimeout(obstructions_records,5000); // Every 5 seconds

}

function resetajax(toreset){
	if(toreset == 'peak'){
		$.ajax({ 
			type: 'GET', 
			url: 'ajax/json/reset_maxspeed.php' , 
			dataType: 'json',
			success: function (data) { 
					//console.log(data)			   
					//$("#nextspeedtest").html('<strong>Next Run</strong>: '+data.speeds.next);				
			}
		});
	}
	
}

function openmodal(folder,modal_template){

		$.ajax({ 
			type: 'GET', 
			url: 'ajax/'+folder+'/'+modal_template , 
			dataType: 'html',
			success: function (data) { 
					$("#modal-content").html(data);	
					$("#onlyModal").modal("show");
			}, 
			error: function (data) { 
					alert('errror');
			}, 
		});
	

	
}

function resetvar(whichvar){
	if(whichvar == 'peakPingTracker'){
		peakPingTracker = 1;
	}
}

get_dishy();
obstructions_records();
setTimeout(obstruction_update,500);
get_speedtest();

//$("#history_speed_test_graph_container").css('display','none');


