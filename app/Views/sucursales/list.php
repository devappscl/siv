<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <a href="<?php echo base_url('/sucursales/add'); ?>" class="btn btn-success btn-sm">Nueva Sucursal</a>

        <hr>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>DIRECCIÓN</th>
                                                <th>TELÉFONO</th>
                                                <th>NOMBRE CORTO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                       
                                            <?php  foreach($datos as $dato): ?>
                                            <tr>
                                                <td><?php echo $dato['nombre']; ?></td>
                                                <td><?php echo $dato['direccion']; ?></td>
                                                <td><?php echo $dato['telefono']; ?></td>
                                                <td><?php echo $dato['nombrecorto']; ?></td>
                                                <td>BOTONES</td>
                                            </tr>
                                            <?php endforeach ?>
                                           
                                       
                                        </tbody>
                                    </table>
                                </div>
                      


    </div>
   </main>

