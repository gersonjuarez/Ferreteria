<?php

namespace App\Http\Controllers;
use App\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(Request $request)
    {


        $buscar = $request->buscar;

        if ($buscar===''){
    $roles = Rol::select('id', 'nombre',  'descripcion')
        ->where('estado','=','1')
        ->orderBy('id', 'desc')->paginate(3);
        }else{
            $roles = Rol::select('id', 'nombre',  'descripcion')
            ->where('nombre', 'like', '%'. $buscar . '%')
            ->where('estado','=','1')
            ->orderBy('id', 'desc')->paginate(3);
       /* if (!$request->ajax()) return redirect('/');*/

        }
        

        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    } 


    public function busquedaTodo(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */


       $buscar = $request->buscar;

            if($buscar===''){

                    return;
            }else{


                $roles = Rol::select('id', 'nombre',  'descripcion')
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->where('estado','=','1')
                ->orderBy('id', 'desc')->paginate(3);
           
          
        }
    


                return[
                   'pagination' => [
                    
                        'current_page' => $personas->currentPage(),                      
                        'last_page'    => $personas->lastPage(),
               
                    ], 
                    'personas'=>$personas
                ] ;


    }

         /* DESACTIVAR */
         public function desactivar(Request $request)
         {
     
     /*         if (!$request->ajax()) return redirect('/');
      */
     $roles= Rol::where('id','=', $request->id)->firstOrFail();
     $roles->estado = '0';
     $roles->save();
         
         }
         public function store(Request $request)
         {
          
             
                 $roles = new Rol();
                 $roles->nombre = $request->nombre;
                 $roles->descripcion = $request->descripcion;
               
                 $roles->estado= 1;
                 $roles->save();
                
           
     
          
         }
         
public function activar(Request $request)
{
 if (!$request->ajax()) return redirect('/');

 $roles= Rol::where('id','=', $request->id)->firstOrFail();
 $roles->estado = '1';
 $roles->save();
     
}

public function update(Request $request)
{
    try{
        $roles = Rol::findOrFail($request->id);
        $roles->nombre = $request->nombre;
        $roles->descripcion = $request->descripcion;
       
        $roles->estado = '1';
        $roles->save(); 
        return 'cliente modificado correctamente';
    }
    catch(\Exception $e){
        $response['error'] = $e->getMessage();
        return response()->json($response, 500);
    }
    
}
}
