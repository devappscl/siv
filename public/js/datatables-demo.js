$(document).ready(function() {
  var table = $('#dataTable').DataTable({
      
      "scrollX": true,
      "scrollY": "50vh",
      //Esto sirve que se auto ajuste la tabla al aplicar un filtro
       "scrollCollapse": true,
   
      language: {
          "decimal": "",
          "emptyTable": "No hay información",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
          "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
          "infoFiltered": "(Filtrado de _MAX_ total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Entradas",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
          }
      },
      
     
      "aoColumnDefs": [
       { "bSearchable": false, "aTargets": [ 1 ] }
     ] 
    
  });
  //********Esta bendita linea hace la magia, adjusta el header de la tabla con el body 
  table.columns.adjust();

});

