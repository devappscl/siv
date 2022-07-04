<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StockModels;
use App\Models\ProductosModels;
use App\Models\SucursalesModels;
use App\Models\ProveedoresModels;
use App\Models\CarritoModels;

class Stock extends BaseController
{
    protected $stock;

    public function __construct(){

       

        $this->stock = New StockModels();
        $this->sucursales = New SucursalesModels();
        $this->productos = New ProductosModels();
        $this->proveedores = New ProveedoresModels();
        $this->carro = New CarritoModels();

    }

    //PÁGINA PRINCIPAL
	public function index()
	{

   // Verificar si ha iniciado sesión
	$sesion = session();
	if(!$sesion->sesion){
		return redirect()->to(base_url('/auth'));
	}
    
        $sucursales = $this->sucursales->findAll();

        $data = ['titulo' => 'Stock', 'sucursales' => $sucursales];

		echo view('header');
		echo view('stock/list',$data);
		echo view('footer');

	}

    public function movil(){


       
        echo view('header');
		echo view('stock/movil');
		echo view('footer');

    }


    //CARGA EL DATATABLE
    public function dataTables(){

        $this->stock->select('producto.id,stock.producto_id,stock.cantidad,producto.nombre,producto.codigo,producto.pventa,stock.updated_at');
        $this->stock->join('producto','stock.producto_id = producto.id');
        $this->stock->where('sucursal',session('sucursal'));
        $lista = $this->stock->findAll();
    
        return json_encode($lista);
	    
    }

    //DETALLE DE UN PRODUCTO
    public function detalle(){
        
        $returnData = array();

        $id = $this->request->getGet('id');

        $this->stock->select("producto.id,producto.nombre,producto.codigo,stock.producto_id,stock.cantidad");
        $this->stock->join("producto","producto.id = stock.producto_id");
        $this->stock->where('producto.id',$id);
        $this->stock->where('stock.sucursal',session('sucursal'));
        $producto = $this->stock->first();

        $data['producto'] = $producto;

	    array_push($returnData,$data);

        return json_encode($returnData);

    }

   
    public function addstock(){

        $codigo = $this->request->getPost('codigo');
        
        $codigo = $this->productos->where('codigo',$codigo)->first();

            if($codigo){

                $this->stock->where('id_producto', $codigo['id']);
                $this->stock->where('sucursal', session('sucursal'));
                $stock = $this->stock->first();

                if($stock){
                    return redirect()->to(base_url('/stock/edit/'. $stock['id']));
                }else{

                    $data = [
                        'id_producto' => $codigo['id'],
                        'sucursal' => session('sucursal'),
                    ];
            
                    $this->stock->save($data);

                    $this->stock->where('id_producto', $data['id_producto']);
                    $this->stock->where('sucursal', session('sucursal'));
                    $stock = $this->stock->first();

                    return redirect()->to(base_url('/stock/edit/'. $stock['id']));

                }

            }else{
                session()->setFlashdata('msg', 'El producto no existe.');
                return redirect()->to(base_url('productos'));
            }


        }

    public function multidatastock(){
        
            // Verificar si ha iniciado sesión
            $sesion = session();
            if(!$sesion->sesion){
                return redirect()->to(base_url('/auth'));
            }

            $this->carro->select('carro.id,carro.producto_id,producto.codigo,producto.nombre,producto.pventa,SUM(carro.cantidadcarro) AS cantidadcarro,user_id');
  
        $this->carro->join('producto','producto.id = carro.producto_id');
        $this->carro->where('user_id',session('rut'));
        $this->carro->groupby('producto_id');
        $this->carro->orderBy('id DESC');
        $datos = $this->carro->findAll();
        
        
        $data = ['datos' => $datos];


		echo view('header');
		echo view('stock/multidatastock',$data);
		echo view('footer');
    }

    public function multidatastockdelete($id){
        $this->carro->where('producto_id',$id);
        $this->carro->where('user_id',session('rut'));
        $this->carro->delete();
        return redirect()->to(base_url('/stock/multidatastock')); //VOLVER A VENTAS
    }

   

    //AGREGAR LINEA AL SISTEMA
    public function addline()
	{
      
       $code = $this->request->getPost('codigo'); // CODIGO ENVIADO

       $codigo = ""; // VARIABLE CODIGO
       $cantidad = ""; // VARIABLE CANTIDAD

        //DETECTAR EL INGRESO DE CODIGO CON O SIN MULTIPLICADOR U OTROS CASOS
       if(strpos($code, '*')){
        $parte = explode("*", $code);
        $codigo = $parte[0];
        $cantidad = $parte[1] = str_replace(",", ".", $parte[1]);
        }elseif(strlen($code) >= 1 & is_numeric($code)){
          $codigo = $code;
          $cantidad = 1;
        }else{
            $codigo = $code;
            $cantidad = 1;
       }
       
       $articulo = $this->productos->where('codigo',$codigo)->get()->getRow();

       if($articulo){
        
        $data = [
            'producto_id' => $articulo->id,
            'user_id' => session('rut'),
            'cantidadcarro' =>  $cantidad,
        ];

        $this->carro->save($data); //REGISTRAR EL PRODUCTO Y CANTIDAD EN EL CARRO DE COMPRA

       return redirect()->to(base_url('/stock/multidatastock')); //VOLVER A VENTAS

       }else{
            session()->setFlashdata('msg', 'No existe producto. ¿Desea crearlo? <a href="' . base_url('/productos/add') . '" class="btn btn-primary">Agregar Producto</a>');
            return redirect()->to(base_url('/stock/multidatastock')); //VOLVER A VENTAS
       }

	}

    public function actualizastock(){
        
        //BUSCAR PRODUCTOS EN EL CARRO DE VENTAS
        $this->carro->select('SUM(carro.cantidadcarro) AS cantidadcarro,carro.producto_id,producto.pventa,producto.codigo,producto.nombre');
        $this->carro->join('producto','producto.id = carro.producto_id');
        $this->carro->where('user_id',session('rut'));
        $this->carro->groupby('producto_id');
        $datos = $this->carro->findAll(); 

        foreach($datos as $row){
            
            //ACTUALIZAR STOCK  
            $this->stock->select('cantidad');
            $this->stock->where('producto_id',$row['producto_id']);
            $this->stock->where('sucursal',session('sucursal'));
            $rowtemp = $this->stock->get()->getRow();

           if(isset($rowtemp->cantidad)){
                $nuevostock = ($rowtemp->cantidad + $row['cantidadcarro']);
                $this->stock->set('cantidad',$nuevostock);
                $this->stock->where('sucursal',session("sucursal"));
                $this->stock->where('producto_id',$row['producto_id']);
                $this->stock->update();
           }else{
            $data1 = [
                'sucursal' => session('sucursal'),
                'producto_id' => $row['producto_id'],
                'cantidad' => $row['cantidad'],
            ];

            $this->stock->save($data1);
           }

 
         }

         //SE ELIMINA EL TICKET
        $this->carro->where('user_id',session('rut'));
        $this->carro->delete();
        return redirect()->to(base_url('/stock')); //VOLVER A VENTAS
        //return redirect()->to("intent://#Intent;scheme=cl.sii.eboleta;package=cl.sii.eboleta;end");
       
    




    }

  
    public function edit($id)
	{
        $this->stock->select("producto.nombre,stock.id,stock.cantidad,producto.codigo");
        $this->stock->where("stock.id",$id);
        $this->stock->where("stock.sucursal",session('sucursal'));
        $this->stock->join("producto","stock.id_producto = producto.id");
        $stock = $this->stock->first();
        

        $data = ['titulo' => 'Editar Producto', 'datos' => $stock];

		echo view('header');
		echo view('stock/edit', $data);
		echo view('footer');

	}





    public function store(){

    

        $data = [
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre'),
            'proveedor' => $this->request->getPost('proveedor'),
            'cantidad' => $this->request->getPost('cantidad'),
            'pcompra' => $this->request->getPost('pcompra'),
            'pventa' => $this->request->getPost('pventa'),

        ];

        $this->articulos->save($data);

        return redirect()->to(base_url('/productos'));

    }


    public function update(){

       echo $id = $this->request->getPost('id');
       echo $cantidad = $this->request->getPost('cantidad');

        $this->stock->where('producto_id',$id);
        $this->stock->where('sucursal',session('sucursal'));
        $existe = $this->stock->first();

       

        if($existe){
           
            $data = [
           
                'cantidad' => $cantidad,
    
            ];
    
             $this->stock->update($existe["id"],$data);
             echo "actualizado";
           

        }else{
           
            $data = [
                'producto_id' => $id,
                'cantidad' => -$cantidad,
                'sucursal' => session('sucursal'),
            ];
    
            $this->stock->save($data);
            echo "ingresado";
          
        }

       

    }

    public function sync($id){


        
        $data = [
            'producto' => $id,
            'sucursal' => session('sucursal'),
        ];

        $this->stock->save($data);

        return redirect()->to(base_url('/stock'));

    }


    public function delete($id){

        if(session('rol') >= '7'){
            session()->setFlashdata('msg', 'No tienes privilegios para acceder a este ítem.');
            return redirect()->to(base_url('/productos'));
        }

        
            $this->stock->where('id',$id);
            $this->stock->delete();

            return redirect()->to(base_url('/stock'));

           
    
    }

    public function autoproducto()
{
	$returnData = array();

   $valor = $this->request->getGet('term');

    $this->productos->select("producto.nombre,producto.codigo,producto.id,stock.producto_id,stock.cantidad,stock.sucursal");
    $this->productos->where("stock.sucursal",session("sucursal"));
	$this->productos->like('producto.nombre',$valor);
	$this->productos->orLike('producto.codigo',$valor);
    $this->productos->join("stock","producto.id = stock.producto_id");

	$articulos = $this->productos->findAll();
  
	if(!empty($articulos)){
		foreach($articulos as $row){
			$data['id'] = $row['id'];
			$data['nombre'] = $row['nombre'];
            $data['cantidad'] = $row['cantidad'];
			$data['label'] = $row['codigo'] . " - " . $row['nombre'];
			array_push($returnData,$data);
		}
		
	}

	echo json_encode($returnData);

}


    

}
