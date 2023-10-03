@extends('layouts.app')

@section('page-title', 'Create New Post')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Create new Post
            <small>Post Details</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('posts.list') }}">Posts</a></li>
                    <li class="active">Create</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'posts.store', 'files' => true, 'id' => 'posts-form']) !!}
    <div class="row">
        <div class="col-md-12">
            @include('posts.partials.details', ['edit' => false, 'profile' => false])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
               Create Post
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
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Posts\CreatePostsRequest', '#posts-form') !!}
@stop