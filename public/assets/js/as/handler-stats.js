as.handler_stats = {};

as.handler_stats.initChart = function () {
	var data = {
		labels: handlers,
		datasets: [
		{
			label: 'Active Agents',
			backgroundColor: '#4286f4',
			data: active_agents,
		},

		{
			label: 'Inactive Agents',
			backgroundColor: '#f44141',
			data: inactive_agents,
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
					stacked: true,

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
					stacked: true,
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
	as.handler_stats.initChart();
});