<?php

namespace App\Actions;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar la clase Auth
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Log;
class EstudiantesList extends AbstractAction
{
    public function getTitle()
    {
        return 'Gestionar Estudiantes';
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
        //id correspondeinte a admin =1
      
        return $this->dataType->slug == 'anuariosfins' && ($rol_data == 1 || $rol_data == 5);
    }
   

    public function getDefaultRoute()
    {
        return route('estudiantes.index',  $this->data->id);
    }
}