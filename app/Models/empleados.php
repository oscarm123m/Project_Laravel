<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Softdeletes;

class empleados extends Model
{
    use HasFactory;
    use Softdeletes;
    protected $primaryKey='ide';
    protected $fillable=['ide','nombre','apellido','sexo','idd','descripcion','email','celular','img'];
}
