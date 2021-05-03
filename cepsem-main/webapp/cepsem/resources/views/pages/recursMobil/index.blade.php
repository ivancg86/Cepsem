@extends('layouts.layout')

@section('pagename')
Recurs Mobil
@endsection

@section('header')
@if (Auth::check())
    <header-component username="{{ Auth::user()->nom }}" :formacio="false" :helpbox="false"></header-component>
@else
    <header-component :formacio="true" :helpbox="true"></header-component>
@endif

@endsection

@section('content')
<div class="container-fluid my-5">
    <recursmobil-component></recursmobil-component>
</div>
@endsection
