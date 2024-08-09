<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use DB;
class EstudianteController extends Controller
{
    public function estudiantes_create ($id_anuario){
        
        return view("vendor.voyager.anuarios.estudiante_fomr",compact('id_anuario')); 
     }
    public function gestionar_excel(Request $request,$id_anuario){
        
        $id_colegio=DB::table('anuariosfins')->select('id_colegio')->where('id','=',$id_anuario)->first();
        $id_colegio=$id_colegio->id_colegio;
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        // Cargar el archivo
        $file = $request->file('excel');
        $reader = ReaderEntityFactory::createXLSXReader(); // Usar createXLSXReader para archivos Excel

        $reader->open($file->getRealPath());
        $validador=self::validador_columnas_excel($reader,$id_colegio);
        $reader->close();
        if(count($validador["errores"])!=0){
            return redirect()->back()->with('errors', $validador["errores"]);
        }else{
            $ids=self::guardar_usuarios_obtener_id($validador["usuarios"]);

            self::guardar_user_anuario( $ids,$id_anuario);
            return redirect()->route('estudiantes.index', ['id_anuario' => $id_anuario])->with('success', 'Usuarios insertados exitosamente.');
           
        }
      
        return response(["response"=>'Archivo importado exitosamente.']);
    }

    public function guardar_user_anuario($ids,$id_anuario){
        foreach ($ids as $id) {
            $data=[
                'id_anuario'=>$id_anuario,
                'id_user'=>$id
            ];
            DB::table('anuariousers')->insert($data);
        }
        
    }
    public function guardar_usuarios_obtener_id($data){
        DB::beginTransaction();
        try {
            // Insertar en la base de datos
            DB::table('users')->insert($data);

            // Obtener los IDs de los registros recién insertados
            // Nota: Asume que los datos en `noidentificacion` son únicos y puedes usarlo para buscar
            $ids = DB::table('users')
                ->whereIn('noidentificacion', array_column($data, 'noidentificacion'))
                ->pluck('id');

            // Confirmar la transacción
            DB::commit();

            return $ids;
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Manejar el error
            return redirect()->back()->with('error', 'Error al insertar usuarios.');
        }

    }
    public function validador_columnas_excel($reader,$id_colegio){
        $isFirstRow = true;
        $errores=[];
        $usuarios=[];
        $contado=2;
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                if ($isFirstRow) {
                    $isFirstRow = false; // Saltar la primera fila
                    continue; // Continuar con la siguiente fila
                }
                $cells = $row->getCells();

                $value1 = $cells[0]->getValue();
                $value2 = $cells[1]->getValue();
                $value3 = $cells[2]->getValue();
                $validacion=self::validador($value1,$value2,$value3,$contado);
                if($validacion!=NULL){
                    array_push($errores,$validacion);
                }else{
                    $users=self::generar_users_check($value1,$value2,$value3,$id_colegio);
                    array_push($usuarios,$users);   
                };
                $contado++;
            }
        }
        return [
            "errores"=> $errores,
            "usuarios"=> $usuarios
        ];
    }

    public function generar_users_check($value1,$value2,$value3,$id_colegio){
        return [
            'role_id'=>3,
            'name' => $value2,
            'email' => $value3,
            'avatar'=>'users/default.png',
            'password' => bcrypt($value1), // Asegúrate de cifrar la contraseña
            'settings'=>'{"locale":"es"}',
            'created_at' => now(),
            'updated_at' => now(),
            'id_colegio'=>$id_colegio,
            'noidentificacion'=>$value1,
        ];
    }

    public function validador($value1,$value2,$value3,$contador){
        //error en fila
        $pila_errores=[];
        if (empty($value1)) {
            array_push($pila_errores, 'Identificacíon esta vacia');
        }

        if (!is_numeric($value1)) {
            array_push($pila_errores, 'Identificacíon no es numerica');
           
        }
        if (empty($value2)) {
            array_push($pila_errores, 'Nombres Completos esta vacia');
        }

        if (empty($value3)) {
            array_push($pila_errores, 'Correo esta vacia');
        }

        if (!filter_var($value3, FILTER_VALIDATE_EMAIL)) {
            array_push($pila_errores, 'correo no es un correo valido');
        }

        $numberOfItems = count($pila_errores);

        if($numberOfItems>0){
            return [$contador=>$pila_errores];
        }
    }
}
