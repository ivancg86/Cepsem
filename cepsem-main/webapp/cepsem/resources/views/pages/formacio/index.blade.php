@extends('layouts.layout')

@section('pagename')
    Formacio
@endsection

@section('header')
    @if (Auth::check())
        <header-component username="{{ Auth::user()->nom }}" :formacio="true" :helpbox="true"></header-component>
    @else
        <header-component :formacio="true" :helpbox="true"></header-component>
    @endif
@endsection

@section('content')

    <div class="container my-5">

        <div class="formacio-video">
            <h2>RCP: Reanimació Cardiopulmonar</h2>
            <div style="background-color: rgb(24, 24, 24); padding: 24px">
                <video id="myVideo" src="http://daw.abp-politecnics.com/daw2b02/cepsem/public/assets/media/CLIP1.mp4" >
                    Your browser does not support HTML5 video.
                </video>
            </div>
        </div>

        <div id="presentacio" class="formacio-body">
            <h5 >A continuació veuras un video de com fer una RCP.
                A mesura que avancis en el video, aniran sortin una serie de preguntas que
                hauras d'anar responent, para-hi molta atenció!</h5>

            <div style="text-align: right">
                <button type="button" id="boton1" class="button button-icon button--rounded button--pink"
                    style="background-image: url('/cepsem/webapp/cepsem/public/assets/icons/next.svg')"
                    onclick="endavant()">Endavant</button>
            </div>
        </div>
            <div id="pregunta" style="display: none" class="formacio-body">
                <div class="form-group row">
                    <label for="evolucion" class="col-sm-10 col-form-label"> <b id="enunciat">Pregunta 1: Que es el
                            primer que s'ha de fer quan veiem a una persona tenint parada cardiorespiratoria?
                        </b></label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input type="radio" id="opcio1" name="exampleRadios" class="form-check-input" value="option1">
                            <label class="form-check-label" for="opcio1" id="label1">Alertar al 112</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="opcio2" name="exampleRadios" class="form-check-input" value="option2">
                            <label class="form-check-label" for="opcio2" id="label2">Avaluar la consciencia i la
                                respiracio</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="opcio3" name="exampleRadios" class="form-check-input" value="option3">
                            <label class="form-check-label" for="opcio3" id="label3">Cridar per demanar ajuda</label>
                        </div>
                    </div>
                </div>
                <div style="text-align: right">
                    <button id="btnValidar" type="button" class="button button--blue" onclick="reanudar()" >Validar</button>
                </div>
            </div>

            <div id="final" class="formacio-body" style="display: none">
                <h5 >Felicitats! Has completat la formació sobre la reanimació cardeopulmonar.</h5>
                <div style="text-align: right">
                    <button id="btnValidar" type="button"  class="button button-icon button--rounded button--pink" style="background-image: url('/cepsem/webapp/cepsem/public/assets/icons/next.svg')"> <a href="/cepsem/webapp/cepsem/public/">Torna a l'inici</a></button>
                </div>
            </div>
    </div>




@endsection
