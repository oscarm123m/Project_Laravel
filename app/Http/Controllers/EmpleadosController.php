<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\empleados;
use App\Models\departamentos;
use App\Models\nominas;
use Session;


class EmpleadosController extends Controller
{
    public function mensaje()
    {
      return "hola trabajador";
    }

    public function eloquent()
    {
      //$consulta=empleados::all();
      $empleados=new empleados;
      $empleados->ide=1;
      $empleados->nombre="pedro";
      $empleados->apellido="perez";
      $empleados->email="pedro@gmail.com";
      $empleados->celular="1234567890";
      $empleados->sexo="M";
      $empleados->descripcion="Prueba";
      $empleados->idd=1;
      $empleados->save();

      //return $consulta;
      return 'operacion realizada';
    }

    public function saludo($nombre,$dias)
    {
      //return view('empleado',compact('nombre','dias'));
      return view('empleado',['nombre'=>$nombre,'dias'=>$dias]);
      //return view('empleado')
      //->with('nombre',$nombre)
      //->with('dias',$dias);
    }

    public function pago()
    {
      $dias=7;
      $pago=600;
      $nomina=$dias*$pago;
      return "el pago del empleado es $nomina";
    }

    public function salir()
    {
      return "Salirrrrrrrrrr";
    }

    public function formularioempleado()
    {
      $consulta=empleados::orderBy('ide','DESC')->take(1)->get();
      $departamentos=departamentos::orderBy('nombre')->get();
      return view ('formularioempleado')->with('departamentos',$departamentos);

      
    }

    public function guardarempleado(Request $request)
    {
      $this->validate($request,[
        //'ide'=>'required|numeric',
        //'ide'=>'required|regex:/^[E][M][P][-][0-9]{5}$/',
        //'nombre'=>'required|alpha',
        'nombre'=>'required|regex:/^[A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
        'apellido'=>'required|regex:/^[A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
        'email'=>'required|email',
        //'celular'=>'required|integer'
        'celular'=>'required|regex:/^[0-9]{10}$/',
        //'precio'=>'required|regex:/^[0-9]+[.][0-9]{2}$/'
        //'precio'=>'required|regex:/^[0-9]*[.][0-9]{2}$/'
        'img'=>'image|mimes:gif,jpeg,png,jpg'
      ]);

      $file=$request->file('img');
      if($file<>"")
      {
      $img=$file->getClientOriginalName();
      $img2=$request->ide . $img;
      \Storage::disk('local')->put($img2, \File::get($file));
      }else{
        $img2="noFoto.jpg";
      }

      $empleados=new empleados;
      $empleados->nombre=$request->nombre;
      $empleados->apellido=$request->apellido;
      $empleados->email=$request->email;
      $empleados->celular=$request->celular;
      $empleados->sexo=$request->sexo;
      $empleados->descripcion=$request->detalle;
      $empleados->idd=$request->idd;
      $empleados->img=$img2;
      $empleados->save();

      /*return view('mensaje')->with('proceso',"Alta de empleados")
                            ->with('mensaje',"El empleado $request->nombre $request->apellido ha sido de alta corectamente")
                            ->with('error',1);*/
      //return "registro guardao";
      Session::flash('mensaje',"El empleado $request->nombre $request->apellido ha sido de alta corectamente");
      return redirect()->route('reporteempleados');

    }

    public function nomina($diast,$pago)
    {
      $nomina=$diast*$pago;
      //dd($nomina,$diast,$pago);
      return "el pago del empleado es $nomina con dias $diast y pago diario de $pago";
    }
    public function reporteempleados()
    {
      $consulta=empleados::withTrashed()->join('departamentos','empleados.idd','=','departamentos.idd')
      ->select('empleados.ide','empleados.nombre','empleados.apellido','departamentos.nombre as depa','empleados.email','empleados.deleted_at','empleados.img')
      ->orderBy('empleados.nombre')
      ->get();
      return view('reporteempleados')->with('consulta',$consulta);
    }

    public function desactivarempleados($ide)
    {
      $empleados=empleados::find($ide);
      $empleados->delete();
      /*return view('mensaje')->with('proceso',"Desactivar empleados")
                            ->with('mensaje',"El empleado ha sido desactivado corectamente")
                            ->with('error',1);*/
      Session::flash('mensaje',"El empleado ha sido desactivado corectamente");
      return redirect()->route('reporteempleados');
    }
    public function activarempleados($ide)
    {
      $empleados=empleados::withTrashed()->where('ide',$ide)->restore();
      /*return view('mensaje')->with('proceso',"Activar empleados")
                            ->with('mensaje',"El empleado ha sido activado corectamente")
                            ->with('error',1);*/
      Session::flash('mensaje',"El empleado ha sido activado corectamente");
      return redirect()->route('reporteempleados');
    }
    public function borrarempleados($ide)
    {
      $buscarempleado=nominas::where('ide',$ide)->get();
      $cuantos=count($buscarempleado);
      if($cuantos==0)
      {
        $empleados=empleados::withTrashed()->find($ide)->forceDelete();
        /*return view('mensaje')->with('proceso',"Borrar empleados")
                            ->with('mensaje',"El empleado ha sido borrado corectamente")
                            ->with('error',1);*/
        Session::flash('mensaje',"El empleado ha sido borrado corectamente");
        return redirect()->route('reporteempleados');
      }else{
        /*return view('mensaje')->with('proceso',"Borrar empleados")
                            ->with('mensaje',"El empleado No se puede eliminar por que tiene otros datos asociados")
                            ->with('error',0);*/
        Session::flash('mensaje',"El empleado No se puede eliminar por que tiene otros datos asociados");
        return redirect()->route('reporteempleados');
      }

      
    }

    public function actualizarempleado($ide){
      $consulta=empleados::withTrashed()->join('departamentos','empleados.idd','=','departamentos.idd')
      ->select('empleados.ide','empleados.nombre','empleados.apellido','departamentos.nombre as dep','empleados.email','empleados.deleted_at','empleados.idd','empleados.descripcion','empleados.sexo','empleados.celular','empleados.img')
      ->where('ide',$ide)
      ->get();
      $departamentos=departamentos::orderBy('nombre')->get();
      return view('actualizarempleado')->with('consulta',$consulta[0])->with('departamentos',$departamentos);
    }

    public function guardarcambio(Request $request){
      $this->validate($request,[
        'nombre'=>'required|regex:/^[A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
        'apellido'=>'required|regex:/^[A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
        'email'=>'required|email',
        'celular'=>'required|regex:/^[0-9]{10}$/',
        'img'=>'image|mimes:gif,jpeg,png,jpg'
      ]);

      $file=$request->file('img');
      if($file<>"")
      {
      $img=$file->getClientOriginalName();
      $img2=$request->ide . $img;
      \Storage::disk('local')->put($img2, \File::get($file));
      }

      $empleados=empleados::withTrashed()->find($request->ide);
      $empleados->nombre=$request->nombre;
      $empleados->apellido=$request->apellido;
      $empleados->email=$request->email;
      $empleados->celular=$request->celular;
      $empleados->sexo=$request->sexo;
      $empleados->descripcion=$request->detalle;
      $empleados->idd=$request->idd;
      if($file<>""){
      $empleados->img=$img2;
      }
      $empleados->save();

      /*return view('mensaje')->with('proceso',"Madificar empleados")
                            ->with('mensaje',"El empleado $request->nombre $request->apellido ha sido modificado corectamente")
                            ->with('error',1);*/
      Session::flash('mensaje',"El empleado $request->nombre $request->apellido ha sido modificado correctamente");
      return redirect()->route('reporteempleados');
    }
}
