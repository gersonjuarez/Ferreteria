<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Producto;

class GraficaController extends Controller
{
    public function __invoke(Request $request)
    {
        /* 
        $existencia = DB::table('productos')->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.idproducto')
       
            ->select(
                'productos.nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as cantidad'),
                DB::raw('COUNT(detalle_ventas.idproducto) as veces')
            )

            ->groupBy('productos.nombre')
            ->orderBy('veces', 'desc')
           
 */
        $mes = Carbon::now('America/Guatemala')->format('m');





        $existencia2 = Producto::join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.idproducto')

            ->select(
                'productos.nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as cantidad'),
                DB::raw('COUNT(detalle_ventas.idproducto) as veces')
            )

            ->groupBy('productos.nombre')
            ->orderBy('cantidad', 'desc')

            ->whereMonth('detalle_ventas.created_at', '=', $mes)
            ->limit(5)
            ->get();

        return ['venta2' => $existencia2];
    }
}
