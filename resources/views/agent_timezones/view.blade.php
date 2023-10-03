@extends('layouts.app')

@section('page-title', $timezone->name)

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			{{ $timezone->name }}
			<small>- agent timezone details</small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('agent_timezones.list') }}">Agent Timezones</a></li>
					<li class="active">{{ $timezone->name }}</li>
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
					<a href="{{ route('agent_timezones.edit', $timezone->id) }}" class="edit"
						data-toggle="tooltip" data-placement="top" title="Edit Agent Timezone">
						Edit
					</a>
				</div>
			</div>
			<div class="panel-body panel-profile">
				<table class="table table-hover table-details">
					<thead>
						<tr>
							<th colspan="3">Agent Timezone Information</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td>Timezone name</td>
							<td>{{ $timezone->name }}</td>
						</tr>
						<tr>
							<td>Colour</td>
							<td><span class="label label-{{ $timezone->colour_tag }} }}">{{ $timezone->name }}</span></td>
						</tr>
						<tr>
							<td>Created</td>
							<td>{{ $timezone->created_at->format(config('app.date_time_format')) }}</td>
						</tr>
						<tr>
							<td>Updated</td>
							<td>{{ $timezone->updated_at->diffForHumans() }}</td>
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
                Agents Who Have this Timezone
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

							@if(count($agents_have_timezone))
							<!-- We Found Some! -->
							
							@foreach($agents_have_timezone as $a)
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
