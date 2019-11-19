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

										<a href="'.SERVERURL.'alumnomateria/'.mainModel::encryption($alumno).'" class="btn btn-default btn-raised btn-sm"><i class="zmdi zmdi-assignment-return"></i> Ver Equivalencias</a>
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
	}