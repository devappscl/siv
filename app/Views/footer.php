<div class="modal" id="recordatorio" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Recordatorio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Recuerde ingresar ventas al sistema para mantener actualizado el inventario.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function() {	
    function Recordatorio() {
        $('#recordatorio').modal({show:true});
    }
    setInterval(Recordatorio, 1800000);
});
</script>

<footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; <?php echo APP_NAMEAPP ?></div>
                            <div>
                            <span class="badge bg-success text-light">Rev.1.5.22</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
        <script src="<?php echo base_url("/js/bootstrap.bundle.min.js"); ?>" ></script>
        <script src="<?php echo base_url("/js/scripts.js"); ?>"></script>
        <script src="<?php echo base_url("/js/jquery.dataTables.min.js"); ?>"></script>
        <script src="<?php echo base_url("/js/dataTables.bootstrap4.min.js"); ?>"></script>
        


        

    </body>
</html>

