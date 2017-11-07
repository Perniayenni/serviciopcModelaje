<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imgs;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImgsController extends Controller
{
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

    public function show($id)
    {
        $datos = Imgs::where('ref', '=', $id)->get();
        return response()->json($datos);
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
