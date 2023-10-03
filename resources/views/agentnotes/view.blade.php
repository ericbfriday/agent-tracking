@extends('layouts.app')

@section('page-title', 'Agent Note')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Subject: {{ $agentNotes->present()->subject }}
			
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">{{ $agentNotes->present()->agent }}</li>
					<li class="active">{{ $agentNotes->present()->subject }}</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		<div id="edit-group-panel" class="panel panel-default">
			<div class="panel-heading">
				Agent

			</div>
			<div class="panel-body panel-profile">

				<div class="name"><strong>{{ $agentNotes->present()->agent }}</strong></div>

				<br>

				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="3">Agent & Note Information</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>@lang('app.agent_handler')</td>
							<td>{{ $agentNotes->present()->handler }}</td>
						</tr>
						<tr>
							<td>@lang('app.agent_created_at')</td>
							<td>{{ $agentNotes->created_at }} - ({{ $agentNotes->created_at->diffForHumans() }})</td>
						</tr>

						<tr>
							<td>Owner / Created By</td>
							<td>{{ $agentNotes->present()->owner }}</td>
						</tr>

						<tr>
							<td>Priority</td>
							<td>{{ $agentNotes->present()->priority }}</td>
						</tr>

						<tr>
							<td>Category</td>
							<td>{{ $agentNotes->present()->category }}</td>
						</tr>

						<tr>
							<td>Notify Handler</td>
							<td>
								@if ($agentNotes->notify_handler === "Yes")
								<span class="label label-success }}">{{ $agentNotes->notify_handler }}</span>
								@else
								<span class="label label-danger }}">{{ $agentNotes->notify_handler }}</span>
								@endif
							</td>
						</tr>

						<tr>
							<td>Notify Spymaster</td>
							<td>
								@if ($agentNotes->notify_spymaster === "Yes")
								<span class="label label-success }}">{{ $agentNotes->notify_spymaster }}</span>
								@else
								<span class="label label-danger }}">{{ $agentNotes->notify_spymaster }}</span>
								@endif
							</td>
						</tr>




					</tbody>

				</table>
			</div>

		</div>
	</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Contact Note Information
			</div>
			<div class="panel-body">
				<table class="table notes">
					<thead>
						<tr>
							<th>Note Detail</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{!! $agentNotes->notes !!}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>



</div>

@stop


