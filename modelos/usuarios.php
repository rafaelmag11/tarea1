<?php

class Usuarios{

	public $conexion;

	public function __construct(){

		$this->conexion = conexionBD();

	}

	public function cerrarConexion(){

		$this->conexion->close();

	}



	public function cambiarPass($usuarioid, $pass){

// 		error_log('pass:'.$pass.' usuarioid:'.$usuarioid);

		$resultado = 0;

		$consulta = 'UPDATE cat_usuarios SET pass=md5(?) WHERE usuarioid=?';

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

// 			error_log('-');

			$stmt->bind_param('si', $pass, $usuarioid);

			$stmt->execute();

			$resultado = $stmt->affected_rows;

// 			error_log('resultado:'+$resultado);

			$stmt->close();

		}

		return $resultado;

	}

	

	public function usuariosDestinoAplicativos($aplicativoid){

		$resultados = array();

		$consulta = "SELECT u.email

					 FROM aplicativos_usuarios au

					 INNER JOIN cat_usuarios u USING (usuarioid)

					 WHERE au.aplicativoid=?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('i',$aplicativoid);

			$stmt->execute();

			$stmt->bind_result($email);

			while($stmt->fetch()){

				array_push($resultados,array('email' => $email));

			}

			$stmt->close();

		}					

		return $resultados;

	}



	public function buscarCoincidencias($textoBusqueda,$tipoTicket,$usuarioBusca){

		//error_log($textoBusqueda);

		$resultados = array();

		$consulta = "SELECT u.usuarioid,u.clave,u.nombre,IFNULL(u.apaterno,''),IFNULL(u.amaterno,''),d.descripcion,u.estatusid,u.email

					 FROM cat_usuarios u

					 LEFT JOIN cat_departamentos d ON u.departamentoid=d.departamentoid

					 WHERE 

						(u.nombre LIKE '%$textoBusqueda%' OR u.apaterno LIKE '%$textoBusqueda%' OR u.amaterno LIKE '%$textoBusqueda%')

						AND u.usuarioid not in (SELECT usuarioid FROM aplicativos_usuarios WHERE aplicativoid=?)

						AND u.usuarioid<>?";

		$stmt = $this->conexion->prepare($consulta);

		if($stmt){

			$stmt->bind_param('ii',$tipoTicket,$usuarioBusca);

			$stmt->execute();

			$stmt->bind_result($usuarioid,$usuario,$nombre,$paterno,$materno,$departamento,$estatus,$email);

			while($stmt->fetch()){

				array_push($resultados,array(

					'usuarioid' => $usuarioid,

					'usuario'	=> $usuario,

					'nombre'	=> $nombre,

					'paterno'	=> $paterno,

					'materno'	=> $materno,

					'departamento' => $departamento,

					'estatus'	=> $estatus,

					'email'		=> $email));

			}

			$stmt->close();

		}					

		return $resultados;

	}

}	