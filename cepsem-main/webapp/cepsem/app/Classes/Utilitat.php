<?php

namespace App\Classes;

use App\Models\Afectat;
use App\Models\Alertant;
use App\Models\Incidencia;
use App\Models\IncidenciaHasRecurs;
use Illuminate\Database\QueryException;

class Utilitat
{


    public static function handleErrorMessage(QueryException $queryException)
    {

        $errorMessage = "";

        if (!empty($queryException->errorInfo[1])) {

            switch ($queryException->errorInfo[1]) {
                    //MySQL server-side error codes
                case 1005:
                    $errorMessage = "No s'ha pogut crear la taula (" . $queryException->errorInfo[2] . ")";
                    break;
                case 1044:
                    $errorMessage = "Accés denegat a la BD, user/password incorrectes";
                    break;
                case 1049:
                    $errorMessage = "Base de dades desconeguda";
                    break;
                case 1050:
                    $errorMessage = "Taula ja existent";
                    break;
                case 1051:
                    $errorMessage = "Taula desconeguda";
                    break;
                case 1054:
                    $errorMessage = "Columna desconeguda";
                    break;
                case 1062:
                    $errorMessage = "Aquest registre ja existeix";
                    break;
                default:
                    $errorMessage = "Error " . $queryException->errorInfo[1] . ": " . $queryException->errorInfo[2];
                    break;
            }
        } else {

            switch ($queryException->getCode()) {
                case 1044:
                    $errorMessage = "Accés denegat a la BD, user/password incorrectes";
                    break;
                case 1049:
                    $errorMessage = "Base de dades desconeguda";
                    break;
                case 2002:
                    $errorMessage = "No s'ha trobat el servidor servidor";
                    break;
                default:
                    $errorMessage = "Error " . $queryException->getCode() . ": " . $queryException->getMessage();
                    break;
            }
        }

        return $errorMessage;
    }

    public static function checkAlertant($alertant)
    {
        if (empty($alertant["telefon"])) {
            $response = \response(['errorMessage' => "El camp alertant.telefon és obligatori"]);
        } else if (empty($alertant["tipus_alertants_id"])) {
            $response = \response(['errorMessage' => "El camp alertant.tipus_alertants_id  és obligatori"]);
        } else {
            $response = '';
        }

        return $response;
    }

    public static function getAlertant($request)
    {
        $alertant = new Alertant();

        $alertant->telefon = $request['telefon'];
        $alertant->nom = $request['nom'];
        $alertant->cognoms = $request['cognoms'];
        $alertant->adreca = $request['adreca'];
        $alertant->municipis_id = $request['municipis_id'];
        $alertant->tipus_alertants_id = $request['tipus_alertants_id'];

        return $alertant;
    }


    public static function checkIncidenciaHasRecurs($incidencia_has_recurs)
    {
        if (empty($incidencia_has_recurs['incidencies_id'])) {
            $response = \response(['errorMessage' => "El camp incidencies_id (incidencia_has_recurs nº" +$incidencia_has_recurs->incidencies_id + " és obligatori"]);
        } else if (empty($incidencia_has_recurs['recursos_id'])) {
            $response = \response(['errorMessage' => "El camp recursos_id (incidencia_has_recurs nº" +$incidencia_has_recurs->incidencies_id + " és obligatori"]);
        } else if (empty($incidencia_has_recurs['afectat']['id'])) {
            $response = \response(['errorMessage' => "El camp afectats_id (incidencia_has_recurs nº" +$incidencia_has_recurs->incidencies_id + " és obligatori"]);
        } else {
            $response = '';
        }

        return $response;
    }

    public static function getIncidenciaHasRecurs($incidencia_has_recurs)
    {
        $incidenciaHasRecurs = new IncidenciaHasRecurs();

        $incidenciaHasRecurs->incidencies_id = $incidencia_has_recurs['incidencies_id'];
        $incidenciaHasRecurs->recursos_id = $incidencia_has_recurs['recursos_id'];
        $incidenciaHasRecurs->afectats_id = $incidencia_has_recurs['afectat']['id'];


        $incidenciaHasRecurs->hora_activacio = $incidencia_has_recurs['hora_activacio'];
        $incidenciaHasRecurs->hora_mobilitzacio = $incidencia_has_recurs['hora_mobilitzacio'];
        $incidenciaHasRecurs->hora_assistencia = $incidencia_has_recurs['hora_assistencia'];
        $incidenciaHasRecurs->hora_transport = $incidencia_has_recurs['hora_transport'];
        $incidenciaHasRecurs->hora_arribada_hospital = $incidencia_has_recurs['hora_arribada_hospital'];
        $incidenciaHasRecurs->hora_transferencia = $incidencia_has_recurs['hora_transferencia'];
        $incidenciaHasRecurs->hora_finalitzacio = $incidencia_has_recurs['hora_finalitzacio'];
        $incidenciaHasRecurs->prioritat = $incidencia_has_recurs['prioritat'];
        $incidenciaHasRecurs->desti = $incidencia_has_recurs['desti'];

        return $incidenciaHasRecurs;
    }


    public static function checkIncidencia($request)
    {
        if (empty($request->input('num_incident'))) {
            $response = \response(['errorMessage' => "El camp incidencia.num_incident és obligatori"]);
        } else if (empty($request->input('data'))) {
            $response = \response(['errorMessage' => "El camp incidencia.data és obligatori"]);
        } else if (empty($request->input('hora'))) {
            $response = \response(['errorMessage' => "El camp incidencia.hora és obligatori"]);
        } else if (empty($request->input('alertant.telefon'))) {
            $response = \response(['errorMessage' => "El camp incidencia.telefon_alertant és obligatori"]);
        } else if (empty($request->input('adreca'))) {
            $response = \response(['errorMessage' => "El camp incidencia.adreça és obligatori"]);
        } else if (empty($request->input('descripcio'))) {
            $response = \response(['errorMessage' => "El camp incidencia.descripció és obligatori"]);
        } else if (empty($request->input('tipus_incidencies_id'))) {
            $response = \response(['errorMessage' => "El camp incidencia.tipus_incidencies_id  és obligatori"]);
        // } else if (empty($request->input('alertants_id'))) {
            // $response = \response(['errorMessage' => "El camp incidencia.alertants_id  és obligatori"]);
        } else if (empty($request->input('municipis_id'))) {
            $response = \response(['errorMessage' => "El camp incidencia.municipis_id  és obligatori"]);
        } else if (empty($request->input('usuaris_id'))) {
            $response = \response(['errorMessage' => "El camp incidencia.usuaris_id  és obligatori"]);
        } else {
            $response = '';
        }

        return $response;
    }

    public static function getIncidencia($request)
    {
        $incidencia = new Incidencia();

        $incidencia->num_incident = $request->input('num_incident');
        $incidencia->data = $request->input('data');
        $incidencia->hora = $request->input('hora');
        $incidencia->telefon_alertant = $request->input('alertant.telefon');
        $incidencia->adreca = $request->input('adreca');
        $incidencia->adreca_complement = $request->input('adreca_complement');
        $incidencia->descripcio = $request->input('descripcio');
        $incidencia->nom_metge = $request->input('nom_metge');
        $incidencia->tipus_incidencies_id = $request->input('tipus_incidencies_id');
        $incidencia->alertants_id = $request->input('alertants_id');
        $incidencia->municipis_id = $request->input('municipis_id');
        $incidencia->usuaris_id = $request->input('usuaris_id');

        return $incidencia;
    }


    public static function checkAfectat($request)
    {
        if (empty($request->input('username'))) {
            $response = \response(['errorMessage' => "El camp afectat.username és obligatori"]);
        } else if (empty($request->input('contrasenya'))) {
            $response = \response(['errorMessage' => "El camp afectat.contrasenya és obligatori"]);
        } else if (empty($request->input('email'))) {
            $response = \response(['errorMessage' => "El camp afectat.email és obligatori"]);
        } else if (empty($request->input('nom'))) {
            $response = \response(['errorMessage' => "El camp afectat.nom és obligatori"]);
        } else if (empty($request->input('cognoms'))) {
            $response = \response(['errorMessage' => "El camp afectat.cognoms és obligatori"]);
        } else if (empty($request->input('rols_id'))) {
            $response = \response(['errorMessage' => "El camp afectat.rol és obligatori"]);
        } else if (empty($request->input('recursos_id'))) {
            $response = \response(['errorMessage' => "El camp afectat.recurs és obligatori"]);
        } else {
            $response = '';
        }

        return $response;
    }

    public static function getAfectat($request)
    {
        $afectat = new Afectat();

        $afectat->telefon = $request->input('telefon');
        $afectat->cip = $request->input('cip');
        $afectat->nom = $request->input('nom');
        $afectat->cognoms = $request->input('cognoms');
        $afectat->edat = $request->input('edat');
        $afectat->te_cip = $request->input('te_cip');
        $afectat->sexes_id = $request->input('sexes_id');

        return $afectat;
    }


}
