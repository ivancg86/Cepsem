<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\IncidenciaResource;
use App\Models\Incidencia;
use App\Models\IncidenciaHasAfectat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Classes\Utilitat;
use App\Models\Afectat;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return IncidenciaResource::collection(Incidencia::all());
        return IncidenciaResource::collection(Incidencia::with(['afectats', 'tipus_incidencia', 'recursos', 'municipi.comarca.provincia', 'alertant', 'usuari'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rollback = false;

        //si tots els camps obligatoris han estat omplerts
        if (Utilitat::checkIncidencia($request) == "") {

            $incidencia = Utilitat::getIncidencia($request);

            //afegirem l'alertant en cas que no existeixi
            if (empty($request->input("alertant.id"))) {
                if (Utilitat::checkAlertant($request->input("alertant")) == "") {
                    $alertant = Utilitat::getAlertant($request->input("alertant"));
                    $alertant->save();
                    $incidencia->alertants_id = $alertant->id;
                } else {
                    $rollback = true;
                }
            }

            try {
                DB::beginTransaction();

                $incidencia->save();

                $incidencia_has_recursos = $request->input('incidencia_has_recursos');
                $response = "";
                $i = 0;
                while ($response == "" && $i < count($incidencia_has_recursos)) {
                    $incidencia_has_recurs = $incidencia_has_recursos[$i];

                    $response = Utilitat::checkIncidenciaHasRecurs($incidencia_has_recurs);

                    //si tots els camps obligatoris de incidencia_has_recurs han estat omplerts
                    if ($response == "") {

                        //afegirem l'afectat en cas que no existeixi
                        $afectat = $this->getAfectat($incidencia_has_recurs["afectat"]);
                        if ($afectat->id < 1) {
                            unset($afectat->id);
                            $afectat->save();
                        }

                        $incidencia_has_recurs = Utilitat::getIncidenciaHasRecurs($incidencia_has_recurs);
                        $incidencia_has_recurs->incidencies_id = $incidencia->id;
                        $incidencia_has_recurs->afectats_id = $afectat->id;
                        $incidencia_has_recurs->save();

                        $incidencia_has_afectat = new IncidenciaHasAfectat();
                        $incidencia_has_afectat->incidencies_id = $incidencia->id;
                        $incidencia_has_afectat->afectats_id = $afectat->id;
                        $incidencia_has_afectat->save();
                    } else {
                        $rollback = true;
                    }

                    $i++;
                }
            } catch (QueryException $e) {
                $rollback = true;
                $response = \response(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
            }
        }

        if ($rollback) {
            DB::rollBack();
            $response = \response(['errorMessage' => $response], 400);
        } else {
            DB::commit();
            $incidencia->update();
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incidencia  $incidency
     * @return \Illuminate\Http\Response
     */
    public function show(Incidencia $incidency)
    {
        return new IncidenciaResource(Incidencia::with(['tipus_incidencia', 'usuari', 'municipi.comarca.provincia', 'alertant.municipi.comarca.provincia', 'incidencia_has_recursos.recurs', 'incidencia_has_recursos.afectat', 'incidencia_has_recursos.recurs.tipus_recurs'])->find($incidency->id));
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
        $incidencia = $this->updateIncidencia($request->request->parameters);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incidencia  $incidency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incidencia $incidency)
    {
        try {
            $incidency->delete();
            $response = \response()->json(['message' => "Incidència esborrada correctament"], 200);
        } catch (QueryException $e) {
            $response = \response()->json(['errorMessage' => Utilitat::handleErrorMessage($e)], 400);
        }

        return $response;
    }


    public function getAfectat($incidencia_has_recurs_afectat)
    {
        $afectat = new Afectat();

        $afectat->id = $incidencia_has_recurs_afectat['id'];
        $afectat->telefon = $incidencia_has_recurs_afectat['telefon'];
        $afectat->cip = $incidencia_has_recurs_afectat['cip'];
        $afectat->nom = $incidencia_has_recurs_afectat['nom'];
        $afectat->cognoms = $incidencia_has_recurs_afectat['cognoms'];
        $afectat->edat = $incidencia_has_recurs_afectat['edat'];
        $afectat->te_cip = $incidencia_has_recurs_afectat['te_cip'];
        $afectat->sexes_id = $incidencia_has_recurs_afectat['sexes_id'];

        return $afectat;
    }

    public function updateIncidencia($request)
    {

    }
}
