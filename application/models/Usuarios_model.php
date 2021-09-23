<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuarios_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function usuarios()
	{
		//$this->db = $this->load->database( $baseDatos ,true);
		//$this->db->order_by('usuario','asc');
		$usuarios= $this->db->get('usuarios');
		if($usuarios->num_rows()>0)
		{
			return $usuarios->result();
		}
	}
	
	public function altaLicenciaUsuario($idUsuario, $idEmpresa,$nombreEmpresa,$emailUsuarioLogeado,$idVendedor, $baseDatos)
	{
		$usuario = "";
		$cantLicenciasCompradas = 0;
		$idVendedor = 0;
		$licenciasActivas = 0;
		$estado = 'Pendiente';
		
		$this->db = $this->load->database( $baseDatos ,true);

	    $query = $this->db->query("SELECT * FROM usuarios WHERE idUsuario = " . $idUsuario);

        foreach ($query->result() as $oc_row)
        {

		    $usuario = $oc_row->usuario;
			$email = $oc_row->email;
			$password = $oc_row->password;
			$perfil = $oc_row->tipo;
			$idIdioma = $oc_row->idIdioma;
			
        }
        
        $licenciasActivas = $this->get_LicenciasActivas();
        
        $query = $this->get_LicenciasCompradasEmpresa($idEmpresa);
        
        foreach ($query->result() as $oc_row)
        {
		    $cantLicenciasCompradas = $oc_row->cantLicencias;
			$idVendedor = $oc_row->idVendedor;
        }
        
        if($idVendedor == 2 && ($cantLicenciasCompradas > $licenciasActivas)){
            $estado = 'Activo';
        }
        if($idVendedor != 2 ){
            $estado = 'Activo';
        }
        
		if($usuario <> "")
		{
			$this->db = $this->load->database( 'zf2xzpil_TG__admin' ,true);
			
			$data = array(
			   'usuario' => $usuario ,
			   'email' => $email ,
			   'password' => $password ,
			   'perfil' => $perfil ,
			   'idIdioma' => $idIdioma ,
			   'idEmpresa' => $idEmpresa ,
			   'fechaAlta' => date('Y-m-d H:i:s'), 
			   'fechaBaja' => date('Y-m-d H:i:s'),
			   'estado' => $estado

			);

			$this->db->insert('usuarios', $data); 

			$insert_id = $this->db->insert_id();
			
			$this->db = $this->load->database( $baseDatos ,true);
			
			$data = array(
				'idUsuarioAdmin' => $insert_id ,
				'idEmpresa' => $idEmpresa
			);

			$this->db->where('idUsuario', $idUsuario);
			
			$this->db->update('usuarios', $data);
			
			$asunto = "Aviso de Alta de Nuevo Usuario";
			$cuerpo = "Usuario: " . $email . " Email: " . $email . "      -----Empresa: " . $nombreEmpresa;
			$destino = "info@toolsguard.com";
			
			
			$this->enviarAviso($asunto, $cuerpo, $destino);
			
			if($idVendedor == 2 && ($cantLicenciasCompradas > $licenciasActivas)){
				$asunto = "New Toolsguard License";
				$cuerpo = "We have received a request to activate a new user: " . $email . "\n . " ;
								
				$this->enviarAviso($asunto, $cuerpo, $emailUsuarioLogeado);
			}
		}

		
	}
	
	
	public function editarDatosLicenciaUsuario($idUsuario, $idEmpresa,$nombreEmpresa, $baseDatos)
	{
		$idUsuarioAdmin = 0;
		$this->db = $this->load->database( $baseDatos ,true);

	    $query = $this->db->query("SELECT * FROM usuarios WHERE idUsuario = " . $idUsuario);

        foreach ($query->result() as $oc_row)
        {

		    $idUsuarioAdmin = $oc_row->idUsuarioAdmin;
			$estado = $oc_row->estado;
			$password = $oc_row->password;
			$idIdioma = $oc_row->idIdioma;
			$usuario = $oc_row->usuario;
			$perfil = $oc_row->tipo;
			$email = $oc_row->email;
			
        }
		if($idUsuarioAdmin <> 0)
		{
			$this->db = $this->load->database( 'zf2xzpil_TG__admin' ,true);
			
			if($estado == 'Activo'){
				$data = array(
					'password' => $password ,
					'usuario' => $usuario ,
					'email' => $email ,
					'perfil' => $perfil ,
					'idIdioma' => $idIdioma
				);

			} else {
				$data = array(
					'estado' => $estado ,
					'password' => $password ,
					'usuario' => $usuario ,
					'email' => $email ,
					'perfil' => $perfil ,
					'idIdioma' => $idIdioma
				);
			}
			$this->db->where('idUsuario', $idUsuarioAdmin);
			
			$this->db->update('usuarios', $data);
			
			if($estado == "Inactivo")
			{
				$asunto = "Aviso de Edicion de Usuario Inactivo";
				$cuerpo = "Usuario: " . $email . " Email: " . $email . "      ------Empresa: " . $nombreEmpresa;
				$destino = "info@toolsguard.com";
				
				
				$r = $this->enviarAviso($asunto, $cuerpo, $destino);
				return true;
			}
		
		}

		
	}
	
	public function get_LicenciasActivas()
	{
		
		$query = $this->db->query("SELECT COUNT(*) as cantidad FROM usuarios where estado = 'Activo' AND (tipo = 0 OR tipo = 2) ");
		$cantidad = 0;
	
		foreach ($query->result() as $oc_row)
		{
			$cantidad = $oc_row->cantidad;
		}
                
		return $cantidad;
	}
	
	public function get_LicenciasCompradasEmpresa($idEmpresa)
	{
		$this->db = $this->load->database( 'zf2xzpil_TG__admin' ,true);
	
		$query = $this->db->query("SELECT idVendedor, cantLicencias FROM empresas WHERE eliminado = 0 and idEmpresa = " . $idEmpresa);
        
		return $query;
	}
	
	
	
	
		
			

	
	
	
	
	
	
}