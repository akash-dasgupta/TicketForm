<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <center><h1>Raised Tickets</h1></center>
    <table>
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Attachment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr>
                <td>{{ $ticket->ticket_id }}</td>
                <td>{{ $ticket->name }}</td>
                <td>{{ $ticket->email }}</td>
                <td>{{ $ticket->phone }}</td>
                <td>{{ $ticket->message }}</td>
                <td>{{ $ticket->attachment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
