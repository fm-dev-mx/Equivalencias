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
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Alumno <small>LISTA DE ALUMNOS</small></h1>
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

<?php 
	require_once "./controladores/alumnoControlador.php";
	$insAlumno= new alumnoControlador();
?>

<!-- Panel listado de alumnos -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ALUMNOS</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insAlumno->paginador_alumno_controlador($pagina[1],10,$_SESSION['privilegio_sbp'],"");
			?>	
		</div>
	</div>
</div>