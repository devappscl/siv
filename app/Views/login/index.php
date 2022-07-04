<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>INGRESAR</title>
        <link href="<?php echo base_url("/css/styles.css"); ?>" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h1 class="text-center font-weight-light my-4"><span class="badge badge-primary"><?php echo APP_NAMEAPP ?></span></h1>
                                    
                                    </div>
                                    <div class="card-body">

                                    <?php if(session()->getFlashdata('msg')): ?>
                                        <div class="alert alert-danger" role="alert" id="msg">
                                            <?php echo session()->getFlashdata('msg') ?>
                                            <br>
                                        </div>
                                    <?php endif ?>

                                        <form method="post" action="<?php echo base_url('auth/login') ?>" autocomplete="off">
                                            <div class="form-group">
                                                <input class="form-control py-4" name="rut" type="text" placeholder="USUARIO" autofocus="TRUE" required="TRUE" />
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control py-4" id="contrasena" type="password" name="password" placeholder="CONTRASEÑA" required="TRUE" />
                                                <input type="checkbox" id="mostrar_contrasena" title="clic para mostrar contraseña"/> Mostrar Contraseña
                                            </div>

                                            <div class="form-group">
                                                <select name="sucursal" class="form-control">
                                                 <?php foreach($locales as $sucursal): ?>
                                                        <option value="<?php echo $sucursal['id']; ?>"><?php echo $sucursal['nombre']; ?></option>   
                                                   <?php endforeach ?> 
                                                </select>
                                            </div>

                                           

                                            
                                            <div class="text-center ">
                                                <button type="submit" class="btn btn-success">INGRESAR</button>
                                            </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    setTimeout(function() {
                        $("#msg").fadeOut(1000);
                    },3000);  
                });
            </script>
            <script>
                $(document).ready(function () {
                $('#mostrar_contrasena').click(function () {
                    if ($('#mostrar_contrasena').is(':checked')) {
                    $('#contrasena').attr('type', 'text');
                    } else {
                    $('#contrasena').attr('type', 'password');
                    }
                });
                });
            </script>
    </body>
</html>
