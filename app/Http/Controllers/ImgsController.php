<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imgs;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImgsController extends Controller
{
    // Guardamos las imagenes Junto con el evento
    public function GuardarImgs($url, $ref, $id_g, $id_m, $id_d) //
    {
        $datos = ([
            'url'=> $url,
            'ref'=> $ref,
            'id_g'=> $id_g,
            'id_m'=>$id_m,
            'id_d'=>$id_d
        ]);
        Imgs::create($datos);/**/

    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    // Obtenemos todas las imagenes segun el id de galeria
    public function getImgs($ref, $id){
        if ($ref == 'Galeria'){
            $datos = Imgs::where('id_g', '=', $id)->get();
            return response()->json($datos);
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    // Eliminamos las imagenes segun el id de Galería
    public function destroy($id)
    {
        $img = Imgs::find($id);
        $url = $img->url;
        $urlEditada= str_replace("http://www.ourproject.cl/", "/", $url);
        unlink('../../'.$urlEditada);
        $img->delete();
        return  response()->json(['mensaje'=>true, 'codigo'=>200], 200);
    }
}
