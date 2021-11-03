<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable=[

        'idcategoria','idpresentacion','codigo','nombre','stock','precio_venta','estado','foto'
    ];
    public function categoria(){

        return $this->belongsTo('App\Categoria');
        
        }

        public function presentacion(){

            return $this->belongsTo('App\Presentacion');
            
            }
   /*      public function detalleventa()
    {
        return $this->hasMany('App\DetalleVenta', 'idproducto', 'id');
    } */
}
