

window.Vue = require('vue');
import Vuetify from "./vuetify/index";
import axios from "axios";
import VueAxios from "vue-axios";
 window.axios = require('axios');
 import Chart from 'chart.js';
 window.Chart = Chart;
 window._ = require('lodash');
//... configure axios...

Vue.component('productos', require('./components/Administrador/Productos/Productos.vue').default);
Vue.component('habilitarproductos', require('./components/Administrador/Productos/HabilitarProducto.vue').default);

Vue.component('categorias', require('./components/Administrador/Productos/Categoria.vue').default);
Vue.component('presentacion', require('./components/Administrador/Productos/Presentacion.vue').default);

Vue.component('material-card', require('./components/Administrador/Productos/Material-Card.vue').default);
Vue.component('ventas', require('./components/Administrador/Ventas/Ventas.vue').default);


Vue.component('grafica', require('./components/Administrador/Graficos/Grafica.vue').default);
Vue.component('reporte', require('./components/Administrador/Graficos/Reportes.vue').default);
Vue.component('material-stat-card', require('./components/Administrador/Graficos/MaterialStatsCard.vue').default);


Vue.component('ingresos', require('./components/Administrador/Compras/Ingresos.vue').default);
Vue.component('proveedores', require('./components/Administrador/Compras/Proveedores.vue').default);
Vue.component('habilitarproveedor', require('./components/Administrador/Compras/HabilitarProveedor.vue').default);

Vue.component('clientes', require('./components/Administrador/Ventas/cliente.vue').default);
Vue.component('habilitarcliente', require('./components/Administrador/Ventas/HabilitarCliente.vue').default);


Vue.component('rol', require('./components/Administrador/Usuario/Rol.vue').default);
Vue.component('User', require('./components/Administrador/Usuario/User.vue').default);
Vue.component('habilitaruser', require('./components/Administrador/Usuario/HabilitarUser.vue').default);

/* Vue.component('detalle', require('./components/Administrador/Ventas/ListadoVentas.vue').default);
 */
/* Vue.use(VueAxios, axios); */

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    data:{
        menu: 0,
        ruta: 'http://localhost:8080/ferreteria/public'
    }
});
