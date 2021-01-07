@extends('adminlte::page')

@section('title', 'Registro de Contacto')

@section('content_header')
    <h1>Registro de Cliente/Paciente Según disponibilidad Horaria</h1>
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
                    <h3 class="card-title"><i class="fa fa-edit"></i> Formulario de Atención - Agenda / Contacto</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="/Agenda/CrearContacto" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre del Contacto:</label>
                            <input type="text" class="form-control" name="nombrec" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Telefono del Contacto (No Incluir +56 9):</label>
                            <input type="number" class="form-control" maxlength="8" min="20000000" max="99999999"
                                   name="telefonoc" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Correo Electrónico Contacto:</label>
                            <input type="email" class="form-control" name="mailc" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Hora de Atención, según disponibilidad:</label>
                            <select class="form-control" name="hatc" required>
                                <option value="">Seleccione Horario</option>
                                @foreach($dispo as $listado)
                                    <option value="{{ $listado->idAgenda }}">{{ $listado->fechaAgenda }}
                                        - {{ $listado->horaAgenda }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Tipo de Atención:</label>
                            <select class="form-control" name="tat" required>
                                <option value="Atención General">Atención General</option>
                                <option value="Primera Atención">Primera Atención</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Observación:</label>
                            <input type="text" class="form-control" name="obsc">
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Registrar Hora</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header border-0">
                    <h3 class="card-title">Contactos Agendados</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>Nombre Contacto</th>
                            <th>Datos de Contacto</th>
                            <th>Fecha / Hora</th>
                            <th>Atención</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contactos as $listado)
                            <tr>
                                <td>{{ $listado->nombreContacto }}</td>
                                <td>+56 9 {{ $listado->celularContacto }} // {{ $listado->correoContacto }}</td>
                                <td>{{ $listado->fechaAtencion }} {{ $listado->horaAtencion }}</td>
                                <td>{{ $listado->tipoAtencion }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@stop

@section('css')
@stop
