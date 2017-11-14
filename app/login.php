<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model{

    protected $table = 'login';
    protected $primaryKey = 'id_login';
    protected $fillable= ['Nombre', 'apellido', 'usuario','contrasena', 'token'];
    public $timestamps = false;

}
