<?php

namespace App\Actions;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar la clase Auth
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Log;
class PublicacionesList extends AbstractAction
{
    public function getTitle()
    {
        return 'Subir Contenido';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        $user = Auth::user();
        $rol_data=$user->role_id;
        //id correspondeinte a estudiante =3
      
        return $this->dataType->slug == 'anuariosfins' && $rol_data ==3 ;
    }
   

    public function getDefaultRoute()
    {
        return route('publicaciones.index',  $this->data->id);
    }
}