@extends('layout.applicant.app')

@section('title', 'My Schedule')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">📅 My Visitation Schedule</h1>
        <p class="text-gray-500 mb-6">Here you can view your scheduled, completed, or cancelled visitations.</p>

        <div id="calendar" class="bg-white rounded shadow-md p-3"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5', // cleaner theme if bootstrap loaded
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },
                events: "{{ route('applicant.visitations.events') }}",
                eventDisplay: 'block',
                eventDidMount: function(info) {
                    // Apply custom background color from DB
                    if (info.event.extendedProps.color) {
                        info.el.style.backgroundColor = info.event.extendedProps.color;
                        info.el.style.borderColor = info.event.extendedProps.color;
                        info.el.style.color = "#fff";
                        info.el.style.borderRadius = "6px";
                        info.el.style.padding = "2px 4px";
                    }
                },
                eventClick: function(info) {
                    const event = info.event;
                    const startDate = event.start.toLocaleDateString();
                    const startTime = event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    Swal.fire({
                        title: `<strong>${event.title}</strong>`,
                        html: `
                            <p><b>Date:</b> ${startDate}</p>
                            <p><b>Time:</b> ${startTime}</p>
                            <p><b>Status:</b> ${event.extendedProps.status ?? 'N/A'}</p>
                            <p><b>Remarks:</b> ${event.extendedProps.remarks ?? '—'}</p>
                        `,
                        icon: "info",
                        confirmButtonText: "Close",
                        customClass: {
                            popup: 'rounded-xl'
                        }
                    });
                }
            });

            calendar.render();
        });
    </script>
@endsection
