<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketViewer extends Controller
{
    public function ticketlist()
    {
        $tickets = Ticket::all();
        if(request()->has('search') && request()->has('criteria')){
            $search = request()->input('search');
            $criteria = request()->input('criteria');
            $tickets = Ticket::where($criteria, 'like', "%$search%")->get();
        }
        return view('ticketviewer', compact('tickets'));
    }
}