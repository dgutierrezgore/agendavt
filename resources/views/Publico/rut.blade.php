<!doctype html>
<html lang="es">
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

                    <form action="/Agenda/Publico/AvanzarFase2" method="post" id="form_rut" name="form1">
                        @csrf
                        <input type="hidden" value="{{$cliente[0]->codpubCliente }}" name="idcliente">

                        <div class="row g-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label for="firstName" class="form-label"><strong>R.U.N. Paciente /
                                        Cliente</strong></label>
                                <input type="text" class="form-control" name="rut" id="idrut_emp"
                                       onfocusout="validaRut(document.form1.rut.value)" autocomplete="off" required>
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
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script type="text/javascript">
    function validaRut(varrut) {
        if (Rut(varrut)) {
            document.form1.submit();
        }
    }

    function revisarDigito(dvr) {
        dv = dvr + ""
        if (dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k' && dv != 'K') {
            alert("Debe ingresar un digito verificador valido");
            window.document.form1.rut.focus();
            window.document.form1.rut.select();
            return false;
        }
        return true;
    }

    function revisarDigito2(crut) {
        largo = crut.length;
        if (largo < 2) {
            alert("Debe ingresar el rut completo 2")
            window.document.form1.rut.focus();
            window.document.form1.rut.select();
            return false;
        }
        if (largo > 2)
            rut = crut.substring(0, largo - 1);
        else
            rut = crut.charAt(0);
        dv = crut.charAt(largo - 1);
        revisarDigito(dv);
        if (rut == null || dv == null)
            return 0
        var dvr = '0'
        suma = 0
        mul = 2
        for (i = rut.length - 1; i >= 0; i--) {
            suma = suma + rut.charAt(i) * mul
            if (mul == 7)
                mul = 2
            else
                mul++
        }
        res = suma % 11
        if (res == 1)
            dvr = 'k'
        else if (res == 0)
            dvr = '0'
        else {
            dvi = 11 - res
            dvr = dvi + ""
        }
        if (dvr != dv.toLowerCase()) {
            $("#idrut_emp").css('border', '2px solid red');
            $('#idrut_emp').val("");
            windows.document.form1.rut.value('');
            return false
        }
        return true
    }

    function Rut(texto) {
        var tmpstr = "";
        for (i = 0; i < texto.length; i++)
            if (texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-')
                tmpstr = tmpstr + texto.charAt(i);
        texto = tmpstr;
        largo = texto.length;
        if (largo < 2) {
            $("#idrut_emp").css('border', '2px solid red');
            $('#idrut_emp').val("");
            windows.document.form1.rut.value('');
            return false
        }
        for (i = 0; i < largo; i++) {
            if (texto.charAt(i) != "0" && texto.charAt(i) != "1" && texto.charAt(i) != "2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) != "5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) != "8" && texto.charAt(i) != "9" && texto.charAt(i) != "k" && texto.charAt(i) != "K") {
                $("#idrut_emp").css('border', '2px solid red');
                $('#idrut_emp').val("");
                windows.document.form1.rut.value('');
                return false
            }
        }
        var invertido = "";
        for (i = (largo - 1), j = 0; i >= 0; i--, j++)
            invertido = invertido + texto.charAt(i);
        var dtexto = "";
        dtexto = dtexto + invertido.charAt(0);
        dtexto = dtexto + '-';
        cnt = 0;
        for (i = 1, j = 2; i < largo; i++, j++) {
            //alert("i=[" + i + "] j=[" + j +"]" );
            if (cnt == 3) {
                dtexto = dtexto + '.';
                j++;
                dtexto = dtexto + invertido.charAt(i);
                cnt = 1;
            } else {
                dtexto = dtexto + invertido.charAt(i);
                cnt++;
            }
        }
        invertido = "";
        for (i = (dtexto.length - 1), j = 0; i >= 0; i--, j++)
            invertido = invertido + dtexto.charAt(i);
        window.document.form1.rut.value = invertido.toUpperCase()
        if (revisarDigito2(texto))
            $("#idrut_emp").css('border', '2px solid green');
        return false;
    }
</script>
<script>
    $("#form_rut").keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });
</script>
</body>
</html>
