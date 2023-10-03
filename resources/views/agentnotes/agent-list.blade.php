@extends('layouts.app')

@section('page-title', trans('app.agent_notes'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			@lang('app.agents_notes')
			<small>@lang('app.list_of_agent_notes')</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">@lang('app.agentnotes')</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')

<div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="agents-table-wrapper">
	<table class="table" id="agentnotes">
		<thead>
			<th>@lang('app.agent_name')</th>
			<th>@lang('app.agent_handler')</th>
			<th>@lang('app.agent_owner')</th>
			<th>@lang('app.agent_subject')</th>
			<th>Category</th>
			<th>Priority</th>
			<th>@lang('app.agentcreated_at')</th>
			<th>Duration</th>
			<th class="text-center">@lang('app.action')</th>
		</thead>
		<tbody>
			@if (count($agentNotes))
			@foreach ($agentNotes as $agentnote)
			<tr>
				<td>{{ $agentnote->agent }}</td>
				<td>{{ $agentnote->handler }}</td>
				<td>{{ $agentnote->owner }}</td>
				<td><a href="#" title="{!! $agentnote->notes !!}" data-toggle="tooltip" data-placement="top">{{ $agentnote->subject }}</a></td>
				<td>{{ $agentnote->category }}</td>
				<td>{{ $agentnote->priority }}</td>
				<td>{{ $agentnote->created_at->toDateTimeString() }}</td>
				<td>{{ $agentnote->created_at->diffForHumans() }}</td>
				
				<td class="text-center">
					<a href="{{ route('agentnotes.show', $agentnote->id) }}" class="btn btn-success btn-circle"
						title="View Agent Note" data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-eye-open"></i>
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

	{!! $agentNotes->render() !!}
</div>

@stop

@section('scripts')
<script>
	$(document).ready(function(){
		$('#agentnotes').DataTable( {
			"paging":   false,
			"searching": false,
			"ordering": true,
			"aaSorting": [[ 6, "desc" ]] // Sort by first column descending
		}
		);

	});
</script>

@stop

