<?php
	$peticionAjax=true;			
	require_once "../core/configGeneral.php";
	if(isset($_GET['busqueda']) || isset($_GET['codigoMateria']) || isset($_POST['codigoUacj'])){
		
		require_once "../controladores/asignarmateriaControlador.php";
		$InsAsignarMateria= new asignarmateriaControlador();

		if(isset($_POST['codigoUacj'])){			
			echo $InsAsignarMateria->asignar_materia_controlador();
		}		

		if(isset($_GET['busqueda'])){			
			echo $InsAsignarMateria->buscar_materia_controlador();
		}

		if(isset($_GET['codigoMateria'])){		
			$_SESSION['codigoMateria']=$_GET['codigoMateria'];
			unset($_GET['codigoMateria']);
		}
		
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }