
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"><?php echo $titulo; ?></h1>
                        <p>Estadísticas de Venta</p>

                        <div class="row">
                        <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                       ESTADÍSTICA SUCURSAL
                                    </div>
                                    <div class="card-body">

                                <h4>INGRESO CAPITAL DE TRABAJO: </h4>
                                   <button class="btn btn-success"><h1><?php echo "$" . number_format($detalle2['suma'],-1) ?></h1></button>
                                    <hr>
                                   <h4>PAGO PROVEEDORES EFECTIVO: </h4>
                                   <button class="btn btn-danger"><h1><?php echo "$" . number_format($detalle1['suma'],-1) ?></h1></button>

                                   <h4>PAGO PROVEEDORES TRANSFERENCIA: </h4>
                                   <button class="btn btn-danger"><h1><?php echo "$" . number_format($detalle6['suma'],-1) ?></h1></button>

                                   <h4>PAGO COLABORADORES: </h4>
                                   <button class="btn btn-danger"><h1><?php echo "$" . number_format($detalle5['suma'],-1) ?></h1></button>


                                   <h4>TOTAL PAGO PROVEEDORES: </h4>
                                   <button class="btn btn-warning"><h1><?php echo "$" . number_format($pagos = $detalle1['suma'] + $detalle5['suma'] + $detalle6['suma'],-1) ?></h1></button>

                                   
                                  
                                   <hr>

                                   <h4>VENTAS: </h4>
                                   <button class="btn btn-success"><h1><?php echo "$" . number_format($detalle3['suma'],-1) ?></h1></button>

                                   <h4>VENTAS TARJETAS: </h4>
                                   <button class="btn btn-success"><h1><?php echo "$" . number_format($detalle4['suma'],-1) ?></h1></button>
                                    
                                   <h4>TOTAL VENTAS: </h4>
                                   <button class="btn btn-warning"><h1><?php echo "$" . number_format($ventas = $detalle3['suma'] + $detalle4['suma'],-1) ?></h1></button>


                                   <hr>
                                   
                                   <h4>BALANCE BRUTO: </h4>
                                   <button class="btn btn-warning"><h1><?php echo "$" . number_format($ventas + $pagos,-1) ?></h1></button>

                                       
                                    
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        VENTAS POR VENDEDOR(A)
                                    </div>
                                    <div class="card-body">
                                   
                                    <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($statventas as $vendor): ?>
                                            <tr>
                                            <td><?php echo $vendor['apaterno'] . " " . $vendor['amaterno'] . " " . $vendor['nombres']?></td>
                                            <td><button type="button" class="btn btn-light"> <strong><?php echo "$" . number_format(round($vendor['total'],-1)) ?></strong></button></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>
                                        
                                        <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($statventasayer as $vendor): ?>
                                            <tr>
                                            <td><?php echo $vendor['apaterno'] . " " . $vendor['amaterno'] . " " . $vendor['nombres']?></td>
                                            <td><button type="button" class="btn btn-light"> <strong><?php echo "$" . number_format(round($vendor['total'],-1)) ?></strong></button></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>
                                        
                                        <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($statventasanteayer as $vendor): ?>
                                            <tr>
                                            <td><?php echo $vendor['apaterno'] . " " . $vendor['amaterno'] . " " . $vendor['nombres']?></td>
                                            <td><button type="button" class="btn btn-light"> <strong><?php echo "$" . number_format(round($vendor['total'],-1)) ?></strong></button></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>
                                        
                                        <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($statventasanteayer1 as $vendor): ?>
                                            <tr>
                                            <td><?php echo $vendor['apaterno'] . " " . $vendor['amaterno'] . " " . $vendor['nombres']?></td>
                                            <td><button type="button" class="btn btn-light"> <strong><?php echo "$" . number_format(round($vendor['total'],-1)) ?></strong></button></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Ventas por Hora
                                    </div>
                                    <div class="card-body">

                                    <table class="table table-hover table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">HORA</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($ventashoras as $horas): ?>

                                            <tr>
                                            <td><?php echo  $horas['horas'] . ":00 "  ?></td>
                                            <td><button type="button" class="btn btn-light"> <strong><?php echo  "$" . number_format(round($horas['total'],-1))  ?></strong></button></td>
                                            </tr>
                                       <?php endforeach ?>

                                          
                                       </tbody>
                                        </table>
                                    
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        PRODUCTOS MAS VENDIDOS MES ACTUAL
                                    </div>
                                    <div class="card-body">

                                    <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">CANTIDAD</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($masvendidoshoy as $hoy): ?>
                                            <tr>
                                            <td><?php echo $hoy['nombre'] ?></td>
                                            <td><?php echo $hoy['cantidad'] ?></td>
                                            <td><?php echo "$" . number_format($hoy['total']) ?></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        PRODUCTOS MAS VENDIDOS TODOS LOS TIEMPOS
                                    </div>
                                    <div class="card-body">

                                    <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">NOMBRE</th>
                                            <th scope="col">CANTIDAD</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($masvendidossiempre as $siempre): ?>
                                            <tr>
                                            <td><?php echo $siempre['nombre'] ?></td>
                                            <td><?php echo $siempre['cantidad'] ?></td>
                                            <td><?php echo "$" . number_format($siempre['total']) ?></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Libro de Ventas
                                    </div>
                                    <div class="card-body">

                                    <table class="table table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">FECHA</th>
                                            <th scope="col">VENDEDOR</th>
                                            <th scope="col">FORMA DE PAGO</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($libroventas as $ventas): ?>
                                            <tr>
                                            <th scope="row"><a href="<?php echo base_url('ventas/ticket/' . $ventas['id']) ?>"><?php echo $ventas['id'] ?></a></th>
                                            <td><?php echo $ventas['created_at'] ?></td>
                                            <td>
                                                <?php echo $ventas['vendedor'] ?>
                                                <?php if($ventas['sucursal'] =="1"): ?>
                                                    <span class="badge badge-success">Las Pozas</span>
                                                <?php elseif($ventas['sucursal'] == "2" ): ?>
                                                <span class="badge badge-danger">Express</span> 
                                                <?php endif ?>
                                           </td>
                                            <td><?php echo $ventas['formapago'] ?></td>
                                            <td><?php echo "$" . number_format(round($ventas['total'],-1)) ?></td>
                                            </tr>
                                           
                                        <?php endforeach ?>
                                            
                                            
                                        </tbody>
                                        </table>

                                       
                                    
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                      
                    
                </main>
          
