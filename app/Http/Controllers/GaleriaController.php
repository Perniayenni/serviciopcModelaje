<?php

namespace App\Http\Controllers;


use App\Galeria;
use App\Imgs;

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
        $resultadosimg=[];
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
            $imgG = Imgs::where('url', '=', 'ImgGaleria/'.$nombre)->get();
            if($imgG =='[]'){
                $url = $value->move('ImgGaleria', $nombre);
                $Imgs->GuardarImgs($url, 'Galeria', $id_g, '', ''); //
                array_push($resultadosimg, $nombre.' Fue guardado de manera Éxitosa');
            }else{
                array_push($resultadosimg, $nombre.' Ya existe');

            }
        }
        return response()->json(['MensajeImg'=>$resultadosimg]);
        //return response()->json($request->hasFile('file'));//response()->json($request->file('file')->getClientOriginalName());
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
