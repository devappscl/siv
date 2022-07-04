<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
       
            <div class="row">
                <div class="col-md-12 bg-dark text-center">
                    <h1 class="text-light" style="font-size: 3vw;"><?php echo $titulo; ?></h1>
                </div>
            </div>
            
            <?php  $total = round($total,-1);  ?>
            <form action="<?php echo base_url('ventas/pagar') ?>" method="post">

            <div class="row mt-2 mb-2">
                <div class="col-md-6">
                    <label for="">TIPO DE PAGO</label>
                        <select name="formapago" id="" class="form-control form-control-lg">
                            <option value="efectivo">EFECTIVO</option>
                            <option value="debito">REDCOMPRA DEBITO</option>
                            <option value="credito">REDCOMPRA CREDITO</option>
                            <option value="transferencia">TRANSFERENCIA</option>
                            <option value="valeconsumo">VALE CONSUMO</option>
                        </select>
                </div>
                <div class="col-md-6">
                        <label for="">SUB TOTAL</label>
                        <input type="text" id="subtotal" class="form-control form-control-lg" value="<?php echo $total; ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="">EFECTIVO</label>
                    <input type="text" id="efectivo" class="form-control form-control-lg" value="<?php echo $total; ?>"   onchange="CalculaVuelto();" required autofocus>
                </div>

                <div class="col-md-6">
                    <label for="">% DESCUENTO</label>
                    <input type="number" id="dscto" value="0" readonly="true" class="form-control form-control-lg" required  onchange="CalculaDescuento();">
                </div>

                <div class="col-md-6">
                    <label for="">TOTAL</label>
                    <input type="text" id="total" class="form-control form-control-lg" value="<?php echo $total; ?>" autofocus  onchange="CalculaVuelto();" required>
                </div>

                <div class="col-md-6">
                    <label for="">VUELTO</label>
                    <input type="text" id="vuelto" class="form-control form-control-lg" value="0" readonly>
                </div>

                <div class="col-md-12 text-right p-3">
                    <button type="submit" class="btn btn-success btn-lg" >PAGAR</button>
                    <a href="<?php echo base_url('ventas/') ?>" class="btn btn-danger btn-lg">VOLVER</a>
                </div>

            </div>
       

            </form>

           
        
    
        


</main>
 
 


 
  

   <script type="text/javascript">
       function CalculaVuelto()
       {
         document.getElementById("vuelto").value = document.getElementById("efectivo").value - document.getElementById("total").value;
         Math.ceil(document.getElementById("vuelto").value);
         CalculaDescuento()

        }

        function CalculaDescuento(){
            
            var dscto = (document.getElementById("dscto").value / 100);
            var tdescuento = document.getElementById("subtotal").value * dscto;
            var total = 0;

            document.getElementById("total").value = document.getElementById("subtotal").value - tdescuento;

            total = document.getElementById("total").value;

            Math.ceil(total);

            document.getElementById("total").value = total;

            CalculaVuelto();
            
        }


 </script>


