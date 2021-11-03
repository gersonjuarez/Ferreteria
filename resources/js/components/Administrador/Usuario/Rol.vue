<template>
<v-app style="width:100%;heigth:100%" >




    <main class="main">
        

    <material-card
      icon="mdi-clipboard-text"
      icon-small
      title="Lista de Roles"
      color="accent"
    >

<!-- :search="search" -->
  <v-data-table
    :headers="headers"
    :items="desserts"
    mobile-breakpoint="50"

    :loading="loading"
    hide-default-footer

    sort-by="calories"
    class="elevation-1"
  >
                         


    <template v-slot:top>
      <v-toolbar
        flat
      >
      <v-text-field
        v-model="search"
        @input="listarRoles"
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
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
               <v-icon
        small
        class="mr-2"
     
      >
        mdi-plus
      </v-icon>Nuevo
            </v-btn>
          </template>

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

      <v-text-field
        
            v-model="nombre"
           :disabled="activo"
           :rules="namerules"
            label="nombre"
            required
            ></v-text-field>
        </div>

          <div
          style="width:600px;"
                  
          >
                <v-text-field
        
            v-model="descripcion"
          
           :disabled="activo"
            label="descripcion"
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
                @click="registrarRol()"
                v-if="editedIndex==-1"
              >
                Guardar
              </v-btn>
              <v-btn
               :disabled='!valid'
              v-else
                color="blue darken-1"
                text
                @click="editarRol()"
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
            <v-card-title class="text-h5">¿Quieres deshabilitar este cliente?</v-card-title>
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
              @click="desactivarRol(item.id,item.desactivar)"
              icon
              v-bind="attrs"
              v-on="on"
            >
                <v-switch

              v-model="item.desactivar"              
              color="success"
              
          
            ></v-switch>
            </v-btn>
          </template>
          <span>Desactivar</span>
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
id:0,
 
                nombre : '',
              
            descripcion:'',
              
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorRol : 0,
                errorMostrarMsjRol : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },


                
         namerules: [
            v => !!v || 'El nombre del Rol no puede estar vacio',
            v => (v && v.length <= 49) || 'El nombre del rol no puede ser mayor a 50',
            v => /[a-zA-Z]/.test(v) || 'El nombre del rol solo puede tener letras',
        ],
   
   
                offset : 3,
                
                buscar : '',
            cargaregistro:false,
            activo:false,
       dialog: false,
      dialogDesactivar: false,
      valid: true,
      search: '',
       loading: false,
   

criterio : 'nombre',


   
      headers: [

 

        {
          text: 'Nombre',
          align: 'start',
         value: 'nombre',
        },
    
          { text: 'descripcion', value: 'descripcion' },
        { text: 'Opciones', value: 'opciones', sortable: false },

      ],

                  pagination : {
                    total : 0,
                    current_page :1,
                   
                },
      desserts: [],
      editedIndex: -1,
   rol_id_temp:null,

        contador:0,
        aux:null
          }
         },

          computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar Rol' : 'Editar Rol'
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

validate(){
    this.$refs.form.validate()
},
reset(){
this.$refs.form.reset()
},
resetValidation(){
    this.$refs.form.resetValidation()
},
  
      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedIndex = -1
           this.limpiar();


        })
      },
      closeDelete () {

     

        let me=this;
         this.$nextTick(() => {
        me.desserts.map(function(item){

          if(item.id==me.id){
            item.desactivar=1;
          }

        })
        me.id=null;
        me.dialogDesactivar = false
})

      },

      /* LISTAR CLIENTES */

    listarRoles() {
     
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

      const url= '/rol?page=' +me.pagination.current_page+ '&buscar='+me.search;

      axios.get(url).then(function (response) {
        me.desserts=[];
          var respuesta = response.data;
         
        console.log('data: '+JSON.stringify(respuesta))
          respuesta.roles.data.map(function(index){
                        me.desserts.push(
                          {
                            
                            nombre:index.nombre,
                            descripcion:index.descripcion,
                          
                            edit:false,
                            tooltip:false,
                            desactivar:index.estado,
                            id:index.id
                       
                                    },
                              
                        )

                });

                  console.log('paginacion: '+JSON.stringify(respuesta.pagination))
                    me.pagination.current_page=respuesta.pagination.current_page;
                    me.pagination.total = respuesta.pagination.last_page;
/*               me.pagination= respuesta.pagination; 
 */
                me.loading=false;
/*                 console.log('total de paginacion: '+JSON.stringify(me.pagination))
 */
/*
 */


          /* me.pagination = respuesta.pagination; */
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
                me.listarRoles(page);
            },

 onPageChange() {
   console.log('valor: '+this.pagination.current_page)
            this.listarRoles();
        },
      cargaeditar(item){
        console.log('ruta: '+JSON.stringify(item))
        let me=this;
        this.editedIndex = this.desserts.indexOf(item)
          this.dialog=true;
          
        
       
        me.nombre= item.nombre;
        me.descripcion=item.descripcion;
      
        me.id=item.id
        me.estado=item.estado

      },


      editarRol(){
        let me=this;
                    
     axios.put("/rol/actualizar", {

         nombre:me.nombre,
         descripcion:me.descripcion,
        
         estado:me.estado,
         id:me.id,


        })
        .then(function (response) {

       
         me.editedIndex =-1;
          me.limpiar();
         me.listarRoles(1,'','nombre');
       
        })
        .catch(function (error) {
          console.log(error);
        });
        

      },


            /* REGISTRO DE CLIENTE */
          registrarRol() {
    
      let me = this;
      me.activo=true;
      me.cargaregistro=true;
      axios.post("/rol/registrar", {
       
          'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    
                    'estado':this.estado
                    

       
        })
        .then(function (response) {
              me.cargaregistro=false;
            me.activo=false;

          me.limpiar();
         me.listarRoles(1,'','nombre');

        })
        .catch(function (error) {
                me.cargaregistro=false;
      me.activo=false;

          console.log(error);
          });
         },
         



         /* DESACTIVAR PORDUCTO */
           desactivarRol(id,estado) {
             this.id=null;
            if(estado==0){
           this.dialogDesactivar=true;
           this.id=id;
            }
            
      
          },


          confirmdeshabilitar(){
              let me=this;
              axios
              .put("/rol/desactivar", {
                id:me.id,
              })
              .then(function (response) {
               me.id=null; 
               me.dialogDesactivar=false;
              me.listarRoles();
              })
              .catch(function (error) {
                console.log(error);
              });
          },


         limpiar(){
        let me=this;
        me.nombre= '';
        me.descripcion= '';
       
        
        me.dialog=false;
         },





    },
    mounted(){
    this.listarRoles();
   
    
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
</style>