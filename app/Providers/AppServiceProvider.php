<?php

namespace App\Providers;
use TCG\Voyager\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Models\User as VoyagerUser;
use App\Observers\PostColegio;
use App\Models\Colegio;
use App\Models\User as Usernew;
use TCG\Voyager\Facades\Voyager;
use \App\Actions\EstudiantesList;
use \App\Actions\PublicacionesList;
use \App\Actions\AnuarioList;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        VoyagerUser::observe(UserObserver::class);
        Colegio::observe(PostColegio::class);
        Voyager::useModel('User', Usernew::class);
        Voyager::addAction(EstudiantesList::class);
        Voyager::addAction(PublicacionesList::class);
        Voyager::addAction(AnuarioList::class);
        
    }
}
