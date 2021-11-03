<?php

namespace App\Http\Controllers;
use App\User;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function index(Request $request)
    {
        

        $buscar = $request->buscar;
      
        
        if ($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento',
            'personas.num_documento','personas.direccion','personas.telefono',
            'personas.email','users.usuario','users.password',
            'users.estado','users.idrol','roles.nombre as rol')
            ->where('users.estado','=','1')
            ->orderBy('personas.id', 'desc')->paginate(5);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento',
            'personas.num_documento','personas.direccion','personas.telefono',
            'personas.email','users.usuario','users.password',
            'users.estado','users.idrol','roles.nombre as rol')  
            ->where('users.estado','=','1')          
            ->where('personas','like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(5);
        }
        

        return [
            'pagination' => [
             
                'current_page' => $personas->currentPage(),
               
                'last_page'    => $personas->lastPage(),
             
            ],
            'personas' => $personas
        ];
    }


    public function indexdeshabilitado(Request $request)
    {
        

        $buscar = $request->buscar;
      
        
        if ($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento',
            'personas.num_documento','personas.direccion','personas.telefono',
            'personas.email','users.usuario','users.password',
            'users.estado','users.idrol','roles.nombre as rol')
            ->where('users.estado','=','0')
            ->orderBy('personas.id', 'desc')->paginate(5);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento',
            'personas.num_documento','personas.direccion','personas.telefono',
            'personas.email','users.usuario','users.password',
            'users.estado','users.idrol','roles.nombre as rol')  
            ->where('users.estado','=','0')          
            ->where('personas','like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(5);
        }
        

        return [
            'pagination' => [
             
                'current_page' => $personas->currentPage(),
               
                'last_page'    => $personas->lastPage(),
             
            ],
            'personas' => $personas
        ];
    }


    public function store(Request $request)
    {
       
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->estado = '1';
            $user->idrol = $request->idrol;          

            $user->id = $persona->id;

            $user->save();

      

        
        
    }

    public function busquedaTodo(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */


       $buscar = $request->buscar;

            if($buscar===''){

                    return;
            }else{


                $personas = User::join('personas','users.id','=','personas.id')
                ->join('roles','users.idrol','=','roles.id')
                ->select('personas.id','personas.nombre','personas.tipo_documento',
                'personas.num_documento','personas.direccion','personas.telefono',
                'personas.email','users.usuario','users.password',
                'users.estado','users.idrol','roles.nombre as rol')            
                ->where('personas.','like', '%'. $buscar . '%')
                ->orderBy('personas.id', 'desc')->paginate(5);
        }
    


                return[
                   'pagination' => [
                    
                        'current_page' => $personas->currentPage(),                      
                        'last_page'    => $personas->lastPage(),
               
                    ], 
                    'personas'=>$personas
                ] ;


    }

    public function update(Request $request)
    {
       

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);

            $persona = Persona::findOrFail($user->id);

            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->idrol = $request->idrol;
            $user->save();



    }

    public function desactivar(Request $request)
    {
        $user= User::where('id','=', $request->id)->firstOrFail();
        $user->estado = '0';
        $user->save();
            
 
    }

    public function activar(Request $request)
    {
/*         if (!$request->ajax()) return redirect('/');
 */       
        $user= User::where('id','=', $request->id)->firstOrFail();
        $user->estado = '1';
        $user->save();
    }
}
