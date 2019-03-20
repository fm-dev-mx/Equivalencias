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
	$url=explode("/", $_GET['views']);
	$codigoUni=$url[1];
	if(isset($codigoUni)){
		$datosUniv=$insUniv->datos_universidad_controlador($codigoUni);
		if($datosUniv->rowCount()==1){
			$camposUniv=$datosUniv->fetch();
		}
	}
?>


<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ADVANCED SELECT
                                <small>Taken from <a href="https://silviomoreto.github.io/bootstrap-select/" target="_blank">silviomoreto.github.io/bootstrap-select</a></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-3">
                                    <p>
                                        <b>Basic</b>
                                    </p>
                                    <select class="form-control show-tick">
                                        <option>Mustard</option>
                                        <option>Ketchup</option>
                                        <option>Relish</option>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <p>
                                        <b>With OptGroups</b>
                                    </p>
                                    <select class="form-control show-tick">
                                        <optgroup label="Picnic">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </optgroup>
                                        <optgroup label="Camping">
                                            <option>Tent</option>
                                            <option>Flashlight</option>
                                            <option>Toilet Paper</option>
                                        </optgroup>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <p>
                                        <b>Multiple Select</b>
                                    </p>
                                    <select class="form-control show-tick" multiple>
                                        <option>Mustard</option>
                                        <option>Ketchup</option>
                                        <option>Relish</option>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <p>
                                        <b>With Search Bar</b>
                                    </p>
                                    <select class="form-control show-tick" data-live-search="true">
                                        <option>Hot Dog, Fries and a Soda</option>
                                        <option>Burger, Shake and a Smile</option>
                                        <option>Sugar, Spice and all things nice</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3">
                                    <p>
                                        <b>Max Selection Limit: 2</b>
                                    </p>
                                    <select class="form-control show-tick" multiple>
                                        <optgroup label="Condiments" data-max-options="2">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </optgroup>
                                        <optgroup label="Breads" data-max-options="2">
                                            <option>Plain</option>
                                            <option>Steamed</option>
                                            <option>Toasted</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <p>
                                        <b>Display Count</b>
                                    </p>
                                    <select class="form-control show-tick" multiple data-selected-text-format="count">
                                        <option>Mustard</option>
                                        <option>Ketchup</option>
                                        <option>Relish</option>
                                        <option>Onions</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <p>
                                        <b>With SubText</b>
                                    </p>
                                    <select class="form-control show-tick" data-show-subtext="true">
                                        <option data-subtext="French's">Mustard</option>
                                        <option data-subtext="Heinz">Ketchup</option>
                                        <option data-subtext="Sweet">Relish</option>
                                        <option data-subtext="Miracle Whip">Mayonnaise</option>
                                        <option data-divider="true"></option>
                                        <option data-subtext="Honey">Barbecue Sauce</option>
                                        <option data-subtext="Ranch">Salad Dressing</option>
                                        <option data-subtext="Sweet &amp; Spicy">Tabasco</option>
                                        <option data-subtext="Chunky">Salsa</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <p>
                                        <b>Disabled Option</b>
                                    </p>
                                    <select class="form-control show-tick">
                                        <option>Mustard</option>
                                        <option disabled>Ketchup</option>
                                        <option>Relish</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




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
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp;<?php echo "<b>".strtoupper($camposUniv['UniversidadNombre'])."</b>"." - ";?> LISTA DE CARRERAS</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insUniv->paginador_carrera_controlador($pagina[2],3,$_SESSION['privilegio_sbp'],"");
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