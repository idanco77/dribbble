<?php

namespace App\Providers;

use App\Repositories\Contracts\{CommentContract, InvitationContract, TeamContract, UserContract, DesignContract};
use App\Repositories\Eloquent\{CommentRepository,
    DesignRepository,
    InvitationRepository,
    TeamRepository,
    UserRepository};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(DesignContract::class, DesignRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(CommentContract::class, CommentRepository::class);
        $this->app->bind(TeamContract::class, TeamRepository::class);
        $this->app->bind(InvitationContract::class, InvitationRepository::class);
    }
}
