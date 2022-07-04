<div id="layoutSidenav_content">
  
  <main>
    
    <div class="container-fluid">
        
      <h1 class="mt-4"><?php echo $titulo . " / " . $proveedor ?></h1>

      <!-- MENU PAGINA -->
      <div class="btn-group" role="group" aria-label="Basic example">
          <a href="<?php echo base_url(); ?>" class="btn btn-primary btn-sm"><i class="fas fa-home"></i> Home</a>
          <?php if(session('rol') == '777' or session('rol') == '7'): ?>
            <button class="btn btn-success btn-sm" id="BotonAgregar"><i class="fas fa-plus-circle"></i> Nuevo Producto</button>
            <a href="<?php echo base_url("productos/ticket/" . $proveedor) ?>" class="btn btn-warning btn-sm"><i class="fas fa-print"></i> Imprimir Nota de Venta</a>
         
            <?php endif ?>
      </div>
    
      <hr>

      <!-- MENSAJE -->
      <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success" role="alert" id="msg">
          <?php echo session()->getFlashdata('msg') ?>
        </div>
      <?php endif ?>

      
                     
      <div class="table-responsive">
        <table class="dataTable table table-bordered" width="100%" cellspacing="0" id="tablaarticulos">
          <thead>
            <tr>
              <th>CÓDIGO</th>
                <th>NOMBRE</th>
                <th>STOCK</th>
                <th>MAS VENDIDO</th>
              </tr>
          </thead>
                                          
        </table>
      </div>


 




    </div>
  </main>






   

<script>

document.addEventListener("DOMContentLoaded", function() {
        
  let tabla1 = $(".dataTable").DataTable({
  "ajax": {
  url: "<?php echo base_url('productos/datatablesmasvendidos/'.$proveedor); ?>",
  dataSrc: ""
  },
  
  "columns": [{
    "data": "codigo", 
  },
  {
  "data": "nombre", 
  },
  {
  "data": "stockcodigo",
  "type": "num", 
  },
  {
  "data": "cantidad",
  "type": "num", 
  }
  ],
          
  
          
  "language": {
    "url": "<?php echo base_url('js/datatables.spanish.json'); ?>",
  },

  "pageLength": 150,
  "order": [[ 3, "desc" ]]


  });

  


  
  
       
        

      });
    </script>



    