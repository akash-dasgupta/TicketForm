<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketViewer extends Controller
{
    public function ticketlist()
    {
        $tickets = Ticket::all();
        if(request()->has('status')) {
            $status = request()->input('status');
            $tickets = Ticket::where('status', $status)->get();
        }
        if(request()->has('search') && request()->has('criteria')) {
            $search = request()->input('search');
            $criteria = request()->input('criteria');
            $tickets = Ticket::where($criteria, 'like', "%$search%")->get();
        }
        return view('ticketviewer', compact('tickets'));
    }

    public function viewticket($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if (!$ticket) {
            return redirect()->route('ticket.view')->with('error', 'Ticket not found.');
        }
        return view('ticket_detail', compact('ticket'));
    }
}