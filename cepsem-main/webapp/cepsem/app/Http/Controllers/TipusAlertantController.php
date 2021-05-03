<?php

namespace App\Http\Controllers;

use App\Classes\Utilitat;
use Illuminate\Http\Request;
use App\Models\TipusAlertant;
use Illuminate\Database\QueryException;

class TipusAlertantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipusAlertant = TipusAlertant::all();
        return view('pages.cecos.altres.tipusAlertant.index', ['tipusAlertant' => $tipusAlertant]);
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
        $tipusAlertant = new TipusAlertant();

        /* $tipusRecurs->id = $request->input('id'); */
        /* $tipusAlertant->id = 5; */
        $tipusAlertant->tipus = $request->input('tipus');

        try {
            $tipusAlertant->save();
            $request->session()->flash('mensaje', 'Registre creat correctament');
            $response = redirect()->action([TipusAlertantController::class, 'index']);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitat::handleErrorMessage($e);
            $request->session()->flash('error', $mensaje);
            $response = redirect()->action([TipusAlertantController::class, 'index'])->withInput();
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipusAlertant  $tipusAlertant
     * @return \Illuminate\Http\Response
     */
    public function show(TipusAlertant $tipusAlertant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipusAlertant  $tipusAlertant
     * @return \Illuminate\Http\Response
     */
    public function edit(TipusAlertant $tipusAlertant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipusAlertant  $tipusAlertant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipusAlertant $tipusAlertant)
    {
        /* $tipusAlertant->id = $request->input('id'); */
        $tipusAlertant->tipus = $request->input('tipus');


        try {
            $tipusAlertant->save();
            $request->session()->flash('mensaje', 'Registre modificat correctament');
            $response = redirect()->action([TipusAlertantController::class, 'index']);
        }
        catch (QueryException $ex)
        {
            $mensaje = Utilitat::handleErrorMessage($ex);
            $request->session()->flash('error', $mensaje);
            $response = redirect()->action([TipusAlertantController::class, 'index'])->withInput();
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipusAlertant  $tipusAlertant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,TipusAlertant $tipusAlertant)
    {
        try {
            $tipusAlertant->delete();
            $request->session()->flash('mensaje', 'Registre esborrat correctament');
        }
        catch (QueryException $ex)
        {
            $mensaje = Utilitat::handleErrorMessage($ex);
            $request->session()->flash('error', $mensaje);

        }

        return redirect()->action([TipusAlertantController::class, 'index']);
    }
}
