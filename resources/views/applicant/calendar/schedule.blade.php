@extends('layout.applicant.app')

@section('title', 'Schedule')

@section('content')
    <h1>Your Schedule</h1>
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            })
            calendar.render()
        })
    </script>

@endsection
