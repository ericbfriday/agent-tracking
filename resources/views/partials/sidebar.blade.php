<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li class="sidebar-avatar">
				<div class="dropdown">
					<div>
						<img alt="image" class="img-circle avatar" width="100" src="{{ Auth::user()->present()->avatar }}">
					</div>
					<div class="name"><strong>{{ Auth::user()->present()->nameOrEmail }}</strong></div>
				</div>
			</li>
			
			<li class="{{ Request::is('/') ? 'active open' : ''  }}">
				<a href="{{ route('dashboard') }}" class="{{ Request::is('/') ? 'active' : ''  }}">
					<i class="fa fa-dashboard fa-fw"></i> @lang('app.dashboard')
				</a>
			</li>

			<li class="{{ Request::is('help') ? 'active open' : ''  }}">
				<a href="{{ route('help') }}" class="{{ Request::is('help') ? 'active' : ''  }}">
					<i class="fa fa-ambulance fa-fw"></i> Help
				</a>
			</li>

			<li class="{{ Request::is('agent/mine*') ? 'active open' : ''  }}">
				<a href="#">
					<i class="fa fa-user-secret fa-fw"></i>
					My Agents
					<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">

					<li class="{{ Request::is('agent/mine/active') ? 'active open' : ''  }}">
						<a href="{{ route('agent.mine-active') }}" class="{{ Request::is('agent/mine/active') ? 'active' : ''  }}">
							Active Agents
						</a>
					</li>

					<li class="{{ Request::is('agent/mine') ? 'active open' : ''  }}">
						<a href="{{ route('agent.mine') }}" class="{{ Request::is('agent/mine') ? 'active' : ''  }}">
							All Agents
						</a>
					</li>

					<li class="{{ Request::is('agent/mine/inactive') ? 'active open' : ''  }}">
						<a href="{{ route('agent.mine-inactive') }}" class="{{ Request::is('agent/mine/inactive') ? 'active' : ''  }}">
							Inactive Agents
						</a>
					</li>
				</ul>
			</li>

			<!-- Spy Masters Post Menu -->
			@role('Spymaster')
			<li class="{{ Request::is('post*') ||  
						  Request::is('agent_tags*') ||
						  Request::is('agents*') ||
						  Request::is('agent-note*') ||
						  Request::is('group*') ||
						  Request::is('handlers*') ||
						  Request::is('agent_timezones*') ||
						  Request::is('spymaster/reports*') 
						  ? 'active open' : ''  }}">
				<a href="#">
					<i class="fa fa-eye fa-fw"></i>
					Spymaster Management
					<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">
					<li class="{{ Request::is('agents*') ? 'active open' : ''  }}">
						<a href="{{ route('agent.list') }}" class="{{ Request::is('agents*') ? 'active' : ''  }}">
							Agents
						</a>
					</li>

					<li class="{{ Request::is('agent_tags*') ? 'active open' : ''  }}">
						<a href="{{ route('agent_tags.list') }}" class="{{ Request::is('agent_tags*') ? 'active' : ''  }}">
							Agent Tags
						</a>
					</li>
					
					<li class="{{ Request::is('agent_timezones*') ? 'active open' : ''  }}">
						<a href="{{ route('agent_timezones.list') }}" class="{{ Request::is('agent_timezones*') ? 'active' : ''  }}">
							Agent Timezones
						</a>
					</li>

					<li class="{{ Request::is('agent-note*') ? 'active open' : ''  }}">
						<a href="{{ route('agentnotes.list') }}" class="{{ Request::is('agent-note*') ? 'active' : ''  }}">
							Agent Activity Reports
						</a>
					</li>

					<li class="{{ Request::is('post*') ? 'active open' : ''  }}">
						<a href="{{ route('posts.list') }}" class="{{ Request::is('post*') ? 'active' : ''  }}">
							Dashboard Posts
						</a>
					</li>

					<li class="{{ Request::is('handlers*') ? 'active open' : ''  }}">
						<a href="{{ route('handler.list') }}" class="{{ Request::is('handlers*') ? 'active' : ''  }}">
							Handlers
						</a>
					</li>

					<li class="{{ Request::is('group*') ? 'active open' : ''  }}">
						<a href="{{ route('group.list') }}" class="{{ Request::is('group*') ? 'active' : ''  }}">
							Reporting Groups
						</a>
					</li>

					<li class="{{ Request::is('spymaster/reports*') ? 'active open' : ''  }}">
						<a href="{{ route('spymaster_reports.list') }}" class="{{ Request::is('spymaster/reports*') ? 'active' : ''  }}">
							Weekly Reports
						</a>
					</li>
			
				</ul>
			</li>
			@endrole


			@permission('users.manage')

			<li class="{{ Request::is('user*') ? 'active open' : ''  }}">
				<a href="#">
					<i class="fa fa-user fa-fw"></i>
					Users
					<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level collapse">


					<li class="{{ Request::is('user*') || Request::is('activity*') ? 'active open' : ''  }}">
						<a href="{{ route('user.list') }}" class="{{ Request::is('user*') ? 'active' : ''  }}">
						</i> @lang('app.users')
					</a>
				</li>

				<li class="{{ Request::is('active-users') ? 'active open' : ''  }}">
					<a href="{{ route('active-users') }}" class="{{ Request::is('active-users') ? 'active' : ''  }}">
					</i> Active Users
				</a>
			</li>



		</ul>
	</li>
	@endpermission

	@permission('metrics.view')
	<li class="{{ Request::is('metrics*') ? 'active open' : ''  }}">
		<a href="{{ route('metrics.index') }}" class="{{ Request::is('metrics*') ? 'active' : ''  }}">
			<i class="fa fa-cube fa-fw"></i> Metrics
		</a>
	</li>
	@endpermission

	@permission('users.activity')
	<li class="{{ Request::is('activity*') ? 'active open' : ''  }}">
		<a href="{{ route('activity.index') }}" class="{{ Request::is('activity*') ? 'active' : ''  }}">
			<i class="fa fa-list-alt fa-fw"></i> @lang('app.activity_log')
		</a>
	</li>
	@endpermission





	



	@permission(['roles.manage', 'permissions.manage'])
	<li class="{{ Request::is('role*') || Request::is('permission*') ? 'active open' : ''  }}">
		<a href="#">
			<i class="fa fa-user fa-fw"></i>
			@lang('app.roles_and_permissions')
			<span class="fa arrow"></span>
		</a>
		<ul class="nav nav-second-level collapse">
			@permission('roles.manage')
			<li>
				<a href="{{ route('role.index') }}" class="{{ Request::is('role*') ? 'active' : ''  }}">
					@lang('app.roles')
				</a>
			</li>
			@endpermission
			@permission('permissions.manage')
			<li>
				<a href="{{ route('permission.index') }}"
				class="{{ Request::is('permission*') ? 'active' : ''  }}">@lang('app.permissions')</a>
			</li>
			@endpermission
		</ul>
	</li>
	@endpermission

	@permission(['settings.general', 'settings.auth', 'settings.notifications'], false)
	<li class="{{ Request::is('settings*') ? 'active open' : ''  }}">
		<a href="#">
			<i class="fa fa-gear fa-fw"></i> @lang('app.settings')
			<span class="fa arrow"></span>
		</a>
		<ul class="nav nav-second-level collapse">
			@permission('settings.general')
			<li>
				<a href="{{ route('settings.general') }}"
				class="{{ Request::is('settings') ? 'active' : ''  }}">
				@lang('app.general')
			</a>
		</li>
		@endpermission
		@permission('settings.auth')
		<li>
			<a href="{{ route('settings.auth') }}"
			class="{{ Request::is('settings/auth*') ? 'active' : ''  }}">
			@lang('app.auth_and_registration')
		</a>
	</li>
	@endpermission
	@permission('settings.notifications')
	<li>
		<a href="{{ route('settings.notifications') }}"
		class="{{ Request::is('settings/notifications*') ? 'active' : ''  }}">
		@lang('app.notifications')
	</a>
</li>
@endpermission
</ul>
</li>
@endpermission
</ul>
</div>
<!-- /.sidebar-collapse -->
</div>