@extends('layouts.app')

@section('page-title', trans('app.agents'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			@lang('app.agents')
			<small>@lang('app.list_of_registered_agents')</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">@lang('app.agents')</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')


<div class="alert alert-warning">
        <ul>
                <li>ATS is undergoing some feature changes, agents do not need allocated reporting group/timezone as this is now carried out by the tagging feature after an agent has been created.</li>
                <li>Existing Agents can be updated and tagged as required.</li>
				<li>Agent Reporting Group/Timezone will be removed once the transition is completed and all Agents have been updated.</li>
                <li>Please tag as required agents groups/timezones/tags - agents can now have multiples of each.</li>
        </ul>
</div>

<div class="row tab-search">
	<div class="col-md-1">
		<a href="{{ route('agent.create') }}" class="btn btn-success" id="add-agent">
			<i class="glyphicon glyphicon-plus"></i>
			@lang('app.add_agent')
		</a>
	</div>		
</div>

<div class="table-responsive top-border-table table datatable compact table-condensed table-hover" id="agents-table-wrapper">
	<table class="table" id="agents">
		<thead>
			<th style="vertical-align: middle;">Name</th>
			<th style="vertical-align: middle;">Handler</th>
			<th style="vertical-align: middle;">Assigned Agent Groups</th>
			<th style="vertical-align: middle;">Agent Timezones</th>
			<th style="vertical-align: middle;">Relay Identifier</th>
			<th style="vertical-align: middle;">Discord Name</th>
			<th style="vertical-align: middle;">Last Updated</th>
			<th style="vertical-align: middle;">Last Contacted</th>
			<th style="vertical-align: middle;">Created At</th>
			<th style="vertical-align: middle;">Relay Status</th>
			<th style="vertical-align: middle;">Status</th>
			
			<th style="vertical-align: middle;">Assigned Agent Tags</th>
			<th style="vertical-align: middle;" class="text-center">Action</th>
		</thead>
		<tbody>
			@if (count($agents))
			@foreach ($agents as $agent)
			<tr>
				<td style="vertical-align: middle;"><a href="{{ route('agent.show', $agent->id) }}">{{ $agent->name }}</a></td>
				<td style="vertical-align: middle;">{{ $agent->handler }}</td>

				@if (count($agent->groups))
				<td style="vertical-align: middle; width: 200px;">
				@foreach ($agent->groups as $g)
				<span class="label label-primary">{{ $g->group->group }}</span>
				@endforeach
				</td>
				@else
				<td style="vertical-align: middle;"></td>
				@endif

				@if (count($agent->timezones))
				<td style="vertical-align: middle; width: 200px;">
				@foreach ($agent->timezones as $t)
				<span class="label label-{{ $t->timezone->colour_tag }}">{{ $t->timezone->name }}</span>
				@endforeach
				</td>
				@else
				<td style="vertical-align: middle;"></td>
				@endif

				<td style="vertical-align: middle;">{{ $agent->logger_id }}</td>
				<td style="vertical-align: middle;">{{ $agent->discord_name }}</td>
				<td style="vertical-align: middle;">{{ $agent->updated_at }}</td>
				@if($agent->last_contacted == "0000-00-00 00:00:00")
				<td style="vertical-align: middle;"></td>
				@else
				<td style="vertical-align: middle;">{{ $agent->last_contacted }}</td>
				@endif
				<td style="vertical-align: middle;">{{ $agent->created_at }}</td>

				<td style="vertical-align: middle;">
					@if ($agent->logger_active === "Active")
					<span class="label label-primary }}">{{ trans("app.{$agent->logger_active}") }}</span>
					@else
					<span class="label label-danger }}">{{ trans("app.{$agent->logger_active}") }}</span>
					@endif
				</td>
				<td style="vertical-align: middle;">
					<span class="label label-{{ $agent->present()->labelClass }}">{{ trans("app.{$agent->status}") }}</span>
				</td>
				
				@if (count($agent->tags))
				<td style="vertical-align: middle; width: 200px;">
				@foreach ($agent->tags as $t)
				<span class="label label-{{ $t->tag->colour_tag }}">{{ $t->tag->name }}</span>
				@endforeach
				</td>
				@else
				<td style="vertical-align: middle;"></td>
				@endif
				<td style="vertical-align: middle;" class="text-center">
					<a href="{{ route('agent.show', $agent->id) }}" class="btn btn-success btn-circle"
						title="@lang('app.view_agent')" data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-eye-open"></i>
					</a>
					<a href="{{ route('agent.edit', $agent->id) }}" class="btn btn-primary btn-circle edit" title="@lang('app.edit_agent')"
						data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-edit"></i>
					</a>
					@role('Spymaster')
					<a href="{{ route('agent.toggle_relay', $agent->id) }}" class="btn btn-info btn-circle edit" title="Activate/Deactivate Relay"
						data-toggle="tooltip" data-placement="top">
						<i class="glyphicon glyphicon-repeat"></i>
					</a>
					@endrole
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
// Initialisation with Config
$('#agents').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
    dom: 'Qfrtip',
	pageLength: 100,
	order: [[0, 'asc']]
})
</script>
@stop
