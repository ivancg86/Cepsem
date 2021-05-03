<?php

namespace App\Http\Controllers\API;

use App\Classes\Utilitat;
use App\Models\Afectat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AfectatResource;
use App\Models\Alertant;
use Illuminate\Database\QueryException;

class AfectatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AfectatResource::collection(Afectat::with(['sexe', 'incidencies'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Utilitat::checkAfectat($request);

        try {
            if ($response == '') {
                $nouAfectat = Utilitat::getAfectat($request);
                $nouAfectat->save();

                $response = (new AfectatResource($nouAfectat))
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
     * @param  \App\Models\Afectat  $cip
     * @return \Illuminate\Http\Response
     */
    public function show(String $cip)
    {
        return new AfectatResource(Afectat::with(['sexe'])->where('cip', '=', $cip)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Afectat  $afectat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Afectat $afectat)
    {
        try {
            $afectat->update([
                'telefon' => $request->input('telefon'),
                'cip' => $request->input('cip'),
                'nom' => $request->input('nom'),
                'cognoms' => $request->input('cognoms'),
                'edat' => $request->input('edat'),
                'te_cip' => $request->input('te_cip'),
                'sexes_id' => $request->input('sexes_id')
            ]);

            $response = (new AfectatResource($afectat))
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
     * @param  \App\Models\Afectat  $afectat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Afectat $afectat)
    {
        try {
            $afectat->delete();
            $response = \response()->json(['message' => "Afectat esborrat correctament"], 200);
        } catch (QueryException $e) {
            $response = \response()->json(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }

        return $response;
    }
}
