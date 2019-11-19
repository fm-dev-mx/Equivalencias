<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class alumnoMateriaModelo extends mainModel{
		protected function agregar_alumno_materia_modelo($alumno,$materia,$estatus){
			
			$consulta=mainModel::ejecutar_consulta_simple("SELECT id FROM alumnomaterias WHERE (CodigoAlumno='$alumno' AND CodigoMateria='$materia')");
			if($consulta->rowCount()>=1){				
				$sql=mainModel::conectar()->prepare("UPDATE alumnomaterias SET EstatusMateria=1 WHERE (CodigoAlumno='$alumno' AND CodigoMateria='$materia')");
			}else{
				$sql=mainModel::conectar()->prepare("INSERT INTO alumnomaterias (CodigoAlumno,CodigoMateria,EstatusMateria) VALUES('$alumno','$materia','$estatus')");
			}			

			$sql->execute();

			return $sql;
		}

		protected function obtener_materias_modelo($alumno){
			$query=mainModel::conectar()->prepare("SELECT CodigoMateria,EstatusMateria FROM alumnomaterias WHERE CodigoAlumno=:Alumno AND EstatusMateria=1");
			$query->bindParam(":Alumno",$alumno);
			$query->execute();
			return $query;
		}
		
		protected function deshabilitar_materias_modelo($codigo){
			$query=mainModel::conectar()->prepare("UPDATE alumnomaterias SET EstatusMateria=0 WHERE CodigoAlumno=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}		
	}