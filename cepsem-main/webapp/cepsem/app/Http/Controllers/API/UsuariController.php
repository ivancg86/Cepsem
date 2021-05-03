<?php

namespace App\Http\Controllers\API;

use App\Classes\Utilitat;
use App\Models\Usuari;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsuariResource;
use Illuminate\Database\QueryException;

class UsuariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsuariResource::collection(Usuari::with(['incidencies', 'recurs', 'rol'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->checkUsuari($request);

        try {
            if (($response) == ' ') {
                $nouUsuari = $this->getUsuari($request);
                $nouUsuari->save();

                $response = (new UsuariResource($nouUsuari))
                ->response()
                ->setStatusCode(201);
            }

        } catch (QueryException $e) {
            $response = \response(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function show(Usuari $usuari)
    {
        return new UsuariResource($usuari);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuari $usuari)
    {
        try {
            $usuari->update([
                'username' => $request->input('username'),
                'contrasenya' => $request->input('contrasenya'),
                'email' => $request->input('email'),
                'nom' => $request->input('nom'),
                'cognoms' => $request->input('cognoms'),
                'rols_id' => $request->input('rols_id'),
                'recursos_id' => $request->input('recursos_id')
            ]);

            $response = (new UsuariResource($usuari))
                ->response()
                ->setStatusCode(204);
        } catch (QueryException $e) {
            $response = \response(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuari $usuari)
    {
        try {
            $usuari->delete();
            $response = \response()->json(['message' => "Usuari esborrat correctament"], 200);
        } catch (QueryException $e) {
            $response = \response()->json(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }

        return $response;
    }

    public function getUsuari($request)
    {
        $usuari = new Usuari();

        $usuari->username = $request->input('username');
        $usuari->contrasenya = $request->input('contrasenya');
        $usuari->email = $request->input('email');
        $usuari->nom = $request->input('nom');
        $usuari->cognoms = $request->input('cognoms');
        $usuari->rols_id = $request->input('rols_id');
        $usuari->recursos_id = $request->input('recursos_id');

        return $usuari;
    }

    public function checkUsuari($request)
    {
        if (empty($request->input('username'))) {
            $response = \response(['errorMessage' => "El camp username és obligatori"]);
        } else if (empty($request->input('contrasenya'))) {
            $response = \response(['errorMessage' => "El camp contrasenya és obligatori"]);
        } else if (empty($request->input('email'))) {
            $response = \response(['errorMessage' => "El camp email és obligatori"]);
        } else if (empty($request->input('nom'))) {
            $response = \response(['errorMessage' => "El camp nom és obligatori"]);
        } else if (empty($request->input('cognoms'))) {
            $response = \response(['errorMessage' => "El camp cognoms és obligatori"]);
        } else if (empty($request->input('rols_id'))) {
            $response = \response(['errorMessage' => "El camp rol és obligatori"]);
        } else {
            $response = ' ';
        }

        return $response;
    }
}
