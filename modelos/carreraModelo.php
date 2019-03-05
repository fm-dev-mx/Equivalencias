<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class carreraModelo extends mainModel{
		protected function agregar_carrera_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO carrera (CarreraNombre,CarreraCodigo,CarreraCodigoUniversidad) VALUES(:Nombre,:Codigo,:CodigoUniversidad)");
			$sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Codigo",$datos['CodigoCarrera']);
            $sql->bindParam(":CodigoUniversidad",$datos['CodigoUniversidad']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_carrera_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM carrera WHERE CarreraCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_carrera_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE carrera SET CarreraNombre=:Nombre WHERE CarreraCodigo=:Codigo");
			$query->bindParam(":Codigo",$datos['Codigo']);
			$query->bindParam(":Nombre",$datos['Nombre']);
			$query->execute();
			return $query;
		}

		protected function datos_carrera_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM carrera WHERE CarreraCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM carrera");
			}
			$query->execute();
			return $query;
		}
	}