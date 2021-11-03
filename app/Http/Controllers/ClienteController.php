<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Persona;
use App\Cliente;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        if ($buscar===''){
    $personas = Cliente::join('personas','clientes.id','=','personas.id')
    ->select('personas.id', 'personas.nombre',  'personas.tipo_documento', 'personas.num_documento', 'personas.direccion','personas.telefono', 'personas.email','personas.estado')
        ->where('estado','=','1')
        ->orderBy('id', 'desc')->paginate(5);
        }else{
            $personas = Cliente::join('personas','clientes.id','=','personas.id')
            ->select('personas.id', 'personas.nombre',  'personas.tipo_documento', 'personas.num_documento', 'personas.direccion','personas.telefono', 'personas.email','personas.estado')
            ->where('nombre', 'like', '%'. $buscar . '%')
            ->where('estado','=','1')
            ->orderBy('id', 'desc')->paginate(5);
        }
            return[
                'pagination' => [
                 
                     'current_page' => $personas->currentPage(),                      
                     'last_page'    => $personas->lastPage(),
            
                 ], 
                 'personas'=>$personas
             ] ;
                


   
   

    }

    public function selectcliente(Request $request){
        /*   if (!$request->ajax()) return redirect('/'); */
  
          $filtro = $request->filtro;
          $personas = Cliente::join('personas','clientes.id','=','personas.id')
          ->select('personas.id', 'personas.nombre',  'personas.tipo_documento', 'personas.num_documento', 'personas.direccion','personas.telefono', 'personas.email','personas.estado')
          ->where('nombre', 'like', '%'. $filtro . '%')
          ->where('estado','=','1')
          ->orderBy('id', 'desc')->get();
  
          return ['personas' => $personas];
      }

    public function indexdeshabilitado(Request $request)
    {
        $buscar = $request->buscar;

        if ($buscar===''){
    $personas = Persona::select('id', 'nombre',  'tipo_documento', 'num_documento', 'direccion','telefono', 'email','estado')
        ->where('estado','=','0')
        ->orderBy('id', 'desc')->paginate(5);
        }else{
            $personas = Persona::select('id', 'nombre',  'tipo_documento', 'num_documento', 'direccion','telefono', 'email','estado')
            ->where('nombre', 'like', '%'. $buscar . '%')
            ->where('estado','=','0')
            ->orderBy('id', 'desc')->paginate(5);
        }
            return[
                'pagination' => [
                 
                     'current_page' => $personas->currentPage(),                      
                     'last_page'    => $personas->lastPage(),
            
                 ], 
                 'personas'=>$personas
             ] ;
                


   
   

    }
    

    public function create()
    {
        //
    }

    public function busquedaTodo(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */


       $buscar = $request->buscar;

            if($buscar===''){

                    return;
            }else{


                $personas = Persona::select('id', 'nombre',  'tipo_documento', 'num_documento', 'direccion','telefono', 'email')
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->where('estado','=','1')
                ->orderBy('id', 'desc')->paginate(5);
           
          
        }
    


                return[
                   'pagination' => [
                    
                        'current_page' => $personas->currentPage(),                      
                        'last_page'    => $personas->lastPage(),
               
                    ], 
                    'personas'=>$personas
                ] ;


    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->estado= 1;
            $persona->save();
           
      
            $cliente = new Cliente();
            $cliente->id = $persona->id;
            $cliente->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $persona = Persona::findOrFail($request->id);
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
        
            $persona->save(); 
            return 'cliente modificado correctamente';
        }
        catch(\Exception $e){
            $response['error'] = $e->getMessage();
            return response()->json($response, 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

                /* DESACTIVAR */
                public function desactivar(Request $request)
                {
            
            /*         if (!$request->ajax()) return redirect('/');
             */
            $persona= Persona::where('id','=', $request->id)->firstOrFail();
            $persona->estado = '0';
            $persona->save();
                
                }

                
    public function activar(Request $request)
    {
/*         if (!$request->ajax()) return redirect('/');
 */
        $persona= Persona::where('id','=', $request->id)->firstOrFail();
        $persona->estado = '1';
        $persona->save();
            
    }
}
