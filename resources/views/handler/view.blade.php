@extends('layouts.app')

@section('page-title', $handler->present()->name)

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			{{ $handler->present()->name }}
			<small>@lang('app.handler_details')</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('handler.list') }}">@lang('app.handlers')</a></li>
					<li class="active">{{ $handler->present()->name }}</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<div id="edit-group-panel" class="panel panel-default">
			<div class="panel-heading">
				@lang('app.details')
				<div class="pull-right">
					<a href="{{ route('handler.edit', $handler->id) }}" class="edit"
						data-toggle="tooltip" data-placement="top" title="@lang('app.edit_handler')">
						@lang('app.edit')
					</a>
				</div>
			</div>
			<div class="panel-body panel-profile">
				<div class="image">
					<img alt="image" class="img-circle avatar" src="{{ url('assets/img/handler.png') }}">
				</div>
				<div class="name"><strong>{{ $handler->present()->name }}</strong></div>

				<br>

				<table class="table table-hover table-details">
					<thead>
						<tr>
							<th colspan="3">@lang('app.handler_informations')</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>@lang('app.handler_owner')</td>
							<td>{{ $handler->owner }}</td>
						</tr>
						<tr>
							<td>@lang('app.handler_timezone')</td>
							<td>{{ $handler->timezone }}</td>
						</tr>
					</tbody>
				</table>

				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="3">@lang('app.handler_additional_informations')</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>@lang('app.handler_gsf_forum_name')</td>
							<td>{{ $handler->present()->gsf_forum_name }}</td>
						</tr>
						<tr>
							<td>@lang('app.handler_skype_name')</td>
							<td>{{ $handler->present()->skype_name }}</td>
						</tr>
						<tr>
							<td>@lang('app.handler_discord_name')</td>
							<td>{{ $handler->present()->discord_name }}</td>
						</tr>
						<tr>
							<td>@lang('app.handler_status')</td>
							<td>{{ $handler->present()->status }}</td>
						</tr>
						<tr>
							<td>@lang('app.handler_created_at')</td>
							<td>{{ $handler->created_at->format(config('app.date_time_format')) }}</td>
						</tr>
					</tbody>

				</table>
			</div>
		</div>
	</div>



	<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-heading">Agents</div>
			<div class="panel-body">
				<div class="list-group">
					@foreach ($agents as $agent)
					<a href="{{ route('agent.show', $agent->id) }}" class="list-group-item">
						<img class="img-circle" src="../../assets/img/agent.png">
						@if ($agent->status === "Active")

						<span class="label label-success">{{ $agent->status }}</span>
						&nbsp; <strong>{{ $agent->name }}</strong>

						@else

						<span class="label label-danger">{{ $agent->status }}</span>
						&nbsp; <strong>{{ $agent->name }}</strong>

						@endif
						

					</a>
					
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				@lang('app.handler_notes')
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
							<td>{!! $handler->notes !!}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	




</div>

@stop
