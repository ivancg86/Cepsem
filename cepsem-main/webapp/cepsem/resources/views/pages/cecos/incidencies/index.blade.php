@extends('layouts.layout')

@section('pagename')
Incidències
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
    <incidencies-component></incidencies-component>
</div>
@endsection
