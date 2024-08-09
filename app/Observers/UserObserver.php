<?php

namespace App\Observers;


use TCG\Voyager\Models\User;
use Illuminate\Support\Facades\Log;
class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param TCG\Voyager\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        //validacion de personas
        Log::info('Observer ejecutado para usuario creado: ' . $user);
    }

   
}
