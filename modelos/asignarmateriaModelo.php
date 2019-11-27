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

		protected function asignar_materia_modelo($Materia,$MateriaUacj,$CarreraMateria){

			$sql=mainModel::conectar()->prepare("UPDATE equivalencia eq, materiauacj matuacj SET CodigoMateriaUacj=:MateriaUacj, CodigoMateria=:Materia WHERE eq.CodigoMateria='$Materia' AND matuacj.MateriaUacjClave=eq.CodigoMateriaUacj AND matuacj.MateriaUacjCarrera='$CarreraMateria'");			

			$sql->bindParam(":Materia",$Materia);
            $sql->bindParam(":MateriaUacj",$MateriaUacj);
			$sql->execute();
			return $sql;
		}

		protected function agregar_materia_modelo($Materia,$MateriaUacj){
			$sql=mainModel::conectar()->prepare("INSERT INTO equivalencia (CodigoMateria,CodigoMateriaUacj) VALUES(:Materia,:MateriaUacj)");
			$sql->bindParam(":Materia",$Materia);
            $sql->bindParam(":MateriaUacj",$MateriaUacj);
			$sql->execute();
			return $sql;
		}
	}
