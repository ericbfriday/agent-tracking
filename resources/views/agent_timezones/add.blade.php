@extends('layouts.app')

@section('page-title', 'Create New Agent Timezone')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Create New Agent Timezone
            <small>Agent Timezone Details</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('agent_timezones.list') }}">Agent Tag</a></li>
                    <li class="active">Create</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'agent_timezones.store', 'files' => true, 'id' => 'agent_timezones-form']) !!}
    <div class="row">
        <div class="col-md-3">
            @include('agent_timezones.partials.details', ['edit' => false, 'profile' => false])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
               Create Agent Timezone
            </button>
        </div>
    </div>
    <br>
    <br>
    <br>
{!! Form::close() !!}

@stop

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\AgentTimezones\CreateAgentTimezonesRequest', '#agent_timezones-form') !!}
@stop