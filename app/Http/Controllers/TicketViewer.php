<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketViewer extends Controller
{
    public function ticketlist()
    {
        $tickets = Ticket::all();
        return view('ticketviewer', compact('tickets'));
    }
}