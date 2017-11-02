<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Destacados extends Model{

    protected $table = 'destacados';
    protected $primaryKey = 'id_d';
    protected $fillable= ['titulo', 'descripcion', 'fecha'];
    public $timestamps = false;

}
