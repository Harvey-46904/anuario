<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Events\BreadDataAdded;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacione;
class PublicacionesController extends Controller
{
    public function publicaciones_create ($id_anuario){
        
        return view("vendor.voyager.publicaciones.publicaciones_form",compact('id_anuario')); 
    }
    public function publicaciones_anuario($id_anuario){
        $anuario=$id_anuario;
        $user = Auth::user()->id;
        $resultado_filtrado=DB::table("publicaciones")
        ->select()
        //->join('users','users.id','=','anuariousers.id_user')
        ->where('publicaciones.id_anuario','=',$id_anuario)
        ->where('publicaciones.id_user','=',$user)
        ->paginate(15);
        $dataType = Voyager::model('DataType')->where('slug', 'anuario_users')->first();
        $dataTypeContent = $resultado_filtrado;
        $showCheckboxColumn = true; // Cambia esto según tu lógica
        return view('vendor.voyager.publicaciones.publicaciones_lista',compact('dataType', 'dataTypeContent', 'showCheckboxColumn','anuario'));
    }
    public function crear_publicacion(Request $request,$id_anuario){
       
        $user = Auth::user();
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
    
            // Crear un nombre único para el archivo
            $filename = time() . '.' . $file->getClientOriginalExtension();
    
            // Obtener el mes y año actual para crear la estructura de carpetas
            $datePath = now()->format('FY'); // Esto creará una cadena como "July_2024"
    
            // Crear la ruta completa para la carpeta y el archivo
            $destinationPath = public_path('storage/posts/' . $datePath);
            $file->move($destinationPath, $filename);
    
            // Asignar la ruta del archivo al campo `avatar`
            $ubicacion = 'posts/' . $datePath . '/' . $filename;
        }

        Publicacione::create([
            'foto'=>$ubicacion,
            'descripcion'=>$request->descripcion,
            'id_anuario'=>$id_anuario,
            'id_user'=>$user->id,
            'moderada'=>0
        ]);
        return redirect()->route('publicaciones.index', ['id_anuario' => $id_anuario])->with('success', 'Usuarios insertados exitosamente.');
    }
}
