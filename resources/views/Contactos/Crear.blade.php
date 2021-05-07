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
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal"><i
                    class="fa fa-user"></i> Nuevo Contacto
            </button>
        </div>
        <br><br>
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header border-0">
                    <h3 class="card-title">Contactos Agendados</h3>
                    <div class="card-tools">

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
                                <td>{{ $listado->rutContacto }}</td>
                                <td>{{ $listado->nombreContacto }}</td>
                                <td>+56 9 {{ $listado->celularContacto }} // {{ $listado->correoContacto }}</td>
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
                                <td>{{ $listado->tipoAtencion }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form role="form" action="/Agenda/CrearContacto" method="POST" id="form_rut" name="form1">
                        <div id="form_rut2">

                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">RUT del Contacto:</label>
                                <input type="text" class="form-control" name="rut" id="idrut_emp"
                                       onfocusout="validaRut(document.form1.rut.value)" autocomplete="off" required>
                            </div>

                            <center>
                                <button type="button" class="btn btn-xs btn-warning" id="traeinfoext"><i
                                        class="fa fa-spinner"></i>
                                    Buscar contacto por RUT en Base de Datos
                                </button>
                            </center>
                            <hr>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre del Contacto:</label>
                                <input type="text" class="form-control" id="nombrec" name="nombrec" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefono del Contacto (No Incluir +56 9):</label>
                                <input type="number" class="form-control" maxlength="8" min="20000000" max="99999999"
                                       id="telefonoc" name="telefonoc" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Correo Electrónico Contacto:</label>
                                <input type="email" class="form-control" id="mailc" name="mailc" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hora de Atención, según disponibilidad:</label>
                                <select class="form-control" name="hatc" required>
                                    <option value="">Seleccione Horario</option>
                                    @foreach($dispo as $listado)
                                        <option value="{{ $listado->idAgenda }}">
                                            @if(date("N", strtotime($listado->fechaAgenda))==1)
                                                Lunes, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                            @if(date("N", strtotime($listado->fechaAgenda))==2)
                                                Martes, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                            @if(date("N", strtotime($listado->fechaAgenda))==3)
                                                Miércoles, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                            @if(date("N", strtotime($listado->fechaAgenda))==4)
                                                Jueves, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                            @if(date("N", strtotime($listado->fechaAgenda))==5)
                                                Viernes, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                            @if(date("N", strtotime($listado->fechaAgenda))==6)
                                                Sábado, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                            @if(date("N", strtotime($listado->fechaAgenda))==7)
                                                Domingo, {{ date("d-m-Y", strtotime($listado->fechaAgenda)) }} a
                                                las {{ ($listado->horaAgenda) }} hrs.
                                            @endif
                                        </option>
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
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-clock"></i> Registrar
                                Hora de Atención
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
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
        $('#traeinfoext').click(function () {
            if (($("#encontrado").val()) == 0) {
                return false;
            } else {
                var url = "TraerDatosRut";
                if ($("#idrut_emp").val() == "") {
                    $("#idrut_emp").css('border', '2px solid red');
                    $('#form_rut2').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-info\"></i> Alerta de Sistema!</h4>" +
                        "Campo RUT es Obligatorio.\n" +
                        "</div>");
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#form_rut").serialize(),
                    success: function (data) {
                        if (data == 2) {
                            $('#form_rut2').html("" +
                                "<div class=\"alert alert-warning alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-warning\"></i> Alerta de Sistema!</h4>" +
                                "No Encontrado en BD, se debe agregar ahora\n" +
                                "</div>").show();
                            $("#nombrec").val('');
                            $("#telefonoc").val('');
                            $("#mailc").val('');
                        } else {
                            $('#form_rut2').html("" +
                                "<div class=\"alert alert-success alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-warning\"></i> Mensaje de Sistema!</h4>" +
                                "Encontrado en BD\n" +
                                "</div>").show();
                            $("#nombrec").val(data[0].nombreContacto);
                            $("#telefonoc").val(data[0].celularContacto);
                            $("#mailc").val(data[0].correoContacto);
                        }
                    },
                    error: function (data) {
                        alert(data);
                        alert('ERROR');
                    }
                });
            }
        });
    </script>
@stop

@section('script')

@stop
