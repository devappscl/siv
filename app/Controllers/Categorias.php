<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModels;


class Categorias extends BaseController
{
    public function __construct(){

        $this->categorias = New CategoriasModels();

    }

    public function index()
	{

        	// Verificar si ha iniciado sesión
	$sesion = session();
	if(!$sesion->sesion){
		return redirect()->to(base_url('/auth'));
	}
    
        $categorias = $this->categorias->findAll();
       
        
        $data = ['titulo' => 'Categorías', 'datos' => $categorias];

		echo view('header');
		echo view('categorias/list', $data);
		echo view('footer');

	}

    public function add(){

        $data = ['titulo' => 'Nueva Categoría'];
        echo view('header');
		echo view('categorias/add', $data);
		echo view('footer');
        
    }

    public function store(){

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'estado' => 1,
        ];

        $this->categorias->save($data);

        return redirect()->to(base_url('/categorias'));

    }

}