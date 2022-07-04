<div id="layoutSidenav_content">
    <main>
      <div class="container-fluid">
      <?php if(session('rol') == '777' OR session('rol') == '7'): ?>
        <h1 class="mt-4"><?php echo $titulo; ?></h1>
        <form class="form" method="post" action="<?php echo base_url('/home/cambiarsucursal/') ?>">
        <div class="form-group">
           <select name="sucursal" class="form-control" onchange="this.form.submit()">
            <?php foreach($locales as $sucursal): ?>
                <option value="<?php echo $sucursal['id']; ?>" <?php  if($sucursal['id'] == session('sucursal')){ echo "selected"; }  ?>><?php echo $sucursal['nombre']; ?></option>   
            <?php endforeach ?> 
            </select>
        </div>
        </form>
      <?php else: ?>
            <h1 class="mt-4"><?php echo $titulo; ?></h1>
      <?php endif ?>
            <p>Bienvenido al panel de control</p>
        
        <!-- SOLO VISIBLE POR ADMINISTRADOR -->           
        <?php if(session('rol') == '777' OR session('rol') == '7'): ?>

        <div class="row">
            
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body" >
                       <strong style="font-size:30px;">Productos</strong> <br><span id="productos">0/0</span>
                    </div>
                   
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                    <strong style="font-size:30px;">Caja </strong><br>$0
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body" >
                    <strong style="font-size:30px;">Ventas</strong> <br>$<span id="ventasdiarias">0</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body" >
                    <strong style="font-size:30px;">Sucursales</strong> <br><span id="sucursales">0</span>
                    </div>
                </div>
            </div>

        </div>

        <?php endif ?>
        <!-- //SOLO VISIBLE POR ADMINISTRADOR --> 


         <!-- SOLO VISIBLE POR ADMINISTRADOR -->           
         <?php if(session('rol') <= '777'): ?>

            <div>

                <div class="row">
                    <div class="col-md-3">
                        <a href="<?php echo base_url('/stock/multidatastock'); ?>" class="btn btn-primary btn-lg btn-block">INGRESAR STOCK FACTURA</a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo base_url('/caja'); ?>" class="btn btn-warning btn-lg btn-block">ACCESO A FLUJO DE CAJA</a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo base_url('/ventas'); ?>" class="btn btn-success btn-lg btn-block">ACCESO A MÓDULO VENTAS</a>
                    </div>
                    
                    <div class="col-md-3">
                        <a href="<?php echo base_url('/proveedores'); ?>" class="btn btn-danger btn-lg btn-block">GENERAR NOTA DE PEDIDO</a>
                    </div>
                </div>
            
            </div>

            <br>

            <div class="row"> 


                            
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Búsqueda de Producto/Precio
                                    </div>
                                    <div class="card-body">
                                        <form action="">
                                            <input type="text" class="form-control" name="codigo" id="codigo" required>
                                            <div>
                                            <h1><center>
                                                <span id="tprecio"></span>
                                               <span id="precio" style="color:red;"></span>
                                                </center>
                                            </h1>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
         </div>

        <?php endif ?>


                                


  <div class="row">

                            <div class="col-xl-12">
                                

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                       N° VENTAS POR HORA
                                    </div>
                                    <div class="card-body">

                                    <canvas id="grafica"></canvas>

                                    
                                    </div>
                                </div>

                               
                            </div>
                            
                        </div>

 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="titulo"></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    <div class="modal-body"> </div>        
            </div>
        </div>
    </div>

      

                    
                </main>
          

    <script type="text/javascript">
    $(function(){
        $("#codigo").autocomplete({
            source: "<?php echo base_url('home/autoproducto') ?>",
            minLength: 3,
            select: function (event,ui){
                event.preventDefault();
                setTimeout(function() {
                    $("#tprecio").fadeIn(10);
                    $("#precio").fadeIn(10);
                },1);
                $("#codigo").val(ui.item.label);
                $('#tprecio').html('Precio Venta: $');
                $('#precio').html(ui.item.value).number(true,0);
                $('#codigo').val("");
                $('#codigo').focus();
                setTimeout(function() {
                    $("#tprecio").fadeOut(1000);
                    $("#precio").fadeOut(1000);
                },4000);  
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo base_url('/home/cargadata') ?>",
            type: "GET",
            dataType: "json",
            success: function(data){

                var total = Math.round(data[0].ventas.suma);

                $("#productos").html(data[0].stock.total + '/' +  data[0].productos);
                $("#ventasdiarias").html(total).number(true);
                $("#sucursales").html(data[0].sucursales);
                
                <?php if(session("rol") <> "777"): ?>
                $('.modal-body').load('<?php echo base_url('/home/popup') ?>',function(){
                    $('#myModal').modal({show:true});
                    $('#titulo').html("INFORMACIÓN FEBRERO");
                });
                <?php endif ?>

               
            }

        });
    });

    
    
</script>

<script>
    
    $(document).ready(function() {
    $.ajax({
        url: "<?php echo base_url('home/grafico') ?>",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var horas = [];
            var total = [];
            var dinero = [];
            console.log(data);

            for (var i in data) {
                horas.push(data[i].horas + 'hrs');
                total.push(data[i].total * 1000);
                dinero.push(data[i].dinero);
            }

            

            const ventadinero = {
                label: "Ventas por Hora",
                // Pasar los datos igualmente desde PHP
                data: dinero, // <- Aquí estamos pasando el valor traído usando AJAX
                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Color de fondo                
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 4, // Ancho del borde
                fill: true,
            };

            const ventacantidad = {
                label: "Cantidad de Ventas",
                // Pasar los datos igualmente desde PHP
                data: total, // <- Aquí estamos pasando el valor traído usando AJAX
                backgroundColor: 'rgba(255, 0, 0, 0.5)', // Color de fondo
                borderColor: 'rgba(255, 0, 0, 1)', // Color del borde
                borderWidth: 4, // Ancho del borde
                fill: true,
            };

            

            var chartdata = {
                labels: horas,
                datasets: [
               
                ventacantidad,
                ventadinero,
                // Aquí más datos...
                ]
                
                
            };

            var mostrar = $("#grafica");

            var grafico = new Chart(mostrar, {
                type: 'line',
                data: chartdata,
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});


</script>
