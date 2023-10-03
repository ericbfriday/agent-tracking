<?php

namespace Vanguard\Providers;

use Carbon\Carbon;
use Vanguard\Repositories\Activity\ActivityRepository;
use Vanguard\Repositories\Activity\EloquentActivity;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Country\EloquentCountry;
use Vanguard\Repositories\Permission\EloquentPermission;
use Vanguard\Repositories\Permission\PermissionRepository;
use Vanguard\Repositories\Role\EloquentRole;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Session\DbSession;
use Vanguard\Repositories\Session\SessionRepository;
use Vanguard\Repositories\User\EloquentUser;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\Group\EloquentGroup;
use Vanguard\Repositories\Group\GroupRepository;
use Vanguard\Repositories\Agent\AgentRepository;
use Vanguard\Repositories\Agent\EloquentAgent;
use Vanguard\Repositories\AgentNotes\AgentNotesRepository;
use Vanguard\Repositories\AgentNotes\EloquentAgentNotes;
use Vanguard\Repositories\Handler\HandlerRepository;
use Vanguard\Repositories\Handler\EloquentHandler;
use Vanguard\Repositories\Posts\PostsRepository;
use Vanguard\Repositories\Posts\EloquentPosts;
use Vanguard\Repositories\AgentTags\AgentTagsRepository;
use Vanguard\Repositories\AgentTags\EloquentAgentTags;
use Vanguard\Repositories\AgentTimezones\AgentTimezonesRepository;
use Vanguard\Repositories\AgentTimezones\EloquentAgentTimezones;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        config(['app.name' => settings('app_name')]);
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, EloquentUser::class);
        $this->app->singleton(ActivityRepository::class, EloquentActivity::class);
        $this->app->singleton(RoleRepository::class, EloquentRole::class);
        $this->app->singleton(PermissionRepository::class, EloquentPermission::class);
        $this->app->singleton(SessionRepository::class, DbSession::class);
        $this->app->singleton(CountryRepository::class, EloquentCountry::class);
        $this->app->singleton(GroupRepository::class, EloquentGroup::class);
        $this->app->singleton(AgentRepository::class, EloquentAgent::class);
        $this->app->singleton(HandlerRepository::class, EloquentHandler::class);
        $this->app->singleton(AgentNotesRepository::class, EloquentAgentNotes::class);
        $this->app->singleton(PostsRepository::class, EloquentPosts::class);
        $this->app->singleton(AgentTagsRepository::class, EloquentAgentTags::class);
        $this->app->singleton(AgentTimezonesRepository::class, EloquentAgentTimezones::class);
        
    }
}
