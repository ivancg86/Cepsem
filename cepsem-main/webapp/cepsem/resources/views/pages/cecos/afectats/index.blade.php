@extends('layouts.layout')

@section('pagename')
Afectats
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
    <afectat-component :sexes="{{ $sexe }}"></afectat-component>
</div>
@endsection

