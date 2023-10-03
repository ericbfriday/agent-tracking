<div class="panel panel-default">
	<div class="panel-heading">@lang('app.agent_details')</div>
	<div class="panel-body">
		<div class="row col-md-12">
			<div class="col-md-3">

				@if ($edit)
				<div class="form-group">
					<label for="name">@lang('app.name')</label>
					<input type="text" class="form-control" id="name" readonly="true"
					name="name" placeholder="@lang('app.name')" value="{{ $edit ? $agent->name : '' }}">
				</div>
				@else
				<div class="form-group">
					<label for="name">@lang('app.name')</label>
					<input type="text" class="form-control" id="name" 
					name="name" placeholder="@lang('app.name')" value="{{ $edit ? $agent->name : '' }}">
				</div>
				@endif

				<div class="form-group">
					<label for="owner">@lang('app.agent_owner')</label>
					{!! Form::select('owner', $users, $edit ? $agent->owner : '',
					['class' => 'form-control', 'id' => 'owner', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="handler">@lang('app.handler')</label>
					{!! Form::select('handler', $handlers, $edit ? $agent->handler : '',
					['class' => 'form-control', 'id' => 'handler', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="status">@lang('app.status')</label>
					{!! Form::select('status', $statuses, $edit ? $agent->status : '',
					['class' => 'form-control', 'id' => 'status', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="status">Logger Status</label>
					{!! Form::select('logger_active', $loggerstatus, $edit ? $agent->logger_active : '',
					['class' => 'form-control', 'id' => 'logger_active', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="logger_id">Logger Name</label>
					<input type="text" class="form-control" id="logger-name" 
					name="logger_id" placeholder="Logger Name" value="{{ $edit ? $agent->logger_id : '' }}">
				</div>
			</div>

			<div class="col-md-3">



				<div class="form-group">
					<label for="jabber_name">Jabber Name</label>
					<input type="text" class="form-control" id="Jabber-name" 
					name="jabber_name" placeholder="Jabber Name" value="{{ $edit ? $agent->jabber_name : '' }}">
				</div>

				<div class="form-group">
					<label for="discord_name">Discord Name</label>
					<input type="text" class="form-control" id="discord-name" 
					name="discord_name" placeholder="Discord Name" value="{{ $edit ? $agent->discord_name : '' }}">
				</div>

				<div class="form-group">
					<label for="gsf_forum_name">GSF Forum Name</label>
					<input type="text" class="form-control" id="gsf-forum-name" 
					name="gsf_forum_name" placeholder="GSF Forum Name" value="{{ $edit ? $agent->gsf_forum_name : '' }}">
				</div>

				<div class="form-group">
					<label for="main_character_name">Main Character Name</label>
					<input type="text" class="form-control" id="main_character_name" 
					name="main_character_name" placeholder="Main Character Name" value="{{ $edit ? $agent->main_character_name : '' }}">
				</div>

				<div class="form-group">
					<label for="main_character_corporation">Main Character Corporation</label>
					<input type="text" class="form-control" id="main_character_corporation" 
					name="main_character_corporation" placeholder="Main Character Corporation" value="{{ $edit ? $agent->main_character_corporation : '' }}">
				</div>

				<div class="form-group">
					<label for="main_character_alliance">Main Character Alliance</label>
					<input type="text" class="form-control" id="main_character_alliance" 
					name="main_character_alliance" placeholder="Main Character Alliance" value="{{ $edit ? $agent->main_character_alliance : '' }}">
				</div>
				
			</div>

			<div class="col-md-6">
				<div class="form-group">

					<div class="form-group">
						<label for="notes">@lang('app.notes')</label>
						<textarea type="text" class="form-control" id="notes" name="notes" style="align-content:center" rows="30" placeholder="@lang('app.notes')" >
							{{ $edit ? $agent->notes : $notes_placeholder }}
						</textarea>
					</div>
				</div>
			</div>
			

			

			@section('scripts')
			<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
			<script>
				CKEDITOR.replace( 'notes', {
					height: 600
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


