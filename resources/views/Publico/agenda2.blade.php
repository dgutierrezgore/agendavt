<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Toma de Hora - Agenda VTCALL Sys.</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/pricing/">


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">
</head>
<body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal">Agenda Electrónica VirtualCALL</p>
    <nav class="my-2 my-md-0 me-md-3">

    </nav>
</header>

<main class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-6">Reserva Hora de Atención</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-1 mb-1 text-center">
        <div class="col">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 fw-normal">con: {{ $cliente[0]->nombreCliente }}</h4>
                </div>
                <div class="card-body">

                    <form action="/Agenda/Publico/TomarHoraOnline" method="post">
                        @csrf
                        <input type="hidden" value="{{$cliente[0]->idCliente }}" name="idcliente">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="firstName" class="form-label">R.U.N.</label>
                                <input type="text" class="form-control" name="runcontacto" placeholder=""
                                       value="{{ $run }}"
                                       readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="firstName" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombrecontacto" placeholder=""
                                       value="{{ $contacto->nombreContacto }}"
                                       required="">
                            </div>

                            <div class="col-md-4">
                                <label for="lastName" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="mailcontacto" placeholder=""
                                       value="{{ $contacto->correoContacto }}"
                                       required="">
                            </div>

                            <div class="col-md-3">
                                <label for="username" class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text">+ 56 9</span>
                                    <input type="number" max="99999999" min="20000000" maxlength="8"
                                           class="form-control"
                                           name="fonocontacto" placeholder="Máximo 8 Números"
                                           value="{{ $contacto->celularContacto }}"
                                           required="">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="state" class="form-label">Disponibilidad de Día</label>
                                <select class="form-select" id="dispo_dia" name="dispo" required>
                                    <option value="">Elegir día de Atención...</option>
                                    @foreach($dispo as $listado)
                                        <option
                                            value="{{ $listado->fechaunica }}">
                                            @if(date("N", strtotime($listado->fechaAgenda))==1)
                                                Lunes,
                                            @elseif(date("N", strtotime($listado->fechaAgenda))==2)
                                                Martes,
                                            @elseif(date("N", strtotime($listado->fechaAgenda))==3)
                                                Miércoles,
                                            @elseif(date("N", strtotime($listado->fechaAgenda))==4)
                                                Jueves,
                                            @elseif(date("N", strtotime($listado->fechaAgenda))==5)
                                                Viernes,
                                            @elseif(date("N", strtotime($listado->fechaAgenda))==6)
                                                Sábado,
                                            @elseif(date("N", strtotime($listado->fechaAgenda))==7)
                                                Domingo,
                                            @endif
                                            {{ date('d-m-Y', strtotime($listado->fechaAgenda)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="state" class="form-label">Disponibilidad de Hora</label>
                                <select class="form-select" id="dispo_hora" name="dispo_hora" required>
                                    <option value="">Elegir hora de Atención...</option>
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label for="state" class="form-label">Observaciones</label>
                                <input type="text" class="form-control" name="obs" placeholder="" value=""
                                       required="">
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Reservar Hora de
                            Atención
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-1 mb-1 text-center">
        <div class="col">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 fw-normal">Mis Solicitudes de Atención</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 300px">Fecha / Hora</th>
                            <th>Hora de atención tomada con:</th>
                            <th>Estado</th>
                            <th style="width: 350px">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($horas as $listado)
                            <tr>
                                <td>
                                    @if(date("N", strtotime($listado->fechaAtencion))==1)
                                        Lunes, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAtencion))==2)
                                        Martes, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAtencion))==3)
                                        Miércoles, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAtencion))==4)
                                        Jueves, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAtencion))==5)
                                        Viernes, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAtencion))==6)
                                        Sábado, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                    @if(date("N", strtotime($listado->fechaAtencion))==7)
                                        Domingo, {{ date("d-m-Y", strtotime($listado->fechaAtencion)) }} a
                                        las {{ ($listado->horaAtencion) }} hrs.
                                    @endif
                                </td>
                                <td>{{ $listado->nombreCliente }} </td>
                                <td>
                                    @if($listado->confContacto ==null)
                                        <button class="btn btn-sm btn-warning">Sin Confirmar</button>
                                    @else
                                        <button class="btn btn-sm btn-success">Confirmado</button>
                                    @endif
                                </td>
                                <td>
                                    @if($listado->confContacto==null)
                                        <button class="btn btn-sm btn-success"> Confirmar Hora</button>
                                    @else
                                    @endif
                                    <button class="btn btn-sm btn-warning"> Cancelar Hora</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <footer class="pt-2 my-md-4 pt-md-4 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="http://virtualcall.cl/img/logovt.png" alt="" height="30">
                <small class="d-block mb-3 text-muted">&copy; {{ date('Y') }}. Virtual CALL Sys.</small>
            </div>
        </div>
    </footer>
</main>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script>
    $('#dispo_dia').on('change', function () {

        // Guardamos el select de cursos
        var cursos = $("#dispo_hora");
        // Guardamos el select de alumnos
        var alumnos = $(this);

        if ($(this).val() != '') {
            $.ajax({
                data: {
                    "id": alumnos.val(),
                    "_token": "{{ csrf_token() }}",
                },
                url: 'TraeDisponibilidadDia',
                type: 'POST',
                dataType: 'json',

                beforeSend: function () {
                    alumnos.prop('disabled', true);
                },
                success: function (r) {
                    alumnos.prop('disabled', false);

                    // Limpiamos el select
                    cursos.find('option').remove();

                    $(r).each(function (i, v) { // indice, valor
                        cursos.append('<option value="' + v.idAgenda + '">' + v.horaAgenda + ' Horas</option>');
                    })

                    cursos.prop('disabled', false);
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    alumnos.prop('disabled', false);
                }
            });
        } else {
            cursos.find('option').remove();
            cursos.prop('disabled', true);
        }

    });

</script>
</html>
