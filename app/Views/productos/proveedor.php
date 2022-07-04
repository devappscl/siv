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
 <a href="<?php echo base_url('productos/masvendidos/' . $proveedor) ?>"><button class="btn btn-dark btn-sm"><i class="fas fa-plus-circle"></i> Lista Más Vendidos</button></a>
           
         
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
                <th>PRECIO COMPRA</th>
                <th>PRECIO VENTA</th>
                <th>STOCK</th>
                <th>ACCIONES</th>
              </tr>
          </thead>
                                          
        </table>
      </div>


 <!-- Formulario (Agregar, Modificar) -->

 <div class="modal fade" id="FormularioArticulo" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modal-titulo"></h4>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <fieldset>
          
          <div class="float-right">
           <span class="badge badge-warning" id="actualizado"></span>
          </div>
          <br>
          </fieldset>

            <fieldset class="form-group">
                <label>Código</label>
                <input type="hidden" id="id" name="id" >
                <input type="text" id="codigo" name="codigo" class="form-control form-control-lg" autofocus="true" required>
            </fieldset>

            <fieldset class="form-group">
                <label>Nombre</label>
                <textarea class="form-control form-control-lg" id="nombre"  name="nombre" rows="3" cols="80" required ></textarea>
            </fieldset>


            <fieldset class="form-group">
                <label>Proveedor</label>
                <select name="proveedor" id="proveedor" class="form-control form-control-lg">
                  
                </select>
            </fieldset>

            <fieldset class="form-group">
          <div class="row">
           
            <div  class="col-md-4">
              <label>Cantidad Actual</label>
              <input type="text" id="stock" name="stock" class="form-control" readonly>
            </div>
            <div  class="col-md-4">
              <label>Cantidad a Agregar</label>
              <input type="text" id="agregar" name="agregar" class="form-control" requiered focus="true" autocomplete="off">
            </div>
            <div  class="col-md-4">
              <label>Cantidad Final</label>
              <input type="text" id="cantidad" name="cantidad" class="form-control" required>
            </div>
          </div>

          </fieldset>
    
        <fieldset class="form-group">
          <div class="row">   
            <div  class="col-md-4">
              <label>Precio Compra</label>
              <input type="text" id="pcompra" name="pcompra" class="form-control form-control-lg" onkeyup="PasarValor();" required>
            </div>
            <div  class="col-md-4">
              <label>Precio Sugerido 30%</label>
              <input type="text" id="psugerido" name="preciocompra" class="form-control form-control-lg" disabled>
            </div>
            <div  class="col-md-4">
              <label>Precio Venta</label>
              <input type="text" id="pventa" name="pventa" class="form-control form-control-lg" required>
            </div>
          </div>
        </fieldset>

          <div class="modal-footer">
              <button type="button" id="ConfirmarAgregar" class="btn btn-success">Agregar</button>
              <button type="button" id="ConfirmarModificar" class="btn btn-success">Modificar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>

          <hr>
          
          <!-- ESTADÍSTICA DEL PRODUCTO-->
          <span class="badge badge-dark" id="margen"></span>

            

          </div>
        </div>
      </div>




    </div>
  </main>






   

<script>

document.addEventListener("DOMContentLoaded", function() {
        
  let tabla1 = $(".dataTable").DataTable({
  "ajax": {
  url: "<?php echo base_url('productos/datatablesproveedor/'.$proveedor); ?>",
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
  "data": "pventa", 
  },
  {
  "data": "cantidad",
  "type": "num", 
  },
  {
  "data": null,  
  "orderable": false
  }
  ],
          
  "columnDefs": [{
  targets: 5,
  "defaultContent": "<button class='btn btn-sm btn-primary' id='botonmodificar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger botoneliminar'><i class='far fa-trash-alt'></i></button>",
  data: null
  }],
          
  "language": {
    "url": "<?php echo base_url('js/datatables.spanish.json'); ?>",
  },

  "pageLength": 150,
  "order": [[ 4, "asc" ]]


  });

  
  //EVENTOS DE LA APLICACIÓN

  //AGREGAR NUEVO PRODUCTO
  $('#BotonAgregar').click(function() {
      limpiarFormulario()
      $('#ConfirmarAgregar').show();
      $('#ConfirmarModificar').hide();
      $( "#modal-titulo" ).html("Agregar Nuevo Producto");
      $("#FormularioArticulo").modal('show');
      cargaProveedores();
  });

  //CONFIRMAR AGREGAR REGISTRO
  $('#ConfirmarAgregar').click(function() {
      $("#FormularioArticulo").modal('hide');
      let registro = recuperarDatosFormulario();
      agregarRegistro(registro);
  });

  $('#ConfirmarModificar').click(function() {
      $("#FormularioArticulo").modal('hide');
      let registro = recuperarDatosFormulario();
      modificarRegistro(registro);
  });

  //DEVOLVER DATOS DEL FORMULARIO A PROCESAR
  function recuperarDatosFormulario() {
    let registro = {
      id: $('#id').val(),
      codigo: $('#codigo').val(),
      nombre: $('#nombre').val(),
      pcompra: $('#pcompra').val(),
      pventa: $('#pventa').val(),
      proveedor: $('#proveedor').val(),
      cantidad: $('#cantidad').val(),
      actualizado: $('#actualizado').val()
    };
    return registro;
  }



  $('#tablaarticulos tbody').on('click', '#botonmodificar', function() {
    $('#ConfirmarAgregar').hide();
    $('#ConfirmarModificar').show();
    let registro = tabla1.row($(this).parents('tr')).data();
    recuperarRegistro(registro.id);
    
  });

        $('#tablaarticulos tbody').on('click', 'button.botoneliminar', function() {
          if (confirm("¿Realmente quiere borrar el artículo?")) {
            let registro = tabla1.row($(this).parents('tr')).data();
            borrarRegistro(registro.id);
          }
        });

        



// LIMPIAR EL FORMULARIO
function limpiarFormulario() {
  $('#modal-titulo').html('');
  $('#id').val('');
  $('#codigo').val('');
  $('#nombre').val('');
  $('#pcompra').val('');
  $('#pventa').val('');
  $('#stock').val('');
  $('#agregar').val('');
  $('#cantidad').val('');
  $('#proveedor').val('');
  $('#actualizado').html('');
}

 //FUNCIONES PARA COMUNICARSE CON EL SERVIDOR
  function recuperarRegistro(codigo) {
          $.ajax({
            type: 'GET',
            url: '<?php echo base_url('productos/detalle?id=') ?>' + codigo,
            dataType: "json",
            data: '',
            success: function(data) {
              $('#modal-titulo').html(data[0].producto.nombre);
              $('#id').val(data[0].producto.id);
              $('#codigo').val(data[0].producto.codigo);
              $('#nombre').val(data[0].producto.nombre);
              $('#pcompra').val(data[0].producto.pcompra);
              $('#pventa').val(data[0].producto.pventa);
              $('#stock').val(data[0].producto.cantidad);
              $('#agregar').val(0);
              $('#cantidad').val(data[0].producto.cantidad);
              $('#actualizado').html("Actualizado " + moment(data[0].producto.updated_at).fromNow());
              $('#margen').html("Margen de Ganancia: " + Math.round(((data[0].producto.pventa - data[0].producto.pcompra) * 100) / data[0].producto.pcompra) + "%") ;
              $("#FormularioArticulo").modal('show');
              cargaProveedores(data[0].producto.proveedor);    
                
            },
            error: function() {
              alert("Hay un problema");
            }
          });
  }

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



  //AJAX AGREGAR REGISTRO
  function agregarRegistro(registro) {
          $.ajax({
            type: 'POST',
            url: '<?php echo base_url('productos/store') ?>',
            data: registro,
            success: function(msg) {
              tabla1.ajax.reload();
            },
            error: function() {
              alert("Hay un problema");
            }
    });
  }

  //AJAX MODIFICAR REGISTRO
  function modificarRegistro(registro) {
          $.ajax({
            type: 'POST',
            url: '<?php echo base_url('productos/update') ?>',
            data: registro,
            success: function(msg) {
              tabla1.ajax.reload();
            },
            error: function() {
              alert("Hay un problema");
            }
          });
        }

       // function recuperarRegistro(codigo) {
       //   $(location).attr('href',"<?php echo base_url('productos/edit')?>/" + codigo);
       // }

        function borrarRegistro(codigo) {
          $(location).attr('href',"<?php echo base_url('productos/desactivar')?>/" + codigo);
        }

       
        

      });
    </script>



    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                $("#msg").fadeOut(1000);
            },2000);  
        });
    </script>

    
   <script type="text/javascript">
        function PasarValor()
            {
            document.getElementById("psugerido").value = document.getElementById("pcompra").value * 1.3;
            }
   </script>

<script>
   $(document).ready(function(){
    
    $("#agregar").change(function(){
    var suma = 0;
    suma = Number($("input[id='stock']").val());
    suma += Number($("input[id='agregar']").val());
   
    $("#cantidad").val(suma);


    });

    });
  </script>