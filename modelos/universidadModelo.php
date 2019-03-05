<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class universidadModelo extends mainModel{
		protected function agregar_universidad_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO universidad (UniversidadNombre,UniversidadTelefono,UniversidadDireccion,UniversidadIniciales,UniversidadPais,UniversidadEstado,UniversidadCiudad) VALUES(:Nombre,:Telefono,:Direccion,:Iniciales,:Pais,:Estado,:Ciudad)");
			$sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Direccion",$datos['Direccion']);
			$sql->bindParam(":Iniciales",$datos['Iniciales']);
			$sql->bindParam(":Pais",$datos['Pais']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Ciudad",$datos['Ciudad']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_universidad_modelo($id){
			$query=mainModel::conectar()->prepare("DELETE FROM universidad WHERE id=:Id");
			$query->bindParam(":Id",$id);
			$query->execute();
			return $query;
		}

		protected function actualizar_universidad_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE universidad SET UniversidadNombre=:Nombre,UniversidadTelefono=:Telefono,UniversidadDireccion=:Direccion,UniversidadIniciales=:Iniciales,UniversidadPais=:Pais,UniversidadEstado=:Estado,UniversidadCiudad=:Ciudad WHERE id=:Id");
			$query->bindParam(":Nombre",$datos['Nombre']);
			$query->bindParam(":Telefono",$datos['Telefono']);
			$query->bindParam(":Direccion",$datos['Direccion']);
			$query->bindParam(":Iniciales",$datos['Iniciales']);
			$query->bindParam(":Id",$datos['Id']);
			$query->bindParam(":Pais",$datos['Pais']);
			$query->bindParam(":Estado",$datos['Estado']);
			$query->bindParam(":Ciudad",$datos['Ciudad']);
			$query->execute();
			return $query;
		}

		protected function datos_universidad_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM universidad WHERE id=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM universidad");
			}
			$query->execute();
			return $query;
		}
	}