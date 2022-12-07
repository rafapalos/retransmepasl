@extends('adminlte::page')

@section('title', 'Retransmepa')

@section('content_header')
    <h2>Añadir Cargo</h2>
@stop

@section('content')
<form action="/cargos" method="POST">
    @csrf
    <div class="mb-3">
        <label for="" class="form-label">Nombre del cargo</label>
        <input id="nombreCargo" name="nombreCargo" type="text" value="{{old('nombreCargo')}}" maxLength="30" class="form-control" required>
        @if ($errors->has('nombreCargo'))
                <span class="error text-danger" for="input-nombreCargo">El nombre del cargo ya está registrado anteriormente</span>
        @endif
    </div>
    <a href="/cargos" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@stop