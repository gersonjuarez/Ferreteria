<?php

namespace App\Http\Controllers;
use App\Presentacion;
use Illuminate\Http\Request;

class PresentacionController extends Controller
{
           /* LISTAR */
           public function index(Request $request)
           {
/*                     if(!$request->ajax()) return redirect('/');
*/                 
               $presentacion=Presentacion::where('presentacions.estado', '=','1')  ->orderBy('id', 'desc')->paginate(5);
           
               return [
                
                'presentacions'=>$presentacion       
       
               ];
           }




           /* REGISTRAR */

           public function store(Request $request)
           {
/*                     if(!$request->ajax()) return redirect('/');
*/                   
               $presentacion= new Presentacion();
               $presentacion->nombre=$request->nombre;           
               $presentacion->estado='1';
               $presentacion->save();
           }



           /* Actualizar */
           public function update(Request $request)
           {
/*                     if(!$request->ajax()) return redirect('/');
*/                 
                
               $presentacion=  Presentacion::findOrFail($request->id);
       
               
               $presentacion->nombre=$request->nombre;
               $presentacion->estado='1';
               $presentacion->save();
           }



           /* DESACTIVAR */
           public function desactivar(Request $request)
           {
       
/*                     if(!$request->ajax()) return redirect('/');
*/            
               $presentacion=  Presentacion::findOrFail($request->id);
               $presentacion->estado='0';
               $presentacion->save();
           }
}
