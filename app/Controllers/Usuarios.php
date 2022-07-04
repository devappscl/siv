<?php

	

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModels;
use App\Models\SucursalesModels;

class Usuarios extends BaseController
{
    public function __construct(){


        $this->usuarios = New UsuariosModels();
        $this->sucursales = New SucursalesModels();

    }

    public function index()
	{

       	// Verificar si ha iniciado sesión
	$sesion = session();
	if(!$sesion->sesion){
		return redirect()->to(base_url('/auth'));
	}

        $this->usuarios->where('rol',1);
       $usuarios = $this->usuarios->findAll();
        
        $data = ['titulo' => 'Usuarios','datos' => $usuarios];

		echo view('header');
		echo view('usuarios/list', $data);
		echo view('footer');
	}

	public function dataTables(){

		$this->usuarios->select("CONCAT(nombres,' ',apaterno,' ',amaterno) AS ncompleto,username,rol");
        $users = $this->usuarios->findAll();
    
        return json_encode($users);
	    
    }

    public function add()
	{
       
        
        $data = ['titulo' => 'Nuevo Usuario'];

		echo view('header');
		echo view('usuarios/add', $data);
		echo view('footer');
	}

	public function store(){

        $data = [
            'rut' => $this->request->getPost('rut'),
            'dv' => $this->request->getPost('dv'),
			'username' => $this->request->getPost('username'),
            'nombres' => $this->request->getPost('nombres'),
            'apaterno' => $this->request->getPost('apaterno'),
			'amaterno' => $this->request->getPost('amaterno'),
			'password' => $this->request->getPost('password'),
			'telefono' => $this->request->getPost('telefono'),
			'rol' => $this->request->getPost('rol'),

        ];

        $this->usuarios->save($data);

		session()->setFlashdata('msg', 'Usuario creado con éxito.');

        return redirect()->to(base_url('/usuarios'));

    }


    



   

}