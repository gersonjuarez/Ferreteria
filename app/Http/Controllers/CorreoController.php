<?php

namespace App\Http\Controllers;
use App\Mail\CorreoRecibido;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Venta;
use App\DetalleVenta;

class CorreoController extends Controller
{
    
        public function send(Request $request){

            $id = $request->id;
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

                
            \Mail::to($venta[0]->email)->send(new CorreoRecibido($detalles,$venta));

        }

}
