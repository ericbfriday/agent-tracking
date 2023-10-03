<?php

/**
 * Authentication
 */

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');

Route::get('logout', [
	'as' => 'auth.logout',
	'uses' => 'Auth\AuthController@getLogout'
]);

// Allow registration routes only if registration is enabled.
if (settings('reg_enabled')) {
	Route::get('register', 'Auth\AuthController@getRegister');
	Route::post('register', 'Auth\AuthController@postRegister');
	Route::get('register/confirmation/{token}', [
		'as' => 'register.confirm-email',
		'uses' => 'Auth\AuthController@confirmEmail'
	]);
}

// Register password reset routes only if it is enabled inside website settings.
if (settings('forgot_password')) {
	Route::get('password/remind', 'Auth\PasswordController@forgotPassword');
	Route::post('password/remind', 'Auth\PasswordController@sendPasswordReminder');
	Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
	Route::post('password/reset', 'Auth\PasswordController@postReset');
}

/**
 * Two-Factor Authentication
 */
if (settings('2fa.enabled')) {
	Route::get('auth/two-factor-authentication', [
		'as' => 'auth.token',
		'uses' => 'Auth\AuthController@getToken'
	]);

	Route::post('auth/two-factor-authentication', [
		'as' => 'auth.token.validate',
		'uses' => 'Auth\AuthController@postToken'
	]);
}

/**
 * Social Login
 */
Route::get('auth/{provider}/login', [
	'as' => 'social.login',
	'uses' => 'Auth\SocialAuthController@redirectToProvider',
	'middleware' => 'social.login'
]);

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::get('auth/twitter/email', 'Auth\SocialAuthController@getTwitterEmail');
Route::post('auth/twitter/email', 'Auth\SocialAuthController@postTwitterEmail');

Route::group(['middleware' => 'auth'], function () {

    /**
     * Dashboard
     */

    Route::get('/', [
    	'as' => 'dashboard',
    	'uses' => 'DashboardController@index'
    ]);

    Route::get('help', [
    	'as' => 'help',
    	'uses' => 'DashboardController@help'
    ]);


    /**
     * User Profile
     */

    Route::get('profile', [
    	'as' => 'profile',
    	'uses' => 'ProfileController@index'
    ]);

    Route::get('profile/activity', [
    	'as' => 'profile.activity',
    	'uses' => 'ProfileController@activity'
    ]);

    Route::put('profile/details/update', [
    	'as' => 'profile.update.details',
    	'uses' => 'ProfileController@updateDetails'
    ]);

    Route::post('profile/avatar/update', [
    	'as' => 'profile.update.avatar',
    	'uses' => 'ProfileController@updateAvatar'
    ]);

    Route::post('profile/avatar/update/external', [
    	'as' => 'profile.update.avatar-external',
    	'uses' => 'ProfileController@updateAvatarExternal'
    ]);

    Route::put('profile/login-details/update', [
    	'as' => 'profile.update.login-details',
    	'uses' => 'ProfileController@updateLoginDetails'
    ]);

    Route::post('profile/two-factor/enable', [
    	'as' => 'profile.two-factor.enable',
    	'uses' => 'ProfileController@enableTwoFactorAuth'
    ]);

    Route::post('profile/two-factor/disable', [
    	'as' => 'profile.two-factor.disable',
    	'uses' => 'ProfileController@disableTwoFactorAuth'
    ]);

    Route::get('profile/sessions', [
    	'as' => 'profile.sessions',
    	'uses' => 'ProfileController@sessions'
    ]);

    Route::delete('profile/sessions/{session}/invalidate', [
    	'as' => 'profile.sessions.invalidate',
    	'uses' => 'ProfileController@invalidateSession'
    ]);

    /**
     * User Management
     */
    Route::get('user', [
    	'as' => 'user.list',
    	'uses' => 'UsersController@index'
    ]);

    Route::get('user/create', [
    	'as' => 'user.create',
    	'uses' => 'UsersController@create'
    ]);

    Route::post('user/create', [
    	'as' => 'user.store',
    	'uses' => 'UsersController@store'
    ]);

    Route::get('user/{user}/show', [
    	'as' => 'user.show',
    	'uses' => 'UsersController@view'
    ]);

    Route::get('user/{user}/edit', [
    	'as' => 'user.edit',
    	'uses' => 'UsersController@edit'
    ]);

    Route::put('user/{user}/update/details', [
    	'as' => 'user.update.details',
    	'uses' => 'UsersController@updateDetails'
    ]);

    Route::put('user/{user}/update/login-details', [
    	'as' => 'user.update.login-details',
    	'uses' => 'UsersController@updateLoginDetails'
    ]);

    Route::delete('user/{user}/delete', [
    	'as' => 'user.delete',
    	'uses' => 'UsersController@delete'
    ]);

    Route::post('user/{user}/update/avatar', [
    	'as' => 'user.update.avatar',
    	'uses' => 'UsersController@updateAvatar'
    ]);

    Route::post('user/{user}/update/avatar/external', [
    	'as' => 'user.update.avatar.external',
    	'uses' => 'UsersController@updateAvatarExternal'
    ]);

    Route::get('user/{user}/sessions', [
    	'as' => 'user.sessions',
    	'uses' => 'UsersController@sessions'
    ]);

    Route::delete('user/{user}/sessions/{session}/invalidate', [
    	'as' => 'user.sessions.invalidate',
    	'uses' => 'UsersController@invalidateSession'
    ]);

    Route::post('user/{user}/two-factor/enable', [
    	'as' => 'user.two-factor.enable',
    	'uses' => 'UsersController@enableTwoFactorAuth'
    ]);

    Route::post('user/{user}/two-factor/disable', [
    	'as' => 'user.two-factor.disable',
    	'uses' => 'UsersController@disableTwoFactorAuth'
    ]);

    /**
     * Active Users
     */
    
    Route::get('active-users', 'ActiveUsersController@index')->name('active-users');

    Route::get('spymaster/reports', [
    	'as' => 'spymaster_reports.list',
    	'uses' => 'SpymasterReportController@index',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('spymaster/reports/{end_date}/view', [
    	'as' => 'spymaster_reports.view',
    	'uses' => 'SpymasterReportController@view',
        'middleware' => 'role:Spymaster'
    ]);


    /**
     * Group Management
     */
    Route::get('group', [
    	'as' => 'group.list',
    	'uses' => 'GroupsController@index',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('group/create', [
    	'as' => 'group.create',
    	'uses' => 'GroupsController@create',
        'middleware' => 'role:Spymaster'
    ]);

    Route::post('group/create', [
    	'as' => 'group.store',
    	'uses' => 'GroupsController@store',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('group/{group}/show', [
    	'as' => 'group.show',
    	'uses' => 'GroupsController@view',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('group/{group}/update-esi/{name}', [
    	'as' => 'group.update-esi',
    	'uses' => 'GroupsController@getESIDetails',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('group/{group}/edit', [
    	'as' => 'group.edit',
    	'uses' => 'GroupsController@edit',
        'middleware' => 'role:Spymaster'
    ]);

    Route::put('group/{group}/update/details', [
    	'as' => 'group.update.details',
    	'uses' => 'GroupsController@updateDetails',
        'middleware' => 'role:Spymaster'
    ]);

    Route::post('group/assignTag', [
        'as' => 'group.assignGroup',
        'uses' => 'GroupsController@assignGroup'
    ]);

    Route::get('group/removeTag/{agent_id}/{group_id}', [
        'as' => 'group.removeGroup',
        'uses' => 'GroupsController@removeGroup'
    ]);

    /**
     * Agent Tag Management
     */
    Route::get('agent_tags', [
        'as' => 'agent_tags.list',
        'uses' => 'AgentTagsController@index',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('agent_tags/create', [
        'as' => 'agent_tags.create',
        'uses' => 'AgentTagsController@create',
        'middleware' => 'role:Spymaster'
    ]);

    Route::post('agent_tags/create', [
        'as' => 'agent_tags.store',
        'uses' => 'AgentTagsController@store',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('agent_tags/{tag}/show', [
        'as' => 'agent_tags.show',
        'uses' => 'AgentTagsController@view',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('agent_tags/{tag}/edit', [
        'as' => 'agent_tags.edit',
        'uses' => 'AgentTagsController@edit',
        'middleware' => 'role:Spymaster'
    ]);

    Route::put('agent_tags/{tag}/update/details', [
        'as' => 'agent_tags.update.details',
        'uses' => 'AgentTagsController@updateDetails',
        'middleware' => 'role:Spymaster'
    ]);

    Route::delete('agent_tags/{tag}/delete', [
        'as' => 'agent_tags.delete',
        'uses' => 'AgentTagsController@delete',
        'middleware' => 'role:Spymaster'

    ]);

    Route::get('agent_tags/assignTag/{agent_id}/{tag_id}', [
        'as' => 'agent_tags.assignTag',
        'uses' => 'AgentTagsController@assignTag'
    ]);

    Route::get('agent_tags/removeTag/{agent_id}/{tag_id}', [
        'as' => 'agent_tags.removeTag',
        'uses' => 'AgentTagsController@removeTag'
    ]);

    /**
     * Agent Tag Management
     */
    Route::get('agent_timezones', [
        'as' => 'agent_timezones.list',
        'uses' => 'AgentTimezonesController@index',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('agent_timezones/create', [
        'as' => 'agent_timezones.create',
        'uses' => 'AgentTimezonesController@create',
        'middleware' => 'role:Spymaster'
    ]);

    Route::post('agent_timezones/create', [
        'as' => 'agent_timezones.store',
        'uses' => 'AgentTimezonesController@store',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('agent_timezones/{timezone}/show', [
        'as' => 'agent_timezones.show',
        'uses' => 'AgentTimezonesController@view',
        'middleware' => 'role:Spymaster'
    ]);

    Route::get('agent_timezones/{timezone}/edit', [
        'as' => 'agent_timezones.edit',
        'uses' => 'AgentTimezonesController@edit',
        'middleware' => 'role:Spymaster'
    ]);

    Route::put('agent_timezones/{timezone}/update/details', [
        'as' => 'agent_timezones.update.details',
        'uses' => 'AgentTimezonesController@updateDetails',
        'middleware' => 'role:Spymaster'
    ]);

    Route::delete('agent_timezones/{timezone}/delete', [
        'as' => 'agent_timezones.delete',
        'uses' => 'AgentTimezonesController@delete',
        'middleware' => 'role:Spymaster'

    ]);

    Route::get('agent_timezones/assignTimezone/{agent_id}/{timezone_id}', [
        'as' => 'agent_timezones.assignTimezone',
        'uses' => 'AgentTimezonesController@assignTimezone'
    ]);

    Route::get('agent_timezones/removeTimezone/{agent_id}/{timezone_id}', [
        'as' => 'agent_timezones.removeTimezone',
        'uses' => 'AgentTimezonesController@removeTimezone'
    ]);

    /**
     * Spymaster Post Management
     */
        Route::get('post', [
        	'as' => 'posts.list',
        	'uses' => 'PostController@index'
        ]);

        Route::get('post/create', [
        	'as' => 'posts.create',
        	'uses' => 'PostController@create'
        ]);

        Route::post('post/create', [
        	'as' => 'posts.store',
        	'uses' => 'PostController@store'
        ]);

        Route::get('post/{post}/show', [
        	'as' => 'posts.show',
        	'uses' => 'PostController@view'
        ]);

        Route::get('post/{post}/edit', [
        	'as' => 'posts.edit',
        	'uses' => 'PostController@edit'
        ]);

        Route::put('post/{post}/update/details', [
        	'as' => 'posts.update.details',
        	'uses' => 'PostController@updateDetails'
        ]);

        Route::delete('post/{post}/delete', [
            'as' => 'posts.delete',
            'uses' => 'PostController@delete',
            'middleware' => 'role:Spymaster'

        ]);

     /**
     * Active Groups
     */

     Route::get('active-groups', 'ActiveGroupsController@index')->name('active-groups');

     /**
     * Agent Management
     */

     Route::get('agents', [
     	'as' => 'agent.list',
     	'uses' => 'AgentsController@index'
     ]);

     Route::get('agent/export', [
     	'as' => 'agent.csv',
     	'uses' => 'AgentsController@exportAgents'
     ]);

     Route::get('agent/mine', [
     	'as' => 'agent.mine',
     	'uses' => 'AgentsController@myAgents'
     ]);

     Route::get('agent/mine/active', [
     	'as' => 'agent.mine-active',
     	'uses' => 'AgentsController@myActiveAgents'
     ]);

     Route::get('agent/mine/inactive', [
     	'as' => 'agent.mine-inactive',
     	'uses' => 'AgentsController@myInactiveAgents'
     ]);

     Route::get('agents/create', [
     	'as' => 'agent.create',
     	'uses' => 'AgentsController@create'
     ]);

     Route::post('agents/create', [
     	'as' => 'agent.store',
     	'uses' => 'AgentsController@store'
     ]);

     Route::get('agents/{agent}/show', [
     	'as' => 'agent.show',
     	'uses' => 'AgentsController@view'
     ]);

     Route::get('agents/{agent}/edit', [
     	'as' => 'agent.edit',
     	'uses' => 'AgentsController@edit'
     ]);

     Route::put('agents/{agent}/update/details', [
     	'as' => 'agent.update.details',
     	'uses' => 'AgentsController@updateDetails'
     ]);

     Route::get('agents/{agent}/relay', [
     	'as' => 'agent.toggle_relay',
     	'uses' => 'AgentsController@toggleRelayStatus'
     ]);

     Route::get('agents/{agent}/status', [
     	'as' => 'agent.toggle_status',
     	'uses' => 'AgentsController@toggleAgentStatus'
     ]);

     Route::get('agents/{agent}/relay/confirm', [
     	'as' => 'agent.confirm_relay',
     	'uses' => 'AgentsController@confirmAgentRelayRunning',
        'middleware' => 'role:Spymaster'
    ]);

     Route::get('agents/{agent}/confirm/manual', [
     	'as' => 'agent.confirm_manual',
     	'uses' => 'AgentsController@confirmAgentHasRecievedManual'
     ]);

     Route::get('agents/{agent}/confirm/questionaire', [
     	'as' => 'agent.confirm_questionaire',
     	'uses' => 'AgentsController@confirmAgenthasCompletedQuestionaire'
     ]);

     Route::get('agents/{agent}/contacted', [
     	'as' => 'agent.contacted',
     	'uses' => 'AgentsController@agentContacted'
     ]);


     

     



     /**
     * Active Agents
     */

     Route::get('agents/active-agents', [
     	'as' => 'active-agents',
     	'uses' => 'ActiveAgentsController@index'
     ]);

     /**
     * My Agents
     */

     Route::get('my-agents', 'MyAgentsController@index')->name('my-agents');


     /**
     * Handlers Management
     */

     Route::get('handlers', [
     	'as' => 'handler.list',
     	'uses' => 'HandlersController@index'
     ]);


     Route::get('handler/mine', [
     	'as' => 'handler.mine',
     	'uses' => 'HandlersController@myHandlers'
     ]);

     Route::get('handler/mine/active', [
     	'as' => 'handler.mine-active',
     	'uses' => 'HandlersController@myActiveHandlers'
     ]);

     Route::get('handler/mine/inactive', [
     	'as' => 'handler.mine-inactive',
     	'uses' => 'HandlersController@myInactiveHandlers'
     ]);

     Route::get('handlers/create', [
     	'as' => 'handler.create',
     	'uses' => 'HandlersController@create'
     ]);

     Route::post('handlers/create', [
     	'as' => 'handler.store',
     	'uses' => 'HandlersController@store'
     ]);

     Route::get('handlers/{handler}/show', [
     	'as' => 'handler.show',
     	'uses' => 'HandlersController@view'
     ]);

     Route::get('handlers/{handler}/edit', [
     	'as' => 'handler.edit',
     	'uses' => 'HandlersController@edit'
     ]);

     Route::put('handlers/{handler}/update/details', [
     	'as' => 'handler.update.details',
     	'uses' => 'HandlersController@updateDetails'
     ]);

     /**
     * Active handlers
     */

     Route::get('handlers/active-handlers', [
     	'as' => 'active-handlers',
     	'uses' => 'ActiveHandlersController@index'
     ]);





     /**
     * My Handlers
     */

     Route::get('my-handlers', 'MyHandlersController@index')->name('my-handlers');

     /**
    * Agent Management
    */

     Route::get('agent-note', [
     	'as' => 'agentnotes.list',
     	'uses' => 'AgentNotesController@index',
        'middleware' => 'permission:agents.manage'
    ]);

     Route::get('agent-note/{noteid}/create', [
     	'as' => 'agentnotes.create',
     	'uses' => 'AgentNotesController@create'
     ]);

     Route::get('agent-note/{agent}/all', [
     	'as' => 'agentnotes.allAgentNotes',
     	'uses' => 'AgentNotesController@allAgentNotes'
     ]);

     Route::post('agent-note/{noteid}/create', [
     	'as' => 'agentnotes.store',
     	'uses' => 'AgentNotesController@store'
     ]);

     Route::get('agent-note/{agentNotes}/show', [
     	'as' => 'agentnotes.show',
     	'uses' => 'AgentNotesController@view',
        
     ]);


     /**
    * Contact Notifications
    */

     Route::get('/notifications/{id}/acknowledge', [
     	'as' => 'contactnote.acknowledge',
     	'uses' => 'ContactNotificationsController@acknowledgeNotification'
     ]);

     Route::get('spymaster/updates', [
     	'as' => 'contactnote.index',
     	'uses' => 'ContactNotificationsController@index'
     ]);





    /**
     * Metrics 
     */

    Route::get('metrics', [
    	'as' => 'metrics.index',
    	'uses' => 'MetricsController@index'
    ]);

    Route::get('metrics/agents', [
    	'as' => 'metrics.agents',
    	'uses' => 'AgentMetricsController@index'
    ]);


    Route::get('metrics/handlers', [
    	'as' => 'metrics.handlers',
    	'uses' => 'HandlerMetricsController@index'
    ]);


    Route::get('metrics/groups', [
    	'as' => 'metrics.groups',
    	'uses' => 'GroupMetricsController@index'
    ]);


    Route::get('metrics/users', [
    	'as' => 'metrics.users',
    	'uses' => 'UserMetricsController@index'
    ]);

    /**
     * Roles & Permissions
     */

    Route::get('role', [
    	'as' => 'role.index',
    	'uses' => 'RolesController@index'
    ]);

    Route::get('role/create', [
    	'as' => 'role.create',
    	'uses' => 'RolesController@create'
    ]);

    Route::post('role/store', [
    	'as' => 'role.store',
    	'uses' => 'RolesController@store'
    ]);

    Route::get('role/{role}/edit', [
    	'as' => 'role.edit',
    	'uses' => 'RolesController@edit'
    ]);

    Route::put('role/{role}/update', [
    	'as' => 'role.update',
    	'uses' => 'RolesController@update'
    ]);

    Route::delete('role/{role}/delete', [
    	'as' => 'role.delete',
    	'uses' => 'RolesController@delete'
    ]);


    Route::post('permission/save', [
    	'as' => 'permission.save',
    	'uses' => 'PermissionsController@saveRolePermissions'
    ]);

    Route::resource('permission', 'PermissionsController');



    /**
     * Settings
     */

    Route::get('settings', [
    	'as' => 'settings.general',
    	'uses' => 'SettingsController@general',
    	'middleware' => 'permission:settings.general'
    ]);

    Route::post('settings/general', [
    	'as' => 'settings.general.update',
    	'uses' => 'SettingsController@update',
    	'middleware' => 'permission:settings.general'
    ]);

    Route::get('settings/auth', [
    	'as' => 'settings.auth',
    	'uses' => 'SettingsController@auth',
    	'middleware' => 'permission:settings.auth'
    ]);

    Route::post('settings/auth', [
    	'as' => 'settings.auth.update',
    	'uses' => 'SettingsController@update',
    	'middleware' => 'permission:settings.auth'
    ]);

// Only allow managing 2FA if AUTHY_KEY is defined inside .env file
    if (env('AUTHY_KEY')) {
    	Route::post('settings/auth/2fa/enable', [
    		'as' => 'settings.auth.2fa.enable',
    		'uses' => 'SettingsController@enableTwoFactor',
    		'middleware' => 'permission:settings.auth'
    	]);

    	Route::post('settings/auth/2fa/disable', [
    		'as' => 'settings.auth.2fa.disable',
    		'uses' => 'SettingsController@disableTwoFactor',
    		'middleware' => 'permission:settings.auth'
    	]);
    }

    Route::post('settings/auth/registration/captcha/enable', [
    	'as' => 'settings.registration.captcha.enable',
    	'uses' => 'SettingsController@enableCaptcha',
    	'middleware' => 'permission:settings.auth'
    ]);

    Route::post('settings/auth/registration/captcha/disable', [
    	'as' => 'settings.registration.captcha.disable',
    	'uses' => 'SettingsController@disableCaptcha',
    	'middleware' => 'permission:settings.auth'
    ]);

    Route::get('settings/notifications', [
    	'as' => 'settings.notifications',
    	'uses' => 'SettingsController@notifications',
    	'middleware' => 'permission:settings.notifications'
    ]);

    Route::post('settings/notifications', [
    	'as' => 'settings.notifications.update',
    	'uses' => 'SettingsController@update',
    	'middleware' => 'permission:settings.notifications'
    ]);

    /**
     * Activity Log
     */

    Route::get('activity', [
    	'as' => 'activity.index',
    	'uses' => 'ActivityController@index'
    ]);

    Route::get('activity/user/{user}/log', [
    	'as' => 'activity.user',
    	'uses' => 'ActivityController@userActivity'
    ]);

});


/**
 * Installation
 */

$router->get('install', [
	'as' => 'install.start',
	'uses' => 'InstallController@index'
]);

$router->get('install/requirements', [
	'as' => 'install.requirements',
	'uses' => 'InstallController@requirements'
]);

$router->get('install/permissions', [
	'as' => 'install.permissions',
	'uses' => 'InstallController@permissions'
]);

$router->get('install/database', [
	'as' => 'install.database',
	'uses' => 'InstallController@databaseInfo'
]);

$router->get('install/start-installation', [
	'as' => 'install.installation',
	'uses' => 'InstallController@installation'
]);

$router->post('install/start-installation', [
	'as' => 'install.installation',
	'uses' => 'InstallController@installation'
]);

$router->post('install/install-app', [
	'as' => 'install.install',
	'uses' => 'InstallController@install'
]);

$router->get('install/complete', [
	'as' => 'install.complete',
	'uses' => 'InstallController@complete'
]);

$router->get('install/error', [
	'as' => 'install.error',
	'uses' => 'InstallController@error'
]);

