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
        $this->form_validation->set_rules('id-empresa', 'Id-empresa', 'required|numeric', [
            'required' => 'El campo ID empresa es requerido',
            'numeric' => 'El campo ID empresa debe ser un número',
        ]);
        $this->form_validation->set_rules('index-start', 'index-start', 'required|numeric', [
            'required' => 'El campo primera fila es requerido',
            'numeric' => 'El campo primera fila debe ser un número',
        ]);        

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('index.php/excel'));
        }
        
        if(isset($_FILES["excel-file"]["name"]))
		{      
            $this->db = $this->load->database( 'zf2xzpil_tg__admin' ,true);
            //Find max id from admin.usuarios table
            $maxIdUsuario = $this->db->query('Select MAX(idUsuario) as maxIdUsuario from usuarios 
            ')->row()->maxIdUsuario;

            $maxIdUsuario++;

            $path = $_FILES["excel-file"]["tmp_name"];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
                    
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            $data = [];
            $rowStart = $this->input->post('index-start');
            $idEmpresa = $this->input->post('id-empresa');

            for ($row = $rowStart; $row <= $highestRow; ++$row) {
                if(empty($worksheet->getCellByColumnAndRow(1, $row)->getValue())) {
                    break;
                }

                $firstName = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $lastName = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $isAdmin = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $cellNumber = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $email = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                $data[] = [
                    'idUsuario' => $maxIdUsuario,
                    'usuario' => $lastName,
                    'apellido' => $lastName,
                    'nombre' => $firstName,
                    'dni' => 0,
                    'celular' => $cellNumber,
                    'idSucursal' => 1,
                    'email' => $email,
                    'password' => rand(0,9).rand(0,9).rand(0,9),
                    'estado' => 'Activo',
                    'perfil' => $isAdmin === 'Y' ? 2 : 0,
                    'tipo' => $isAdmin === 'Y' ? 2 : 0,
                    'imagen' => '-',
                    'idIdioma' => 1,
                    'fechaAlta' => date('d-m-Y H:i'),
                    'fechaBaja' => date('d-m-Y H:i'),
                    'idEmpresa' => $idEmpresa,
                    'idUsuarioAdmin' => $maxIdUsuario,
                ];                
               
                $maxIdUsuario++;
            }
               
            $this->load->view('header');
            $this->load->view('salida', ['usuarios' => $data]);
            $this->load->view('footer');          
        }        

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
