@extends('adminlte::page')

@section('title', 'Secretaría - Crea Disponibilidad')

@section('content_header')
    <h1>Listado de Clientes - Secretaria Virtual</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending"
                                            style="width: 203.4px;">Cliente
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending"
                                            style="width: 262.6px;">N° Teléfono
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 233px;">Correo Electrónico
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending"
                                            style="width: 174.6px;">Dirección
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                            style="width: 123.6px;">Acción
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clientes as $listado)
                                        <tr>
                                            <td>{{ $listado->nombreCliente }}</td>
                                            <td>+56 9 {{ $listado->whatsappCliente }}</td>
                                            <td>{{ $listado->correoCliente }}</td>
                                            <td>{{ $listado->direccionCliente }}</td>
                                            <td>
                                                <center>
                                                    <form action="">
                                                        <button class="btn btn-success" type="submit"><i
                                                                class="fa fa-calendar-plus"></i> Agendar
                                                        </button>
                                                    </form>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

@stop

@section('css')
@stop
