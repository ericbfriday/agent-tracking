@extends('layouts.app')

@section('page-title', $agent->present()->name)

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $agent->present()->name }}
            <small>@lang('app.agent_details')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('agent.list') }}">@lang('app.agents')</a></li>
                    <li class="active">{{ $agent->present()->name }}</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')
<div class="row">
<div class="container col-md-12">
	<ul class="nav nav-tabs" id="agent">
		<li class="active"><a data-toggle="tab" href="#home">Agent Details</a></li>
		<li><a data-toggle="tab" href="#agent_notes">Agent Notes</a></li>
		<li><a data-toggle="tab" href="#activity_log">Activity Log</a></li>
		
	</ul>

    <div class="tab-content">
	    <div id="home" class="tab-pane fade in active">
                <div class="row col-md-12">
                    <div class="col-md-3">
                        <div id="edit-group-panel" class="panel panel-default">
                            <div class="panel-heading">
                                @lang('app.details')
                                <div class="pull-right">
                                    <a href="{{ route('agent.edit', $agent->id) }}" class="edit" data-toggle="tooltip"
                                        data-placement="top" title="@lang('app.edit_agent')">
                                        @lang('app.edit')
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body panel-profile">
                                <div class="image">
                                    <img alt="image" class="img-circle avatar" src="{{ url('assets/img/agent.png') }}">
                                </div>
                                <div class="name"><strong>{{ $agent->present()->name }}</strong></div>

                                <br>

                                <table border="0" class="table table-hover table-details">
                                    <thead>
                                        <tr>
                                            <th width="50%">@lang('app.agent_informations')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>@lang('app.agent_handler')</td>
                                            <td>{{ $agent->handler }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('app.agent_owner')</td>
                                            <td>{{ $agent->owner }}</td>
                                        </tr>

                                        <tr>
                                            <td>Timezone</td>
                                            <td>{{ $agent->timezone }}</td>
                                        </tr>


                                    </tbody>
                                </table>

                                <table border="0" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50%">@lang('app.agent_additional_informations')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>@lang('app.agent_group')</td>
                                            <td>{{ $agent->present()->group }}</td>
                                        </tr>
                                        <tr>
                                            <td>Logging Name</td>
                                            <td>{{ $agent->present()->logger_id }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('app.agent_created_at')</td>
                                            <td>{{ $agent->created_at->toDayDateTimeString() }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('app.agent_updated_at')</td>
                                            <td>{{ $agent->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    </tbody>

                                </table>

                                <table border="0" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50%">Agent Contact Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>GSF Forum Name</td>
                                            <td>{{ $agent->present()->gsf_forum_name }}</td>
                                        </tr>

                                        <tr>
                                            <td>Jabber</td>

                                            <td id="jabber_name"><a href="#"
                                                    onclick="copyToClipboard('#jabber_name')">{{ $agent->present()->jabber_name }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Discord</td>
                                            <td>{{ $agent->present()->discord_name }}</td>
                                        </tr>

                                    </tbody>

                                </table>

                                <table border="0" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50%">Agent Ingame Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>Main Character</td>
                                            <td><a href="https://zkillboard.com/search/{{ $agent->present()->main_character_name }}/"
                                                    target="_blank">{{ $agent->present()->main_character_name }}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Corporation</td>
                                            <td>{{ $agent->present()->main_character_corporation }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alliance</td>
                                            <td>{{ $agent->present()->main_character_alliance }}</td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-9">
                        <!-- Agent Tags Avaliable-->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agent Tags Avaliable
                                </div>

                                <div class="panel-body">
                                        @if (count($agentTags))
                                        @foreach ($agentTags as $tag)

                                        <a href="{{ route('agent_tags.assignTag', [$agent->id, $tag->id]) }}" class="btn btn-{{ $tag->colour_tag }} }}" id="{{ $tag->id }}">{{ $tag->name }}</a>

                                        @endforeach
                                        @endif
                                </div>
                            </div>
                        </div>

                        <!-- Agent Tags Assigned -->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agent Tags Assigned
                                </div>

                                <div class="panel-body">
                                        @if (count($currentTags))
                                        @foreach ($currentTags as $tag)
                                        <a href="{{ route('agent_tags.removeTag', [$agent->id, $tag->tag->id]) }}" class="btn btn-{{ $tag->tag->colour_tag }} }}" id="{{ $tag->tag->id }}">{{ $tag->tag->name }}</a>
                                        @endforeach
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <!-- Agent Tiemzones Avaliable-->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agent Timezones Avaliable
                                </div>

                                <div class="panel-body">
                                        @if (count($agentTimezones))
                                        @foreach ($agentTimezones as $t)

                                        <a href="{{ route('agent_timezones.assignTimezone', [$agent->id, $t->id]) }}" class="btn btn-{{ $t->colour_tag }} }}" id="{{ $t->id }}">{{ $t->name }}</a>

                                        @endforeach
                                        @endif
                                </div>
                            </div>
                        </div>

                        <!-- Agent Timezones Assigned -->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agent Timezones Assigned
                                </div>

                                <div class="panel-body">
                                        @if (count($avaliableTimezones))
                                        @foreach ($avaliableTimezones as $t)
                                        <a href="{{ route('agent_timezones.removeTimezone', [$agent->id, $t->timezone->id]) }}" class="btn btn-{{ $t->timezone->colour_tag }} }}" id="{{ $t->timezone->id }}">{{ $t->timezone->name }}</a>
                                        @endforeach
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <!-- Agent Groups Avaliable-->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agent Groups Avaliable
                                </div>

                                <div class="panel-body">
                                <div class="col-md-11">
                                {!! Form::open(['route' => 'group.assignGroup', 'id' => 'add-group-form']) !!}
                                    <div class="form-group">
                                        {!! Form::select('group_id', $avaliableGroups, null,
                                        ['class' => 'form-control', 'id' => 'group_id']) !!}
                                        <input type="hidden" value="{{ $agent->id }}" name="agent_id">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-default" type="submit" id="assign-groups-btn">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </button>
                                </div>
                                {!! Form::close() !!}
                                </div>
                            </div>
                        </div> 

                        <!-- Agent Groups Assigned -->
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Agent Groups Assigned
                                </div>

                                <div class="panel-body">
                                        @if (count($agentGroups))
                                        @foreach ($agentGroups as $group)
                                        <a href="{{ route('group.removeGroup', [$agent->id, $group->group->id]) }}" class="btn btn-primary" id="{{ $group->group->id }}">{{ $group->group->group }}</a>
                                        @endforeach
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Agent Actions -->
                    <div class="col-md-3">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Actions
                                    </div>
                                    <div class="panel-body">
                                        <table class="table notes">
                                            <thead>
                                                <tr>
                                                    <th>Actions</th>

                                                </tr>
                                            </thead>

                                            <table border="0" class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Toggle Agent Status</td>

                                                        <td>
                                                            @if ($agent->status === 'Active')
                                                            <span class="label label-success }}">{{ $agent->status }}</span>
                                                            @else
                                                            <span class="label label-danger }}">{{ $agent->status }}</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('agent.toggle_status', $agent->id) }}"
                                                                class="btn btn-primary btn-circle edit" title="Activate/Deactivate the Agent."
                                                                data-toggle="tooltip" data-placement="top">
                                                                <i class="glyphicon glyphicon-refresh"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Toggle Relay Status</td>

                                                        <td>
                                                            @if ($agent->logger_active === 'Active')
                                                            <span class="label label-success }}">{{ $agent->logger_active }}</span>
                                                            @else
                                                            <span class="label label-danger }}">{{ $agent->logger_active }}</span>
                                                            @endif
                                                        </td>

                                                        <td>

                                                            <a href="{{ route('agent.toggle_relay', $agent->id) }}"
                                                                class="btn btn-info btn-circle edit"
                                                                title="Activate/Deactivate the Agents Relay Status." data-toggle="tooltip"
                                                                data-placement="top">
                                                                <i class="glyphicon glyphicon-refresh"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                    @role('Spymaster')
                                                    <tr>
                                                        <td>Confirm Relay Running</td>
                                                        @if($agent->confirm_relay == "")
                                                        <td></td>
                                                        @else
                                                        <td>
                                                            <span class="label label-default">{{ $agent->confirm_relay }}</span> <span
                                                                class="label label-default">{{ Carbon\Carbon::parse($agent->confirm_relay)->diffForHumans() }}</span>
                                                            <br>
                                                        </td>
                                                        @endif
                                                        <td>

                                                            <a href="{{ route('agent.confirm_relay', $agent->id) }}"
                                                                class="btn btn-success btn-circle edit"
                                                                title="Confirm the Agents Relay is Running." data-toggle="tooltip"
                                                                data-placement="top">
                                                                <i class="glyphicon glyphicon-ok"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                    @endrole
                                                    <tr>
                                                        <td>Last Contacted</td>
                                                        @if($agent->last_contacted == "0000-00-00 00:00:00")
                                                        <td></td>
                                                        @else
                                                        <td>
                                                            <span class="label label-default }}">{{ $agent->last_contacted }}</span> <span
                                                                class="label label-default">{{ Carbon\Carbon::parse($agent->last_contacted)->diffForHumans() }}
                                                            </span>
                                                            <br>
                                                        </td>
                                                        @endif
                                                        <td>

                                                            <a href="{{ route('agent.contacted', $agent->id) }}"
                                                                class="btn btn-success btn-circle edit" title="Agent Contacted"
                                                                data-toggle="tooltip" data-placement="top">
                                                                <i class="glyphicon glyphicon-ok"></i>
                                                            </a>

                                                        </td>
                                                    </tr>

                                                </tbody>

                                            </table>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                
                </div>
                
        </div>

        <div id="agent_notes" class="tab-pane fade">
            <div class="row col-md-12">
                <!-- Agent Notes -->

                    <div class="row tab-search">
                        <div class="col-md-1">
                            <a href="{{ route('agent.edit', $agent->id) }}" class="btn btn-primary" id="add-agent">
                                <i class="glyphicon glyphicon-plus"></i>
                                Edit Agent Notes
                            </a>
                        </div>		
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Agent Notes</h4>
                            <p>
                            Agent notes should be compiled over time based on the activity log's data & information about the agent in as much detail as possible.
                            </p>
                        </div>
                        <div class="panel-body">
                            <table class="table notes">
                                <thead>
                                    <tr>
                                        <th>@lang('app.notes')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{!! $agent->notes !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
               
                
               

            </div>
        </div>

        <div id="activity_log" class="tab-pane fade">

            @include('agent.partials.notes')

        </div>
</div>

@stop

@section('scripts')
<script>
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}
</script>

<script>
    $("#avaliableGroups").change(function () {
        $("#avaliableGroups").submit();
    });
    
</script>

@stop