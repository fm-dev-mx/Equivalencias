<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['ListadoMaterias']) || isset($_POST['CodigoAlumno']) || isset($_POST['MateriasCursadasBtn'])){

		require_once "../controladores/alumnoMateriaControlador.php";
		$InsAlumnoMateria= new alumnoMateriaControlador();
		

		if(isset($_POST['ListadoMaterias']) && isset($_POST['CodigoAlumno'])){			
			if(isset($_POST['multiSelectMaterias']))
				echo $InsAlumnoMateria->validar_materias_controlador($_POST['multiSelectMaterias']);
			else
				echo $InsAlumnoMateria->validar_materias_controlador(0);
		}

		if(isset($_POST['MateriasCursadasBtn']) && isset($_POST['CodigoAlumnoBtn'])){	
			echo $InsAlumnoMateria->boton_equivalencias_controlador($_POST['MateriasCursadasBtn'],$_POST['CodigoAlumnoBtn']);
		}

	}