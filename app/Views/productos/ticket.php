<?php echo header('Content-type: application/pdf'); ?>
<div id="layoutSidenav_content">
        <main>
           <div class="container-fluid">
<div class="row">

	<div class="col-xs-8 col-sm-8 col-md-8">
		<div class="panel">
			<div class="embed-responsive embed-responsive-4by3" style="margin-top: 30px;">
				<iframe class="embed-responsive-item" src="<?php echo base_url('productos/verticket/' . $proveedor) ?>"></iframe>
			</div>
		</div>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4" style="padding-top:30px;">
		
		<a href="<?php echo base_url('/proveedores') ?>"><button class="btn btn-success">Volver a Proveedores</button></a>
	</div>
</div>
</div>
</main>

