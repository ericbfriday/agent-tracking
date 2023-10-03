as.agent_groups = {};
as.agent_tags = {};
as.agent_timezones = {};
as.agent_activity = {};
as.handler_activity = {};

as.agent_groups.initChart = function () {
	var data = {
		labels: labels_groups,
		datasets: [
		{
			label: "Weekly Reporting Active Agent Groups",
			borderColor: "#337ab7",
			data: values_groups,
			fill: false
		}
		]
	};

	var ctx = document.getElementById("agent_groups_chart").getContext("2d");
	var myLineChart = new Chart(ctx, {
		type: 'line',
		data: data,

		options: {
			responsive: true,
			maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 75
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
		}
       
	});
};

as.agent_tags.initChart = function () {
	var data = {
		labels: labels_tags,
		datasets: [
		{
			label: "Weekly Reporting Active Agent Tags",
			borderColor: "#337ab7",
			data: values_tags,
			fill: false
		}
		]
	};

	var ctx = document.getElementById("agent_tag_chart").getContext("2d");
	var myLineChart = new Chart(ctx, {
		type: 'line',
		data: data,

		options: {
			responsive: true,
			maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 75
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
		}
	});
};

as.agent_timezones.initChart = function () {
	var data = {
		labels: labels_timezones,
		datasets: [
		{
			label: "Weekly Reporting Active Agent Groups",
			borderColor: "#337ab7",
			data: values_timezones,
			fill: false
		}
		]
	};

	var ctx = document.getElementById("agent_timezone_chart").getContext("2d");
	var myLineChart = new Chart(ctx, {
		type: 'line',
		data: data,

		options: {
			responsive: true,
			maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 75
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
		}
	});
};

as.agent_activity.initChart = function () {
	var data = {
		labels: labels_agent_activity,
		datasets: [
		{
			label: "Weekly Reporting Agent Activity",
			borderColor: "#337ab7",
			data: values_agent_activity,
			fill: false
		}
		]
	};

	var ctx = document.getElementById("agent_activity_chart").getContext("2d");
	var myLineChart = new Chart(ctx, {
		type: 'line',
		data: data,

		options: {
			responsive: true,
			maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 75
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
		}
	});
};

as.handler_activity.initChart = function () {
	var data = {
		labels: labels_handler_activity,
		datasets: [
		{
			label: "Weekly Reporting Handler Activity",
			borderColor: "#337ab7",
			data: values_handler_activity,
			fill: false
		}
		]
	};

	var ctx = document.getElementById("handler_activity_chart").getContext("2d");
	var myLineChart = new Chart(ctx, {
		type: 'line',
		data: data,

		options: {
			responsive: true,
			maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 75
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
		}
	});
};


$(document).ready(function () {
	as.agent_groups.initChart();
    as.agent_tags.initChart();
    as.agent_timezones.initChart();
	as.agent_activity.initChart();
	as.handler_activity.initChart();
});