@extends('layouts.app')

@section('page-title', trans('app.edit_agents'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			{{ $agent->present()->name }}
			<small>@lang('app.edit_group_details')</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="javascript:;">@lang('app.home')</a></li>
					<li><a href="{{ route('agent.list') }}">@lang('app.agents')</a></li>
					<li><a href="{{ route('agent.show', $agent->id) }}">{{ $agent->present()->name }}</a></li>
					<li class="active">@lang('app.edit')</li>
				</ol>
			</div>
		</h1>
	</div>
</div>

@include('partials.messages')

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active">
		<a href="#details" aria-controls="details" role="tab" data-toggle="tab">
			<i class="glyphicon glyphicon-th"></i>
			@lang('app.group_details')
		</a>
	</li>
	<li role="presentation">
		<a href="#spare" aria-controls="spare" role="tab" data-toggle="tab">
			<i class="fa fa-lock"></i>
			@lang('app.spare')
		</a>
	</li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="details">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				{!! Form::open(['route' => ['agent.update.details', $agent->id], 'method' => 'PUT', 'id' => 'details-form']) !!}
				@include('agent.partials.details', ['profile' => false])
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane" id="notes">
		<div class="row">
			<div class="col-md-12">
				
			</div>
		</div>
	</div>
</div>

@stop

@section('styles')
{!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
{!! HTML::style('assets/plugins/croppie/croppie.css') !!}
@stop

@section('scripts')
{!! HTML::script('assets/plugins/croppie/croppie.js') !!}
{!! HTML::script('assets/js/moment.min.js') !!}
{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
{!! HTML::script('assets/js/as/btn.js') !!}
{!! HTML::script('assets/js/as/profile.js') !!}
{!! JsValidator::formRequest('Vanguard\Http\Requests\Agent\UpdateDetailsRequest', '#details-form') !!}



@stop