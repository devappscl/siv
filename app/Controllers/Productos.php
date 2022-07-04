<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModels;
use App\Models\StockModels;
use App\Models\ProveedoresModels;
use App\Models\CategoriasModels;
use App\Models\SucursalesModels;
use App\Models\VentasDetalleModels;
use Illuminate\Http\Request;

require_once APPPATH.'/ThirdParty/fpdf/fpdf.php';
require_once APPPATH.'/ThirdParty/numeros_letras.php';

class Productos extends BaseController
{


    public function __construct(){

        $this->articulos = New ProductosModels();
        $this->stock = New StockModels();
        $this->proveedores = New ProveedoresModels();
        $this->categorias = New CategoriasModels();
        $this->sucursales = New SucursalesModels();
        $this->ventasdetalle = New VentasDetalleModels();

        helper('proveedores_helper'); 
        helper('productos_helper');
     
    }

  //PAGINA DE INICIO
	public function index()
	{
        // Verificar si ha iniciado sesión
        if(!session('sesion')){
            return redirect()->to(base_url('/auth'));
        }
   
       

        $data = ['titulo' => 'Productos'];

		echo view('header');
		echo view('productos/lista', $data);
		echo view('footer');

	}

    public function proveedor($id)
	{
        // Verificar si ha iniciado sesión
        if(!session('sesion')){
            return redirect()->to(base_url('/auth'));
        }
   
        
        $proveedor = $id;

        $data = ['titulo' => 'Productos', 'proveedor' => $proveedor,];

		echo view('header');
		echo view('productos/proveedor', $data);
		echo view('footer');

	}

    //Genera ticket en PDF 
    function ticket($id) 
    {		
        $data = [
            'proveedor' => $id,
        ];
        echo view('header');
        echo view('productos/ticket',$data);
        echo view('footer');
    }

    function verticket($id) 
    {	
        
        $this->articulos->select('producto.id,producto.codigo,producto.nombre,producto.pcompra,producto.pventa,stock.cantidad');
        $this->articulos->join('stock','producto.id = stock.producto_id');
        $this->articulos->where("producto.proveedor",$id);
        $this->articulos->where("stock.sucursal",session('sucursal'));
        //$this->articulos->orderBy('stock.cantidad','ASC');
        $this->articulos->orderBy('producto.nombre','ASC');
        $articulos = $this->articulos->findAll();

        $sucursal = $this->sucursales->where('id',session('sucursal'))->first();
        

        $data = [
            'proveedor' => $id,
            'productos' => $articulos,
            'sucursal' => $sucursal
        ];
        
        echo view('productos/verticket',$data);
    }


    //CARGAR EL DATATABLE DE PRODUCTOS
    public function dataTables(){


        $this->articulos->select('producto.id,producto.codigo,producto.nombre,producto.pcompra,producto.pventa,producto.updated_at,stock.cantidad');
        $this->articulos->join('stock','producto.id = stock.producto_id');
        $this->articulos->where("stock.sucursal",session('sucursal'));
        $articulos = $this->articulos->findAll();
    
        return json_encode($articulos);
	    
    }

    //CARGAR EL DATATABLE DE PRODUCTOS
    public function dataTablesProveedor($id){

        $this->articulos->select('producto.id,producto.codigo,producto.nombre,producto.pcompra,producto.pventa,stock.cantidad');
        $this->articulos->join('stock','producto.id = stock.producto_id');
        $this->articulos->where("producto.proveedor",$id);
        $this->articulos->where("stock.sucursal",session('sucursal'));
        $articulos = $this->articulos->findAll();
    
        return json_encode($articulos);
	    
    }

    public function pcompuesto(){

            $data = [
                'titulo' => "PRODUCTO COMPUESTO",
                
            ];

            echo view('header');
            echo view('productos/pcompuesto', $data);
            echo view('footer');
   
    }


    //CARGAR EL DATATABLE DE PRODUCTOS
    public function dataTablesMasVendidos($id){

        $this->ventasdetalle->select('ventadetalle.producto_id, ROUND(SUM(ventadetalle.cantidad),1) AS cantidad, stock.producto_id as stockcodigo,producto.codigo,producto.nombre,producto.pcompra,producto.pventa');
        $this->ventasdetalle->join('producto','producto.id = ventadetalle.producto_id');
        $this->ventasdetalle->join('stock','producto.id = stock.producto_id');
        $this->ventasdetalle->groupBy('ventadetalle.producto_id');
        $this->ventasdetalle->Where('producto.proveedor',$id);
        $articulos = $this->ventasdetalle->findAll();
    
        return json_encode($articulos);
	    
    }

    public function masvendidos($id){
        // Verificar si ha iniciado sesión
        if(!session('sesion')){
            return redirect()->to(base_url('/auth'));
        }


        $proveedor = $id;

        $data = ['titulo' => 'Productos Mas Vendidos', 'proveedor' => $proveedor,];

        echo view('header');
        echo view('productos/masvendidos', $data);
        echo view('footer');

    }

 
    //DETALLE DE UN PRODUCTO
    public function detalle(){
        
        $returnData = array();

        $id = $this->request->getGet('id');

        $this->articulos->select("producto.nombre,producto.codigo,producto.id,producto.pcompra,producto.pventa,producto.proveedor,producto.categoria,stock.producto_id,stock.cantidad,stock.sucursal");
        $this->articulos->join("stock","producto.id = stock.producto_id");
        $producto = $this->articulos->where('producto.id',$id)->first();

        $data['producto'] = $producto;

	    array_push($returnData,$data);

        return json_encode($returnData);

    }

    public function proveedoresid(){
        
        $this->proveedores->orderBy('nombre','DESC');
        $lista = $this->proveedores->findAll();
        return json_encode($lista);

    }

    public function categoriasid(){
        
        $this->categorias->orderBy('nombre','DESC');
        $lista = $this->categorias->findAll();
        return json_encode($lista);

    }



    //CRUD PRODUCTOS

    //CREAR PRODUCTO
    public function store(){

        $codigo = $this->request->getPost('codigo');


       if($this->articulos->where("codigo",$codigo)->first()){

        session()->setFlashdata('msg', 'El producto ya existe en la base de datos.');
        return redirect()->to(base_url('/productos'));

       }else{

        $data = [
            'codigo' => $codigo,
            'nombre' => $this->request->getPost('nombre'),
            'proveedor' => $this->request->getPost('proveedor'),
            'categoria' => $this->request->getPost('categoria'),
            'pcompra' => $this->request->getPost('pcompra'),
            'pventa' => $this->request->getPost('pventa'),
            'inventariable' => $this->request->getPost('inventariable'),

        ];

        $this->articulos->save($data);
        
        
        

       $articulo = $this->articulos->where('codigo',$codigo)->first();

            //AGREGAR REGISTROS A LA SUCURSAL RESPECTIVA

            $data1 = [
                'sucursal' => session('sucursal'),
                'producto_id' => $articulo['id'],
            ];

            $this->stock->save($data1);
        
        session()->setFlashdata('msg', 'Producto agregado con éxito.');

     return redirect()->to(base_url('/productos'));



       }
       

    }
    
   
    //ACTUALIZAR PRODUCTO
    public function update(){
       
       /* if(session('rol') >= '7'){
            session()->setFlashdata('msg', 'No tienes privilegios para acceder a este ítem.');
            return redirect()->to(base_url('/productos'));
        }*/

       $this->request->getPost('id');

        if($this->request->getPost('id')){
            
            $id = $this->request->getPost('id');

            $data = [
               
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'pcompra' => $this->request->getPost('pcompra'),
                'pventa' => $this->request->getPost('pventa'),
                'proveedor' => $this->request->getPost('proveedor'),
                'categoria' => $this->request->getPost('categoria'),
    
            ];
    
            $this->articulos->update($id,$data);

            //ACTUALIZAR STOCK
            $this->stock->where('producto_id',$id);
            $this->stock->set('cantidad',$this->request->getPost('cantidad'));
            $this->stock->update();

            session()->setFlashdata('msg', 'Producto actualizado con éxito.');
    
            return redirect()->to(base_url('/productos'));
        } 
       

    }

   
    //ELIMINAR PRODUCTO
    public function desactivar($id){

      /* if(session('rol') == '777'){
            session()->setFlashdata('msg', 'No tienes privilegios para acceder a este ítem.');
            return redirect()->to(base_url('/productos'));
        } */

    $this->stock->where('producto_id',$id);
    $this->stock->delete();

    $this->articulos->where('id',$id);
    $this->articulos->delete();

 

   return redirect()->to(base_url('/productos'));

 
    
}

//BUSCAR PRODUCTO AJAX
public function autoproducto()
{
    $returnData = array();

    $valor = $this->request->getGet('term');

        $this->articulos->like('nombre',$valor);
        $this->articulos->orLike('codigo',$valor);
        $this->articulos->where('estado',1);

        $articulos = $this->articulos->findAll();
    
        if(!empty($articulos)){
            foreach($articulos as $row){
                $data['id'] = $row['id'];
                $data['nombre'] = $row['nombre'];
                $data['value'] = $row['pventa'];
                $data['label'] = $row['codigo'] . " - " . $row['nombre'];
                array_push($returnData,$data);
            }
            
        }

        echo json_encode($returnData);

}

}
