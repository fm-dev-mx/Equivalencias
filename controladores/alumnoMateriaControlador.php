<?php
	
	if($peticionAjax){
		require_once "../modelos/alumnoMateriaModelo.php";
	}else{
		require_once "./modelos/alumnoMateriaModelo.php";
	}

    class alumnoMateriaControlador extends alumnoMateriaModelo{
		public function validar_materias_controlador($materias){						
			$codigoAlumno=mainModel::limpiar_cadena($_POST['CodigoAlumno']);
			$ban=0;
			
			if($materias==0){
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT CodigoMateria FROM alumnomaterias WHERE CodigoAlumno='$codigoAlumno' AND EstatusMateria=1");
				if($consulta1->rowCount()>=1){
					$deshabilitarMateria=alumnoMateriaModelo::deshabilitar_materias_modelo($codigoAlumno);
					if($deshabilitarMateria->rowCount()<=0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Ocurrio un error al realizar el procedimiento solicitado!",
							"Tipo"=>"error"
						];
					}else{
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Materias actualizadas",
							"Texto"=>"El listado de materias fue actualizado correctamente!",
							"Tipo"=>"success"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Materias actualizadas",
						"Texto"=>"El listado de materias fue actualizado correctamente!",
						"Tipo"=>"success"
					];	
				}
			}else{			
				//verificar cuales agregar y cuales eliminar
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT CodigoMateria FROM alumnomaterias WHERE CodigoAlumno='$codigoAlumno' AND EstatusMateria=1");
				if($consulta1->rowCount()>=1){
					$deshabilitarMateria=alumnoMateriaModelo::deshabilitar_materias_modelo($codigoAlumno);
					if($deshabilitarMateria->rowCount()<=0){
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Ocurrio un error al realizar el procedimiento solicitado!",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}	
				
				foreach($materias as $rows){
					$agregarMateria=alumnoMateriaModelo::agregar_alumno_materia_modelo($codigoAlumno,$rows,1);
					if($agregarMateria->rowCount()<=0){
						$ban=$ban+1;
					}
				}
				if($ban==0){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Materias registradas",
						"Texto"=>"Las materias fueron registradas con exito en el sistema",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos podido registrar las materias correctamente, favor de intentar nuevamente1!",
						"Tipo"=>"error"
					];
				}
			}			
            return mainModel::sweet_alert($alerta);
		}

		public function obtener_materias_controlador($alumno){
			$alumno=mainModel::decryption($alumno);
			return alumnoMateriaModelo::obtener_materias_modelo($alumno);
		}

		public function boton_equivalencias_controlador($materiasCursadas,$alumno){
			if($materiasCursadas<=0){ 
				$cadena='<div class="row">
							<div class="col-xs-4 col-sm-6">
								<div class="form-group label-floating">						
									<p class="text-center" style="margin-top: 20px;">	
										<button type="button" class="btn btn-primary btn-raised btn-sm" data-toggle="modal" data-target="#agregar-materia-pop" data-dismiss="modal" data-backdrop="false"><i class="zmdi zmdi-book"></i>Agregar Materia</button>			
									</p>
								</div>
							</div>	
							<div class="col-xs-4 col-sm-6">
								<div class="form-group label-floating">						
									<p class="text-left" style="margin-top: 20px;">				
										<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
									</p>
								</div>
							</div>			
						</div>';
			}else{ 
				$cadena='<div class="row">
							<div class="col-xs-4 col-sm-6">
								<div class="form-group label-floating">						
									<p class="text-center" style="margin-top: 20px;">	
										<button type="button" class="btn btn-primary btn-raised btn-sm" data-toggle="modal" data-target="#agregar-materia-pop" data-dismiss="modal" data-backdrop="false"><i class="zmdi zmdi-book"></i>Agregar Materia</button>			

										<a href="'.SERVERURL.'alumnoequivalencia/'.mainModel::encryption($alumno).'" class="btn btn-default btn-raised btn-sm"><i class="zmdi zmdi-assignment-return"></i> Ver Equivalencias</a>
									</p>
								</div>
							</div>	
							<div class="col-xs-4 col-sm-6">
								<div class="form-group label-floating">										
									<p style="margin-top: 20px;">										
										<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
									</p>
								</div>																				
							</div>							
						</div>';
		
			}
			return $cadena;
		}

		public function paginador_alumno_equivalencia_controlador($pagina,$registros,$privilegio,$alumno){
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoAlumno=mainModel::limpiar_cadena($alumno);			

			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

			$consulta="SELECT SQL_CALC_FOUND_ROWS mat.MateriaNombre, am.CalificacionMateria, am.MateriaUacj FROM alumnomaterias am, materia mat WHERE (am.CodigoAlumno='$codigoAlumno' AND mat.MateriaCodigo=am.CodigoMateria AND am.EstatusMateria=1) ORDER BY mat.MateriaNombre ASC LIMIT $inicio,$registros";
			
			$paginaurl="alumnoequivalencia";			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			$total= $conexion->query("SELECT FOUND_ROWS()");
			$total= (int) $total->fetchColumn();

			$Npaginas= ceil($total/$registros);

			$tabla.='
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">MATERIA</th>
							<th class="text-center">EQUIVALENCIA</th>
							<th class="text-center">CALIFICACION</th>';
						if($privilegio<=2){
							$tabla.='								
								<th class="text-center">ASIGNAR</th>
							';
						}						
			$tabla.='</tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$Npaginas){

				$contador=$inicio+1;
		
				foreach($datos as $rows){
					$codigoMateriaUacj=$rows['MateriaUacj'];
					$consultaEquivalencia="SELECT MateriaUacjNombre FROM materiauacj WHERE MateriaUacjClave='$codigoMateriaUacj'";
					$consultaEquivalencia = $conexion->query($consultaEquivalencia);
					$consultaEquivalencia= $consultaEquivalencia->fetch();
					$paginaurl="alumnoequivalencia";			

					$conexion = mainModel::conectar();

					$datos = $conexion->query($consulta);
					$datosRen=$rows['MateriaNombre'].'||'.'||'.$rows['CalificacionMateria'].'||'.mainModel::encryption($privilegio);
					
					$tabla.='	
								<tr>
									<td>'.$contador.'</td>
									<td>'.$rows['MateriaNombre'].'</td>
									<td>'.$consultaEquivalencia['MateriaUacjNombre'].'</td>
									<td>'.$rows['CalificacionMateria'].'</td>
									';
					if($privilegio<=2){
						$tabla.='
								<td>																		
									<button class="btn btn-success btn-raised btn-xs" data-toggle="modal" data-target="#asignar-materia-pop" data-dismiss="modal" data-backdrop="false" onclick="ModalAsignarMateria(\''.$rows['MateriaCodigo'].'\')">
									<i class="zmdi zmdi-bookmark"></i></button>																		
								</td>		
								';
					}

					$contador++;
				}
				
				$tabla.='</tr>';
				
			}else{
				if($total>=1){
					$tabla.='
						<tr>
							<td colspan="5">
								<a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
									Haga clic aca para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr>
							<td colspan="7">No hay registros en el sistema</td>
						</tr>
					';	
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<nav class="text-center"><ul class="pagination pagination-sm">';

				if($pagina==1){
					$tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
				}else{
					$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
				}

				for($i=1; $i<=$Npaginas; $i++){
					if($pagina==$i){
						$tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
					}else{
						$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($pagina==$Npaginas){
					$tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
				}else{
					$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
				}
				$tabla.='</ul></nav>	
						';
				$contador++;
			}

			return $tabla;
		}		


	}