@extends('adminlte::page')

@section('title', 'Retransmepa')

@section('content_header')
    <h2>Editar Cargos</h2>
@stop

@section('content')
    <form action="/cargos/{{$cargo->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="" class="form-label">Nombre del cargo</label>
            <input id="nombreCargo" name="nombreCargo" type="text" class="form-control" value="{{$cargo->nombreCargo}}" readonly>
        </div>
        <a href="/cargos" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop
