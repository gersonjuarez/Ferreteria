<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;

class IngresoController extends Controller
{



    public function index(Request $request)
    {
/*         if (!$request->ajax()) return redirect('/');
 */
                    $buscar = $request->buscar;
                            
                    if ($buscar==''){
                        $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
                        ->join('users','ingresos.idusuario','=','users.id')
                        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
                        'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
                        'ingresos.estado','personas.nombre','users.usuario')
                        ->orderBy('ingresos.id', 'desc')->paginate(5);
                    }
                    else{
                        $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
                        ->join('users','ingresos.idusuario','=','users.id')
                        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
                        'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
                        'ingresos.estado','personas.nombre','users.usuario')
                        ->where('personas.nombre', 'like', '%'. $buscar . '%')
                        ->orwhere('ingresos.num_comprobante', 'like', '%'. $buscar . '%')
                        ->orwhere('ingresos.serie_comprobante', 'like', '%'. $buscar . '%')
                        ->orderBy('ingresos.id', 'desc')->paginate(5);
                    }

                    return [
                        'pagination' => [
                                
                            'current_page' => $ingresos->currentPage(),                      
                            'last_page'    => $ingresos->lastPage(),

                        ], 
                        'ingresos' => $ingresos
                    ];
    }
   

    public function obtenerDetalles(Request $request){
/*         if (!$request->ajax()) return redirect('/');
 */
        $id = $request->id;
        $detalles = DetalleIngreso::join('productos','detalle_ingresos.idproducto','=','productos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','productos.nombre','productos.codigo','productos.foto')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->orderBy('detalle_ingresos.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }
    public function store(Request $request)
    {
       /*  if (!$request->ajax()) return redirect('/'); */

        try{
            DB::beginTransaction();

            $mytime=now();

            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->idusuario =\Auth::user()->id ;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->fecha_hora = $mytime;
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            $ingreso->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idproducto = $det['id'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];    
                $detalle->foto = $det['imagen'];          
      
                $detalle->save();
            }
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function  totalcompras(Request $request, $fecha_inicial_c, $fecha_final_c)
    {

        
        
        if ($fecha_inicial_c == $fecha_final_c) {
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
              'personas.nombre','users.usuario')
                ->orderBy('ingresos.fecha_hora', 'desc')
                ->whereDate('ingresos.fecha_hora', $fecha_inicial_c)->get();



                $total_i=Ingreso::whereDate('ingresos.fecha_hora', $fecha_inicial_c)
                ->sum('ingresos.total');

        } else {
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
              'personas.nombre','users.usuario')
                ->orderBy('ingresos.fecha_hora', 'desc')
                ->whereBetween('ingresos.fecha_hora', [$fecha_inicial_c, $fecha_final_c])->get();



                $total_i=Ingreso::whereBetween('ingresos.fecha_hora', [$fecha_inicial_c, $fecha_final_c])
                ->sum('ingresos.total');


        }



        $fe = now();

        $pdf = \PDF::loadView('pdf.compraspdf', ['ingresos' => $ingresos,'total'=>$total_i]);
        return $pdf->download('Ingresos ' . ' ' . $fe . '.pdf');


    }


}
