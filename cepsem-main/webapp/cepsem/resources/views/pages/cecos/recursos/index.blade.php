@extends('layouts.layout')

@section('pagename')
Recursos
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
    <recurs-component :tipusrecursos="{{ $tipusRecurs }}"></recurs-component>
</div>
@endsection
