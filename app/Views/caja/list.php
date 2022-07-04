<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <!-- INGRESO -->
        <button type="button" class="btn btn-success btn-sm inbox">Ingreso de Caja</button>
        <!-- EGRESO -->
        <button type="button" class="btn btn-danger btn-sm outbox">Egreso de caja</button>
        <!-- REGLAMENTO -->
        <button type="button" class="btn btn-warning btn-sm help float-right"><i class="fas fa-question-circle"></i></button>
        <hr>

        <?php if(session('rol') == '777'): ?>
        <div>
            <form action="<?php echo base_url('/caja/registro'); ?>" method="post" class="form-inline">
            
                <strong>Seleccionar rango de fechas: </strong> &nbsp;

                 <input type="datetime-local" name="datea" id="datea" class="form-control mb-2 mr-sm-2" >

                <input type="datetime-local" name="dateb" id="dateb" class="form-control mb-2 mr-sm-2">
           
               <button class="btn btn-primary mb-2">Buscar</button>
                
            </form>
        </div>
      
        <hr>
        <?php endif ?>

    <?php

        $ingresos = 0;
        $egresos = 0;
        $total = 0;

    ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                               
                                                <th>VENDEDOR(A)</th>
                                                <th>CANTIDAD</th>
                                                <th>COMENTARIO</th>
                                                
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                            <?php  foreach($datos as $dato): ?>
                                            <tr>
                                              
                                                <td><?php echo $dato['cajera']; ?><br><small><?php echo $dato['turno']; ?></small></td>
                                                
                                                <td>
                                                <h4>
                                                    <?php if($dato['tipo']== 'egreso'): ?>
                                                        <span class="badge badge-danger badge"><?php echo "$" .number_format($dato['cantidad']); ?></span>
                                                        
                                                    <?php else: ?>
                                                        <span class="badge badge-success"><?php echo "$" .number_format($dato['cantidad']); ?></span>
                                                        
                                                    <?php endif ; ?>
                                                </h4>
                                                
                                                </td>
                                                <td>
                                                    <small><?php echo $dato['created_at']; ?></small>
                                                    <br>
                                                    <?php if($dato['tipodetalle']== 4): ?>
                                                       
                                                        <img src="https://iconape.com/wp-content/files/fs/209126/svg/209126.svg"  class="img-fluid" width="100" height="20">
                                                        <br>
                                                    <?php endif ; ?>
                                                    <?php echo $dato['comentario']; ?>
                                                       
                                                </td>

                                                <?php 

                                                    if($dato['tipo'] == 'ingreso'){
                                                        $ingresos = $ingresos + $dato['cantidad'];
                                                    }else{
                                                        $egresos = $egresos + $dato['cantidad'];
                                                    }

                                                ?>
                                               
                                            </tr>

                                            <?php endforeach ?>

                                            <?php $total = ($ingresos + $egresos); ?>
                                       
                                        </tbody>
                                    </table>
                                </div>
                      


    </div>

    <?php if(session('rol') == '777'): ?>
    <div class="container-fluid">

    <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                      INGRESOS DIARIOS
                                    </div>
                                    <div class="card-body">
                                    INGRESO PAGO PEDIDOS <h1><?php echo  "$". number_format($cajachicad['suma']); ?></h1>
                                    INGRESO VENTAS EFECTIVO <h1><?php echo  "$". number_format($cajaventasd['suma']); ?></h1>
                                    INGRESO VENTAS TARJETAS <h1><?php echo  "$". number_format($cajaredcomprad['suma']); ?></h1><hr>
                                    
                                   TOTAL INGRESOS <h1><?php echo "$". number_format($cajaventasd['suma'] + $cajaredcomprad['suma']) ?></h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                      EGRESOS DIARIOS
                                    </div>
                                    <div class="card-body">
                                     PAGO PROVEEDORES <h1><?php echo "$". number_format($pagoproveedord['suma']); ?></h1>
                                    PAGO COLABORADORES <h1><?php echo "$". number_format($pagopersonald['suma']); ?></h1>
                                    PAGO TRANSFERENCIA <h1><?php echo "$". number_format($pagotransferenciad['suma']); ?></h1><hr>
                                    TOTAL EGRESOS <h1><?php echo "$". number_format($pagoproveedord['suma'] + $pagopersonald['suma'] + $pagotransferenciad['suma'] ); ?></h1>
                                   
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                      BALANCE DIARIO
                                    </div>
                                    <div class="card-body">
                                    TOTAL EFECTIVO <h1><?php echo "$". number_format($cajachicad['suma'] + $cajaventasd['suma'] + $pagopersonald['suma'] + $pagoproveedord['suma']); ?></h1>
                                    TOTAL GENERAL <h1><?php echo "$". number_format($cajachicad['suma'] + $cajaventasd['suma'] + $cajaredcomprad['suma'] + $pagopersonald['suma'] + $pagoproveedord['suma'] + $pagotransferenciad['suma']); ?></h1>
                                    
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                       INGRESOS MENSUALES
                                    </div>
                                    <div class="card-body">
                                    INGRESO PAGO PEDIDOS<h1><?php echo  "$". number_format($cajachica['suma']); ?></h1>
                                    INGRESO VENTAS EFECTIVO <h1><?php echo  "$". number_format($cajaventas['suma']); ?></h1>
                                    INGRESO VENTAS TARJETAS <h1><?php echo  "$". number_format($cajaredcompra['suma']); ?></h1><hr>
                                    TOTAL INGRESOS <h1><?php echo "$". number_format($cajaventas['suma'] + $cajaredcompra['suma']); ?></h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                       EGRESOS MENSUALES
                                    </div>
                                    <div class="card-body">
                                    PAGO PROVEEDORES <h1><?php echo "$". number_format($pagoproveedor['suma']); ?></h1>
                                    PAGO TRANSFERENCIA <h1><?php echo "$". number_format($pagotransferencia['suma']); ?></h1><hr>
                                    TOTAL EGRESOS <h1><?php echo "$". number_format($pagoproveedor['suma'] + $pagotransferencia['suma'] ); ?></h1>
                                    
                                
                                    PAGO COLABORADORES <h1><?php echo "$". number_format($pagopersonal['suma']); ?></h1></div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                      BALANCE MENSUAL
                                    </div>
                                    <div class="card-body">
                                    TOTAL EFECTIVO <h1><?php echo "$". number_format($cajachica['suma'] + $cajaventas['suma'] + $pagopersonal['suma'] + $pagoproveedor['suma']); ?></h1>
                                    TOTAL GENERAL <h1><?php echo "$". number_format($cajaventas['suma'] + $cajaredcompra['suma'] + $pagopersonal['suma'] + $pagoproveedor['suma'] + $pagotransferencia['suma']); ?></h1>
                                    
                                    </div>
                                </div>
                            </div>
         </div>


    
    <?php endif ?>
 


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


<script>

$('.inbox').on('click',function(){
    $('.modal-body').load('<?php echo base_url('/caja/inbox') ?>',function(){
        $('#myModal').modal({show:true});
        $('#titulo').html("INGRESO DE CAJA");
    });
});

$('.outbox').on('click',function(){
    $('.modal-body').load('<?php echo base_url('caja/outbox') ?>',function(){
        $('#myModal').modal({show:true});
        $('#titulo').html("EGRESO DE CAJA");
    });
});

$('.help').on('click',function(){
    $('.modal-body').load('<?php echo base_url('caja/help') ?>',function(){
        $('#myModal').modal({show:true});
        $('#titulo').html("<i class='fas fa-question-circle'></i> AYUDA :: FLUJO DE CAJA");
    });
});


</script>

