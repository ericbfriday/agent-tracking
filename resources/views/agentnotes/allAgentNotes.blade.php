@extends('layouts.app')

@section('page-title', trans('app.agent_notes'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			@lang('app.agents_notes')
			<small>@lang('app.list_of_agent_notes')</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">@lang('app.agentnotes')</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')


@stop
