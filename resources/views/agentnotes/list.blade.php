@extends('layouts.app')

@section('page-title', trans('app.agent_notes'))

@section('content')

<div class="row">
	<div class="col-md-12">
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

<div class="row col-md-12">
<div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="agents-table-wrapper">
	<table class="table" id="agentnotes">
		<thead>
			<th> Agent Name</th>
			<th> Handler</th>
			<th> Agent Owner</th>
			<th> Subject</th>
			<th> Category</th>
			<th> Priority</th>
			<th> Created</th>
			@role('Spymaster')
			<th class="text-center">@lang('app.action')</th>
			@endrole
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
				<td>{{ $agentnote->created_at }}</td>
				@role('Spymaster')
				<td class="text-center">
					<a href="{{ route('agentnotes.show', $agentnote->id) }}" class="btn btn-success btn-circle"
						title="View Agent Note" data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-eye-open"></i>
					</a>
				</td>
				@endrole
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

@stop

@section('scripts')
<!--
<script>
	$("#category").change(function () {
		$("#agents-form").submit();
	});

	$("#priority").change(function () {
		$("#agents-form").submit();
	});

	$("#handlers").change(function () {
		$("#agents-form").submit();
	});

	$("#agents").change(function () {
		$("#agents-form").submit();
	});
	$("#owner").change(function () {
		$("#agents-form").submit();
	});
</script>
-->

<script>
// Initialisation with Config
$('#agentnotes').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
    dom: 'Qfrtip',
	pageLength: 100,
	order: [[6, 'desc']]
})
</script>


@stop

