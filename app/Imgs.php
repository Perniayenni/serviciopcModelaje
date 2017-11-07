<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Imgs extends Model{

    protected $table = 'imgs';
    protected $primaryKey = 'id_img';
    protected $fillable= ['url', 'ref', 'id_g','id_m','id_d'];
    public $timestamps = false;

}