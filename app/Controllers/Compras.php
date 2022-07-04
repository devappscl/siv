<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModels;
use App\Models\ProductosModels;
use App\Models\SucursalesModels;
use App\Models\UsuariosModels;
use App\Models\ProveedoresModels;

class Compras extends BaseController
{
   
    public function __construct(){

        $this->usuarios = New UsuariosModels();
        $this->compras = New ComprasModels();
        $this->productos = New ProductosModels();
        $this->sucursales = New SucursalesModels();
        $this->proveedores = New ProveedoresModels();
        helper('number');

    }


    public function index(){

            // Verificar si ha iniciado sesión
            $sesion = session();
            if(!$sesion->sesion){
                return redirect()->to(base_url('/auth'));
            }


        $this->compras->where("compras.delivery_at >= CURRENT_DATE()");
        $this->compras->where("compras.sucursal",session('sucursal'));
        $this->compras->join("proveedores","compras.proveedor_id = proveedores.id");
        $this->compras->orderby("compras.delivery_at asc");
        $compraslist = $this->compras->findAll();

        $proveedor = $this->proveedores->findAll();
        

            $data = [
                'titulo' => 'Compras / Proveedores', 
                'compras' => $compraslist,
                'proveedores' => $proveedor,
            ];

		echo view('header');
		echo view('compras/list',$data);
		echo view('footer');
    }

    public function store(){
       

        $data = [
           
           
            'total' => $this->request->getPost('total'),
            'proveedor_id' => $this->request->getPost('proveedor_id'),
            'sucursal' => session('sucursal'),
            'vendedor' => session('rut'),
            'detalle' => $this->request->getPost('detalle'),
            'delivery_at' => $this->request->getPost('delivery_at'),
            
        ];

        $this->compras->save($data);

        return redirect()->to(base_url('/compras'));

    }


}

?>