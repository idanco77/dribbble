<?php

namespace App\Providers;

use App\Repositories\Contracts\{UserContract, DesignContract};
use App\Repositories\Eloquent\{DesignRepository, UserRepository};

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
    }
}
