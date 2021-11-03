<template>
<v-app style="width:100%;heigth:100%" >




    <main class="main">
        

    <material-card
      icon="mdi-clipboard-text"
      icon-small
      title="Habilitar Productos"
      color="accent"
    >

<!-- :search="search" -->
  <v-data-table
    :headers="headers"
    :items="desserts"
   mobile-breakpoint="50"

    :loading="loading"
    hide-default-footer

    class="elevation-1"
  >
                         


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
      
         <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
 
        <v-spacer></v-spacer>

       
        <!-- Aquí -->
        <v-dialog
          v-model="dialog"
           width="700px"
          max-width="700px"
        >
        

          <!-- Dialog Card -->
          <v-card
          :loading="cargaregistro"
          >

            <v-card
             color="#26c6da"
            >       
            <v-card-title
           
            >
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>
                </v-card>

          <v-form
    ref="form"
    v-model="valid"
  

        >

    <div
    style="
    padding:2em;
    display:flex;
   flex-wrap: wrap;
   align-self:center;
   justify-content:center"
    >


          <div
          style="width:600px;"
                  
          >

                 <v-select
                    v-model="idcategoria"
                    :items="Categoria_prod"
                           :rules="CategoriaRules"

                   :disabled="activo"
                    label="Categorias"
                     item-text="nombre"
                      item-value="id"

                  ></v-select>
          </div>



     <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="codigo_producto"
            :rules="CodigoRules"
           :disabled="activo"
            label="Código"
            required
            ></v-text-field>
        </div>

   
        <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="nombre_producto"
            :rules="NombreRules"
            :disabled="activo"
            label="Nombre del producto"
            required
            ></v-text-field>
        </div>


                   <div v-if="!image"
                  style="width:600px;lign-items: center;
                         justify-content: center;
                        display: flex;wrap;flex-wrap: wrap"
                  >
                  <label for="file-upload" class="custom-file-upload">
                    <i class="fa fa-cloud-upload"></i> Subir Imagen
                </label>
                      <input  :disabled="activo" type="file"  id="file-upload" @change="onFileChange" accept="image/*" />
                    </div>
                    <div v-else
                    style="width:600px;align-items: center;
                         justify-content: center;
                        display: flex"
                    >
                      <v-img class="contenedor"  :src="image" contain  max-width="100" />
                      <v-btn
                      @click="removeImage"
                      class="ma-2"
                      text
                      :disabled="activo"
                      color="red lighten-2"
                    >
                      <v-icon>mdi-close</v-icon>
                      Eliminar
                    </v-btn>
                    
                    </div>
                    <div v-if="foto && !image"
                    tyle="width:600px;align-items: center;
                         justify-content: center;
                        display: flex"
                    >
                      <v-img  class="contenedor"  :src="'images/'+foto" contain max-width="100" />
                    </div>

    

    <div
          style="width:600px;"
                  
          >

            <v-select
                    :items="Presentacion_prod"
                    v-model="idpresentacion"
                      :rules="UnidadRules"
                   :disabled="activo"

                    label="Unidad de medida"
                     item-text="nombre"
                      item-value="id"
                   
                  ></v-select>
          </div>


      <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="precio_producto"
            :rules="PrecioRules"
             :disabled="activo"

            :min="minPrecio"
            type="number"
            label="Precio Venta"
            required
            ></v-text-field>
        </div>





              <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="stock_producto"
            :rules="StockRules"
             :disabled="activo"

            :min="minStock"

            type="number"
            label="Stock"
            required
            ></v-text-field>
        </div>

 
 </div>

          </v-form>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancelar
              </v-btn>

              
              <v-btn
              :disabled='!valid'
                color="blue darken-1"
                text
        
                v-if="editedIndex==-1"
              >
                Guardar
              </v-btn>
              <v-btn
               :disabled='!valid'
              v-else
                color="blue darken-1"
                text
                @click="editarproducto()"
              >
                Actualizar
              </v-btn>
            </v-card-actions>
            <template slot="progress">
      <v-progress-linear
        height="5"
        indeterminate
        absolute
        bottom
        color="deep-purple accent-4"
      ></v-progress-linear>
    </template>
          </v-card>

          <!-- FIN DIALOG CARD -->
        </v-dialog>
        <v-dialog v-model="dialogDesactivar" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">¿Quieres deshabilitar este producto?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="confirmdeshabilitar">Aceptar</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    
   <template  v-slot:[`item.nombre_categoria`]="{ item }">
      <v-chip
        :color="getColor(item.nombre_categoria)"
        dark
      >
        {{ item.nombre_categoria }}
      </v-chip>
    </template>

        
   <template  v-slot:[`item.foto`]="{ item }">
     <v-img max-width="60" contain  :src="'images/'+item.foto" />
    </template>

 <template  v-slot:[`item.precio_venta`]="{ item }">
     <h6>Q.{{item.precio_venta}}</h6>
    </template>

    <template v-slot:[`item.opciones`]="{ item }">
     
    
      <v-tooltip
          v-model="item.edit"
          top
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
            @click="cargaeditar(item)"
              icon
              v-bind="attrs"
              v-on="on"
              class="outlin"
            >
              <v-icon       color="blue darken-2"
>
                mdi-pencil
              </v-icon>
            </v-btn>
          </template>
          <span>Editar</span>
        </v-tooltip>


      <v-tooltip
          v-model="item.tooltip"
          top
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              @click="desactivarProducto(item.id,item.estado)"
              icon
              v-bind="attrs"
              v-on="on"
              class="outlin"
            >
                <v-switch

              v-model="item.estado"              
              color="success"
              
          
            ></v-switch>
            </v-btn>
          </template>
          <span>Activar</span>
        </v-tooltip>
    


    </template>





      </v-data-table>

         <v-pagination
                v-model="pagination.current_page"
                :length="pagination.total"
                @input="onPageChange"
            ></v-pagination>

                


         </material-card>






    </main>
   </v-app>
</template>


<script>

export default {
 props : ['ruta'],
  data(){
          return{

            cargaregistro:false,
            activo:false,
       dialog: false,
      dialogDesactivar: false,
      valid: true,
      search: '',
       loading: false,
      minPrecio:0,
      minStock:0,
       image:'',
       CategoriaRules: [
        v => !!v || 'Categoria requerida.',
      ],
        CodigoRules: [
        v => !!v || 'Codigo requerido.',
      ],
        NombreRules: [
        v => !!v || 'Nombre requerido.',
      ],
       UnidadRules: [
        v => !!v || 'Unidad de medida requerido.',
      ],
       PrecioRules: [
        v => !!v || 'Precio requerido.',
           ],


       StockRules: [
        v => !!v || 'Stock requerido.',
      ],
        Categoria_prod: [],
        Presentacion_prod:[],
      headers: [

         { text: 'Código', value: 'codigo', sortable: false },

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
        { text: 'Opciones', value: 'opciones', sortable: false },

      ],

                  pagination : {
                    total : 0,
                    current_page :1,
                   
                },
      desserts: [],
      editedIndex: -1,
        id_producto_temp:null,
        producto_id:null,
        idcategoria:null,
        idpresentacion:null,
        categoria:'',
        presentacion:'',

        codigo_producto:'',
        nombre_producto: '',
        foto:'',
        categoria: '',
        unidad:'',
        precio_producto:null,
        stock_producto:null,
        contador:0,
        aux:null
        



   
          }
         },

          computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar Producto' : 'Editar Producto'
      },
        
      
    },

    watch: {
      dialog (val) {
        val || this.close()
      },

      dialogDesactivar(val){
        val || this.closeDelete()
        

      }
    },
    

    methods: {

  reset() {
        this.$refs.form.reset()
      },
        Reporte(){

                window.open('/producto/listarPdf','_blank');


        },
      envioidcategoria(id){
        this.idcategoria=id;
      },
     envioidpresentacion(id){
        this.idpresentacion=id
      },
      close () {
        
        this.dialog = false
        this.$nextTick(() => {
          this.editedIndex = -1
           this.limpiar();
           this.reset();


        })
      },
      closeDelete () {

     

        let me=this;
         this.$nextTick(() => {
        me.desserts.map(function(item){

          if(item.id==me.id_producto_temp){
            item.estado=0;
          }

        })
        me.id_producto_temp=null;
        me.dialogDesactivar = false
})

      },

    onFileChange(e) {
              
  
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    
   
/*     this.image= URL.createObjectURL(this.imagen_producto)
 console.log('valor url: '+this.url)
 console.log('valor imagen_producto: '+this.imagen_producto) */
 
    },
 createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = (e) => {
        vm.image = e.target.result;
      };

      reader.readAsDataURL(file);
    },

      removeImage: function (e) {
      this.image = '';
    },
         getColor (nombre_categoria) {
      return 'orange'
      },
     

      /* LISTAR PRODUCTOS */

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

      const url=  '/lista/producto/deshabilitado?page=' +me.pagination.current_page+ '&buscar='+ me.search;

      axios
        .get(url)
        .then(function (response) {
        me.desserts=[];
        
          var respuesta = response.data;
         
         me.desserts= respuesta.productos.data

                  console.log('paginacion: '+JSON.stringify(respuesta.pagination))
                    me.pagination.current_page=respuesta.pagination.current_page;
                    me.pagination.total = respuesta.pagination.last_page;

                me.loading=false;

        })
        .catch(function (error) {
          console.log(error);
        });
    },

      cambiarPagina(page){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProducto(page);
            },

 onPageChange() {
   console.log('valor: '+this.pagination.current_page)
            this.listarProducto();
        },
      cargaeditar(item){
        console.log('ruta: '+JSON.stringify(item))
        let me=this;
        this.editedIndex = this.desserts.indexOf(item)
          this.dialog=true;
          me.idcategoria= item.idcategoria,
          me.idpresentacion=item.idpresentacion,
          me.foto=item.foto
         me.categoria=item.categoria;
         me.presentacion=item.unidad;
        me.codigo_producto=item.codigo;
        me.nombre_producto= item.nombre;
        me.precio_producto=item.precio_venta;
        me.stock_producto=item.stock;
        me.producto_id=item.id

      },


      editarproducto(){
        let me=this;
     axios
        .put("/producto/actualizar", {

          idcategoria: me.idcategoria,
          idpresentacion:me.idpresentacion,
          codigo: me.codigo_producto,
          nombre: me.nombre_producto,
          existencia: me.stock_producto,
          precio_venta:me.precio_producto,
          image: me.image,
          foto:me.foto,
          id:me.producto_id ,

        })
        .then(function (response) {

       
         me.editedIndex =-1;
          me.limpiar();
         me.listarProducto();
       
        })
        .catch(function (error) {
          console.log(error);
        });
        

      },


            /* REGISTRO DE PRODUCTOS */
 /*          registrarProducto() {
    
      let me = this;
      me.activo=true;
      me.cargaregistro=true;
      axios.post("/producto/registrar", {
          idcategoria: me.idcategoria,
          idpresentacion:me.idpresentacion,
          codigo: me.codigo_producto,
          nombre: me.nombre_producto,
          existencia: me.stock_producto,
          precio_venta:me.precio_producto,
          image: me.image, 
          aux:'miniatura.png'
        })
        .then(function (response) {
              me.cargaregistro=false;
            me.activo=false;

          me.limpiar();
         me.listarProducto();

        })
        .catch(function (error) {
                me.cargaregistro=false;
      me.activo=false;

          console.log(error);
          });
         }, */



         /* DESACTIVAR PORDUCTO */
           desactivarProducto(id,estado) {
             this.id_producto_temp=null;
            if(estado==1){
           this.dialogDesactivar=true;
           this.id_producto_temp=id;
            }
            
      
          },


          confirmdeshabilitar(){
              let me=this;
              axios
              .put("/producto/activar", {
                id:me.id_producto_temp,
              })
              .then(function (response) {
               me.id_producto_temp=null; 
               me.dialogDesactivar=false;
              me.listarProducto();
              })
              .catch(function (error) {
                console.log(error);
              });
          },


         limpiar(){
        let me=this;
        me.idcategoria='';
        me.idpresentacion='';
        me.categoria='';
         me.presentacion='';
        me.codigo_producto='';
        me.nombre_producto= '';
        me.categoria= '';
        me.unidad=0;
        me.precio_producto='';
        me.stock_producto='';
        me.image='';
        me.foto='';
        me.dialog=false;
         },


          listarCategoria() {
      let me = this;
 
      axios
        .get("/categoria")
        .then(function (response) {

          var respuesta = response.data;
         

          respuesta.categorias.data.map(function(index){
                        me.Categoria_prod.push({
                          nombre:index.nombre,
                          id:index.id

                        })

                });

          

        })
        .catch(function (error) {
          console.log(error);
        });
    },


        listarPresentacion() {
      let me = this;
 
      axios
        .get("/presentacion")
        .then(function (response) {

          var respuesta = response.data;
         

          respuesta.presentacions.data.map(function(index){
                        me.Presentacion_prod.push({
                          nombre:index.nombre,
                          id:index.id

                        })

                });

          

        })
        .catch(function (error) {
          console.log(error);
        });
    },


    },
    mounted(){
    this.listarProducto();
    this.listarCategoria();
    this.listarPresentacion();
    
  }


    


    
}
</script>


<style scoped>
input[type="file"] {
    display: none;
}
.custom-file-upload {
    border: 2px solid rgb(3, 3, 3);
    border-radius: 8px;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
.custom-file-upload:hover{
  background-color:aqua;
}
.contenedor{
border: 2px solid rgb(139, 139, 139);
    border-radius: 8px;
    display: inline-block;
    padding: 6px 12px;

}
.outlin{
  outline: none;
}
</style>