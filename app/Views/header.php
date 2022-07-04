<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo APP_NAMEAPP ?></title>
        <link href="<?php echo base_url("/css/styles.css"); ?>" rel="stylesheet" />
        <link href="<?php echo base_url("/css/dataTables.bootstrap4.min.css") ?>" rel="stylesheet" crossorigin="anonymous" />
        <script src="<?php echo base_url("/js/all.min.js") ?>" crossorigin="anonymous"></script>
        <link href="<?php echo base_url("/js/jquery-ui/jquery-ui.min.css"); ?>" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="<?php echo base_url("/js/jquery-ui/jquery-ui.min.js"); ?>" ></script>
        <script src="<?php echo base_url("/js/jquery.number.min.js"); ?>" ></script> 
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
        

    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo base_url('/home'); ?>"><?php echo APP_NAMEAPP ?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
            

            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
               

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i> <?php echo session('rut'); ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                     
                       <!-- <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>

        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                           
                            <div class="sb-sidenav-menu-heading">DASHBOARD</div>

                         
                           
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                INVENTARIO
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url('/productos'); ?>">Productos</a>
                                    <!--<a class="nav-link" href="<?php echo base_url('/stock'); ?>">Stock</a>
                                    <a class="nav-link" href="<?php echo base_url('/stock/movil'); ?>">Recuento</a> -->
                                    <a class="nav-link" href="<?php echo base_url('/proveedores'); ?>">Proveedores</a>
                                    <a class="nav-link" href="<?php echo base_url('/categorias'); ?>">Categorías</a>
                                  
                                </nav>
                            </div>

                            <a class="nav-link" href="<?php echo base_url('/ventas'); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                               VENTAS
                            </a>

                            <a class="nav-link" href="<?php echo base_url('/compras'); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                               COMPRAS
                            </a>

                            <a class="nav-link" href="<?php echo base_url('/caja'); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                               CAJA
                            </a>

                            
                            <?php if(session('rol') == '777'): ?>
                            
                               
                            <a class="nav-link" href="<?php echo base_url('/usuarios'); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                               USUARIOS
                            </a>

                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                               CLIENTES
                            </a>

                            <a class="nav-link" href="<?php echo base_url('ventas/stats') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            ESTADÍSTICAS
                            </a>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                CONFIGURACIÓN
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url('/sucursales'); ?>">Sucursales</a>
                                  
                                </nav>
                            </div>
                            <?php endif ?>
                           
                           
                           
                    </div>
                    
                </nav>
            </div>


