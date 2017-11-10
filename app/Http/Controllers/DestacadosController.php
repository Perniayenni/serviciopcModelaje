<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Destacados;
use App\Imgs;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DestacadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Destacados::get(),202);
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
        $princUrl = 'http://www.ourproject.cl/ImagenesModelaje/ImgDestacado/';
        $url='../../ImagenesModelaje/ImgDestacado/';
        //$urlGAleria='ImgGaleria/';
        $resultadosimg=[];
        $Imgs = new ImgsController();
        $titulo = $request->get('titulo');
        $tituloEditado = str_replace(" ", "_", $titulo);
        $datos = ([
            'titulo' => $request->get('titulo'),
            'descripcion'=> $request->get('descripcion'),
            'fecha'=> $request->get('fecha')
        ]);

        // Agregamos los datos de destacados
        $id = Destacados::create($datos);
        $id_d = $id->id_d;

        // Creamos el Directorio
        mkdir($url.$tituloEditado , 0777);

        // Recorremos el file y lo guardamos en el directorio Creado
        foreach ($request->file('file') as $value){
            $nombre =    $value->getClientOriginalName();
            $imgG = Imgs::where('url', '=', $princUrl.$tituloEditado.'/'.$nombre)->get();

            // Validamos si la img éxiste
            if($imgG =='[]'){
                $value->move($url.$tituloEditado, $nombre);
                $url= $princUrl.$tituloEditado.'/'.$nombre;
                $Imgs->GuardarImgs($url, $titulo, '', '', $id_d); //
                array_push($resultadosimg, $nombre.' Fue guardado de manera Éxitosa');
            }else{
                array_push($resultadosimg, $nombre.' Ya existe');

            }
        }
        return response()->json(true);
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
        $princUrl = 'http://www.ourproject.cl/ImagenesModelaje/ImgDestacado/';
        $urlGAleria='ImagenesModelaje/ImgDestacado/';
        $destacados = Destacados::find($id);

        // Ruta vieja
        $rutaold = $destacados->titulo;
        $rutaoldEdit = str_replace(" ", "_", $rutaold);

        $titulo =$request->get('titulo');
        $tituloEditado = str_replace(" ", "_", $titulo);

        $descripcion =$request->get('descripcion');

        if ($titulo != null && $titulo!=''){
            $destacados->titulo=$titulo;
        }
        if ($descripcion != null && $descripcion!=''){
            $destacados->descripcion=$descripcion;
        }

        $destacados->save();

        //Edito el nombre de la carpeta

       /* rename($urlGAleria.$rutaoldEdit, $urlGAleria.$tituloEditado);

        // Edito las imagenes asociadas a galeria
        $imgs = Imgs::where('id_d', '=', $id)->get();
        foreach ($imgs as $valor){
            $valor->url = $princUrl.$tituloEditado;
            $valor->ref = $tituloEditado;
            $valor->save();
        }
        */
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
        $urlDestacados='../../ImagenesModelaje/ImgDestacado/';

        // obtengo los datos de Destacados
        $destacados = Destacados::find($id);
        $titulo = $destacados->titulo;
        $tituloEditado = str_replace(" ", "_", $titulo);

        // Elimino las imagenes asociadas a destacados
        $imgs = Imgs::where('id_d', '=', $id)->get();
        foreach ($imgs as $valor){
            $valor->delete();
        }
        // Elimino la carpeta del directorio

        //rmdir($urlDestacados.$tituloEditado);

        // Elimino la fila de Destacados
        $destacados->delete();

        return response()->json(['Mensaje'=>'Articulo eliminado de manera éxitosa']);
    }
}
