@extends('layouts.layout')

@section('pagename')
Alertants
@endsection

@section('header')
@if (Auth::check())
    <header-component username="{{ Auth::user()->nom }}" :formacio="true" :helpbox="true"></header-component>
@else
    <header-component :formacio="true" :helpbox="true"></header-component>
@endif

@endsection

@section('content')
<div class="container-fluid my-5">
    <alertant-component :tipusalertants="{{ $tipusAlertants }}" :provincies="{{ $provincies }}"></alertant-component>
</div>
@endsection
