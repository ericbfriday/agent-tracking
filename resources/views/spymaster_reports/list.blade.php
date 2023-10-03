@extends('layouts.app')

@section('page-title', 'Spymaster Weekly Reports')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Spymaster Weekly Reports
			<small>- ATS weekly reports, click a report for more details.</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">Spymaster Weekly Reports</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')

<div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="spymaster-reports-table-wrapper">
	<table class="table" id="spymaster_reports">
		<thead>
			<th style="vertical-align: middle;">View Report</th>
			<th style="vertical-align: middle;">Start Date</th>
			<th style="vertical-align: middle;">End Date</th>
			<th style="vertical-align: middle;">Active Agents</th>
			<th style="vertical-align: middle;">Active Handlers</th>
			<th style="vertical-align: middle;">Active Groups</th>
			<th style="vertical-align: middle;">Created</th>
			<th style="vertical-align: middle;">Last Updated</th>
		</thead>
		<tbody>
			@if (count($reports))
			@foreach ($reports as $r)
			<tr>
				<td style="vertical-align: middle;"><a href="{{ route('spymaster_reports.view', $r->end_date) }}">Week: ({{ $r->week_number }}) : {{ $r->month }}-{{$r->year}}</a></td>
				<td style="vertical-align: middle;">{{ $r->start_date }}</td>
                <td style="vertical-align: middle;">{{ $r->end_date }}</td>
                <td style="vertical-align: middle;">{{ $r->active_agents }}</td>
                <td style="vertical-align: middle;">{{ $r->active_handlers }}</td>
                <td style="vertical-align: middle;">{{ $r->active_groups }}</td>
                <td style="vertical-align: middle;">{{ $r->created_at->diffForhumans() }}</td>
                <td style="vertical-align: middle;">{{ $r->updated_at->diffForhumans() }}</td>
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
// Initialisation with Config
$('#spymaster_reports').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
    dom: 'Qfrtip',
	pageLength: 100,
	order: [[0, 'desc']]
})
</script>
@stop