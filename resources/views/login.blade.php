@extends('menu')

@section('contenido')
<div class="container">
    <h1>Inicio de sesion</h1>
    <hr>
    <form action="{{route('validar')}}" method="POST">
        {{ csrf_field() }}
        <div class="well">
            <div class="form-group">
                <label for="dni">Usuario:
                    @if($errors->first('usuario'))
                    <p class='text-danger'>{{$errors->first('usuario')}}</p>
                    @endif
                </label>
                <input type="text" name="usuario" id="usuario" value="" class="form-control" placeholder="Usuario">

            </div>
            <div class="form-group">
                <label for="dni">Password:
                    @if($errors->first('password'))
                    <p class='text-danger'>{{$errors->first('password')}}</p>
                    @endif
                </label>
                <input type="text" name="password" id="password" value="" class="form-control" placeholder="password">

            </div>
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <input type="submit" value="Iniciar" class="btn btn-danger">
                </div>
            </div>
        </div>
    </form>
    @if (Session::has('mensaje'))
        <div class="alert alert-danger">{{Session::get('mensaje')}}</div>
    @endif
    @stop
</div>