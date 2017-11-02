<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelosp extends Model{

    protected $table = 'modelos';
    protected $primaryKey = 'id_m';
    protected $fillable= ['sexo', 'nivel', 'nombreCompleto','descripcion'];
    public $timestamps = false;

}
