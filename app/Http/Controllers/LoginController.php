<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $usuario = $request->get('usuario');
        $contrasena = $request->get('contrasena');
        $Elusuario = Login::where('usuario', '=', $usuario)
            ->where('contrasena', '=', $contrasena)->get();

        if ($Elusuario!='[]'){
            $token = bin2hex( openssl_random_pseudo_bytes(20));
            foreach ($Elusuario as $value){
                 $this->actualizasToken($value->id_login, $token);
            }
            $NewCon = Login::where('usuario', '=', $usuario)
                ->where('contrasena', '=', $contrasena)->get();
            return response()->json($NewCon);
        }else{
            return response()->json(false);
        }

    }

    public function actualizasToken($id, $token){
            $usuario = Login::find($id);

            $usuario->token = $token;

            $usuario->save();
    }

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
