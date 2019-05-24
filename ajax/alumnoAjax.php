<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['AlumnoNombre']) || isset($_POST['agregarActualizar'])){

		require_once "../controladores/alumnoControlador.php";
		$InsAlumno= new alumnoControlador();

		if(isset($_POST['AlumnoNombre']) && isset($_POST['agregarActualizar'])){
			if($_POST['agregarActualizar']=='Actualizar'){
				echo $InsAlumno->actualizar_alumno_controlador();
			}elseif($_POST['agregarActualizar']=="Agregar"){
				echo $InsAlumno->agregar_alumno_controlador();
			}	
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsAlumno->eliminar_alumno_controlador();
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }