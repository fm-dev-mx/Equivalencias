<?php
	if($peticionAjax){
		session_start(['name'=>'SBP']);
		require_once "../modelos/asignarmateriaModelo.php";
	}else{
		require_once "./modelos/asignarmateriaModelo.php";
	}

	class asignarmateriaControlador extends asignarmateriaModelo{
		public function buscar_materia_controlador($pagina,$registros){
			$registros=mainModel::limpiar_cadena($registros);
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
			$busqueda=mainModel::limpiar_cadena($_REQUEST['busqueda']);

			//Count the total number of row in your table*/
			$numrow = asignarmateriaModelo::buscar_materia_modelo("Conteo",0,"","");
			$numrows = $numrow->rowCount(); 

			//main query to fetch the data
			$carrera = $_SESSION['carreraUacjSelect'];

			$query="SELECT SQL_CALC_FOUND_ROWS * FROM materiauacj WHERE (MateriaUacjNombre like '%$busqueda%' or MateriaUacjClave like '%$busqueda%') AND MateriaUacjCarrera='$carrera' ORDER BY MateriaUacjNombre ASC LIMIT $inicio,$registros";		

			$conexion = mainModel::conectar();

			$datos = $conexion->query($query);
			$datos= $datos->fetchAll();

			$total= $conexion->query("SELECT FOUND_ROWS()");
			$total= (int) $total->fetchColumn();

			$Npaginas= ceil($total/$registros);			
			
			//loop through fetched data
			if($numrows>0){				
				$tabla='<div class="table-responsive">
							<table class="table table-hover text-center">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">CLAVE</th>
										<th class="text-center">NOMBRE</th>
										<th class="text-center">CREDITOS</th>
										<th class="text-center">OBL/OPT</th>
										<th class="text-center">ASIGNAR</th>
									</tr>
								</thead>
								<tbody>';				
				
				if($total>=1 && $pagina<=$Npaginas){
					$i=1;
					foreach($datos as $rows){						
						$tabla.='<tr>
									<td>'.$i.'</td>
									<td>'.$rows['MateriaUacjClave'].'</td>
									<td>'.$rows['MateriaUacjNombre'].'</td>
									<td>'.$rows['MateriaUacjCreditos'].'</td>
									<td>'.$rows['MateriaUacjObligatoria'].'</td>							
									<td>
										<button type="submit" class="btn btn-info btn-xs" onclick="AsignarMateria(\'' . $rows['MateriaUacjClave'] . '\')">
											<i class="glyphicon glyphicon-ok"></i>
										</button>
										<div class="RespuestaAjax"></div>
									</td>								
								</tr>
								';
						$i++;
					}					
				}
				$tabla.='</tbody></table></div>';
			}
			return $tabla;
		}
		
		public function asignar_materia_controlador(){

			$adminPrivilegio=$_SESSION['privilegio_sbp'];
			if($adminPrivilegio==1){

				$MateriaUacj=mainModel::limpiar_cadena($_GET['codigoMateriaUacj']);
				unset($_GET['codigoMateriaUacj']);				
				$Materia=mainModel::limpiar_cadena($_SESSION['codigoMateria']);		
				unset($_SESSION['codigoMateria']);
				$query="SELECT MateriaUacjCarrera FROM materiauacj WHERE MateriaUacjClave='$MateriaUacj'";		
				$conexion = mainModel::conectar();
				$query = $conexion->query($query);
				$query= $query->fetch();
				$CarreraMateria=$query['MateriaUacjCarrera'];
				$consulta=mainModel::ejecutar_consulta_simple("SELECT eq.id FROM equivalencia eq, materiauacj matuacj WHERE eq.CodigoMateria='$Materia' AND matuacj.MateriaUacjClave=eq.CodigoMateriaUacj AND matuacj.MateriaUacjCarrera='$CarreraMateria'");

				if($consulta->rowCount()<=0){

					$agregarMateria=asignarmateriaModelo::agregar_materia_modelo($Materia,$MateriaUacj);
					if($agregarMateria->rowCount()>=1){
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Datos actualizados!",
							"Texto"=>"Se asignó la materia correctamente",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido asignar la materia, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}	
				}else{
					
					$asignarMateria=asignarmateriaModelo::asignar_materia_modelo($Materia,$MateriaUacj,$CarreraMateria);
					if($asignarMateria->rowCount()>=1){
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Datos actualizados!",
							"Texto"=>"Se asignó la materia correctamente",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido asignar la materia, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}								
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No tiene los permisos para asignar materias",
					"Tipo"=>"error"
				];
			}
			
			return mainModel::sweet_alert($alerta);
		}
	}