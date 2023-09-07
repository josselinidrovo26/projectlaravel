    <link href="{{ asset('fullcalendar/main.css') }}" rel="stylesheet">
    <script src="{{ asset('fullcalendar/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/locales/es.js') }}"></script>

                @extends('layouts.app')
                @section('content')
                    <section class="section">
                        <div class="section-header">
                            <h3 class="page__heading">Calendario</h3>
                        </div>
                        <div class="section-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endsection

                @section('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var calendarEl = document.getElementById('calendar');

                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'dayGrid', 'timeGrid', 'list' ],
                    defaultView: 'dayGridMonth',

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },

                    eventTimeFormat: {
                        hour: 'numeric',
                        minute: '2-digit',
                        meridiem: 'short'
                    },

                    events: [
                    ],

                    eventClick: function(info) {
                    },

                    eventDragStop: function(info) {
                    },

                    eventResize: function(info) {
                    },

                    select: function(info) {
                    },


                });




                plugins: [ 'dayGrid', 'timeGrid', 'list' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: [
                ]
            });

            calendar.render();
        });
    </script>
@endsection
