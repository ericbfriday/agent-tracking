@extends('layouts.app')

@section('page-title', trans('app.agent_notes'))

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			Contact Notes for {{ $agent_details->name }}
			<small></small>
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li><a href="{{ route('agent.show', $agent_details->id) }}">@lang('app.home')</a></li>
					<li class="active">@lang('app.agentnotes')</li>
				</ol>
			</div>

		</h1>
	</div>
</div>

@include('partials.messages')
<div class="row">
@foreach ($agentsNotes as $note)


	<div class="col-md-12">
		<div id="edit-group-panel" class="panel panel-default">
			<div class="panel-heading">
				<a href="#" onclick="toggle_visibility('{{ $note->id }}');" class="expand"
					data-toggle="tooltip" data-placement="top" title="Click to Expand">

					{{ $note->subject }}
				</a>
				
				<div class="pull-right">

					Created: {{ $note->created_at }} : ({{ $note->created_at->diffForHumans() }})
					
				</div>
			</div>
			<div class="panel-body">
				<div id="{{ $note->id }}" style="display:none;">
					Handler: {{ $note->handler }}<br>
					Added By: {{ $note->owner }}<br>
					Priority: {{ $note->priority }}<br>
					Category: {{ $note->category }}<br>
					Notify Handler:
				
								@if ($note->notify_handler === "Yes")
								<span class="label label-success }}">{{ $note->notify_handler }}</span><br>
								@else
								<span class="label label-danger }}">{{ $note->notify_handler }}</span><br>
								@endif
					Notify Spymaster:


			
								@if ($note->notify_spymaster === "Yes")
								<span class="label label-success }}">{{ $note->notify_spymaster }}</span><br>
								@else
								<span class="label label-danger }}">{{ $note->notify_spymaster }}</span><br>
								@endif
							

					
					Note:<br>
					<p>{!! $note->notes !!}</p>
				</div>
			</div>
		</div>
	</div>


@endforeach

{!! $agentsNotes->render() !!}

</div>


@stop

@section('scripts')
<script type="text/javascript">

	function toggle_visibility(id) {
		var e = document.getElementById(id);
		if(e.style.display == 'block')
			e.style.display = 'none';
		else
			e.style.display = 'block';
	}

</script>

@stop
