@extends('layouts.app')

@section('page-title', 'Spymaster Weekly Reports')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Spymaster Weekly Report for: <b>Week ({{ $report->week_number }}) - {{ $report->month }}-{{ $report->year }}</b>
			<small></small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('spymaster_reports.list') }}">Spymaster Weekly Reports</a></li>
					<li class="active">Week ({{ $report->week_number }}) - {{ $report->month }}-{{ $report->year }}</li>
				</ol>
			</div>

		</h1>
	</div>
</div>


<div class="row col-md-12">
	<div class="col-md-3">
		<div id="edit-user-panel" class="panel panel-default">
			<div class="panel-heading">
				<b>Weekly Report For Week ({{ $report->week_number }}) - {{ $report->month }}-{{ $report->year }}</b>
			</div>
			<div class="panel-body panel-profile">
				<br>
				<table class="table table-hover table-details">
					<thead>
						<tr>
							<th colspan="3">Information</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Period</td>
							<td>{{ $report->start_date}} - {{ $report->end_date }}</td>
						</tr>
						
						<tr>
							<td>Agents</td>
							<td>{{ $report_data['agents']['active'] }} / {{ $report_data['agents']['total'] }} - (<b>{{ number_format($report_data['agents']['percentage_active'],2) }}%)</b></td>
						</tr>

						<tr>
							<td>Handlers</td>
							<td>{{ $report_data['handlers']['active'] }} / {{ $report_data['handlers']['total'] }} - (<b>{{ number_format($report_data['handlers']['percentage_active'],2) }}%</b>)</td>
						</tr>

                        <tr>
							<td>Active Groups</td>
							<td>{{ $report_data['groups']['active'] }} / {{ $report_data['groups']['total'] }} - (<b>{{ number_format($report_data['groups']['percentage_active'],2) }}%</b>)</td>
						</tr>

                        <tr>
							<td>Created</td>
							<td>{{ $report->created_at }}</td>
						</tr>

                        <tr>
							<td>Updated</td>
							<td>{{ $report->updated_at }}</td>
						</tr>
					</tbody>					
				</table>
			</div>
		</div>
	</div>

    <div class="col-md-9">
		<div class="panel panel-default">

			<div class="panel-heading">
				<b>Weekly Reporting Details</b>
			</div>
			<div class="panel-body">

                <p>Weekly reports are generated hourly and updated throughout the week until the end of the week at midnight.
                <p>This report (<b>Wk: {{ $report->week_number }} - {{ $report->month }}</b>) will be marked as completed on the <b>{{ $report->end_date }}</b>, {{ \Carbon\Carbon::parse($report->end_date)->diffForHumans() }}. 
                <p>Once the week is over, the metrics within this report will be recorded for future reference.
                <p>
                <p>Each Report Summarises the following;
                <ul>
                    <li>Agents & Agent Activity</li>
                    <li>Handlers & Handler Activity</li>
                    <li>Groups</li>
                    <li>Active Groups & Reported Agents</li>
                    <li>Active Timezones & Reported Agents</li>
                    <li>Active Tags & Reported Agents</li>
                </ul>
            </div>
		</div>
	</div>
</div>
<div class="row col-md-12">
    <div class="col-md-3">
        <div class="panel panel-default agent_activity">
			<div class="panel-heading">
				<b>Agent Activity</b>
			</div>
			<div class="panel-body">
                   <div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="spymaster-reports-table-wrapper">
                        <table class="table" id="agent_activity">
                            <thead>
                                <th style="vertical-align: middle;">Agent Name</th>
                                <th style="vertical-align: middle;">Activity</th>
                            </thead>
                            <tbody>
                            @if(count($report_data['agent_activity']))
                                @foreach ($report_data['agent_activity'] as $x)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $x['name'] }}</td>
                                    <td style="vertical-align: middle;">{{ $x['agent_activity'] }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>  
			</div>
		</div>
    </div>

	<div class="col-md-9">
		<div class="panel panel-default agent_activity_chart">

			<div class="panel-heading">
				<b>Agent Activity Reporting Chart</b>
			</div>
			<div class="panel-body chart">

				<div>
					<canvas id="agent_activity_chart" height="514"></canvas>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="row col-md-12">
    <div class="col-md-3">
        <div class="panel panel-default handler_activity">
			<div class="panel-heading">
				<b>Handler Activity</b>
			</div>
			<div class="panel-body">
                   <div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="spymaster-reports-table-wrapper">
                        <table class="table" id="handler_activity">
                            <thead>
                                <th style="vertical-align: middle;">Agent Name</th>
                                <th style="vertical-align: middle;">Activity</th>
                            </thead>
                            <tbody>
                            @if(count($report_data['handler_activity']))
                                @foreach ($report_data['handler_activity'] as $x)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $x['name'] }}</td>
                                    <td style="vertical-align: middle;">{{ $x['handler_activity'] }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>  
			</div>
		</div>
    </div>

	<div class="col-md-9">
		<div class="panel panel-default handler_activity_chart">

			<div class="panel-heading">
				<b>Handler Activity Reporting Chart</b>
			</div>
			<div class="panel-body chart">

				<div>
					<canvas id="handler_activity_chart" height="514"></canvas>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="row col-md-12">
    <div class="col-md-3">
        <div class="panel panel-default active_groups">
			<div class="panel-heading">
				<b>Active Groups Allocated to Agents</b>
			</div>
			<div class="panel-body">
                   <div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="spymaster-reports-table-wrapper">
                        <table class="table" id="active_groups">
                            <thead>
                                <th style="vertical-align: middle;">Group Name</th>
                                <th style="vertical-align: middle;">Reporting Agents</th>
                            </thead>
                            <tbody>
                            @if(count($report_data['active_groups']))
                                @foreach ($report_data['active_groups'] as $x)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $x['name'] }}</td>
                                    <td style="vertical-align: middle;">{{ $x['active_agents'] }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>  
		    </div>
        </div>
    </div>
    <div class="col-md-9">
		<div class="panel panel-default agent_groups_chart">

			<div class="panel-heading">
				<b>Agent Groups Reporting Chart</b>
			</div>
			<div class="panel-body chart">

				<div>
					<canvas id="agent_groups_chart" height="514"></canvas>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="row col-md-12">
    <div class="col-md-3">
        <div class="panel panel-default active_tags">
			<div class="panel-heading">
				<b>Active Tags Allocated to Agents</b>
			</div>
			<div class="panel-body">
                   <div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="spymaster-reports-table-wrapper">
                        <table class="table" id="active_tags">
                            <thead>
                                <th style="vertical-align: middle;">Tag Name</th>
                                <th style="vertical-align: middle;">Reporting Agents</th>
                            </thead>
                            <tbody>
                            @if(count($report_data['active_tags']))
                                @foreach ($report_data['active_tags'] as $x)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $x['name'] }}</td>
                                    <td style="vertical-align: middle;">{{ $x['active_agents'] }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>  
			</div>
		</div>
    </div>

    <div class="col-md-9">
		<div class="panel panel-default agent_tag_chart">

			<div class="panel-heading">
				<b>Agent Tag Reporting Chart</b>
			</div>
			<div class="panel-body chart">

				<div>
					<canvas id="agent_tag_chart" height="514"></canvas>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="row col-md-12">
    <div class="col-md-3">
        <div class="panel panel-default active_timezones">
			<div class="panel-heading">
				<b>Active Timezones Allocated to Agents</b>
			</div>
			<div class="panel-body">
                   <div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="spymaster-reports-table-wrapper">
                        <table class="table" id="active_timezones">
                            <thead>
                                <th style="vertical-align: middle;">Timezone</th>
                                <th style="vertical-align: middle;">Reporting Agents</th>
                            </thead>
                            <tbody>
                            @if(count($report_data['active_timezones']))
                                @foreach ($report_data['active_timezones'] as $x)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $x['name'] }}</td>
                                    <td style="vertical-align: middle;">{{ $x['active_agents'] }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>  
			</div>
		</div>
    </div>

	<div class="col-md-9">
		<div class="panel panel-default agent_timezone_chart">

			<div class="panel-heading">
				<b>Agent Timezone Reporting Chart</b>
			</div>
			<div class="panel-body chart">

				<div>
					<canvas id="agent_timezone_chart" height="514"></canvas>
				</div>

			</div>
		</div>
	</div>
</div>






@stop

@section('scripts')
<script>
// Initialisation with Config
$('#agent_activity').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
	pageLength: 10,
	order: [[0, 'asc']]
})

$('#handler_activity').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
	pageLength: 10,
	order: [[0, 'asc']]
})

$('#active_groups').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
	pageLength: 10,
	order: [[0, 'asc']]
})

$('#active_tags').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
	pageLength: 10,
	order: [[0, 'asc']]
})

$('#active_timezones').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
	pageLength: 10,
	order: [[0, 'asc']]
})

var labels_groups = {!! json_encode(array_keys($agentGroupChart)) !!};
var values_groups = {!! json_encode(array_values($agentGroupChart)) !!};
var labels_tags = {!! json_encode(array_keys($agentTagChart)) !!};
var values_tags = {!! json_encode(array_values($agentTagChart)) !!};
var labels_timezones = {!! json_encode(array_keys($agentTimezoneChart)) !!};
var values_timezones = {!! json_encode(array_values($agentTimezoneChart)) !!};

var labels_agent_activity = {!! json_encode(array_keys($agentActivityChart)) !!};
var values_agent_activity = {!! json_encode(array_values($agentActivityChart)) !!};
var labels_handler_activity = {!! json_encode(array_keys($handlerActivityChart)) !!};
var values_handler_activity = {!! json_encode(array_values($handlerActivityChart)) !!};
</script>
{!! HTML::script('assets/js/chart.min.js') !!}
{!! HTML::script('assets/js/charts/spymaster-report-weekly.js') !!}

@stop

@section('styles')
<style>
	.chart {
		zoom: 1.235;
	}
</style>
@stop
