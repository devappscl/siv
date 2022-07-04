
            <form method="post" action="<?php echo base_url('/finanzas/store'); ?>" autocomplete="off">

           
            <input type="hidden" name="tipo" value="<?php echo $movimiento; ?>">
                
            <fieldset class="form-group">
                <label>Cantidad $</label>
                <input type="text" name="cantidad" class="form-control" autofocus="true" required>
            </fieldset>

            <fieldset class="form-group">
                <label>Sucursal</label>
                <select name="local" class="form-control" readonly>
                     <?php foreach($locales as $sucursal): ?>
                        <option value="<?php echo $sucursal['id']; ?>" <?php if($sucursal['id'] == session('sucursal')){echo "selected";}  ?>><?php echo $sucursal['nombre']; ?></option>
                    <?php endforeach ?>
                </select>
            </fieldset>

            <fieldset class="form-group">
                <label>Vendedor(a)</label>
                <select name="cajera" class="form-control" readonly>
                <?php foreach($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['rut']; ?>" <?php if($usuario['rut'] == session('rut')){echo "selected";}  ?>><?php echo $usuario['nombres'] . " " . $usuario['apaterno'] . " " . $usuario['amaterno']; ?></option>
                    <?php endforeach ?>
                </select>
            </fieldset>

           

            <fieldset class="form-group">
                <label>Tipo de Movimiento</label>
                <select name="tipodetalle" class="form-control">
                <option value="">Seleccione</option>
                  <option value="1" >Pago Proveedor</option>
                  <option value="2" >Ingreso Caja Chica</option>
                  <option value="3" >Cierre Caja Ventas</option>
                  <option value="4" >Cierre RedCompra</option>
                  <option value="5" >Pago Colaborador(a)</option>
                </select>
            </fieldset>

            <fieldset class="form-group">
                <label>Comentario</label>
                <textarea class="form-control" name="comentario" rows="3" cols="80" required> </textarea>
            </fieldset>

        <fieldset>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" name="button" class="btn btn-primary">Guardar</button>
        </fieldset>
            
    </form>
        
    

   <script type="text/javascript">
        function PasarValor()
            {
            document.getElementById("psugerido").value = document.getElementById("pcompra").value * 1.3;
            }
        </script>