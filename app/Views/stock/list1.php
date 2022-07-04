<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4">ACTUALIZAR CODIGO DE PRODUCTOS</h3>
        <br>
      
       
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>CODIGO</th>
                                                <th>NOMBRE</th>
                                                <th>CANTIDAD</th>
                                                <th>ACCIONES</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                            <?php  foreach($datos as $dato): ?>
                                            <tr>
                                                <td><?php echo $dato['codigo']; ?></td>
                                                <td><?php echo $dato['nombre']; ?></td>
                                                <td>
                                                    <h4><?php echo $dato['cantidad']; ?></h4>
                                                    <strong> Acumulado:</strong> <span class="badge badge-success"><?php echo "$". number_format($dato['pventa'] * $dato['cantidad']); ?></span>
                                            
                                            </td>
                                               
                                                <td >
                                                <div class="btn-group">
                                                <a href="<?php echo base_url('/stock/edit/' .$dato['idstock'])  ;  ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <?php if(session('sucursal') <> $dato['sucursal']): ?>
                                                    <a href="<?php echo base_url('/stock/sync/' .$dato['producto'])  ;  ?>" class="btn btn-success btn-sm"><i class="fas fa-sync-alt"></i></a>
                                                    <?php endif ?>
                                                </div>
                                                
                                                </td> 
                                            </tr>

                                            <?php endforeach ?>

                                            
                                       
                                        </tbody>
                                    </table>
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