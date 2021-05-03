<?php

namespace App\Http\Controllers;

use App\Classes\Utilitat;
use Illuminate\Http\Request;
use App\Models\TipusIncidencia;
use Illuminate\Database\QueryException;

class TipusIncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipusIncidencia = TipusIncidencia::all();
        return view('pages.cecos.altres.tipusIncidencia.index', ['tipusIncidencia' => $tipusIncidencia]);
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
        $tipusIncidencia = new TipusIncidencia();

        /* $tipusRecurs->id = $request->input('id'); */
        /* $tipusIncidencia->id = 5; */
        $tipusIncidencia->tipus = $request->input('tipus');

        try {
            $tipusIncidencia->save();
            $request->session()->flash('mensaje', 'Registre creat correctament');
            $response = redirect()->action([TipusIncidenciaController::class, 'index']);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitat::handleErrorMessage($e);
            $request->session()->flash('error', $mensaje);
            $response = redirect()->action([TipusIncidenciaController::class, 'index'])->withInput();
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipusIncidencia  $tipusIncidencia
     * @return \Illuminate\Http\Response
     */
    public function show(TipusIncidencia $tipusIncidencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipusIncidencia  $tipusIncidencia
     * @return \Illuminate\Http\Response
     */
    public function edit(TipusIncidencia $tipusIncidencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipusIncidencia  $tipusIncidencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipusIncidencia $tipusIncidencia)
    {
        /* $tipusIncidencia->id = $request->input('id'); */
        $tipusIncidencia->tipus = $request->input('tipus');


        try {
            $tipusIncidencia->save();
            $request->session()->flash('mensaje', 'Registre modificat correctament');
            $response = redirect()->action([TipusIncidenciaController::class, 'index']);
        }
        catch (QueryException $ex)
        {
            $mensaje = Utilitat::handleErrorMessage($ex);
            $request->session()->flash('error', $mensaje);
            $response = redirect()->action([TipusIncidenciaController::class, 'index'])->withInput();
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipusIncidencia  $tipusIncidencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,TipusIncidencia $tipusIncidencia)
    {
        try {
            $tipusIncidencia->delete();
            $request->session()->flash('mensaje', 'Registre esborrat correctament');
        }
        catch (QueryException $ex)
        {
            $mensaje = Utilitat::handleErrorMessage($ex);
            $request->session()->flash('error', $mensaje);

        }

        return redirect()->action([TipusIncidenciaController::class, 'index']);
    }
}
