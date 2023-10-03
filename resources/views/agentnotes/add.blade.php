@extends('layouts.app')

@section('page-title', trans('app.add_agent_note'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.create_new_agent_note')
            <small>@lang('app.agent_note_details')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('agentnotes.list') }}">@lang('app.agents_notes')</a></li>
                    <li class="active">@lang('app.create')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

@php
$noteid = $agent->id;
@endphp

{!! Form::open(['route' => ['agentnotes.store', $noteid], 'files' => true, 'id' => 'agentnotes-form', ]) !!}
    <div class="row">
        <div class="col-md-12">
            @include('agentnotes.partials.details', ['edit' => false, 'profile' => false])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                @lang('app.create_agent_note')
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
    {!! JsValidator::formRequest('Vanguard\Http\Requests\AgentNotes\CreateAgentNotesRequest', '#agentnotes-form') !!}
@stop

