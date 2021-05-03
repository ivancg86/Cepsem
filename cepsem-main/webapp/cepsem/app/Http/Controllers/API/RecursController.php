<?php

namespace App\Http\Controllers\API;

use App\Classes\Utilitat;
use App\Http\Controllers\Controller;
use App\Models\Recurs;
use App\Models\TipusRecurs;
use Illuminate\Http\Request;
use App\Http\Resources\RecursResource;
use Illuminate\Database\QueryException;

class RecursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RecursResource::collection(Recurs::with(['incidencies', 'tipus_recurs', 'usuaris'])->get());
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
        if (empty($request->input('codi'))) {
            $response = \response(['errorMessage' => "El camp codi és obligatori"]);
        } else if (empty($request->input('tipus_recursos_id'))) {
            $response = \response(['errorMessage' => "El camp tipus és obligatori"]);
        } else {
            try {
                $nouRecurs = $this->getRecurs($request);
                $nouRecurs->save();

                $response = (new RecursResource($nouRecurs))
                    ->response()
                    ->setStatusCode(201);
            } catch (QueryException $e) {
                $response = \response(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
            }
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recurs  $recurs
     * @return \Illuminate\Http\Response
     */
    public function show(Recurs $recurs)
    {
        return new RecursResource($recurs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recurs  $recurs
     * @return \Illuminate\Http\Response
     */
    public function edit(Recurs $recurs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recurs  $recurs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recurs $recurso)
    {
        try {
            $recurso->update([
                'codi' => $request->input('codi'),
                'tipus_recursos_id' => $request->input('tipus_recursos_id'),
                'actiu' => ($request->input('actiu') == 'actiu')
            ]);

            $response = (new RecursResource($recurso))
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
     * @param  \App\Models\Recurs  $recurs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recurs $recurso)
    {
        try {
            $recurso->delete();
            $response = \response()->json(['message' => "Recurs esborrat correctament"], 200);
        } catch (QueryException $e) {
            $response = \response()->json(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }
        return $response;
    }




    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function getAvailableRecurs($tipus_recurs_id)
    {
        return new RecursResource(
            Recurs::with(['usuaris', 'tipus_recurs'])
                ->where('actiu', '=', 0)
                ->where('tipus_recursos_id', '=', $tipus_recurs_id)
                ->get()
        );
    }


      /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function setRecursAvailability($id, $available)
    {
        if($available == 0 || $available == 1){
            $recurs = Recurs::find($id);

            $recurs->actiu = $available;

            $recurs->save();
        }
    }




    public function getRecurs($request)
    {
        $recurso = new Recurs();

        $recurso->codi = $request->input('codi');
        $recurso->tipus_recursos_id = $request->input('tipus_recursos_id');
        $recurso->actiu = ($request->input('actiu') == 'actiu');

        return $recurso;
    }
}
