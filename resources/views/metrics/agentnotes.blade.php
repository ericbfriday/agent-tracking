@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Agent Metrics
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">Metrics / Agents</li>
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
						<div class="title">New Agents This Month</div>
						<div class="text-huge">{{ $agentstats['new'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-plus fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('agent.list') }}">
				<div class="panel-footer">
					<span class="pull-left">View All Agents</span>
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
						<div class="title">Total Agents</div>
						<div class="text-huge">{{ $agentstats['total'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-secret fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('user.list') }}">
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
						<div class="title">Inactive Agents</div>
						<div class="text-huge">{{ $agentstats['inactive'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-times fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('agent.list', ['status' => \Vanguard\Support\Enum\AgentStatus::INACTIVE]) }}">
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
						<div class="title">Active Agents</div>
						<div class="text-huge">{{ $agentstats['active'] }}</div>
						<div class="clearfix"></div>
					</div>
					<div class="icon">
						<i class="fa fa-user fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('agent.list', ['status' => \Vanguard\Support\Enum\AgentStatus::ACTIVE]) }}">
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
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Agent History</div>
			<div class="panel-body">
				<div>
					<canvas id="myChart" height="403"></canvas>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Latest Agents</div>
			<div class="panel-body">
				@if (count($latestAgentRegistrations))
				<div class="list-group">
					@foreach ($latestAgentRegistrations as $agent)
					<a href="{{ route('agent.show', $agent->id) }}" class="list-group-item">
						<img class="img-circle" src="{{  url('assets/img/agent.png') }}">
						<strong>{{ $agent->present()->name }}</strong>
						<span class="list-time text-muted small">
							<em>{{ $agent->created_at->diffForHumans() }}</em>
						</span>
					</a>
					@endforeach
				</div>
				<a href="{{ route('agent.list') }}" class="btn btn-default btn-block">@lang('app.view_all_agents')</a>
				@else
				<p class="text-muted">@lang('app.no_records_found')</p>
				@endif
			</div>
		</div>
	</div>


</div>

@stop

@section('scripts')
<script>
	var users = {!! json_encode(array_values($agentsPerMonth)) !!};
	var months = {!! json_encode(array_keys($agentsPerMonth)) !!};
	var trans = {
		chartLabel: "{{ trans('app.agent_history')  }}",
		new: "New",
		user: "Agent",
		users: "Agents"
	};
</script>
{!! HTML::script('assets/js/chart.min.js') !!}
{!! HTML::script('assets/js/as/dashboard-admin.js') !!}
@stop