<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}

	//Se obtienen los datos del alumno enviado por URL	----------------->

	require_once "./controladores/alumnoControlador.php";
	require_once "./controladores/universidadControlador.php";	
	$insAlumno= new alumnoControlador();
	$insUniv= new universidadControlador();
	
	$datos=explode("/", $_GET['views']);
	if(isset($datos[1])){
		$tipo="Unico";
		$filesAlumno=$insAlumno->datos_alumno_controlador($tipo,$datos[1]);
		if($filesAlumno->rowCount()==1){
			$campos=$filesAlumno->fetch();
		}
	}	
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Alumno <small>REGISTRAR DATOS</small></h1>
	</div>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>alumno/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ALUMNO
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>alumnoList/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ALUMNOS
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>alumnoSearch/" class="btn btn-primary">
	  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ALUMNO
	  		</a>
	  	</li>
	</ul>
</div>

<!-- Panel nuevo alumno -->
<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ALUMNO</h3>
		</div>

		<div class="panel-body">
			<form action="<?php echo SERVERURL; ?>ajax/alumnoAjax.php" method="POST" data-form=<?php if(isset($campos['AlumnoNombre'])){echo 'updateAlumno';}else{echo 'saveAlumno';} ?> class="FormularioAjax" enctype="multipart/form-data">			
				<fieldset>					
					<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
					<div class="container-fluid">
						
							<input type="hidden" name="agregarActualizar"value="<?php if(isset($campos['AlumnoNombre'])){echo "Actualizar";}else{echo "Agregar";} ?>">
							<input type="hidden" name="AlumnoCodigo" value="<?php echo $datos[1]; ?>">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombres *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}" class="form-control" type="text" name="AlumnoNombre" required="" maxlength="70" value="<?php if(isset($campos['AlumnoNombre'])){ echo $campos['AlumnoNombre'];} ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
										<label class="control-label">Apellidos *</label>
										<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}" class="form-control" type="text" name="AlumnoApellido" required="" maxlength="70" value="<?php if(isset($campos['AlumnoApellido'])){ echo $campos['AlumnoApellido'];} ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-4" id="datecontainer">
								<div class="form-group label-floating">										
									<div class="input-group date">											
										<label class="control-label datecontainer">Fecha de nacimiento *</label>
										<input class="form-control" name="AlumnoFechaNac" type="date" value="<?php if(isset($campos['AlumnoFechaNac'])){ echo $campos['AlumnoFechaNac'];} ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>
							</div>			
							<div class="col-xs-12 col-sm-4">
								<div class="form-group label-floating">
									<label class="control-label">Teléfono</label>
									<input pattern="[0-9]{10}" class="form-control" type="text" name="AlumnoTelefono" maxlength="10" value="<?php if(isset($campos['AlumnoTelefono'])){ echo $campos['AlumnoTelefono'];} ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-4">
								<div class="form-group label-floating">
									<label class="control-label">E-mail</label>
									<input class="form-control" type="email" name="AlumnoEmail" maxlength="80" value="<?php if(isset($campos['AlumnoEmail'])){ echo $campos['AlumnoEmail'];} ?>">
								</div>
							</div>
								
							<!--listado de universidades ---------------------------------------------------------->
							<div id="divUniSelect"></div>
							<!--listado de carreras (jquery)---------------------------------------------------------->
							<div id="divCarreraSelect"></div>

							<div class="col-xs-12 col-sm-2">
								<div class="form-group label-floating">
									<label class="control-label">Semestre</label>
									<input class="form-control" pattern="[0-9]{1,2}" type="text" name="AlumnoSemestre" maxlength="2" value="<?php if(isset($campos['AlumnoSemestre'])){ echo $campos['AlumnoSemestre'];} ?>">
								</div>
							</div>

					</div>
				</fieldset>
				<br>
				
				
				
					<div class="row">
						<?php if(isset($campos['AlumnoEmail'])){ ?>

							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">										
									<p class="text-right" style="margin-top: 20px;">
										<a href="<?php echo SERVERURL; ?>alumnomateria/<?php echo mainModel::encryption($campos['AlumnoCodigo']); ?>" class="btn btn-default btn-raised btn-sm"><i class="zmdi zmdi-book"></i> Ver Materias</a>
									</p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">						
									<p class="text-left" style="margin-top: 20px;">				
										<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
									</p>
								</div>
							</div>
						<?php }else{ ?>

							<div class="form-group label-floating">						
								<p class="text-center" style="margin-top: 20px;">				
									<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
								</p>
							</div>

						<?php }?>

					</div>
				
				<div class="RespuestaAjax"></div>
			</form>
		</div>
	</div>
</div>


<!--Ventana emergente para agregar universidad-->

<form action="<?php echo SERVERURL; ?>ajax/universidadAjax.php" method="POST" data-form='saveModal' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="agregar-uni-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Agregar instituto</h4>
				</div>
				<input class="form-control" type="hidden" name="agregarActualizar-reg" maxlength="170" value="Agregar">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group label-floating">
								<label class="control-label">Nombre del instituto *</label>
								<input class="form-control" type="text" name="nombreUniversidad-reg" required="" maxlength="170" value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadNombre'];} ?>">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
								<label class="control-label">Iniciales *</label>
								<input class="form-control" type="text" name="iniciales-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadIniciales'];} ?>">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
								<label class="control-label">Pais *</label>
								<input class="form-control" type="text" name="pais-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadPais'];} ?>">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
								<label class="control-label">Estado *</label>
								<input class="form-control" type="text" name="estado-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadEstado'];} ?>">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
								<label class="control-label">Ciudad *</label>
								<input class="form-control" type="text" name="ciudad-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadCiudad'];} ?>">
							</div>
						</div>
						<div class="col-xs-12">
							<div class="form-group label-floating">
								<label class="control-label">Dirección</label>
								<input class="form-control" type="text" name="direccion-reg" maxlength="170" value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadDireccion'];} ?>">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label class="control-label">Tipo de universidad</label>
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPublica" id="optionsRadios1" value="Publica" checked="" <?php if(isset($campos['UniversidadTipo'])){if($campos['UniversidadTipo']=="Publica"){ echo 'checked=""'; }} ?>>
										<i class="zmdi zmdi-male-alt"></i> &nbsp; Pública
									</label>
								</div>
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPublica" id="optionsRadios2" value="Privada" <?php if(isset($campos['UniversidadTipo'])){if($campos['UniversidadTipo']=="Privada"){ echo 'checked=""'; }} ?>>
										<i class="zmdi zmdi-female"></i> &nbsp; Privada
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
								<label class="control-label">Teléfono</label>
								<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="50" value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadTelefono'];} ?>">
							</div>
						</div>
		    		</div>
				</div>

				<p class="text-center" style="margin-top: 20px;">
					<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Agregar</button>
				</p>

			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>

<!--Ventana emergente para agregar carrera-->

<form action="<?php echo SERVERURL; ?>ajax/carreraAjax.php" method="POST" data-form='saveModalCarrera' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="agregar-carrera-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Agregar carrera</h4>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group label-floating">
								<label class="control-label">Nombre</label>
								<input class="form-control" type="text" name="nombreAlumnoCarrera" required="" maxlength="170">
							</div>
						</div>						
		    		</div>
				</div>

				<p class="text-center" style="margin-top: 20px;">
			    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Agregar</button>
			    </p>

			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>

<script type="text/javascript">
	$(document).ready(function(){		
		$('#uniSelect').select2();
		recargarUniversidad();		
		recargarCarrera();		
		$('span.select2-selection.select2-selection--single span#select2-uniSelect-container.select2-selection__rendered').css('color','#999');		
	});
	
	function recargarUniversidad(){
		$.ajax({
			type:"POST",
			url:"<?php echo SERVERURL; ?>ajax/universidadAjax.php",
			data:"codigoUniEditar=<?php if(isset($campos["AlumnoUniversidad"])){echo $campos["AlumnoUniversidad"];}else{echo "";}?>",
			success:function(r){				
				$('#divUniSelect').html(r);
			}
		});
	}

	function recargarCarrera(){
		var uniSelect=<?php if(isset($campos['AlumnoUniversidad'])){echo "\"".$campos['AlumnoUniversidad']."\"";}else{echo '$("#uniSelect").val()';}?>;
		$.ajax({
			type:"POST",
			url:"<?php echo SERVERURL; ?>ajax/carreraAjax.php",
			data:"alumnoUniSelect="+uniSelect+"&codigoCarreraEditar=<?php if(isset($campos['AlumnoCarrera'])){echo $campos['AlumnoCarrera'];}?>",
			success:function(r){				
				$('#divCarreraSelect').html(r);
			}
		});
	}

</script>