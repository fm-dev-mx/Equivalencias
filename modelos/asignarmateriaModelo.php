<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class asignarmateriaModelo extends mainModel{

		protected function buscar_materia_modelo($tipo,$busqueda,$inicio,$registros){
			if($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT MateriaUacjNombre FROM materiauacj");
			}elseif($tipo=="Lista"){
				if($busqueda!=""){
					$query=mainModel::conectar()->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM materiauacj WHERE MateriaUacjNombre like '%$busqueda%' or MateriaUacjClave like '%$busqueda%' ORDER BY MateriaUacjNombre ASC LIMIT $inicio,$registros");
				}else{
					$query=mainModel::conectar()->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM materiauacj ORDER BY MateriaUacjNombre ASC LIMIT $inicio,$registros");
				}				
			}
			$query->execute();
			return $query;
		}

		protected function asignar_materia_modelo($codigo,$codigoUacj){
			$query=mainModel::conectar()->prepare("UPDATE materia SET MateriaUacj=:Materia WHERE MateriaCodigo=:Codigo");
			
			$query->bindParam(":Materia",$codigoUacj);
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}
	}
