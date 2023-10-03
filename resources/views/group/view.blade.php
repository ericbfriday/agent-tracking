@extends('layouts.app')

@section('page-title', $group->present()->group)

@section('content')

<div class="row">
	<div class="col-md-12">
		<h1 class="page-header">
			{{ $group->present()->group }}
			<small>@lang('app.group_details')</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('group.list') }}">@lang('app.groups')</a></li>
					<li class="active">{{ $group->present()->group }}</li>
					<li><a href="{{ route('group.update-esi', ['group' => $group->id, 'name' => $group->group]  ) }}">Update ESI</a></li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')

<div class="row col-md-12">
	<div class="col-md-3">
		<div id="edit-group-panel" class="panel panel-default">
			<div class="panel-heading">
				@lang('app.details')
				<div class="pull-right">
					<a href="{{ route('group.edit', $group->id) }}" class="edit"
						data-toggle="tooltip" data-placement="top" title="@lang('app.edit_group')">
						@lang('app.edit')
					</a>
				</div>
			</div>
			<div class="panel-body panel-profile">
				<div class="image">
					<img alt="image" class="img-circle avatar" src="{{ url('assets/img/group.jpg') }}">
				</div>
				<div class="name"><strong>{{ $group->present()->group }}</strong></div>

				<br>

				<table class="table table-hover table-details">
					<thead>
						<tr>
							<th colspan="3">@lang('app.group_informations')</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>@lang('app.group_home')</td>
							<td>{{ $group->home }}</a></td>
						</tr>
					</tbody>
				</table>

				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="3">@lang('app.group_additional_informations')</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>@lang('app.group_type')</td>
							<td>{{ $group->present()->type }}</td>
						</tr>
						<tr>
							<td>@lang('app.group_status')</td>
							<td>{{ $group->present()->status }}</td>
						</tr>
						<tr>
							<td>@lang('app.group_created_at')</td>
							<td>{{ $group->created_at->format(config('app.date_time_format')) }}</td>
						</tr>
						<tr>
							<td>@lang('app.group_updated_at')</td>
							<td>{{ $group->updated_at->diffForHumans() }}</td>
						</tr>
					</tbody>

				</table>
			</div>
		</div>
	</div>


	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.reporting_agents')</div>
			<div class="panel-body">
				<div class="list-group">
					@foreach ($agents as $agent)
					@if ($group->group === $agent->group)
					<a href="{{ route('agent.show', $agent->id) }}" class="list-group-item">
						<div>
							&nbsp; <strong>Agent Name: {{ $agent->name }}</strong><br>
							&nbsp; <strong>Logger ID: {{ $agent->logger_id }}</strong><br>
							&nbsp; <strong>Relay Status: {{ $agent->logger_active }}</strong><br>
						</div>
						<span class="list-time text-muted small">
							<em>Last Contact : {{ $agent->updated_at->diffForHumans() }}</em>
						</span>
					</a>
					@endif
					@endforeach
				</div>
				<a href="{{ route('agent.list') }}" class="btn btn-default btn-block">@lang('app.view_all_agents')</a>
			</div>
		</div>
	</div>

		<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				@lang('app.group_notes')
			</div>
			<div class="panel-body">
				<table class="table notes">
					<thead>
						<tr>
							<th>@lang('app.notes')</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{!! $group->notes !!}</td>
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div

@stop
