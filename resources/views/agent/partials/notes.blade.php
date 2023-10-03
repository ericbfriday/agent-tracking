<div class="row tab-search">
	<div class="col-md-1">
		<a href="{{ route('agentnotes.create', $agent->id) }}" class="btn btn-primary" id="add-agent">
			<i class="glyphicon glyphicon-plus"></i>
			Create Agent Activity Note
		</a>
	</div>		
</div>
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


@section('scripts')


<script>
// Initialisation with Config
$('#agentnotes').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
    dom: 'Qfrtip',
	pageLength: 20,
	order: [[6, 'desc']]
})
</script>


@stop

