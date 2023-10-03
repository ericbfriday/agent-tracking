@extends('layouts.app')

@section('page-title', 'Active Agents')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			MyAgents
			<small>list of my agents</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">My Agents</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@foreach($agents as $agent)
<div class="user media">
	<div class="media-left">
		<a href="{{ route('agent.show', $agent->id) }}" 
			title="@lang('app.view_agent')" data-toggle="tooltip" data-placement="top">
			<img class="media-object img-circle avatar" src="assets/img/agent.png">
		</a>
	</div>
	<div class="media-body">
		<h4 class="media-heading">{{ $agent->present()->name }}</h4>
		{{ $agent->group }}
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