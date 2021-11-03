  <template>
<v-app style="width:100%;heigth:100%" >




    <main class="main">
        

    <material-card
      icon="mdi-clipboard-text"
      icon-small
      title="Habilitar Usuario"
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
        @input="listarUser"
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

      <v-text-field
        
            v-model="nombre"
            :rules="RulesNombre"

            :disabled="activo"
            label="Nombre del Usuario"
            required
            ></v-text-field>
        </div>
         <div
          style="width:600px;"
                  
          >
                <v-text-field
        
            v-model="tipo_documento"
           :rules="dpirules"
           :disabled="des"
            label="tipo de documento"
            required
            ></v-text-field>

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

               
     <div
          style="width:600px;"
                  
          >

                 <v-select
                    v-model="idrol"
                    :items="urol"
                    :rules="rolrules"


                   :disabled="activo"
                    label="roles"
                     item-text="nombre"
                      item-value="id"

                  ></v-select>
          </div>

         

    <div
        style="width:600px;"
        >

      <v-text-field
        
            v-model="usuario"
             :disabled="activo"
                  :rules="userrules"

            label="usuario"
            required
            ></v-text-field>
        </div>
        
    <div
        style="width:600px;"
        >

        <v-text-field
        
            v-model="password"
             :disabled="activo"
             :rules="contrarules"
              :append-icon="value ? 'fas fa-eye' : 'fas fa-eye-slash'"
              @click:append="value = !value"
              :type="value ? 'password' : 'text'"

            label="password"
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
                @click="registraruser()"
                v-if="editedIndex==-1"
              >
                Guardar
              </v-btn>
              <v-btn
               :disabled='!valid'
              v-else
                color="blue darken-1"
                text
                @click="editaruser()"
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
            <v-card-title class="text-h5">¿Quieres deshabilitar este Usuario?</v-card-title>
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
    
   <template  v-slot:[`item.idrol`]="{ item }">
      <v-chip
        :color="getColor(item.idrol)"
        dark
      >
        {{ item.idrol }}
      </v-chip>
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
              @click="desactivarUser(item.id,item.estado)"
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
            des:true,
 rol: [],
 urol:[],
  rol:'',
  value:true,
            cargaregistro:false,
            activo:false,
       dialog: false,
      dialogDesactivar: false,
      valid: true,
      search: '',
       loading: false,
      
       
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
           { text: 'rol', value: 'rol' },
                  { text: 'usuario', value: 'usuario' },

        { text: 'Opciones', value: 'opciones', sortable: false },

      ],
       RulesNombre: [
            v => !!v || 'El nombre del cliente no puede estar vacio',
            v => (v && v.length <= 49) || 'El nombre del cliente no puede ser mayor a 50',
            v => /[a-zA-Z]/.test(v) || 'El nombre del cliente solo puede tener letras',
        ],
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
  rolrules: [
            v => !!v || 'El campo rol no puede estar vacio',
        ],
          userrules: [
            v => !!v || 'El campo usuario no puede estar vacio',
        ],
          contrarules: [
            v => !!v || 'El campo password no puede estar vacio',
        ],
                  pagination : {
                    total : 0,
                    current_page :1,
                   
                },
      desserts: [],
      editedIndex: -1,
      
       persona_id: 0,
                nombre : '',
                tipo_documento : 'DNI',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario : '',
                password : '',
                idrol : 0,
                arrayPersona : [],
                arrayRol : [],
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
     
                 offset : 3,
                criterio : 'nombre',
                buscar : '',
      
        contador:0,
        aux:null
        



   
          }
         },

          computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar Usuario' : 'Eliminar Usuario'
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

      enviorol(id){
        this.idrol=id;
      },
     
      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedIndex = -1
            this.$refs.form.reset()

           this.limpiar();


        })
      },
      closeDelete () {

     

        let me=this;
         this.$nextTick(() => {
        me.desserts.map(function(item){

          if(item.id==me.id){
            item.estado=0;
          }

        })
        me.id=null;
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
       

     

      /* LISTAR PRODUCTOS */

    listarUser() {
     
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

      const url=  '/user/deshabilitado?page=' +me.pagination.current_page+ '&buscar='+ me.search;

      axios
        .get(url)
        .then(function (response) {
        me.desserts=[];
          var respuesta = response.data;
         
        console.log('data: '+JSON.stringify(respuesta))
          me.desserts=respuesta.personas.data;

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
                me.listarUser(page);
            },

 onPageChange() {
   console.log('valor: '+this.pagination.current_page)
            this.listarUser();
        },
      cargaeditar(item){
        console.log('ruta: '+JSON.stringify(item))
        let me=this;
        this.editedIndex = this.desserts.indexOf(item)
          this.dialog=true;
             me.nombre= item.nombre,
        me.tipo_documento=item.tipo_documento,
        me.num_documento=item.num_documento,
        me. direccion=item. direccion,
        me.telefono=item.telefono,
        me.email=item.email,
        me.rol=item.rol,
        me.usuario=item.usuario,
        me.password=item.password,
        me.id=item.id,
        me.idrol=item.idrol,
        me.estado=item.estado
    
     

      },


      editaruser(){
        let me=this;
     axios
        .put("/user/actualizar", {
          nombre:me.nombre,
         tipo_documento:me.tipo_documento,
         num_documento:me.num_documento,
         direccion:me.direccion,
         telefono:me.telefono,
         email:me.email,
         estado:me.estado,
         usuario:me.usuario,
         password:me.password,
         id:me.id,
         idrol:me.idrol,

       

        })
        .then(function (response) {

       
         me.editedIndex =-1;
          me.limpiar();
         me.listarUser();
       
        })
        .catch(function (error) {
          console.log(error);
        });
        

      },


          
          registraruser() {
    
      let me = this;
      me.activo=true;
      me.cargaregistro=true;
      axios.post("/user/registrar", {
        nombre: me.nombre,
        tipo_documento:me.tipo_documento,
        num_documento:me.num_documento,
        direccion:me.direccion,
        telefono:me.telefono,
        email:me.email,
           idrol:me.idrol,
        usuario:me.usuario,
        password:me.password,
       
        estado:me.estado

   
               
        })
        .then(function (response) {
              me.cargaregistro=false;
            me.activo=false;

          me.limpiar();
         me.listarUser(1,'','nombre');

        })
        .catch(function (error) {
                me.cargaregistro=false;
      me.activo=false;

          console.log(error);
          });
         },



         /* DESACTIVAR PORDUCTO */
           desactivarUser(id,estado) {
             this.id=null;
            if(estado==1){
           this.dialogDesactivar=true;
           this.id=id;
            }
            
      
          },


          confirmdeshabilitar(){
              let me=this;
              axios
              .put("/user/activar", {
                id:me.id,
              })
              .then(function (response) {
               me.id=null; 
               me.dialogDesactivar=false;
              me.listarUser();
              })
              .catch(function (error) {
                console.log(error);
              });
          },


         limpiar(){
        let me=this;
   
         me.nombre= '';
        me.tipo_documento= '';
        me.num_documento='';
        me.direccion='';
        me.telefono='';
        me.email='';
        me.idrol='';
         me.rol='';
        me.usuario='';
        me.password='';
       
      
     
        me.dialog=false;
         },


          listarrol() {
      let me = this;
 
      axios
        .get("/rol")
        .then(function (response) {

          var respuesta = response.data;
         

          respuesta.roles.data.map(function(index){
                        me.urol.push({
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
    this.listarUser();
    this.listarrol();
  
    
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
  
  
  
        