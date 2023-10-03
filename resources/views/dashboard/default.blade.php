@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			@lang('app.welcome') <?= Auth::user()->username ?: Auth::user()->first_name ?>!
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">@lang('app.dashboard')</li>
				</ol>
			</div>
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<a href="{{ route('profile') }}" class="panel-link">
			<div class="panel panel-default dashboard-panel">
				<div class="panel-body">
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>
					<p class="lead">@lang('app.update_profile')</p>
				</div>
			</div>
		</a>
	</div>
	<div class="col-md-2">
		<a href="{{ route('agent.mine') }}" class="panel-link">
			<div class="panel panel-default dashboard-panel">
				<div class="panel-body">
					<div class="icon">
						<i class="fa fa-user-secret"></i>
					</div>
					<p class="lead">My Agents</p>
				</div>
			</div>
		</a>
	</div>
	<div class="col-md-2">
		<a href="{{ route('handler.mine') }}" class="panel-link">
			<div class="panel panel-default dashboard-panel">
				<div class="panel-body">
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
					<p class="lead">My Handlers</p>
				</div>
			</div>
		</a>
	</div>
	@if (config('session.driver') == 'database')
	<div class="col-md-2">
		<a href="{{ route('profile.sessions') }}" class="panel-link">
			<div class="panel panel-default dashboard-panel">
				<div class="panel-body">
					<div class="icon">
						<i class="fa fa-list"></i>
					</div>
					<p class="lead">@lang('app.my_sessions')</p>
				</div>
			</div>
		</a>
	</div>
	@endif
	<div class="col-md-2">
		<a href="{{ route('profile.activity') }}" class="panel-link">
			<div class="panel panel-default dashboard-panel">
				<div class="panel-body">
					<div class="icon">
						<i class="fa fa-list-alt"></i>
					</div>
					<p class="lead">@lang('app.activity_log')</p>
				</div>
			</div>
		</a>
	</div>
	<div class="col-md-2">
		<a href="{{ route('auth.logout') }}" class="panel-link">
			<div class="panel panel-default dashboard-panel">
				<div class="panel-body">
					<div class="icon">
						<i class="fa fa-sign-out"></i>
					</div>
					<p class="lead">@lang('app.logout')</p>
				</div>
			</div>
		</a>
	</div>
</div>

@include('partials.messages')

<div class="row">
	
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Notifications -

				@if(isset($ContactNotificationsCount))
					you have (<b>{{ $ContactNotificationsCount }}</b>) outstanding notifications to action.
				@else
					(<b>0</b>)
				@endif
			</div>
			<div class="panel-body">
				@if(isset($ContactNotifications))
					@foreach($ContactNotifications as $note)
					<div class="alert alert-info" role="alert">
						<b>{{ $note->present()->getUser($note->from)->username }}</b> requires your attention to <b><a href="{{ route('agentnotes.show', $note->present()->agentNote($note->note_id)->id) }}">{{ substr($note->present()->agentNote($note->note_id)->subject, 0, 30) }}...</a></b>
						for agent <b>{{ $note->present()->agentNote($note->note_id)->agent }}</b>, handled by <b>{{ $note->present()->agentNote($note->note_id)->handler }}</b>.
						<div class="pull-right">Created at: {{ $note->created_at->toDateTimeString() }} ({{ $note->created_at->diffForHumans() }}) - <a href="{{ route('contactnote.acknowledge', $note->id) }}">Acknowledge</a></div>
						<br>
					</div>
					@endforeach
				@else
					<tr>
						<td colspan="6"><em>No Notifications to show.</em></td>
					</tr>
				@endif
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Spy Master Updates
				<div class="pull-right">
					<a href="{{ route('contactnote.index') }}" class="view"
					data-toggle="tooltip" data-placement="top" title="View All Spymaster Updates">
					View All

				</a>
			</div>
		</div>

		<div class="panel-body">


			@if(count($posts))
			@foreach($posts as $post)
			<div class="col-md-4">
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

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.activity') (@lang('app.last_two_weeks')</div>
			<div class="panel-body">
				<div>
					<canvas id="myChart" height="400"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
<script>
	var labels = {!! json_encode(array_keys($activities)) !!};
	var activities = {!! json_encode(array_values($activities)) !!};
</script>
{!! HTML::script('assets/js/chart.min.js') !!}
{!! HTML::script('assets/js/as/dashboard-default.js') !!}
@stop
