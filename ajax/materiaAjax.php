<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['privilegio-admin']) || isset($_POST['uniSelect']) || isset($_POST['carreraSelect']) || isset($_POST['carreraUacjSelect']) || isset($_POST['nombreMateriaAgregar']) || isset($_POST['codigoCarreraAgregarMateria']) || isset($_POST['MateriaNombreUpdate'])	){

		require_once "../controladores/materiaControlador.php";
		$InsMateria= new materiaControlador();

		if(isset($_POST['nombreMateriaAgregar']) && isset($_POST['codigoCarreraAgregarMateria'])){
			echo $InsMateria->agregar_materia_controlador();
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsMateria->eliminar_materia_controlador();
		}

		if(isset($_POST['MateriaNombreUpdate']) && isset($_POST['MateriaCodigoUpdate'])){
			echo $InsMateria->actualizar_materia_controlador();
		}

		if(isset($_POST['uniSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['uniSelect']=$_POST['uniSelect'];		
			unset($_SESSION['carreraSelect']);
		}

		if(isset($_POST['carreraSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraSelect']=$_POST['carreraSelect'];		
		}

		if(isset($_POST['carreraUacjSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraUacjSelect']=$_POST['carreraUacjSelect'];		
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }