@extends('layouts.app')

@section('page-title', trans('app.agents'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			My Agents
			<small>- list of all my currently (active) assigned agents.</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">All Agents</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')

<div class="row tab-search">
	<div class="col-md-2">
		<a href="{{ route('agent.create') }}" class="btn btn-success" id="add-agent">
			<i class="glyphicon glyphicon-plus"></i>
			@lang('app.add_agent')
		</a>
	</div>
	<div class="col-md-5"></div>
</div>

<div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="agents-table-wrapper">
	<table class="table" id="agents">
		<thead>
			<th>@sortablelink('name')</th>
			<th>@sortablelink('handler')</th>
			<th>@sortablelink('group', 'Reporting Group')</th>
			<th>@sortablelink('logger_id', 'Relay Identifier')</th>
			<th>@sortablelink('bh_forum_name', 'BH Forum Name')</th>
			<th>@sortablelink('discord_name', 'Discord Name')</th>
			<th>@sortablelink('updated_at', 'Last Updated')</th>
			<th>@sortablelink('last_contacted', 'Last Contacted')</th>
			<th>@sortablelink('logger_active', 'Relay Status')</th>
			<th>@sortablelink('status')</th>

			<th class="text-center">@lang('app.action')</th>
		</thead>
		<tbody>
			@if (count($agents))
			@foreach ($agents as $agent)
			<tr>
				<td><a href="{{ route('agent.show', $agent->id) }}" title="Go to {{ $agent->name}}"
						data-toggle="tooltip" data-placement="top">{{ $agent->name }}</a></td>
				<td>{{ $agent->handler }}</td>
				<td>{{ $agent->group }}</td>
				<td>{{ $agent->logger_id }}</td>
				<td>{{ $agent->bh_forum_name }}</td>
				<td>{{ $agent->discord_name }}</td>
				<td>{{ $agent->updated_at->diffForHumans() }}</td>
				<td>{{ \Carbon\Carbon::parse($agent->last_contacted)->diffForHumans() }}</td>
				<td>
					@if ($agent->logger_active === "Active")
					<span class="label label-success }}">{{ trans("app.{$agent->logger_active}") }}</span>
					@else
					<span class="label label-warning }}">{{ trans("app.{$agent->logger_active}") }}</span>
					@endif
				</td>
				<td>
					<span class="label label-{{ $agent->present()->labelClass }}">{{ trans("app.{$agent->status}") }}</span>
				</td>
				<td class="text-center">
					<a href="{{ route('agent.show', $agent->id) }}" class="btn btn-success btn-circle"
						title="@lang('app.view_agent')" data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-eye-open"></i>
					</a>
					<a href="{{ route('agent.edit', $agent->id) }}" class="btn btn-primary btn-circle edit" title="@lang('app.edit_agent')"
						data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-edit"></i>
					</a>
					<a href="{{ route('agent.toggle_relay', $agent->id) }}" class="btn btn-info btn-circle edit" title="Activate/Deactivate Relay"
						data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-repeat"></i>
					</a>
					<a href="{{ route('agent.contacted', $agent->id) }}" class="btn btn-warning btn-circle edit" title="Agent Contacted"
						data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-ok"></i>
					</a>
				</td>
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

@stop

@section('scripts')
<script>
	$("#status").change(function () {
		$("#agents-form").submit();
	});
</script>

<script>
	$(document).ready(function(){
		$('#agent').DataTable( {
			"paging":   false,
			"searching": false
		}
		);

	});
</script>
@stop
