<template>



          <material-card
          color="red lighten-1"
          full-header
        >
          <template #heading>
            <v-tabs
              v-model="tabs"
              background-color="transparent"
              slider-color="white"
              class="pa-8"
            >
              <span
                class="subheading font-weight-light mx-3"
                style="align-self: center"
              >Opciones:</span>
              <v-tab class="mr-3">
                <v-icon class="mr-2">
                  mdi-poll
                </v-icon>
                Reporte de Ingresos
              </v-tab>
              <v-tab class="mr-3">
                <v-icon class="mr-2">
                  mdi-poll
                </v-icon>
                Reporte de Ventas
              </v-tab>
         
            </v-tabs>
          </template>

          <v-tabs-items
            v-model="tabs"
            background-color="transparent"
          >   



            <v-tab-item
           
            >    


        
            <h2 style="text-align:center;">Seleccione el rango de fecha a consultar.</h2>


      <v-row
      >
    <v-col
      cols="12"
      sm="6"
      md="6"
    >

             <v-menu
        v-model="menu1"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="auto"
   
      
      >
      
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="fecha_inicial_c"
            label="Selelccione fecha inicial"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>

     
        <v-date-picker
        color="purple"
          v-model="fecha_inicial_c"
          @input="menu1 = false"
              :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
             min="2021-10-01"

            locale="es"
            
        ></v-date-picker>
     
      </v-menu>
    </v-col>
    <v-col
    cols="12"
      sm="6"
      md="6"
    >
      <v-menu
        v-model="menu2"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="fecha_final_c"
            label="Selelccione fecha final"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
        color="purple"
          v-model="fecha_final_c"
          @input="menu2 = false"
          locale="es"
        :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
             min="2021-10-01"
        ></v-date-picker>
      </v-menu>

         
 
    </v-col>
</v-row>



          <div style="display:flex;justify-content:center">
          <v-btn
        
          color="blue-grey"
          class="ma-2 white--text "
          @click="ReporteCompras"
        >
          Generar
          <v-icon
            right
            dark
          >
            mdi-animation
          </v-icon>
        </v-btn>
              </div>


         




            </v-tab-item>   





<!-- REPORTE DE VENTAS -->

       <v-tab-item
           
            >    




  <h2 style="text-align:center;">Seleccione el rango de fecha a consultar.</h2>



          
      <v-row
      >
    <v-col
      cols="12"
      sm="6"
      md="6"
    >


             <v-menu
        v-model="menu3"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="fecha_inicial_v"
            label="Selelccione fecha inicial"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
        color="purple"
          v-model="fecha_inicial_v"
          @input="menu3 = false"
            locale="es"
         :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
             min="2021-10-01"    
        ></v-date-picker>
      </v-menu>
          </v-col>
    <v-col
      cols="12"
      sm="6"
      md="6"
    >
      <v-menu
        v-model="menu4"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="fecha_final_v"
            label="Selelccione fecha final"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
        color="purple"
          v-model="fecha_final_v"
          @input="menu4 = false"
          locale="es"
         :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
             min="2021-10-01"
        ></v-date-picker>
      </v-menu>

         
    </v-col>

      </v-row>
       



          <div style="display:flex;justify-content:center">
          <v-btn
        
          color="blue-grey"
          class="ma-2 white--text "
          @click="ReporteVentas"
        >
          Generar
          <v-icon
            right
            dark
          >
            mdi-animation
          </v-icon>
        </v-btn>
              </div>













            </v-tab-item>   

          





          </v-tabs-items>


              <v-snackbar
                v-model="snackbar"
                        shaped
                    :timeout="timeout"

                color="deep-purple accent-4"
                elevation="24"
              >
              La fecha inicial debe ser menor o igual a la final.

         
              </v-snackbar>
      
             <v-snackbar
                v-model="snackbar2"
                        shaped
                    :timeout="timeout"

                color="deep-purple accent-4"
                elevation="24"
              >
              Las fechas no deben estar vacias.

         
              </v-snackbar>
        </material-card>







</template>
         



         <script>

export default {
    
    data(){

        return{
            mdi_tag:'mdi-tag',
            tabs: 0,
            timeout:3000,
            snackbar:false,
             snackbar2:false,
             snackbar3:false,
             snackbar4:false,
            menu1:false,
            menu2:false,
              menu3:false,
            menu4:false,
            fecha_inicial_v:null,
            fecha_final_v:null,
               fecha_inicial_c:null,
            fecha_final_c:null,
               stats: [
        {
   
          color: '#FD9A13',
          icon: 'mdi-calendar-range',
         
        },
    
      
      ]

        }

    },
    methods:{
 
        ReporteCompras(){

          if(this.fecha_inicial_c>this.fecha_final_c){
              this.snackbar=true;
            return;
          }else if(this.fecha_inicial_c==null||this.fecha_final_c==null){
             this.snackbar2=true;
            return;
          }
       
     
                  window.open(
                "/compra/total/" +
                 this.fecha_inicial_c+
                    "/" +
                    this.fecha_final_c,
                "_blank"
            );
     

              this.fecha_inicial_c=null;
            this.fecha_final_c=null;

        },



          ReporteVentas(){

              console.log('enta para reporte de ventas: '+this.fecha_inicial_v)

          if(this.fecha_inicial_v>this.fecha_final_v){
              this.snackbar=true;
            return;
          }else if(this.fecha_inicial_v==null||this.fecha_final_v==null){
             this.snackbar2=true;
            return;
          }
       
              window.open(
                "/venta/total/" +
                 this.fecha_inicial_v+
                    "/" +
                    this.fecha_final_v,
                "_blank"
            );

              this.fecha_inicial_v=null;
            this.fecha_final_v=null;

        }

    }

}

</script>

<style scoped>


</style>