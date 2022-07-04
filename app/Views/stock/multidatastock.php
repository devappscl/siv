<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h1 class="mt-4">Ingreso Stock desde Factura</h1>
        
        <?php if(session()->getFlashdata('msg')): ?>
            
            <div class="alert alert-danger" role="alert" id="msg">
                <?php echo session()->getFlashdata('msg') ?>
            </div>

        <?php endif ?>

        <hr>

        <div class="row">

        <div class="col-md-12">

        <form method="post" action="<?php echo base_url('stock/addline'); ?>" id="linea">
            
                    <div class="form-group">
                    <div class="input-group ">
                    <input type="hidden" name="id_producto">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><span class="fas fa-fw fa-barcode"></span></div>
                    </div>
                    <input type="text" class="form-control form-control-lg ui-widget" id="codigo" name="codigo" value="" placeholder="Ingrese el código" onkeyup="" autofocus required>   
                        
                    </div>
                    </div>

                    
        </form>

            <table id="mytable"  class="table table-hover">
                <thead>
                    <tr>
                   <!-- <th scope="col">CODIGO</th> -->
                    <th scope="col">PRODUCTO</th>
                    <th scope="col">CANTIDAD</th>
                    <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
              
                <?php if(!empty($datos)): ?>
                <?php  foreach($datos as $dato): ?>

                   
                    <tr>
                    <!--<th scope="row"><?php echo $dato['codigo']; ?></th> -->
                    <th scope="row"><h4><?php echo $dato['nombre']; ?></h4>
                    <span class="badge badge-primary">cod:<?php echo $dato['codigo']; ?></span>
                    </th>
                    
                    <td><h4><?php echo number_format($dato['cantidadcarro'],'2'); ?></h4></td>

                    <td>

                    <div class="btn-group">
                       <a href="<?php echo base_url('/stock/multidatastockdelete/'.$dato['producto_id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                    
                    </td>
                    </tr>

                <?php endforeach ?>
                
                <?php else: ?>
                    <tr>
                     <td colspan="4">NO HAY PRODUCTOS</td>
                     
                    </tr>
                    <?php endif; ?>
    
                </tbody>
                <tfoot>
                <tr>
                <?php if(!empty($datos)): ?>
                <td colspan="3"><a href="<?php echo base_url('stock/actualizastock') ?>" class="btn btn-primary float-right"> Actualizar</a></td>
                <?php endif; ?>    
            </tr>
            </tfoot>
             </table>
            </div>

        </div>
        

    </div>
   </main>

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





