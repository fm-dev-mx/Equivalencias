<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['privilegio-admin']) || isset($_POST['nombreMateriaAgregar']) || isset($_POST['carreraSelect']) || isset($_POST['codigo-del']) || isset($_POST['materiaObl'])){

		require_once "../controladores/materiauacjControlador.php";
		$InsMateria= new materiaUacjControlador();

		if(isset($_POST['nombreMateriaAgregar']) && isset($_POST['claveMateriaAgregar'])){
			echo $InsMateria->agregar_materia_uacj_controlador();
		}
	
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsMateria->eliminar_materia_uacj_controlador();
		}
/*
		if(isset($_POST['MateriaNombreUpdate']) && isset($_POST['MateriaCodigoUpdate'])){
			echo $InsMateria->actualizar_materia_uacj_controlador();
		}*/
		
		if(isset($_POST['materiaObl'])){
			session_start(['name'=>'SBP']);
			$_SESSION['materiaObl']=$_POST['materiaObl'];		
		}

		if(isset($_POST['carreraSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraSelect']=$_POST['carreraSelect'];		
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }