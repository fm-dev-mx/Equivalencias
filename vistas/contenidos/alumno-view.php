<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
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
			<form action="<?php echo SERVERURL; ?>ajax/alumnoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-5">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Nombres *</label>
								  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
									</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-5">
									<div class="form-group label-floating">
											<label class="control-label">Apellidos *</label>
											<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-reg" required="" maxlength="30">
									</div>
								</div>
								<div class="col-xs-12 col-sm-2" id="datecontainer">
									<div class="form-group label-floating">										
										<div class="input-group date">											
											<label class="control-label">Fecha de nacimiento *</label>
											<input class="form-control" name="PacienteFechaNac" value="<?php if(isset($campos['PacienteFechaNac'])){ echo $campos['PacienteFechaNac'];} ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>
									</div>
								</div>			
		    				<div class="col-xs-12 col-sm-4">
									<div class="form-group label-floating">
											<label class="control-label">Teléfono</label>
											<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="15">
									</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
											<label class="control-label">E-mail</label>
											<input class="form-control" type="email" name="email-reg" maxlength="50">
									</div>
								</div>
								<div class="col-xs-12 col-sm-5">
									<div class="form-group label-floating">
											<label class="control-label">Universidad</label>
											<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="15">
									</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-5">
									<div class="form-group label-floating">
											<label class="control-label">Carrera</label>
											<input class="form-control" type="email" name="email-reg" maxlength="50">
									</div>
								</div>
								<div class="col-xs-12 col-sm-2">
									<div class="form-group label-floating">
											<label class="control-label">Semestre</label>
											<input class="form-control" type="email" name="email-reg" maxlength="50">
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