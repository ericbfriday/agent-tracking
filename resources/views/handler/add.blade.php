@extends('layouts.app')

@section('page-title', trans('app.add_handler'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Create a New Handler
            <small>- handler details</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('handler.list') }}">@lang('app.handlers')</a></li>
                    <li class="active">@lang('app.create')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'handler.store', 'files' => true, 'id' => 'handler-form']) !!}
    <div class="row col-md-12">
        <div class="col-md-12">
            @include('handler.partials.details', ['edit' => false, 'profile' => false])
        </div>



        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                @lang('app.create_handler')
            </button>
        </div>
    </div>
    
{!! Form::close() !!}

@stop

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Handler\CreateHandlerRequest', '#handler-form') !!}
@stop

