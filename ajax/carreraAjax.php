<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre']) || isset($_GET['codigoUni']) || isset($_POST['codigo-del']) || isset($_POST['nombreCarreraAgregar']) || isset($_POST['privilegio-admin']) || isset($_POST['codigo-actu']) || isset($_POST['CarreraNombreUpdate']) || isset($_POST['uniSelect']) || isset($_POST['alumnoUniSelect']) || isset($_POST['carreraSelect']) || isset($_POST['nombreAlumnoCarrera'])){

		require_once "../controladores/carreraControlador.php";
		$InsCarrera= new carreraControlador();
		session_start(['name'=>'SBP']);

		if(isset($_POST['nombreCarreraAgregar']) && isset($_POST['codigoUniAgregarCarrera'])){
			echo $InsCarrera->agregar_carrera_controlador();
		}
	
		if(isset($_POST['nombreAlumnoCarrera']) && isset($_SESSION['codigoUni'])){
			echo $InsCarrera->agregar_carrera_controlador();
		}

		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsCarrera->eliminar_carrera_controlador();
		}

		if(isset($_POST['CarreraNombreUpdate']) && isset($_POST['CarreraCodigoUpdate'])){
			echo $InsCarrera->actualizar_carrera_controlador();
		}

		if(isset($_POST['uniSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['uniSelect']=$_POST['uniSelect'];	
			unset($_POST['uniSelect']);
		}

		if(isset($_GET['codigoUni'])){
			session_start(['name'=>'SBP']);
			$_SESSION['codigoUni']=$_GET['codigoUni'];	
			unset($_GET['codigoUni']);
		}

		//recargar lista de select de carreras desde "Registrar alumno"
		if(isset($_POST['alumnoUniSelect'])){	
			
			if(isset($_POST["codigoCarreraEditar"])){
				$_SESSION['codigoCarreraEditar']=$_POST["codigoCarreraEditar"];
				
			}
			echo $InsCarrera->lista_carrera_controlador();
		}

		if(isset($_POST['carreraSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraSelect']=$_POST['carreraSelect'];		
			echo '<script> window.location.href="'.SERVERURL.'materias/" </script>';
		}		
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }