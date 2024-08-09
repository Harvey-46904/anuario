<?php

namespace App\Observers;

use App\Models\Colegio;
use Illuminate\Support\Facades\Log;
class PostColegio
{
    /**
     * Handle the Colegio "created" event.
     *
     * @param  \App\Models\Colegio  $colegio
     * @return void
     */
    public function created(Colegio $colegio)
    {
        Log::info('Observer ejecutado para colegio creado: ' );
    }

}
