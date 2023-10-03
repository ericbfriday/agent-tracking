@extends('layouts.app')

@section('page-title', 'Spymaster Notifications')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Spy Master Notifications
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">Notifications</li>
				</ol>
			</div>
		</h1>
	</div>
</div>

@include('partials.messages')


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Spy Master Updates</div>
			<div class="panel-body">

				@if(count($notifications))
				@foreach($notifications as $post)
				<div class="col-md-12">
					<h2>{!! $post->present()->subject !!}</h2>
					Post By: <b>{{ $post->present()->author }}</b> at {{ $post->created_at->toDateTimeString() }} <b>({{ $post->created_at->diffForHumans() }})</b><br>
					Category: <b>{{ $post->present()->category }}</b><br>
					<p>{!! $post->present()->description !!}</p>
				</div>
				@endforeach

				@else
				<tr>
					<td colspan="6"><em>No Posts to show.</em></td>
				</tr>
				@endif

			</div>
		</div>
	</div>
</div>

{!! $notifications->render() !!}


@stop