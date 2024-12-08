 <!-- Navbar (include if it's in a partial or Blade component) -->
 @include('layouts.app') <!-- Assuming your navbar is in a file called navbar.blade.php -->

<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Calendar</title>

    <!-- FullCalendar CSS v5 -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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
   
    <div class="content-container">
        <h1>Event Calendar</h1>
        <div id="calendar"></div>
    </div>

    <!-- FullCalendar JS v5 -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>

    <!-- Calendar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/events1',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventColor: '#014a7f', // event color adjusted to match the theme
                eventTextColor: '#fff',
                editable: false,
            });

            calendar.render();
        });
    </script>
</body>
</html>
