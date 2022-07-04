<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h1 class="mt-4"><?php echo $titulo ?></h1>
        <a href="<?php echo base_url('stock/'); ?>" class="btn btn-primary btn-sm">Volver</a>
        <hr>

        
            <form method="post" action="<?php echo base_url('/stock/update'); ?>" autocomplete="off">
                
            <fieldset class="form-group">
                <label>Código</label>
                <input type="text" name="producto" value="<?php echo $datos['producto'] ?>" class="form-control" readonly>
            </fieldset>

            <fieldset class="form-group">
                <label>Stock</label>
                <input type="text" name="cantidad" value="<?php echo $datos['cantidad'] ?>" class="form-control" autofocus="true">
            </fieldset>

        <fieldset>
            <input type="hidden" name="id" value="<?php echo $datos['id'] ?>">
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
        
     
    </div>
   </main>

  