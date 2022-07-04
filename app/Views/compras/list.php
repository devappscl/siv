<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <!-- INGRESO -->
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
        Ingresar Pedido
        </button>
     
        <hr>

       <!-- <?php if(session('rol') == '777'): ?>
        <div>
            <form action="<?php echo base_url('/caja/registro'); ?>" method="post" class="form-inline">
            
                <strong>Seleccionar rango de fechas: </strong> &nbsp;

                 <input type="datetime-local" name="datea" id="datea" class="form-control mb-2 mr-sm-2" >

                <input type="datetime-local" name="dateb" id="dateb" class="form-control mb-2 mr-sm-2">
           
               <button class="btn btn-primary mb-2">Buscar</button>
                
            </form>
        </div>
      
        <hr>
        <?php endif ?> -->

   
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                               
                                                <th>VENDEDOR(A)</th>
                                                <th>DETALLE</th>
                                                <th>PROVEEDOR/TOTAL/FECHA ENTREGA</th>
                                                
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                            <?php  foreach($compras as $compra): ?>
                                            <tr>
                                              
                                                <td>
                                                
                                                    <?php echo $compra['vendedor']; ?>
                                                    <br>
                                                    <?php echo $compra['created_at']; ?>
                                                
                                                </td>
                                                
                                                <td>
                                               
                                                <?php echo $compra['detalle']; ?>
                                                </td>
                                                <td>
                                                <strong><?php echo $compra['nombre'] ?></strong>
                                                <br>
                                                <button class="btn btn-warning"><strong><?php echo "$" . number_format($compra['total']) ?></strong></button>
                                             
                                                <br>
                                                <?php echo $compra['delivery_at'] ?>
                                                       
                                                </td>

                                            </tr>

                                            <?php endforeach ?>

                                        </tbody>
                                    </table>
                                </div>
                      

 <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingresar Pedido/Compra Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url("compras/store") ?>" method="post" autocomplete="off">
            <fieldset>
                <label for="">Total</label>
                <input type="text" name="total" class="form-control">
            </fieldset>
            <fieldset class="form-group">
            <label>Proveedor</label>
                <select name="proveedor_id" class="form-control">
                        <?php foreach($proveedores as $proveedor): ?>
                            <option value="<?php echo $proveedor['id']; ?>"><?php echo $proveedor['nombre']; ?></option>
                        <?php endforeach ?>
                </select>
            </fieldset>
            <fieldset>
                <label for="">Detalle</label>
                <textarea name="detalle" id="" cols="30" rows="3" class="form-control"></textarea>
            </fieldset>
            
            <fieldset>
            <label for="">Fecha Entrega</label>
            <input type="date" name="delivery_at" value="<?php echo date("Y-m-d") ?>" class="form-control">
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




    </div>
  </main>





