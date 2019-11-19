<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
		<h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Estudiante <small>Materias</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/universidadControlador.php";
	$insUniv= new universidadControlador();
	require_once "./controladores/carreraControlador.php";
	$insCarrera= new carreraControlador();
	require_once "./controladores/alumnoControlador.php";
	$insAlumno= new alumnoControlador();
	require_once "./controladores/materiaControlador.php";
	$insMateria= new materiaControlador();
	require_once "./controladores/alumnoMateriaControlador.php";
	$insAlumnoMateria= new alumnoMateriaControlador();

	$url=explode("/", $_GET['views']);	

	//Se obtiene un array con los datos del alumno seleccionado
	if($url[1]!=""){
		$datosAlumno=$insAlumno->datos_alumno_controlador("Unico",$url[1]);
		if($datosAlumno->rowCount()==1){
			$camposAlumno=$datosAlumno->fetch();
		}
	}

	//Se obtiene un array con las materias cursadas por el alumno
	if($url[1]!=""){
		$datosAlumnoMateria=$insAlumnoMateria->obtener_materias_controlador($url[1]);
		if($datosAlumnoMateria->rowCount()>=1){
			$materiasCursadas=$datosAlumnoMateria->fetchAll();
		}
	}

	//Se obtiene un array con los nombres de todas las universidades (para datos del alumno)
	$listaUniv=$insUniv->datos_universidad_controlador("Lista","");
	if($listaUniv->rowCount()>=1){
		$listaUniversidad=$listaUniv->fetchAll();
	}

	//Se obtiene un array con los nombres de todas las carreras (para datos del alumno)
	$listaC=$insCarrera->datos_carrera_controlador("Lista","");
	if($listaC->rowCount()>=1){
		$listaCarrera=$listaC->fetchAll();
	}

	//Se obtiene un array con los nombres de todas las materias (para la lista desplegable)
	$listaM=$insMateria->datos_materia_controlador("Lista","",$camposAlumno['AlumnoCarrera']);
	if($listaM->rowCount()>=1){
		$listaMateria=$listaM->fetchAll();
	}
?>


<style>
	.container {
		box-sizing: border-box;;
		margin: auto;
		max-width: 1200px;
		padding: 20px 20px;
		width: 100%;
	}
</style>

<!-- Panel listado de materias -->
<div class="panel-body">
	<form action="<?php echo SERVERURL; ?>ajax/alumnoMateriaAjax.php" method="POST" data-form='SaveMaterias' class="FormularioAjax" enctype="multipart/form-data">			
		<fieldset>					
			<div class="container">
				<input type="hidden" name="CodigoAlumno" value="<?php echo $camposAlumno['AlumnoCodigo']; ?>">				
				<input type="hidden" name="ListadoMaterias" value=1>				
				<select multiple="multiple" name="multiSelectMaterias[]">
					<?php foreach($listaMateria as $rows){
							$banMat=0;
							foreach($materiasCursadas as $rowMat){
								if(($rows['MateriaCodigo']==$rowMat['CodigoMateria']) && $rowMat['EstatusMateria']==1){ 
									$banMat=$banMat+1;
								}
							} 
							if($banMat>=1){ ?>
								<option value="<?php echo $rows['MateriaCodigo'];?>" class="selected-wrapper" selected="true">
									<?php echo $rows['MateriaNombre'];?>
								</option>	<?php
							}else{ ?>
								<option value="<?php echo $rows['MateriaCodigo'];?>" class="selected-wrapper">
									<?php echo $rows['MateriaNombre'];?>
								</option>	<?php
							}
						} ?>	
				</select>
			</div>		
		</fieldset>
		
		<div style="text-indent:60px;">
			<legend>Datos del estudiante</legend>				
			<div style="text-indent:70px;">
				<p>
					<b>Nombre: </b> 
						<?php
							echo $camposAlumno['AlumnoNombre'].' '.$camposAlumno['AlumnoApellido'];
						?>
				</p>
				<p>
				<b>Universidad: </b> 
						<?php foreach($listaUniversidad as $rows){
							if($rows['UniversidadCodigo']==$camposAlumno['AlumnoUniversidad'])	
							echo $rows['UniversidadNombre'];					
						} ?>			
				</p>
				<p>
					<b>Carrera: </b> 
						<?php 
							foreach($listaCarrera as $rows){
							if($rows['CarreraCodigo']==$camposAlumno['AlumnoCarrera'])	
							echo $rows['CarreraNombre'];					
						} ?>			
						
				</p>
				<p>
					<b>Semestre: </b> 
						<?php
							echo $camposAlumno['AlumnoSemestre'].'to sem';
						?>
				</p>				    	
			</div>				
		</div>		
						
		<!--Boton guardar / ver materias - guardar---------------------------------------------------------->
		<div id="divBotonGuardar"></div>
		<div class="RespuestaAjax"></div>
	</form>
</div>

<!--Ventana emergente para agregar materia-->
<div class="modal-body">
	<form action="<?php echo SERVERURL; ?>ajax/materiaAjax.php" method="POST" data-form='saveModalMateria' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<div class="modal fade" id="agregar-materia-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Agregar materia</h4>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
									<input type="text" name="codigoCarreraAgregarMateria" value="<?php echo $camposAlumno['AlumnoCarrera'];?>" hidden="false">
									<label class="control-label">Nombre</label>
									<input class="form-control" type="text" name="nombreMateriaAgregar" required="" maxlength="170">
								</div>
							</div>						
						</div>
					</div>

					<p class="text-center" style="margin-top: 20px;">
						<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Agregar</button>
					</p>

				</div>	
			</div>
		<div class="RespuestaAjax"></div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('select').multi({
			search_placeholder: 'Busca las materias cursadas por el alumno',
		});
		boton_ver_equivalencias();
	});

	function boton_ver_equivalencias(){
		$.ajax({
			type:"POST",
			url:"<?php echo SERVERURL; ?>ajax/alumnoMateriaAjax.php",
			data:"MateriasCursadasBtn=<?php echo $datosAlumnoMateria->rowCount();?>&CodigoAlumnoBtn=<?php echo $camposAlumno['AlumnoCodigo'];?>",
			success:function(r){				
				$('#divBotonGuardar').html(r);
			}
		});
	}
</script>                
