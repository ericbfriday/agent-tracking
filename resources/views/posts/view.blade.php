@extends('layouts.app')

@section('page-title', $post->present()->subject)

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			{{ $post->present()->subject }}
			<small>- post details</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('posts.list') }}">Posts</a></li>
					<li class="active">{{ $post->present()->subject }}</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')

<div class="row">
	<div class="col-lg-4 col-md-5">
		<div id="edit-group-panel" class="panel panel-default">
			<div class="panel-heading">
				Details
				<div class="pull-right">
					<a href="{{ route('posts.edit', $post->id) }}" class="edit"
						data-toggle="tooltip" data-placement="top" title="Edit Post">
						Edit
					</a>
				</div>
			</div>
			<div class="panel-body panel-profile">
				<table class="table table-hover table-details">
					<thead>
						<tr>
							<th colspan="3">Post Information</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td>Subject</td>
							<td>{{ $post->present()->subject }}</td>
						</tr>
						<tr>
							<td>Author</td>
							<td>{{ $post->present()->author }}</td>
						</tr>
						<tr>
							<td>Category</td>
							<td>{{ $post->present()->category }}</td>
						</tr>
						<tr>
							<td>Created</td>
							<td>{{ $post->created_at->format(config('app.date_time_format')) }}</td>
						</tr>
						<tr>
							<td>Updated</td>
							<td>{{ $post->updated_at->diffForHumans() }}</td>
						</tr>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				Description
			</div>
			<div class="panel-body">
				<table class="table notes">
					<thead>
						<tr>
							<th>Post Content</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{!! $post->description !!}</td>
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

@stop
