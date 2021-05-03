@extends('layouts.layout')

@section('pagename')
Usuaris
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
    <usuari-component :rols="{{ $rols }}" :recursos="{{ $recursos }}"></usuari-component>
</div>
@endsection

{{-- @if (Auth::check())
    @switch(Auth::user()->rols_id)
        @case(1)

            @break
        @case(2)

            @break
        @case(3)

            @break
        @default

    @endswitch
@else
    {{ return redirect()->action([App\Http\Controllers\UsuariController::class, 'index']) }}
@endif
 --}}
