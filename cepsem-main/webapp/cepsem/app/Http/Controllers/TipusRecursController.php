<?php

namespace App\Http\Controllers;

use App\Classes\Utilitat;
use App\Models\TipusRecurs;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TipusRecursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipusRecurs = TipusRecurs::all();
        return view('pages.cecos.altres.tipusRecursos.index', ['tipusRecurs' => $tipusRecurs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipus_recur = new TipusRecurs();

        /* $tipusRecurs->id = 5; */
        $tipus_recur->tipus = $request->input('tipus');

        try {
            $tipus_recur->save();
            $request->session()->flash('mensaje', 'Registre creat correctament');
            $response = redirect()->action([TipusRecursController::class, 'index']);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitat::handleErrorMessage($e);
            $request->session()->flash('error', $mensaje);
            $response = redirect()->action([TipusRecursController::class, 'index'])->withInput();
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipusRecurs  $tipusRecurs
     * @return \Illuminate\Http\Response
     */
    public function show(TipusRecurs $tipusRecurs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipusRecurs  $tipusRecurs
     * @return \Illuminate\Http\Response
     */
    public function edit(TipusRecurs $tipusRecurs)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipusRecurs  $tipusRecurs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipusRecurs $tipusRecurs)
    {
        $tipusRecurs->tipus = $request->input('tipus');


        try {
            $tipusRecurs->save();
            $request->session()->flash('mensaje', 'Registre modificat correctament');
            $response = redirect()->action([TipusRecursController::class, 'index']);
        }
        catch (QueryException $ex)
        {
            $mensaje = Utilitat::handleErrorMessage($ex);
            $request->session()->flash('error', $mensaje);
            $response = redirect()->action([TipusRecursController::class, 'index'])->withInput();
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipusRecurs  $tipusRecurs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,TipusRecurs $tipus_recur)
    {
        try {
            $tipus_recur->delete();
            $request->session()->flash('mensaje', 'Registre esborrat correctament');
        }
        catch (QueryException $ex)
        {
            $mensaje = Utilitat::handleErrorMessage($ex);
            $request->session()->flash('error', $mensaje);

        }

        return redirect()->action([TipusRecursController::class, 'index']);
    }
}
