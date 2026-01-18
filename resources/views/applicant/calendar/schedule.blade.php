@extends('layout.applicant.app')

@section('title', 'My Schedule')

@section('content')
    <div class="w-full min-h-screen p-4 md:p-6 bg-gradient-to-br from-gray-50 to-blue-50">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full shadow-lg">
                    <i class="fas fa-calendar-alt text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-white">My Visitation Schedule</h1>
                    <p class="text-blue-100 mt-1 text-sm">View and manage your scheduled appointments</p>
                </div>
            </div>
        </div>

        <!-- Legend Section -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-6 border border-blue-100">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">Schedule Legend</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                    <div class="w-4 h-4 rounded bg-blue-500"></div>
                    <span class="text-sm text-gray-700 font-medium">Scheduled</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                    <div class="w-4 h-4 rounded bg-green-500"></div>
                    <span class="text-sm text-gray-700 font-medium">Completed</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                    <div class="w-4 h-4 rounded bg-red-500"></div>
                    <span class="text-sm text-gray-700 font-medium">Cancelled</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                    <div class="w-4 h-4 rounded bg-amber-500"></div>
                    <span class="text-sm text-gray-700 font-medium">Pending</span>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600"></i>
                        </div>
                        <h2 class="text-xl font-bold text-blue-800">Calendar View</h2>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-mouse-pointer text-blue-500"></i> Click on events for details
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div id="calendar" class="bg-white rounded-lg"></div>
            </div>
        </div>
    </div>

    <style>
        /* FullCalendar Custom Styling */
        #calendar {
            font-family: inherit;
        }

        .fc-header-toolbar {
            margin-bottom: 1.5rem !important;
            padding: 1rem;
            background: linear-gradient(to right, #EFF6FF, #EEF2FF);
            border-radius: 0.75rem;
        }

        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #1E40AF !important;
        }

        .fc-button {
            background: linear-gradient(to right, #3B82F6, #6366F1) !important;
            border: none !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            text-transform: capitalize !important;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2) !important;
            transition: all 0.2s !important;
        }

        .fc-button:hover {
            background: linear-gradient(to right, #2563EB, #4F46E5) !important;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3) !important;
            transform: translateY(-1px);
        }

        .fc-button:active,
        .fc-button-active {
            background: linear-gradient(to right, #1D4ED8, #4338CA) !important;
        }

        .fc-button:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
        }

        .fc-daygrid-day-number {
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 0.5rem !important;
        }

        .fc-col-header-cell {
            background: linear-gradient(to right, #DBEAFE, #E0E7FF) !important;
            font-weight: 700 !important;
            color: #1E40AF !important;
            padding: 0.75rem !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .fc-daygrid-day:hover {
            background-color: #F0F9FF !important;
        }

        .fc-day-today {
            background-color: #FEF3C7 !important;
        }

        .fc-daygrid-day-frame {
            min-height: 100px;
        }

        .fc-event {
            cursor: pointer !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            padding: 4px 8px !important;
            margin: 2px !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.2s !important;
        }

        .fc-event:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
        }

        .fc-event-title {
            font-weight: 600 !important;
        }

        /* Make calendar responsive */
        @media (max-width: 768px) {
            .fc-toolbar-title {
                font-size: 1.25rem !important;
            }

            .fc-header-toolbar {
                flex-direction: column !important;
                gap: 0.5rem !important;
            }

            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                margin: 0.25rem 0;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                    list: 'List'
                },
                events: "{{ route('applicant.visitations.events') }}",
                eventDisplay: 'block',
                eventDidMount: function(info) {
                    // Apply custom background color from DB
                    if (info.event.extendedProps.color) {
                        info.el.style.backgroundColor = info.event.extendedProps.color;
                        info.el.style.borderColor = info.event.extendedProps.color;
                        info.el.style.color = "#fff";
                    }

                    // Add tooltip on hover
                    const tooltipText =
                        `${info.event.title}\n${info.event.start.toLocaleDateString()} at ${info.event.start.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}`;
                    info.el.setAttribute('title', tooltipText);
                },
                eventClick: function(info) {
                    const event = info.event;
                    const startDate = event.start.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    const startTime = event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Determine status badge color
                    let statusColor = '#6B7280';
                    const status = event.extendedProps.status?.toLowerCase() || '';
                    if (status.includes('scheduled') || status.includes('confirmed')) {
                        statusColor = '#3B82F6';
                    } else if (status.includes('completed')) {
                        statusColor = '#10B981';
                    } else if (status.includes('cancelled')) {
                        statusColor = '#EF4444';
                    } else if (status.includes('pending')) {
                        statusColor = '#F59E0B';
                    }

                    Swal.fire({
                        title: `<strong style="color: #1F2937;">${event.title}</strong>`,
                        html: `
                            <div style="text-align: left; padding: 1rem;">
                                <div style="margin-bottom: 1rem; padding: 0.75rem; background: #F3F4F6; border-radius: 0.5rem;">
                                    <p style="margin: 0.5rem 0; color: #374151;">
                                        <i class="fas fa-calendar" style="color: #3B82F6; width: 20px;"></i>
                                        <strong>Date:</strong> ${startDate}
                                    </p>
                                    <p style="margin: 0.5rem 0; color: #374151;">
                                        <i class="fas fa-clock" style="color: #3B82F6; width: 20px;"></i>
                                        <strong>Time:</strong> ${startTime}
                                    </p>
                                </div>
                                <div style="margin-bottom: 1rem; padding: 0.75rem; background: #F3F4F6; border-radius: 0.5rem;">
                                    <p style="margin: 0.5rem 0; color: #374151;">
                                        <i class="fas fa-info-circle" style="color: #3B82F6; width: 20px;"></i>
                                        <strong>Status:</strong> 
                                        <span style="background: ${statusColor}; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600;">
                                            ${event.extendedProps.status || 'N/A'}
                                        </span>
                                    </p>
                                </div>
                                ${event.extendedProps.remarks ? `
                                        <div style="padding: 0.75rem; background: #FEF3C7; border-left: 4px solid #F59E0B; border-radius: 0.5rem;">
                                            <p style="margin: 0; color: #92400E;">
                                                <i class="fas fa-sticky-note" style="color: #F59E0B; width: 20px;"></i>
                                                <strong>Remarks:</strong><br>
                                                <span style="margin-left: 28px; display: inline-block; margin-top: 0.25rem;">
                                                    ${event.extendedProps.remarks}
                                                </span>
                                            </p>
                                        </div>
                                    ` : ''}
                            </div>
                        `,
                        icon: null,
                        confirmButtonText: '<i class="fas fa-times mr-2"></i> Close',
                        confirmButtonColor: '#3B82F6',
                        customClass: {
                            popup: 'rounded-xl',
                            confirmButton: 'rounded-lg px-6 py-2'
                        },
                        width: '600px'
                    });
                },
                // Add loading state
                loading: function(isLoading) {
                    if (isLoading) {
                        document.getElementById('calendar').style.opacity = '0.5';
                    } else {
                        document.getElementById('calendar').style.opacity = '1';
                    }
                },
                // Enable date clicking for future features
                dateClick: function(info) {
                    // Could add "Schedule new appointment" functionality here
                    console.log('Clicked on: ' + info.dateStr);
                }
            });

            calendar.render();
        });
    </script>
@endsection
