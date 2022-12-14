@extends('adminlte::page')

@section('title', 'Retransmepa')

@section('content_header')
    <h2>Editar Incidencia</h2>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
    <form action="/incidencias/{{$incidencia->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="" class="form-label">Sector</label>
            <select class="form-control" id="sector" name="sector">
                <option class="optionSectorValue" value="{{$incidencia->sector}}">{{$incidencia->sector}}</option>
                <option class="optionSectorTransporte" value="Transporte">Transporte</option>
                <option class="optionSectorLavadero" value="Lavadero">Lavadero</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nombre de Empleado</label>
            <select class="form-control" id="nombreEmpleado" name="nombreEmpleado" required>
                <option value="">Seleccionar opción</option>
                @foreach ($empleadosIncidenciasTransporte as $empleadosIncidenciasTransporte)
                <option class="optionTransporte" value="{{$empleadosIncidenciasTransporte->id}}-{{$empleadosIncidenciasTransporte->nombre}} {{$empleadosIncidenciasTransporte->apellidos}}">{{$empleadosIncidenciasTransporte->nombre}} {{$empleadosIncidenciasTransporte->apellidos}}</option>
                @endforeach
                @foreach ($empleadosIncidenciasLavadero as $empleadosIncidenciasLavadero)
                <option class="optionLavadero" value="{{$empleadosIncidenciasLavadero->id}}-{{$empleadosIncidenciasLavadero->nombre}} {{$empleadosIncidenciasLavadero->apellidos}}">{{$empleadosIncidenciasLavadero->nombre}} {{$empleadosIncidenciasLavadero->apellidos}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Descripción</label>
            <input id="descripcion" name="descripcion" type="text" class="form-control" value="{{$incidencia->descripcion}}">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option class="optionValueEstado" value="{{$incidencia->estado}}">{{$incidencia->estado}}</option>
                <option class="optionPendiente" value="Pendiente">Pendiente</option>
                <option class="optionSolucionado" value="Solucionado">Solucionado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Sanción</label>
            <input id="sancion" name="sancion" type="number" min="0" max="10000" class="form-control" value="{{$incidencia->sancion}}">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Fecha</label>
            <input id="fecha" name="fecha" type="date" class="form-control" min="2022-01-01" max="2050-01-01" value="{{$incidencia->fecha}}">
        </div>
        <a href="/incidencias" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // $('.optionLavadero').hide();
    $(document).ready(function() {
        $('#nombreEmpleado').select2({
            language: "es",
            theme: "classic",
            width: '100%'
        });

        let Actual = new Date();
        let mesActual = Actual.getMonth();
        let anioActual = Actual.getFullYear();
        let ultimoDia = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate();
        let min = anioActual+'-'+mesActual+'-'+'01';
        let max = anioActual+'-'+mesActual+'-'+ultimoDia;

        $("#fecha").attr("min", min);
        $("#fecha").attr("max", max);
    });

    $("#sector").bind("change keyup", function(event){
        var sector = $('#sector').val();

        if (sector == 'Transporte') {
            $('#nombreEmpleado').val('');
            $('.optionLavadero').hide();
            $('.optionTransporte').show();
        } else if (sector == 'Lavadero') {
            $('#nombreEmpleado').val('');
            $('.optionLavadero').show();
            $('.optionTransporte').hide();
        }
    });

    // Option Sectores
    var optionSector = $('.optionSectorValue').val();

    if (optionSector == 'Transporte') {
        $('.optionSectorLavadero').show();
        $('.optionSectorTransporte').hide();
        $('.optionLavadero').hide();
    } else if (optionSector == 'Lavadero') {
        $('.optionSectorTransporte').show();
        $('.optionSectorLavadero').hide();
        $('.optionTransporte').hide();
    }

    // SELECT DE ESTADO
    var optionEstado = $('.optionValueEstado').val();

    if (optionEstado == 'Pendiente') {
        $('.optionSolucionado').show();
        $('.optionPendiente').hide();
    } else if (optionEstado == 'Solucionado') {
        $('.optionSolucionado').hide();
        $('.optionPendiente').show();
    }
</script>
@stop