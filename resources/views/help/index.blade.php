@extends('layouts.app')

@section('page-title', 'Help Dashboard')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Help Dashboard
			<div class="pull-right">
				<ol class="breadcrumb">
					<li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
					<li class="active">Help</li>
				</ol>
			</div>
		</h1>
	</div>
</div>

<li><a href="#help-me">Black Hand Help</a>
	<ul>
		<li><a href="#dashboard">Dashboard</a></li>
		<li><a href="#handlers">Handlers</a></li>
		<li><a href="#agents">Adding Agents</a></li>
		<li><a href="#manage-agents">Managing Agents</a></li>

</ul>

<hr />

<p><a name="help-me"></a></p>
<h3>How to use these tools.</h3>
<p><a name="handlers"></a></p>

<h3>Dashboard</h3>
<p>Upon logging in you will be brought to your dashboard. The dashboard will allow you to navigate the tools and provide you with key information from the Spymaster.</p>
<p>From the dashboard you can see:</p>
<ul>
	<li>Navigation to Handlers/Agents.</li>
	<li>Provide real time updates from each agent's contact notes.</li>
	<li>Spymaster Updates and Actions required.</li>
	<li>Handlers daily activity.</li>
</ul>

<h3>Your Handlers</h3>
<p>Once you have spoken to the spymaster, they will allocate a handler(s) to you account. Once you have access to your handler(s).</p>
<ul>
	<li>Update all information related to that handler.</li>
	<li>Add your agents under each handler.</li>
	<li>Carry out actions for each agent.</li>
</ul>


</div>



@stop