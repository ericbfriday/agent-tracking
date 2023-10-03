@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Metrics Dashboard
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">Metrics</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <a href="{{ route('metrics.users') }}" class="panel-link">
            <div class="panel panel-default dashboard-panel">
                <div class="panel-body">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <p class="lead">Registered Users</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
    	<a href="{{ route('metrics.agents') }}" class="panel-link">
    		<div class="panel panel-default dashboard-panel">
    			<div class="panel-body">
    				<div class="icon">
    					<i class="fa fa-user-secret"></i>
    				</div>
    				<p class="lead">Agents</p>
    			</div>
    		</div>
    	</a>
    </div>
    <div class="col-md-3">
    	<a href="{{ route('metrics.handlers') }}" class="panel-link">
    		<div class="panel panel-default dashboard-panel">
    			<div class="panel-body">
    				<div class="icon">
    					<i class="fa fa-users"></i>
    				</div>
    				<p class="lead">Handlers</p>
    			</div>
    		</div>
    	</a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('metrics.groups') }}" class="panel-link">
            <div class="panel panel-default dashboard-panel">
                <div class="panel-body">
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <p class="lead">Groups</p>
                </div>
            </div>
        </a>
    </div>

</div>


@stop

