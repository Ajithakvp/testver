<?php
$data = [
	['CR Number', 'hours', 'hospital'],
	['124556', 8, 'Trichy Hospital'],
	[
		'244567',
		24,
		'Kamineni Hospitals
Krishna - AP'
	],
	[
		'456688',
		15,
		'Saveera Institute of Medical Sciences Pvt Ltd
Ananthapur - AP'
	],
	[
		'447889',
		11,
		'Iswarya Health Private Limited
Chennai - TN'
	],
	[
		'474989',
		17,
		'SAHRUDAYA HEALTHCARE PRIVATE LIMITED
Bangalore - KA'
	],
];

$googleChartData = json_encode($data);
?>

<html>

<head>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
		google.charts.load('current', { 'packages': ['corechart'] });
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable(<?php echo $googleChartData; ?>);
			var red=0;
			var orange=0;
			var green=0;

			var view = new google.visualization.DataView(data);
			view.setColumns([0, 1, {
				calc: function (dt, row) {
					var time = dt.getValue(row, 1);
					var colorcol;



					if (time >= 24) {
						colorcol = 'red';
						red++;
					} else if (time > 12 && time < 24) {
						colorcol = 'orange';
						orange++;

					} else if (time > 0 && time < 12) {
						colorcol = 'green';
						green++;

					}

					return colorcol;
				},
				type: 'string',
				role: 'style'
			}, {
					calc: function (dt, row) {
						var tooltipstring = "CR No : " + dt.getValue(row, 0) + "\n" + "Hours : " + dt.getValue(row, 1) + "\n" + "Hospital Name : " + dt.getValue(row, 2) + "\n";
						return tooltipstring; // Display hospital name on hover(tooltip)
					},
					type: 'string',
					role: 'tooltip'
				}]);

			var options = {
				legend: { position: 'none' },
				hAxis: { title: 'CR Number' },
				vAxis: { title: 'Time (hours)' },
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(view, options);


			// console.log(red+"--"+orange+"--"+green);

			// Add custom legend
			var legendDiv = document.createElement('div');
			legendDiv.innerHTML = '<div style="margin-top: 20px;margin-left: 20px;">' +
				'<div style="color: red; display: inline-block; width: 20px;">&#9632;</div>' +
				'<div style="display: inline-block; margin-left: 5px;">Danger  ( '+red+' )</div>' +
				'<div style="color: orange; display: inline-block; margin-left: 20px; width: 20px;">&#9632;</div>' +
				'<div style="display: inline-block; margin-left: 5px;">Warning   ( '+orange+' )</div>' +
				'<div style="color: green; display: inline-block; margin-left: 20px; width: 20px;">&#9632;</div>' +
				'<div style="display: inline-block; margin-left: 5px;">Normal   ( '+green+' )</div>' +
				'</div>';

			document.getElementById('chart_div').appendChild(legendDiv);
		}
	</script>
</head>

<body>
	<div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>

</html>