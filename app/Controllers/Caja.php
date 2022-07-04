<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajaModels;
use App\Models\SucursalesModels;
use App\Models\UsuariosModels;

require_once APPPATH.'/ThirdParty/fpdf/fpdf.php';
require_once APPPATH.'/ThirdParty/numeros_letras.php';

class Caja extends BaseController
{
    public function __construct(){

        $this->mtoscaja = New CajaModels();
        $this->sucursales = New SucursalesModels();
        $this->usuarios = New UsuariosModels();

    }

    public function index()
	{
        
		// Verificar si ha iniciado sesión
        $sesion = session();
        if(!$sesion->sesion){
            return redirect()->to(base_url('/auth'));
        }

        if(session("rol") == "777"){
            $this->mtoscaja->where("created_at >= CURDATE()");
            $this->mtoscaja->where("sucursal",session('sucursal'));
            $this->mtoscaja->orderby("id DESC");
        }else{
            $this->mtoscaja->where("created_at >= CURDATE()");
            $this->mtoscaja->where("sucursal",session('sucursal'));
            $this->mtoscaja->where("cajera",session('rut'));
            $this->mtoscaja->orderby("id DESC");
        }
        $mtoscaja = $this->mtoscaja->findAll();
        

        $this->mtoscaja->Select('SUM(cantidad) AS suma');
        $this->mtoscaja->where('tipo','ingreso');
        $this->mtoscaja->where('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->where('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $ingresos = $this->mtoscaja->first();
       
        $this->mtoscaja->Select('SUM(cantidad) AS suma');
        $this->mtoscaja->where('tipo','egreso');
        $this->mtoscaja->where('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->where('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $egresos = $this->mtoscaja->first();






        //DETALLE DEL MES ACTUAL

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',1);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $pagoproveedor = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',2);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $cajachica = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',3);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $cajaventas= $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',4);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $cajaredcompra= $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',5);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $pagopersonal= $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',6);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $pagotransferencia= $this->mtoscaja->first();
        
        //DETALLE DEL DIA

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',1);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $pagoproveedord = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',2);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $cajachicad = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',3);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $cajaventasd = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',4);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $cajaredcomprad = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',5);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $pagopersonald = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',6);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $pagotransferenciad = $this->mtoscaja->first();

        $data = [
            'titulo' => 'Flujo de Caja', 
            'datos' => $mtoscaja, 
            'entrada' => $ingresos,
            'salida' => $egresos,
            'pagoproveedor' => $pagoproveedor,
            'cajachica' => $cajachica,
            'cajaventas' => $cajaventas,
            'cajaredcompra' => $cajaredcompra,
            'pagopersonal' => $pagopersonal,
            'pagotransferencia' => $pagotransferencia,
            'pagoproveedord' => $pagoproveedord,
            'cajachicad' => $cajachicad,
            'cajaventasd' => $cajaventasd,
            'cajaredcomprad' => $cajaredcomprad,
            'pagopersonald' => $pagopersonald,
            'pagotransferenciad' => $pagotransferenciad,
        ];

		echo view('header');
		echo view('caja/list', $data);
		echo view('footer');

	}

    public function add($id)
	{

        $locales = $this->sucursales->findAll(); //BUSCA LAS SUCURSALES
        $usuarios = $this->usuarios->findAll(); //BUSCA LOS USUARIOS

        $data = ['titulo' => 'Movimiento de Caja','movimiento' => $id,'locales' => $locales,'usuarios' => $usuarios];

        echo view('header');
		echo view('caja/add',$data);
		echo view('footer');

	}

    public function inbox(){
        $locales = $this->sucursales->where('id',session('sucursal'))->findAll(); //BUSCA LAS SUCURSALES
        $usuarios = $this->usuarios->where('rut',session('rut'))->findAll(); //BUSCA LOS USUARIOS

        $data = ['titulo' => 'Movimiento de Caja','movimiento' => 'ingreso','locales' => $locales,'usuarios' => $usuarios];
        echo view('caja/inbox',$data);
    }

    public function outbox(){
        $locales = $this->sucursales->where('id',session('sucursal'))->findAll(); //BUSCA LAS SUCURSALES
        $usuarios = $this->usuarios->where('rut',session('rut'))->findAll(); //BUSCA LOS USUARIOS

        $data = ['titulo' => 'Movimiento de Caja','movimiento' => 'egreso','locales' => $locales,'usuarios' => $usuarios];
        echo view('caja/inbox',$data);
    }

    public function help(){
       
        echo view('caja/help');
    }
 
    public function store()
	{
        $cantidad = $this->request->getPost('cantidad');
        $cantidad = str_replace('.','',$cantidad);
        $tipo = $this->request->getPost('tipo');

        if($tipo=="egreso"){
            $cantidad = - $cantidad;
        }

        $data = [
           
           
            'tipo' => $tipo,
            'tipodetalle' => $this->request->getPost('tipodetalle'),
            'cantidad' => $cantidad,
            'comentario' => $this->request->getPost('comentario'),
            'sucursal' => session('sucursal'),
            'cajera' => session('rut'),
            'turno' => $this->request->getPost('turno'),
            
        ];

        $this->mtoscaja->save($data);

        $mov = $this->mtoscaja->getInsertID();

        return redirect()->to(base_url('/caja/ticket/'.$mov));

	}

    //Genera ticket en PDF 
    function ticket($id) 
    {		
        $data = [
            'ticket' => $id,
        ];
        echo view('header');
        echo view('caja/ticket',$data);
        echo view('footer');
    }

    function verticket($id) 
		{	
            
            $mov = $this->mtoscaja->where('id',$id)->first();
            
            

            $data = [
                'ticket' => $id,
                'mov' => $mov,
            ];
            
		    echo view('caja/verticket',$data);
		}

    

    public function registro(){

        $fechaa = $this->request->getPost('datea');
        $fechab = $this->request->getPost('dateb');

        // Verificar si ha iniciado sesión
        $sesion = session();
        if(!$sesion->sesion){
            return redirect()->to(base_url('/auth'));
        }

        
        $this->mtoscaja->where("sucursal",session('sucursal'));
        //$this->mtoscaja->where("tipodetalle <> 4");
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $mtoscaja = $this->mtoscaja->findAll();
        

        $this->mtoscaja->Select('SUM(cantidad) AS suma');
        $this->mtoscaja->where('tipo','ingreso');
        $this->mtoscaja->where('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $ingresos = $this->mtoscaja->first();
       
        $this->mtoscaja->Select('SUM(cantidad) AS suma');
        $this->mtoscaja->where('tipo','egreso');
        $this->mtoscaja->where('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $egresos = $this->mtoscaja->first();

        
        //DETALLE DEL MES ACTUAL

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',1);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $pagoproveedor = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',2);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $cajachica = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',3);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $cajaventas= $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',4);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $cajaredcompra= $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',5);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $pagopersonal= $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',6);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE('YEAR(created_at) = YEAR(CURRENT_DATE())');
        $this->mtoscaja->WHERE('MONTH(created_at)  = MONTH(CURRENT_DATE())');
        $pagotransferencia= $this->mtoscaja->first();
        
        //DETALLE DEL DIA

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',1);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $pagoproveedord = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',2);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $cajachicad = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',3);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $cajaventasd = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',4);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $cajaredcomprad = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',5);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->where("created_at BETWEEN '$fechaa' AND '$fechab'");
        $pagopersonald = $this->mtoscaja->first();

        $this->mtoscaja->select("SUM(cantidad) AS suma");
        $this->mtoscaja->WHERE('tipodetalle',6);
        $this->mtoscaja->WHERE('sucursal',session('sucursal'));
        $this->mtoscaja->WHERE("created_at >= CURDATE()");
        $pagotransferenciad = $this->mtoscaja->first();

        $data = [
            'titulo' => 'Flujo de Caja', 
            'datos' => $mtoscaja, 
            'entrada' => $ingresos,
            'salida' => $egresos,
            'pagoproveedor' => $pagoproveedor,
            'cajachica' => $cajachica,
            'cajaventas' => $cajaventas,
            'cajaredcompra' => $cajaredcompra,
            'pagopersonal' => $pagopersonal,
            'pagoproveedord' => $pagoproveedord,
            'cajachicad' => $cajachicad,
            'cajaventasd' => $cajaventasd,
            'cajaredcomprad' => $cajaredcomprad,
            'pagopersonald' => $pagopersonald,
            'pagotransferenciad' => $pagotransferenciad,
            'pagotransferencia' => $pagotransferencia,
        ];

		echo view('header');
		echo view('caja/list', $data);
		echo view('footer');

    }

  

}

