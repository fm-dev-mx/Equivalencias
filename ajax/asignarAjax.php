<?php
	$peticionAjax=true;			
	require_once "../core/configGeneral.php";
	if(isset($_GET['busqueda']) || isset($_GET['codigoMateria']) || isset($_GET['codigoMateriaUacj'])){
		
		require_once "../controladores/asignarmateriaControlador.php";
		$InsAsignarMateria= new asignarmateriaControlador();		

		if(isset($_GET['busqueda'])){			
			echo $InsAsignarMateria->buscar_materia_controlador();
		}

		if(isset($_GET['codigoMateria'])){		
			$_SESSION['codigoMateria']=$_GET['codigoMateria'];
			unset($_GET['codigoMateria']);
		}

		if(isset($_GET['codigoMateriaUacj'])){			
			echo $InsAsignarMateria->asignar_materia_controlador();
		}		
		
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }