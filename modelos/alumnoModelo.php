<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class alumnoModelo extends mainModel{
		protected function agregar_alumno_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO alumno (AlumnoCodigo,AlumnoNombre,AlumnoApellido,AlumnoTelefono,AlumnoFechaNac,AlumnoEmail,AlumnoUniversidad,AlumnoCarrera,AlumnoSemestre) VALUES(:Codigo,:Nombre,:Apellido,:Telefono,:FechaNac,:Email,:Universidad,:Carrera,:Semestre)");
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Apellido",$datos['Apellido']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":FechaNac",$datos['FechaNac']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Universidad",$datos['Universidad']);
			$sql->bindParam(":Carrera",$datos['Carrera']);
			$sql->bindParam(":Semestre",$datos['Semestre']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_alumno_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM universidad WHERE UniversidadCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_alumno_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE universidad SET UniversidadNombre=:Nombre,UniversidadTelefono=:Telefono,UniversidadDireccion=:Direccion,UniversidadIniciales=:Iniciales,UniversidadTipo=:Tipo,UniversidadPais=:Pais,UniversidadEstado=:Estado,UniversidadCiudad=:Ciudad WHERE UniversidadCodigo=:Codigo");
			$query->bindParam(":Codigo",$datos['Codigo']);
			$query->bindParam(":Nombre",$datos['Nombre']);
			$query->bindParam(":Telefono",$datos['Telefono']);
			$query->bindParam(":Direccion",$datos['Direccion']);
			$query->bindParam(":Iniciales",$datos['Iniciales']);
			$query->bindParam(":Tipo",$datos['Tipo']);
			$query->bindParam(":Pais",$datos['Pais']);
			$query->bindParam(":Estado",$datos['Estado']);
			$query->bindParam(":Ciudad",$datos['Ciudad']);
			$query->execute();
			return $query;
		}

		protected function datos_alumno_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM alumno WHERE AlumnoCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM alumno");
			}elseif($tipo=="Lista"){
				$query=mainModel::conectar()->prepare("SELECT AlumnoCodigo,AlumnoNombre FROM alumno ORDER BY AlumnoNombre ASC");
			}
			$query->execute();
			return $query;
		}
	}