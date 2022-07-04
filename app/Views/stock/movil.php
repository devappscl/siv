<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
        <h1 class="mt-4">Recuento</h1>
        <a href="<?php echo base_url('stock/'); ?>" class="btn btn-primary btn-sm">Volver</a>
        <hr>

        
            
                
            <fieldset class="form-group">
                <label>Código</label>
                <input type="text" name="codigo" id="codigo" value="" class="form-control" autofocus="true">
                <input type="hidden" name="id" id="id" value="" >
            </fieldset>

            <fieldset class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" value="" class="form-control" >
            </fiseldset>


            <fieldset class="form-group">
                <label>Stock</label>
                <input type="text" name="cantidad" id="cantidad" value="" class="form-control" >
            </fiseldset>

        <fieldset>
            <br>
          <button type="button" id="ConfirmarModificar" class="btn btn-primary" visible="false">Guardar</button>
        </fieldset>
            

        
     
    </div>
   </main>



   <script type="text/javascript">

     


    $(function(){
      limpiarFormulario();
        $("#codigo").autocomplete({
            source: "<?php echo base_url('stock/autoproducto') ?>",
            minLength: 3,
            select: function (event,ui){
                event.preventDefault();

                $('#button').show();
                $("#nombre").show();
                $("#cantidad").show();
               
                $("#codigo").val(ui.item.label);
                $("#id").val(ui.item.id);
                $("#nombre").val(ui.item.nombre);
                $("#cantidad").val(ui.item.cantidad);
               
               
            }
        });

    });

    $('#ConfirmarModificar').click(function() {
      let registro = recuperarDatosFormulario();
      modificarRegistro(registro);
      limpiarFormulario();
  });

  // LIMPIAR EL FORMULARIO
function limpiarFormulario() {
    $("#codigo").val("");
    $('#button').hide();
     $("#nombre").hide();
     $("#cantidad").hide();
     $("#codigo").focus();
}

  //DEVOLVER DATOS DEL FORMULARIO A PROCESAR
  function recuperarDatosFormulario() {
    let registro = {
      id: $('#id').val(),
      cantidad: $('#cantidad').val(),
    };
    return registro;
  }

     //AJAX MODIFICAR REGISTRO
  function modificarRegistro(registro) {
          $.ajax({
            type: 'POST',
            url: '<?php echo base_url('stock/update') ?>',
            data: registro,
            success: function(msg) {
                alert("Actualizado");
            },
            error: function() {
              alert("Hay un problema");
            }
          });
        }



</script>