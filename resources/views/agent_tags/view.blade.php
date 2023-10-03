@extends('layouts.app')

@section('page-title', $tag->name)

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			{{ $tag->name }}
			<small>- agent tag details</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('agent_tags.list') }}">Agent Tags</a></li>
					<li class="active">{{ $tag->name }}</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')

<div class="row col-md-12">
	<div class="col-md-3">
		<div id="edit-group-panel" class="panel panel-default">
			<div class="panel-heading">
				Details
				<div class="pull-right">
					<a href="{{ route('agent_tags.edit', $tag->id) }}" class="edit"
						data-toggle="tooltip" data-placement="top" title="Edit Agent Tag">
						Edit
					</a>
				</div>
			</div>
			<div class="panel-body panel-profile">
				<table class="table table-hover table-details">
					<thead>
						<tr>
							<th colspan="3">Agent Tag Information</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td>Tag name</td>
							<td>{{ $tag->name }}</td>
						</tr>
						<tr>
							<td>Colour</td>
							<td><span class="label label-{{ $tag->colour_tag }} }}">{{ $tag->name }}</span></td>
						</tr>
						<tr>
							<td>Hidden From Handlers</td>
							<td>
							@if($tag->is_hidden)
                        	Yes
                        	@else
                        	No
                        	@endif
							</td>
						</tr>
						<tr>
							<td>Created</td>
							<td>{{ $tag->created_at->format(config('app.date_time_format')) }}</td>
						</tr>
						<tr>
							<td>Updated</td>
							<td>{{ $tag->updated_at->diffForHumans() }}</td>
						</tr>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>

    <!-- Agents Who Have Tag -->
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Agents Who Have this Tag
            </div>
            <div class="panel-body">
                <table class="table notes">
                    <thead>
                        <tr>
                            <th>Agent Name</th>
                        </tr>
                    </thead>

                    <table border="0" class="table table-hover">
                        <tbody>

							@if(count($agents_have_tag))
							<!-- We Found Some! -->
							
							@foreach($agents_have_tag as $a)
							<tr>	
							<td><a href="{{ route('agent.show', $a->agent->id) }}">{{ $a->agent->name }}</a></td>
							</tr>
							@endforeach
							@else
							<!-- No Agents Present -->
							<td>
							No Agents have this tag.
							</td>
						
							@endif
							</tr>
                        </tbody>

                    </table>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
