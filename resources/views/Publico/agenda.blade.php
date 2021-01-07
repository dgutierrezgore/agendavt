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
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

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
                    <h4 class="my-0 fw-normal">{{ $cliente[0]->nombreCliente }}</h4>
                </div>
                <div class="card-body">

                    <form action="/Agenda/Publico/TomarHoraOnline" method="post">
                        @csrf
                        <input type="hidden" value="{{$cliente[0]->idCliente }}" name="idcliente">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="firstName" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombrecontacto" placeholder="" value=""
                                       required="">
                            </div>

                            <div class="col-md-4">
                                <label for="lastName" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="mailcontacto" placeholder="" value=""
                                       required="">
                            </div>

                            <div class="col-md-3">
                                <label for="username" class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text">+ 56 9</span>
                                    <input type="number" max="99999999" min="20000000" class="form-control"
                                           name="fonocontacto" placeholder="Máximo 8 Números"
                                           required="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">Disponibilidad</label>
                                <select class="form-select" name="dispo">
                                    <option value="">Elegir Hora de Atención...</option>
                                    @foreach($cliente as $listado)
                                        <option
                                            value="{{ $listado->idAgenda }}">{{ date('d-m-Y', strtotime($listado->fechaAgenda)) }}
                                            - {{ $listado->horaAgenda }} Hrs.
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-7">
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
</html>
