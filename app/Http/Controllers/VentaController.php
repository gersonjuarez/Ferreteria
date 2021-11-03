<?php

namespace App\Http\Controllers;
use App\Venta;
use App\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function index(Request $request)
    {
     /*    if (!$request->ajax()) return redirect('/');*/

        $buscar = $request->buscar;
       
        
        if ($buscar==''){
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.num_comprobante','ventas.fecha_hora','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->orderBy('ventas.id', 'desc')->paginate(5);
        }
        else{
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.num_comprobante','ventas.fecha_hora','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->where('personas.nombre', 'like', '%'. $buscar . '%')
            ->orwhere('ventas.num_comprobante', 'like', '%'. $buscar . '%')
            ->orwhere('ventas.serie_comprobante', 'like', '%'. $buscar . '%')
            ->orderBy('ventas.id', 'desc')->paginate(5);
        }
        
        return [
            'pagination' => [
                'current_page' => $ventas->currentPage(),                      
                'last_page'    => $ventas->lastPage(),
            ],
            'ventas' => $ventas
        ];
    }
    public function obtenerCabecera(Request $request){
/*         if (!$request->ajax()) return redirect('/');
 */
        $id = $request->id;
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
        'ventas.num_comprobante','ventas.fecha_hora','ventas.total',
        'ventas.estado','personas.nombre','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();
        
        return ['venta' => $venta];
    }
    public function obtenerDetalles(Request $request){
/*         if (!$request->ajax()) return redirect('/');
 */
        $id = $request->id;
        $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio',
        'productos.nombre','productos.codigo','productos.foto')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
/*         if (!$request->ajax()) return redirect('/');
 */
        try{
            DB::beginTransaction();

            $mytime=now();

            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;
            $venta->num_comprobante = $request->num_comprobante;
            $venta->fecha_hora = $mytime;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
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

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }

    public function  totalventas(Request $request, $fecha_inicial_v, $fecha_final_v)
    {

      
        if ($fecha_inicial_v == $fecha_final_v) {
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.num_comprobante','ventas.fecha_hora','ventas.total',
              'personas.nombre','users.usuario')
                ->orderBy('ventas.fecha_hora', 'desc')
                ->whereDate('ventas.fecha_hora','=', $fecha_inicial_v)->get();



                $total_i=Venta::whereDate('ventas.fecha_hora','=', $fecha_inicial_v)
                ->sum('ventas.total');

        } else {
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.num_comprobante','ventas.fecha_hora','ventas.total',
              'personas.nombre','users.usuario')
                ->orderBy('ventas.fecha_hora', 'desc')
                ->whereBetween('ventas.fecha_hora', [$fecha_inicial_v, $fecha_final_v])->get();



                $total_i=Venta::whereBetween('ventas.fecha_hora', [$fecha_inicial_v, $fecha_final_v])
                ->sum('ventas.total');


        }

        $fe = now();

        $pdf = \PDF::loadView('pdf.ventaspdf', ['ventas' => $ventas,'total'=>$total_i]);
        return $pdf->download('Ventas ' . ' ' . $fe . '.pdf');


    }


    public function recibo(Request $request,$id){

        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
        'ventas.num_comprobante','ventas.created_at','ventas.total',
        'ventas.estado','personas.nombre','personas.tipo_documento','personas.num_documento',
        'personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio',
        'productos.nombre as producto')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa=Venta::select('num_comprobante')->where('id',$id)->get();
        $fe = now();
        $pdf = \PDF::loadView('pdf.recibo',['venta'=>$venta,'detalles'=>$detalles]);
        return $pdf->download('ventaTicket-'.$numventa[0]->num_comprobante.'.pdf');

    }


    
}
