<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
       
        <div class="row bg-dark mt-2 p-1">
                <div class="col-md-2">
                    <a href="<?php echo base_url(); ?>" class="btn btn-primary" title="INICIO"><i class="fas fa-home"></i></a>
                    <a href="<?php echo base_url('/proveedores/add'); ?>" class="btn btn-success" title="NUEVO PROVEEDOR"><i class="fas fa-plus-circle"></i></a>
                </div>
                <div class="col-md-10">
                    <h3 class="text-light"><?php echo $titulo; ?></h3>
                </div>
           </div>
        

                                <div class="table-responsive mt-0">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                       
                                            <?php  foreach($datos as $dato): ?>
                                            <tr>
                                                <td><?php echo $dato['nombre']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('productos/proveedor/'. $dato['id']); ?>" class="btn btn-primary" title="INVENTARIO DEL PROVEEDOR"><i class="fas fa-boxes"></i></a>
                                                    <a href="<?php echo base_url('productos/proveedor/edit/'. $dato['id']); ?>" class="btn btn-danger" title="EDITAR PROVEEDOR"><i class="fas fa-edit"></i></a>
                                                
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                           
                                       
                                        </tbody>
                                    </table>
                                </div>
                      


    </div>
   </main>

