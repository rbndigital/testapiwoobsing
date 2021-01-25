<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Resources\UsuarioResource;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response([ 'usuarios' => UsuarioResource::collection($usuarios), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nombre' => 'required|max:55',
            'apellido' => 'required|max:55',
            'telefono' => 'required|max:10|min:10',
            'email' => 'email|required|unique:usuarios',
            'direccion' => 'required|max:55'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $usuario = Usuario::create($data);

        return response(['usuario' => new UsuarioResource($usuario), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        return response(['usuario' => new UsuarioResource($usuario), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $usuario->update($request->all());

        return response(['usuario' => new UsuarioResource($usuario), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response(['message' => 'Deleted']);
    }
}
