<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeria extends Model{

    protected $table = 'galeria';
    protected $primaryKey = 'id_g';
    protected $fillable= ['titulo', 'descripcion'];
    public $timestamps = false;

}
