@extends('layouts.app')

@section('page-title', trans('app.handlers'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.handlers')
            <small>- list of all inactive handlers</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">Inactive Handlers</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')



<div class="table-responsive top-border-table" id="handlers-table-wrapper">
    <table class="table" id="handlers">
        <thead>
            <th>@lang('app.handlername')</th>
            <th>@lang('app.handlertimezone')</th>
            <th>GSF Forum Name</th>
            <th>Number of Agents</th>
            <th>@lang('app.status')</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($handlers))
            @foreach ($handlers as $handler)
            <tr>
                <td>{{ $handler->name }}</td>
                <td>{{ $handler->timezone }}</td>
                <td>{{ $handler->gsf_forum_name }}</td>
                <td>{{ $handler->present()->countAgents($handler->name) }}</td>
                <td>
                    <span class="label label-{{ $handler->present()->labelClass }}">{{ trans("app.{$handler->status}") }}</span>
                </td>
                <td class="text-center">
                    <a href="{{ route('handler.show', $handler->id) }}" class="btn btn-success btn-circle"
                     title="@lang('app.view_handler')" data-toggle="tooltip" data-placement="top">
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


</div>

@stop

@section('scripts')
<script>
    $("#status").change(function () {
        $("#handlers-form").submit();
    });
</script>

<script>
    $(document).ready(function(){
        $('#handlers').DataTable( {
            "paging":   false,
            "searching": false
        }
        );

    });
</script>
@stop
