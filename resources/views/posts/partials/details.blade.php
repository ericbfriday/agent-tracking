<div class="panel panel-default">
	<div class="panel-heading">Post Details</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				
				<div class="form-group">
					<label for="subject">Subject</label>
					<input type="text" class="form-control" id="subject" 
					name="subject" placeholder="Subject" value="{{ $edit ? $post->subject : '' }}">
				</div>
				
				<div class="form-group">
					<label for="author">Author</label>
					<input type="text" class="form-control" id="author" readonly="true"
					name="author" placeholder="Author" value="{{ $edit ? $author->username : $author->username }}">
				</div>				

				<div class="form-group">
					<label for="category">Category</label>
					{!! Form::select('category', array('Update' => 'Update', 'Notification' => 'Notification'), $edit ? $post->category : '',
					['class' => 'form-control', 'id' => 'category', $profile ? 'disabled' : '']) !!}
				</div>

				<div class="form-group" height="200px">
					<label for="description">Description</label>
					<textarea type="text" class="form-control" id="description" name="description" style="align-content:center" rows="20" placeholder="@lang('app.notes')" >
						{{ $edit ? $post->description : '' }}
					</textarea>
				</div>
			
			</div>

			

			@section('scripts')
			<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
			<script>
				CKEDITOR.replace( 'description' );
			</script>
			@stop

			@if ($edit)
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary" id="update-details-btn">
					<i class="fa fa-refresh"></i>
					Update Post
				</button>
			</div>
			@endif
		</div>
	</div>
</div>


