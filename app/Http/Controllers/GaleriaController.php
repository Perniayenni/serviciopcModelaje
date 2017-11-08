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
        return response()->json(Galeria::get(),202);
    }

    public function create()
    {
        //
    }

    // Guardamos Imagenes adicionales al evento
    public  function AddMasImagenes(Request $request){

        $princUrl = 'http://www.ourproject.cl/ImagenesModelaje/ImgGaleria/';
        $urlGAleria='../../ImagenesModelaje/ImgGaleria/';
        $resultadosimg=[];
        $titulo = $request->get('titulo');
        $id_g= $request->get('id_g');
        $tituloEditado = str_replace(" ", "_", $titulo);
        $Imgs = new ImgsController();

        // Recorremos el file y lo guardamos en el directorio Creado
        foreach ($request->file('file') as $value){
            $nombre = $value->getClientOriginalName();
            $imgG = Imgs::where('url', '=', $princUrl.$tituloEditado.'/'.$nombre)
                                ->where('id_g', '=', $id_g)->get();
            // Validamos si la img éxiste
            if($imgG =='[]'){
                $value->move($urlGAleria.$tituloEditado, $nombre);
                $url= $princUrl.$tituloEditado.'/'.$nombre;
                $Imgs->GuardarImgs($url, $titulo, $id_g, '', ''); //
                array_push($resultadosimg, $nombre.' Fue guardado de manera Éxitosa');
            }else{
                array_push($resultadosimg, $nombre.' Ya existe');

            }
        }
        return response()->json(['MensajeImg'=>$resultadosimg]);
    }

    // Guardamos las imagenes junto con el evento
    public function store(Request $request)
    {
        $princUrl = 'http://www.ourproject.cl/ImagenesModelaje/ImgGaleria/';
        $urlGAleria='../../ImagenesModelaje/ImgGaleria/';
        //$urlGAleria='ImgGaleria/';
        $resultadosimg=[];
        $Imgs = new ImgsController();
        $titulo = $request->get('titulo');
        $tituloEditado = str_replace(" ", "_", $titulo);
        $datos = ([
            'titulo' => $request->get('titulo'),
            'descripcion'=> $request->get('descripcion')
        ]);

       // Agregamos los datos de la galeria
        $id = Galeria::create($datos);
        $id_g = $id->id_g;

        // Creamos el Directorio
        mkdir($urlGAleria.$tituloEditado , 0777);

        // Recorremos el file y lo guardamos en el directorio Creado
        foreach ($request->file('file') as $value){
            $nombre =    $value->getClientOriginalName();
            $imgG = Imgs::where('url', '=', $princUrl.$tituloEditado.'/'.$nombre)->get();

            // Validamos si la img éxiste
            if($imgG =='[]'){
                $value->move($urlGAleria.$tituloEditado, $nombre);
                $url= $princUrl.$tituloEditado.'/'.$nombre;
                $Imgs->GuardarImgs($url, $titulo, $id_g, '', ''); //
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
        $urlGAleria='../../ImagenesModelaje/ImgGaleria/';

        // obtengo los datos de GAleria
       $galeria = Galeria::find($id);
       $titulo = $galeria->titulo;
       $tituloEditado = str_replace(" ", "_", $titulo);

       // Elimino las imagenes asociadas a galeria
        $imgs = Imgs::where('id_g', '=', $id)->get();
        foreach ($imgs as $valor){
            $valor->delete();
        }
        // Elimino la carpeta del directorio

            //rmdir($urlGAleria.$tituloEditado);

        // Elimino la fila de galeria
        $galeria = Galeria::find($id);
        $galeria->delete();

        return response()->json(['Mensaje'=>'El evento fue eliminado de manera éxitosa']);


    }
}
