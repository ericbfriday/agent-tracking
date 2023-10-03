<div class="panel panel-default">
	<div class="panel-heading">Agent Timezone Details</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" 
					name="name" placeholder="Name" value="{{ $edit ? $timezone->name : '' }}">
				</div>	

				<div class="form-group">
					<label for="colour_tag">Colour Type</label>
					{!! Form::select('colour_tag', $colour_tags, $edit ? $timezone->colour_tag : '',
					['class' => 'form-control', 'id' => 'colour_tag', $profile ? 'disabled' : '']) !!}
				</div>		
			</div>


			@if ($edit)
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary" id="update-details-btn">
					<i class="fa fa-refresh"></i>
					Update Agent Timezone
				</button>
			</div>
			@endif
		</div>
	</div>
</div>


