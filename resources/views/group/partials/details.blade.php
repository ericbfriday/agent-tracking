<div class="panel panel-default">
	<div class="panel-heading">@lang('app.group_details')</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				@if ($edit)
				<div class="form-group">
					<label for="group">@lang('app.group')</label>
					<input type="text" class="form-control" id="group" readonly="true"
					name="group" placeholder="@lang('app.group')" value="{{ $edit ? $group->group : '' }}">
				</div>
				@else
				<div class="form-group">
					<label for="group">@lang('app.group')</label>
					<input type="text" class="form-control" id="group"
					name="group" placeholder="@lang('app.group')" value="{{ $edit ? $group->group : '' }}">
				</div>
				@endif

				<div class="form-group">
					<label for="type">@lang('app.type')</label>
					<input type="text" class="form-control" id="type"
					name="type" placeholder="@lang('app.type')" value="{{ $edit ? $group->type : '' }}">
				</div>

				<div class="form-group">
					<label for="status">@lang('app.status')</label>
					{!! Form::select('status', $statuses, $edit ? $group->status : '',
					['class' => 'form-control', 'id' => 'status', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="topsecret">@lang('app.topsecret')</label>
					{!! Form::select('topsecret', $topsecret, $edit ? $group->topsecret : '',
					['class' => 'form-control', 'id' => 'topsecret', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="home">@lang('app.home')</label>
					<input type="text" class="form-control" id="home"
					name="home" placeholder="@lang('app.home')" value="{{ $edit ? $group->home : '' }}">
				</div>
			</div>

			<div class="col-md-8">
				<div class="form-group">
					<label for="home">@lang('app.notes')</label>
					<textarea type="text" class="form-control" id="notes" name="notes" style="align-content:center" rows="20" placeholder="@lang('app.notes')" >
						{{ $edit ? $group->notes : '' }}
					</textarea>
				</div>
			</div>

			

			@section('scripts')
			<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
			<script>
				CKEDITOR.replace( 'notes', {
					height: 400
				} );
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


