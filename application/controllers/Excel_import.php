<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_import extends CI_Controller {	
    public function __construct() {
        parent::__construct();   
  
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->helper('url');  
        $this->load->database();  
     }
	public function index()
	{
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}

    public function mostrar()
    {         
        if(isset($_FILES["excel-file"]["name"]))
		{  
            $idEmpresa = $this->input->post('id-empresa');
            $cerradura = $this->input->post('cerradura');
            
            $path = $_FILES["excel-file"]["tmp_name"];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();            
            // Convert spread sheet to array
            $data = $worksheet->toArray();
            // Getting the headings values and combining with the rows
            $headings = array_shift($data);
            array_walk(
                $data,
                function (&$row) use ($headings) {
                    $row = array_combine($headings, $row);
                }
            );

            $ubicaciones = [];
            $herramientas = [];
            
            $maxIdUbicacion = $this->db->query('Select MAX(idUbicacion) as maxIdUbicacion from ubicaciones 
            ')->row()->maxIdUbicacion;
            $maxIdUbicacion++;

            $maxIdHerramienta = $this->db->query('Select MAX(idUbicacion) as maxIdHerramienta from herramientas 
            ')->row()->maxIdHerramienta;
            $maxIdHerramienta++;

            // Setting ubicaciones data
            foreach($data as $row) {
                if(!empty($row['Location'])) {
                    $ubicaciones[] = $this->fillUbicacion(
                       $row['Location'], 
                       $maxIdUbicacion, 
                       $cerradura
                    );
                    $maxIdUbicacion++;
                }
                if(!empty($row['M Location'])) {                    
                    $ubicaciones[] = $this->fillUbicacion(
                        $row['M Location'], 
                        $maxIdUbicacion, 
                        $cerradura
                    );
                    $maxIdUbicacion++;
                }
            }
           
            echo '<pre>';
            var_dump($ubicaciones);
            exit;
            $this->load->view('header');
            $this->load->view('salida', ['usuarios' => $data]);
            $this->load->view('footer');          
        }        

    }

    public function fillUbicacion($ubicacion, $id, $cerradura = 0)
    {
        return [
            'idUbicacion' => $id,
            'descripcion' => $ubicacion,
            'idGrupo' => 1,
            'idSucursal' => 1,
            'idCerradura' => $cerradura,
            'estado' => 'activo',
        ];
    }

    public function defaulToolValues()
    {
        return [
            'valor' => 0,
            'valorRecidual' => 0,
            'fechaInicio' => date('Y-m-d'),
            'fechaFin' => date('Y-m-d'),
            'valorRecidual' => 0,
            'daniada' => 0,
            'prestada' => 0,
            'observacionesPrestada' => 0,
            'consumible' => 0,
            'stock' => 0,
            'stockMinimo' => 0,
            'fechaAlta' => date('Y-m-d H:i'),
            'fechaBaja' => date('Y-m-d H:i'),
            'idUbicacionAlternativa' => date('Y-m-d H:i'),
        ];
    }

    public function storeUsers()
    {
        $usuarios = $this->input->post('usuarios');
        foreach($usuarios as $usuario) {
            $usuario['fechaAlta'] = date('Y-m-d H:i' ,strtotime($usuario['fechaAlta']));
            $usuario['fechaBaja'] = date('Y-m-d H:i' ,strtotime($usuario['fechaBaja']));
            $this->db->insert('usuarios', $usuario);
        }
        echo json_encode(["status" => "success"]);
    }

    public function storeAdminUsers()
    {
        $usuarios = $this->input->post('usuarios');       
        $this->db = $this->load->database( 'zf2xzpil_tg__admin' ,true);
        foreach($usuarios as $usuario) {
            $usuario['fechaAlta'] = date('Y-m-d H:i' ,strtotime($usuario['fechaAlta']));
            $usuario['fechaBaja'] = date('Y-m-d H:i' ,strtotime($usuario['fechaBaja']));
            $this->db->insert('usuarios', $usuario);         
        }
        echo json_encode(["status" => "success"]);
    }

}
