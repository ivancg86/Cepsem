@extends('layouts.layout')

@section('pagename')
Incidència
@endsection

@section('header')
@if (Auth::check())
<header-component username="{{ Auth::user()->nom }}" :formacio="true" :helpbox="true"></header-component>
@else
<header-component :formacio="true" :helpbox="true"></header-component>
@endif

@endsection

@section('content')
    @if ($idincidencia == -1)
        <incidenciaform-component :insert="true" :usuari="{{ Auth::user() }}" :tipusalertants="{{ $tipusAlertants }}" :provincies="{{ $provincies }}" :tipusincidents="{{ $tipusIncidents }}" :sexes="{{ $sexes }}" :tipusrecursos="{{ $tipusRecursos }}"></incidenciaform-component>
    @else
        <incidenciaform-component :idincidencia="{{ $idincidencia }}" :usuari="{{ Auth::user() }}" :insert="false" :tipusalertants="{{ $tipusAlertants }}" :provincies="{{ $provincies }}" :tipusincidents="{{ $tipusIncidents }}" :sexes="{{ $sexes }}" :tipusrecursos="{{ $tipusRecursos }}"></incidenciaform-component>
    @endif
@endsection
