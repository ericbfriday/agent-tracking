as.agent_stats = {};

as.agent_stats.initChart = function () {
	var data = {
		labels: agents,
		datasets: [
		{
			label: 'Agents Note Activity',
			backgroundColor: '#f49841',
			data: agent_activity,
		},

		]
	};

	var ctx = document.getElementById('myChart').getContext('2d');

	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: data,

		
		options: {
			title: {
				display: true,
				text: trans.chartLabel
			},
			tooltips: {
				mode: 'index',
				intersect: false
			},
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					stacked: false,

					ticks: {
						autoSkip: false,
						maxRotation: 25,
						minRotation: 25,
					},

					gridLines: {
						offsetGridLines: true
					},

					
				}],
				yAxes: [{
					stacked: false,
					ticks: {
						min: 0,
						stepSize: 1,
					},

					gridLines: {
						offsetGridLines: true
					},
				}],
			}
		}
	});
};


$(document).ready(function () {
	as.agent_stats.initChart();
});