<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
  </head>
    <body class="flex flex-col items-center justify-center min-h-screen">
<!-- The best way to predict the future is to invent it. - Alan Kay -->
      

<!-- Ticket Table -->
<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <nav>
        <ul class="flex space-x-4 justify-end m-4">
            <li>
                @auth
                    <span class="border-r-2 pr-2">
                        Welcome, {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('staff.logout') }}" class="inline">
                        @csrf
                    <button type="submit" class="text-black rounded hover:bg-red-600 hover:text-white cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                        Logout
                    </button>
                    </form>
                @endauth
            </li>
        </ul>
    </nav>
    <h1 class="text-3xl text-center font-bold underline centered m-4">Raised Tickets</h1>
      <div class="card">
            <div class="card-header">
                <h4 class="text-xl font-semibold mb-2">
                    Search Tickets
                </h4>
            </div>
            <div class="card-body">
                <div class="mb-4 flex justify-center gap-4">
                    <a href="{{ route('ticket.view') }}?status=OPEN" class="bg-green-600 text-white rounded hover:bg-green-700 cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                        Open Tickets
                    </a>
                    <a href="{{ route('ticket.view') }}?status=CLOSED" class="bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline">
                        Closed Tickets
                    </a>
                </div>
                <form action="{{ route('ticket.view') }}" method="GET" class="form-inline">
                    <div class="form-group mb-2 grid grid-cols-6 gap-2">
                        <select name="criteria" id="criteria" class="border border-gray-300 rounded px-2 py-1 col-span-1">
                            <option value="ticket_id">Ticket ID</option>
                            <option value="name">Name</option>
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                            <option value="message">Message</option>
                            <option value="status">Status</option>
                        </select>
                        <input type="text" id="search" name="search" class="border border-gray-300 rounded px-2 py-1 col-span-4">
                        <button type="submit" class="bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer col-span-1">Search</button>
                        <script>
                        var form = document.getElementByTagName("search");
                        form.reset();
                        </script>
                    </div>
                </form>
            </div>
        </div>
    <table class="table-auto text-center border-collapse border border-gray-400 border-spacing-2 p-4">
        <thead>
            <tr>
                <th class="center border border-gray-400 p-2">Ticket ID</th>
                <th class="center border border-gray-400 p-2">Name</th>
                <th class="border border-gray-400 p-2">Email</th>
                <th class="border border-gray-400 p-2">Phone</th>
                <th class="border border-gray-400 p-2">Message</th>
                <th class="border border-gray-400 p-2">Status</th>
                <th class="border border-gray-400 p-2">Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $tickets)
            <tr>
                <td class="border border-gray-400 p-2">
                    <a href="{{ route('ticket.view.single', ['ticket_id' => $tickets->ticket_id]) }}">
                        <div class="text-blue-600 hover:underline">
                            {{ $tickets->ticket_id }}
                        </div>
                    </a>
                </td>
                <td class="border border-gray-400 p-2">{{ $tickets->name }}</td>
                <td class="border border-gray-400 p-2">{{ $tickets->email }}</td>
                <td class="border border-gray-400 p-2">{{ $tickets->phone }}</td>
                <td class="border border-gray-400 p-2">{{ $tickets->message }}</td>
                <td class="border border-gray-400 p-2">{{ $tickets->status }}</td>
                <td class="border border-gray-400 p-2">{{ $tickets->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
</body>
</html>