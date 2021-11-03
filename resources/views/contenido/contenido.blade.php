@extends('principal')
@section('contenido')

@if(Auth::check())
            @if (Auth::user()->idrol == 1)
        
            <template v-if="menu==0">
    <grafica></grafica>

    </template>
    <template v-if="menu==1">
        <categorias></categorias>
    </template>

    <template v-if="menu==2">
        <presentacion></presentacion>
</template>
    <template v-if="menu==3">
    <productos></productos>

    </template>
    <template v-if="menu==4">
        <habilitarproductos></habilitarproductos>
    </template>
    <template v-if="menu==5">
    <ventas></ventas>
    </template>
    <template v-if="menu==6">
    <clientes></clientes>
    </template>
    <template v-if="menu==7">
        <ingresos></ingresos>
    </template>
    <template v-if="menu==8">
<proveedores></proveedores>
    </template>
    <template v-if="menu==9">
    <habilitarproveedor></habilitarproveedor>
    </template>
  
    <!-- para habilitar cliente -->
    <template v-if="menu==11">
<habilitarcliente></habilitarcliente>
    </template>


    <template v-if="menu==15">
    <rol></rol>
</template>

<template v-if="menu==16">
<user></user>
</template>

<template v-if="menu==17">
<habilitaruser></habilitaruser>
</template>
        

    
              @elseif(Auth::user()->idrol == 2)

              <template v-if="menu==0">
    <grafica></grafica>

    </template>
    <template v-if="menu==1">
        <categorias></categorias>
    </template>

    <template v-if="menu==2">
        <presentacion></presentacion>
</template>
    <template v-if="menu==3">
    <productos></productos>

    </template>
    <template v-if="menu==4">
        <habilitarproductos></habilitarproductos>
    </template>
    <template v-if="menu==5">
    <ventas></ventas>
    </template>
    <template v-if="menu==6">
    <clientes></clientes>
    </template>
    <template v-if="menu==11">
<habilitarcliente></habilitarcliente>
    </template>
              @else
            @endif

        @endif

         
    




    
 
@endsection