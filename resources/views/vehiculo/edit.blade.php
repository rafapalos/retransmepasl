@extends('adminlte::page')

@section('title', 'Retransmepa')

@section('content_header')
    <h2>Editar Vehiculos</h2>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
    <form action="/vehiculos/{{$vehiculo->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="" class="form-label">Marca</label>
            <input id="marca" name="marca" type="text" maxLength="15" pattern="[A-Za-z ]{1,15}" class="form-control" value="{{$vehiculo->marca}}" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Modelo</label>
            <input id="modelo" name="modelo" type="text" maxLength="15" pattern="[A-Za-z0-9]{1,15}" class="form-control" value="{{$vehiculo->modelo}}" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Matricula</label>
            <input id="matricula" name="matricula" type="text" maxLength="8" pattern="[0-9]{4}[-][A-Z]{3}" title="La matricula debe tener el siguiente formato '0000-XXX'" class="form-control" value="{{$vehiculo->matricula}}" readonly required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Empresa</label>
            <select class="form-control" id="empresa" name="empresa" required>
            <option value="">Seleccionar opción</option>
            @foreach ($delegacionesEdit as $delegacionesEdit)
            <option value="{{$delegacionesEdit->id}}-{{$delegacionesEdit->nombreEmpresa}}">{{$delegacionesEdit->nombreEmpresa}}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Estado</label>
            <select class="form-control" id="estado" name="estado"  required>
                <option class="optionValueEstado" value="{{$vehiculo->estado}}">{{$vehiculo->estado}}</option>
                <option class="optionActivo" value="Activo">Activo</option>
                <option class="optionParado" value="Parado">Parado</option>
                <option class="optionTaller" value="Taller">Taller</option>
                <option class="optionInactivo" value="Inactivo">Inactivo</option>
            </select>
        </div>
        <div class="mb-3" id="divPropiedad">
            <label for="" class="form-label">Propiedad</label>
            <select class="form-control" id="propiedad" name="propiedad" required>
                <option class="optionValuePropiedad" value="{{$vehiculo->propiedad}}">{{$vehiculo->propiedad}}</option>
                <option class="optionRetransmepa" value="Retransmepa">Retransmepa</option>
                <option class="optionAlquiler" value="Alquiler">Alquiler</option>
            </select>
        </div>
        <div class="mb-3" id="divAlquiler">
            <label for="" class="form-label">Alquiler</label>
            <select class="form-control" id="alquiler" name="alquiler">
                <option value="">Seleccionar opción</option>
                @foreach ($alquileresEdit as $alquileresEdit)
                <option value="{{$alquileresEdit->id}}-{{$alquileresEdit->nombreEmpresa}}">{{$alquileresEdit->nombreEmpresa}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" id="divFechaAlquilerDesde">
            <label for="" class="form-label">Fecha Desde Alquiler</label>
            <input id="fechaAlquilerDesde" name="fechaAlquilerDesde" type="date" class="form-control" min="2020-01-01" max="2050-01-01" value="{{$vehiculo->fechaAlquilerDesde}}">
        </div>
        <div class="mb-3" id="divFechaAlquilerHasta">
            <label for="" class="form-label">Fecha Hasta Alquiler</label>
            <input id="fechaAlquilerHasta" name="fechaAlquilerHasta" type="date" class="form-control" min="2020-01-01" max="2050-01-01" value="{{$vehiculo->fechaAlquilerHasta}}">
        </div>
        <a href="/vehiculos" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    // SELECT RESPONSIVE
    $(document).ready(function() {
        $('#empresa').select2({
            language: "es",
            theme: "classic",
            width: '100%'
        });

        $('#alquiler').select2({
            language: "es",
            theme: "classic",
            width: '100%'
        });

    });
    
    $('#divAlquiler, #divFechaAlquilerDesde, #divFechaAlquilerHasta').hide();

	// Propiedad
	$(document).off('change', '#propiedad').on('change', '#propiedad', function() {
        if ($("#propiedad").val() == "Retransmepa") {
            $('#divAlquiler, #divFechaAlquilerDesde, #divFechaAlquilerHasta').hide();
            $('#alquiler, #fechaAlquilerDesde, #fechaAlquilerHasta').removeAttr('required', true);
            $('#alquiler').val('Null');
            $('#fechaAlquilerDesde').val('Null');
            $('#fechaAlquilerHasta').val('Null');
        } else if ($("#propiedad").val() == "Alquiler") {
            $('#divAlquiler, #divFechaAlquilerDesde, #divFechaAlquilerHasta').show();
            $('#alquiler, #fechaAlquilerDesde, #fechaAlquilerHasta').attr('required', true);
        } else if ($("#propiedad").val() == "Null") {
            $('#divAlquiler, #divFechaAlquilerDesde, #divFechaAlquilerHasta').hide();
            $('#alquiler, #fechaAlquilerDesde, #fechaAlquilerHasta').removeAttr('required', true);
            $('#alquiler').val('');
            $('#fechaAlquilerDesde').val('');
            $('#fechaAlquilerHasta').val('');
        }
    });


    // SELECT ESTADO
    var optionEstado = $('.optionValueEstado').val();

    if (optionEstado == 'Activo') {
        $('.optionActivo').hide();
        $('.optionParado').show();
        $('.optionTaller').show();
        $('.optionInactivo').show();
    } else if (optionEstado == 'Parado') {
        $('.optionActivo').show();
        $('.optionParado').hide();
        $('.optionTaller').show();
        $('.optionInactivo').show();
    } else if (optionEstado == 'Taller') {
        $('.optionActivo').show();
        $('.optionParado').show();
        $('.optionTaller').hide();
        $('.optionInactivo').show();
    } else if (optionEstado == 'Inactivo') {
        $('.optionActivo').show();
        $('.optionParado').show();
        $('.optionTaller').show();
        $('.optionInactivo').hide();
    }

    // SELECT EMPRESA
    // var optionEmpresa = $('.optionValueEmpresa').val();

    // if (optionEmpresa == 'GLS') {
    //     $('.optionGLS').hide();
    //     $('.optionSEUR').show();
    //     $('.optionCorreosExpress').show();
    // } else if (optionEmpresa == 'SEUR') {
    //     $('.optionGLS').show();
    //     $('.optionSEUR').hide();
    //     $('.optionCorreosExpress').show();
    // } else if (optionEmpresa == 'CorreosExpress') {
    //     $('.optionGLS').show();
    //     $('.optionSEUR').show();
    //     $('.optionCorreosExpress').hide();
    // }

    // SELECT PROPIEDAD
    var optionPropiedad = $('.optionValuePropiedad').val();

    if (optionPropiedad == 'Retransmepa') {
        $('.optionRetransmepa').hide();
        $('.optionAlquiler').show();
    } else if (optionPropiedad == 'Alquiler') {
        $('.optionRetransmepa').show();
        $('.optionAlquiler').hide();
        $('#divAlquiler, #divFechaAlquilerDesde, #divFechaAlquilerHasta').show();
        $('#alquiler, #fechaAlquilerDesde, #fechaAlquilerHasta').attr('required', true);
    }

    // SELECT ALQUILER
    // var optionAlquiler = $('.optionValueAlquiler').val();

    // if (optionAlquiler == 'Northgate') {
    //     $('.optionNorthgate').hide();
    //     $('.optionPinveco').show();
    //     $('.optionEnterprise').show();
    //     $('.optionLogicar').show();
    // } else if (optionAlquiler == 'Pinveco') {
    //     $('.optionNorthgate').show();
    //     $('.optionPinveco').hide();
    //     $('.optionEnterprise').show();
    //     $('.optionLogicar').show();
    // } else if (optionAlquiler == 'Enterprise') {
    //     $('.optionNorthgate').show();
    //     $('.optionPinveco').show();
    //     $('.optionEnterprise').hide();
    //     $('.optionLogicar').show();
    // } else if (optionAlquiler == 'Logicar') {
    //     $('.optionNorthgate').show();
    //     $('.optionPinveco').show();
    //     $('.optionEnterprise').hide();
    //     $('.optionLogicar').hide();
    // }
    
    $("#fechaAlquilerDesde").bind("change keyup", function(event) {
        let fechaDesde = $('#fechaAlquilerDesde').val();

        let unixFechaDesde = new Date(fechaDesde).getTime() / 1000;

        if (unixFechaDesde >= 1640995200) {
            $('#fechaAlquilerHasta').removeAttr('readonly', true);
        }

        let dateMinValue = new Date(fechaDesde);
        let dateMinValueFormat = dateMinValue.toISOString()
        let dateMinSinFormat = dateMinValueFormat.slice("T", -13);
        let dateMinFormat = dateMinSinFormat.replace("T", "");

        document.getElementById("fechaAlquilerHasta").setAttribute("min", dateMinFormat);

    });

</script>
@stop