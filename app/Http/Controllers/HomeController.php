<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->middleware('auth');
        $this->ticket = $ticket;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $openedTickets = $this->ticket->latest()->orderBy('priority', 'DESC')->paginate(9);
        
        return view('home', [
            'tickets' => $openedTickets
        ]);
    }
}
