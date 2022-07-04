<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h1 class="mt-4"><?php echo $titulo ?></h1>
        <a href="<?php echo base_url('stock/'); ?>" class="btn btn-primary btn-sm">Volver</a>
        <hr>

        
            <form method="post" action="<?php echo base_url('/stock/update'); ?>" autocomplete="off">
                
            <fieldset class="form-group">
                <label>Código</label>
                <input type="text" name="producto" value="<?php echo $datos['codigo'] ?>" class="form-control" readonly>
            </fieldset>

    
                    <fieldset class="form-group">
                    <label>Nombre</label>
                    <input type="text"  value="<?php echo $datos['nombre'] ?>" class="form-control" readonly>
                    </fieldset>
              

            <div class="row">

                <div class="col-md-4">
                    <fieldset class="form-group">
                    <label>Stock Actual</label>
                    <input type="text" name="monto" id="cinicial" value="<?php echo $datos['cantidad'] ?>" class="form-control" readonly>
                    </fieldset>
                </div>

               
                <div class="col-md-4">
                    <fieldset class="form-group">
                    <label>Stock Agregado</label>
                    <input type="text" name="monto" id="cagregar" value="" class="form-control" autofocus="true">
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                    <label>Stock Final</label>
                    <input type="text" name="cantidad" id="cfinal" value="<?php echo $datos['cantidad'] ?>" class="form-control" readonly>
                    </fieldset>
                </div>
            
            </div>

  

        <fieldset>
            <input type="hidden" name="id" value="<?php echo $datos['id'] ?>">
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
        
     
    </div>
   </main>

  
  <script>
   $(document).ready(function(){
    $("input[type='text']").change(function(){
    var suma = 0;
    suma = Number($("input[id='cinicial']").val());
    suma += Number($("input[id='cagregar']").val());
   
    $("#cfinal").val(suma);
    });
    });
  </script>