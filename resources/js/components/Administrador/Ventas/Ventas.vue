<template>
<v-app style="width:100%;heigth:100%" >


    <main class="main">


        <!-- Listado de Ventas -->
        
    <material-card
        v-if="listado==1"
      icon="mdi-cart"
      icon-small
      title="Lista de Ventas"
      color="accent"
      
    
    >
    <v-data-table
    :headers="header_ingreso"
    :items="Ingresos"
    :loading="loading3"
    mobile-breakpoint="50"
    hide-default-footer

    class="elevation-1"
  >
 
   <template v-slot:top>
      <v-toolbar
        flat
      >
      <v-text-field
        v-model="busqueda_compra"
        append-icon="mdi-magnify"
        label="Busqueda general"
        @input="onPageChangeIngreso"
        single-line
        hide-details
      ></v-text-field>     
      
         <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>

            <v-btn
              color="primary"
              dark
              class="mb-2"
              @click="registrarcompra"
            >
               <v-icon
        small
        class="mr-2"
     
      >
        mdi-plus
      </v-icon>Nueva Venta
            </v-btn>
         

 

      </v-toolbar>
   </template>


    <template v-slot:[`item.opciones`]="{ item }">
      <v-tooltip
          v-model="item.nada"
          top
        >
          <template v-slot:activator="{ on, attrs }">
               <v-btn
               @click="cambiodetalle(item.id)"
              icon
              v-bind="attrs"
              v-on="on"
            >
              <v-icon       color="blue darken-2"
>
                mdi-eye
              </v-icon>
            </v-btn>
          </template>
          <span>Ver Detalle</span>
        </v-tooltip>


         <v-tooltip
          v-model="item.otro"
          top
        >
          <template v-slot:activator="{ on, attrs }">
               <v-btn
               @click="recibo(item.id)"
              icon
              v-bind="attrs"
              v-on="on"
            >
              <v-icon       color="blue darken-2"
>
                mdi-file-document
              </v-icon>
            </v-btn>
          </template>
          <span>Recibo</span>
        </v-tooltip>


        </template>




      </v-data-table>
          <v-pagination
                v-model="pagination_ingreso.current_page"
                :length="pagination_ingreso.total"
                @input="onPageChangeIngreso"
               ></v-pagination>


                <v-snackbar
                v-model="snackbar_email"
                        shaped
                    :timeout="timeout"

                color="deep-purple accent-4"
                elevation="24"
              >
               Recibo enviado.

         
              </v-snackbar>
    </material-card>


      <!-- DETALLE DE VENTA -->
          <material-card
          v-if="listado==2"
            icon="mdi-cart"
            icon-small
            title="Detalle De Venta"
            color="accent"
          >

              <v-data-table
            hide-default-footer
            :headers="headersdetalle"
            :items="lista_productos_detalle"
            :loading="loading2"
            mobile-breakpoint="50"
            class="elevation-1"
        >
        
        <template v-slot:top>
            <v-toolbar
                flat
            >

             <v-btn
               @click="cambiolista"
              
              
            >
            
              <v-icon       color="blue darken-2"
>
                mdi-arrow-left-bold
              </v-icon>
              Regresar
            </v-btn>


    <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>


      </v-toolbar>
   </template>

  <template  v-slot:[`item.foto`]="{ item }">
     <v-img max-width="60" contain  :src="'images/'+item.foto" />
    </template>
    
                 <template  v-slot:[`item.subtotal`]="{ item }">
                   <h6>Q{{(item.precio*item.cantidad).toFixed(2)}}</h6>
              </template>

        </v-data-table>
    <div
                            style="
                            margin:1em;
                                display:flex;
                              flex-wrap: wrap;
                              align-self:end;
                              justify-content:end"
                            >

                                    <tbody>
                                       
                                        <tr >
                                            <td colspan="4" align="right"><strong>Total: </strong></td>
                                            <td>Q{{(total_detalle).toFixed(2)}}</td>
                                        </tr>
                                   
                                    </tbody>

                               </div>
    </material-card>




<!-- REGISTRO DE VENTA -->
     <material-card
     v-if="listado==3"
      icon="mdi-cart"
      icon-small
      title="Registrar Venta"
      color="accent"
      >


                <div
                style="margin:2em"
                >
             <v-btn
               @click="cambiolista"
              :disabled=" desactivar"
        
              
            >
            
              <v-icon       color="blue darken-2"
>
                mdi-arrow-left-bold
              </v-icon>
              Regresar
            </v-btn>
                </div>
            
  
       
            <v-card
            style="margin:2em"
        :loading="cargarventa"

            >

<v-form v-model="validar"     ref="form"
>

    <v-container>
      <v-row>
        <div>

        </div>
        <v-col
          cols="12"
          md="6"
        >
         <v-autocomplete

         v-model="idcliente"
          item-text="nombre"
         item-value="id"
        :items="items"
        :search-input.sync="busqueda"
        label="Buscar Cliente"
        :required="required"
         :rules="[v => !required || !!v || 'Cliente Requerido.']"
        :disabled=" desactivar"

      ></v-autocomplete>
        </v-col>

      
      

     
      </v-row>
    </v-container>

     <v-container>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-select
          v-model="tipo_comprobante"
          :items="comprobantes"
          :rules="ComprobanteRules"
          label="Tipo de comprobante"
            :disabled=" desactivar"

        ></v-select>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
          
            v-model="serie_comprobante"
             :rules="SerieRules"

            label="Serie comprobante"
            required
             :disabled=" desactivar"

          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
       
            v-model="num_comprobante"
            :rules="NumeroRules"
              label="Numero combrobante"
              required
              :disabled=" desactivar"

            ></v-text-field>
          </v-col>
        </v-row>
      </v-container>
    </v-form>

              </v-card>




        <v-dialog
          v-model="modal"
           width="800px"
          max-width="800px"
        >


    <template v-slot:activator="{ on, attrs }">
            <div
            style="display:flex;

   align-self:center;
   justify-content:center"
            >
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
              :disabled=" desactivar"

            >
               <v-icon
        small
        class="mr-2"
     
      >
        mdi-plus
      </v-icon>Productos
            </v-btn>

            </div>
       
          </template>

  
            <div>
   <material-card
          color="orange"
          full-header
        >
          <template #heading>
            <div class="pa-8 white--text">
              <div class="text-h4 font-weight-light">
               Listado de Productos
              </div>
            <!--   <div class="text-caption">
                  Texto pequeño
              </div -->
            </div>
          </template>










            <!-- AQUI SE COLOCARIA TODO EL CONTENIDO -->
                   <v-data-table
                    :headers="headers"
                    :items="desserts"
                    :loading="loading"
                    hide-default-footer
                    mobile-breakpoint="50"
                    class="elevation-1"
                  >

   <template  v-slot:[`item.foto`]="{ item }">
     <v-img max-width="60" contain  :src="'images/'+item.foto" />
    </template>

            <template v-slot:top>
              <v-toolbar
                flat
              >
              <v-text-field
                v-model="search"
                @input="listarProducto"
                append-icon="mdi-magnify"
                label="Busqueda general"
                single-line
                hide-details
              ></v-text-field>  

              </v-toolbar>
            </template>


         <template v-slot:[`item.opciones`]="{ item }">

                <v-tooltip
                v-model="item.delete"
                top
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                  @click="AgregarCarrito(item)"
                    icon
                    v-bind="attrs"
                    v-on="on"
                  >
                    <v-icon  color="blue darken-2">
                     mdi-checkbox-marked-circle

                    </v-icon>
                  </v-btn>
                </template>
                <span>Agregar</span>
              </v-tooltip>
          </template>

                   </v-data-table>
                  <v-pagination
                v-model="pagination.current_page"
                :length="pagination.total"
                @input="onPageChange"
               ></v-pagination>


                   
            <!-- FIN DEL CONTENIDO -->












             <v-btn
                color="blue darken-1"
                text
                @click="modal=false"
              >
                Cerrar
              </v-btn>
        </material-card>


            </div>

       </v-dialog>





              <div
               style="margin:2em"
              >

              <v-data-table
                :headers="headerproductos"
                :items="productos"

              mobile-breakpoint="50"
                hide-default-footer
                class="elevation-1"
              >
  <template  v-slot:[`item.imagen`]="{ item }">
     <v-img max-width="60" contain  :src="'images/'+item.imagen" />
    </template>
              <template  v-slot:[`item.precio`]="{ item }">
                <v-text-field
                type="number"
                v-model="item.precio"
                :min="precio_minimo"
                            :disabled=" desactivar"

                >

                </v-text-field>
              </template>

                 <template  v-slot:[`item.cantidad`]="{ item }">
                <v-text-field
                type="number"
                v-model="item.cantidad"
                  :min="cant_minimo"
                @input="verificar"
                            :disabled=" desactivar"

                >

                </v-text-field>
              </template>

                 <template  v-slot:[`item.subtotal`]="{ item }">
                   <h6>Q{{(item.precio*item.cantidad).toFixed(2)}}</h6>
              </template>


    <template v-slot:[`item.opciones`]="{ item }">

          <v-tooltip
          v-model="item.delete"
          top
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
            @click="EliminarCarrito(item.id)"
              icon
              v-bind="attrs"
              v-on="on"
              :disabled=" desactivar"

            >
              <v-icon  color="blue darken-2">
                mdi-delete
              </v-icon>
            </v-btn>
          </template>
          <span>Eliminar</span>
        </v-tooltip>
    </template>

    

              </v-data-table>


                            <div
                            style="
                            margin:1em;
                                display:flex;
                              flex-wrap: wrap;
                              align-self:end;
                              justify-content:end"
                            >

                                    <tbody>
                                       
                                        <tr >
                                            <td colspan="4" align="right"><strong>Total: </strong></td>
                                            <td>Q{{(total_pagar).toFixed(2)}}</td>
                                        </tr>
                                     <!--    <tr >
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ 200</td>
                                        </tr>
                                        <tr >
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ 20</td>
                                        </tr> -->
                                    </tbody>

                               </div>
                                         


    


              <div
              style=" 
              padding:2em;
                display:flex;
              flex-wrap: wrap;
              align-self:center;
              justify-content:center"
              >
                            <div class="my-2">

                <v-btn 
                  v-if="productos.length && validar && required"
                    
                    color="success"
                      :disabled=" desactivar"
    
                    @click="Comprar"
                    >
                     Realizar Venta
                    </v-btn>
                            </div>
              <div class="my-2">

                      <v-btn 
                      style="margin-left: 1em;"
                 color="error"
                    dark
                   @click="cambiolista"
                    :disabled=" desactivar"

                    >
                   Cancelar
                    </v-btn>
          </div>
                  </div>


              </div>
             
          <v-snackbar
                v-model="snackbar"
                        shaped
                    :timeout="timeout"

                color="deep-purple accent-4"
                elevation="24"
              >
               El producto ya se encuentra agregado.

         
              </v-snackbar>

             <v-snackbar
                v-model="snackbar_cantidad"
                        shaped
                    :timeout="timeout"

                color="deep-purple accent-4"
                elevation="24"
              >
               Stock insuficiente.

         
              </v-snackbar>
    </material-card>

    </main>


     <div class="text-center">
  

    <v-overlay
    z-index="9999"

     :value="carga_email">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>

    </v-overlay>
  </div>


    
   </v-app>
</template>


<script>

export default {

  data(){
          return{
            snackbar_email:false,
            carga_email:false,
                  subject: "Comprobante",

            required: {
            type: Boolean,
            default: false,
          },
          detalle_email:[],
          venta_email:[],
          cargarventa:false,
          desactivar:false,
          busqueda_:false,
          cant_minimo:0,
          precio_minimo:0,
          modal:false,
              timeout:3000,
              required_productos:true,
              validar:true,
              snackbar:false,
              snackbar_cantidad:false,
              listado:1,
              loading2:false,
                loading3:false,

              search:'',
              busqueda_compra:'',
              loading:false,
              arrayProveedor:[],
              items:[],
              cliente_v:'',
              busqueda_filtro:'',
              busqueda:null,
              select: "",
              idcliente:null, //Registro de Compra
              tipo_comprobante:'',
              serie_comprobante:'',
              num_comprobante:'',
              impuesto:null,
         
              /* Carrito de compra ingresos */

          ProveedorRules: [
                  v => !!v || 'Proveedor Requerido.',
                ],
                  ImpuestoRules: [
                  v => !!v || 'Impuesto Requerido.',
                ],

                ComprobanteRules: [
                  v => !!v || 'Comprobante Requerido.',
                ],
                   SerieRules: [
                  v => !!v || 'Serie Comprobante Requerido.',
                ],
                  NumeroRules: [
                  v => !!v || 'Numero Comprobante Requerido.',
                ],
                headers: [
          
          { text: 'Opciones', value: 'opciones', sortable: false },

         {  text: 'Código', value: 'codigo', sortable: false },

                {
                  text: 'Nombre',
                  align: 'start',
                
                  value: 'nombre',
                },
                { text: 'Imagen', value: 'foto', sortable: false },
                { text: 'Categoria', value: 'nombre_categoria', sortable: false },
                { text: 'Medida', value: 'nombre_presentacion', sortable: false },
                { text: 'Precio Venta', value: 'precio_venta' },
                { text: 'Stock', value: 'stock' },

              ],
              headerproductos:[       

                {
                  text: 'Opciones',
                  align: 'start',
                
                  value: 'opciones',
                  sortable: false
                },
              { text: 'Producto', value: 'producto', sortable: false },
              { text: 'imagen', value: 'imagen', sortable: false },

                { text: 'Precio', value: 'precio', sortable: false },
                                   { text: 'Stock', value: 'stock', sortable: false },

                { text: 'Cantidad', value: 'cantidad', sortable: false },
                { text: 'Subtotal', value: 'subtotal', sortable: false },
            
              ],

                  /* PAGINACION LISTA DE PRODUCTOS */
                  pagination : {
                    total : 0,
                    current_page :1,
                   
                },
              desserts: [], /*Arreglo de productos al realizar busqueda */
               contador:0,
               aux:null,
                 productos:[], /* Arreglo de productos para carrito de ingreso */
                 /* Detalle de ingreso */
              comprobantes:['Boleta','Factura'],
            
            /* Detall INGRESOS */
                    lista_productos_detalle:[],

                  headersdetalle:[
                        

                    { text: 'Código', value: 'codigo', sortable: false },

                    {
                      text: 'Nombre',
                      align: 'start',
                    
                      value: 'nombre',
                    },
                  { text: 'Imagen', value: 'foto', sortable: false },

                    { text: 'Precio', value: 'precio', sortable: false },
                    
                    { text: 'Cantidad', value: 'cantidad', sortable: false },
                { text: 'Subtotal', value: 'subtotal', sortable: false },

                
                  ],
                
                pagination_ingreso:[
                      {
                      total : 0,
                    current_page :1,
                    }
                    ],
                Ingresos:[],
                header_ingreso:[       

                {
                  text: 'Opciones',
                  align: 'start',
                
                  value: 'opciones',
                  sortable: false
                },
              { text: 'Usuario', value: 'usuario', sortable: false },
              { text: 'Cliente', value: 'nombre', sortable: false },

                { text: 'Tipo Comprobante', value: 'tipo_comprobante', sortable: false },
                { text: 'Serie Comprobante', value: 'serie_comprobante', sortable: false },
                { text: 'Numero Comprobante', value: 'num_comprobante', sortable: false },
              { text: 'Fecha Hora', value: 'fecha_hora' },
                { text: 'Total', value: 'total', sortable: false },
                { text: 'Estado', value: 'estado', sortable: false },


              ],
            contador2:0,
               aux2:null,
           

          }

  },
  computed:{

    total_pagar(){

        
      return _.sumBy (this.productos, function (it) {
        return it.precio * it.cantidad;
      });

    },
       total_detalle(){

        
      return _.sumBy (this.lista_productos_detalle, function (it) {
        return it.precio * it.cantidad;
      });

    }

  },
  watch:{



    busqueda(val) {
     
    if(val===null){
      this.idcliente=null;
      return;
    }
      let me=this;
        if(val.length){
          val && val !== this.select && this.selectProveedor(val);

        }else{
            me.items=[];
          return;
        }

        },

      },
            methods:{

              revisa(){

                    if(this.idcliente){
                      this.busqueda_=true;
                    }
                

              },
            verificar(){
            
            let me=this;
              me.productos.map(function(x,indice){
                    if (x.cantidad>x.stock){
                              
                      me.snackbar_cantidad=true;

                     me.productos[indice].cantidad=0;
                      return;

                    }

                });


            },
      /* LISTAR INGRESOS */
           listarIngreso (){
                let me=this;
                  if(me.contador2==0){
        me.aux2=me.pagination_ingreso.current_page;
     }
      me.contador2=me.contador2+1;

      me.Ingresos=[];
      me.loading3=true;
      if(me.busqueda_compra.length){          
        me.pagination_ingreso.current_page=1;
      }else{
        me.contador2=0;
        me.pagination_ingreso.current_page=me.aux2;
        me.aux2=null;
      }


                var url= '/venta?page=' + me.pagination_ingreso.current_page+ '&buscar='+ me.busqueda_compra;
                axios.get(url).then(function (response) {
                        me.Ingresos=[];

                    var respuesta= response.data;
                    console.log('datos: '+JSON.stringify(respuesta))
                    me.Ingresos = respuesta.ventas.data;
                     me.pagination_ingreso.current_page=respuesta.pagination.current_page;
                    me.pagination_ingreso.total = respuesta.pagination.last_page;
                    me.loading3=false;
                })
                .catch(function (error) {
                    me.loading3=false;

                    console.log(error);
                });
     },
      onPageChangeIngreso(){

          this.listarIngreso();
      },

   listarProducto() {
    
      let me = this;
     
     if(me.contador==0){
        me.aux=me.pagination.current_page;
     }
      me.contador=me.contador+1;

      me.desserts=[];
      me.loading=true;
      if(me.search.length){          
        me.pagination.current_page=1;
      }else{
        me.contador=0;
        me.pagination.current_page=me.aux;
        me.aux=null;
      }

      /* if(!me.search.length){
       me.desserts=[];
          me.loading=false;

        return;
      } */

      const url='/lista/producto?page=' +me.pagination.current_page+ '&buscar='+ me.search;

       axios
        .get(url)
        .then(function (response) {
        me.desserts=[];
          var respuesta = response.data;
         
        console.log('data: '+JSON.stringify(respuesta))
         me.desserts= respuesta.productos.data;

                    me.pagination.current_page=respuesta.pagination.current_page;
                    me.pagination.total = respuesta.pagination.last_page;

                    me.loading=false;

        })
        .catch(function (error) {
          console.log(error);
        });
    },
     
    selectProveedor(valor){
                let me=this;

              
                var url= '/cliente/selectcliente?filtro='+valor;
                axios.get(url).then(function (response) {
                  me.items=[];
                    let respuesta = response.data;

                    me.items= respuesta.personas
               

      
                })
                .catch(function (error) {
                    console.log(error);
                });

                  

            },
        onPageChange() {

            this.listarProducto();
        },
        AgregarCarrito(item){

          let me=this;
            
             if(item.stock<=0){
              me.snackbar_cantidad=true;
            }else 
            if(this.ComprobarCarrito(item.id)){

              me.snackbar=true;
              return;
            }else{


          this.productos.push(
            {
                           producto:item.nombre,
                           precio:item.precio_venta,
                           stock:item.stock,
                           cantidad:1,
                           imagen:item.foto,
                           subtotal:null,
                           id:item.id

              }
          )

               me.required_productos=false;


          }



        },
        EliminarCarrito(id){

          const index = this.productos.indexOf(id);
                                                                        
         this.productos.splice(index, 1);    
          if(!this.productos.length){
               this.required_productos=true;

          }

        },
        ComprobarCarrito(id){
          let me=this;
                  var sw=0;
                for(var i=0;i<me.productos.length;i++){
                    if(me.productos[i].id==id){
                        sw=true;
                    }
                }
                return sw;

        },

        Comprar(){


                  let me = this;
          me.cargarventa=true;
          me.desactivar=true;
   
                axios.post('/venta/registrar',{
                    'idcliente': me.idcliente,
                    'tipo_comprobante': me.tipo_comprobante,
                    'serie_comprobante' : me.serie_comprobante,
                    'num_comprobante' : me.num_comprobante,
              
                    'total' : me.total_pagar,   /* Valor temporal */
                    'data': me.productos

                }).then(function (response) {
                  
                    me.cargarventa=false,
                     me.desactivar=false,
                    me.listado=1;
                    me.idcliente=null;
                    me.tipo_comprobante='';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=null;
                    me.productos=[];
                    me.listarIngreso();                  

                }).catch(function (error) {
                     me.cargarventa=false,
                     me.desactivar=false,
                    console.log(error);
                });

        },
                cambiodetalle(id){
                  let me=this;
                    this.listado=2;
                    me.loading2=true;

                var urld='/venta/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
              
                    var respuesta= response.data;
                    me.lista_productos_detalle = respuesta.detalles;
                    me.loading2=false;
                })
                .catch(function (error) {
                      me.loading2=false;

                    console.log(error);
                });               


                    
                },


            cambiolista(){
                   let me=this;
                    me.listado=1;
                     me.idproveedor=null;
                    me.tipo_comprobante='';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=null;
                    me.productos=[];
                    me.items=[];
                    me.listarIngreso();        
                },

                registrarcompra(){
                   this.listado=3;
                },

                recibo(id){

                    let me=this;
               var urld='/venta/recibo?id=' + id;
                

                                    me.carga_email=true;



                              axios.post('enviar/email?id='+id).then(function(response){


                                    me.carga_email=false;
                                    me.snackbar_email=true;

                              }).catch((error)=>{
                                    me.carga_email=false;

                                console.log('Error: '+error)
                              }) 



                }


                
            },
            mounted(){
    
              this.listarProducto();
             this.listarIngreso();
            }


}

</script>