<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre']) || isset($_POST['codigo-del']) || isset($_POST['nombreCarreraAgregar']) || isset($_POST['privilegio-admin']) || isset($_POST['codigo-actu']) || isset($_POST['CarreraNombreUpdate']) || isset($_POST['uniSelect'])){

		require_once "../controladores/carreraControlador.php";
		$InsUniv= new carreraControlador();

		if(isset($_POST['nombreCarreraAgregar']) && isset($_POST['codigoUniAgregarCarrera'])){
			echo $InsUniv->agregar_carrera_controlador();
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsUniv->eliminar_carrera_controlador();
		}

		if(isset($_POST['CarreraNombreUpdate']) && isset($_POST['CarreraCodigoUpdate'])){
			echo $InsUniv->actualizar_carrera_controlador();
		}

		
			echo '<script> window.location.href="'.SERVERURL.'carrera/'.$_POST['uniSelect'].'/" </script>';

		if(isset($_POST['uniSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['uniSelect']=$_POST['uniSelect'];		
		}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }