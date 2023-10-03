<div class="panel panel-default">
	<div class="panel-heading">Agent Tag Details</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" 
					name="name" placeholder="Name" value="{{ $edit ? $tag->name : '' }}">
				</div>	

				<div class="form-group">
					<label for="colour_tag">Colour Type</label>
					{!! Form::select('colour_tag', $colour_tags, $edit ? $tag->colour_tag : '',
					['class' => 'form-control', 'id' => 'colour_tag', $profile ? 'disabled' : '']) !!}
				</div>	

				<div class="form-group">
					<label for="is_hidden">Hidden From Handlers</label>
					{!! Form::select('is_hidden', $is_hidden, $edit ? $tag->is_hidden : '',
					['class' => 'form-control', 'id' => 'is_hidden', $profile ? 'disabled' : '']) !!}
				</div>		
			</div>


			@if ($edit)
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary" id="update-details-btn">
					<i class="fa fa-refresh"></i>
					Update Agent Tag
				</button>
			</div>
			@endif
		</div>
	</div>
</div>


