<!-- Navbar (include if it's in a partial or Blade component) -->
@include('layouts.app') <!-- Assuming your navbar is in a file called navbar.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Calendar</title>

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FullCalendar CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />

    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <!-- Custom CSS for basic styling -->
    <!-- Custom CSS for styling -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px; 
        }
        .content-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        #calendar {
    max-width: 60%; /* Set the maximum width to 80% of the container */
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transform: scale(0.9); /* Scale the calendar to 80% of its size */
    transform-origin: top center; /* Ensure the calendar scales from the top */
}


        .fc .fc-toolbar {
            background-color: #014a7f;
            color: white;
            border-radius: 8px;
            padding: 10px;
        }

        .fc-toolbar button {
            color: white;
            font-size: 1.1rem;
            border: none;
            padding: 8px 15px;
            background-color: #c02420;
            border-radius: 4px;
            cursor: pointer;
        }

        .fc-toolbar button:hover {
            background-color: #a01b17;
        }

        .fc-daygrid-day-number {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .fc-event {
            border-radius: 5px;
            padding: 5px;
            color: white;
        }

        .fc-event:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px;
            }

            h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .fc-toolbar {
                flex-direction: column;
                align-items: center;
            }

            .fc-toolbar button {
                margin: 5px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<body>
    

    <div class="content-container">
        <h1>Event Calendar</h1>
        <h3>Add/Edit Event</h3>
<form id="eventForm">
    @csrf
    <input type="hidden" id="eventId" name="eventId"> <!-- Hidden field for event ID -->
    
    <label for="eventTitle">Event Title:</label>
    <input type="text" id="eventTitle" name="eventTitle" required>

    <label for="eventDate">Event Date:</label>
    <input type="date" id="eventDate" name="eventDate" required>
    <div class="">
        <label for="offer_id">Select Intake</label>
        <select class="" id="intakeid" name="intakeid" required>
            <option value="" disabled selected>Select an intake</option>
            @foreach ($intakes as $intake)
                <option value="{{ $intake->id }}">{{ $intake->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit">Save Event</button>
</form>

<!-- Placeholder for displaying validation errors -->
<div id="errorMessages"></div>

        <div id="calendar"></div>
    </div>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>

    <!-- Calendar Script -->
    <!-- Modal Popup HTML -->
<!-- Modal Popup HTML -->
<div id="eventModal" class="modal">
    <div class="modal-content">
        <h3>Event Actions</h3>
        <button id="editButton">Edit Title</button>
        <button id="deleteButton">Delete Event</button>
        <button id="closeModal">Close</button>
    </div>
</div>

<style>
    /* Basic modal styling */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    /* Show modal when active */
    .show-modal {
        display: flex;
    }

    /* Modal content box */
    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 300px;
        text-align: center;
    }
</style>

<!-- FullCalendar Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var eventModal = document.getElementById('eventModal');
    var editButton = document.getElementById('editButton');
    var deleteButton = document.getElementById('deleteButton');
    var closeModal = document.getElementById('closeModal');

    var selectedEvent; // To store the clicked event

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: '/events',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventColor: '#378006',
        eventTextColor: '#fff',
        editable: true,

        eventDrop: function(info) {
            var event = info.event;
            var newDate = info.event.start;

            const formattedDate = FullCalendar.formatDate(newDate, {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });

            $.ajax({
                url: '/admin/events/update',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: event.id,
                    new_date: formattedDate
                },
                success: function(response) {
                    alert('Event date updated successfully!');
                },
                error: function(error) {
                    console.log(error);
                    info.revert();
                }
            });
        },

        eventClick: function(info) {
            selectedEvent = info.event; // Store the clicked event
            eventModal.classList.add('show-modal'); // Show the modal by adding the class
        }
    });

    // Handle Edit Button Click
    editButton.addEventListener('click', function() {
        var newTitle = prompt('Enter new title for the event:', selectedEvent.title);

        if (newTitle && newTitle.trim() !== "") {
            $.ajax({
                url: '/admin/events/update',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: selectedEvent.id,
                    new_title: newTitle
                },
                success: function(response) {
                    alert('Event title updated successfully!');
                    selectedEvent.setProp('title', newTitle);
                    eventModal.classList.remove('show-modal'); // Close modal
                },
                error: function(error) {
                    console.log(error);
                    alert('Could not update event title');
                }
            });
        } else {
            alert('Invalid title. No changes made.');
        }
    });

    // Handle Delete Button Click
    deleteButton.addEventListener('click', function() {
        if (confirm("Are you sure you want to delete this event?")) {
            $.ajax({
                url: '/admin/events/delete',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: selectedEvent.id
                },
                success: function(response) {
                    alert('Event deleted successfully!');
                    selectedEvent.remove();
                    eventModal.classList.remove('show-modal'); // Close modal
                },
                error: function(error) {
                    console.log(error);
                    alert('Could not delete event');
                }
            });
        }
    });

    // Handle Close Modal Button
    closeModal.addEventListener('click', function() {
        eventModal.classList.remove('show-modal'); // Hide the modal
    });

    calendar.render();
});
</script>


    {{-- <button id="sync-google">Sync from Google Calendar</button> --}}

    <script>
        $('#sync-google').click(function() {
            $.ajax({
                url: '/sync-from-google',  // The route that syncs from Google
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Events synced from Google Calendar successfully');
                    location.reload(); // Optionally reload the page or re-render the calendar
                },
                error: function(error) {
                    console.log(error);
                    alert('Error syncing events from Google Calendar');
                }
            });
        });
    </script>
    
    
    
    <script>
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting the traditional way
    
            const eventId = document.getElementById('eventId').value;
            const eventTitle = document.getElementById('eventTitle').value;
            const eventDate = document.getElementById('eventDate').value;
            const intakeid = document.getElementById('intakeid').value;
    
            $.ajax({
                url: eventId ? '/admin/events/update' : '/admin/events/store', // Update if eventId exists, otherwise store
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    id: eventId,
                    title: eventTitle,
                    date: eventDate,
                    intakeid: intakeid
                },
                success: function(response) {
                    alert('Event saved successfully!');
                    location.reload(); // Reload page to reflect changes on the calendar
                },
                error: function(error) {
                    console.log(error);
                    $('#errorMessages').html('Error saving event.');
                }
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                editable: true, // Enables dragging and dropping
                eventDrop: function(event, delta, revertFunc) {
                    const newDate = event.start.format();
    
                    // Send an AJAX request to update the event date
                    $.ajax({
                        url: '/admin/events/update-date',
                        method: 'POST',
                        data: {
                            _token: $('input[name="_token"]').val(),
                            id: event.id,
                            new_date: newDate
                        },
                        success: function(response) {
                            alert('Event updated successfully!');
                        },
                        error: function(error) {
                            console.log(error);
                            revertFunc(); // If error occurs, revert to old date
                        }
                    });
                }
            });
        });
    </script> --}}
    
    
</body>
</html>
