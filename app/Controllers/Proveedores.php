<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProveedoresModels;
use App\Models\ProductosModels;

class Proveedores extends BaseController
{
    public function __construct(){

        $this->proveedores = New ProveedoresModels();
        $this->productos = New ProductosModels();

    }

    public function index()
	{

        	// Verificar si ha iniciado sesión
	$sesion = session();
	if(!$sesion->sesion){
		return redirect()->to(base_url('/auth'));
	}
    
        $proveedores = $this->proveedores->findAll();
       
        
        $data = ['titulo' => 'GESTIÓN PROVEEDORES', 'datos' => $proveedores];

		echo view('header');
		echo view('proveedores/list', $data);
		echo view('footer');

	}

    public function add(){

        $data = ['titulo' => 'AGREGAR PROVEEDOR'];
        echo view('header');
		echo view('proveedores/add', $data);
		echo view('footer');
        
    }

    public function store(){

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'estado' => 1,
        ];

        $this->proveedores->save($data);

        return redirect()->to(base_url('/proveedores'));

    }

}