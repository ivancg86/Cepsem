<?php

namespace App\Http\Controllers;

use App\Models\Sexe;
use App\Models\Provincia;
use App\Models\TipusRecurs;
use Illuminate\Http\Request;
use App\Models\TipusAlertant;
use App\Models\TipusIncidencia;
use App\Models\IncidenciaHasRecurs;

class IncidenciaHasRecursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provincies = Provincia::with(['comarques', 'comarques.municipis'])->get();
        $tipusAlertants = TipusAlertant::all();
        $tipusIncidents = TipusIncidencia::all();
        $sexes = Sexe::all();
        $tipusRecursos = TipusRecurs::all();

        return view('pages.recursMobil.index', compact('provincies', 'tipusAlertants', 'tipusIncidents', 'sexes', 'tipusRecursos'));
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
        $provincies = Provincia::with(['comarques', 'comarques.municipis'])->get();
        $tipusAlertants = TipusAlertant::all();
        $tipusIncidents = TipusIncidencia::all();
        $sexes = Sexe::all();
        $tipusRecursos = TipusRecurs::all();
        return view('pages.cecos.incidencies.incidencia', compact('incidenciaHasRecurs', 'provincies', 'tipusAlertants', 'tipusIncidents', 'sexes', 'tipusRecursos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncidenciaHasRecurs  $incidenciaHasRecurs
     * @return \Illuminate\Http\Response
     */
    public function edit(IncidenciaHasRecurs $incidenciaHasRecurs)
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
