@extends('adminlte::page')

@section('title', 'Agenda - Calendario')

@section('content_header')
    <h1>Agenda - Calendario</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div id='calendar'></div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link href='../lib/main.css' rel='stylesheet'/>
    <script src='../lib/main.js'></script>
    <script src='../lib/locales-all.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialDate: new Date(),
                navLinks: true,
                slotDuration: '00:15',
                locale: 'es',
                navLinks: true, // can click day/week names to navigate views
                selectable
        :
            true,
                selectMirror
        :
            false,
                select
        :

            function (arg) {

            }

        ,
            editable: true,
                dayMaxEvents
        :
            true, // allow "more" link when too many events
                events
        :
            [
                    @foreach($micalendario as $listado)
                {
                    title: '{{ $listado->nombreContacto }} - {{ $listado->tipoAtencion }} - +56 9 {{ $listado->celularContacto }} - {{ $listado->correoContacto }} // OBS: {{ $listado->obsContacto }}',
                    start: '{{ ($listado->fechaAtencion.'T'.$listado->horaAtencion) }}',
                    end: '{{ ($listado->fechaAtencion.'T'.$listado->horaFinAtencion) }}',
                },
                @endforeach
            ]
        })
            ;
            calendar.render();
        });

    </script>
@stop


