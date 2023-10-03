as.group_relay_stats = {};

as.group_relay_stats.initChart = function () {
	var data = {
		labels: groups,
		datasets: [
		{
			label: 'Active Agents',
			backgroundColor: '#f44141',
			data: active_agents,
		},

		{
			label: 'Active Relays',
			backgroundColor: '#4286f4',
			data: active_relays,
		}
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
	as.group_relay_stats.initChart();
});