<?php

namespace App\Controllers;

use App\Models\SucursalesModels;
use App\Models\ProductosModels;
use App\Models\VentasModels;
use App\Models\StockModels;
use App\Models\VentasDetalleModels;

class Home extends BaseController
{

	public function __construct(){

		$this->sucursales = New SucursalesModels();
		$this->productos = New ProductosModels();
		$this->ventas = New VentasModels();
		$this->ventasdetalle = New VentasDetalleModels();		
		$this->stock = New StockModels();
	
    }

	public function index(){
		
	
		// Verificar si ha iniciado sesión
		$sesion = session();
		if(!$sesion->sesion){
			return redirect()->to(base_url('/auth'));
		}

		$locales = $this->sucursales->findAll(); //BUSCA LAS SUCURSALES
		
		$titulo = NombreSucursal(session('sucursal'));

		$this->ventas->select('usuarios.username,ventas.vendedor, SUM(ventas.total) as total');
        $this->ventas->join('usuarios','usuarios.rut = ventas.vendedor');
		$this->ventas->where("ventas.created_at >= CURDATE()");
        $this->ventas->where("ventas.vendedor",session('rut'));
        $this->ventas->groupBy('ventas.vendedor');
        $statventas = $this->ventas->findAll();

        if(session('rol') <> '777'){
			$this->ventas->where("ventas.vendedor",session('rut'));
		}
		$this->ventas->where("ventas.sucursal",session('sucursal'));
        $this->ventas->where("ventas.created_at >= CURDATE()");
		$this->ventas->orderBy("ventas.created_at DESC");
        $ultimasventas = $this->ventas->limit(10)->findAll(20);


        $this->ventas->select('HOUR(created_at) AS horas,COUNT(total) AS total');
        $this->ventas->where("created_at >= CURDATE()");
        if(session('rol') <> '777'){
			$this->ventas->where("ventas.vendedor",session('rut'));
		}
		$this->ventas->where("ventas.sucursal",session('sucursal'));
        $this->ventas->groupBy('horas');
        $ventashoras = $this->ventas->findAll();

        $this->ventasdetalle->select('ventadetalle.producto_id, SUM(ventadetalle.cantidad) AS cantidad, producto.nombre');
        $this->ventasdetalle->join('producto','producto.codigo = ventadetalle.producto_id');
        $this->ventasdetalle->where('user_id',session('rut'));
        $this->ventasdetalle->groupBy('ventadetalle.producto_id');
        $this->ventasdetalle->OrderBy('cantidad DESC');
        
        $masvendidosxmi = $this->ventasdetalle->findAll(10);
       
			$data = [
				'titulo' => $titulo,
        		'statventas' => $statventas,
        		'ventashoras' => $ventashoras,
       			'ultimasventas' => $ultimasventas,
        		'masvendidosxmi' => $masvendidosxmi,
				'locales' => $locales,	
			];

			echo view('header');
			echo view('home/home',$data);
			echo view('footer');

}

public function cambiarsucursal(){

	$session = session();
	
	$session->set('sucursal',$this->request->getPost('sucursal'));

	return redirect()->to(base_url());
}

public function autoproducto()
{
	$returnData = array();

   $valor = $this->request->getGet('term');

	$this->productos->like('nombre',$valor);
	$this->productos->orLike('codigo',$valor);
	$this->productos->where('estado',1);

	$articulos = $this->productos->findAll();
  
	if(!empty($articulos)){
		foreach($articulos as $row){
			$data['id'] = $row['id'];
			$data['value'] = $row['pventa'];
			$data['label'] = $row['codigo'] . " - " . $row['nombre'];
			array_push($returnData,$data);
		}
		
	}

	echo json_encode($returnData);

}

// DATOS A MOSTRAR VIA AJAX EN HOME
public function CargaData(){

	$returnData = array();

	//VENTAS DEL DÍA
	$this->ventas->Select('SUM(total) AS suma');
	$this->ventas->where("MONTH(created_at) = MONTH(CURDATE())");
	$this->ventas->where("DAY(created_at) = DAY(CURDATE())");
	//DETERMINAR TURNO A MOSTRAR MAÑANA O TARDE
	if(date("H") < 15){
		$this->ventas->where("HOUR(created_at) >= '08'");
		$this->ventas->where("HOUR(created_at) < '15'");
	}elseif(date("H") >= 15){
		$this->ventas->where("HOUR(created_at) >= '15'");
		$this->ventas->where("HOUR(created_at) < '23'");
	}
	$this->ventas->where("sucursal",session("sucursal"));
	$ventas = $this->ventas->first();



	//PRODUCOS EN STOCK
	$this->stock->select('COUNT(*) AS total');
	$this->stock->where('sucursal',session('sucursal'));
	$stock = $this->stock->get()->getRow();

	$productos = $this->productos->countAll(); //TOTAL PRODUCTOS

	$sucursales = $this->sucursales->countAll(); //TOTAL SUCURSALES

	$data['ventas'] = $ventas;
	$data['stock'] = $stock;
	$data['productos'] = $productos;
	$data['sucursales'] = $sucursales;
	
	array_push($returnData,$data);

	echo json_encode($returnData);

}

public function grafico(){
	


	//VENTAS POR HORA
	$this->ventas->select('HOUR(created_at) AS horas,COUNT(total) AS total,SUM(total) as dinero');
    $this->ventas->where("created_at >= CURDATE()");
	$this->ventas->where("ventas.sucursal",session('sucursal'));
    $this->ventas->groupBy('horas');
    $ventasxhora = $this->ventas->findAll();

	$data = array();
		foreach ($ventasxhora as $row) {
		$data[] = $row;
	}

	echo json_encode($data);
	
}



public function popup(){
	echo view('home/popup');
}



}

