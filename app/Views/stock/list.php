<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h3 class="mt-4"><?php echo $titulo ?></h3>
        <a href="<?php echo base_url('/home'); ?>" class="btn btn-primary btn-sm">Volver</a>
      <!-- <?php foreach($sucursales as $sucursal) :?>
            <a href="<?php echo base_url('stock/sucursal/'.$sucursal['id']); ?>" class="btn btn-info btn-sm"><?php echo $sucursal['nombre']; ?></a>
        <?php endforeach ?>
      -->
      
        <hr>

        <div class="table-responsive">
        <table class="dataTable table table-bordered" width="100%" cellspacing="0" id="tablaarticulos">
          <thead>
            <tr>
               <th>ID</th>
                <th>CÓDIGO</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>ACTUALIZAR</th>
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
          

            <fieldset class="form-group">
                <label>Código</label>
                <input type="hidden" id="id" name="id" >
                <input type="text" id="codigo" name="codigo" class="form-control" autofocus="true" readonly>
            </fieldset>

            <fieldset class="form-group">
                <label>Nombre</label>
                <textarea class="form-control" id="nombre"  name="nombre" rows="3" cols="80"  readonly></textarea>
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

          <div class="modal-footer">
          <button type="button" id="ConfirmarAgregar" class="btn btn-success">Agregar</button>
              <button type="button" id="ConfirmarModificar" class="btn btn-success">Modificar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>

          </div>
        </div>
      </div>




    </div>
  </main>


<script>
moment.locale('es');

document.addEventListener("DOMContentLoaded", function() {
        
  
    let tabla1 = $(".dataTable").DataTable({
        "ajax": {
        url: "<?php echo base_url('/stock/dataTables'); ?>",
        dataSrc: ""
    },
  
    "columns": [
        { "data": "producto_id","visible":false },
        { "data": "codigo", },
        { "data": "nombre", },
        { "data": "cantidad","orderable": true },
        
        { "data": "updated_at",
          "render": function (data) {
            return moment(data).fromNow();
          }
        },

      { "data": null,  "orderable": false }
    ],
          
    "columnDefs": [{
       targets: 5,
      "defaultContent": "<button class='btn btn-sm btn-primary ' id='botonmodificar'><i class='fas fa-edit'></i></button>",
      data: null
    }],
          
    "language": {
        "url": "<?php echo base_url('js/datatables.spanish.json'); ?>",
        "decimal": ",",//separador decimales
        "thousands": "."//Separador miles
    },

    "pageLength": 50,

    order: [[2, "asc"]],

  });

  //EVENTOS DE LA APLICACIÓN

  //AGREGAR NUEVO PRODUCTO
  $('#BotonAgregar').click(function() {
      limpiarFormulario()
      $('#ConfirmarAgregar').show();
      $('#ConfirmarModificar').hide();
      $( "#modal-titulo" ).html("Actualizar Stock");
      $("#FormularioArticulo").modal('show');
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
      cantidad: $('#cantidad').val(),
    };
    return registro;
  }


      

  $('#ConfirmarModificar').click(function() {
    
    $("#FormularioArticulo").modal('hide');
    let registro = recuperarDatosFormulario();
    modificarRegistro(registro);
  });

  $('#tablaarticulos tbody').on('click', '#botonmodificar', function() {
    limpiarFormulario();
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
  $('#cantidad').val('');
  $('#agregar').val('');
  $('#stock').val('');
}

 //FUNCIONES PARA COMUNICARSE CON EL SERVIDOR
  function recuperarRegistro(codigo) {
          $.ajax({
            type: 'GET',
            url: '<?php echo base_url('stock/detalle?id=') ?>' + codigo,
            dataType: "json",
            data: '',
            success: function(data) {
              $('#modal-titulo').html(data[0].producto.nombre);
              $('#id').val(data[0].producto.producto_id);
              $('#codigo').val(data[0].producto.codigo);
              $('#nombre').val(data[0].producto.nombre);
              $('#cantidad').val(data[0].producto.cantidad);
              $('#stock').val(data[0].producto.cantidad);
              $("#FormularioArticulo").modal('show');
            },
            error: function() {
              alert("Hay un problema");
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
            url: '<?php echo base_url('stock/update') ?>',
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
    $(function(){
        $("#codigo").autocomplete({
            source: "<?php echo base_url('ventas/autoproducto') ?>",
            minLength: 3,
            select: function (event,ui){
                event.preventDefault();
                $("#codigo").val(ui.item.value);
            }
        });

    });
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
