<?php
// REVISIÓN 07/05/2022


namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuariosModels;
use App\Models\SucursalesModels;

class Auth extends BaseController
{
    public function __construct(){

        //CARGA MODELOS
        $this->usuarios = New UsuariosModels();
        $this->sucursales = New SucursalesModels();
    }

public function index(){

    // Verificar si ha iniciado sesión
    if(session('sesion')){
        return redirect()->to(base_url());
    }


    $locales = $this->sucursales->findAll(); //BUSCA LAS SUCURSALES
    $data = ['locales' => $locales]; //ENVÍA DATA A LA VISTA
    echo view('login/index',$data); //CARGA LA VISTA

}


public function login(){
        
    //VARIABLES DEL FORMULARIO LOGIN
    $rut = $this->request->getPost("rut");
    $password = $this->request->getPost("password");
    $sucursal = $this->request->getPost("sucursal");
   

    //CONSULTA SI EXISTE EL USUARIO
    $this->usuarios->where('rut',$rut);
    $this->usuarios->orWhere('username',$rut);
    $datosUsuario = $this->usuarios->first();

    //SI EL USUARIO EXISTE
    if($datosUsuario != null){

        if($password == $datosUsuario['password']){ //COMPARA LAS CONTRASEÑAS DE LA DB Y LA INGRESADA
            
            $datosSesion = [

                'rut' => $datosUsuario['rut'],
                'sucursal' => $sucursal,
                'rol' => $datosUsuario['rol'],
                'btntemporal' => TRUE,
                'sesion' => TRUE,

            ]; // VARIABLES DE SESION

            $session = session();
            $session->set($datosSesion);
            return redirect()->to(base_url('/home')); // REDIRIGIR AL HOME

        //SI LA CONTRASEÑA ES INCORRECTA
        }else{
            session()->setFlashdata('msg', 'CREDENCIALES INVÁLIDAS');
            return redirect()->to(base_url('/auth'));
        }

    //SI EL USUARIO NO EXISTE
    }else{
        session()->setFlashdata('msg', 'USUARIO NO EXISTE. CONTÁCESE CON EL ADMINISTRADOR(A)');
        return redirect()->to(base_url('/auth'));
    } 

}


//FINALIZAR LA SESSIÓN
public function logout(){ 
    $session = session();
    $session->destroy();
    return redirect()->to(base_url('auth/'));
}



}