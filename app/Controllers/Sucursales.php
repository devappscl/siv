<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SucursalesModels;

class Sucursales extends BaseController
{
    public function __construct(){

        $this->sucursales = New SucursalesModels();

    }

    public function index()
	{

        	// Verificar si ha iniciado sesión
	$sesion = session();
	if(!$sesion->sesion){
		return redirect()->to(base_url('/auth'));
	}
        $sucursales = $this->sucursales->findAll();
        
        $data = ['titulo' => 'Sucursales', 'datos' => $sucursales];

		echo view('header');
		echo view('sucursales/list', $data);
		echo view('footer');

	}

    public function add(){

        $data = ['titulo' => 'Sucursales'];
        echo view('header');
		echo view('sucursales/add', $data);
		echo view('footer');
        
    }

    public function store(){

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'direccion' => $this->request->getPost('direccion'),
            'telefono' => $this->request->getPost('telefono'),
            'nombrecorto' => $this->request->getPost('nombrecorto'),

        ];

        $this->sucursales->save($data);

        return redirect()->to(base_url('/sucursales'));

    }

}