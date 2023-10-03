<div class="panel panel-default">
	<div class="panel-heading">@lang('app.agent_add_note')</div>
	<div class="panel-body">
		<div class="row col-md-12">
			<div class="col-md-3">

				<div class="form-group">
					<label for="agent">@lang('app.agent')</label>
					<input type="text" class="form-control" id="agent" readonly="true"
					name="agent" placeholder="@lang('app.agent')" value="{{ $agent_information->name }}">
				</div>

				<div class="form-group">
					<label for="owner">User Account</label>
					<input type="text" class="form-control" id="owner" readonly="true"
					name="owner" placeholder="@lang('app.owner')" value="{{ $owner }}">
				</div>

				<div class="form-group">
					<label for="handler">@lang('app.handler')</label>
					<input type="text" class="form-control" id="handler" readonly="true"
					name="handler" placeholder="@lang('app.handler')" value="{{ $agent_information->handler }}">
				</div>

				<div class="form-group">
					<label for="priority">Priority</label>
					{!! Form::select('priority', $priority, $edit ? $agent_information->priority : '',
					['class' => 'form-control', 'id' => 'priority', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="category">Category</label>
					{!! Form::select('category', $category, $edit ? $agent_information->category : '',
					['class' => 'form-control', 'id' => 'category', $profile ? 'disabled' : '']) !!}
				</div>
				
				<div class="form-group">
					<label for="notify_handler">Notify Handler</label>
					{!! Form::select('notify_handler', array('No' => 'No', 'Yes' => 'Yes'), $edit ? $agent_information->notify_handler : '',
					['class' => 'form-control', 'id' => 'notify_handler', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="notify_spymaster">Notify Spymaster</label>
					{!! Form::select('notify_spymaster', array('No' => 'No', 'Yes' => 'Yes'), $edit ? $agent_information->notify_spymaster : '',
					['class' => 'form-control', 'id' => 'notify_spymaster', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group">
					<label for="subject">@lang('app.Subject')</label>
					<input type="text" class="form-control" id="subject"
					name="subject" placeholder="@lang('app.note_subject')" value="{{ $edit ? $agentNotes->subject : '' }}">
				</div>
			</div>

			<div class="col-md-9">
				<div class="form-group">

					<div class="form-group" height="200px">
						<label for="notes">@lang('app.notes')</label>
						<textarea type="text" class="form-control" id="notes" name="notes" style="align-content:center" rows="10" placeholder="@lang('app.notes')" >
							{{ $edit ? $agentNotes->notes : ''  }}
						</textarea>
					</div>
				</div>
			</div>
			

			

			@section('scripts')
			<script src="/assets/ckeditor/ckeditor.js"></script>
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
					@lang('app.add_agent_note')
				</button>
			</div>
			@endif
		</div>
	</div>
</div>


