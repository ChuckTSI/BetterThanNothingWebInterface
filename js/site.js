var obstructed = 1;

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
};

function bytes_to_megabits(bits){	
	/*
	var  units = bytes / 2500;
	var Mb = (units * 0.0191) / 10 ; // 2500 Bytes = 0.0191 Megabits;
	return Mb.toFixed(2)+' Mbps';
	*/
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

			   if(data.dishGetStatus.downlinkThroughputBps != ""){
					var downspeed = bytes_to_megabits(data.dishGetStatus.downlinkThroughputBps);
			   } else {
					var downspeed = "--";
			   }
				if(data.dishGetStatus.uplinkThroughputBps != ""){
					var upspeed = bytes_to_megabits(data.dishGetStatus.uplinkThroughputBps);
			   } else {
					var upspeed = "--";
			   }
			   $("#downloadlinkthru").text(downspeed);
			   $("#uploadlinkthru").text(upspeed);
			   $("#maxthroughputdown").text(bytes_to_megabits(data.dishGetStatus.maxspeeds.down));
			   $("#maxthroughputup").text(bytes_to_megabits(data.dishGetStatus.maxspeeds.up));
			   if(data.dishGetStatus.state == "CONNECTED"){
				 $("#state").addClass('badge-success');
				 $("#state").removeClass('badge-danger'); 
				 $("#state").html('<i class="fas fa-satellite-dish"></i> '+data.dishGetStatus.state);
			   } else {
				 $("#state").addClass('badge-danger');
				 $("#state").removeClass('badge-success');
				 $("#state").text(data.dishGetStatus.state);
			   }

			  
			   if(data.dishGetStatus.popPingLatencyMs){
					var latency = data.dishGetStatus.popPingLatencyMs.toFixed();
					if(latency < 40){
						$("#latency").css('color','green');
					} else if(latency < 60){
						$("#latency").css('color','orange');
					} else if(latency >= 60){
						$("#latency").css('color','red');
					}
				 $("#latency").text(latency+' ms');
			   } else {
					$("#latency").text('--- ms');
			   }
				$("#fractionObstructed").text((data.dishGetStatus.obstructionStats.fractionObstructed*100).toFixed(2)+'%');
				if(obstructed != "" && obstructed != data.dishGetStatus.obstructionStats.last24hObstructedS){
					obstructed = data.dishGetStatus.obstructionStats.last24hObstructedS;
					$("#obstruction_icon").removeClass("fade");
				} 
				if(obstructed == data.dishGetStatus.obstructionStats.last24hObstructedS){
					$("#obstruction_icon").addClass("fade");
				}
				$("#last24hObstructedS").text(format_sec(data.dishGetStatus.obstructionStats.last24hObstructedS));
				$("#uptimeS").text(format_sec(data.dishGetStatus.deviceState.uptimeS));
				$("#snr").text(data.dishGetStatus.snr);
				wedgeFractionObstructedDataSet(data.dishGetStatus.obstructionStats.wedgeFractionObstructed);
				//console.log(config.data.datasets);
				
				
		}
	});
	setTimeout(get_dishy,1000);
}

function obstruction_update(){
	window.myPolarArea.update();
	setTimeout(obstruction_update,5000);
}

setTimeout(obstruction_update,100);

function get_speedtest(){
	$.ajax({ 
		type: 'GET', 
		url: ajax_speedtest_url , 
		dataType: 'json',
		success: function (data) { 
				//console.log(data)
			   $("#downloadtest").html(data.speeds.down);
				$("#uploadtest").html(data.speeds.up);
				$("#speedtest").html(data.speeds.mtime);
				//$("#nextspeedtest").html('<strong>Next Run</strong>: '+data.speeds.next);
			
		}
	});
	setTimeout(get_speedtest,900000); // Every 15 Mins.
	
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

get_dishy();
get_speedtest();