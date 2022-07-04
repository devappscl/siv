<div id="layoutSidenav_content">
  
  <main>
    
    <div class="container-fluid">

    <div class="row bg-dark mt-2 p-1">
                <div class="col-md-2">
                  <?php if(session('rol') == '777' or session('rol') == '7'): ?>
                    <a href="<?php echo base_url(); ?>" class="btn btn-primary" title="INICIO" ><i class="fas fa-home"></i></a>
                    <button class="btn btn-success" id="BotonAgregar" title="NUEVO PRODUCTO"><i class="fas fa-plus-circle"></i></button>
                    <a href="<?php echo base_url('productos/pcompuesto') ?>" class="btn btn-warning" title="NUEVO PRODUCTO COMPUESTO"><i class="fas fa-boxes"></i></a>
             
                  <?php endif ?> 
                </div>
                <div class="col-md-10">
                    <h3 class="text-light"><?php echo $titulo; ?></h3>
                </div>
           </div>
        

      <!-- MENSAJE -->
      <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success" role="alert" id="msg">
          <?php echo session()->getFlashdata('msg') ?>
        </div>
      <?php endif ?>

      
                     
      <div class="table-responsive mt-2">
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
          
            <fieldset class="form-group">
                <div class="input-group ">   
                  <div class="input-group-prepend">
                      <div class="input-group-text"><span class="fas fa-fw fa-barcode"></span></div>
                  </div>
                  
                  <input type="hidden" id="id" name="id" >
                  <input type="text" id="codigo" name="codigo" class="form-control form-control-lg" autofocus="true" required placeholder="CÓDIGO DEL PRODUCTO">
                </div>
               
                </fieldset>
              
            

            <fieldset class="form-group">
                <textarea class="form-control form-control-lg" id="nombre"  name="nombre" rows="2" cols="80" required placeholder="NOMBRE DEL PRODUCTO"></textarea>
            </fieldset>


            <fieldset class="form-group">

          
              <div class="input-group ">   
                  <select name="proveedor" id="proveedor" class="form-control form-control-lg">
                  </select>
                  <div class="input-group-prepend">
                    <a href="<?php echo base_url("proveedores/add") ?>" class="btn btn-success"><i class="fas fa-plus-circle"></i></a>
                  </div>
              </div>

             
                 
            </fieldset>

            <fieldset>
            <div class="input-group ">   
                  <select name="categoria" id="categoria" class="form-control form-control-lg">
                  </select>
                  <div class="input-group-prepend">
                    <a href="<?php echo base_url("categorias/add") ?>" class="btn btn-success"><i class="fas fa-plus-circle"></i></a>
                  </div>
              </div>
            </fieldset>

            
            <hr>

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
            <div  class="col-md-3">
              <label>Precio Compra</label>
              <input type="text" id="pcompra" name="pcompra" class="form-control form-control-lg" onkeyup="PasarValor();" required>
            </div>
            <div  class="col-md-3">
              <label>% Margen de Ganancia</label>
              <input type="text" id="margen" name="margen" value="30" class="form-control form-control-lg" onchange="PasarValor();" required>
            </div>
            <div  class="col-md-3">
              <label id="margenganancia">Precio Venta Sugerido</label>
              <input type="text" id="psugerido" name="psugerido" class="form-control form-control-lg" disabled>
            </div>
            <div  class="col-md-3">
              <label>Precio Venta</label>
              <input type="text" id="pventa" name="pventa" class="form-control form-control-lg" required>
            </div>
          </div>
        </fieldset>

        <hr>
              <div class="text-right">
                <button class="btn btn-primary btn-sm" id="mostrar"><i class="fas fa-cog"></i> MOSTRAR CONFIGURACIÓN AVANZADA</button>
                <button class="btn btn-danger btn-sm" id="ocultar"> <i class="fas fa-cog"></i> OCULTAR CONFIGURACIÓN AVANZADA</button>
              </div>
              <div id="target">
              <hr>
              <fieldset class="form-group">
              
              <div class="row">

                <div class="col-md-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                        ACTIVO
                      </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                        MOSTRAR EN CATÁLOGO DE VENTAS
                      </label>
                    </div>
                </div>

                <div class="col-md-12">
                  <br>
                  <h3>LISTA DE PRODUCTOS</h3>
                  <table>
                    <thead>
                      <th>ID</th>
                      <th>NOMBRE</th>
                      <th>CANTIDAD</th>
                      <th>PRECIO NORMAL</th>
                      <th>PRECIO VENTA</th>
                    </thead>
                  </table>
                </div>

               
              </div>
              
              
              </fieldset>

             

              </div>
              <br>
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

 document.addEventListener("DOMContentLoaded", function() {
        
  let tabla1 = $(".dataTable").DataTable({
      "ajax": {
      url: "<?php echo base_url('productos/datatables'); ?>",
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

      "pageLength": 25,
      "order": [[ 4, "asc" ]]

  });

  
  //EVENTOS DE LA APLICACIÓN

  //AGREGAR NUEVO PRODUCTO
  $('#BotonAgregar').click(function() {
      limpiarFormulario()
      $('#ConfirmarAgregar').show();
      $('#ConfirmarModificar').hide();
      $( "#modal-titulo" ).html("NUEVO PRODUCTO");
      $("#FormularioArticulo").modal('show');
      cargaProveedores();
      cargaCategorias();
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
      categoria: $('#categoria').val(),
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
  $('#proveedor').empty();
  $('#categoria').empty();
  $('#actualizado').html('');
}

 //FUNCIONES PARA COMUNICARSE CON EL SERVIDOR
  function recuperarRegistro(codigo) {
    limpiarFormulario()
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
              cargaCategorias(data[0].producto.categoria);    
                
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

  function cargaCategorias(cat){
    
    $.ajax({
	    	type: "GET",
	    	url: '<?php echo base_url('productos/categoriasid') ?>', 
	    	dataType: "json",
	    	success: function(data){
	    		
          $(data).each(function(i, v){ // indice, valor
             $("#categoria").prepend('<option value="' + v.id + '">' + v.nombre + '</option>');
          });

          $("#categoria option[value="+ cat +"]").attr("selected",true);

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

            $('#ocultar').hide(); //muestro mediante clase
            $('#target').hide();

            $("#mostrar").on( "click", function() {
              $('#target').show(); //muestro mediante id
              $('#mostrar').hide(); //muestro mediante clase
              $('#ocultar').show(); //muestro mediante clase
             });

            $("#ocultar").on( "click", function() {
              $('#target').hide(); //oculto mediante id
              $('#mostrar').show(); //muestro mediante clase
              $('#ocultar').hide(); //muestro mediante clase
            });
        });
        
    </script>

    
   <script type="text/javascript">
        function PasarValor()
            {
              var margen = 1 + document.getElementById("margen").value / 100;
              document.getElementById("margenganancia").innerHTML = "Precio Venta al " + document.getElementById("margen").value + "%";
            document.getElementById("psugerido").value = document.getElementById("pcompra").value * margen;

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