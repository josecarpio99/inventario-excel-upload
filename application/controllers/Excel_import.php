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
            $tipos = $this->input->post('tipos');
            $idMarca = $this->input->post('id-marca');
            $notas = $this->input->post('notas');

            // Get indexes of tipos string.. Ej: 'I,J,K' => [8,9,10]
            $tipos = explode(',', $tipos);
            foreach($tipos as $key => $tipo) {
                $tipos[$key] = $this->letterToNumber($tipo);
            }
            // Get indexes of notas string.. Ej: 'I,J,K' => [8,9,10]
            $notas = explode(',', $notas);
            foreach($notas as $key => $nota) {
                $notas[$key] = $this->letterToNumber($nota);
            }  
            // echo "<pre>";
            //         var_dump('' ?? 'algo');
            //         exit;          
            
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

            $maxIdHerramienta = $this->db->query('Select MAX(idHerramienta) as maxIdHerramienta from herramientas 
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
                //Get tipos
                $rowValues = array_values($row);
                $idTipo = '';
                foreach ($tipos as $tipoIndex) {
                    if(!empty($rowValues[$tipoIndex]))
                        $idTipo .= $rowValues[$tipoIndex].','; 
                }
                $idTipo = rtrim($idTipo, ',');

                $notasInfo = '';
                foreach ($notas as $notaIndex) {
                    if(!empty($rowValues[$notaIndex]))
                        $notasInfo .= $rowValues[$notaIndex].'|'; 
                }
                $notasInfo = rtrim($notasInfo, '|');

                //How many tools create for row
                $numberToolsForRow = ((!empty($row['Inv'])) ? $row['Inv'] : 0) + 
                               ((!empty($row['M Inv'])) ? $row['M Inv'] : 0);
                
                $numberToolsForRow = $numberToolsForRow == 0 ? 1 : $numberToolsForRow;   
                
                for($i = 1; $i <= $numberToolsForRow; $i++) {
                    $herramientas[] = array_merge([
                        'idHerramienta' => $maxIdHerramienta,
                        'codigo' => $maxIdHerramienta.$row['ToolNo'].$idMarca,
                        'descripcion' => $row['Description'],
                        'idTipo' => $idTipo,
                        'idMarca' => $idMarca,
                        'estado' => 'Activo',
                        'nroSerie' => $row['ToolNo'],
                        'datalle' => $notasInfo.'0'.$row['ToolNo'],
                        'idUbicacion' => '1', //TODO
                        'imagen' => $row['ToolNo'].'.jpg',
                    ], $this->defaulToolValues());
                   
                    $maxIdHerramienta++;
                }                 
            }
           
            echo "<pre>";
                    var_dump($herramientas);
                    exit;
            // echo '<pre>';
            // var_dump($ubicaciones);
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
            'idUbicacionAlternativa' => null,
        ];
    }

    public function letterToNumber($letter)
    {
        if ($letter)
            return ord(strtolower($letter)) - 96 - 1;
        else
            return 0;
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
