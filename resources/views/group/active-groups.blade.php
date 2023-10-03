@extends('layouts.app')

@section('page-title', 'Active Groups')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Active Groups
            <small>list of active groups</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">Active Groups</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@foreach($groups as $group)
<div class="user media">
    <div class="media-left">
        <a href="{{ route('group.show', $group->id) }}" 
           title="@lang('app.view_group')" data-toggle="tooltip" data-placement="top">
           <img class="media-object img-circle avatar" src="assets/img/group.jpg">
       </a>
   </div>
   <div class="media-body">
    <h4 class="media-heading">{{ $group->present()->name }}</h4>
    {{ $group->home }}
</div>
</div>
@endforeach

@stop

@section('styles')
<style>
.user.media {
    float: left;
    border: 1px solid #dfdfdf;
    padding: 10px;
    border-radius: 4px;
    margin-right: 15px;
}
.user.media .media-object {
    width: 64px;
    height: 64px;
}
.user.media .media-body {

    width: 200px;
    height: 100px;
}
</style>
@stop