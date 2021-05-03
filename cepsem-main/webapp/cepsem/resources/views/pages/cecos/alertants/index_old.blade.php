@extends('layouts.layout')

@section('pagename')
Alertants
@endsection

@section('content')

<div class="form-container custom-card my-5">

    <h2 class="textBlue mb-4" style="font-weight: 700">Alertant</h2>

    <form action="{{ action([App\Http\Controllers\AlertantController::class, 'store']) }}" method="post">
        @csrf
        <div class="form-grid">
            <div class="input input--col">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="Introdueix el nom de l'alertant..."
                    value="{{ old('nom') }}">
            </div>

            <div class="input input--col">
                <label for="cognoms">Cognoms</label>
                <input type="text" name="cognoms" id="cognoms" placeholder="Introdueix els cognoms de l'alertant..."
                    value="{{ old('cognoms') }}">
            </div>

            <div class="input input--col">
                <label for="telefon">Telèfon</label>
                <input type="text" name="telefon" id="telefon" placeholder="Introdueix el telèfon de l'alertant..."
                    required value="{{ old('telefon') }}">
            </div>

            <div class="input input--col">
                <label for="adreca">Adreça</label>
                <input type="text" name="adreca" id="adreca" placeholder="Introdueix l'adreça de l'alertant..."
                    value="{{ old('adreca') }}">
            </div>

            <div class="input input--col">
                <label for="tipus">Tipus</label>
                <select name="tipus" id="tipus" class="select" required>
                    <option value="null" selected="true" disabled="disabled">Selecciona el tipus d'alertant...</option>

                    @foreach ($tipusAlertants as $tipusAlertant)

                    @if (session('tipus') == $tipusAlertant->id)
                    <option value="{{ $tipusAlertant->id }}" selected="true">{{ $tipusAlertant->tipus }}</option>
                    @else
                    <option value="{{ $tipusAlertant->id }}">{{ $tipusAlertant->tipus }}</option>
                    @endif

                    @endforeach
                </select>
            </div>

            <div class="input input--col">
                <label for="provincia">Provincia</label>
                <select id="provincia" class="select">
                    <option value="null" selected="true" disabled="disabled">Selecciona la provincia on es troba...
                    </option>
                    @foreach ($provincies as $provincia)
                    <option value="{{ $provincia->id }}">{{ $provincia->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input input--col">
                <label for="comarca">Comarca</label>
                <select id="comarca" class="select">
                    <option value="null" selected="true" disabled="disabled">Selecciona la comarca on es troba...
                    </option>
                    @foreach ($comarques as $comarca)
                    <option value="{{ $comarca->id }}">{{ $comarca->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input input--col">
                <label for="municipi">Municipi</label>
                <select name="municipi" id="municipi" class="select">
                    <option value="null" selected="true" disabled="disabled">Selecciona el municipi on es troba...
                    </option>
                    @foreach ($municipis as $municipi)
                    <option value="{{ $municipi->id }}">{{ $municipi->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-5">
            <button type="submit" class="button button-icon button--rounded button--blue mr-2"
                style="background-image: url({{ asset('assets/icons/add.svg') }})">Afegir</button>
            <a href="" class="button button-icon button--rounded button--pink"
                style="background-image: url({{ asset('assets/icons/cancel.svg') }})">Cancel·lar</a>
        </div>
    </form>

</div>

<div class="container-fluid my-5">
    <h1 class="page-title">Alertants</h1>

    <div class="d-flex justify-content-end">
        <a href="" class="button button-icon button--pink"
            style="background-image: url({{ asset('assets/icons/add.svg') }})">AFEGEIX UN NOU ALERTANT</a>
    </div>

    <div class="table-responsive  py-4">
        <table class="table table-hover">
            <thead>
                <tr class="table-danger">
                    <th scope="col">Telèfon</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Cognom</th>
                    <th scope="col">Adreça</th>
                    <th scope="col">Municipi</th>
                    <th scope="col">Tipus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alertants as $alertant)
                <tr class="table-info py-5">
                    <th scope="row">{{ $alertant->telefon }}</th>
                    <td>{{ $alertant->nom }}</td>
                    <td>{{ $alertant->cognoms }}</td>
                    <td>{{ $alertant->adreca }}</td>
                    <td>{{ $alertant->municipi }}</td>
                    <td>{{ $alertant->tipus }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $alertants->links() }}
    </div>

</div>






@endsection
