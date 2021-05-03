@extends('layouts.layout')

@section('pagename')
Tipus Incidencia
@endsection

@section('header')
    <header-component :formacio="true" :helpbox="false" :logged="true"></header-component>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Incidencia</h4>


    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Tipus</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($tipusIncidencia as $incidencia)
                <tr>
                    <th scope="row">{{ $incidencia->id }}</th>
                    <td>{{ $incidencia->tipus }}</td>

                    <td style="display: flex;
                    justify-content: flex-end;">
                        <button type="submit" id="myBtn" class="button button-icon button--rounded button-inverted button-inverted--red float-right ml-2" data-toggle="modal" data-target="#modal{{ $incidencia->id }}">Esborrar</button>
                        <button type="submit" class="button button-icon button--rounded button--blue float-right ml-2" style="background-image: url('../assets/icons/edit.svg')" data-toggle="modal" data-target="#modalUpdate">Editar</button>



                        {{-- MODAL ELIMINAR --}}
                        <div class="modal" id="modal{{ $incidencia->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Esborrar Incidencia</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Estas segur de que vols esborrar la incidencia {{ $incidencia->tipus }}</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Tancar</button>
                                  <form action="{{ action([App\Http\Controllers\TipusIncidenciaController::class, 'destroy'], ['tipus_incidencium' => $incidencia->id]) }}" method="POST">
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
                                <form action="{{ action([App\Http\Controllers\TipusIncidenciaController::class, 'store']) }}" method="POST">
                                @csrf
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">

                                  <h5 class="modal-title">Incidencia</h5>
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
                            <form action="{{ action([App\Http\Controllers\TipusIncidenciaController::class, 'update'], ['tipus_incidencium' => $incidencia->id]) }}" method="POST">
                            @csrf
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">

                              <h5 class="modal-title">Incidencia</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-2" for="sigles">Tipus</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" name="tipus" id="tipus" value="{{ $incidencia->tipus }}">
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

<a class="button button-icon button--pink flotante" style="background-image: url('../assets/icons/add.svg')" data-toggle="modal" data-target="#modalCrear"><i class="fas fa-plus" ></i>Nova incidencia</a>


