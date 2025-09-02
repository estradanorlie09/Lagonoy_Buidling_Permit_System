@extends('layout.applicant.app')

@section('title', 'Schedule')

@section('content')
    <h1>Your Schedule</h1>
    <div id='calendar' class="bg-white shadow p-5 rounded"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [{
                        title: 'Meeting with John',
                        start: '2025-09-05T10:30:00',
                        end: '2025-09-05T12:30:00'
                    },
                    {
                        title: 'Lunch Break',
                        start: '2025-09-07T12:00:00'
                    },
                    {
                        title: 'Project Deadline',
                        start: '2025-09-12'
                    },
                    {
                        title: 'Conference',
                        start: '2025-09-20',
                        end: '2025-09-22'
                    }
                ]
            });

            calendar.render();
        });
    </script>


@endsection
