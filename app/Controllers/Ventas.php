<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StockModels;
use App\Models\ProductosModels;
use App\Models\VentasModels;
use App\Models\VentasDetalleModels;
use App\Models\CarritoModels;
use App\Models\SucursalesModels;
use App\Models\UsuariosModels;
use App\Models\CajaModels;

require_once APPPATH.'/ThirdParty/fpdf/fpdf.php';
require_once APPPATH.'/ThirdParty/numeros_letras.php';

class Ventas extends BaseController
{
    protected $stock;
    protected $ventas;
    protected $carro;

    public function __construct(){


        $this->usuarios = New UsuariosModels();
        $this->stock = New StockModels();
        $this->productos = New ProductosModels();
        $this->ventas = New VentasModels();
        $this->ventasdetalle = New VentasDetalleModels();
        $this->sucursales = New SucursalesModels();
        $this->carro = New CarritoModels();
        $this->mtoscaja = New CajaModels();
        helper('number');

    }

	public function index()
	{

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

        foreach($datos as $dato){
            
        }
        
        
        $data = ['datos' => $datos];

		echo view('header');
		echo view('ventas/v3',$data);
		echo view('footer');

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
            'pcompracarro' =>  $articulo->pcompra,
            'pventacarro' =>  $articulo->pventa,
            'subtotalcarro' =>  $articulo->pventa * $cantidad,
        ];

        $this->carro->save($data); //REGISTRAR EL PRODUCTO Y CANTIDAD EN EL CARRO DE COMPRA

       return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS

       }else{
            session()->setFlashdata('msg', 'No existe producto. ¿Desea crearlo? <a href="' . base_url('/productos') . '" class="btn btn-primary">Agregar Producto</a>');
            return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
       }



      
       
       

	}

    public function deleteticket($user){
        $this->carro->where('user_id',$user);
        $this->carro->delete();
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    public function deleteline($line){
        $this->carro->where('id',$line);
        $this->carro->delete();
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

  

    public function delete($id){
        $this->carro->where('producto_id',$id);
        $this->carro->where('user_id',session('rut'));
        $this->carro->delete();
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    public function more($id){
        $this->carro->set('cantidadcarro','cantidadcarro+1.0');
        $this->carro->where('id',$id);
        $this->carro->update();
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    public function less($id){
        $this->carro->set('cantidadcarro','cantidadcarro-1.0');
        $this->carro->where('id',$id);
        $this->carro->update();
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    public function actualizarcantidad(){

        $id = $this->request->getPost('id'); // CODIGO ENVIADO
        $cantidad= $this->request->getPost('cantidad'); // CODIGO ENVIADO

        $this->carro->set('cantidadcarro',$cantidad);
        $this->carro->where('id',$id);
        $this->carro->update();
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    public function updateline(){
        $id = $this->request->getPost('id'); // CODIGO ENVIADO
        $cantidad= $this->request->getPost('cantidad'); // CODIGO ENVIADO
        $this->carro->set('cantidadcarro',$cantidad);
        $this->carro->where('id',$id);
        $this->carro->update();
        
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
                $data['value'] = $row['codigo'];
                $data['label'] = $row['codigo'] . " - " . $row['nombre'];
                array_push($returnData,$data);
            }
            
        }

        echo json_encode($returnData);

    }

    public function prepago(){
       
        //BUSCAR PRODUCTOS EN VENTA
        $this->carro->select('producto.codigo, producto.pventa,SUM(carro.cantidadcarro) AS cantidadcarro');
        $this->carro->join('producto','producto.id = carro.producto_id');
        $this->carro->where('user_id',session('rut'));
        $this->carro->groupby('producto_id');
        $datos = $this->carro->findAll();

        $totalventa = 0;
       
        //RECORREN PRODUCTOS, SE CUENTA EL TOTAL Y SE GENERA EL ARRAY DEL DETALLE DE VENTAS
        foreach($datos as $row){

           $totalventa = $totalventa +  ($row['cantidadcarro'] * $row['pventa']);
        }

        $data = [
        'titulo' => 'Pre venta',
        'total' => $totalventa,

        ];
       
       
        echo view('header');
		echo view('ventas/prepago',$data);
		echo view('footer');
    }


    public function pagar(){

        //datos temporales
        $session = session();
        $rutoriginal = str_replace ( 't', '', session('rut'));
       

        $formapago = $this->request->getPost('formapago');
        $cliente_rut = $this->request->getPost('cliente_rut'); 

        //BUSCAR PRODUCTOS EN EL CARRO DE VENTAS
        $this->carro->select('SUM(carro.cantidadcarro) AS cantidadcarro,carro.producto_id,producto.pventa,producto.codigo,producto.nombre');
        $this->carro->join('producto','producto.id = carro.producto_id');
        $this->carro->where('user_id',session('rut'));
        $this->carro->groupby('producto_id');
        $datos = $this->carro->findAll();

        $totalventa = 0;

        //RECORREN PRODUCTOS, SE CUENTA EL TOTAL Y SE GENERA EL ARRAY DEL DETALLE DE VENTAS
        foreach($datos as $row){

            $horaactual = strtotime(date('G:i'));
            $hora2 = strtotime('7:30');
            $hora3 = strtotime('9:00');
            $hora4 = strtotime('14:00');
            $hora5 = strtotime('16:00');
            
            if($row['codigo'] == 1 && $horaactual >= $hora2 && $horaactual <= $hora3){
                    
                    $row['pventa'] = 1600;

           }elseif($row['codigo'] == 1 && $horaactual >= $hora4 && $horaactual <= $hora5){

                    $row['pventa'] = 1600;

           }


            $totalventa = $totalventa +  ($row['cantidadcarro'] * $row['pventa']);
        }

        //SE REGISTRA LA VENTA A LA BASE DE DATOS
        $dataventa = [
            'total' => $totalventa,
            'sucursal' => session('sucursal'),
            'vendedor' => $rutoriginal,
            'formapago' => $formapago,
            'cliente_rut' => $cliente_rut,
        ];

        $this->ventas->save($dataventa); //SE GUARDA LA VENTA TOTAL

        //---------------------------------------------------------------------
 

        //CREAR UN ARRAY PARA ARMAR EL DETALLE DE VENTA
        $productos = array();

        //SE BUSCA EL ULTIMO ID INGRESADO DE VENTA
        $this->ventas->selectMax('id');
        $nventa = $this->ventas->get()->getRow();


        foreach($datos as $row){
            
            $data['nventa'] = $nventa->id;
            $data['producto_id'] = $row['producto_id'];
            $data['cantidad'] = $row['cantidadcarro'];
            $data['pventa'] = $row['pventa'];
            $data['descripcion'] = $row['nombre'];
            $data['sucursal'] = session('sucursal');
            $data['user_id'] = $rutoriginal;

            $this->ventasdetalle->save($data); //SE GUARDA LA LINEA DE DETALLE DE VENTA
          
            //ACTUALIZAR STOCK  
            $this->stock->select('cantidad');
            $this->stock->where('producto_id',$data['producto_id']);
            $this->stock->where('sucursal',session('sucursal'));
            $rowtemp = $this->stock->get()->getRow();

            

           if(isset($rowtemp->cantidad)){
                $nuevostock = ($rowtemp->cantidad - $data['cantidad']);
                $this->stock->set('cantidad',$nuevostock);
                $this->stock->where('sucursal',session("sucursal"));
                $this->stock->where('producto_id',$data['producto_id']);
                $this->stock->update();
           }else{
            $data1 = [
                'sucursal' => session('sucursal'),
                'producto_id' => $data['producto_id'],
                'cantidad' => $data['cantidad'],
            ];

            $this->stock->save($data1);
           }

 
         }

         //SE ELIMINA EL TICKET
        $this->carro->where('user_id',session('rut'));
        $this->carro->delete();
         
        //return redirect()->to("intent://#Intent;scheme=cl.sii.eboleta;package=cl.sii.eboleta;end");
       
        $session->set('rut',$rutoriginal);
        
        return redirect()->to(base_url('/ventas/ticket/' . $nventa->id)); //VOLVER A VENTAS

    }

    function temporal(){


        $session = session();
        $session->set('rut','t'. session('rut'));
        $session->set('btntemporal',FALSE);
        
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    function original(){

        $session = session();
        $original = str_replace ( 't', '', session('rut'));
        $session->set('btntemporal',TRUE);
        $session->set('rut',$original);
        
        return redirect()->to(base_url('/ventas')); //VOLVER A VENTAS
    }

    //Genera ticket en PDF 
	    function ticket($id) 
		{		
            $data = [
                'ticket' => $id,
            ];
			echo view('header');
		    echo view('ventas/ticket',$data);
		    echo view('footer');
		}

        function verticket($id) 
		{	
            
            $detalle = $this->ventasdetalle->where('nventa',$id)->findAll();
            
            $sucursal = $this->sucursales->where('id',session('sucursal'))->first();
            

            $data = [
                'ticket' => $id,
                'ventadetalle' => $detalle,
                'sucursal' => $sucursal,
            ];
            
		    echo view('ventas/verticket',$data);
		}





    public function stats(){


        //ESTADÍSTICA SUCURSAL
        //DETALLE DEL MES ACTUAL

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',1);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
       $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
       //$this->mtoscaja->WHERE('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
      
        $detalle1 = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',2);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
       $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
       //$this->mtoscaja->WHERE('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $detalle2 = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',3);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
       //this->mtoscaja->WHERE('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $detalle3 = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',4);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
       $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
       //$this->mtoscaja->WHERE('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $detalle4 = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',5);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
       $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
       //$this->mtoscaja->WHERE('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $detalle5 = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',6);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
       //$this->mtoscaja->WHERE('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $detalle6 = $this->mtoscaja->first();

        //VENTAS HOY
        $this->ventas->select('usuarios.apaterno,usuarios.amaterno,usuarios.nombres,ventas.vendedor, SUM(ventas.total) as total');
        $this->ventas->join('usuarios','usuarios.rut = ventas.vendedor');
        $this->ventas->where("ventas.created_at >= CURDATE()");
        $this->ventas->groupBy('ventas.vendedor');
        $statventas = $this->ventas->findAll();

        //VENTAS AYER
        $this->ventas->select('usuarios.apaterno,usuarios.amaterno,usuarios.nombres,ventas.vendedor, SUM(ventas.total) as total');
        $this->ventas->join('usuarios','usuarios.rut = ventas.vendedor');
        $this->ventas->where("DATE(ventas.created_at) = DATE(NOW() - INTERVAL 1 DAY)");
        $this->ventas->groupBy('ventas.vendedor');
        $statventasayer = $this->ventas->findAll();

        //VENTAS ANTEAYER
        $this->ventas->select('usuarios.apaterno,usuarios.amaterno,usuarios.nombres,ventas.vendedor, SUM(ventas.total) as total');
        $this->ventas->join('usuarios','usuarios.rut = ventas.vendedor');
        $this->ventas->where("DATE(ventas.created_at) = DATE(NOW() - INTERVAL 2 DAY)");
        $this->ventas->groupBy('ventas.vendedor');
        $statventasanteayer = $this->ventas->findAll();

         //VENTAS ANTEAYER
         $this->ventas->select('usuarios.apaterno,usuarios.amaterno,usuarios.nombres,ventas.vendedor, SUM(ventas.total) as total');
         $this->ventas->join('usuarios','usuarios.rut = ventas.vendedor');
         $this->ventas->where("DATE(ventas.created_at) = DATE(NOW() - INTERVAL 3 DAY)");
         $this->ventas->groupBy('ventas.vendedor');
         $statventasanteayer1 = $this->ventas->findAll();



        $this->ventas->select('HOUR(created_at) AS horas,SUM(total) AS total');
        $this->ventas->where("created_at >= CURDATE()");
        $this->ventas->groupBy('horas');
        $ventashoras = $this->ventas->findAll();
        
        $libroventas = $this->ventas->where("created_at >= CURDATE()")->OrderBy("created_at DESC")->findAll();

        $this->ventasdetalle->select('ventadetalle.producto_id, SUM(ventadetalle.cantidad) AS cantidad,producto.nombre,SUM(producto.pventa*ventadetalle.cantidad) AS total');
        $this->ventasdetalle->join('producto','producto.id = ventadetalle.producto_id');
        $this->ventasdetalle->WHERE('YEAR(ventadetalle.created_at) = YEAR(CURRENT_DATE())');
        $this->ventasdetalle->WHERE('MONTH(ventadetalle.created_at)  = MONTH(CURRENT_DATE())');
        //$this->ventasdetalle->where("ventadetalle.created_at >= CURDATE()");
        $this->ventasdetalle->groupBy('ventadetalle.producto_id');
        $this->ventasdetalle->OrderBy('cantidad DESC');   
        $masvendidoshoy = $this->ventasdetalle->findAll();

        $this->ventasdetalle->select('ventadetalle.producto_id, SUM(ventadetalle.cantidad) AS cantidad, producto.nombre,SUM(producto.pventa*ventadetalle.cantidad) AS total');
        $this->ventasdetalle->join('producto','producto.id = ventadetalle.producto_id');
        $this->ventasdetalle->groupBy('ventadetalle.producto_id');
        $this->ventasdetalle->OrderBy('cantidad DESC');
        $masvendidossiempre = $this->ventasdetalle->findAll();

        $data = [
            'detalle1' => $detalle1,
            'detalle2' => $detalle2,
            'detalle3' => $detalle3,
            'detalle4' => $detalle4,
            'detalle5' => $detalle5,
            'detalle6' => $detalle6,
            'titulo' => 'Estadísticas',
            'statventas' => $statventas,
            'statventasayer' => $statventasayer,
            'statventasanteayer' => $statventasanteayer,
            'statventasanteayer1' => $statventasanteayer1,
            'ventashoras' => $ventashoras,
            'libroventas' => $libroventas,
            'masvendidoshoy' => $masvendidoshoy,
            'masvendidossiempre' => $masvendidossiempre,
            ];
   
   
            echo view('header');
            echo view('ventas/stats',$data);
            echo view('footer');

    }


    public function ventasdiarias(){

        $returnData = array();

        $valor = $this->request->getGet('term');
 
         $this->productos->like('nombre',$valor);
         $this->productos->orLike('codigo',$valor);
         $this->productos->where('estado',1);
 
         $articulos = $this->productos->findAll();
       
         if(!empty($articulos)){
             foreach($articulos as $row){
                 $data['id'] = $row['id'];
                 $data['value'] = $row['codigo'];
                 $data['label'] = $row['codigo'] . " - " . $row['nombre'];
                 array_push($returnData,$data);
             }
             
         }
 
         echo json_encode($returnData);

    }


    public function statsvendor(){

        $this->ventas->select('usuarios.username,ventas.vendedor, SUM(ventas.total) as total');
        $this->ventas->join('usuarios','usuarios.rut = ventas.vendedor');
        $this->ventas->where("ventas.created_at >= CURDATE()");
        $this->ventas->where("ventas.vendedor",session('rut'));
        $this->ventas->groupBy('ventas.vendedor');
        $statventas = $this->ventas->findAll();

        $this->ventas->where("vendedor",session('rut'));
        $this->ventas->where("ventas.created_at >= CURDATE()");
        $ultimasventas = $this->ventas->findAll(10);


        $this->ventas->select('HOUR(created_at) AS horas,COUNT(total) AS total');
        $this->ventas->where("created_at >= CURDATE()");
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
        'titulo' => 'Estadísticas por vendedor(a) ' . session('rut') ,
        'statventas' => $statventas,
        'ventashoras' => $ventashoras,
        'ultimasventas' => $ultimasventas,
        'masvendidosxmi' => $masvendidosxmi,
        ];


        echo view('header');
        echo view('ventas/statsvendor',$data);
        echo view('footer');

    }




}