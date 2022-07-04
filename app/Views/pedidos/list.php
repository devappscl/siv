<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <!-- INGRESO -->
        <button type="button" class="btn btn-success btn-sm inbox">Ingresar Pedido</button>
        <hr>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                               
                                                <th>ID</th>
                                                <th>PEDIDO</th>
                                                <th>COMENTARIO</th>
                                                
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                           
                                        </tbody>
                                    </table>
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


</script>

