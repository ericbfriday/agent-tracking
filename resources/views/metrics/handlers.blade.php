@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Handler Metrics
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('metrics.index') }}">Metrics</a></li>
					<li class="active">Handlers</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

<div class="row">

	<div class="col-lg-3 col-md-6">
		<div class="panel panel-widget panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-7">
						<div class="title">Total Handlers</div>
						<div class="text-huge">{{ $handlerstats['total'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-secret fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('handler.list') }}">
				<div class="panel-footer">
					<span class="pull-left">@lang('app.view_details')</span>
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
						<div class="title">Active Handlers</div>
						<div class="text-huge">{{ $handlerstats['active'] }}</div>
						<div class="clearfix"></div>
					</div>
					<div class="icon">
						<i class="fa fa-user fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('handler.list', ['status' => \Vanguard\Support\Enum\HandlerStatus::ACTIVE]) }}">
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
	<div class="col-md-9">
		<div class="panel panel-default chart">
			<div class="panel-heading">Handler's Active/Inactive Agents</div>
			<div class="panel-body chart">
				<div>
					<canvas id="myChart" height="403"></canvas>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Latest Handlers</div>
			<div class="panel-body">
				@if (count($latestHandlerRegistrations))
				<div class="list-group">
					@foreach ($latestHandlerRegistrations as $handler)
					<a href="{{ route('handler.show', $handler->id) }}" class="list-group-item">
						<img class="img-circle" src="{{ url('assets/img/handler.png') }}">
						<strong>{{ $handler->present()->name }}</strong>
						<span class="list-time text-muted small">
							<em>{{ $handler->created_at->diffForHumans() }}</em>
						</span>
					</a>
					@endforeach
				</div>
				<a href="{{ route('handler.list') }}" class="btn btn-default btn-block">View All Handlers</a>
				@else
				<p class="text-muted">@lang('app.no_records_found')</p>
				@endif
			</div>
		</div>
	</div>
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
	var active_agents = {!! json_encode(array_values($activeAgents)) !!};
	var inactive_agents = {!! json_encode(array_values($inactiveAgents)) !!};
	var handlers = {!! json_encode(array_keys($activeAgents)) !!};
	var trans = {
		chartLabel: "Handlers Inactive/Active Agents",
	};
</script>
{!! HTML::script('assets/js/chart.min.js') !!}
{!! HTML::script('assets/js/as/handler-stats.js') !!}
@stop