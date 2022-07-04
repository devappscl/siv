<div id="layoutSidenav_content">
        
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo; ?></h3>
        <a href="<?php echo base_url('/categorias'); ?>" class="btn btn-primary btn-sm">Volver</a>
        <hr>
            
        
            <form method="post" action="<?php echo base_url('/categorias/store'); ?>" autocomplete="off">

         
            <fieldset class="form-group">
                <label>Nombre Categoría</label>
               <input type="text" class="form-control" name="nombre" autofocus required>
            </fieldset>

        <fieldset>
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
        
     
      
                     
                                
                      


    </div>
   </main>

  