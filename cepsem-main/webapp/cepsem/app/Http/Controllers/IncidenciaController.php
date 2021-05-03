<?php

namespace App\Http\Controllers;

use App\Models\Sexe;
use App\Models\Provincia;
use App\Models\Incidencia;
use App\Models\TipusRecurs;
use Illuminate\Http\Request;
use App\Models\TipusAlertant;
use App\Models\TipusIncidencia;
use App\Models\IncidenciaHasRecurs;
use Illuminate\Support\Facades\Auth;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cecos.incidencies.index');
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
     * @param  \App\Models\Incidencia  $incidency
     * @return \Illuminate\Http\Response
     */
    public function show($idincidencia)
    {
        $provincies = Provincia::with(['comarques', 'comarques.municipis'])->get();
        $tipusAlertants = TipusAlertant::all();
        $tipusIncidents = TipusIncidencia::all();
        $sexes = Sexe::all();
        $tipusRecursos = TipusRecurs::all();
        $rol = Auth::user()->rols_id;
        return view('pages.cecos.incidencies.incidencia', compact('idincidencia', 'provincies', 'tipusAlertants', 'tipusIncidents', 'sexes', 'tipusRecursos', 'rol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incidencia  $incidency
     * @return \Illuminate\Http\Response
     */
    public function edit(Incidencia $incidency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incidencia  $incidency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incidencia $incidency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incidencia  $incidency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incidencia $incidency)
    {
        //
    }
}
