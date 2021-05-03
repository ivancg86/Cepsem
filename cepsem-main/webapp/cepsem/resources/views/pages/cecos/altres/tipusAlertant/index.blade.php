@extends('layouts.layout')

@section('pagename')
Tipus Alertants
@endsection

@section('header')
    <header-component :formacio="true" :helpbox="false" :logged="true"></header-component>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Alertants</h4>


    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Tipus</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($tipusAlertant as $alertant)
                <tr>
                    <th scope="row">{{ $alertant->id }}</th>
                    <td>{{ $alertant->tipus }}</td>

                    <td style="display: flex;
                    justify-content: flex-end;">
                        <button type="submit" id="myBtn" class="button button-icon button--rounded button-inverted button-inverted--red float-right ml-2" data-toggle="modal" data-target="#modal{{ $alertant->id }}"></i>Esborrar</button>
                        <button type="submit" class="button button-icon button--rounded button--blue float-right ml-2" style="background-image: url('../assets/icons/edit.svg')" data-toggle="modal" data-target="#modalUpdate"></i>Editar</button>

                        {{-- MODAL ELIMINAR --}}
                        <div class="modal" id="modal{{ $alertant->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Esborrar Alertant</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Estas segur de que vols esborrar el alertant {{ $alertant->tipus }}</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Tancar</button>
                                  <form action="{{ action([App\Http\Controllers\TipusAlertantController::class, 'destroy'], ['tipus_alertant' => $alertant->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger float-right"><i class="fas fa-trash-alt"></i>Esborrar</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>


                          {{-- MODAL CREAR --}}
                          <div class="modal" id="modalCrear" tabindex="-1" role="dialog">
                              <form action="{{ action([App\Http\Controllers\TipusAlertantController::class, 'store']) }}" method="POST">
                              @csrf
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">

                                <h5 class="modal-title">Alertant</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group row">
                                      <label class="col-2" for="sigles">Tipus</label>
                                      <div class="col-10">
                                          <input class="form-control" type="text" name="tipus" id="tipus">
                                      </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Tancar</button>
                                  <button type="submit" class="btn btn-danger float-right" ><i class="fas fa-trash-alt"></i>Aceptar</button>
                              </div>
                            </div>
                          </div>
                      </form>
                        </div>


                          {{-- MODAL UPDATE --}}
                          <div class="modal" id="modalUpdate" tabindex="-1" role="dialog">
                                <form action="{{ action([App\Http\Controllers\TipusAlertantController::class, 'update'], ['tipus_alertant' => $alertant->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h5 class="modal-title">Alertant</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-2" for="sigles">Tipus</label>
                                                    <div class="col-10">
                                                        <input class="form-control" type="text" name="tipus" id="tipus" value="{{ $alertant->tipus }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Tancar</button>
                                                <button type="submit" class="btn btn-danger float-right" ><i class="fas fa-trash-alt"></i>Aceptar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


@endsection

<a class="button button-icon button--pink flotante" style="background-image: url('../assets/icons/add.svg')" data-toggle="modal" data-target="#modalCrear">Nou recurs</a>


