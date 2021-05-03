@extends('layouts.layout')

@section('pagename')
CECOS
@endsection

@section('header')
@if (Auth::check())
<header-component username="{{ Auth::user()->nom }}" :formacio="true" :helpbox="true"></header-component>
@else
<header-component :formacio="true" :helpbox="true"></header-component>
@endif

@endsection

@section('content')
<div class="cecos">
    <div class="container-xl">
        <div class="row mt-5">
            <div class="col-md-6">
                <menucard-component size="lg" page="incidencies" name="INCIDÈNCIES" v-bind:secondary="false"></menucard-component>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <menucard-component size="sm" page="recursos-mobils" name="RECURSOS MÒBILS" v-bind:secondary="false">
                        </menucard-component>
                    </div>

                    <div class="col-md-12">
                        <menucard-component size="sm" page="alertants" name="ALERTANTS" v-bind:secondary="false"></menucard-component>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <menucard-component size="sm" page="usuaris" name="USUARIS" v-bind:secondary="false"></menucard-component>
            </div>

            <div class="col-md-6">
                <menucard-component size="sm" page="afectats" name="AFECTATS" v-bind:secondary="false"></menucard-component>
            </div>

            <div class="col-md-12">
                <div class="cepsem-card">
                    <h2 class="mb-5">ALTRES</h2>

                    <div class="cepsem-card-menu mt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <menucard-component size="sm" page="tipus-recurs" name="TIPUS RECURSOS" v-bind:secondary="true"></menucard-component>
                            </div>
                            <div class="col-md-4">
                                <menucard-component size="sm" page="tipus-alertant" name="TIPUS ALERTANTS" v-bind:secondary="true"></menucard-component>
                            </div>
                            <div class="col-md-4">
                                <menucard-component size="sm" page="tipus-incidencia" name="TIPUS INCIDÈNCIES" v-bind:secondary="true"></menucard-component>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</div>

@endsection
