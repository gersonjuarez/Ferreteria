
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style>
    /* reset */
    * {
      border: 0;
      box-sizing: content-box;
      color: inherit;
      font-family: inherit;
      font-size: inherit;
      font-style: inherit;
      font-weight: inherit;
      line-height: inherit;
      list-style: none;
      margin: 0;
      padding: 0;
      text-decoration: none;
      vertical-align: top;
    }

   
    /* heading */
    h1 {
      font: bold 100% sans-serif;
      letter-spacing: 0.5em;
      text-align: center;
      text-transform: uppercase;
    }

    /* table */
    table {
      font-size: 75%;
      table-layout: fixed;
            width: 100%;
      max-width: 100%;

    }

    table {
      border-collapse: separate;
      border-spacing: 2px;
    }

    th,
    td {
      border-width: 1px;
      padding: 0.5em;
      position: relative;
      text-align: left;
    }

    th,
    td {
      border-radius: 0.25em;
      border-style: solid;
    }

    th {
      background: #EEE;
      border-color: #BBB;
    }

    td {
      border-color: #DDD;
      word-wrap:break-word;

    }

    /* page */
   
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.93rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
      margin: 0;
      padding: 0.5in;
      width:100%;
    }

    body {
      background: #FFF;
      border-radius: 1px;
      box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    }

    /* header */
   /*  header {
      margin: 0 0 3em;
    } */

    header:after {
      clear: both;
      content: "";
      display: table;
    }

    header h1 {
      background: #000;
      border-radius: 0.25em;
      color: #FFF;
      margin: 0 0 1em;
      padding: 0.5em 0;
    }

    header address {
      float: left;
      font-size: 75%;
      font-style: normal;
      line-height: 1.25;
      margin: 0 1em 1em 0;
    }

    header address p {
      margin: 0 0 0.25em;
    }

    header span,
    header img {
      display: block;
      float: right;
    }

    header span {
      margin: 0 0 1em 1em;
      max-height: 25%;
      max-width: 60%;
      position: relative;
    }

    header img {
      max-height: 100%;
      max-width: 100%;
    }

    header input {
      cursor: pointer;
      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
      height: 100%;
      left: 0;
      opacity: 0;
      position: absolute;
      top: 0;
      width: 100%;
    }

    /* article */
    article,
    article address,
    table.meta,
    table.inventory {
      margin: 0 0 3em;
    }

    article:after {
      clear: both;
      content: "";
      display: table;
    }

    article h1 {
      clip: rect(0 0 0 0);
      position: absolute;
    }

    article address {
      float: left;
      font-size: 125%;
      font-weight: bold;
    }

    table.meta,
    table.balance {
      float: right;
      width: 36%;
    }

    table.meta:after,
    table.balance:after {
      clear: both;
      content: "";
      display: table;
    }

    table.meta th {
      width: 40%;
    }

    table.meta td {
      width: 60%;
    }

    /* table items */
    table.inventory {
      clear: both;
      width: 100%;
    }

    table.inventory th {
      font-weight: bold;
      text-align: center;
    }

    table.inventory td:nth-child(1) {
      width: 13%;
      text-align: center;
    }

    table.inventory td:nth-child(2) {
      width: 30%;
      text-align: center;
    }

    table.inventory td:nth-child(3) {
      text-align: center;      width: 20%;
      
    }

    table.inventory td:nth-child(4) {
      text-align: center;      width: 13%;
    }

    table.inventory td:nth-child(5) {
      text-align: center;      width: 9%;
    }
    table.inventory td:nth-child(6) {
      text-align: center;      width: 15%;
    }

    /* table balance */
    table.balance th,
    table.balance td {
      width: 50%;
    }

    table.balance td {
      text-align: right;
    }

    /* aside */
    aside h1 {
      border: none;
      border-width: 0 0 1px;
      margin: 0 0 1em;
    }

    aside h1 {
      border-color: #999;
      border-bottom-style: solid;
    }


    @page {
      margin: 0;
    }
  </style>
</head>

<body>
    <div style="width:100%">
    <header>
    <h1>Listado de productos</h1>
  </header>
    </div>

  <article>

    <table class="meta">
      <tr>
        <th><span>Fecha:</span></th>
        <td><span>{{now()}}</span></td>
      </tr>
 
    </table>
    <table class="inventory">
    <thead>
                <tr>
                    <th><span>Código</span></th>
                    <th><span>Nombre</span></th>
                    <th><span>Categoría</span></th>
                    <th><span>Precio Venta</span></th>
                    <th><span>Stock</span></th>
                    <th><span>Estado</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $a)
                <tr>
                    <td><span>{{$a->codigo}}</span></td>
                    <td><span>{{$a->nombre}}</span></td>
                    <td><span>{{$a->nombre_categoria}}</span></td>
                    <td><span>Q</span><span>{{$a->precio_venta}}</span></td>
                    <td><span>{{$a->stock}}</span></td>
                    <td><span>{{$a->estado?'Activo':'Desactivado'}}</span></td>
                </tr>
                @endforeach                                
            </tbody>
    </table>
    <table class="balance">
      <tr>
        <th><span>Total</span></th>
        <td><span>{{$cont}} productos</span></td>
      </tr>
    
    </table>
  </article>

</body>

</html>