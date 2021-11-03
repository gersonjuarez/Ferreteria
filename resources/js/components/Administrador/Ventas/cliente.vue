<template>
<v-app style="width:100%;heigth:100%" >




    <main class="main">
        

    <material-card
      icon="mdi-clipboard-text"
      icon-small
      title="Lista de Clientes"
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
        @input="listarPersona"
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
                <v-select
        
            v-model="tipo_documento"
            :items="Documento_client"
            item-text="nombre"
            item-value="nombre"
            :rules="dpirules"
            :disabled="des"
            label="tipo de documento"
            required
            ></v-select>

          </div>



   

   
        <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="num_documento"
            :rules="dpirules"
            :disabled="activo"
            label="numero de documento"
            required
            ></v-text-field>
        </div>


               
                    
                    
             

    

      <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="direccion"
           
             :disabled="activo"

        :rules="direccionRules"
            type="text"
            label="direccion"
            required
            ></v-text-field>
        </div>





              <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="telefono"
           
             :disabled="activo"

            
:rules="telefonorules"
            type="number"
            label="telefono"
            required
            ></v-text-field>
        </div>

        
              <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="email"
             :disabled="activo"
             :rules="correoRules"
            label="email"
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
                @click="registrarPersona()"
                v-if="editedIndex==-1"
              >
                Guardar
              </v-btn>
              <v-btn
               :disabled='!valid'
              v-else
                color="blue darken-1"
                text
                @click="editarpersona()"
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
              @click="desactivarPersona(item.id,item.estado)"
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
  persona_id: 0,
  activo:false,
  des:true,
                nombre : '',
                tipo_documento : {id:1,nombre:'DNI'},
                 Documento_client: [
            {id:1,nombre:'DNI'},

        ],
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                arrayPersona : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },


                
         namerules: [
            v => !!v || 'El nombre del cliente no puede estar vacio',
            v => (v && v.length <= 49) || 'El nombre del cliente no puede ser mayor a 50',
            v => /[a-zA-Z]/.test(v) || 'El nombre del cliente solo puede tener letras',
        ],
          direccionRules: [
            v => !!v || 'La direccion del cliente no puede estar vacia',
            v => (v && v.length <= 99) || 'El apellido del proveedor no puede ser mayor a 100',
        ],
         telefonorules: [
            v => !!v || 'El telefono del cliente no puede estar vacio',
           
        ],
        correoRules: [
            v => !!v || 'El campo de correo no puede estar vacio',
            v => /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/.test(v)|| 'El correo ingresado no existe',
        ],
        dpirules: [
            v => !!v || 'El campo de dpi no puede estar vacio',
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
    
        { text: 'tipo de documento', value: 'tipo_documento', sortable: false },
        { text: 'numero de documento', value: 'num_documento' },
        { text: 'direccion', value: 'direccion' },
         { text: 'telefono', value: 'telefono' },
          { text: 'email', value: 'email' },
        { text: 'Opciones', value: 'opciones', sortable: false },

      ],

                  pagination : {
                    total : 0,
                    current_page :1,
                   
                },
      desserts: [],
      editedIndex: -1,
   persona_id_temp:null,


 
      
   
        contador:0,
        aux:null
        



   
          }
         },

          computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar Cliente' : 'Editar Cliente'
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


      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedIndex = -1
          console.log('antes del reset:'+this.tipo_documento)
          this.$refs.form.reset()
           this.limpiar();
          console.log('despues del reset:'+this.tipo_documento)

        })
      },
      closeDelete () {

     

        let me=this;
         this.$nextTick(() => {
        me.desserts.map(function(item){

          if(item.id==me.id){
            item.estado=1;
          }

        })
        me.id=null;
        me.dialogDesactivar = false
})

      },


      
      /* LISTAR CLIENTES */

    listarPersona() {
     
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

      const url= '/cliente?page=' +me.pagination.current_page+ '&buscar='+me.search;

      axios.get(url).then(function (response) {
        me.desserts=[];
          var respuesta = response.data;
         
        console.log('data: '+JSON.stringify(respuesta))
          me.desserts= respuesta.personas.data;

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
                me.listarPersona(page);
            },

 onPageChange() {
   console.log('valor: '+this.pagination.current_page)
            this.listarPersona();
        },
      cargaeditar(item){
        console.log('ruta: '+JSON.stringify(item))
        let me=this;
        this.editedIndex = this.desserts.indexOf(item)
          this.dialog=true;
          
        
       
        me.nombre= item.nombre;
        me.tipo_documento=item.tipo_documento;
        me.num_documento=item.num_documento
        me. direccion=item. direccion;
        me.telefono=item.telefono
        me.email=item.email
        me.id=item.id
        me.estado=item.estado

      },


      editarpersona(){
        let me=this;
                    me.activo=true;
     axios.put("/cliente/actualizar", {

         nombre:me.nombre,
         tipo_documento:me.tipo_documento,
         num_documento:me.num_documento,
         direccion:me.direccion,
         telefono:me.telefono,
         email:me.email,
         estado:me.estado,
         id:me.id,


        })
        .then(function (response) {

       
         me.editedIndex =-1;
         me.activo=false;
          me.limpiar();
         me.listarPersona(1,'','nombre');
       
        })
        .catch(function (error) {
          console.log(error);
        });
        

      },


            /* REGISTRO DE CLIENTE */
          registrarPersona() {
    
      let me = this;
      me.activo=true;
      me.cargaregistro=true;
      axios.post("/cliente/registrar", {
       
          'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento.nombre,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'estado':this.estado
                    

       
        })
        .then(function (response) {
              me.cargaregistro=false;
            me.activo=false;

          me.limpiar();
         me.listarPersona(1,'','nombre');

        })
        .catch(function (error) {
                me.cargaregistro=false;
      me.activo=false;

          console.log(error);
          });
         },
         



         /* DESACTIVAR PORDUCTO */
           desactivarPersona(id,estado) {
             this.id=null;
            if(estado==0){
           this.dialogDesactivar=true;
           this.id=id;
            }
            
      
          },


          confirmdeshabilitar(){
              let me=this;
              axios
              .put("/cliente/desactivar", {
                id:me.id,
              })
              .then(function (response) {
               me.id=null; 
               me.dialogDesactivar=false;
              me.listarPersona();
              })
              .catch(function (error) {
                console.log(error);
              });
          },


         limpiar(){
        let me=this;
        me.tipo_documento={id:1,nombre:'DNI'};

        me.nombre= '';
        me.num_documento='';
        me.direccion='';
        me.telefono='';
        me.email='';
        
        me.dialog=false;
         },





    },
    mounted(){
    this.listarPersona();
   
    
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