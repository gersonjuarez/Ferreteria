<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon fa fa-home"></i> Inicio
                </a>
            </li>
            <li class="nav-title bg-dropbox">Inventario</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i>Productos</a>
                <ul class="nav-dropdown-items">

                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-tags"></i>Categorias</a>
                    </li>

                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-balance-scale"></i>Unidad de Medida</a>
                    </li>

                  
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-cogs"></i>Productos</a>
                    </li>

                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-shopping-cart "></i>Habilitar productos</a>
                    </li>
                  
                </ul>
            </li>
            <li class="nav-title bg-tumblr">Venta</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-sign-out"></i>Ventas</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa  fa-share"></i>Realizar Ventas</a>
                    </li>

                <li @click="menu=6" class="nav-item">
                <a class="nav-link" href="#"><i class="nav-icon fa fa-user-circle-o"></i>clientes</a>
            </li>

            <li @click="menu=11" class="nav-item">
                <a class="nav-link" href="#"><i class="nav-icon fa fa-user-circle-o"></i>Habilitar Cliente</a>
            </li>


                </ul>
            </li>
         
            <li class="nav-title bg-google-plus">Administracion</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-plus-square"></i>Adquisiciones</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-shopping-cart"></i>Ingresos</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-address-book"></i>Proveedores</a>
                    </li>
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fa fa-address-book"></i>Habilitar Proveedor</a>
                    </li>
                </ul>
            </li>
       
      
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fas fa-user"></i> Usuarios</a>
                <ul class="nav-dropdown-items">

                 
              
                    <li @click="menu=16" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fas fa-user-tag"></i> Usuarios</a>
                    </li>
                    <li @click="menu=17" class="nav-item">
                        <a class="nav-link" href="#"><i class="nav-icon fas fa-user-tag"></i>Habilitar Usuario</a>
                    </li>
                </ul>
            </li>
         
           
        </ul>
    </nav>
</div>


  