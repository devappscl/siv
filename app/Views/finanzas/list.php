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

        
        <div>
            <form action="<?php echo base_url('/finanzas/registro'); ?>" method="post" class="form-inline">
            
                <strong>Seleccionar rango de fechas: </strong> &nbsp;

                 <input type="datetime-local" name="datea" id="datea" class="form-control mb-2 mr-sm-2" >

                <input type="datetime-local" name="dateb" id="dateb" class="form-control mb-2 mr-sm-2">
           
               <button class="btn btn-primary mb-2">Buscar</button>
                
            </form>
        </div>
      
        <hr>

   
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
                                            <?php
                                                $ingresos = 0;
                                                $egresos = 0;
                                                $total = 0;
                                            ?>
                                            
                                            <?php  foreach($datos as $dato): ?>

                                                <?php  
                                                        if($dato['tipo']== 'ingreso'){
                                                            $ingresos = $dato['cantidad'] + $ingresos;
                                                        }else{
                                                            $egresos = $dato['cantidad'] + $egresos;
                                                        }
                                                        
                                                        ?>
                                            <tr>
                                              
                                                <td><?php echo $dato['cajera']; ?><br></td>
                                                
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

                                               
                                               
                                            </tr>

                                            <?php endforeach ?>

                                            
                                       
                                        </tbody>
                                    </table>
                                </div>

                                <hr>

                                <h1>INGRESOS <button class="btn btn-success"><h1><?php echo "$". number_format($ingresos,-1); ?></h1></button></h1>  
                                <h1>EGRESOS <button class="btn btn-danger"><h1><?php echo "$". number_format($egresos,-1); ?></h1></button></h1>
                                <?php
                                $total = $ingresos + $egresos;
                                ?>
                                <h1>EGRESOS <button class="btn btn-primary"><h1><?php echo "$". number_format($total,-1); ?></h1></button></h1>                      


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


<script>

$('.inbox').on('click',function(){
    $('.modal-body').load('<?php echo base_url('/finanzas/inbox') ?>',function(){
        $('#myModal').modal({show:true});
        $('#titulo').html("INGRESO DE DINERO");
    });
});

$('.outbox').on('click',function(){
    $('.modal-body').load('<?php echo base_url('finanzas/outbox') ?>',function(){
        $('#myModal').modal({show:true});
        $('#titulo').html("EGRESO DE DINERO");
    });
});

$('.help').on('click',function(){
    $('.modal-body').load('<?php echo base_url('finanzas/help') ?>',function(){
        $('#myModal').modal({show:true});
        $('#titulo').html("<i class='fas fa-question-circle'></i> AYUDA :: FINANZAS");
    });
});


</script>

