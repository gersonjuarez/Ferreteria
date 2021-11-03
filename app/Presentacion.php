<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $fillable=['nombre','estado'];    
    public $timestamps = false;

    public function producto(){

        return $this->hasMany('App\Producto');
        
        }
}
