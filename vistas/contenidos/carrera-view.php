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
	require_once "./controladores/universidadControlador.php";
	$insUniv= new universidadControlador();
	$url=explode("/", $_GET['views']);
	$codigoUni=$url[1];
	
	//Se obtiene un array con los datos de la universidad seleccionada
	$tipoConsulta="Unico";
	if(isset($codigoUni)){
		$datosUniv=$insUniv->datos_universidad_controlador($tipoConsulta,$codigoUni);
		if($datosUniv->rowCount()==1){
			$camposUniv=$datosUniv->fetch();
		}
	}

	//Se obtiene un array con los nombres de todas las universidades (para la lista desplegable)
	$tipoConsulta="Lista";
	$listaU=$insUniv->datos_universidad_controlador($tipoConsulta,$codigoUni);
	if($listaU->rowCount()>=1){
		$listaUniv=$listaU->fetchAll();
	}
?>

<div class="container-fluid">
	<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/carreraAjax.php" method="POST" data-form="Save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
			<fieldset>
				<input class="form-control" type="hidden" name="codigoUniAgregarCarrera" value="<?php echo $codigoUni; ?>">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group label-floating">
								<label class="control-label">Agregar nueva carrera</label>
								<input class="form-control" type="text" name="nombreCarreraAgregar" required="" maxlength="170">
							</div>
						</div>
					</div>
				</div>
				<table style="border: hidden" class="table text-center">
					<tr>
						<th class="text-left">
							<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Agregar</button>
						</th>
						<th class="text-center">
							<select class="selectpicker" data-live-search="true">
							<!--listado de universidades - se valida con el url la que fue seleccionada-->
								<?php foreach($listaUniv as $rows){ ?> 
									<option data-tokens="<?php echo $lc->encryption($rows['UniversidadCodigo']);?>" <?php if($codigoUni==$lc->encryption($rows['UniversidadCodigo'])){echo ' selected';} ?>>
										<?php echo $rows['UniversidadNombre'];?>
									</option>								
								<?php } ?>	
							</select>
						</th>
					</tr>
				</table>			
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
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp;<?php echo "<b>".strtoupper($camposUniv['UniversidadNombre'])."</b>"." - ";?> LISTA DE CARRERAS</h3>
		</div>
		<div class="panel-body">
			<?php 
				if(isset($url[2])){
					$pagina=$url[2];
				}else{
					$pagina=1;
				}
				echo $insUniv->paginador_carrera_controlador($pagina,3,$_SESSION['privilegio_sbp'],"");
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



<!-- PARA QUE FUNCIONE EL BUSCADOR DE UNIVERSIDADES---------------------------------------------------------------- -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/i18n/defaults-*.min.js"></script>