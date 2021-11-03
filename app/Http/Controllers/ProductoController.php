<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Categoria;
use App\Presentacion;

class ProductoController extends Controller
{
  
    /* LISTAR PRODUCTOS */

    public function index(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */


       $buscar = $request->buscar;

       if ($buscar===''){
            $productos = Producto::join('categorias', 'productos.idcategoria', '=', 'categorias.id')
            ->join('presentacions','productos.idpresentacion','=','presentacions.id')
                ->select('productos.id', 'productos.idcategoria',  'productos.codigo', 'productos.nombre', 'categorias.nombre as nombre_categoria','presentacions.nombre as nombre_presentacion', 'productos.stock', 'productos.precio_venta', 'productos.estado', 'productos.foto')
                ->where('productos.estado','=','1')
                ->orderBy('productos.id', 'desc')->paginate(5);
       }else{

        $productos = Producto::join('categorias', 'productos.idcategoria', '=', 'categorias.id')
        ->join('presentacions','productos.idpresentacion','=','presentacions.id')
            ->select('productos.id', 'productos.idcategoria', 'productos.idpresentacion', 'productos.codigo', 'productos.nombre', 'categorias.nombre as nombre_categoria','presentacions.nombre as nombre_presentacion', 'productos.stock', 'productos.precio_venta', 'productos.estado', 'productos.foto')
            ->where('productos.estado','=','1')
            ->where(function($query)use ($buscar){
               return $query->where('productos.nombre', 'like', '%'. $buscar . '%')
                ->orwhere('productos.codigo', 'like', '%'. $buscar . '%');
                
            })->orderBy('productos.id', 'desc')->paginate(5);

       }


                return[
                   'pagination' => [
                    
                        'current_page' => $productos->currentPage(),                      
                        'last_page'    => $productos->lastPage(),
               
                    ], 
                    'productos'=>$productos
                ] ;


    }


    public function indexdeshabilitado(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */


       $buscar = $request->buscar;

       if ($buscar===''){
            $productos = Producto::join('categorias', 'productos.idcategoria', '=', 'categorias.id')
            ->join('presentacions','productos.idpresentacion','=','presentacions.id')
                ->select('productos.id', 'productos.idcategoria',  'productos.codigo', 'productos.nombre', 'categorias.nombre as nombre_categoria','presentacions.nombre as nombre_presentacion', 'productos.stock', 'productos.precio_venta', 'productos.estado', 'productos.foto')
                ->where('productos.estado','=','0')
                ->orderBy('productos.id', 'desc')->paginate(5);
       }else{

        $productos = Producto::join('categorias', 'productos.idcategoria', '=', 'categorias.id')
        ->join('presentacions','productos.idpresentacion','=','presentacions.id')
            ->select('productos.id', 'productos.idcategoria', 'productos.idpresentacion', 'productos.codigo', 'productos.nombre', 'categorias.nombre as nombre_categoria','presentacions.nombre as nombre_presentacion', 'productos.stock', 'productos.precio_venta', 'productos.estado', 'productos.foto')
            ->where('productos.estado','=','0')
            ->where(function($query)use ($buscar){
               return $query->where('productos.nombre', 'like', '%'. $buscar . '%')
                ->orwhere('productos.codigo', 'like', '%'. $buscar . '%');
                
            })->orderBy('productos.id', 'desc')->paginate(5);

       }


                return[
                   'pagination' => [
                    
                        'current_page' => $productos->currentPage(),                      
                        'last_page'    => $productos->lastPage(),
               
                    ], 
                    'productos'=>$productos
                ] ;


    }

        
    public function busquedaTodo(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */


       $buscar = $request->buscar;

            if($buscar===''){

                    return;
            }else{


          
        $productos = Producto::join('categorias', 'productos.idcategoria', '=', 'categorias.id')
        ->join('presentacions','productos.idpresentacion','=','presentacions.id')
            ->select('productos.id', 'productos.idcategoria',  'productos.codigo', 'productos.nombre', 'categorias.nombre as nombre_categoria','presentacions.nombre as nombre_presentacion', 'productos.stock', 'productos.precio_venta', 'productos.estado', 'productos.foto')
            ->where('productos.nombre', 'like', '%'. $buscar . '%')
            ->orwhere('productos.codigo', 'like', '%'. $buscar . '%')
            ->where('productos.estado','=','1')
            ->orderBy('productos.id', 'desc')->paginate(5);
        }
    


                return[
                   'pagination' => [
                    
                        'current_page' => $productos->currentPage(),                      
                        'last_page'    => $productos->lastPage(),
               
                    ], 
                    'productos'=>$productos
                ] ;


    }




        /* INGRESO DE PRODUCTOS */
    public function store(Request $request)
    {

       
        if ($request->get('image')) {
            $image = $request->get('image');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/') . $name);
        }

        
        $producto = new Producto();
        $producto->idcategoria = $request->idcategoria;
        $producto->idpresentacion = $request->idpresentacion;

        /*         $producto->descripcion=$request->descripcion;
 */
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->stock = $request->existencia;
        $producto->precio_venta = $request->precio_venta;
        $producto->estado = '1';
        if(!$request->get('image')){
            $producto->foto = $request->aux;

        }else{
            $producto->foto = $name;

        }
       

        $producto->save();
    }



    /* ACTUALIZAR PRODUCTOS */

    public function update(Request $request)
    {
/*         if (!$request->ajax()) return redirect('/');
 */

        if ($request->get('image')) {
            $image = $request->get('image');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->save(public_path('images/') . $name);
        }




        $producto =  Producto::findOrFail($request->id);

    
        $producto->idcategoria = $request->idcategoria;
        $producto->idpresentacion = $request->idpresentacion;

        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->stock = $request->existencia;
        $producto->precio_venta = $request->precio_venta;
       
        if ($request->get('image')) {
            $producto->foto = $name;
        } else {
            $producto->foto = $request->foto;
        }
       
      
      
        $producto->save();
    }




            /* DESACTIVAR */
    public function desactivar(Request $request)
    {

/*         if (!$request->ajax()) return redirect('/');
 */
        $producto =  Producto::findOrFail($request->id);
        $producto->estado = '0';
        $producto->save();
    }



    /* Activar */

    public function activar(Request $request)
    {
/*         if (!$request->ajax()) return redirect('/');
 */
        $producto =  Producto::findOrFail($request->id);
        $producto->estado = '1';
        $producto->save();
    }




    public function listarPdf(){

        $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre',
            'categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock',
            'productos.descripcion','productos.estado')
            ->orderBy('productos.nombre', 'asc')->get();

        $cont=Producto::count();
        $fe = now();

        $pdf = \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('Productos'.'-'.$fe.'.pdf');
    }





}
