@extends('layouts.app')

@section('page-title', trans('app.groups'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.groups')
            <small>@lang('app.list_of_registered_groups')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.groups')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2">
        <a href="{{ route('group.create') }}" class="btn btn-success" id="add-group">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_group')
        </a>
    </div>
    <div class="col-md-5"></div>
</div>

<div class="table-responsive top-border-table" id="groups-table-wrapper">
    <table class="table" id="groups">
        <thead>
            <th> Name</th>
            <th> Type</th>
            <th> Home</th>
            <th> Active Agents</th>
            <th> Active Relays</th>
            <th> Last Updated</th>
            <th> Status</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($groups))
                @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->group }}</td>
                        <td>{{ $group->type }}</td>
                        <td>{{ $group->home }}</td>
                        <td>{{ $group->present()->countActiveAgents($group->group) }}</td>
                        <td>{{ $group->present()->countActiveAgentsRelays($group->group) }}</td>
                        <td>{{ $group->updated_at->diffForHumans() }}</td>
                        <td>
                            <span class="label label-{{ $group->present()->labelClass }}">{{ trans("app.{$group->status}") }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('group.show', $group->id) }}" class="btn btn-success btn-circle"
                               title="@lang('app.view_group')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a href="{{ route('group.edit', $group->id) }}" class="btn btn-primary btn-circle edit" title="@lang('app.edit_group')"
                                    data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
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
// Initialisation with Config
$('#groups').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
    dom: 'Qfrtip',
	pageLength: 100
})
</script>
@stop