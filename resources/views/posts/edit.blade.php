@extends('layouts.app')

@section('page-title', 'Edit Post')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			{{ $post->present()->subject }}
			<small>- edit post</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('posts.list') }}">Posts</a></li>
					<li><a href="{{ route('posts.show', $post->id) }}">{{ $post->id }}</a></li>
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
			Post Details
		</a>
	</li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="details">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				{!! Form::open(['route' => ['posts.update.details', $post->id], 'method' => 'PUT', 'id' => 'details-form']) !!}
				@include('posts.partials.details', ['profile' => false])
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
{!! JsValidator::formRequest('Vanguard\Http\Requests\Posts\UpdateDetailsRequest', '#details-form') !!}



@stop