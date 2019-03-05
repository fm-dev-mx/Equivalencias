<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombreUniversidad-reg']) || isset($_POST['codigo-del']) || isset($_POST['agregarActualizar-reg'])){

		require_once "../controladores/universidadControlador.php";
		$InsUniv= new universidadControlador();

		if(isset($_POST['nombreUniversidad-reg']) && isset($_POST['iniciales-reg']) && isset($_POST['agregarActualizar-reg'])){
			if($_POST['agregarActualizar-reg']=='Actualizar'){
				echo $InsUniv->actualizar_universidad_controlador();
			}elseif($_POST['agregarActualizar-reg']=="Agregar"){
				echo $InsUniv->agregar_universidad_controlador();
			}	
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsUniv->eliminar_universidad_controlador();
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }