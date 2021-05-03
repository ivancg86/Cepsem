<?php

namespace App\Http\Controllers\API;

use App\Classes\Utilitat;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlertantResource;
use App\Models\Alertant;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AlertantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $alertants = AlertantResource::collection(Alertant::all()->map->only(['id', 'nom'])->with(['incidencies', 'municipi', 'tipus_alertant'])->get());
        // $alertants = AlertantResource::collection(
        //     Alertant::query()
        //         ->with()
        //     Alertant::all()->map->only(['id', 'nom'])->with(['incidencies', 'municipi', 'tipus_alertant'])->get()
        // );
        // return $alertants;


        // return AlertantResource::collection(Alertant::all());


        // $alertants = AlertantResource::collection(Alertant::with(['incidencies', 'municipi', 'tipus_alertant'])->get());
        // return $alertants->map(function($alertant) {
            //     $alertant->testsilfjsld = 'jhsdkbfkjsdnfkls';
            //     return $alertant;
            // });

            return AlertantResource::collection(Alertant::with(['incidencies', 'municipi', 'municipi.comarca', 'municipi.comarca.provincia', 'tipus_alertant'])->get());
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Utilitat::checkAlertant($request) == ""){
            try {
                $nouAlertant = Utilitat::getAlertant($request);
                $nouAlertant->save();

                $response = (new AlertantResource($nouAlertant))
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
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function getAlertantbyTelefon($telefon)
    {
        return new AlertantResource(Alertant::with(['municipi.comarca.provincia', 'tipus_alertant'])->where("telefon", "=", $telefon)->get());
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function show(Alertant $alertant)
    {
        return new AlertantResource($alertant);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alertant $alertant)
    {
        try {
            $alertant->update([
                'telefon' => $request->input('telefon'),
                'nom' => $request->input('nom'),
                'cognoms' => $request->input('cognoms'),
                'adreca' => $request->input('adreca'),
                'municipis_id' => $request->input('municipis_id'),
                'tipus_alertants_id' => $request->input('tipus_alertants_id')
            ]);

            $response = (new AlertantResource($alertant))
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
     * @param  \App\Models\Alertant  $alertant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alertant $alertant)
    {
        try {
            $alertant->delete();
            $response = \response()->json(['message' => "Alertant esborrat correctament"], 200);
        } catch (QueryException $e) {
            $response = \response()->json(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }

        return $response;
    }




}
