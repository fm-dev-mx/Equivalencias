<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre']) || isset($_POST['codigo-del']) || isset($_POST['agregarActualizar']) || isset($_POST['privilegio-admin']) || isset($_POST['codigo-actu'])){

		require_once "../controladores/carreraControlador.php";
		$InsUniv= new carreraControlador();

		if(isset($_POST['nombre']) && isset($_POST['agregarActualizar'])){
				echo $InsUniv->agregar_carrera_controlador();
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsUniv->eliminar_carrera_controlador();
		}

		if(isset($_POST['codigo-actu']) && isset($_POST['privilegio-admin'])){
			echo $InsUniv->actualizar_carrera_controlador();
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }