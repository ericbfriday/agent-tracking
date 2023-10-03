<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.registration_history')</div>
			<div class="panel-body">
				<div>
					<canvas id="myChart" height="403"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.latest_registrations')</div>
			<div class="panel-body">
				@if (count($latestRegistrations))
				<div class="list-group">
					@foreach ($latestRegistrations as $user)
					<a href="{{ route('user.show', $user->id) }}" class="list-group-item">
						<img class="img-circle" src="{{ $user->present()->avatar }}">
						&nbsp; <strong>{{ $user->present()->nameOrEmail }}</strong>
						<span class="list-time text-muted small">
							<em>{{ $user->created_at->diffForHumans() }}</em>
						</span>
					</a>
					@endforeach
				</div>
				<a href="{{ route('user.list') }}" class="btn btn-default btn-block">@lang('app.view_all_users')</a>
				@else
				<p class="text-muted">@lang('app.no_records_found')</p>
				@endif
			</div>
		</div>
	</div>
</div>