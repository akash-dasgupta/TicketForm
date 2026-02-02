<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
  </head>
    <body class="flex flex-col items-center justify-center min-h-screen">
<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <h1 class="text-3xl text-center font-bold underline centered m-4">Ticket #{{ $ticket->id }}</h1>
    <div class="card border border-gray-400 p-4 m-4">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $ticket->name }}</p>
            <p><strong>Email:</strong> {{ $ticket->email }}</p>
            <p><strong>Phone:</strong> {{ $ticket->phone }}</p>
            <p><strong>Message:</strong> {{ $ticket->message }}</p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
            <p><strong>Created At:</strong> {{ $ticket->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $ticket->updated_at }}</p>
        </div>
</div>
</body>
</html>
