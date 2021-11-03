<?php

namespace App\Http\Controllers;
use App\Categoria;

use Illuminate\Http\Request;

            class CategoriaController extends Controller
            {


                /* LISTAR */
                public function index(Request $request)
                {
/*                     if(!$request->ajax()) return redirect('/');
 */                 
                    $categorias=Categoria::where('categorias.estado', '=','1')  ->orderBy('id', 'desc')->paginate(5);
                
                    return [
                     
                     'categorias'=>$categorias       
            
                    ];
                }




                /* REGISTRAR */

                public function store(Request $request)
                {
/*                     if(!$request->ajax()) return redirect('/');
 */                   
                    $categoria= new Categoria();
                    $categoria->nombre=$request->nombre;           
                    $categoria->estado='1';
                    $categoria->save();
                }



                /* Actualizar */
                public function update(Request $request)
                {
/*                     if(!$request->ajax()) return redirect('/');
 */                 
                     
                    $categoria=  Categoria::findOrFail($request->id);
            
                    
                    $categoria->nombre=$request->nombre;
                    $categoria->estado='1';
                    $categoria->save();
                }



                /* DESACTIVAR */
                public function desactivar(Request $request)
                {
            
/*                     if(!$request->ajax()) return redirect('/');
 */            
                    $categoria=  Categoria::findOrFail($request->id);
                    $categoria->estado='0';
                    $categoria->save();
                }
            
            }
