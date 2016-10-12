<?php
require_once("class_dbConnect.php");

class Persona {
		private $AT_id_persona;	
		private $AT_nombre_persona;	
		private $AT_apellido;	
		private $AT_fecha_nacimiento;	
		private $AT_direccion;	
		private $AT_telefono;	
		private $AT_email;	
		private $AT_tipo_documento;	
		private $AT_estado_habilitado;	
		private $AT_id_area;	
		private $AT_id_nacionalidad;
		private $table;
		private $Cllave1;
		private $Cllave2;
		private $conexion;
		private $stmt;
		private $query;
	  	private $GT; 
 
		public function __construct($P_id_persona,$P_nombre_persona,$P_apellido,$P_fecha_nacimiento,$P_direccion,$P_telefono,$P_email,$P_tipo_documento,$P_estado_habilitado,$P_id_area,$P_id_nacionalidad)
		{
		$this->AT_id_persona = $P_id_persona;	
		$this->AT_nombre_persona = $P_nombre_persona;	
		$this->AT_apellido = $P_apellido;	
		$this->AT_fecha_nacimiento = $P_fecha_nacimiento;	
		$this->AT_direccion = $P_direccion;	
		$this->AT_telefono = $P_telefono;	
		$this->AT_email = $P_email;	
		$this->AT_tipo_documento = $P_tipo_documento;
		$this->AT_estado_habilitado = $P_estado_habilitado;	
	  	$this->AT_id_area = $P_id_area;	
		$this->AT_id_nacionalidad =$P_id_nacionalidad;	
			
		$this->table 	= "persona"; //TABLA
		$this->Cllave1 	= "id_persona"; //CAMPO LLAVE

		$this->conexion = Conexion::getInstance();
		}

		public function Validar() 
			{
				$this->query = sprintf("SELECT ".$this->Cllave1." FROM ".$this->table." WHERE ".$this->Cllave1."= '%s' ", 
				mysql_real_escape_string($this->AT_id_persona));
				$this->stmt = $this->conexion->ejecutar($this->query);
				if(mysql_num_rows($this->stmt)) 
				
				{
				echo "<center><div  class='alert alert-info'> LA PERSONA YA EXISTE EN EL SISTEMA !!</div></center>";	
				return true;
				}  
				else
				{
					return false;
					}
			}

		public function registrar()
		  {
			if(!$this->Validar()) 
			{
			$this->query  = sprintf("INSERT INTO persona (id_persona, nombre_persona, apellido, fecha_nacimiento, direccion, telefono, email,tipo_documento, estado_habilitado, id_area, id_nacionalidad) VALUES ('%s', '%s', '%s', '%s' , '%s', '%s', '%s', '%s', '%s', '%s','%s')", 
																																			
			mysql_real_escape_string($this->AT_id_persona),
			mysql_real_escape_string($this->AT_nombre_persona ),
			mysql_real_escape_string($this->AT_apellido),
			mysql_real_escape_string($this->AT_fecha_nacimiento),
			mysql_real_escape_string($this->AT_direccion),
			mysql_real_escape_string($this->AT_telefono),
			mysql_real_escape_string($this->AT_email),
			mysql_real_escape_string($this->AT_tipo_documento),			
			mysql_real_escape_string($this->AT_estado_habilitado),
			mysql_real_escape_string($this->AT_id_area),
			mysql_real_escape_string($this->AT_id_nacionalidad));
				
			$this->stmt = $this->conexion->ejecutar($this->query);
			if($this->stmt)
				{
				echo "<center><div  class='alert alert-success'> ".$this->AT_nombre_persona." FUE REGISTRADO  EXITOSAMENTE! </div></center>";
				$this->GT = new GestionarPersona($this->AT_id_persona);
				return $this->GT -> consultar();		
				}
				else
					{
					echo "<center><div class='alert alert-error'> SE ENCONTRÓ UN ERROR INTENTANDO REALIZAR EL REGISTRO, CONTACTE EL ADMINISTRADOR! (ERROR EN LA CONSULTA)</div></center>";
					}
					
			}
			
		  }

	public function modificar()
	{
	$this->query  = sprintf("UPDATE  persona  SET nombre_persona = '%s', apellido = '%s', fecha_nacimiento = '%s', direccion = '%s', telefono = '%s', email = '%s',tipo_documento = '%s', estado_habilitado = '%s', id_area = '%s', id_nacionalidad = '%s' WHERE id_persona = '%s';
", 
			mysql_real_escape_string($this->AT_nombre_persona),
			mysql_real_escape_string($this->AT_apellido),
			mysql_real_escape_string($this->AT_fecha_nacimiento),
			mysql_real_escape_string($this->AT_direccion),
			mysql_real_escape_string($this->AT_telefono),
			mysql_real_escape_string($this->AT_email),
			mysql_real_escape_string($this->AT_tipo_documento),
			mysql_real_escape_string($this->AT_estado_habilitado),
			mysql_real_escape_string($this->AT_id_area),
			mysql_real_escape_string($this->AT_id_nacionalidad),
			mysql_real_escape_string($this->AT_id_persona));
			
			
		$this->stmt = $this->conexion->ejecutar($this->query);
			if($this->stmt)
			{
			echo "<center><div  class='alert alert-success'>LOS DATOS ".$this->AT_nombre_persona." SE MODIFICARON SATISFACTORIAMENTE!</div></center>";
			$this->GT = new GestionarPersona($this->AT_id_persona);
			return $this->GT -> consultar();
			}
			else
				{
				echo "<center><div class='alert alert-error'> NO FUE POSIBLE ACTUALIZAR LA INFORMACIÓN, CONTACTE EL ADMINISTRADOR! (ERROR EN LA CONSULTA)</div></center>";
				}

	}
}

class GestionarPersona {

	  private $p_IdPersona; 
	  private $table; 
	  private $Cllave1; 
	  private $Cllave2; 
  	  private $conexion;
	  private $stmt;
	  private $query;

	public function __construct($idPersona=0)
	  {
		$this->p_IdPersona = $idPersona; 

		$this->table 	= "persona"; //TABLA
		$this->Cllave1 	= "id_persona"; //CAMPO LLAVE
		$this->conexion = Conexion::getInstance();
	  }

	public function eliminar()
	  {
		$status = "";
		$this->query = sprintf("DELETE FROM ".$this->table." WHERE ".$this->Cllave1." = '%s';", 
		mysql_real_escape_string($this->p_IdPersona));
		
		$this->stmt = $this->conexion->ejecutar($this->query);
		if($this->stmt)
		
				{
				$this->limpiar();
				echo "<center><div  class='alert alert-success'> SE HA ELIMINADO EL REGISTRO DE MANERA CORRECTA!! </div></center>";
				} 
				else 
					{
					echo  "<center><div class='alert alert-error'> NO FUE POSIBLE ELIMINAR EL REGISTRO, CONTACTE EL ADMINISTRADOR! (ERROR EN LA CONSULTA)</div></center>";
					}

				$this->limpiar();
	  }

	public function consultar()
	  {
	  	$this->query = sprintf("SELECT id_persona, nombre_persona, apellido, fecha_nacimiento, direccion, telefono, email,  tipo_documento ,estado_habilitado, id_area, id_nacionalidad FROM pruebita.persona WHERE id_persona = '%s'",
		mysql_real_escape_string($this->p_IdPersona));
		
		$stmt= $this->conexion->ejecutar($this->query);	
		$x = $this->conexion->obtener_fila($stmt,0);
		if($x>0)
		{
		$R1 = $x['id_persona'];
		$R2 = $x['nombre_persona'];
		$R3 = $x['apellido'];
		$R4 = $x['fecha_nacimiento'];
		$R5 = $x['direccion'];
		$R6 = $x['telefono'];
		$R7 = $x['email'];
		$R8 = $x['tipo_documento'];
		$R9 = $x['estado_habilitado'];
		$R10 = $x['id_area'];
		$R11 = $x['id_nacionalidad'];
	
		
		return array($R1, $R2, $R3, $R4, $R5, $R6, $R7,$R8,$R9,$R10,$R11 );											
		}
		else
			{
			$status = "<center><div  class='alert alert-info'>SU BÚSQUEDA NO ARROJÓ RESULTADOS, PRUEBE CON OTRO CRITERIO.</div></center>";	
			$this->limpiar();	
			echo $this->query;		
			}
			echo "$status";
	  }
	  
	public function limpiar()
	  {
		unset($R1, $R2, $R3, $R4, $R5, $R6,  $R7, $R8,  $R9, $R10,$R11);
		return array($R1, $R2, $R3, $R4, $R5, $R6,  $R7, $R8, $R9, $R10,$R11);				
	  }

	public function consultarTodos()
	{
		$this->query = sprintf("SELECT id_persona,nombre_persona, apellido,fecha_nacimiento, direccion, telefono, email, tipo_documento,IF(persona.estado_habilitado = 1,'SI', 'NO') AS HABILITADO,nombre_area,nombre_nacionalidad
FROM persona join nacionalidad on  persona.id_nacionalidad = nacionalidad.id_nacionalidad join area on persona.id_area = area.id_area
order by apellido;");
		$stmt = $this->conexion->ejecutar($this->query);	
		include("inclusiones/include_personas.php");
	}
}
?>

