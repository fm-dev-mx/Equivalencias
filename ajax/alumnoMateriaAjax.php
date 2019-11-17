<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['multiSelectMaterias']) || isset($_POST['CodigoAlumno'])){

		require_once "../controladores/alumnoMateriaControlador.php";
		$InsAlumnoMateria= new alumnoMateriaControlador();
		
		if(isset($_POST['multiSelectMaterias']) && isset($_POST['CodigoAlumno'])){
			echo $InsAlumnoMateria->validar_materias_controlador($_POST['multiSelectMaterias']);
		}

	}