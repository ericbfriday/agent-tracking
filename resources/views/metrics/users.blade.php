@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Registered User Metrics
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('metrics.index') }}">Metrics</a></li>
					<li class="active">Users</li>
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
						<div class="title">@lang('app.new_users_this_month')</div>
						<div class="text-huge">{{ $stats['new'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-user-plus fa-5x"></i>
					</div>
				</div>
			</div>
			<a href="{{ route('user.list') }}">
				<div class="panel-footer">
					<span class="pull-left">@lang('app.view_all_users')</span>
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
						<div class="title">@lang('app.total_users')</div>
						<div class="text-huge">{{ $stats['total'] }}</div>
					</div>
					<div class="icon">
						<i class="fa fa-users fa-5x"></i>
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

</div>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default chart">
			<div class="panel-heading">@lang('app.registration_history')</div>
			<div class="panel-body chart">
				<div>
					<canvas id="myChart" height="403"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.latest_registrations')</div>
			<div class="panel-body">
				@if (count($latestRegistrations))
				<div class="list-group">
					@foreach ($latestRegistrations as $user)
					<a href="{{ route('user.show', $user->id) }}" class="list-group-item">
						<img class="img-circle" src="{{ $user->present()->avatar }}">
						<strong>{{ $user->present()->nameOrEmail }}</strong>
						<span class="list-time text-muted small">
							<em>{{ $user->created_at->diffForHumans() }}</em>
						</span>
					</a>
					@endforeach
				</div>
				<a href="{{ route('user.list') }}" class="btn btn-default btn-block">@lang('app.view_all_users')</a>
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
	var users = {!! json_encode(array_values($usersPerMonth)) !!};
	var months = {!! json_encode(array_keys($usersPerMonth)) !!};
	var trans = {
		chartLabel: "New User Accounts per Month",
	};
</script>
{!! HTML::script('assets/js/chart.min.js') !!}
{!! HTML::script('assets/js/as/dashboard-admin.js') !!}
@stop