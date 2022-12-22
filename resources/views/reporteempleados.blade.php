@extends('menu')

@section('contenido')
<div class="container">
<h1>reporte del empleado</h1>
<br>
<a href="{{route('formularioempleado')}}">
    <button type="button" class="btn btn-success">Nuevo</button>
</a>
<br>
@if (Session::has('mensaje'))
  <div class="alert alert-success">{{Session::get('mensaje')}}</div>  
@endif
<table class="table">
  <thead>
    <tr>
      <th scope="col">Foto</th>
      <th scope="col">Clave</th>
      <th scope="col">Nombre</th>
      <th scope="col">Correo</th>
      <th scope="col">Area</th>
      <th scope="col">operaciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($consulta as $c)
    <tr>
      <td><img src="{{asset('archivos/'.$c->img)}}" height=50 width=50></td>
      <th scope="row">{{$c->ide}}</th>
      <td>{{$c->nombre}} {{$c->apellido}}</td>
      <td>{{$c->email}}</td>
      <td>{{$c->depa}}</td>
      <td>
      <a href="{{route('actualizarempleado',['ide'=>$c->ide])}}">
        <button type="button" class="btn btn-info">Modificar</button>
      </a>

      @if ($c->deleted_at)
      <a href="{{route('activarempleados',['ide'=>$c->ide])}}">
        <button type="button" class="btn btn-warning">Activar</button>
      </a>
      <a href="{{route('borrarempleados',['ide'=>$c->ide])}}">
        <button type="button" class="btn btn-secondary">Borrar</button>
      </a>
      @else
      <a href="{{route('desactivarempleados',['ide'=>$c->ide])}}">
        <button type="button" class="btn btn-danger">Desactivar</button>
      </a>
      @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

</div>
@stop