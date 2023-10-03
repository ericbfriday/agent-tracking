@extends('layouts.app')

@section('page-title', trans('app.handlers'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.handlers')
            <small>@lang('app.list_of_registered_handlers')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.handlers')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2">
        <a href="{{ route('handler.create') }}" class="btn btn-success" id="add-handler">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_handler')
        </a>
    </div>
    <div class="col-md-5"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="handlers-form">
        <div class="col-md-2">
            {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_handlers')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-handlers-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('handler.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="handlers-table-wrapper">
    <table class="table" id="handlers">
        <thead>
            <th> @sortablelink('name')</th>
            <th> @sortablelink('timezone')</th>
            <th> Number of Agents</th>
            <th> @lang('app.status')</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($handlers))
                @foreach ($handlers as $handler)
                    <tr>
                        <td>{{ $handler->name }}</td>
                        <td>{{ $handler->timezone }}</td>
                        <td>{{ $handler->present()->countAgents($handler->name) }}</td>
                        <td>
                            <span class="label label-{{ $handler->present()->labelClass }}">{{ trans("app.{$handler->status}") }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('handler.show', $handler->id) }}" class="btn btn-success btn-circle"
                               title="@lang('app.view_handler')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a href="{{ route('handler.edit', $handler->id) }}" class="btn btn-primary btn-circle edit" title="@lang('app.edit_handler')"
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

    {!! $handlers->render() !!}
</div>

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#handlers-form").submit();
        });
    </script>
@stop
