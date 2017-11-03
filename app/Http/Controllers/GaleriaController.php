<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Galeria;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $elArray = $request->get('archivos');

        /*foreach ($elArray as $valor) {
            array_push($arreglo, $valor);
        }*/

        return response()->json($request->file('FileItem'));
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
