@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Group Metrics
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('metrics.index') }}">Metrics</a></li>
					<li class="active">Groups</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-widget panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-7">
						<div class="title">New Groups This Month</div>
						<div class="text-huge">{{ $groupstats['new'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-plus fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('group.list') }}">
				<div class="panel-footer">
					<span class="pull-left">View All Groups</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="panel panel-widget panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-7">
						<div class="title">Total Groups</div>
						<div class="text-huge">{{ $groupstats['total'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-secret fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('group.list') }}">
				<div class="panel-footer">
					<span class="pull-left">@lang('app.view_details')</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="panel panel-widget panel-danger">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-7">
						<div class="title">Inactive Groups</div>
						<div class="text-huge">{{ $groupstats['inactive'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-times fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('group.list', ['status' => \Vanguard\Support\Enum\GroupStatus::INACTIVE]) }}">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="panel panel-widget panel-purple">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-7">
						<div class="title">Active Groups</div>
						<div class="text-huge">{{ $groupstats['active'] }}</div>
						<div class="clearfix"></div>
					</div>
					<div class="icon">
						<i class="fa fa-user fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('group.list', ['status' => \Vanguard\Support\Enum\GroupStatus::ACTIVE]) }}">
				<div class="panel-footer">
					<span class="pull-left">@lang('app.view_details')</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default chart">
			<div class="panel-heading">Group History</div>
			<div class="panel-body chart">
				<div>
					<canvas id="myChart" height="503"></canvas>
				</div>
			</div>
		</div>
	</div>
<!--
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Latest Groups</div>
			<div class="panel-body">
				@if (count($latestGroupRegistrations))
				<div class="list-group">
					@foreach ($latestGroupRegistrations as $group)
					<a href="{{ route('group.show', $group->id) }}" class="list-group-item">
						<img class="img-circle" src="{{ url('assets/img/group.jpg') }}">
						<strong>{{ $group->present()->name }}</strong>
						<span class="list-time text-muted small">
							<em>{{ $group->created_at->diffForHumans() }}</em>
						</span>
					</a>
					@endforeach
				</div>
				<a href="{{ route('group.list') }}" class="btn btn-default btn-block">View All Groups</a>
				@else
				<p class="text-muted">@lang('app.no_records_found')</p>
				@endif
			</div>
		</div>
	</div>
-->


</div>

@section('styles')
<style>
	.chart .chart {
		zoom: 1.235;
	}
</style>
@stop

@stop

@section('scripts')
<script>
	var groups = {!! json_encode(array_keys($activeAgents)) !!};
	var active_agents = {!! json_encode(array_values($activeAgents)) !!};
	var active_relays = {!! json_encode(array_values($activeRelayAgents)) !!};
	var trans = {
		chartLabel: "Active Agents/Relays per Group",
	};
</script>
{!! HTML::script('assets/js/chart.min.js') !!}
{!! HTML::script('assets/js/as/group-relay-stats.js') !!}
@stop

