@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Disponibilidad Horaria</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="errors">
            <p><strong>Por favor corrige los siguientes errores<strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-edit"></i> Formulario de Creación</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="/Agenda/CrearDisponibilidad" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha Inicio:</label>
                            <input type="date" class="form-control" name="fecha_ini">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha Fin:</label>
                            <input type="date" class="form-control" name="fecha_fin">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Primera Hora de Atención:</label>
                            <input type="time" class="form-control" name="hora_ini" step="900" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Última Hora de Atención:</label>
                            <input type="time" class="form-control" name="hora_fin" step="900" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Bloques de Disponibilidad Cada:</label>
                            <input type="text" class="form-control" value="Cada {{ $cliente->tipoAgenda }} Minutos"
                                   readonly>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Crear Disponibilidad</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-calendar"></i>
                        Fechas Creadas
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @foreach($disponibilidad as $listado)
                        <ul>
                            <li><strong>FECHA: </strong>{{ $listado->fechaAgenda }} - <strong>Horas Disponibles para
                                    Atención:</strong> {{ $listado->horaAgenda }}
                            </li>
                        </ul>
                    @endforeach

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@stop

@section('css')
@stop
