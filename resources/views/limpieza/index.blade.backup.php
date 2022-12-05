@extends('adminlte::page')

@section('title', 'Retransmepa')

@section('content_header')
<h1>Listado de limpiezas</h1>
@stop

@section('content')
<a href="limpiezas/create" class="btn btn-primary mb-3">Añadir Limpieza</a>

<table id="limpiezas" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col">Nº Limpieza</th>
            <th scope="col">Nombre del cliente</th>
            <th scope="col">Matricula</th>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Tipo de lavado</th>
            <th scope="col">Tipo de coche</th>
            <th scope="col">Precio</th>
            <th scope="col">Fecha de limpieza</th>
            <th scope="col">Empleado Asignado</th>
            <th scope="col">Registrado por</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($limpiezas as $limpieza)
        <tr>
            <td>{{ $limpieza-> id }}</td>
            <td>{{ $limpieza-> nombreCliente }}</td>
            <td>{{ $limpieza-> matricula }}</td>
            <td>{{ $limpieza-> marca }}</td>
            <td>{{ $limpieza-> modelo }}</td>
            <td>{{ $limpieza-> tipoLavado }}</td>
            <td>{{ $limpieza-> tipoCoche }}</td>
            <td>{{ $limpieza-> precio }} €</td>
            <td>{{ $limpieza-> fechaLimpieza }}</td>
            <td>{{ $limpieza-> empleadoAsignado }}</td>
            <td>{{ $limpieza-> registrado_por }}</td>
            <td>
                <form action="{{ route ('limpiezas.destroy',$limpieza->id) }}" method="POST">
                    <a href="/limpiezas/{{ $limpieza-> id }}/edit" class="btn btn-info">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger functionDelete">Borrar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('css')
<!-- DataTables responsive con buttons-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.6/sb-1.3.3/sp-2.0.1/sl-1.4.0/sr-1.1.1/datatables.min.css" />
@stop

@section('js')
<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- DataTables responsive con buttons-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.6/sb-1.3.3/sp-2.0.1/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.functionDelete').click(function(event) {
            var form = $(this).closest("form");

            event.preventDefault();

            swal({
                title: "¿Estás seguro de que desea eliminar este registro?",
                text: "Si eliminas esto, desaparecerá para siempre.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancelar", "Si"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!'
            }).then((result) => {
                if (result) {
                    form.submit();
                    swal(
                        'Borrado',
                        'El registro ha sido borrado.',
                        'success'
                    )
                } else {
                    swal(
                        'Cancelado',
                        'El registro no ha sido borrado.',
                        'error'
                    )
                }
            });
        });

        $('#limpiezas').DataTable({
            "pageLength": 10,
            "info": false,
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "Todos"]
            ],
            "dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
            "responsive": true,
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 Registros",
                "infoFiltered": "(Filtrado de _MAX_ total registros)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "buttons": [{
                extend: 'collection',
                text: 'Colección',
                className: 'custom-html-collection',
                buttons: [{
                    // Botón para Excel
                    extend: 'excel',
                    text: 'Exportar a excel',
                    filename: 'RegistroLimpiezas'
                }, {
                    // Botón para Pdf
                    extend: 'pdf',
                    text: 'Exportar a pdf',
                    filename: 'RegistroLimpiezas'
                }, {
                    // Botón para imprimir
                    extend: 'print',
                    text: 'Imprimir'
                }, {
                    extend: 'colvis',
                    text: 'Columnas Visibles'
                }]
            }],
            "columnDefs": [{
                targets: [0,10],
                visible: false
            }]
        });
    });
</script>
@stop