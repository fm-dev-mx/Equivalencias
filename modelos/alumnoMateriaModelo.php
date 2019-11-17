<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class alumnoMateriaModelo extends mainModel{
		protected function agregar_alumno_materia_modelo($alumno,$materia,$estatus){
			var_dump($alumno,$materia,$estatus);
			$sql=mainModel::conectar()->prepare("INSERT INTO alumnoMaterias (CodigoAlumno,CodigoMateria,EstatusMateria) VALUES(:Alumno,:Materia,:Estatus)");
			$sql->bindParam(":Alumno",$alumno);
			$sql->bindParam(":Materia",$materia);
			$sql->bindParam(":Estatus",$estatus);            
			$sql->execute();
			var_dump($sql);
			return $sql;
		}

		protected function obtener_materias_modelo($alumno){
			$query=mainModel::conectar()->prepare("SELECT CodigoMateria,EstatusMateria FROM alumnomaterias WHERE CodigoAlumno=:Alumno");
			$query->bindParam(":Alumno",$alumno);
			$query->execute();
			return $query;
		}
		
		protected function eliminar_alumno_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM universidad WHERE UniversidadCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_alumno_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE alumno SET AlumnoNombre=:Nombre,AlumnoApellido=:Apellido,AlumnoFechaNac=:FechaNac,AlumnoTelefono=:Telefono,AlumnoEmail=:Email,AlumnoUniversidad=:Universidad,AlumnoCarrera=:Carrera,AlumnoSemestre=:Semestre WHERE AlumnoCodigo=:Codigo");
			$query->bindParam(":Codigo",$datos['Codigo']);
			$query->bindParam(":Nombre",$datos['Nombre']);
			$query->bindParam(":Apellido",$datos['Apellido']);
			$query->bindParam(":FechaNac",$datos['FechaNac']);
			$query->bindParam(":Telefono",$datos['Telefono']);
			$query->bindParam(":Email",$datos['Email']);
			$query->bindParam(":Universidad",$datos['Universidad']);
			$query->bindParam(":Carrera",$datos['Carrera']);
			$query->bindParam(":Semestre",$datos['Semestre']);
			$query->execute();
			return $query;
		}
		
	}