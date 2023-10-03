<div class="panel panel-default">
	<div class="panel-heading">@lang('app.handler_details')</div>
	<div class="panel-body">
		<div class="row col-md-12">
			<div class="col-md-3">

				@if ($edit)
				<div class="form-group">
					<label for="name">@lang('app.name')</label>
					<input type="text" class="form-control" id="name" readonly="true"
					name="name" placeholder="@lang('app.name')" value="{{ $edit ? $handler->name : '' }}">
				</div>
				@else
				<div class="form-group">
					<label for="name">@lang('app.name')</label>
					<input type="text" class="form-control" id="name" 
					name="name" placeholder="@lang('app.name')" value="{{ $edit ? $handler->name : '' }}">
				</div>
				@endif

				<div class="form-group">
					<label for="owner">@lang('app.owner')</label>
					{!! Form::select('owner', $users, $edit ? $handler->owner : '',
					['class' => 'form-control', 'id' => 'owner', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="gsf_forum_name">@lang('app.gsf_forum_name')</label>
					<input type="text" class="form-control" id="gsf_forum_name"
					name="gsf_forum_name" placeholder="@lang('app.gsf_forum_name')" value="{{ $edit ? $handler->gsf_forum_name : '' }}">
				</div>

				<div class="form-group">
					<label for="skype_name">@lang('app.skype_name')</label>
					<input type="text" class="form-control" id="skype_name"
					name="skype_name" placeholder="@lang('app.skype_name')" value="{{ $edit ? $handler->skype_name : '' }}">
				</div>

				<div class="form-group">
					<label for="discord_name">@lang('app.discord_name')</label>
					<input type="text" class="form-control" id="discord_name"
					name="discord_name" placeholder="@lang('app.discord_name')" value="{{ $edit ? $handler->discord_name : '' }}">
				</div>
				<div class="form-group">
					<label for="timezone">@lang('app.timezone')</label>
					{!! Form::select('timezone', $timezones, $edit ? $handler->timezone : '',
					['class' => 'form-control', 'id' => 'timezone', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="status">@lang('app.status')</label>
					{!! Form::select('status', $statuses, $edit ? $handler->status : '',
					['class' => 'form-control', 'id' => 'status', $profile ? 'disabled' : '']) !!}
				</div>


			</div>
			<div class="col-md-9">
				<div class="form-group">

					<div class="form-group" height="200px">
						<label for="notes">@lang('app.notes')</label>
						<textarea type="text" class="form-control" id="notes" name="notes" style="align-content:center" rows="10" placeholder="@lang('app.notes')" >
							{{ $edit ? $handler->notes : '' }}
						</textarea>
					</div>
				</div>
			</div>
			

			

			@section('scripts')
			<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
			<script>
				CKEDITOR.replace( 'notes', {
					height: 400
				});
			</script>
			@stop

			@if ($edit)
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary" id="update-details-btn">
					<i class="fa fa-refresh"></i>
					@lang('app.update_details')
				</button>
			</div>
			@endif
		</div>
	</div>
</div>


