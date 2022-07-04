<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <a href="<?php echo base_url('/usuarios/add'); ?>" class="btn btn-success btn-sm">Nuevo Usuario</a>

        <hr>

        <?php if(session()->getFlashdata('msg')): ?>
            
            <div class="alert alert-success" role="alert" id="msg">
                <?php echo session()->getFlashdata('msg') ?>
            </div>

        <?php endif ?>

                                <div class="table-responsive">
                                    <table class="dataTable table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>USERNAME</th>
                                                <th>ROL</th>
                                                <th>NOMBRE</th>
                                                <th>ACCIONES</th>
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
  url: "<?php echo base_url('usuarios/datatables'); ?>",
  dataSrc: ""
  },
  
  "columns": [{
    "data": "username", 
  },
  {
  "data": "rol", 
  },
  {
  "data": "ncompleto", 
  },
  {
  "data": null,  
  "orderable": false
  }
  ],
          
  "columnDefs": [{
  targets: 3,
  "defaultContent": "<button class='btn btn-sm btn-primary ' id='botonmodificar'><i class='fas fa-edit'></i></button> <button class='btn btn-sm btn-danger botoneliminar'><i class='far fa-trash-alt'></i></button>",
  data: null
  }],
          
  "language": {
    "url": "<?php echo base_url('js/datatables.spanish.json'); ?>",
  },

  "pageLength": 25,

  order: [[3, "asc"]],

  });


});



</script>

   <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                $("#msg").fadeOut(1000);
            },2000);  
        });
    </script>