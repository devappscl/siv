<div id="layoutSidenav_content">
        <main>
        <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-12 bg-dark text-center">
                <h1 class="text-light" style="font-size: 3vw;"><?php echo NombreSucursal(session('sucursal')); ?></h1>
            </div>
        </div>
        
        <!--
        Caja: <a href="<?php echo base_url('ventas/original') ?>" class="btn btn-primary btn-sm"><?php echo session('rut'); ?></a> <?php if(session('btntemporal')): ?><a href="<?php echo base_url('ventas/temporal') ?>" class="btn btn-danger btn-sm">Temporal</a><?php endif; ?>
        <a href="<?php echo base_url('ventas/statsvendor') ?>" title="Estadísticas de venta"><strong><i class="fas fa-chart-line"></i></strong></a>
        
        
        <a href="" data-toggle="modal" data-target="#exampleModal" title="Cierre Caja Ventas">
        <strong><i class="fas fa-cash-register"></i></strong>
        </a>
        
        -->
        
        <?php if(session()->getFlashdata('msg')): ?>
            
            <div class="alert alert-danger" role="alert" id="msg">
                <?php echo session()->getFlashdata('msg') ?>
            </div>

        <?php endif ?>

        

<div class="row mt-2 mb-2">

    


  <div class="col-md-9">
    <div class="row">
    <div class="col-md-12 text-right mb-1">
                    <a href="<?php echo base_url('ventas/original') ?>" class="btn btn-primary btn-sm" title="Vendedor(a)"><i class="fas fa-user"></i> <?php echo session('rut'); ?></a> 
                    <?php if(session('btntemporal')): ?>
                    <a href="<?php echo base_url('ventas/temporal') ?>" class="btn btn-danger btn-sm" title="Usuario Temporal Ventas"><i class="fas fa-user-astronaut"></i> Temporal</a>
                    <?php endif; ?>
                    <a href="" data-toggle="modal" data-target="#exampleModal" title="Cierre Caja Ventas" class="btn btn-warning btn-sm">
        <i class="fas fa-cash-register"></i> Arqueo Caja</a>
        
    </div>
    </div>
  
   <!--<form method="post" action="<?php echo base_url('ventas/addline'); ?>" id="linea"> -->
            
    <div class="form-group">
        <div class="input-group ">   
            <div class="input-group-prepend">
                <div class="input-group-text"><span class="fas fa-fw fa-barcode"></span></div>
            </div>
            
            <input type="hidden" name="id_producto">
            <input type="text" class="form-control form-control-lg ui-widget" id="codigo" name="codigo" value="" placeholder="Ingrese el código" onkeyup="" autofocus required>   
        </div>

    </div>
              
    <!-- </form> -->

    <table id="datatable"  class="table table-hover bg-light">
        <thead>
          <tr>
             <th scope="col">PRODUCTO</th>
             <th scope="col">CANTIDAD</th>
             <th scope="col">SUBTOTAL</th>
          </tr>
        </thead>
        
        <tbody>
            <?php 
                $total = 0;
                $user_id = "";
                $nl = 1;
            ?>
                <?php $botoneliminar = false; ?>

                <?php if(!empty($datos)): ?>
                <?php  foreach($datos as $dato): ?>

                   
                    <tr>
                    <!--<th scope="row"><?php echo $dato['codigo']; ?></th> -->
                    <th scope="row"><h4><?php echo $dato['nombre']; ?></h4>
                    <span class="badge badge-primary">cod:<?php echo $dato['codigo']; ?></span>
                    </th>
                    
                    <td>
                    <!--<input type="hidden" value="<?php echo $dato['id'] ?>" id="id">
                   <input type="number" id="cantidad" style="font-size: 3vw;" class="form-control control-lg" value="<?php echo  number_format($dato['cantidadcarro'],3); ?>" name="cantidad" step="0.1">
                       
                --><h1>
                    <div class="row d-flex align-items-center">
                    <div class="col-md-5"><form method="post" action="<?php echo base_url('ventas/actualizarcantidad') ?>"><input type="hidden" name="id" value="<?php echo $dato['id'] ?>"><input type="number" id="actualizarcantidad" class="form-control form-control-lg" name="cantidad" value="<?php echo round($dato['cantidadcarro'],2); ?>" onchange="this.form.submit()"></form></div>
                    <div class="col-md-2"> x </div>
                    <div class="col-md-5"> <span class="badge badge-success"><?php echo "$" . number_format($dato['pventa']); ?></span></div>
                    </div>
                   
                   
                    
               
                    </h1>
                   
                </td>
                    <td>
                    
                    <h1>
                        <?php 
                            $subtotal = $dato['cantidadcarro'] * $dato['pventa'];
                            echo "$" . round($subtotal,-1); 
                        ?>
                    </h1>
                    <a href="<?php echo base_url('/ventas/delete/'.$dato['producto_id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>

                    
                    </td>
                    </tr>
                    <?php
                     $varpaso = $dato['cantidadcarro'] * $dato['pventa'];
                     $total = $total + $varpaso;  
                     $user_id = $dato['user_id'];
                     ?>

                  

                     <?php 
                     $nl = $nl + 1;
                     $botoneliminar = true;
                      ?>
                <?php endforeach ?>
                <?php else: ?>
                    <tr>
                     <td colspan="4">NO HAY PRODUCTOS</td>
                     <?php $botoneliminar = false; ?>
                    </tr>
                    <?php endif; ?>
    
                </tbody>


        
             </table>
            </div>

            <div class="col-md-3" style="background-color: #85CE36;padding:20px;">
               
                <h3 class="">TOTAL</h3>
                <?php
                   
                     $total = round($total,-1); 
                ?>
                <h1 style="background-color: #FFF;font-size: 45px;" class="p-2 text-center"><?php echo "$" . number_format($total); ?></h1>
                <hr>
                <h5>Total Neto</h5>
                <h4>
                    <?php  

                        $neto = 0;
                        $neto = $total - ((19*$total) / 100);
                        echo "$" . number_format($neto);
                    
                    ?>
                </h4>
                <h5>Impuestos (19%)</h5>
                <h4>
                <?php  

                        $iva = 0;
                        $iva = $total - $neto;
                        echo "$" . number_format($iva);
                    
                    ?>
                </h4>
               
                <?php if($botoneliminar):?>
              
                   
                <a href="<?php echo base_url('ventas/prepago') ?>" class="btn btn-primary btn-lg">PAGAR</a>

                <a href="<?php echo base_url('ventas/deleteticket/'.$user_id); ?>" class="btn btn-danger btn-lg">LIMPIAR</a>
                <?php endif ?>

                
            </div>
        
        </div>
        

    </div>
   </main>


   <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cierre Caja Ventas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$20.000</legend></div>
                        <div class="col-md-6"><input type="number" id="20mil" class="form-control" onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$10.000</legend></div>
                        <div class="col-md-6"><input type="number" id="10mil" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$5.000</legend></div>
                        <div class="col-md-6"><input type="number" id="5mil" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$2.000</legend></div>
                        <div class="col-md-6"><input type="number" id="2mil" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$1.000</legend></div>
                        <div class="col-md-6"><input type="number" id="1mil" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$500</legend></div>
                        <div class="col-md-6"><input type="number" id="quinientos" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$100</legend></div>
                        <div class="col-md-6"><input type="number" id="cien" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$50</legend></div>
                        <div class="col-md-6"><input type="number" id="cincuenta" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>$10</legend></div>
                        <div class="col-md-6"><input type="number" id="diez" class="form-control"  onchange="SumarCaja();"></div>
                    </div>
                </fieldset>
                <form action="<?php echo base_url('/caja/store'); ?>" method="post">
                
                <!-- ENVIA TURNO -->
                <?php if(date("G" >= 15)): ?>
                    <input type="hidden" name="turno" value="Mañana">
                <?php elseif(date("G" < 15)): ?>
                    <input type="hidden" name="turno" value="Tarde">
                <?php endif ?>

                <!-- ENVIA TIPO DETALLE -->
                <input type="hidden" name="tipodetalle" value="3">

                <!-- ENVIA TIPO -->
                <input type="hidden" name="tipo" value="ingreso">

                 <!-- ENVIA TIPO -->
                 <input type="hidden" name="comentario" value="Ingreso Caja de Ventas <?php echo date('d-m-Y') ?>">

                <!-- ENVIA EFECTIVO -->
                <fieldset>
                    <div class="row">
                        <div class="col-md-6"><legend>TOTAL EFECTIVO</legend></div>
                        <div class="col-md-6"><input type="textbox" name="cantidad" id="totalefectivo" class="form-control control-lg cantidad" readonly></div>
                    </div>
                </fieldset>
                
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
            
         </form>
        </div>
        </div>
    </div>
    </div>


    <script>

    $(document).ready(function(){  
   
      $("#codigo").keypress(function(e) {
        if(e.which == 13 && $("#codigo").val() != "") {
         agregarlinea();
        }
      });

      $('#actualizarcantidad').on('change', function(){
        actualizarcantidad();
      })
      
    });


    //AJAX AGREGAR REGISTRO
  function agregarlinea() {
    var codigo = $("#codigo").val();
    $.ajax({
            type: 'POST',
            url: '<?php echo base_url("ventas/addline") ?>',
            data: "codigo=" + codigo,
            success: function(msg) {
                location.reload();
            },
            error: function() {
              alert("Hay un problema");
            }
    });
  }

  function cargaproductos(){
    $.ajax({
            type: 'POST',
            url: '<?php echo base_url("ventas/cargaproductos") ?>',
            data: "",
            success: function(msg) {
                
            },
            error: function() {
              alert("Hay un problema");
            }
    });

    function actualizarcantidad() {
    var id = $("#actualizarcantidad").val();
    var codigo = $("#actualizarcantidad").val();
    $.ajax({
            type: 'POST',
            url: '<?php echo base_url("ventas/actualizarcantidad") ?>',
            data: "id=" + id,
            success: function(msg) {
                location.reload();
            },
            error: function() {
              alert("Hay un problema");
            }
    });
  }

  }

 

    </script>



   <script type="text/javascript">
    $(function(){
        $("#codigo").autocomplete({
            source: "<?php echo base_url('ventas/autoproducto') ?>",
            minLength: 3,
            select: function (event,ui){
                event.preventDefault();
                $("#codigo").val(ui.item.value);
            }
        });

    });

</script>

<script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                $("#msg").fadeOut(1000);
            },4000);  
        });
</script>

<script type="text/javascript">
        
        function SumarCaja()
            {

            var veintemil = document.getElementById("20mil").value * 20000;
            var diezmil = document.getElementById("10mil").value * 10000;
            var cincomil = document.getElementById("5mil").value * 5000;
            var dosmil = document.getElementById("2mil").value * 2000;
            var mil = document.getElementById("1mil").value * 1000;
            var quinientos = document.getElementById("quinientos").value * 500;
            var cien = document.getElementById("cien").value * 100;
            var cincuenta = document.getElementById("cincuenta").value * 50;
            var diez = document.getElementById("diez").value * 10;
            var total = veintemil + diezmil + cincomil + dosmil + mil + quinientos + cien + cincuenta + diez;

            total = total.toLocaleString('es-CL');

                document.getElementById("totalefectivo").value = total;

            }

            

</script>

<script>
  
</script>





