<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}

	//Se obtienen los datos del alumno enviado por URL	----------------->

	require_once "./controladores/alumnoControlador.php";
	$insAlumno= new alumnoControlador();
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
	  		<a href="<?php echo SERVERURL; ?>admin/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ALUMNO
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>adminlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ALUMNOS
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>adminsearch/" class="btn btn-primary">
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
			<form action="<?php echo SERVERURL; ?>ajax/alumnoAjax.php" method="POST" data-form=<?php if(isset($campos['AlumnoNombre'])){echo 'Update';}else{echo 'Save';} ?> class="FormularioAjax">
				<input type="hidden" name="agregarActualizar"value="<?php if(isset($campos['AlumnoNombre'])){echo "Actualizar";}else{echo "Agregar";} ?>">
				<input type="hidden" name="AlumnoCodigo" value="<?php echo $datos[1]; ?>">
				<fieldset>
					<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombres *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}" class="form-control" type="text" name="AlumnoNombre" required="" maxlength="70" value="<?php if(isset($campos['AlumnoNombre'])){ echo $campos['AlumnoNombre'];} ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
										<label class="control-label">Apellidos *</label>
										<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}" class="form-control" type="text" name="AlumnoApellido" required="" maxlength="70">
								</div>
							</div>
							<div class="col-xs-12 col-sm-4" id="datecontainer">
								<div class="form-group label-floating">										
									<div class="input-group date">											
										<label class="control-label">Fecha de nacimiento *</label>
										<input class="form-control" name="AlumnoFechaNac" value="<?php if(isset($campos['AlumnoFechaNac'])){ echo $campos['AlumnoFechaNac'];} ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>
							</div>			
							<div class="col-xs-12 col-sm-4">
								<div class="form-group label-floating">
										<label class="control-label">Teléfono</label>
										<input pattern="[0-9+]{1,10}" class="form-control" type="text" name="AlumnoTelefono" maxlength="15">
								</div>
							</div>
							<div class="col-xs-12 col-sm-4">
								<div class="form-group label-floating">
										<label class="control-label">E-mail</label>
										<input class="form-control" type="email" name="AlumnoEmail" maxlength="50">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
										<label class="control-label">Universidad</label>
										<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,100}" class="form-control" type="text" name="AlumnoUniversidad" maxlength="15">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
										<label class="control-label">Carrera</label>
										<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,100}" class="form-control" type="text" name="AlumnoCarrera" maxlength="50">
								</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
										<label class="control-label">Semestre</label>
										<input class="form-control" pattern="[0-9]{1,2}" type="text" name="AlumnoSemestre" maxlength="50">
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