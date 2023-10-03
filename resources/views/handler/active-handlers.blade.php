@extends('layouts.app')

@section('page-title', 'Active Handlers')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Active Handlers
			<small>list of active Handlers</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">Active Handlers</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@foreach($handlers as $handler)
<div class="user media">
	<div class="media-left">
		<a href="{{ route('handler.show', $handler->id) }}" 
			title="@lang('app.view_handler')" data-toggle="tooltip" data-placement="top">
			<img class="media-object img-circle avatar" src="../../assets/img/handler.png">
		</a>
	</div>
	<div class="media-body">
		<h4 class="media-heading">{{ $handler->present()->name }}</h4>
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