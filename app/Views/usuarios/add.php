<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <a href="<?php echo base_url('/usuarios'); ?>" class="btn btn-primary btn-sm">Volver</a>

        <hr>

        <form action="<?php echo base_url('usuarios/store') ?>" method="post" autocomplete="OFF">
        
            <div class="form-group">
             <div class="row">
                <div class="col-md-2">
                <label for="">RUT</label>
                    <input type="text" name="rut" class="form-control" required autofocus> 
                    
                </div>
                <div class="col-md-1">
                <label>Dv</label>
                    <input type="text" name="dv" class="form-control" required> 
                    
                </div>
                
             </div>
            </div>

            <div class="form-group">
             <div class="row">
            <div class="col-md-4">
                <label>USERNAME</label>
                    <input type="text" name="username" class="form-control" required> 
                    
                </div>
            </div>
            </div>
              
            <div class="form-group">
             <div class="row">
                <div class="col-md-4">
                <label for="">NOMBRES</label>
                    <input type="text" name="nombres" class="form-control" required> 
                    
                </div>
                <div class="col-md-4">
                <label>APELLIDO PATERNO</label>
                    <input type="text" name="apaterno" class="form-control" required> 
                    
                </div>
                <div class="col-md-4">
                <label>APELLIDO MATERNO</label>
                    <input type="text" name="amaterno" class="form-control" required> 
                    
                </div>
                
             </div>
            </div> 

            <div class="form-group">
             <div class="row">
                <div class="col-md-4">
                <label for="">PASSWORD</label>
                    <input type="text" name="password" class="form-control" required> 
                    
                </div>
                <div class="col-md-4">
                <label>TELÉFONO</label>
                    <input type="text" name="telefono" class="form-control"> 
                    
                </div>
                <div class="col-md-4">
                <label>ROL</label>
                    <select name="rol" id="" class="form-control" required>
                        <option value="1">Vendedor(a)</option>
                        <option value="777">Administrador(a)</option>
                    </select>
                    
                </div>
                
             </div>
            </div> 

            <div>
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </div>

                         
        
        </form>

       
                      


    </div>
   </main>

