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
            $toolNumber = $this->input->post('tool-number');
            $inv = $this->input->post('inv');
            $mulInv = $this->input->post('mul-inv');
            $location = $this->input->post('location');
            $mulLocation = $this->input->post('mul-location');
            $description = $this->input->post('description');
            $idEmpresa = $this->input->post('id-empresa');
            $cerradura = $this->input->post('cerradura');
            $tipos = $this->input->post('tipos');
            $idMarca = $this->input->post('id-marca');
            $notas = $this->input->post('notas');

            $toolNumberIndex = $this->letterToNumber($toolNumber);
            $invIndex = $this->letterToNumber($inv);
            $mulInvIndex = $this->letterToNumber($mulInv);
            $locationIndex = $this->letterToNumber($location);
            $mulLocationIndex = $this->letterToNumber($mulLocation);
            $descriptionIndex = $this->letterToNumber($description);

            // Get indexes of tipos string.. Ej: 'I,J,K' => [8,9,10]
            $tiposIndexes = explode(',', $tipos);
            foreach($tiposIndexes as $key => $tipo) {
                $tiposIndexes[$key] = $this->letterToNumber($tipo);
            }
            // Get indexes of notas string.. Ej: 'I,J,K' => [8,9,10]
            $notasIndexes = explode(',', $notas);
            foreach($notasIndexes as $key => $nota) {
                $notasIndexes[$key] = $this->letterToNumber($nota);
            }
            
            $path = $_FILES["excel-file"]["tmp_name"];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();            
            // Convert spread sheet to array
            $data = $worksheet->toArray();
            // Remove first row
            array_shift($data);      

            $ubicaciones = [];
            $ubicacionesData = [];
            $herramientas = [];
            
            $maxIdUbicacion = $this->db->query('Select MAX(idUbicacion) as maxIdUbicacion from ubicaciones 
            ')->row()->maxIdUbicacion;
            $maxIdUbicacion++;

            $maxIdHerramienta = $this->db->query('Select MAX(idHerramienta) as maxIdHerramienta from herramientas 
            ')->row()->maxIdHerramienta;
            $maxIdHerramienta++;

            
            foreach($data as $row) {
                $locationField = null;
                $mulLocationField = null;
                // Setting ubicaciones data
                if(!empty($row[$locationIndex])) {
                    // Check if location exist
                    $location = $row[$locationIndex];                   
                    if(!isset($ubicaciones[$location])) {
                        $ubicaciones[$location] = $maxIdUbicacion;
                        $locationField = $maxIdUbicacion;
                        $ubicacionesData[] = $this->fillUbicacion(
                            $location, 
                            $locationField, 
                            $cerradura
                        );
                        $maxIdUbicacion++;
                    }else {
                        $locationField = $ubicaciones[$location];                         
                    }   
                }
                if(!empty($row[$mulLocationIndex])) {
                    // Check if location exist                   
                    $mulLocation = $row[$mulLocationIndex];                                  
                    if(!isset($ubicaciones[$mulLocation])) {
                        $ubicaciones[$mulLocation] = $maxIdUbicacion;
                        $mulLocationField = $maxIdUbicacion;
                        $ubicacionesData[] = $this->fillUbicacion(
                            $mulLocation, 
                            $mulLocationField, 
                            $cerradura
                        );
                        $maxIdUbicacion++;
                    }else {
                        $mulLocationField = $ubicaciones[$mulLocation];
                    }                       
                }
                //Get tipos                
                $tipoField = $this->getTipo($row, $tiposIndexes);                

                $notaField = $this->getNota($row, $notasIndexes);
                $invField = $row[$invIndex];
                $mulInvField = $row[$mulInvIndex];
                // Remove ' and " from description
                $descriptionField =  str_replace(['"',"'"], '', $row[$descriptionIndex]) ;
                $toolNumberField = $row[$toolNumberIndex];
                $detalleToolNumber = str_replace([' ','-','_' ], '', $toolNumberField);
                
                // How many tools create for inv
                $numberOfInv = (empty($invField)) ? 1 : $invField;
                $numberOfMulInv = (empty($mulInvField)) ? 1 : $mulInvField;               
                
                // Add tools for every number of inv
                for($i = 1; $i <= $numberOfInv; $i++) {
                    $herramientas[] = array_merge([
                        'idHerramienta' => $maxIdHerramienta,
                        'codigo' => $maxIdHerramienta.$toolNumberField.$idMarca,
                        'descripcion' => empty($descriptionField) ? 'Special Tool' : $descriptionField,
                        'idTipo' => $tipoField,
                        'idMarca' => $idMarca,
                        'estado' => (empty($invField)) ? 'Inactivo' : 'Activo',
                        'nroSerie' => $toolNumberField,
                        'detalle' => $notaField.'0'.$detalleToolNumber,
                        'idUbicacion' => $locationField,
                        'imagen' => $toolNumberField.'.jpg',
                    ], $this->defaulToolValues());
                   
                    $maxIdHerramienta++;
                }  
                
                if(!empty($mulInvField)) {
                    //Add tools for every number of inv
                    for($i = 1; $i <= $numberOfInv; $i++) {
                        $herramientas[] = array_merge([
                            'idHerramienta' => $maxIdHerramienta,
                            'codigo' => $maxIdHerramienta.$toolNumberField.$idMarca,
                            'descripcion' => empty($descriptionField) ? 'Special Tool' : $descriptionField,
                            'idTipo' => $tipoField,
                            'idMarca' => $idMarca,
                            'estado' => (empty($mulInvField)) ? 'Inactivo' : 'Activo',
                            'nroSerie' => $toolNumberField,
                            'detalle' => $notaField.'0'.$detalleToolNumber,
                            'idUbicacion' => $mulLocationField,
                            'imagen' => $toolNumberField.'.jpg',
                        ], $this->defaulToolValues());
                    
                        $maxIdHerramienta++;
                    }  
                }
            }          
            $this->load->view('header');
            $this->load->view('salida', [
                'tools' => $herramientas,
                'ubicaciones' => $ubicacionesData,
            ]);
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
            'idUnidad' => 1,
            'fechaAlta' => date('Y-m-d H:i'),
            'fechaBaja' => date('Y-m-d H:i'),
            'idSucursal' => 1,
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

    public function getTipo($row, $indexes)
    {
        $string = '';
        foreach ($indexes as $index) {
            if(!empty($row[$index])) {
                $value = trim($row[$index], '*');
                $string .= $value.','; 
            }
        }
        $string = rtrim($string, ',');
        if(stripos($string, 'E') !== false) {
            return 23;
        }
        if(stripos($string, 'R') !== false) {
            return 22;
        }
        if(stripos($string, 'A') !== false) {
            return 21;
        }
        if(stripos($string, 'L') !== false || stripos($string, 'Legacy') !== false) {
            return 20;
        }
        return 1;
    }

    public function getNota($row, $indexes)
    {
        $result = '';
        foreach ($indexes as $index) {
            if(!empty($row[$index]))
                $result .= $row[$index].'|'; 
        }
        return $result;
    }

    public function storeUbicaciones()
    {
        $ubicaciones = $this->input->post('ubicaciones');
        foreach($ubicaciones as $ubicacion) {                
            $this->db->insert('ubicaciones', $ubicacion);
        }
        echo json_encode(["status" => "success"]);
    }

    public function storeHerramientas()
    {
        $herramientas = $this->input->post('herramientas');          
        foreach($herramientas as $herramienta) {           
            $this->db->insert('herramientas', $herramienta);         
        }
        echo json_encode(["status" => "success"]);
    }

}
