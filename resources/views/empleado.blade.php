<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/estilo.css')}}">
</head>
<body>
    <h1>holaaaaaaaaaa</h1>
    Nombre del empleado {{$nombre}} trabajo {{$dias}}   
    <br>
    @if($nombre=="foto")
    <h3>hola foto</h3>
    <br>
    <img src="{{asset('fotos/foto.png')}}">
    @endif
    @if($nombre=="paris")
    <h3>hola paris</h3>
    <br>
    <img src="{{asset('fotos/paris.png')}}">
    @endif
    <br>
    <a href="{{route('salir')}}">cerrar nomina</a>
</body>
</html>