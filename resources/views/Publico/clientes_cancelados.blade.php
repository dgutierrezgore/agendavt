<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Hora agendada con éxito - Agenda VTCALL Sys.</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/pricing/">


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

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
        <h1 class="display-6">Cancelación Hora de Atención</h1>
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
                    <h4 class="my-0 fw-normal">Hora cancelada con éxito.</h4>
                </div>
                <div class="card-body">
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
