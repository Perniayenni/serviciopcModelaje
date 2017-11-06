<?php

namespace App\Http\Controllers;


use App\Galeria;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        // Agregamos los datos de la galeria
       //$id = Galeria::create($request->all());
       //$id_g = $id->id_g;
        $arreglo = array();
        //$elArray = $request->get('archivos');

        /*foreach ($elArray as $valor) {
            array_push($arreglo, $valor);
        }*/

        //$file= $request->file('File');
     //   $nombre= $file->getClientOriginalName();
      //  $request->file('File')->move('ImgGaleria', $nombre);

        return response()->json($request->file('file')->getClientOriginalName());
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
