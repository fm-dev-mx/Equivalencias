<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class materiaModelo extends mainModel{
		protected function agregar_materia_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO materia (CarreraNombre,CarreraCodigo,CarreraCodigoUniversidad) VALUES(:Nombre,:Codigo,:CodigoUniversidad)");
			$sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":CodigoUniversidad",$datos['CodigoUniversidad']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_materia_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM carrera WHERE CarreraCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_materia_modelo($codigo,$nombre){
			$query=mainModel::conectar()->prepare("UPDATE carrera SET CarreraNombre=:Nombre WHERE CarreraCodigo=:Codigo");
			$query->bindParam(":Nombre",$nombre);
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

	}