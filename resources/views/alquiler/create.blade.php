@extends('adminlte::page')

@section('title', 'Retransmepa')

@section('content_header')
    <h2>Añadir Alquiler</h2>
@stop

@section('content')
<form action="/alquileres" method="POST">
    @csrf
    <div class="mb-3">
        <label for="" class="form-label">Nombre de la empresa de alquiler</label>
        <input id="nombreEmpresa" name="nombreEmpresa" type="text" value="{{old('nombreEmpresa')}}" maxLength="30" class="form-control" required>
        @if ($errors->has('nombreEmpresa'))
                <span class="error text-danger" for="input-nombreEmpresa">El Nombre de la empresa de alquiler ya está registrado anteriormente</span>
        @endif
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Localidad</label>
        <input id="localidad" name="localidad" type="text" value="{{old('localidad')}}" maxLength="30" class="form-control" required>
    </div>
    <a href="/alquileres" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@stop