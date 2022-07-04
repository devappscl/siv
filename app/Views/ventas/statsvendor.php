
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
                                        META DE VENTAS DIARIAS
                                    </div>
                                    <div class="card-body">
                                        
                                    <?php foreach($statventas as $vendor): ?>



        <?php 
        
        $vendido = $vendor['total'];
        $porcentaje = ($vendido * 100) / 100000;
        
        if($porcentaje > 100){
            $porcentaje = 100;
        }

        echo "<div class='progress'>
        <div class='progress-bar' role='progressbar' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' style='width:". $porcentaje ."%'><strong>". $porcentaje ."%</strong></div>
      </div>";
        
        ?>




<?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        ÚLTIMAS 10 VENTAS POR VENDEDOR(A)
                                    </div>
                                    <div class="card-body">
                                    <table class="table table-hover table-dark">
                                        <thead>
                                            <tr>
                                            <th scope="col">FECHA</th>
                                            <th scope="col">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach($ultimasventas as $ventas): ?>
                                            <tr>
                                            <td><?php echo  $ventas['created_at']  ?></td>
                                            <td>
                                            <button type="button" class="btn btn-success"> <strong><?php echo "$" . (number_format( round($ventas['total'],-1)) )  ?></strong></button>
                                                <?php if($ventas['formapago']== 'debito'): ?>
                                                       
                                                       <img src="https://iconape.com/wp-content/files/fs/209126/svg/209126.svg"  class="img-fluid" width="100" height="20">
                                                       <br>
                                                   <?php endif ; ?>
                                            </td>
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
                                       VENTAS POR HORA
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
                                            <td><button type="button" class="btn btn-light"> <strong><?php echo number_format($horas['total'])  ?></strong></button></td>
                                            </tr>
                                       <?php endforeach ?>

                                          
                                       </tbody>
                                        </table>

                                    
                                    </div>
                                </div>

                               
                            </div>
                            
                        </div>

                      
                    
                </main>
          
