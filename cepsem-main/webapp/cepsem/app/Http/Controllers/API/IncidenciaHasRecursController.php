<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncidenciaHasRecursResource;
use App\Models\IncidenciaHasRecurs;
use Illuminate\Http\Request;

class IncidenciaHasRecursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IncidenciaHasRecursResource::collection(IncidenciaHasRecurs::with(['incidencia', 'recurs', 'afectat'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncidenciaHasRecurs  $incidenciaHasRecurs
     * @return \Illuminate\Http\Response
     */
    public function show(IncidenciaHasRecurs $incidenciaHasRecurs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncidenciaHasRecurs  $incidenciaHasRecurs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncidenciaHasRecurs $incidenciaHasRecurs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncidenciaHasRecurs  $incidenciaHasRecurs
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncidenciaHasRecurs $incidenciaHasRecurs)
    {
        //
    }
}
