<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <a href="<?php echo base_url('/categorias/add'); ?>" class="btn btn-success btn-sm">Nueva Categoría</a>

        <hr>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>ESTADO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                       
                                            <?php  foreach($datos as $dato): ?>
                                            <tr>
                                                <td><?php echo $dato['nombre']; ?></td>
                                                <td><?php echo $dato['estado']; ?></td>
                                                <td>BOTONES</td>
                                             </tr>
                                            <?php endforeach ?>
                                           
                                       
                                        </tbody>
                                    </table>
                                </div>
                      


    </div>
   </main>

