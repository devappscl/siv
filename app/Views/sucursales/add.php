<div id="layoutSidenav_content">
        
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo; ?></h3>
        <a href="<?php echo base_url('/sucursales'); ?>" class="btn btn-primary btn-sm">Volver</a>
        <hr>
            
        
            <form method="post" action="<?php echo base_url('/sucursales/store'); ?>" autocomplete="off">

         
            <fieldset class="form-group">
                <label>Nombre Sucursal</label>
                <textarea class="form-control" name="nombre" rows="3" cols="80" required autofocus="TRUE"> </textarea>
            </fieldset>

            <fieldset class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </fieldset>

            <fieldset class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </fieldset>

            <fieldset class="form-group">
                <label>Nombre Corto</label>
                <input type="text" name="nombrecorto" class="form-control">
            </fieldset>


        <fieldset>
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
        
     
      
                     
                                
                      


    </div>
   </main>

  