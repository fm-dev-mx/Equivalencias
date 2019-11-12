<?php 
    if($_SESSION['tipo_sbp']!="Administrador"){
        echo $lc->forzar_cierre_sesion_controlador();
    }

	require "./controladores/administradorControlador.php";
	$IAdmin= new administradorControlador();
	$CAdmin=$IAdmin->datos_administrador_controlador("Conteo",0);
	require "./controladores/universidadControlador.php";
	$IUniv= new universidadControlador();
	$CUniv=$IUniv->datos_universidad_controlador("Conteo",0);
	require "./controladores/carreraControlador.php";
	$ICarrera= new carreraControlador();
	$CCarrera=$ICarrera->datos_carrera_controlador("Conteo",0);
	require "./controladores/alumnoControlador.php";
	$IAlumno= new alumnoControlador();
	$CAlumno=$IAlumno->datos_alumno_controlador("Conteo",0);
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Sistema de equivalencias <small>UACJ</small></h1>
	</div>
</div>
<div class="full-box text-center" style="padding: 30px 10px;">
<div class="panel-body">				
		<div class="row">
		
			<div class="col-xs-12 col-sm-4">
				<a href="<?php echo SERVERURL; ?>adminlist/">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Administradores
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-account"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo $CAdmin->rowCount(); ?></p>
							<small>Registrados</small>
						</div>
					</article>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4">
				<a href="<?php echo SERVERURL; ?>univList/">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Universidades
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-balance"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo $CUniv->rowCount(); ?></p>
							<small>Registrados</small>
						</div>
					</article>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4">
				<a href="<?php echo SERVERURL; ?>carrera/">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Carreras
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-library"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo $CCarrera->rowCount(); ?></p>
							<small>Registrados</small>
						</div>
					</article>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4">
				<a href="<?php echo SERVERURL; ?>alumno/">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Alumnos
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-face zmdi-hc-fw"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo $CAlumno->rowCount(); ?></p>
							<small>Registrados</small>
						</div>
					</article>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4">
				<a href="<?php echo SERVERURL; ?>equivalencias/">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Equivalencias
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-assignment-return zmdi-hc-fw"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo $CAlumno->rowCount(); ?></p>
							<small>Registrados</small>
						</div>
					</article>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4">
				<a href="<?php echo SERVERURL; ?>alumno/">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Operaciones
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-chart zmdi-hc-fw"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo $CAlumno->rowCount(); ?></p>
							<small>Operaciones</small>
						</div>
					</article>
				</a>
			</div>
			</div>
			</div>
</div>

