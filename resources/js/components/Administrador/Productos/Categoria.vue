<template>
<v-app style="width:100%;heigth:100%" >




    <main class="main">
        

    <material-card
      icon="mdi-clipboard-text"
      icon-small
      title="Lista de Categorias"
      color="accent"
    >


  <v-data-table
    :headers="headers"
    :items="lista_categorias"
    :search="search"
    mobile-breakpoint="50"
    :loading="loading"
    sort-by="calories"
    class="elevation-1"
  >
 


    <template v-slot:top>
      <v-toolbar
        flat
      >
      <v-text-field
        v-model="search"
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
          <v-card>

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
        
            v-model="nombre_categoria"
            :rules=" NombreRules"
            label="Nombre de Categoria"
            :disabled="activo"
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
                @click="registrarCategoria()"
                v-if="editedIndex==-1"
              >
                Guardar
              </v-btn>
              <v-btn
          :disabled='!valid'
              v-else
                color="blue darken-1"
                text
               
                @click="editarCategoria()"
              >
                Actualizar
              </v-btn>
            </v-card-actions>
          </v-card>

          <!-- FIN DIALOG CARD -->
        </v-dialog>
        <v-dialog v-model="dialogDesactivar" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">¿Quieres deshabilitar esta categoria?</v-card-title>
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
    
   <template  v-slot:[`item.nombre`]="{ item }">
      <v-chip
        :color="getColor(item.nombre)"
        dark
      >
        {{ item.nombre }}
      </v-chip>
    </template>





    <template v-slot:[`item.opciones`]="{ item }">
     
    
      <v-tooltip
          v-model="item.edit"
          top
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
            class="outlin"
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

    


    </template>





  </v-data-table>






    </material-card>






    </main>
   </v-app>
</template>


<script>

export default {

  data(){
          return{
            activo:false,
       dialog: false,
      dialogDesactivar: false,
     valid:true,
      search: '',
       loading: false,
      
      NombreRules: [
        v => !!v || 'Nombre requerido.',
      ],
      headers: [


        {
          text: 'Nombre',
          align: 'start',
         
          value: 'nombre',
        },  
        { text: 'Opciones', value: 'opciones', sortable: false },

      ],     
      lista_categorias: [],
      editedIndex: -1,
        id_categoria_temp:null,
        nombre_categoria: '',
        categoria_id:null

        
        



   
          }
         },

          computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar Categoria' : 'Editar Categoria'
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
            this.$refs.form.reset()

           this.limpiar();


        })
      },
      closeDelete () {

     

        let me=this;
         this.$nextTick(() => {
        me.lista_categorias.map(function(item){

          if(item.id==me.id_categoria_temp){
            item.desactivar=1;
          }

        })
        me.id_categoria_temp=null;
        me.dialogDesactivar = false
})

      },

    
         getColor (categoria) {
      return 'orange'
      },
     

      /* LISTAR PRODUCTOS */

    listarCategoria() {
      let me = this;
      me.lista_categorias=[];
      me.loading=true;
      axios
        .get("/categoria")
        .then(function (response) {

          var respuesta = response.data;
         

          respuesta.categorias.data.map(function(index){
                        me.lista_categorias.push(
                          {
                          
                            nombre:index.nombre,                          
                            desactivar:index.estado,
                            tooltip:false,
                            edit:false,
                            id:index.id

                                    },
                              
                        )

                });

                me.loading=false;

        })
        .catch(function (error) {
          console.log(error);
        });
    },


      cargaeditar(item){
        let me=this;
        this.editedIndex = this.lista_categorias.indexOf(item)
          this.dialog=true;
         
        me.nombre_categoria= item.nombre;
        me.categoria_id=item.id;
 
      },


      editarCategoria(){
        let me=this;
        me.activo=true;
          axios
        .put("/categoria/actualizar", {

        
          nombre: me.nombre_categoria,         
          id:me.categoria_id,

        })
        .then(function (response) {

       
         me.editedIndex =-1;
         me.activo=false;
          me.limpiar();
         me.listarCategoria();
       
        })
        .catch(function (error) {
          console.log(error);
        });
        

      },


            /* REGISTRO DE PRODUCTOS */
          registrarCategoria() {
    
      let me = this;
      me.activo=true;
      axios.post("/categoria/registrar", {
         
          nombre: me.nombre_categoria,
         
        })
        .then(function (response) {
        me.activo=false;
          me.limpiar();
          me.listarCategoria();
 
        })
        .catch(function (error) {
          console.log(error);
          });
         },



         /* DESACTIVAR PORDUCTO */
           desactivarCategoria(id,estado) {
             this.id_categoria_temp=null;
            if(estado==0){
           this.dialogDesactivar=true;
           this.id_categoria_temp=id;
            }
            
      
          },


          confirmdeshabilitar(){
              let me=this;
              axios
              .put("/categoria/desactivar", {
                id:me.id_categoria_temp,
              })
              .then(function (response) {
               me.id_categoria_temp=null; 
               me.dialogDesactivar=false;
              me.listarCategoria();
              })
              .catch(function (error) {
                console.log(error);
              });
          },


         limpiar(){
        let me=this;
      
        me.nombre_categoria= '';
        me.dialog=false;

         }




    },
    mounted(){
    this.listarCategoria();
    
  }


    


    
}
</script>


<style scoped>
.outlin{
outline:none;
}
</style>