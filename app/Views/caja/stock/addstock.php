<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h1 class="mt-4"><?php echo $titulo ?></h1>
        <a href="<?php echo base_url('stock/'); ?>" class="btn btn-primary btn-sm">Volver</a>
        <hr>

        <?php if(session()->getFlashdata('msg')): ?>
            
            <div class="alert alert-success" role="alert" id="msg">
                <?php echo session()->getFlashdata('msg') ?>
            </div>

        <?php endif ?>

        <?php if($nodata): ?>
            <form method="post" action="<?php echo base_url('/stock/update'); ?>" autocomplete="off">
                
            <fieldset class="form-group">
                <label>Código</label>
                <input type="text" name="producto" value="<?php echo $producto['codigo'] ?>" class="form-control" readonly>
            </fieldset>

            <fieldset class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?php echo $producto['nombre'] ?>" class="form-control" readonly>
            </fieldset>

            <fieldset class="form-group">
                <label>Stock</label>
                <input type="text" name="cantidad" value="" class="form-control" autofocus="true">
            </fieldset>

        <fieldset>
            <input type="hidden" name="id" value="<?php echo $producto['codigo'] ?>">
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
    <?php else: ?>
        <h3>El Producto no existe. Intente agregarlo por favor.</h3>
        <a href="<?php echo base_url('/productos/add'); ?>" class="btn btn-primary btn-sm">Nuevo Producto</a>
    <?php endif ?>
        
     
    </div>
   </main>