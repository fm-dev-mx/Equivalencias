<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>Universidades</small></h1>
	</div>
	<p class="lead"></p>
</div>

<div class="container-fluid">
<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>univ/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; AGREGAR INSTITUTO
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>univList/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE INSTITUTOS
	  		</a>
	  	</li>
		<li>
	  		<a href="<?php echo SERVERURL; ?>univSearch/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; BUSCAR INSTITUTOS
	  		</a>
	  	</li>  
	</ul>
</div>

<?php 
	require_once "./controladores/universidadControlador.php";
	$insUniv= new universidadControlador();
	$datos=explode("/", $_GET['views']);
	
	if(isset($datos[1])){
		$tipo="Unico";
		$filesUniv=$insUniv->datos_universidad_controlador($tipo,$datos[1]);

		if($filesUniv->rowCount()==1){
			$campos=$filesUniv->fetch();
		}
	}

?>

<!-- panel datos de la empresa -->
<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DE LA UNIVERSIDAD</h3>
		</div>
		<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/universidadAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp;</legend>
		    		<div class="container-fluid">
		    			<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Nombre del instituto *</label>
								  	<input class="form-control" type="text" name="nombreUniversidad-reg" maxlength="170" value="<?php $campos['UniversidadNombre'];?>">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Iniciales *</label>
								  	<input class="form-control" type="text" name="iniciales-reg" maxlength="15">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Pais *</label>
								  	<input class="form-control" type="text" name="pais-reg" maxlength="15">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Estado *</label>
								  	<input class="form-control" type="text" name="estado-reg" maxlength="15">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Ciudad *</label>
								  	<input class="form-control" type="text" name="ciudad-reg" maxlength="15">
								</div>
		    				</div>
		    				<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Dirección</label>
								  	<input class="form-control" type="text" name="direccion-reg" maxlength="170">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Teléfono</label>
								  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="50">
								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
			    <p class="text-center" style="margin-top: 20px;">
			    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
			    </p>
					<div class="RespuestaAjax"></div>
		    </form>
		</div>
	</div>
</div>