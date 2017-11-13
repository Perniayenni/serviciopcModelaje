<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Modelosp;
use App\Imgs;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModelosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Modelosp::get(),202);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $princUrl = 'http://www.ourproject.cl/ImagenesModelaje/ImgModelos';
        $url='../../ImagenesModelaje/ImgModelos/';

        $resultadosimg=[];
        $Imgs = new ImgsController();
        $titulo = $request->get('nombreCompleto');
        $datos = ([
            'nombreCompleto' => $request->get('nombreCompleto'),
            'descripcion'=> $request->get('descripcion'),
            'nivel'=> $request->get('nivel')
        ]);

        // Agregamos los datos del modelo
        $id = Modelosp::create($datos);
        $id_m = $id->id_m;


        // Recorremos el file y lo guardamos en el directorio Creado
        foreach ($request->file('file') as $value){
            $nombre =    $value->getClientOriginalName();
            $imgG = Imgs::where('url', '=', $princUrl.'/'.$nombre)->get();

            // Validamos si la img éxiste
            if($imgG =='[]'){
                $value->move($url, $nombre);
                $url= $princUrl.'/'.$nombre;
                $Imgs->GuardarImgs($url, $titulo, '', $id_m, ''); //
                array_push($resultadosimg, $nombre.' Fue guardado de manera Éxitosa');
            }else{
                array_push($resultadosimg, $nombre.' Ya existe');

            }
        }
        return response()->json(true);
        //return response()->json($request->hasFile('file'));//response()->json($request->file('file')->getClientOriginalName());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelos = Modelosp::find($id);

        $nombreCompleto =$request->get('nombreCompleto');

        $descripcion =$request->get('descripcion');

        $nivel =$request->get('nivel');

        if ($nombreCompleto != null && $nombreCompleto!=''){
            $modelos->nombreCompleto=$nombreCompleto;
        }
        if ($descripcion != null && $descripcion!=''){
            $modelos->descripcion=$descripcion;
        }
        if ($nivel != null && $nivel!=''){
            $modelos->nivel=$nivel;
        }

        $modelos->save();

        return response()->json(['mensaje'=>true, 'codigo'=>200], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // obtengo los datos de Destacados
        $modelos = Modelosp::find($id);

        // Elimino las imagenes asociadas a destacados
        $imgs = Imgs::where('id_m', '=', $id)->get();
        foreach ($imgs as $valor){
            $valor->delete();
            /// Eliminamos la foto existente
            $url1 = $valor->url;
            $urlEditada= str_replace("http://www.ourproject.cl/", "/", $url1);
            unlink('../..'.$urlEditada);

        }

        // Elimino la fila de Destacados
        $modelos->delete();

        return response()->json(['Mensaje'=>'Modelo eliminado de manera éxitosa']);
    }
}
