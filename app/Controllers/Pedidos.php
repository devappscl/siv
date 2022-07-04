<?php

namespace App\Controllers;

use App\Models\SucursalesModels;
use App\Models\ProductosModels;
use App\Models\VentasModels;
use App\Models\StockModels;

class Pedidos extends BaseController
{

	public function __construct(){

		$this->sucursales = New SucursalesModels();
		$this->productos = New ProductosModels();
		$this->ventas = New VentasModels();
		$this->stock = New StockModels();
	
    }

	public function index(){
		// Verificar si ha iniciado sesión
		$sesion = session();
		if(!$sesion->sesion){
			return redirect()->to(base_url('/auth'));
		}

		$data = ['titulo' => 'Pedidos'];


		echo view('header');
		echo view('pedidos/list',$data);
		echo view('footer');
	}

}