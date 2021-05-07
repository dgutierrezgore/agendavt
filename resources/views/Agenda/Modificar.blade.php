@extends('adminlte::page')

@section('title', 'Modificar Disponibilidad Horaria')

@section('content_header')
    <h1>Modificar Disponibilidad Horaria</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabla con Disponibilidad de Agenda</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="width: 200px">Fecha</th>
                            <th style="width: 200px">Hora</th>
                            <th>
                                <center>Agenda / Contacto</center>
                            </th>
                            <th>Información Adicional</th>
                            <th>
                                <center>Confirmación</center>
                            </th>
                            <th style="width: 200px">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($disponibilidad as $listado)
                            <tr>
                                <td>
                                    @if(date("N", strtotime($listado->fechaAgenda))==1)
                                        Lunes, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAgenda))==2)
                                        Martes, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAgenda))==3)
                                        Miércoles, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAgenda))==4)
                                        Jueves, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAgenda))==5)
                                        Viernes, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAgenda))==6)
                                        Sábado, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAgenda))==7)
                                        Domingo, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }}
                                    @endif
                                </td>
                                <td>{{ $listado->horaAgenda }}</td>
                                <td>
                                    @if($listado->estadoAgenda == 1)
                                        <center><small class="badge badge-success"><i class="fa fa-check"></i>
                                                DISPONIBLE</small></center>
                                    @elseif($listado->estadoAgenda == 2)
                                        <center><small class="badge badge-primary"><i class="fa fa-check"></i>
                                                HORA ASIGNADA A CONTACTO</small></center>
                                    @elseif($listado->estadoAgenda == 3)
                                        <center><small class="badge badge-warning"><i class="fa fa-check"></i>
                                                HORA ASIGNADA POR SISTEMA</small></center>
                                    @elseif($listado->estadoAgenda == 4)
                                        <center><small class="badge badge-danger"><i class="fa fa-check"></i>
                                                HORA NO DISPONIBLE</small></center>
                                    @endif
                                </td>
                                <td>{{ $listado->nombreContacto }} - +56 9 {{ $listado->celularContacto }}
                                    - {{ $listado->correoContacto }}</td>
                                <td>
                                    <center> @if($listado->confContacto == null)
                                            <button class="btn btn-xs btn-warning">SIN CONFIRMAR</button>
                                        @else
                                            <button class="btn btn-xs btn-success">CONFIRMADA</button>
                                        @endif
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        @if($listado->estadoAgenda == 1)
                                            <form action="/Agenda/Deshabilitar" method="POST">
                                                @csrf
                                                <input type="hidden" name="hatc" value="{{ $listado->idAgenda }}">
                                                <button class="btn btn-xs btn-danger" type="submit"><i
                                                        class="fa fa-calendar-minus"></i> DESHABILITAR ATENCIÓN
                                                </button>
                                            </form>
                                        @elseif($listado->estadoAgenda == 2)
                                            <form action="/Agenda/Cancelar" method="POST">
                                                @csrf
                                                <input type="hidden" name="hatc" value="{{ $listado->idAgenda }}">
                                                <button class="btn btn-xs btn-warning" type="submit"><i
                                                        class="fa fa-calendar-minus"></i> CANCELAR ATENCIÓN
                                                </button>
                                            </form>
                                        @elseif($listado->estadoAgenda == 3)
                                            <form action="/Agenda/Cancelar" method="POST">
                                                @csrf
                                                <input type="hidden" name="hatc" value="{{ $listado->idAgenda }}">
                                                <button class="btn btn-xs btn-warning" type="submit"><i
                                                        class="fa fa-calendar-minus"></i> CANCELAR ATENCIÓN
                                                </button>
                                            </form>
                                        @elseif($listado->estadoAgenda == 4)
                                            <form action="/Agenda/Habilitar" method="POST">
                                                @csrf
                                                <input type="hidden" name="hatc" value="{{ $listado->idAgenda }}">
                                                <button class="btn btn-xs btn-success" type="submit"><i
                                                        class="fa fa-calendar-plus"></i> HABILITAR ATENCIÓN
                                                </button>
                                            </form>
                                        @endif
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
          href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@stop
