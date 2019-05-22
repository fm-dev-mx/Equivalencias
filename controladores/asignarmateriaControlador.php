<?php
	if($peticionAjax){
		session_start(['name'=>'SBP']);
		require_once "../modelos/asignarmateriaModelo.php";
	}else{
		require_once "./modelos/asignarmateriaModelo.php";
	}

	class asignarmateriaControlador extends asignarmateriaModelo{
		public function buscar_materia_controlador(){
			$busqueda=mainModel::limpiar_cadena($_REQUEST['busqueda']);

			//Count the total number of row in your table*/
			$numrow = asignarmateriaModelo::buscar_materia_modelo("Conteo",0);
			$numrows = $numrow->rowCount(); 

			//main query to fetch the data
			$query = asignarmateriaModelo::buscar_materia_modelo("Lista",$busqueda);
			
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
				$i=1;
				foreach($query as $rows){						
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
				$tabla.='</tbody></table></div>';			
			}
			return $tabla;
		}
		
		public function asignar_materia_controlador(){
			
			$codigoUacj=mainModel::limpiar_cadena($_GET['codigoMateriaUacj']);
			unset($_GET['codigoMateriaUacj']);
			$adminPrivilegio=$_SESSION['privilegio_sbp'];
			$codigoMateria=mainModel::limpiar_cadena($_SESSION['codigoMateria']);
			unset($_SESSION['codigoMateria']);
			if($adminPrivilegio<=1){
				$asignarMateria=asignarmateriaModelo::asignar_materia_modelo($codigoMateria,$codigoUacj);
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