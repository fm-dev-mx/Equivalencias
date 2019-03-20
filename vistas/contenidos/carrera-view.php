<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-bookmark zmdi-hc-fw"></i> Administración <small>Carreras</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/carreraControlador.php";
	$insUniv= new carreraControlador();
	$datos=explode("/", $_GET['views']);
	
	if(isset($datos[1])){
		$tipo="Unico";
		$filesUniv=$insUniv->datos_carrera_controlador($tipo,$datos[1]);
		if($filesUniv->rowCount()==1){
			$campos=$filesUniv->fetch();
		}
	}
?>

<div class="container-fluid">
	
		<div class="panel-body">
			<form action="<?php echo SERVERURL; ?>ajax/carreraAjax.php" method="POST" data-form=<?php if(isset($campos['UniversidadNombre'])){echo 'Update';}else{echo 'Save';} ?> class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<input class="form-control" type="hidden" name="agregarActualizar" maxlength="170" value="<?php if(isset($campos['CarreraNombre'])){echo "Actualizar";}else{echo "Agregar";} ?>">
					<input class="form-control" type="hidden" name="codigoUniversidad" value="<?php echo $datos[1]; ?>">
		    		<div class="container-fluid">
		    			<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
									<label class="control-label">Nombre de la carrera</label>
									<input class="form-control" type="text" name="nombre" required="" maxlength="170" value="<?php if(isset($campos['CarreraNombre'])){ echo $campos['CarreraNombre'];} ?>">
									<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Agregar</button>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				
			<div class="RespuestaAjax"></div>					
			</form>
		</div>
	
</div>


<?php 
	require_once "./controladores/carreraControlador.php";
	$insUniv= new carreraControlador();
?>

<!-- Panel listado de carreras -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CARRERAS</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insUniv->paginador_carrera_controlador($pagina[1],10,$_SESSION['privilegio_sbp'],"");
			?>	
		</div>
	</div>
</div>


<!--Ventana emergente para renombrar carrera-->

<form action="<?php echo SERVERURL; ?>ajax/carreraAjax.php" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="ren-carrera-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Renombrar carrera</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="CarreraCodigoUpdate" name="CarreraCodigoUpdate" hidden="">
					<input type="text" id="CarreraPrivilegioUpdate" name="CarreraPrivilegioUpdate" hidden="">
					<input type="text" id="CarreraNombreUpdate" name="CarreraNombreUpdate" class="form-control input">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>

</body>
</html>