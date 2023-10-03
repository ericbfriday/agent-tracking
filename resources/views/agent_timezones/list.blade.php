@extends('layouts.app')

@section('page-title','Agent Timezones')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Agent Timezones
            <small>- list of agent timezones</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">Agent Timezones</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2">
        <a href="{{ route('agent_timezones.create') }}" class="btn btn-success" id="add-group">
            <i class="glyphicon glyphicon-plus"></i>
            Create Agent Timezone
        </a>
    </div>
    <div class="col-md-7"></div>
</div>

<div class="table-responsive top-border-table" id="groups-table-wrapper">
    <table class="table" id="agent_timezones">
        <thead>
            <th> No.</th>
            <th> Name</th>
            <th> Tag Colour</th>
            <th> Created At</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($timezones))
                @foreach ($timezones as $timezone)
                    <tr>
                        <td>{{ $timezone->id }}</td>
                        <td>{{ $timezone->name }}</td>
                        <td><span class="label label-{{ $timezone->colour_tag }} }}">{{ $timezone->name }}</span></td>
                        <td>{{ $timezone->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <a href="{{ route('agent_timezones.show', $timezone->id) }}" class="btn btn-success btn-circle"
                               title="View Agent Tag" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a href="{{ route('agent_timezones.edit', $timezone->id) }}" class="btn btn-primary btn-circle edit" title="Edit Post"
                                    data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <a href="{{ route('agent_timezones.delete', $timezone->id) }}" class="btn btn-danger btn-circle" title="Delete Post"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-method="DELETE"
                                    data-confirm-title="Please Confirm"
                                    data-confirm-text="Are you Sure"
                                    data-confirm-delete="Yes Delete">
                                <i class="glyphicon glyphicon-trash"></i>
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
$('#agent_timezones').DataTable( {
    searchBuilder:{
		paging: true,
    	searching: true
		
    },
    dom: 'Qfrtip',
	pageLength: 100,
    order: [[1, 'asc']]
})
</script>
@stop