<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h1 class="mt-4">Nota Pedido</h1>
        
        <?php if(session()->getFlashdata('msg')): ?>
            
            <div class="alert alert-danger" role="alert" id="msg">
                <?php echo session()->getFlashdata('msg') ?>
            </div>

        <?php endif ?>

        <hr>

        <div class="row">

        <div class="col-md-12">

        <form action="">
            <fieldset class="form-group">
                <select name="proveedor" id="proveedor" class="form-control form-control-lg">
                <?php  foreach($datos as $dato): ?>
                  <option value=""></option>
                  
                </select>
            </fieldset>
        </form>

        <!-- <div class="table-responsive">
        <table class="datatable table table-bordered"  width="100%" cellspacing="0" id="tablaarticulos">
          <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>NOMBRE</th>
                <th>PRECIO COMPRA</th>
                <th>CANTIDAD</th>
                <th>SOLICITUD</th>
              </tr>
          </thead>
                                          
        </table>
        -->
      </div>

            
            </div>

        </div>
        

    </div>
   </main>


<script>

  

$( document ).ready(function() {
    cargaProveedores(1);
    cargaproductos(1);
});

$('#proveedor').on('change', function() {
    cargaproductos($("#proveedor").val());
});

  function cargaProveedores(prov){
    
    $.ajax({
	    	type: "GET",
	    	url: '<?php echo base_url('productos/proveedoresid') ?>', 
	    	dataType: "json",
	    	success: function(data){
	    		
          $(data).each(function(i, v){ // indice, valor
             $("#proveedor").prepend('<option value="' + v.id + '">' + v.nombre + '</option>');
          });

          $("#proveedor option[value="+ prov +"]").attr("selected",true);

	    	},

	    	error: function(data) {
	    		alert('error');
	    	}

	    });

  }

  function cargaproductos(proveedor){

    var table = $("#tablaarticulos").DataTable({
        "ajax": {
        url: "<?php echo base_url('productos/datatablesproveedor'); ?>/" + proveedor,
        dataSrc: ""
        },
        
        "columns": [{
          "data": "codigo", 
        },
        {
        "data": "nombre", 
        },
        {
        "data": "pcompra", 
        },
        {
        "data": "cantidad",
        "type": "num", 
        },
        {
        "data": null,  
        "orderable": false
        },

    ],

        "columnDefs": [{
        targets: 4,
        "defaultContent": "<button class='btn btn-sm btn-success' id='botonpedir'><i class='fas fa-edit'></i></button>",
        data: null
        }],
        
        
        stateSave: true,
        "bDestroy": true,
        searching: false, 
        paging: false, 
        info: false,
                
        
                
        "language": {
          "url": "<?php echo base_url('js/datatables.spanish.json'); ?>",
        },
      
        "pageLength": 500,
        "order": [[ 3, "asc" ]]

    });
   
}

$('#tablaarticulos tbody').on('click', 'button.botonpedir', function() {
          if (confirm("¿Realmente quiere pedir este artículo?")) {
            let registro = tabla1.row($(this).parents('tr')).data();
            borrarRegistro(registro.id);
          }
 });


</script>









