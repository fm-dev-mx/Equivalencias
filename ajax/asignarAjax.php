<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_GET['busqueda']) || isset($_POST['asignarMateria']) || isset($_POST['MateriaCodigoAsignar'])){

		require_once "../controladores/asignarmateriaControlador.php";
		$InsAsignarMateria= new asignarmateriaControlador();

		if(isset($_GET['busqueda'])){
			echo $InsAsignarMateria->buscar_materia_controlador();
		}

		if(isset($_POST['asignarMateria'])){
			echo $InsAsignarMateria->asignar_materia_controlador();
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }