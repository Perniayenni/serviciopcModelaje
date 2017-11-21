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

    // Editamos las imagenes
    public function EditarImagenes($url, $id){
        $imgs = Imgs::find($id);

        if ($url != null && $url!=''){
            $imgs->url=$url;
        }
        $imgs->save();
    }

    // Obtenemos todas las imagenes segun el id de galeria
    public function getImgs($ref, $id){
        if ($ref == 'Galeria'){
            $datos = Imgs::where('id_g', '=', $id)->get();
            return response()->json($datos);
        }else
            if($ref == 'Destacados'){
                $datos = Imgs::where('id_d', '=', $id)->get();
                return response()->json($datos);
            }else
                if ($ref == 'Modelos'){
                    $datos = Imgs::where('id_m', '=', $id)->get();
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


    }

    // Eliminamos las imagenes segun el id
    public function destroy($id)
    {
        $img = Imgs::find($id);
        $url = $img->url;
        $urlEditada= str_replace("http://www.ourproject.cl/", "/", $url);
         unlink('../..'.$urlEditada);
         $img->delete();
        return  response()->json(['mensaje'=>true, 'codigo'=>200], 200);

    }

    public function RedimenscionarImg($url){
        //Ruta de la imagen original
        $rutaImagenOriginal= $url;

        //Creamos una variable imagen a partir de la imagen original
        $img_original = imagecreatefromjpeg($rutaImagenOriginal);

        //Se define el maximo ancho o alto que tendra la imagen final
        $max_ancho = 400;
        $max_alto = 300;

        //Ancho y alto de la imagen original
        list($ancho,$alto)=getimagesize($rutaImagenOriginal);

        //Se calcula ancho y alto de la imagen final
        $x_ratio = $max_ancho / $ancho;
        $y_ratio = $max_alto / $alto;

        //Si el ancho y el alto de la imagen no superan los maximos,
        //ancho final y alto final son los que tiene actualmente
        if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        }
        /*
         * si proporcion horizontal*alto mayor que el alto maximo,
         * alto final es alto por la proporcion horizontal
         * es decir, le quitamos al alto, la misma proporcion que
         * le quitamos al alto
         *
        */
        elseif (($x_ratio * $alto) < $max_alto){
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $max_ancho;
        }
        /*
         * Igual que antes pero a la inversa
        */
        else{
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $max_alto;
        }

        //Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
        $tmp=imagecreatetruecolor($ancho_final,$alto_final);

        //Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
        imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);

        //Se destruye variable $img_original para liberar memoria
        imagedestroy($img_original);

        //Definimos la calidad de la imagen final
        $calidad=95;

        //Se crea la imagen final en el directorio indicado
        imagejpeg($tmp,$url,$calidad);

        /* SI QUEREMOS MOSTRAR LA IMAGEN EN EL NAVEGADOR
         *
         * descomentamos las lineas 64 ( Header("Content-type: image/jpeg"); ) y 65 ( imagejpeg($tmp); )
         * y comentamos la linea 57 ( imagejpeg($tmp,"./imagen/retoque.jpg",$calidad); )
         */
        //Header("Content-type: image/jpeg");
        //imagejpeg($tmp);

    }
}
