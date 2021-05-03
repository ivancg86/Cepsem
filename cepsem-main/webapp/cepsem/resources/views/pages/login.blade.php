@extends('layouts.layout')


@section('pagename')
Login
@endsection

@section('content')

<div class="login">
    <div style="padding-top: 150px">
        <div class="form-container form-container--small cepsem-card">
            <h2>Iniciar Sessió</h2>

            <form action="{{ action([App\Http\Controllers\UsuariController::class, 'login']) }}" method="POST">
                @csrf
                <div class="input input--col mb-4">
                    <label for="username">Usuari</label>
                    <input type="text" name="username" id="username" placeholder="Introdueix el teu usuari..." autofocus
                        value="{{ old('username') }}">
                </div>

                <div class="input input--icon input--col" style="margin-bottom: 12px">
                    <label for="contrasenya">Contrasenya</label>
                    <div class="input-icon">
                        <input type="password" name="contrasenya" id="contrasenya"
                            placeholder="Introdueix la teva contrasenya..." value="{{ old('contrasenya') }}">
                        <div class="icon pw-icon" alt=""></div>
                    </div>
                </div>

                @if (session('error'))
                    <div class="input-error input-error--show">
                        <img src="{{ asset('assets/icons/alert.svg') }}" alt="" width="18px" height="18px"
                            style="margin-bottom: auto">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <button type="submit" class="button button--pink">INICIAR SESSIÓ</button>
            </form>
        </div>
    </div>

</div>
@endsection
