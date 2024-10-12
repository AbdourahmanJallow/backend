<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Appointment Request</title>
    </head>
    <body class="bg-neutral-200 p-8">
        <h1 class="font-bold">Appointment Request</h1>
        <p class="italic mt-5">
            Dear {{ $appointment["doctor"] }}, {{ $appointment["patient"] }} has
            requested an appointment with you on {{ $appointment["date"] }}.
        </p>
    </body>
</html>
