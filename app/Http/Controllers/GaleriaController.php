<?php

namespace App\Http\Controllers;


use App\Galeria;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImgsController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GaleriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json('hello');
    }

    public function create()
    {
        //
    }

    public function storeImg(Request $request){

    }

    public function store(Request $request)
    {
        $Imgs = new ImgsController();
        $datos = ([
            'titulo' => $request->get('titulo'),
            'descripcion'=> $request->get('descripcion')
        ]);

       // Agregamos los datos de la galeria
        $id = Galeria::create($datos);
        $id_g = $id->id_g;

        foreach ($request->file('file') as $value){
            $nombre =    $value->getClientOriginalName();
            $url = $value->move('ImgGaleria', $nombre);
         //   echo 'Paso';
            $Imgs->GuardarImgs($url, 'Galeria', $id_g, '', ''); //

        }
     //   $file->getClientOriginalName();


        //$Imgs->GuardarImgs($url, 'Galeria', $id_g, null, null );

        //$elArray = $request->get('archivos');

        /*foreach ($elArray as $valor) {
            array_push($arreglo, $valor);
        }*/

        return response()->json($request->hasFile('file'));//response()->json($request->file('file')->getClientOriginalName());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
