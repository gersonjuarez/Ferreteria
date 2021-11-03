<template>
<v-app style="width:100%;heigth:100%" >


    <main class="main">
        

      <v-container
        id="dashboard-view"
        fluid
        tag="section"
      >
    <v-row>
      <v-col cols="12">
        <v-row>
          <v-col
          
            cols="12"
            md="6"
            lg="4"
          >
          <!-- GRAFICA MAQUETACION -->
              <material-card
                  v-bind="$attrs"
                  full-header
                class="v-card--material-chart"

                >

                <template #heading >
                  <div class="pa-4"  >
                
                <canvas id='primero' ></canvas>

                  </div>
                </template>


                <template >
            
                  <h5 style="text-align:center" >Productos más vendidos mes de {{mes_actual}}</h5>

          
                </template>

          

                <template #actions>
                    <h6 style="text-align:center">Gráfica de los 5 productos más vendidos por Factura.  </h6>
                </template>
              </material-card>
            
              
     
            
          </v-col>
             <v-col
          
            cols="12"
            md="6"
            lg="4"
          >


          <!-- GRAFICA MAQUETACION -->
     
              <material-card
              v-bind="$attrs"
              class="v-card--material-chart"
              full-header
              
            >

              <template #heading >
                <div class="pa-4" >
              
                    <canvas id='segundo'></canvas>

                      </div>
                    </template>


                    <template >
                     <h5 style="text-align:center">Total de Ventas realizadas por mes</h5>
                    </template>

                    <template #actions>
                      <h6>Gráfica del total de ventas por mes.</h6>
                    </template>
                  </material-card>

    
            
          </v-col>
             <v-col
          
            cols="12"
            md="6"
            lg="4"
          >
          <!-- GRAFICA MAQUETACION -->
    
              <material-card
                  v-bind="$attrs"
                  class="v-card--material-chart"
                  full-header
                  
                >

                  <template #heading >
                    <div class="pa-4" >
                  
                  <canvas id='tercero'></canvas>

                    </div>
                  </template>


                  <template >
              <h5 style="text-align:center">Total de Compras realizadas por mes</h5>

                  </template>

               

                  <template #actions>
                      <h6>Gráfica del total de compras por mes.</h6>

                  </template>
                </material-card>


              

            
          </v-col>
        </v-row>
      </v-col>
    </v-row>


          <div
          style="margin-top:5em"
          >
              <reporte></reporte>

          </div>


    
  </v-container>

  
     

    </main>









   </v-app>
</template>


<script>

export default {
    
    data(){

        return{


            menu1:false,
            fecha_inicial:null,
            fecha_final:null,

            varproductos:null,
            charproductos:null,
            varproductos2:null,
            charproductos2:null,
            varproductos3:null,
            charproductos3:null,

            top_productos:[],
            nombre_productos:[],
            total_productos:[],

            ventas:[],
            ingresos:[],

            mes:[],
            total:[],
            mes_actual:null,
            array_meses:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
             
            mes_ingresos:[],
            total_ingresos:[],
        }

    },
    computed:{
      
 

      

    },
  methods:{

    obtenerproductos(){


      let me = this;
      
      var url = "/grafica";
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
       
            me.top_productos=respuesta.venta2;
            me.Listado();
        /*   me.productos2 = respuesta.venta2;

          me.loadProductos2(); */
        })

        .catch(function (error) {
          console.log(error);
        });
    
    },
    obtenerVentas(){
              let me=this;
                var url='/grafica/ventas';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                    me.Listado2();
                })
                .catch(function (error) {
                    console.log(error);
                });

    },  obtenerIngresos(){
              let me=this;
                var url='/grafica/ventas';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ingresos = respuesta.ingresos;
                                        console.log('INFO: '+JSON.stringify(respuesta.ingresos))

                    //cargamos los datos del chart
                    me.Listado3();
                })
                .catch(function (error) {
                    console.log(error);
                });

    },

     Listado(){
     
       let me=this;
    
  

      me.top_productos.map(function (x) {
        me.nombre_productos.push(x.nombre);
        me.total_productos.push(x.veces);
      });

      Chart.scaleService.updateScaleDefaults('category', {
  ticks: {
    callback: function(tick) {
      var characterLimit = 10;
      if ( tick.length >= characterLimit) {
        return tick.slice(0, tick.length).substring(0, characterLimit -1).trim() + '...';;
      }
      return tick;
    }
  }
});

      me.varproductos = document.getElementById('primero');

        me.charproductos = new Chart(me.varproductos, {
        type: "bar",
        data: {
          labels:me.nombre_productos,
          datasets: [
            {
              label:'Productos mas vendidos',
              data:me.total_productos,
                 
               backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
     hoverBackgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    hoverBorderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
                borderWidth: 3
            },
          ],
        },
       
        options: {
      
         responsive: true,
         
    scales: {
     xAxes: [{
  
                beginAtZero:true,
        /*         ticks:{
                  callback: function(label) {
          if (/\s/.test(label)) {
            return label.split(" ");
          }else{
            return label;
          }              
        }
                } */

            }],
            yAxes: [{
                                
                ticks:{
                maxTicksLimit:6,
                beginAtZero:true,
                
                }                
             
            }]
    },
     tooltips: {
         callbacks: {
          title:  function(tooltipItems, data) {
             return data.labels[tooltipItems[0].index]
          }
        }
      }

        },

      });


      this.updatechart(me.charproductos);

       
     },

    updatechart(chart){

    var canvasheight=document.getElementById("primero").width;
            if(canvasheight>=500 || canvasheight>=400 && canvasheight<=410 )
            {
           chart.options.scales.xAxes[0].display=false;

        
            }else{

           chart.options.scales.xAxes[0].display=true;

            }

          chart.update();


     },
          Listado2(){
     
       let me=this;

      let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; 
                me.ventas.map(function(x){
                    me.mes.push(meses[x.mes-1]);
                    me.total.push(x.total);
                });


      me.varproductos2 = document.getElementById('segundo');
         
          me.charproductos2 = new Chart(me.varproductos2, {
        type: "bar",
        data: {
          labels: me.mes,
          datasets: [
            {
              label: "Ventas",
              data: me.total,
               backgroundColor: [
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',      
      'rgba(201, 203, 207, 0.2)',
       'rgba(153, 102, 255, 0.2)',
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',      
      'rgba(201, 203, 207, 0.2)',
    ],
    borderColor: [
      'rgb(153, 102, 255)',
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(201, 203, 207)',
        'rgb(153, 102, 255)',
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(201, 203, 207)',
    ],
    
                borderWidth: 3
            },
          ],
        },
        options: {
  
            tooltips: {
         callbacks : {
            label: function(t, d) {
               var xLabel = d.datasets[t.datasetIndex].label;
               var yLabel = t.yLabel >= 1000 ? 'Q' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Q' + t.yLabel;
               return xLabel + ': ' + yLabel;
            }
         }
      },
          scales: {

               xAxes: [{
  
                beginAtZero:true,
             
            }],
      yAxes: [{
      

        ticks: {
                beginAtZero:true,                      
             maxTicksLimit:6,
           callback: function(value, index, values) {
                           if (parseInt(value) >= 1000) {
                     return 'Q' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  } else {
                     return 'Q' + value;
                  }
                    }
       
        },
    
      }],
     
      
    },


        },
      });



       
     },
           Listado3(){
     
       let me=this;

      let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; 
                me.ingresos.map(function(x){
                    me. mes_ingresos.push(meses[x.mes-1]);
                    me.total_ingresos.push(x.total);
                });


      me.varproductos2 = document.getElementById('tercero');
              const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
              });
          me.charproductos2 = new Chart(me.varproductos2, {
        type: "bar",
        data: {
          labels: me.mes_ingresos,
          datasets: [
            {
              label: "Compras",
              data: me.total_ingresos,
               backgroundColor: [
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)',
       'rgba(54, 162, 235, 0.2)',
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)',
    ],
    borderColor: [
      'rgb(54, 162, 235)',
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)',
         'rgb(54, 162, 235)',
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)',
    ],
                borderWidth: 3
            },
          ],
        },
        options: {
  
         tooltips: {
         callbacks : {
            label: function(t, d) {
               var xLabel = d.datasets[t.datasetIndex].label;
               var yLabel = t.yLabel >= 1000 ? 'Q' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Q' + t.yLabel;
               return xLabel + ': ' + yLabel;
            }
         }
      },
          scales: {
      yAxes: [{
               
         ticks: {
                                     
      beginAtZero:true,                      
             maxTicksLimit:6,
           callback: function(value, index, values) {
                           if (parseInt(value) >= 1000) {
                     return 'Q' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  } else {
                     return 'Q' + value;
                  }
                    }
       
        },
    
      }],
    
      
    },
    
    responsive: true,
        },
      });



       
     }



   },
   mounted() {


     
  

    this.obtenerproductos();
    this.obtenerVentas();
    this.obtenerIngresos();
    const fecha=new Date();
     const valor=fecha.getMonth();
     this.mes_actual=this.array_meses[valor] ; 
  }





}
</script>


<style scoped>
.minimo{
    min-width:300px;
}
</style>