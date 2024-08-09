<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Events\BreadDataAdded;
use Illuminate\Support\Facades\Auth;
use App\Models\Anuariouser;
use DB;
class AnuarioController extends VoyagerBaseController
{
    public function store(Request $request)
    {   
       
        $request->merge(['id_colegio' => Auth::user()->id_colegio]);
        $slug = $this->getSlug($request);
        
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
       
        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        self::crear_user($data->id,Auth::user()->id);
        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function insertUpdateData($request, $slug, $rows, $model)
    {
        
        // Extracción de datos del formulario
        $data = $request->except(['_token', '_method']);
       
        $model->fill($data);
       
        $model->save();
       
        return $model;
    }
    public function crear_user($anuario,$user){
        $anuariouser = new Anuariouser();
        $anuariouser->id_anuario = $anuario;
        $anuariouser->id_user = $user;
        
        // Guarda el modelo en la base de datos
        $anuariouser->save();
    }

    public function estudiantes_anuario($id_anuario){
        $anuario=$id_anuario;
        $resultado_filtrado=DB::table("anuariousers")
        ->select()
        ->join('users','users.id','=','anuariousers.id_user')
        ->where('anuariousers.id_anuario','=',$id_anuario)
        ->whereNotIn('users.role_id', [1, 5])
        ->paginate(15);
        $dataType = Voyager::model('DataType')->where('slug', 'anuario_users')->first();
        $dataTypeContent = $resultado_filtrado;
        $showCheckboxColumn = true; // Cambia esto según tu lógica
        return view('vendor.voyager.anuarios.estudiantes_list',compact('dataType', 'dataTypeContent', 'showCheckboxColumn','anuario'));
    }
    public function anuario_index($serie_id_anuario){

        $estudiantes_filtrado=DB::table("anuariousers")
        ->select('users.id','users.name','users.avatar')
        ->join('users','users.id','=','anuariousers.id_user')
        ->where('anuariousers.id_anuario','=',$serie_id_anuario)
        ->whereNotIn('users.role_id', [1, 5])
        ->get();
      
        $colegio_filtrado=DB::table("anuariosfins")
        ->select('colegios.*','anuariosfins.nombre','anuariosfins.anio')
        ->join('colegios','colegios.id','=','anuariosfins.id_colegio')
        ->where('anuariosfins.id','=',$serie_id_anuario)
        ->first();

        $text_color=self::determineTextColor($colegio_filtrado->color_institucional,$colegio_filtrado->color_secundario);
        $colegio_filtrado->text_color=$text_color;

        $response=[
            "colegio"=>$colegio_filtrado,
            "estudiantes"=>$estudiantes_filtrado,
            "id_anuario"=>$serie_id_anuario
        ];
        return view('themes.simple',compact('response'));
        return response(["data"=>$response]);
    }

    public function personal_anuario($serie_id_anuario,$id_estudiante){
        $colegio_filtrado=DB::table("anuariosfins")
        ->select('colegios.*','anuariosfins.nombre','anuariosfins.anio')
        ->join('colegios','colegios.id','=','anuariosfins.id_colegio')
        ->where('anuariosfins.id','=',$serie_id_anuario)
        ->first();

        $text_color=self::determineTextColor($colegio_filtrado->color_institucional,$colegio_filtrado->color_secundario);
        $colegio_filtrado->text_color=$text_color;


        $resultado_filtrado=DB::table("publicaciones")
        ->select()
        //->join('users','users.id','=','anuariousers.id_user')
        ->where('publicaciones.id_anuario','=',$serie_id_anuario)
        ->where('publicaciones.id_user','=',$id_estudiante)
        ->get();
        $response=[
            "colegio"=>$colegio_filtrado,
            "posts"=>$resultado_filtrado,
        ];
       // return response(["data"=>$response]);
        return view('themes.persona',compact('response'));

    }

    function hexToRgb($hex) {
        // Quitar el símbolo '#' si está presente
        $hex = ltrim($hex, '#');
    
        // Convertir el color hexadecimal a valores RGB
        if (strlen($hex) == 6) {
            list($r, $g, $b) = array(
                hexdec(substr($hex, 0, 2)),
                hexdec(substr($hex, 2, 2)),
                hexdec(substr($hex, 4, 2))
            );
        } elseif (strlen($hex) == 3) {
            list($r, $g, $b) = array(
                hexdec(str_repeat(substr($hex, 0, 1), 2)),
                hexdec(str_repeat(substr($hex, 1, 1), 2)),
                hexdec(str_repeat(substr($hex, 2, 1), 2))
            );
        } else {
            // Return false if the hex color is invalid
            return false;
        }
    
        return array($r, $g, $b);
    }
    function getLuminance($r, $g, $b) {
        // Calcular la luminosidad según la fórmula de luminancia relativa
        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;
    
        $r = ($r <= 0.03928) ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = ($g <= 0.03928) ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = ($b <= 0.03928) ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);
    
        return ($r * 0.2126) + ($g * 0.7152) + ($b * 0.0722);
    }

    function determineTextColor($color1, $color2) {
        // Convertir colores hexadecimales a RGB
        list($r1, $g1, $b1) = self::hexToRgb($color1);
        list($r2, $g2, $b2) = self::hexToRgb($color2);
    
        if ($r1 === false || $r2 === false) {
            return false; // Color hexadecimal inválido
        }
    
        // Calcular la luminosidad de ambos colores
        $luminance1 = self::getLuminance($r1, $g1, $b1);
        $luminance2 = self::getLuminance($r2, $g2, $b2);
    
        // Determinar si ambos colores son claros u oscuros
        if ($luminance1 > 0.5 && $luminance2 > 0.5) {
            return '#000000'; // Ambos colores son claros
        } elseif ($luminance1 < 0.5 && $luminance2 < 0.5) {
            return '#FFFFFF'; // Ambos colores son oscuros
        } else {
            // Si uno es claro y el otro es oscuro, no hay una respuesta única, así que puedes decidir o retornar un color por defecto
            return '#000000'; // Ejemplo de retorno por defecto
        }
    }
    
}
