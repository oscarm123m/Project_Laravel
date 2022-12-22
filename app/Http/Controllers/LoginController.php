<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\users;
use Session;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function validar(Request $request){
        $this->validate($request,[
            'usuario'=>'required',
            'password'=>'required'
          ]);
        //$passwordEncriptado=Hash::make($request->password);
        //echo $passwordEncriptado;
        $consulta=users::where('email',$request->usuario)
                ->get();
          $cuantos=count($consulta);
        if($cuantos==1 and hash::check($request->password,$consulta[0]->password)){
            Session::put('sessionusuario',$consulta[0]->email);
            Session::put('sessiontipo',$consulta[0]->type);
            Session::put('sessionid',$consulta[0]->id);
            return redirect()->route('principal');
        }else{
            Session::flash('mensaje',"El usuario o la contraseña son incorrectos");
            return redirect()->route('login');
        }
    }
    public function principal(){
        $sessionusuario=session('sessionusuario');
        $sessiontipo=session('sessiontipo');
        $sessionid=session('sessionid');
        if($sessionusuario<>"")
        {
            return view('menu');
        }else{
            Session::flash('mensaje',"Inicia ession antes de continuar");
            return redirect()->route('login');
        }
        
    }

    public function cerrarsession()
    {
        Session::forget('sessionusuario');
        Session::forget('sessiontipo');
        Session::forget('sessionid');
        Session::flush();
        Session::flash('mensaje',"Session cerrada");
            return redirect()->route('login');
    }
}
