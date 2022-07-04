<div id="layoutSidenav_content">
        
        <main>
           <div class="container-fluid">
           <div class="row bg-dark mt-2 p-1">
             <div class="col-md-2">
                <a href="<?php echo base_url('/proveedores'); ?>" class="btn btn-primary"><i class="fas fa-home"></i></a>
             </div>
             <div class="col-md-10">
                <h3 class="text-light"><?php echo $titulo; ?></h3>
             </div>
           </div>
            
        <hr>

            <form method="post" action="<?php echo base_url('/proveedores/store'); ?>" autocomplete="off">

            <fieldset class="form-group">
            <div class="row">
              <div class="col-md-4">
                <input type="text" class="form-control" name="prut" placeholder="RUT PROVEEDOR" autofocus required>
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" name="pdv" placeholder="DV" autofocus required>
              </div>
            </div>
            </fieldset>

            <fieldset class="form-group">
               <input type="text" class="form-control" placeholder="NOMBRE" name="nombre" autofocus required>
            </fieldset>

            <fieldset class="form-group">
               <input type="text" class="form-control" placeholder="VENDEDOR(A)" name="vendedor" autofocus required>
            </fieldset>

            <fieldset class="form-group">
               
                <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="DATOS RELEVANTES, DÍA TOMA PEDIDO, DÍA ENTREGA, DATOS TRANSFERENCIA, ENTRE OTROS..."></textarea>
            </fieldset>

        <fieldset>
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
        
     
      
                     
                                
                      


    </div>
   </main>

  